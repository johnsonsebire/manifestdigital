<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public bool $terms = false;
    public bool $newsletter = false;

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'terms' => ['required', 'accepted'],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered(($user = User::create($validated))));

        Auth::login($user);

        Session::regenerate();

        $this->redirectIntended(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<!-- Auth Container - Single Root Element for Livewire -->
<div class="auth-component-container">
    <!-- Auth Tabs -->
    <div class="auth-tabs" style="display: flex; background: #f8f9fa;">
        <button class="auth-tab" data-tab="login" style="flex: 1; padding: 20px; text-align: center; background: transparent; border: none; font-family: 'Anybody', sans-serif; font-weight: 600; font-size: 18px; color: #666; cursor: pointer; transition: all 0.3s ease; position: relative;" onclick="window.location.href='{{ route('login') }}'">
            <i class="fas fa-sign-in-alt"></i> Login
        </button>
        <button class="auth-tab active" data-tab="register" style="flex: 1; padding: 20px; text-align: center; background: #FFFCFA; border: none; font-family: 'Anybody', sans-serif; font-weight: 600; font-size: 18px; color: #FF4900; cursor: pointer; transition: all 0.3s ease; position: relative;">
            <i class="fas fa-user-plus"></i> Register
        </button>
    </div>

    <!-- Register Form -->
    <form class="auth-form active" wire:submit="register" style="padding: 40px;">
    <h2>Create Account</h2>
    <p class="subtitle">Join us to unlock powerful digital solutions for your organization</p>
    
    <!-- Session Status -->
    @if (session('status'))
        <div class="alert alert-success" style="background: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 12px; border-radius: 8px; margin-bottom: 20px;">
            {{ session('status') }}
        </div>
    @endif
    
    <div class="form-group">
        <label class="form-label" for="registerName">Full Name</label>
        <input 
            type="text" 
            class="form-input @error('name') error @enderror" 
            id="registerName" 
            wire:model="name" 
            placeholder="Enter your full name" 
            required 
            autofocus 
            autocomplete="name"
        >
        @error('name')
            <div class="form-error">{{ $message }}</div>
        @enderror
    </div>
    
    <div class="form-group">
        <label class="form-label" for="registerEmail">Email Address</label>
        <input 
            type="email" 
            class="form-input @error('email') error @enderror" 
            id="registerEmail" 
            wire:model="email" 
            placeholder="Enter your email address" 
            required 
            autocomplete="email"
        >
        @error('email')
            <div class="form-error">{{ $message }}</div>
        @enderror
    </div>
    
    <div class="form-group" style="position: relative;">
        <label class="form-label" for="registerPassword">Password</label>
        <input 
            type="password" 
            class="form-input @error('password') error @enderror" 
            id="registerPassword" 
            wire:model="password" 
            placeholder="Create a strong password" 
            required 
            autocomplete="new-password"
        >
        <button type="button" class="password-toggle" data-target="registerPassword">
            <i class="fas fa-eye"></i>
        </button>
        @error('password')
            <div class="form-error">{{ $message }}</div>
        @enderror
    </div>
    
    <div class="form-group" style="position: relative;">
        <label class="form-label" for="confirmPassword">Confirm Password</label>
        <input 
            type="password" 
            class="form-input @error('password_confirmation') error @enderror" 
            id="confirmPassword" 
            wire:model="password_confirmation" 
            placeholder="Confirm your password" 
            required 
            autocomplete="new-password"
        >
        <button type="button" class="password-toggle" data-target="confirmPassword">
            <i class="fas fa-eye"></i>
        </button>
        @error('password_confirmation')
            <div class="form-error">{{ $message }}</div>
        @enderror
    </div>
    
    <div class="checkbox-group">
        <input type="checkbox" class="checkbox-input" id="agreeTerms" wire:model="terms" required>
        <label class="checkbox-label" for="agreeTerms">
            I agree to the <a href="{{ route('policies') }}">Terms of Service</a> and <a href="{{ route('policies') }}">Privacy Policy</a>
        </label>
        @error('terms')
            <div class="form-error">{{ $message }}</div>
        @enderror
    </div>
    
    <div class="checkbox-group">
        <input type="checkbox" class="checkbox-input" id="newsletter" wire:model="newsletter">
        <label class="checkbox-label" for="newsletter">
            Send me updates about new features and digital marketing tips
        </label>
    </div>
    
    <button type="submit" class="btn-auth">
        <i class="fas fa-user-plus"></i> Create Account
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
    
    <div class="back-to-login">
        <span>Already have an account? </span>
        <a href="{{ route('login') }}" wire:navigate>Sign in here</a>
    </div>
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
    
    // Form validation
    function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }
    
    function validatePassword(password) {
        return password.length >= 8;
    }
    
    function showError(inputId, message) {
        const input = document.getElementById(inputId);
        const errorDiv = input.parentNode.querySelector('.form-error');
        if (errorDiv) {
            input.classList.add('error');
            input.classList.remove('success');
            errorDiv.textContent = message;
            errorDiv.style.display = 'block';
        }
    }
    
    function showSuccess(inputId) {
        const input = document.getElementById(inputId);
        const errorDiv = input.parentNode.querySelector('.form-error');
        if (errorDiv) {
            input.classList.remove('error');
            input.classList.add('success');
            errorDiv.style.display = 'none';
        }
    }
    
    // Real-time validation
    const inputs = document.querySelectorAll('.form-input');
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            const value = this.value.trim();
            const inputId = this.id;
            
            if (!value) return;
            
            switch(inputId) {
                case 'registerEmail':
                    if (validateEmail(value)) {
                        showSuccess(inputId);
                    } else {
                        showError(inputId, 'Please enter a valid email address');
                    }
                    break;
                case 'registerName':
                    if (value.length >= 2) {
                        showSuccess(inputId);
                    } else {
                        showError(inputId, 'Name must be at least 2 characters long');
                    }
                    break;
                case 'registerPassword':
                    if (validatePassword(value)) {
                        showSuccess(inputId);
                    } else {
                        showError(inputId, 'Password must be at least 8 characters long');
                    }
                    break;
                case 'confirmPassword':
                    const registerPassword = document.getElementById('registerPassword').value;
                    if (value === registerPassword) {
                        showSuccess(inputId);
                    } else {
                        showError(inputId, 'Passwords do not match');
                    }
                    break;
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
