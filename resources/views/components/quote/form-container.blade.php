<!-- Quote Form Container -->
<div class="quote-container">
    <!-- Progress Indicator -->
    <div class="quote-progress">
        <div class="progress-step active" data-step="1">
            <i class="fas fa-tasks"></i>
            <span>Service</span>
        </div>
        <div class="progress-step" data-step="2">
            <i class="fas fa-info-circle"></i>
            <span>Details</span>
        </div>
        <div class="progress-step" data-step="3">
            <i class="fas fa-dollar-sign"></i>
            <span>Budget</span>
        </div>
        <div class="progress-step" data-step="4">
            <i class="fas fa-user"></i>
            <span>Contact</span>
        </div>
        <div class="progress-step" data-step="5">
            <i class="fas fa-check"></i>
            <span>Review</span>
        </div>
    </div>

    <!-- Wrap all steps in a single form -->
    <form id="quoteForm" action="{{ route('forms.submit', 'request-quote') }}" method="POST">
        @csrf
        
        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="alert alert-success" style="margin: 20px; padding: 20px; background: #d1e7dd; border: 2px solid #badbcc; border-radius: 12px; color: #0f5132;">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger" style="margin: 20px; padding: 20px; background: #f8d7da; border: 2px solid #f5c2c7; border-radius: 12px; color: #842029;">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger" style="margin: 20px; padding: 20px; background: #f8d7da; border: 2px solid #f5c2c7; border-radius: 12px; color: #842029;">
                <strong><i class="fas fa-exclamation-triangle"></i> Please fix the following errors:</strong>
                <ul style="margin: 10px 0 0 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <!-- Quote Form Content -->
        <div class="quote-content">
            <!-- Step 1: Service Selection -->
            <x-quote.step-service />
            
            <!-- Step 2: Project Details -->
            <x-quote.step-details />
            
            <!-- Step 3: Budget & Timeline -->
            <x-quote.step-budget-timeline />
            
            <!-- Step 4: Contact Information -->
            <x-quote.step-contact />
            
            <!-- Step 5: Review & Submit -->
            <x-quote.step-review />
            
            <!-- Success Message -->
            <x-quote.step-success />
        </div>
    </form>
</div>

<!-- Add some spacing after the quote container -->
<div style="padding: 80px 0;"></div>