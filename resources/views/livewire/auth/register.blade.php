<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        try {
            Log::info('REGISTER_ATTEMPT_START', [
                'name' => $this->name,
                'email' => $this->email,
                'session_id' => session()->getId(),
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'csrf_token' => csrf_token(),
            ]);

            Log::info('REGISTER_RATE_LIMIT_CHECK');
            $this->ensureIsNotRateLimited();
            Log::info('REGISTER_RATE_LIMIT_PASSED');

            Log::info('REGISTER_VALIDATION_START');
            $validated = $this->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
                'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            ]);
            Log::info('REGISTER_VALIDATION_SUCCESS');

            Log::info('REGISTER_PASSWORD_HASH_START');
            $validated['password'] = Hash::make($validated['password']);
            Log::info('REGISTER_PASSWORD_HASH_SUCCESS');

            Log::info('REGISTER_USER_CREATE_START');
            $user = User::create($validated);
            Log::info('REGISTER_USER_CREATE_SUCCESS', [
                'user_id' => $user->id,
                'user_email' => $user->email,
            ]);

            Log::info('REGISTER_EVENT_FIRE_START');
            event(new Registered($user));
            Log::info('REGISTER_EVENT_FIRE_SUCCESS');

            Log::info('REGISTER_AUTH_LOGIN_START', ['user_id' => $user->id]);
            Auth::login($user);
            Log::info('REGISTER_AUTH_LOGIN_SUCCESS', [
                'authenticated_user_id' => Auth::id(),
                'auth_check' => Auth::check(),
            ]);

            RateLimiter::clear($this->throttleKey());
            
            Log::info('REGISTER_SESSION_REGENERATE_START');
            Session::regenerate();
            Log::info('REGISTER_SESSION_REGENERATE_SUCCESS', [
                'new_session_id' => session()->getId(),
            ]);

            Log::info('REGISTER_REDIRECT_START', [
                'dashboard_route' => route('dashboard', absolute: false),
            ]);

            $this->redirectIntended(route('dashboard', absolute: false), navigate: true);
            
            Log::info('REGISTER_COMPLETE_SUCCESS');

        } catch (ValidationException $e) {
            Log::error('REGISTER_VALIDATION_ERROR', [
                'name' => $this->name,
                'email' => $this->email,
                'errors' => $e->errors(),
                'message' => $e->getMessage(),
            ]);
            throw $e;
        } catch (\Exception $e) {
            Log::error('REGISTER_UNEXPECTED_ERROR', [
                'name' => $this->name,
                'email' => $this->email,
                'session_id' => session()->getId(),
                'error_message' => $e->getMessage(),
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine(),
                'stack_trace' => $e->getTraceAsString(),
            ]);
            
            // Re-throw the exception so user sees an error
            throw new ValidationException(validator([], []), [
                'email' => ['An unexpected error occurred during registration. Please try again.']
            ]);
        }
    }

    /**
     * Ensure the registration request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        $throttleKey = $this->throttleKey();
        $attempts = RateLimiter::attempts($throttleKey);
        
        Log::info('REGISTER_RATE_LIMIT_CHECK', [
            'throttle_key' => $throttleKey,
            'current_attempts' => $attempts,
            'max_attempts' => 3,
        ]);
        
        if (! RateLimiter::tooManyAttempts($throttleKey, 3)) {
            return;
        }

        Log::warning('REGISTER_RATE_LIMIT_EXCEEDED', [
            'throttle_key' => $throttleKey,
            'attempts' => $attempts,
            'email' => $this->email,
        ]);

        $seconds = RateLimiter::availableIn($throttleKey);

        throw ValidationException::withMessages([
            'email' => __('Too many registration attempts. Please try again in :seconds seconds.', [
                'seconds' => $seconds,
            ]),
        ]);
    }

    /**
     * Get the registration rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email).'|register|'.request()->ip());
    }
}; ?>

<div class="flex flex-col gap-6">
    <x-auth-header :title="__('Create an account')" :description="__('Enter your details below to create your account')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form method="POST" wire:submit="register" class="flex flex-col gap-6">
        @csrf
        <!-- Name -->
        <flux:input
            wire:model="name"
            :label="__('Name')"
            type="text"
            required
            autofocus
            autocomplete="name"
            :placeholder="__('Full name')"
        />

        <!-- Email Address -->
        <flux:input
            wire:model="email"
            :label="__('Email address')"
            type="email"
            required
            autocomplete="email"
            placeholder="email@example.com"
        />

        <!-- Password -->
        <flux:input
            wire:model="password"
            :label="__('Password')"
            type="password"
            required
            autocomplete="new-password"
            :placeholder="__('Password')"
            viewable
        />

        <!-- Confirm Password -->
        <flux:input
            wire:model="password_confirmation"
            :label="__('Confirm password')"
            type="password"
            required
            autocomplete="new-password"
            :placeholder="__('Confirm password')"
            viewable
        />

        <div class="flex items-center justify-end">
            <flux:button type="submit" variant="primary" class="w-full" data-test="register-user-button">
                {{ __('Create account') }}
            </flux:button>
        </div>
    </form>

    <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
        <span>{{ __('Already have an account?') }}</span>
        <flux:link :href="route('login')" wire:navigate>{{ __('Log in') }}</flux:link>
    </div>
</div>
