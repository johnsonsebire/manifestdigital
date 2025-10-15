<div class="quote-step" id="step3">
    <div class="step-header">
        <h2>Budget & Timeline</h2>
        <p>Help us understand your budget range and project timeline to provide the most accurate quote.</p>
    </div>

    <!-- Hidden inputs to store selections -->
    <input type="hidden" name="budget" id="budgetInput" value="">
    <input type="hidden" name="timeline" id="timelineInput" value="">

    <div class="form-section">
        <h3>
            <div class="form-section-icon"><i class="fas fa-dollar-sign"></i></div>
            Project Budget
        </h3>

        <div class="budget-options" id="budgetOptions">
            <div class="budget-option" data-budget="under-5k">
                <div class="check-icon"><i class="fas fa-check"></i></div>
                <div class="budget-amount">Under GH₵5,000</div>
                <div class="budget-description">Small projects, basic websites</div>
            </div>
            <div class="budget-option" data-budget="5k-15k">
                <div class="check-icon"><i class="fas fa-check"></i></div>
                <div class="budget-amount">GH₵5,000 - GH₵15,000</div>
                <div class="budget-description">Medium projects, custom features</div>
            </div>
            <div class="budget-option" data-budget="15k-30k">
                <div class="check-icon"><i class="fas fa-check"></i></div>
                <div class="budget-amount">GH₵15,000 - GH₵30,000</div>
                <div class="budget-description">Large projects, complex systems</div>
            </div>
            <div class="budget-option" data-budget="30k-plus">
                <div class="check-icon"><i class="fas fa-check"></i></div>
                <div class="budget-amount">GH₵30,000+</div>
                <div class="budget-description">Enterprise solutions</div>
            </div>
            <div class="budget-option" data-budget="flexible">
                <div class="check-icon"><i class="fas fa-check"></i></div>
                <div class="budget-amount">I'm flexible</div>
                <div class="budget-description">Show me options</div>
            </div>
        </div>
    </div>

    <div class="form-section">
        <h3>
            <div class="form-section-icon"><i class="fas fa-calendar-alt"></i></div>
            Project Timeline
        </h3>

        <div class="timeline-options" id="timelineOptions">
            <div class="timeline-option" data-timeline="asap">
                <div class="check-icon"><i class="fas fa-check"></i></div>
                <div class="timeline-period">ASAP</div>
                <div class="timeline-description">Rush delivery</div>
            </div>
            <div class="timeline-option" data-timeline="1-month">
                <div class="check-icon"><i class="fas fa-check"></i></div>
                <div class="timeline-period">1 Month</div>
                <div class="timeline-description">Quick turnaround</div>
            </div>
            <div class="timeline-option" data-timeline="2-3-months">
                <div class="check-icon"><i class="fas fa-check"></i></div>
                <div class="timeline-period">2-3 Months</div>
                <div class="timeline-description">Standard timeline</div>
            </div>
            <div class="timeline-option" data-timeline="3-6-months">
                <div class="check-icon"><i class="fas fa-check"></i></div>
                <div class="timeline-period">3-6 Months</div>
                <div class="timeline-description">Complex project</div>
            </div>
            <div class="timeline-option" data-timeline="6-plus-months">
                <div class="check-icon"><i class="fas fa-check"></i></div>
                <div class="timeline-period">6+ Months</div>
                <div class="timeline-description">Long-term project</div>
            </div>
            <div class="timeline-option" data-timeline="flexible">
                <div class="check-icon"><i class="fas fa-check"></i></div>
                <div class="timeline-period">Flexible</div>
                <div class="timeline-description">No rush</div>
            </div>
        </div>
    </div>

    <div class="btn-navigation">
        <button type="button" class="btn-secondary" onclick="prevStep()">
            <i class="fas fa-arrow-left"></i> Previous
        </button>
        <button type="button" class="btn-quote" onclick="nextStep()">
            Next Step <i class="fas fa-arrow-right"></i>
        </button>
    </div>
</div>