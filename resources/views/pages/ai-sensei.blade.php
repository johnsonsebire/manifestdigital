<x-layouts.frontend 
    title="AI Sensei | Coming Soon - Manifest Digital"
    :transparent-header="false"
    preloader="advanced"
    notificationStyle="dark">

    <!-- Coming Soon Section -->
    <section class="coming-soon-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <div class="coming-soon-content">
                        <!-- AI Robot Icon -->
                        <div class="coming-soon-icon">
                            <i class="fas fa-robot"></i>
                        </div>
                        
                        <!-- Main Title -->
                        <h1 class="coming-soon-title">AI Sensei</h1>
                        <h2 class="coming-soon-subtitle">Coming Soon</h2>
                        
                        <!-- Description -->
                        <p class="coming-soon-description">
                            We're working hard to bring you the most advanced AI-powered business assistant. 
                            AI Sensei will revolutionize how you interact with digital services and automate your workflows.
                        </p>
                        
                        <!-- Features Preview -->
                        <div class="features-preview">
                            <div class="row">
                                <div class="col-md-4 mb-4">
                                    <div class="feature-item">
                                        <i class="fas fa-brain"></i>
                                        <h4>Smart Assistance</h4>
                                        <p>Intelligent business insights and recommendations</p>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-4">
                                    <div class="feature-item">
                                        <i class="fas fa-cogs"></i>
                                        <h4>Workflow Automation</h4>
                                        <p>Streamline your business processes with AI</p>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-4">
                                    <div class="feature-item">
                                        <i class="fas fa-chart-line"></i>
                                        <h4>Data Analytics</h4>
                                        <p>Advanced analytics and performance insights</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Call to Action -->
                        <div class="coming-soon-cta">
                            <p class="mb-4">Want to be notified when AI Sensei launches?</p>
                            <div class="cta-buttons">
                                <a href="{{ route('contact') }}" class="btn btn-primary btn-lg me-3">
                                    <i class="fas fa-envelope"></i> Get Notified
                                </a>
                                <a href="{{ route('home') }}" class="btn btn-outline-primary btn-lg">
                                    <i class="fas fa-arrow-left"></i> Back to Home
                                </a>
                            </div>
                        </div>
                        
                        <!-- Progress Indicator -->
                        <div class="development-progress">
                            <div class="progress-header">
                                <h5>Development Progress</h5>
                                <span class="progress-percentage">75%</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <p class="progress-note mt-2">Expected launch: Q1 2025</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</x-layouts.frontend>

@push('styles')
<style>
.coming-soon-section {
    min-height: 100vh;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    padding: 100px 0;
    color: white;
    position: relative;
    overflow: hidden;
}

.coming-soon-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.05"/><circle cx="75" cy="25" r="1" fill="white" opacity="0.05"/><circle cx="25" cy="75" r="1" fill="white" opacity="0.05"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.05"/><circle cx="50" cy="50" r="1" fill="white" opacity="0.05"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    pointer-events: none;
}

.coming-soon-content {
    position: relative;
    z-index: 2;
}

.coming-soon-icon {
    font-size: 120px;
    margin-bottom: 30px;
    opacity: 0.9;
    animation: float 3s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

.coming-soon-title {
    font-size: 4rem;
    font-weight: 800;
    margin-bottom: 10px;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
}

.coming-soon-subtitle {
    font-size: 2.5rem;
    font-weight: 300;
    margin-bottom: 30px;
    opacity: 0.9;
}

.coming-soon-description {
    font-size: 1.25rem;
    line-height: 1.6;
    margin-bottom: 50px;
    opacity: 0.95;
}

.features-preview {
    margin-bottom: 50px;
}

.feature-item {
    background: rgba(255, 255, 255, 0.1);
    padding: 30px 20px;
    border-radius: 15px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    height: 100%;
    transition: transform 0.3s ease, background 0.3s ease;
}

.feature-item:hover {
    transform: translateY(-5px);
    background: rgba(255, 255, 255, 0.15);
}

.feature-item i {
    font-size: 2.5rem;
    margin-bottom: 15px;
    color: #fff;
}

.feature-item h4 {
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 10px;
}

.feature-item p {
    font-size: 0.95rem;
    opacity: 0.9;
    margin: 0;
}

.coming-soon-cta {
    margin-bottom: 40px;
}

.cta-buttons .btn {
    border-radius: 50px;
    padding: 15px 30px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
}

.btn-primary {
    background: rgba(255, 255, 255, 0.2);
    border: 2px solid rgba(255, 255, 255, 0.3);
    color: white;
}

.btn-primary:hover {
    background: rgba(255, 255, 255, 0.3);
    border-color: rgba(255, 255, 255, 0.5);
    transform: translateY(-2px);
}

.btn-outline-primary {
    background: transparent;
    border: 2px solid rgba(255, 255, 255, 0.5);
    color: white;
}

.btn-outline-primary:hover {
    background: rgba(255, 255, 255, 0.1);
    border-color: rgba(255, 255, 255, 0.7);
    transform: translateY(-2px);
    color: white;
}

.development-progress {
    background: rgba(255, 255, 255, 0.1);
    padding: 25px;
    border-radius: 15px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    max-width: 400px;
    margin: 0 auto;
}

.progress-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.progress-header h5 {
    margin: 0;
    font-weight: 600;
}

.progress-percentage {
    font-size: 1.25rem;
    font-weight: 700;
}

.progress {
    height: 10px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 5px;
    overflow: hidden;
}

.progress-bar {
    background: linear-gradient(90deg, #00d4ff, #00ff88);
    border-radius: 5px;
    transition: width 1s ease-in-out;
    animation: pulse 2s ease-in-out infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.8; }
}

.progress-note {
    margin: 0;
    font-size: 0.9rem;
    opacity: 0.8;
    text-align: center;
}

@media (max-width: 768px) {
    .coming-soon-title {
        font-size: 2.5rem;
    }
    
    .coming-soon-subtitle {
        font-size: 1.8rem;
    }
    
    .coming-soon-icon {
        font-size: 80px;
    }
    
    .cta-buttons .btn {
        display: block;
        width: 100%;
        margin-bottom: 15px;
    }
    
    .cta-buttons .btn:last-child {
        margin-bottom: 0;
    }
}
</style>
@endpush