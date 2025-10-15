<div class="quote-step" id="step2">
    <div class="step-header">
        <h2>Tell us about your project</h2>
        <p>The more details you provide, the more accurate your quote will be.</p>
    </div>

    <form id="projectDetailsForm">
        <div class="form-section">
            <h3>
                <div class="form-section-icon"><i class="fas fa-project-diagram"></i></div>
                Project Overview
            </h3>

            <div class="form-group">
                <label class="form-label" for="projectTitle">Project Title</label>
                <input type="text" class="form-input" id="projectTitle" name="projectTitle"
                    placeholder="Give your project a name" required value="{{ old('projectTitle') }}">
                @error('projectTitle')
                    <span class="text-danger" style="font-size: 14px; color: #dc3545;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="projectDescription">Project Description</label>
                <textarea class="form-textarea" id="projectDescription" name="projectDescription"
                    placeholder="Describe your project in detail. What are your goals? What problems are you trying to solve?"
                    required>{{ old('projectDescription') }}</textarea>
                @error('projectDescription')
                    <span class="text-danger" style="font-size: 14px; color: #dc3545;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="targetAudience">Target Audience</label>
                    <input type="text" class="form-input" id="targetAudience" name="targetAudience"
                        placeholder="Who is your target audience?" value="{{ old('targetAudience') }}">
                    @error('targetAudience')
                        <span class="text-danger" style="font-size: 14px; color: #dc3545;">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="form-label" for="industry">Industry</label>
                    <select class="form-select" id="industry" name="industry">
                        <option value="">Select your industry</option>
                        <option value="nonprofit">Non-profit</option>
                        <option value="healthcare">Healthcare</option>
                        <option value="education">Education</option>
                        <option value="technology">Technology</option>
                        <option value="retail">Retail/E-commerce</option>
                        <option value="finance">Finance</option>
                        <option value="real-estate">Real Estate</option>
                        <option value="hospitality">Hospitality</option>
                        <option value="manufacturing">Manufacturing</option>
                        <option value="other">Other</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="form-section">
            <h3>
                <div class="form-section-icon"><i class="fas fa-cogs"></i></div>
                Technical Requirements
            </h3>

            <div class="form-group">
                <label class="form-label" for="features">Required Features</label>
                <textarea class="form-textarea" id="features" name="features"
                    placeholder="List the specific features and functionality you need (e.g., user login, payment processing, booking system, etc.)"></textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="platforms">Preferred Platforms</label>
                    <select class="form-select" id="platforms" name="platforms" multiple>
                        <option value="web">Web Browser</option>
                        <option value="ios">iOS App</option>
                        <option value="android">Android App</option>
                        <option value="desktop">Desktop Application</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" for="integrations">Third-party Integrations</label>
                    <input type="text" class="form-input" id="integrations" name="integrations"
                        placeholder="Payment gateways, CRM, email marketing, etc.">
                </div>
            </div>
        </div>

        <div class="form-section">
            <h3>
                <div class="form-section-icon"><i class="fas fa-upload"></i></div>
                Additional Materials
            </h3>

            <div class="file-upload" id="fileUpload">
                <div class="file-upload-icon">
                    <i class="fas fa-cloud-upload-alt"></i>
                </div>
                <div class="file-upload-text">Drop files here or click to browse</div>
                <div class="file-upload-hint">Upload mockups, wireframes, inspiration, or any reference
                    materials (Max 10MB per file)</div>
                <input type="file" id="fileInput" multiple style="display: none;"
                    accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.gif,.sketch,.fig,.xd">
            </div>
            <div class="uploaded-files" id="uploadedFiles"></div>
        </div>
    </form>

    <div class="btn-navigation">
        <button type="button" class="btn-secondary" onclick="prevStep()">
            <i class="fas fa-arrow-left"></i> Previous
        </button>
        <button type="button" class="btn-quote" onclick="nextStep()">
            Next Step <i class="fas fa-arrow-right"></i>
        </button>
    </div>
</div>