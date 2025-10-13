<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    public string $email = '';

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        Password::sendResetLink($this->only('email'));

        session()->flash('status', __('A reset link will be sent if the account exists.'));
    }
}; ?>

<!-- Password Reset Form - Single Root Element for Livewire -->
<div class="auth-form active" style="text-align: center; padding: 40px;">
    <div class="reset-icon" style="width: 80px; height: 80px; background: linear-gradient(135deg, #FF4900, #FF6B3D); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 30px; font-size: 36px; color: white; box-shadow: 0 8px 25px rgba(255, 73, 0, 0.3);">
        <i class="fas fa-lock"></i>
    </div>
    
    <h2 style="font-family: 'Anybody', sans-serif; font-weight: 800; font-size: 32px; color: #1a1a1a; margin-bottom: 16px;">Forgot Password?</h2>
    <p class="subtitle">
        No worries! Enter your email address and we'll send you instructions to reset your password.
    </p>
    
    <!-- Session Status -->
    @if (session('status'))
        <div class="success-message" style="background: linear-gradient(135deg, #28a745, #20c997); color: white; padding: 20px; border-radius: 12px; margin-bottom: 30px;">
            <i class="fas fa-check-circle" style="font-size: 48px; margin-bottom: 16px; display: block;"></i>
            <div>
                <strong>Email Sent Successfully!</strong><br>
                {{ session('status') }}
            </div>
        </div>
    @endif
    
    <form wire:submit="sendPasswordResetLink">
        <div class="form-group" style="text-align: left;">
            <label class="form-label" for="resetEmail">Email Address</label>
            <input 
                type="email" 
                class="form-input @error('email') error @enderror" 
                id="resetEmail" 
                wire:model="email" 
                placeholder="Enter your email address" 
                required 
                autofocus 
                style="text-align: center;"
            >
            @error('email')
                <div class="form-error" style="text-align: center;">{{ $message }}</div>
            @enderror
        </div>
        
        <button type="submit" class="btn-auth">
            <i class="fas fa-paper-plane"></i> Send Reset Instructions
        </button>
        
        <a href="{{ route('login') }}" class="btn-secondary" style="width: 100%; padding: 16px; background: transparent; color: #666; border: 2px solid #e0e0e0; border-radius: 12px; font-family: 'Anybody', sans-serif; font-weight: 600; font-size: 16px; cursor: pointer; transition: all 0.3s ease; text-decoration: none; display: inline-block; text-align: center;" wire:navigate>
            <i class="fas fa-arrow-left"></i> Back to Login
        </a>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form validation
    function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
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
    const emailInput = document.getElementById('resetEmail');
    if (emailInput) {
        emailInput.addEventListener('blur', function() {
            const value = this.value.trim();
            
            if (!value) return;
            
            if (validateEmail(value)) {
                showSuccess('resetEmail');
            } else {
                showError('resetEmail', 'Please enter a valid email address');
            }
        });
    }
});
</script>
@endpush
