<div class="quote-step" id="step4">
    <div class="step-header">
        <h2>Contact Information</h2>
        <p>We'll use this information to send your quote and get in touch about your project.</p>
    </div>

    <div class="form-section">
        <h3>
            <div class="form-section-icon"><i class="fas fa-user"></i></div>
            Your Details
        </h3>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="firstName">First Name *</label>
                <input type="text" class="form-input" id="firstName" name="firstName" required value="{{ old('firstName') }}">
                @error('firstName')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="lastName">Last Name *</label>
                <input type="text" class="form-input" id="lastName" name="lastName" required value="{{ old('lastName') }}">
                @error('lastName')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="email">Email Address *</label>
                <input type="email" class="form-input" id="email" name="email" required value="{{ old('email') }}">
                @error('email')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="phone">Phone Number</label>
                <input type="tel" class="form-input" id="phone" name="phone"
                    placeholder="+233 XX XXX XXXX" value="{{ old('phone') }}">
                @error('phone')
                    <span class="form-error">{{ $message }}</span>
                @enderror
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
                <input type="text" class="form-input" id="company" name="company" value="{{ old('company') }}">
                @error('company')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="position">Your Position</label>
                <input type="text" class="form-input" id="position" name="position" value="{{ old('position') }}">
                @error('position')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="website">Current Website</label>
                <input type="url" class="form-input" id="website" name="website"
                    placeholder="https://yourwebsite.com" value="{{ old('website') }}">
                @error('website')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="employees">Team Size</label>
                <select class="form-select" id="employees" name="employees">
                    <option value="">Select team size</option>
                    <option value="1-10" {{ old('employees') == '1-10' ? 'selected' : '' }}>1-10 people</option>
                    <option value="11-50" {{ old('employees') == '11-50' ? 'selected' : '' }}>11-50 people</option>
                    <option value="51-200" {{ old('employees') == '51-200' ? 'selected' : '' }}>51-200 people</option>
                    <option value="200+" {{ old('employees') == '200+' ? 'selected' : '' }}>200+ people</option>
                </select>
                @error('employees')
                    <span class="form-error">{{ $message }}</span>
                @enderror
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
                <option value="email" {{ old('communication') == 'email' ? 'selected' : '' }}>Email</option>
                <option value="phone" {{ old('communication') == 'phone' ? 'selected' : '' }}>Phone Call</option>
                <option value="video" {{ old('communication') == 'video' ? 'selected' : '' }}>Video Call</option>
                <option value="whatsapp" {{ old('communication') == 'whatsapp' ? 'selected' : '' }}>WhatsApp</option>
                <option value="in-person" {{ old('communication') == 'in-person' ? 'selected' : '' }}>In-person Meeting</option>
            </select>
            @error('communication')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="availability">Best Time to Contact</label>
            <input type="text" class="form-input" id="availability" name="availability"
                placeholder="e.g., Weekdays 9am-5pm, Evenings after 6pm" value="{{ old('availability') }}">
            @error('availability')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="additionalInfo">Additional Information</label>
            <textarea class="form-textarea" id="additionalInfo" name="additionalInfo"
                placeholder="Anything else you'd like us to know about your project or requirements?">{{ old('additionalInfo') }}</textarea>
            @error('additionalInfo')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="btn-navigation">
        <button type="button" class="btn-secondary" onclick="prevStep()">
            <i class="fas fa-arrow-left"></i> Previous
        </button>
        <button type="button" class="btn-quote" onclick="nextStep()">
            Review Quote <i class="fas fa-arrow-right"></i>
        </button>
    </div>
</div>