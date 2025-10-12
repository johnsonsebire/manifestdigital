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
</div>

<!-- Add some spacing after the quote container -->
<div style="padding: 80px 0;"></div>