@props([
    'title' => 'Stay Updated',
    'description' => 'Subscribe to our newsletter for the latest updates and exclusive content.',
])

<section class="newsletter-section">
    <div class="newsletter-container">
        <div class="newsletter-content" x-data="{ 
            email: '', 
            success: false,
            error: '',
            loading: false,
            async subscribe() {
                this.loading = true;
                this.error = '';
                
                try {
                    const response = await fetch('/api/newsletter/subscribe', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                        },
                        body: JSON.stringify({ email: this.email })
                    });
                    
                    const data = await response.json();
                    
                    if (response.ok) {
                        this.success = true;
                        this.email = '';
                    } else {
                        this.error = data.message || 'Something went wrong. Please try again.';
                    }
                } catch (err) {
                    this.error = 'Network error. Please try again.';
                }
                
                this.loading = false;
            }
        }">
            <div class="newsletter-text">
                <h2>{{ $title }}</h2>
                <p>{{ $description }}</p>
            </div>

            <form @submit.prevent="subscribe" class="newsletter-form">
                <div class="input-group" :class="{ 'error': error }">
                    <i class="fas fa-envelope"></i>
                    <input 
                        type="email" 
                        x-model="email"
                        placeholder="Enter your email address"
                        required
                        :disabled="loading || success"
                    >
                    <button type="submit" :disabled="loading || success">
                        <template x-if="!loading">
                            <span>Subscribe</span>
                        </template>
                        <template x-if="loading">
                            <i class="fas fa-spinner fa-spin"></i>
                        </template>
                    </button>
                </div>
                
                <template x-if="error">
                    <p class="error-message" x-text="error"></p>
                </template>

                <template x-if="success">
                    <div class="success-message">
                        <i class="fas fa-check-circle"></i>
                        <p>Thank you for subscribing!</p>
                    </div>
                </template>
            </form>
        </div>
    </div>
</section>

<style>
.newsletter-section {
    background: linear-gradient(135deg, #ff2200, #ff6b00);
    padding: 80px 0;
    color: white;
    overflow: hidden;
    position: relative;
}

.newsletter-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='rgba(255,255,255,0.1)' fill-rule='evenodd'/%3E%3C/svg%3E");
}

.newsletter-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
    position: relative;
    z-index: 1;
}

.newsletter-content {
    max-width: 600px;
    margin: 0 auto;
    text-align: center;
}

.newsletter-text h2 {
    font-size: 36px;
    font-weight: 800;
    margin-bottom: 15px;
    letter-spacing: -0.5px;
}

.newsletter-text p {
    font-size: 18px;
    opacity: 0.9;
    margin-bottom: 30px;
}

.newsletter-form {
    position: relative;
}

.input-group {
    display: flex;
    background: white;
    border-radius: 50px;
    padding: 5px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
}

.input-group.error {
    box-shadow: 0 5px 20px rgba(255, 0, 0, 0.2);
}

.input-group i {
    width: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #666;
}

.input-group input {
    flex: 1;
    border: none;
    padding: 0 15px;
    font-size: 16px;
    outline: none;
    background: transparent;
}

.input-group button {
    background: linear-gradient(135deg, #ff2200, #ff6b00);
    color: white;
    border: none;
    padding: 12px 30px;
    border-radius: 25px;
    font-weight: 600;
    cursor: pointer;
    transition: transform 0.3s ease;
}

.input-group button:hover:not(:disabled) {
    transform: translateY(-1px);
}

.input-group button:disabled {
    opacity: 0.7;
    cursor: not-allowed;
}

.error-message {
    color: #ffd1d1;
    font-size: 14px;
    margin-top: 10px;
}

.success-message {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50px;
    padding: 15px;
    margin-top: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    animation: fadeInUp 0.5s ease-out;
}

.success-message i {
    font-size: 20px;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive Design */
@media (max-width: 768px) {
    .newsletter-section {
        padding: 60px 0;
    }
    
    .newsletter-text h2 {
        font-size: 30px;
    }
    
    .newsletter-text p {
        font-size: 16px;
    }
}

@media (max-width: 480px) {
    .input-group {
        flex-direction: column;
        background: none;
        box-shadow: none;
        padding: 0;
    }
    
    .input-group i {
        display: none;
    }
    
    .input-group input {
        background: white;
        padding: 15px 25px;
        border-radius: 50px;
        margin-bottom: 10px;
        text-align: center;
    }
    
    .input-group button {
        width: 100%;
        padding: 15px;
    }
}
</style>