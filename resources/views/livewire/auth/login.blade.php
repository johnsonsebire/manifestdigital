<?php

use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Features;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    #[Validate('required|string|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = false;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        try {
            Log::info('LOGIN_ATTEMPT_START', [
                'email' => $this->email,
                'remember' => $this->remember,
                'session_id' => session()->getId(),
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'csrf_token' => csrf_token(),
            ]);

            Log::info('LOGIN_VALIDATION_START');
            $this->validate();
            Log::info('LOGIN_VALIDATION_SUCCESS');

            Log::info('LOGIN_RATE_LIMIT_CHECK');
            $this->ensureIsNotRateLimited();
            Log::info('LOGIN_RATE_LIMIT_PASSED');

            Log::info('LOGIN_CREDENTIALS_VALIDATION_START');
            $user = $this->validateCredentials();
            Log::info('LOGIN_CREDENTIALS_VALIDATION_SUCCESS', [
                'user_id' => $user->id,
                'user_email' => $user->email,
            ]);

            if (Features::canManageTwoFactorAuthentication() && $user->hasEnabledTwoFactorAuthentication()) {
                Log::info('LOGIN_2FA_REDIRECT', ['user_id' => $user->id]);
                
                Session::put([
                    'login.id' => $user->getKey(),
                    'login.remember' => $this->remember,
                ]);

                $this->redirect(route('two-factor.login'), navigate: true);
                return;
            }

            Log::info('LOGIN_AUTH_LOGIN_START', ['user_id' => $user->id]);
            Auth::login($user, $this->remember);
            Log::info('LOGIN_AUTH_LOGIN_SUCCESS', [
                'authenticated_user_id' => Auth::id(),
                'auth_check' => Auth::check(),
            ]);

            RateLimiter::clear($this->throttleKey());
            
            Log::info('LOGIN_SESSION_REGENERATE_START');
            Session::regenerate();
            Log::info('LOGIN_SESSION_REGENERATE_SUCCESS', [
                'new_session_id' => session()->getId(),
            ]);

            Log::info('LOGIN_REDIRECT_START', [
                'dashboard_route' => route('dashboard', absolute: false),
            ]);
            
            $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
            
            Log::info('LOGIN_COMPLETE_SUCCESS');

        } catch (ValidationException $e) {
            Log::error('LOGIN_VALIDATION_ERROR', [
                'email' => $this->email,
                'errors' => $e->errors(),
                'message' => $e->getMessage(),
            ]);
            throw $e;
        } catch (\Exception $e) {
            Log::error('LOGIN_UNEXPECTED_ERROR', [
                'email' => $this->email,
                'session_id' => session()->getId(),
                'error_message' => $e->getMessage(),
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine(),
                'stack_trace' => $e->getTraceAsString(),
            ]);
            
            // Re-throw the exception so user sees an error
            throw new ValidationException(validator([], []), [
                'email' => ['An unexpected error occurred during login. Please try again.']
            ]);
        }
    }

    /**
     * Validate the user's credentials.
     */
    protected function validateCredentials(): User
    {
        Log::info('CREDENTIALS_LOOKUP_START', ['email' => $this->email]);
        
        $user = Auth::getProvider()->retrieveByCredentials(['email' => $this->email, 'password' => $this->password]);
        
        if (! $user) {
            Log::warning('CREDENTIALS_USER_NOT_FOUND', ['email' => $this->email]);
            RateLimiter::hit($this->throttleKey());
            
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }
        
        Log::info('CREDENTIALS_USER_FOUND', [
            'user_id' => $user->id,
            'user_email' => $user->email,
            'email_verified_at' => $user->email_verified_at,
        ]);
        
        Log::info('CREDENTIALS_PASSWORD_CHECK_START');
        $passwordValid = Auth::getProvider()->validateCredentials($user, ['password' => $this->password]);
        
        if (! $passwordValid) {
            Log::warning('CREDENTIALS_PASSWORD_INVALID', [
                'user_id' => $user->id,
                'email' => $this->email,
            ]);
            RateLimiter::hit($this->throttleKey());
            
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }
        
        Log::info('CREDENTIALS_PASSWORD_VALID', ['user_id' => $user->id]);
        
        return $user;
    }

    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        $throttleKey = $this->throttleKey();
        $attempts = RateLimiter::attempts($throttleKey);
        
        Log::info('RATE_LIMIT_CHECK', [
            'throttle_key' => $throttleKey,
            'current_attempts' => $attempts,
            'max_attempts' => 5,
        ]);
        
        if (! RateLimiter::tooManyAttempts($throttleKey, 5)) {
            return;
        }

        Log::warning('RATE_LIMIT_EXCEEDED', [
            'throttle_key' => $throttleKey,
            'attempts' => $attempts,
            'email' => $this->email,
        ]);

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($throttleKey);

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email).'|'.request()->ip());
    }
}; ?>

<div class="flex flex-col gap-6">
    <x-auth-header :title="__('Log in to your account')" :description="__('Enter your email and password below to log in')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form method="POST" wire:submit="login" class="flex flex-col gap-6">
        @csrf
        <!-- Email Address -->
        <flux:input
            wire:model="email"
            :label="__('Email address')"
            type="email"
            required
            autofocus
            autocomplete="email"
            placeholder="email@example.com"
        />

        <!-- Password -->
        <div class="relative">
            <flux:input
                wire:model="password"
                :label="__('Password')"
                type="password"
                required
                autocomplete="current-password"
                :placeholder="__('Password')"
                viewable
            />

            @if (Route::has('password.request'))
                <flux:link class="absolute top-0 text-sm end-0" :href="route('password.request')" wire:navigate>
                    {{ __('Forgot your password?') }}
                </flux:link>
            @endif
        </div>

        <!-- Remember Me -->
        <flux:checkbox wire:model="remember" :label="__('Remember me')" />

        <div class="flex items-center justify-end">
            <flux:button variant="primary" type="submit" class="w-full" data-test="login-button">
                {{ __('Log in') }}
            </flux:button>
        </div>
    </form>

    @if (Route::has('register'))
        <div class="space-x-1 text-sm text-center rtl:space-x-reverse text-zinc-600 dark:text-zinc-400">
            <span>{{ __('Don\'t have an account?') }}</span>
            <flux:link :href="route('register')" wire:navigate>{{ __('Sign up') }}</flux:link>
        </div>
    @endif
</div>
