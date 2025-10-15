<div class="quote-step" id="step5">
    <div class="step-header">
        <h2>Review Your Quote Request</h2>
        <p>Please review all the information below before submitting your quote request.</p>
    </div>

    <div class="quote-summary" id="quoteSummary">
        <div class="summary-header">
            <h3><i class="fas fa-file-alt"></i> Quote Summary</h3>
            <p>Here's what we'll be quoting for you:</p>
        </div>

        <div class="summary-items" id="summaryItems">
            <!-- Summary items will be populated by JavaScript -->
        </div>
    </div>

    <div class="btn-navigation">
        <button type="button" class="btn-secondary" onclick="prevStep()">
            <i class="fas fa-arrow-left"></i> Previous
        </button>
        <button type="button" class="btn-quote" onclick="submitQuote()" id="submitBtn">
            <i class="fas fa-paper-plane"></i> Submit Quote Request
        </button>
    </div>
</div>