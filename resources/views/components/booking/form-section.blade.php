<!-- Custom Booking Form Section -->
<section class="booking-section" id="calendar">
    <div class="booking-container">
        <div class="booking-wrapper">
            <div class="booking-form-header">
                <h2>Schedule Your Consultation</h2>
                <p>Fill out the form below and we'll get back to you within 24 hours to confirm your appointment</p>
            </div>

            <!-- Success Message -->
            <div class="success-message" id="successMessage">
                <i class="fas fa-check-circle"></i>
                <h3>Request Received!</h3>
                <p>Thank you for booking a consultation. We'll contact you within 24 hours to confirm your preferred
                    time slot.</p>
            </div>

            <!-- Booking Form -->
            <form class="booking-form" id="bookingForm">
                <div class="form-row">
                    <div class="form-group">
                        <label for="firstName">First Name <span class="required">*</span></label>
                        <input type="text" id="firstName" name="firstName" required placeholder="John">
                    </div>
                    <div class="form-group">
                        <label for="lastName">Last Name <span class="required">*</span></label>
                        <input type="text" id="lastName" name="lastName" required placeholder="Doe">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="email">Email Address <span class="required">*</span></label>
                        <input type="email" id="email" name="email" required placeholder="john@example.com">
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone Number <span class="required">*</span></label>
                        <input type="tel" id="phone" name="phone" required placeholder="+233 XX XXX XXXX">
                    </div>
                </div>

                <div class="form-group">
                    <label for="meetingType">Meeting Type <span class="required">*</span></label>
                    <select id="meetingType" name="meetingType" required>
                        <option value="">Select a meeting type</option>
                        <option value="discovery">Discovery Call (30 minutes)</option>
                        <option value="technical">Technical Consultation (45 minutes)</option>
                        <option value="project">Project Discussion (60 minutes)</option>
                    </select>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="preferredDate">Preferred Date <span class="required">*</span></label>
                        <input type="date" id="preferredDate" name="preferredDate" required>
                    </div>
                    <div class="form-group">
                        <label for="preferredTime">Preferred Time <span class="required">*</span></label>
                        <select id="preferredTime" name="preferredTime" required>
                            <option value="">Select a time slot</option>
                            <option value="09:00">09:00 AM</option>
                            <option value="10:00">10:00 AM</option>
                            <option value="11:00">11:00 AM</option>
                            <option value="12:00">12:00 PM</option>
                            <option value="14:00">02:00 PM</option>
                            <option value="15:00">03:00 PM</option>
                            <option value="16:00">04:00 PM</option>
                            <option value="17:00">05:00 PM</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="timezone">Your Timezone <span class="required">*</span></label>
                    <select id="timezone" name="timezone" required>
                        <option value="">Select your timezone</option>
                        <option value="GMT">GMT (Ghana)</option>
                        <option value="WAT">WAT (West Africa Time)</option>
                        <option value="EST">EST (Eastern Standard Time)</option>
                        <option value="PST">PST (Pacific Standard Time)</option>
                        <option value="CET">CET (Central European Time)</option>
                        <option value="BST">BST (British Summer Time)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="projectDetails">Tell us about your project</label>
                    <textarea id="projectDetails" name="projectDetails"
                        placeholder="Briefly describe your project, goals, and any specific requirements..."></textarea>
                </div>

                <button type="submit" class="submit-btn">
                    <i class="fas fa-calendar-check"></i> Schedule Consultation
                </button>

                <p class="form-note">
                    <i class="fas fa-lock"></i>
                    Your information is secure and will only be used to contact you about your consultation.
                </p>
            </form>
        </div>
    </div>
</section>