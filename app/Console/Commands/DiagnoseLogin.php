<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DiagnoseLogin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'diagnose:login';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Diagnose common login issues in production';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Diagnosing Login Issues...');
        $this->newLine();

        $issues = [];
        $warnings = [];

        // Check environment
        $this->checkEnvironment($issues, $warnings);
        
        // Check session configuration
        $this->checkSessionConfig($issues, $warnings);
        
        // Check database
        $this->checkDatabase($issues, $warnings);
        
        // Check file permissions
        $this->checkFilePermissions($issues, $warnings);

        // Display results
        $this->displayResults($issues, $warnings);

        return empty($issues) ? Command::SUCCESS : Command::FAILURE;
    }

    private function checkEnvironment(&$issues, &$warnings)
    {
        $this->info('📋 Environment Configuration:');
        
        $env = config('app.env');
        $debug = config('app.debug');
        $url = config('app.url');
        
        $this->line("   APP_ENV: {$env}");
        $this->line("   APP_DEBUG: " . ($debug ? 'true' : 'false'));
        $this->line("   APP_URL: {$url}");
        
        if ($env === 'production' && $debug) {
            $issues[] = 'APP_DEBUG should be false in production';
        }
        
        if (str_starts_with($url, 'http://localhost')) {
            $warnings[] = 'APP_URL appears to be set for local development';
        }
        
        $this->newLine();
    }

    private function checkSessionConfig(&$issues, &$warnings)
    {
        $this->info('🍪 Session Configuration:');
        
        $driver = config('session.driver');
        $domain = config('session.domain');
        $secure = config('session.secure');
        $httpOnly = config('session.http_only');
        $sameSite = config('session.same_site');
        
        $this->line("   SESSION_DRIVER: {$driver}");
        $this->line("   SESSION_DOMAIN: " . ($domain ?: 'null'));
        $this->line("   SESSION_SECURE: " . ($secure ? 'true' : 'false'));
        $this->line("   SESSION_HTTP_ONLY: " . ($httpOnly ? 'true' : 'false'));
        $this->line("   SESSION_SAME_SITE: {$sameSite}");
        
        if ($driver === 'file' && config('app.env') === 'production') {
            $warnings[] = 'Consider using database sessions for production';
        }
        
        if (config('app.env') === 'production' && !$secure && str_starts_with(config('app.url'), 'https://')) {
            $issues[] = 'SESSION_SECURE should be true for HTTPS sites';
        }
        
        $this->newLine();
    }

    private function checkDatabase(&$issues, &$warnings)
    {
        $this->info('🗄️ Database Configuration:');
        
        try {
            DB::connection()->getPdo();
            $this->line('   ✅ Database connection: OK');
            
            // Check sessions table if using database driver
            if (config('session.driver') === 'database') {
                if (Schema::hasTable('sessions')) {
                    $sessionCount = DB::table('sessions')->count();
                    $this->line("   ✅ Sessions table exists ({$sessionCount} sessions)");
                } else {
                    $issues[] = 'Sessions table missing (run: php artisan session:table && php artisan migrate)';
                }
            }
            
            // Check users table
            if (Schema::hasTable('users')) {
                $userCount = DB::table('users')->count();
                $this->line("   ✅ Users table exists ({$userCount} users)");
            } else {
                $issues[] = 'Users table missing';
            }
            
        } catch (\Exception $e) {
            $issues[] = 'Database connection failed: ' . $e->getMessage();
        }
        
        $this->newLine();
    }

    private function checkFilePermissions(&$issues, &$warnings)
    {
        $this->info('🔒 File Permissions:');
        
        $paths = [
            'storage' => storage_path(),
            'bootstrap/cache' => base_path('bootstrap/cache'),
        ];
        
        foreach ($paths as $name => $path) {
            if (is_writable($path)) {
                $this->line("   ✅ {$name}: Writable");
            } else {
                $issues[] = "{$name} directory is not writable: {$path}";
            }
        }
        
        $this->newLine();
    }

    private function displayResults($issues, $warnings)
    {
        if (!empty($issues)) {
            $this->error('❌ Critical Issues Found:');
            foreach ($issues as $issue) {
                $this->line("   • {$issue}");
            }
            $this->newLine();
        }
        
        if (!empty($warnings)) {
            $this->warn('⚠️ Warnings:');
            foreach ($warnings as $warning) {
                $this->line("   • {$warning}");
            }
            $this->newLine();
        }
        
        if (empty($issues) && empty($warnings)) {
            $this->info('✅ No issues detected with login configuration!');
        } else {
            $this->info('💡 Suggested Actions:');
            $this->line('   • Review the PRODUCTION_LOGIN_TROUBLESHOOTING.md file');
            $this->line('   • Run ./deploy-production.sh to fix common issues');
            $this->line('   • Check web server logs for additional errors');
        }
    }
}
