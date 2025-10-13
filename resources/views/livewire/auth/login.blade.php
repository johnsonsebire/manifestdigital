<?php

use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
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
        $this->validate();

        $this->ensureIsNotRateLimited();

        $user = $this->validateCredentials();

        if (Features::canManageTwoFactorAuthentication() && $user->hasEnabledTwoFactorAuthentication()) {
            Session::put([
                'login.id' => $user->getKey(),
                'login.remember' => $this->remember,
            ]);

            $this->redirect(route('two-factor.login'), navigate: true);

            return;
        }

        Auth::login($user, $this->remember);

        RateLimiter::clear($this->throttleKey());
        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }

    /**
     * Validate the user's credentials.
     */
    protected function validateCredentials(): User
    {
        $user = Auth::getProvider()->retrieveByCredentials(['email' => $this->email, 'password' => $this->password]);

        if (! $user || ! Auth::getProvider()->validateCredentials($user, ['password' => $this->password])) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        return $user;
    }

    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

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

<!-- Auth Container - Single Root Element for Livewire -->
<div class="auth-component-container">
    <!-- Auth Tabs -->
    <div class="auth-tabs" style="display: flex; background: #f8f9fa;">
        <button class="auth-tab active" data-tab="login" style="flex: 1; padding: 20px; text-align: center; background: #FFFCFA; border: none; font-family: 'Anybody', sans-serif; font-weight: 600; font-size: 18px; color: #FF4900; cursor: pointer; transition: all 0.3s ease; position: relative;">
            <i class="fas fa-sign-in-alt"></i> Login
        </button>
        <button class="auth-tab" data-tab="register" style="flex: 1; padding: 20px; text-align: center; background: transparent; border: none; font-family: 'Anybody', sans-serif; font-weight: 600; font-size: 18px; color: #666; cursor: pointer; transition: all 0.3s ease; position: relative;" onclick="window.location.href='{{ route('register') }}'">
            <i class="fas fa-user-plus"></i> Register
        </button>
    </div>

    <!-- Login Form -->
    <form class="auth-form active" wire:submit="login" style="padding: 40px;">
    <h2>Welcome Back</h2>
    <p class="subtitle">Sign in to access your dashboard and continue your digital journey</p>
    
    <!-- Session Status -->
    @if (session('status'))
        <div class="alert alert-success" style="background: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 12px; border-radius: 8px; margin-bottom: 20px;">
            {{ session('status') }}
        </div>
    @endif
    
    <div class="form-group">
        <label class="form-label" for="loginEmail">Email Address</label>
        <input 
            type="email" 
            class="form-input @error('email') error @enderror" 
            id="loginEmail" 
            wire:model="email" 
            placeholder="Enter your email address" 
            required 
            autofocus 
            autocomplete="email"
        >
        @error('email')
            <div class="form-error">{{ $message }}</div>
        @enderror
    </div>
    
    <div class="form-group" style="position: relative;">
        <label class="form-label" for="loginPassword">Password</label>
        <input 
            type="password" 
            class="form-input @error('password') error @enderror" 
            id="loginPassword" 
            wire:model="password" 
            placeholder="Enter your password" 
            required 
            autocomplete="current-password"
        >
        <button type="button" class="password-toggle" data-target="loginPassword">
            <i class="fas fa-eye"></i>
        </button>
        @error('password')
            <div class="form-error">{{ $message }}</div>
        @enderror
    </div>
    
    <div class="checkbox-group">
        <input type="checkbox" class="checkbox-input" id="rememberMe" wire:model="remember">
        <label class="checkbox-label" for="rememberMe">
            Remember me for 30 days
        </label>
    </div>
    
    <button type="submit" class="btn-auth">
        <i class="fas fa-sign-in-alt"></i> Sign In
    </button>
    
    <div class="divider">
        <span>Or continue with</span>
    </div>
    
    <div class="social-login">
        <button type="button" class="btn-social" data-provider="google">
            <i class="fab fa-google"></i> Google
        </button>
        <button type="button" class="btn-social" data-provider="microsoft">
            <i class="fab fa-microsoft"></i> Microsoft
        </button>
    </div>
    
    @if (Route::has('password.request'))
        <div class="back-to-login">
            <a href="{{ route('password.request') }}" wire:navigate>Forgot your password?</a>
        </div>
    @endif
</form>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Password toggle functionality
    const passwordToggles = document.querySelectorAll('.password-toggle');
    passwordToggles.forEach(toggle => {
        toggle.addEventListener('click', function() {
            const targetId = this.dataset.target;
            const targetInput = document.getElementById(targetId);
            const icon = this.querySelector('i');
            
            if (targetInput.type === 'password') {
                targetInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                targetInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    });
    
    // Social login handlers
    const socialButtons = document.querySelectorAll('.btn-social');
    socialButtons.forEach(button => {
        button.addEventListener('click', function() {
            const provider = this.dataset.provider;
            alert(`${provider.charAt(0).toUpperCase() + provider.slice(1)} authentication would be implemented here`);
        });
    });
});
</script>
@endpush
    </form>
</div>
