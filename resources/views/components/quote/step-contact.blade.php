<div class="quote-step" id="step4">
    <div class="step-header">
        <h2>Contact Information</h2>
        <p>We'll use this information to send your quote and get in touch about your project.</p>
    </div>

    <form id="contactForm">
        <div class="form-section">
            <h3>
                <div class="form-section-icon"><i class="fas fa-user"></i></div>
                Your Details
            </h3>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="firstName">First Name *</label>
                    <input type="text" class="form-input" id="firstName" name="firstName" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="lastName">Last Name *</label>
                    <input type="text" class="form-input" id="lastName" name="lastName" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="email">Email Address *</label>
                    <input type="email" class="form-input" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="phone">Phone Number</label>
                    <input type="tel" class="form-input" id="phone" name="phone"
                        placeholder="+233 XX XXX XXXX">
                </div>
            </div>
        </div>

        <div class="form-section">
            <h3>
                <div class="form-section-icon"><i class="fas fa-building"></i></div>
                Organization Details
            </h3>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="company">Organization Name</label>
                    <input type="text" class="form-input" id="company" name="company">
                </div>
                <div class="form-group">
                    <label class="form-label" for="position">Your Position</label>
                    <input type="text" class="form-input" id="position" name="position">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="website">Current Website</label>
                    <input type="url" class="form-input" id="website" name="website"
                        placeholder="https://yourwebsite.com">
                </div>
                <div class="form-group">
                    <label class="form-label" for="employees">Team Size</label>
                    <select class="form-select" id="employees" name="employees">
                        <option value="">Select team size</option>
                        <option value="1-10">1-10 people</option>
                        <option value="11-50">11-50 people</option>
                        <option value="51-200">51-200 people</option>
                        <option value="200+">200+ people</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="form-section">
            <h3>
                <div class="form-section-icon"><i class="fas fa-cog"></i></div>
                Project Preferences
            </h3>

            <div class="form-group">
                <label class="form-label" for="communication">Preferred Communication Method</label>
                <select class="form-select" id="communication" name="communication">
                    <option value="email">Email</option>
                    <option value="phone">Phone Call</option>
                    <option value="video">Video Call</option>
                    <option value="whatsapp">WhatsApp</option>
                    <option value="in-person">In-person Meeting</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label" for="availability">Best Time to Contact</label>
                <input type="text" class="form-input" id="availability" name="availability"
                    placeholder="e.g., Weekdays 9am-5pm, Evenings after 6pm">
            </div>

            <div class="form-group">
                <label class="form-label" for="additionalInfo">Additional Information</label>
                <textarea class="form-textarea" id="additionalInfo" name="additionalInfo"
                    placeholder="Anything else you'd like us to know about your project or requirements?"></textarea>
            </div>
        </div>
    </form>

    <div class="btn-navigation">
        <button class="btn-secondary" onclick="prevStep()">
            <i class="fas fa-arrow-left"></i> Previous
        </button>
        <button class="btn-quote" onclick="nextStep()">
            Review Quote <i class="fas fa-arrow-right"></i>
        </button>
    </div>
</div>