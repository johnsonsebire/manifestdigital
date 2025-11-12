<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class DiagnoseLoginAdvanced extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'diagnose:login-advanced {--test-user=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Advanced login diagnostics for production issues';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔬 Advanced Login Diagnostics...');
        $this->newLine();

        // Check Livewire setup
        $this->checkLivewireConfig();
        
        // Check CSRF configuration
        $this->checkCSRFConfig();
        
        // Check rate limiting
        $this->checkRateLimiting();
        
        // Check middleware
        $this->checkMiddleware();
        
        // Check user authentication
        if ($email = $this->option('test-user')) {
            $this->testUserAuth($email);
        }
        
        // Check for common production issues
        $this->checkProductionIssues();

        return Command::SUCCESS;
    }

    private function checkLivewireConfig()
    {
        $this->info('⚡ Livewire Configuration:');
        
        try {
            $livewireManifest = base_path('bootstrap/cache/livewire-components.php');
            if (file_exists($livewireManifest)) {
                $this->line('   ✅ Livewire manifest exists');
            } else {
                $this->line('   ❌ Livewire manifest missing - run: php artisan livewire:publish --assets');
            }
            
            // Check if Livewire assets are published
            $livewireJs = public_path('vendor/livewire/livewire.js');
            if (file_exists($livewireJs)) {
                $this->line('   ✅ Livewire assets published');
            } else {
                $this->line('   ❌ Livewire assets missing - run: php artisan livewire:publish --assets');
            }
            
        } catch (\Exception $e) {
            $this->line('   ❌ Error checking Livewire: ' . $e->getMessage());
        }
        
        $this->newLine();
    }

    private function checkCSRFConfig()
    {
        $this->info('🛡️ CSRF Configuration:');
        
        $csrfToken = csrf_token();
        $this->line("   CSRF Token Length: " . strlen($csrfToken));
        
        // Check if CSRF middleware is registered
        $kernel = app(\Illuminate\Contracts\Http\Kernel::class);
        $middlewareGroups = $kernel->getMiddlewareGroups();
        
        if (isset($middlewareGroups['web']) && 
            in_array(\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class, $middlewareGroups['web'])) {
            $this->line('   ✅ CSRF middleware registered');
        } else {
            $this->line('   ❌ CSRF middleware not found in web group');
        }
        
        $this->newLine();
    }

    private function checkRateLimiting()
    {
        $this->info('⏱️ Rate Limiting:');
        
        try {
            $rateLimiters = ['login', 'register', 'two-factor'];
            foreach ($rateLimiters as $limiter) {
                try {
                    \Illuminate\Support\Facades\RateLimiter::limiter($limiter);
                    $this->line("   ✅ Rate limiter '{$limiter}' exists");
                } catch (\Exception $e) {
                    $this->line("   ❌ Rate limiter '{$limiter}' missing");
                }
            }
        } catch (\Exception $e) {
            $this->line('   ❌ Error checking rate limiters: ' . $e->getMessage());
        }
        
        $this->newLine();
    }

    private function checkMiddleware()
    {
        $this->info('🔒 Authentication Routes & Middleware:');
        
        try {
            // Check login route
            $loginRoute = \Illuminate\Support\Facades\Route::getRoutes()->getByName('login');
            if ($loginRoute) {
                $this->line('   ✅ Login route exists');
                $middleware = $loginRoute->middleware();
                $this->line('     Middleware: ' . implode(', ', $middleware));
            } else {
                $this->line('   ❌ Login route not found');
            }
            
            // Check dashboard route
            $dashboardRoute = \Illuminate\Support\Facades\Route::getRoutes()->getByName('dashboard');
            if ($dashboardRoute) {
                $this->line('   ✅ Dashboard route exists');
                $middleware = $dashboardRoute->middleware();
                $this->line('     Middleware: ' . implode(', ', $middleware));
            } else {
                $this->line('   ❌ Dashboard route not found');
            }
            
        } catch (\Exception $e) {
            $this->line('   ❌ Error checking routes: ' . $e->getMessage());
        }
        
        $this->newLine();
    }

    private function testUserAuth($email)
    {
        $this->info("👤 Testing User Authentication: {$email}");
        
        try {
            $user = User::where('email', $email)->first();
            
            if (!$user) {
                $this->line('   ❌ User not found in database');
                return;
            }
            
            $this->line("   ✅ User found: {$user->name} ({$user->email})");
            $this->line("   Created: {$user->created_at}");
            $this->line("   Email verified: " . ($user->email_verified_at ? 'Yes' : 'No'));
            
            // Test password (you'll need to provide a test password)
            if ($this->confirm('Test password authentication?')) {
                $password = $this->secret('Enter password to test');
                
                if (Hash::check($password, $user->password)) {
                    $this->line('   ✅ Password hash verification successful');
                } else {
                    $this->line('   ❌ Password hash verification failed');
                }
            }
            
        } catch (\Exception $e) {
            $this->line('   ❌ Error testing user: ' . $e->getMessage());
        }
        
        $this->newLine();
    }

    private function checkProductionIssues()
    {
        $this->info('🚨 Production-Specific Issues:');
        
        // Check for common production problems
        $issues = [];
        
        // Check if running behind load balancer/proxy
        $this->line('   Checking proxy/load balancer configuration...');
        
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $this->line('   ⚠️ Behind proxy - ensure TRUSTED_PROXIES is configured');
            $trustedProxies = config('trustedproxy.proxies');
            $this->line('   Trusted proxies: ' . ($trustedProxies ? implode(', ', (array)$trustedProxies) : 'none'));
        }
        
        // Check session lifetime vs server time
        $sessionLifetime = config('session.lifetime');
        $this->line("   Session lifetime: {$sessionLifetime} minutes");
        
        // Check recent sessions
        try {
            $recentSessions = DB::table('sessions')
                ->where('last_activity', '>', now()->subHours(1)->timestamp)
                ->count();
            $this->line("   Active sessions (last hour): {$recentSessions}");
            
            // Check for orphaned sessions
            $oldSessions = DB::table('sessions')
                ->where('last_activity', '<', now()->subDays(7)->timestamp)
                ->count();
            if ($oldSessions > 100) {
                $this->line("   ⚠️ {$oldSessions} old sessions found - consider cleanup");
            }
            
        } catch (\Exception $e) {
            $this->line('   ❌ Error checking sessions: ' . $e->getMessage());
        }
        
        // Check for JavaScript errors that might prevent form submission
        $this->newLine();
        $this->warn('🔍 Additional Checks to Perform:');
        $this->line('   1. Check browser console for JavaScript errors');
        $this->line('   2. Verify HTTPS certificate is valid');
        $this->line('   3. Test login from different browsers/devices');
        $this->line('   4. Check web server error logs');
        $this->line('   5. Test with browser developer tools network tab');
        
        $this->newLine();
        $this->info('💡 Debugging Commands:');
        $this->line('   # Check recent Laravel logs:');
        $this->line('   tail -f storage/logs/laravel.log');
        $this->line('   ');
        $this->line('   # Clear all caches:');
        $this->line('   php artisan optimize:clear');
        $this->line('   ');
        $this->line('   # Test specific user:');
        $this->line('   php artisan diagnose:login-advanced --test-user=email@domain.com');
    }
}
