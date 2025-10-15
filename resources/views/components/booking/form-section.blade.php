<!-- Custom Booking Form Section -->
<section class="booking-section" id="calendar">
    <div class="booking-container">
        <div class="booking-wrapper">
            <div class="booking-form-header">
                <h2>Schedule Your Consultation</h2>
                <p>Fill out the form below and we'll get back to you within 24 hours to confirm your appointment</p>
            </div>

            @if(session('success'))
                <!-- Success Message -->
                <div class="success-message" id="successMessage" style="display: block;">
                    <i class="fas fa-check-circle"></i>
                    <h3>Request Received!</h3>
                    <p>{{ session('success') }}</p>
                </div>
            @elseif(session('error'))
                <!-- Error Message -->
                <div class="error-message" style="display: block; background: #fee; border-color: #f88; color: #c33;">
                    <i class="fas fa-exclamation-circle"></i>
                    <h3>Submission Error</h3>
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            <!-- Booking Form -->
            <form class="booking-form" id="bookingForm" action="{{ route('forms.submit', 'book-a-call') }}" method="POST">
                @csrf
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="firstName">First Name <span class="required">*</span></label>
                        <input type="text" id="firstName" name="firstName" value="{{ old('firstName') }}" required placeholder="John" class="@error('firstName') is-invalid @enderror">
                        @error('firstName')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="lastName">Last Name <span class="required">*</span></label>
                        <input type="text" id="lastName" name="lastName" value="{{ old('lastName') }}" required placeholder="Doe" class="@error('lastName') is-invalid @enderror">
                        @error('lastName')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="email">Email Address <span class="required">*</span></label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="john@example.com" class="@error('email') is-invalid @enderror">
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone Number <span class="required">*</span></label>
                        <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required placeholder="+233 XX XXX XXXX" class="@error('phone') is-invalid @enderror">
                        @error('phone')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="meetingType">Meeting Type <span class="required">*</span></label>
                    <select id="meetingType" name="meetingType" required class="@error('meetingType') is-invalid @enderror">
                        <option value="">Select a meeting type</option>
                        <option value="discovery" {{ old('meetingType') == 'discovery' ? 'selected' : '' }}>Discovery Call (30 minutes)</option>
                        <option value="technical" {{ old('meetingType') == 'technical' ? 'selected' : '' }}>Technical Consultation (45 minutes)</option>
                        <option value="project" {{ old('meetingType') == 'project' ? 'selected' : '' }}>Project Discussion (60 minutes)</option>
                    </select>
                    @error('meetingType')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="preferredDate">Preferred Date <span class="required">*</span></label>
                        <input type="date" id="preferredDate" name="preferredDate" value="{{ old('preferredDate') }}" required class="@error('preferredDate') is-invalid @enderror">
                        @error('preferredDate')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="preferredTime">Preferred Time <span class="required">*</span></label>
                        <select id="preferredTime" name="preferredTime" required class="@error('preferredTime') is-invalid @enderror">
                            <option value="">Select a time slot</option>
                            <option value="09:00" {{ old('preferredTime') == '09:00' ? 'selected' : '' }}>09:00 AM</option>
                            <option value="10:00" {{ old('preferredTime') == '10:00' ? 'selected' : '' }}>10:00 AM</option>
                            <option value="11:00" {{ old('preferredTime') == '11:00' ? 'selected' : '' }}>11:00 AM</option>
                            <option value="12:00" {{ old('preferredTime') == '12:00' ? 'selected' : '' }}>12:00 PM</option>
                            <option value="14:00" {{ old('preferredTime') == '14:00' ? 'selected' : '' }}>02:00 PM</option>
                            <option value="15:00" {{ old('preferredTime') == '15:00' ? 'selected' : '' }}>03:00 PM</option>
                            <option value="16:00" {{ old('preferredTime') == '16:00' ? 'selected' : '' }}>04:00 PM</option>
                            <option value="17:00" {{ old('preferredTime') == '17:00' ? 'selected' : '' }}>05:00 PM</option>
                        </select>
                        @error('preferredTime')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="timezone">Your Timezone <span class="required">*</span></label>
                    <select id="timezone" name="timezone" required class="@error('timezone') is-invalid @enderror">
                        <option value="">Select your timezone</option>
                        <option value="GMT" {{ old('timezone') == 'GMT' ? 'selected' : '' }}>GMT (Ghana)</option>
                        <option value="WAT" {{ old('timezone') == 'WAT' ? 'selected' : '' }}>WAT (West Africa Time)</option>
                        <option value="EST" {{ old('timezone') == 'EST' ? 'selected' : '' }}>EST (Eastern Standard Time)</option>
                        <option value="PST" {{ old('timezone') == 'PST' ? 'selected' : '' }}>PST (Pacific Standard Time)</option>
                        <option value="CET" {{ old('timezone') == 'CET' ? 'selected' : '' }}>CET (Central European Time)</option>
                        <option value="BST" {{ old('timezone') == 'BST' ? 'selected' : '' }}>BST (British Summer Time)</option>
                    </select>
                    @error('timezone')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="projectDetails">Tell us about your project</label>
                    <textarea id="projectDetails" name="projectDetails" placeholder="Briefly describe your project, goals, and any specific requirements..." class="@error('projectDetails') is-invalid @enderror">{{ old('projectDetails') }}</textarea>
                    @error('projectDetails')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('bookingForm');
    if (form) {
        console.log('Form found, action:', form.action);
        form.addEventListener('submit', function(e) {
            console.log('Form submitting to:', this.action);
            console.log('Form method:', this.method);
            console.log('Form data:', new FormData(this));
        });
    } else {
        console.error('Booking form not found!');
    }
});
</script>