<?php

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    #[Locked]
    public string $token = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Mount the component.
     */
    public function mount(string $token): void
    {
        $this->token = $token;

        $this->email = request()->string('email');
    }

    /**
     * Reset the password for the given user.
     */
    public function resetPassword(): void
    {
        $this->validate([
            'token' => ['required'],
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $status = Password::reset(
            $this->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) {
                $user->forceFill([
                    'password' => Hash::make($this->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        if ($status !== Password::PASSWORD_RESET) {
            $this->addError('email', __($status));

            return;
        }

        Session::flash('status', __($status));

        $this->redirectRoute('login', navigate: true);
    }
}; ?>

<!-- Reset Password Form - Single Root Element for Livewire -->
<div class="auth-form active" style="text-align: center; padding: 40px;">
    <div class="reset-icon" style="width: 80px; height: 80px; background: linear-gradient(135deg, #FF4900, #FF6B3D); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 30px; font-size: 36px; color: white; box-shadow: 0 8px 25px rgba(255, 73, 0, 0.3);">
        <i class="fas fa-key"></i>
    </div>
    
    <h2 style="font-family: 'Anybody', sans-serif; font-weight: 800; font-size: 32px; color: #1a1a1a; margin-bottom: 16px;">Reset Password</h2>
    <p class="subtitle">
        Enter your new password below. Make sure it's strong and secure.
    </p>
    
    <!-- Session Status -->
    @if (session('status'))
        <div class="success-message" style="background: linear-gradient(135deg, #28a745, #20c997); color: white; padding: 20px; border-radius: 12px; margin-bottom: 30px;">
            <i class="fas fa-check-circle" style="font-size: 48px; margin-bottom: 16px; display: block;"></i>
            <div>
                <strong>Password Reset Successful!</strong><br>
                {{ session('status') }}
            </div>
        </div>
    @endif
    
    <form wire:submit="resetPassword">
        <div class="password-requirements" style="background: #f8f9fa; border-radius: 12px; padding: 20px; margin-bottom: 24px; text-align: left;">
            <h4 style="font-family: 'Anybody', sans-serif; font-weight: 700; font-size: 14px; color: #1a1a1a; margin-bottom: 12px;">Password Requirements:</h4>
            <div class="requirement-item" id="req-length" style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px; font-size: 14px; color: #dc3545;">
                <i class="fas fa-times" style="width: 16px;"></i>
                <span>At least 8 characters long</span>
            </div>
            <div class="requirement-item" id="req-uppercase" style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px; font-size: 14px; color: #dc3545;">
                <i class="fas fa-times" style="width: 16px;"></i>
                <span>One uppercase letter</span>
            </div>
            <div class="requirement-item" id="req-lowercase" style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px; font-size: 14px; color: #dc3545;">
                <i class="fas fa-times" style="width: 16px;"></i>
                <span>One lowercase letter</span>
            </div>
            <div class="requirement-item" id="req-number" style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px; font-size: 14px; color: #dc3545;">
                <i class="fas fa-times" style="width: 16px;"></i>
                <span>One number</span>
            </div>
        </div>
        
        <div class="form-group" style="text-align: left;">
            <label class="form-label" for="resetEmail">Email Address</label>
            <input 
                type="email" 
                class="form-input @error('email') error @enderror" 
                id="resetEmail" 
                wire:model="email" 
                required 
                readonly 
                autocomplete="email"
            >
            @error('email')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="form-group" style="position: relative; text-align: left;">
            <label class="form-label" for="newPassword">New Password</label>
            <input 
                type="password" 
                class="form-input @error('password') error @enderror" 
                id="newPassword" 
                wire:model="password" 
                placeholder="Enter your new password" 
                required 
                autocomplete="new-password"
            >
            <button type="button" class="password-toggle" data-target="newPassword">
                <i class="fas fa-eye"></i>
            </button>
            @error('password')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="form-group" style="position: relative; text-align: left;">
            <label class="form-label" for="confirmNewPassword">Confirm New Password</label>
            <input 
                type="password" 
                class="form-input @error('password_confirmation') error @enderror" 
                id="confirmNewPassword" 
                wire:model="password_confirmation" 
                placeholder="Confirm your new password" 
                required 
                autocomplete="new-password"
            >
            <button type="button" class="password-toggle" data-target="confirmNewPassword">
                <i class="fas fa-eye"></i>
            </button>
            @error('password_confirmation')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>
        
        <button type="submit" class="btn-auth" id="resetPasswordBtn">
            <i class="fas fa-check"></i> Reset Password
        </button>
        
        <a href="{{ route('login') }}" class="btn-secondary" style="width: 100%; padding: 16px; background: transparent; color: #666; border: 2px solid #e0e0e0; border-radius: 12px; font-family: 'Anybody', sans-serif; font-weight: 600; font-size: 16px; cursor: pointer; transition: all 0.3s ease; text-decoration: none; display: inline-block; text-align: center;" wire:navigate>
            <i class="fas fa-arrow-left"></i> Back to Login
        </a>
    </form>
</div>

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
    
    // Password strength validation
    function validatePasswordStrength(password) {
        const requirements = {
            length: password.length >= 8,
            uppercase: /[A-Z]/.test(password),
            lowercase: /[a-z]/.test(password),
            number: /\d/.test(password)
        };
        
        // Update requirement indicators
        Object.keys(requirements).forEach(req => {
            const element = document.getElementById('req-' + req);
            const icon = element.querySelector('i');
            
            if (requirements[req]) {
                element.style.color = '#28a745';
                icon.classList.remove('fa-times');
                icon.classList.add('fa-check');
            } else {
                element.style.color = '#dc3545';
                icon.classList.remove('fa-check');
                icon.classList.add('fa-times');
            }
        });
        
        return Object.values(requirements).every(req => req);
    }
    
    // Real-time password validation
    const newPasswordInput = document.getElementById('newPassword');
    const confirmNewPasswordInput = document.getElementById('confirmNewPassword');
    const resetPasswordBtn = document.getElementById('resetPasswordBtn');
    
    function checkPasswordsMatch() {
        const password = newPasswordInput.value;
        const confirmPassword = confirmNewPasswordInput.value;
        const isStrong = validatePasswordStrength(password);
        const isMatching = password === confirmPassword && password.length > 0;
        
        // Enable/disable button based on validation
        if (resetPasswordBtn) {
            resetPasswordBtn.disabled = !(isStrong && isMatching);
        }
        
        if (confirmPassword.length > 0) {
            const confirmInput = document.getElementById('confirmNewPassword');
            const errorDiv = confirmInput.parentNode.querySelector('.form-error');
            
            if (isMatching) {
                confirmInput.classList.remove('error');
                confirmInput.classList.add('success');
                if (errorDiv) errorDiv.style.display = 'none';
            } else {
                confirmInput.classList.add('error');
                confirmInput.classList.remove('success');
                if (errorDiv) {
                    errorDiv.textContent = 'Passwords do not match';
                    errorDiv.style.display = 'block';
                }
            }
        }
    }
    
    if (newPasswordInput) {
        newPasswordInput.addEventListener('input', function() {
            validatePasswordStrength(this.value);
            checkPasswordsMatch();
        });
    }
    
    if (confirmNewPasswordInput) {
        confirmNewPasswordInput.addEventListener('input', checkPasswordsMatch);
    }
});
</script>
@endpush
