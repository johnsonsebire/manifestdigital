<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MonitorAuthLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auth:monitor {--follow : Follow log file in real-time}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Monitor authentication logs for debugging login/register issues';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $logFile = storage_path('logs/laravel.log');
        
        if (!file_exists($logFile)) {
            $this->error('Log file not found: ' . $logFile);
            return Command::FAILURE;
        }

        $this->info('🔍 Monitoring Authentication Logs...');
        $this->info('📁 Log file: ' . $logFile);
        $this->newLine();

        if ($this->option('follow')) {
            $this->info('👀 Following log file in real-time (Press Ctrl+C to stop)...');
            $this->followLogs($logFile);
        } else {
            $this->showRecentAuthLogs($logFile);
        }

        return Command::SUCCESS;
    }

    private function followLogs($logFile)
    {
        $handle = popen("tail -f {$logFile} | grep -E '(LOGIN_|REGISTER_|LIVEWIRE_|auth)'", 'r');
        
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                $this->formatLogLine($line);
            }
            pclose($handle);
        }
    }

    private function showRecentAuthLogs($logFile)
    {
        $this->info('📊 Recent Authentication Activity:');
        $this->newLine();
        
        // Get last 100 lines and filter for auth-related entries
        $command = "tail -100 {$logFile} | grep -E '(LOGIN_|REGISTER_|LIVEWIRE_|auth)'";
        $output = shell_exec($command);
        
        if (empty($output)) {
            $this->warn('No recent authentication logs found.');
            $this->info('💡 Try the following:');
            $this->line('   • Attempt a login/register and run this command again');
            $this->line('   • Run with --follow flag to monitor in real-time');
            return;
        }

        $lines = explode("\n", trim($output));
        
        foreach (array_slice($lines, -20) as $line) {
            if (!empty($line)) {
                $this->formatLogLine($line);
            }
        }
        
        $this->newLine();
        $this->info('💡 Tips:');
        $this->line('   • Run with --follow to monitor in real-time');
        $this->line('   • Look for error patterns in the log output above');
        $this->line('   • Check for CSRF token mismatches or validation errors');
    }

    private function formatLogLine($line)
    {
        if (str_contains($line, 'ERROR')) {
            $this->error('🔴 ' . $this->cleanLogLine($line));
        } elseif (str_contains($line, 'WARNING')) {
            $this->warn('🟡 ' . $this->cleanLogLine($line));
        } elseif (str_contains($line, 'LOGIN_')) {
            $this->line('🔑 <fg=blue>' . $this->cleanLogLine($line) . '</>');
        } elseif (str_contains($line, 'REGISTER_')) {
            $this->line('📝 <fg=green>' . $this->cleanLogLine($line) . '</>');
        } elseif (str_contains($line, 'LIVEWIRE_')) {
            $this->line('⚡ <fg=cyan>' . $this->cleanLogLine($line) . '</>');
        } else {
            $this->line('ℹ️  ' . $this->cleanLogLine($line));
        }
    }

    private function cleanLogLine($line)
    {
        // Remove timestamp and log level prefix for cleaner output
        return preg_replace('/^\[.*?\]\s*(local\.|production\.)?(\w+):\s*/', '', $line);
    }
}
