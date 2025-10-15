<x-layouts.inner-pages :title="'Team Profile Form - Manifest Digital'" 
:preloader="'none'" :transparentHeader="true" :notificationStyle="'detailed'">
    <!-- Team Profile Form Section -->
    <section class="form-section">
        <div class="container">
            <div class="form-header">
                <h1>Team <span class="highlight">Profile</span> Submission</h1>
                <p class="section-subtitle">Complete the form below to create or update your team profile information</p>
            </div>
        </div>
    </section>
    
    <div class="container">
        <div class="team-profile-form">
            <form action="{{ route('forms.submit', 'team-profile') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="form-section-title">
                    <div class="form-section-icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <h3>Personal Information</h3>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="form-label">Full Name <span class="required">*</span></label>
                            <input type="text" id="name" name="name" class="form-control" required value="{{ old('name') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="role" class="form-label">Job Role/Position <span class="required">*</span></label>
                            <input type="text" id="role" name="role" class="form-control" required value="{{ old('role') }}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="photo" class="form-label">Profile Photo</label>
                            <input type="file" id="photo" name="photo" class="form-control">
                            <small class="form-text text-muted">Upload a professional headshot (JPEG or PNG, max 2MB)</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="id_key" class="form-label">Profile ID <span class="required">*</span></label>
                            <input type="text" id="id_key" name="id_key" class="form-control" required value="{{ old('id_key') }}">
                            <small class="form-text text-muted">Unique identifier (e.g., "john-doe", use lowercase with hyphens)</small>
                        </div>
                    </div>
                </div>

                <div class="form-section-title">
                    <div class="form-section-icon">
                        <i class="fas fa-address-card"></i>
                    </div>
                    <h3>Contact Information</h3>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="contact_email" class="form-label">Email <span class="required">*</span></label>
                            <input type="email" id="contact_email" name="contact_email" class="form-control" required value="{{ old('contact_email') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="contact_phone" class="form-label">Phone Number</label>
                            <input type="tel" id="contact_phone" name="contact_phone" class="form-control" value="{{ old('contact_phone') }}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="contact_location" class="form-label">Location</label>
                            <input type="text" id="contact_location" name="contact_location" class="form-control" value="{{ old('contact_location') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="contact_linkedin" class="form-label">LinkedIn Profile</label>
                            <input type="url" id="contact_linkedin" name="contact_linkedin" class="form-control" value="{{ old('contact_linkedin') }}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="contact_github" class="form-label">GitHub Profile</label>
                            <input type="url" id="contact_github" name="contact_github" class="form-control" value="{{ old('contact_github') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="contact_other_social" class="form-label">Other Social Media</label>
                            <input type="text" id="contact_other_social" name="contact_other_social" class="form-control" value="{{ old('contact_other_social') }}">
                            <small class="form-text text-muted">Format: platform:username (e.g., dribbble:username)</small>
                        </div>
                    </div>
                </div>

                <div class="form-section-title">
                    <div class="form-section-icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <h3>Professional Summary</h3>
                </div>

                <div class="form-group">
                    <label for="bio" class="form-label">Professional Bio <span class="required">*</span></label>
                    <textarea id="bio" name="bio" class="form-control" rows="6" required>{{ old('bio') }}</textarea>
                    <small class="form-text text-muted">Write a detailed professional bio (2-3 paragraphs recommended)</small>
                </div>

                <div class="form-section-title">
                    <div class="form-section-icon">
                        <i class="fas fa-tools"></i>
                    </div>
                    <h3>Skills</h3>
                </div>
                <p class="mb-4">Enter your key skills by category</p>

                <div id="skills-container">
                    <div class="skill-category-group">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="skill_category_1" class="form-label">Skill Category <span class="required">*</span></label>
                                    <input type="text" id="skill_category_1" name="skills[0][category]" class="form-control" required value="{{ old('skills.0.category') }}">
                                    <small class="form-text text-muted">E.g., "Programming Languages", "Design"</small>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="skill_items_1" class="form-label">Skills (comma separated) <span class="required">*</span></label>
                                    <input type="text" id="skill_items_1" name="skills[0][items]" class="form-control" required value="{{ old('skills.0.items') }}">
                                    <small class="form-text text-muted">E.g., "JavaScript, Python, PHP, SQL"</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="form-group text-end">
                    <button type="button" id="add-skill-category" class="btn btn-outline-primary">
                        <i class="fas fa-plus"></i> Add Another Skill Category
                    </button>
                </div>

                <div class="form-section-title">
                    <div class="form-section-icon">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <h3>Professional Experience</h3>
                </div>

                <div id="experience-container">
                    <div class="experience-item">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="experience_title_1" class="form-label">Position/Title <span class="required">*</span></label>
                                    <input type="text" id="experience_title_1" name="experience[0][title]" class="form-control" required value="{{ old('experience.0.title') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="experience_company_1" class="form-label">Company/Organization <span class="required">*</span></label>
                                    <input type="text" id="experience_company_1" name="experience[0][company]" class="form-control" required value="{{ old('experience.0.company') }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="experience_date_1" class="form-label">Duration <span class="required">*</span></label>
                                    <input type="text" id="experience_date_1" name="experience[0][duration]" class="form-control" required value="{{ old('experience.0.duration') }}">
                                    <small class="form-text text-muted">E.g., "2020 - Present", "2018 - 2020"</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="experience_location_1" class="form-label">Location</label>
                                    <input type="text" id="experience_location_1" name="experience[0][location]" class="form-control" value="{{ old('experience.0.location') }}">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="experience_description_1" class="form-label">Description <span class="required">*</span></label>
                            <textarea id="experience_description_1" name="experience[0][description]" class="form-control" rows="3" required>{{ old('experience.0.description') }}</textarea>
                            <small class="form-text text-muted">Describe your responsibilities and achievements in this role</small>
                        </div>
                    </div>
                </div>

                <div class="form-group text-end">
                    <button type="button" id="add-experience" class="btn btn-outline-primary">
                        <i class="fas fa-plus"></i> Add Another Experience
                    </button>
                </div>

                <div class="form-section-title">
                    <div class="form-section-icon">
                        <i class="fas fa-trophy"></i>
                    </div>
                    <h3>Key Achievements</h3>
                </div>

                <div id="achievements-container">
                    <div class="achievement-item">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="achievement_title_1" class="form-label">Achievement Title <span class="required">*</span></label>
                                    <input type="text" id="achievement_title_1" name="achievements[0][title]" class="form-control" required value="{{ old('achievements.0.title') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="achievement_year_1" class="form-label">Year</label>
                                    <input type="text" id="achievement_year_1" name="achievements[0][year]" class="form-control" value="{{ old('achievements.0.year') }}">
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="achievement_description_1" class="form-label">Description <span class="required">*</span></label>
                            <textarea id="achievement_description_1" name="achievements[0][description]" class="form-control" rows="2" required>{{ old('achievements.0.description') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="form-group text-end">
                    <button type="button" id="add-achievement" class="btn btn-outline-primary">
                        <i class="fas fa-plus"></i> Add Another Achievement
                    </button>
                </div>

                <!-- Hidden fields for JSON serialized data -->
                <input type="hidden" name="skills" id="skills_json">
                <input type="hidden" name="experience" id="experience_json">
                <input type="hidden" name="achievements" id="achievements_json">

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary btn-lg" id="submitProfileBtn">Submit Profile</button>
                    <button type="reset" class="btn btn-outline-secondary btn-lg">Reset Form</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Add some spacing after the form container -->
    <div style="padding: 80px 0;"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            
            // Serialize array fields to JSON before form submission
            form.addEventListener('submit', function(e) {
                // Collect skills
                const skills = [];
                document.querySelectorAll('.skill-category-group').forEach(group => {
                    const categoryInput = group.querySelector('input[name*="[category]"]');
                    const itemsInput = group.querySelector('input[name*="[items]"]');
                    
                    if (categoryInput && itemsInput && categoryInput.value && itemsInput.value) {
                        skills.push({
                            category: categoryInput.value,
                            items: itemsInput.value
                        });
                    }
                });
                document.getElementById('skills_json').value = JSON.stringify(skills);
                
                // Collect experience
                const experiences = [];
                document.querySelectorAll('.experience-item').forEach(item => {
                    const titleInput = item.querySelector('input[name*="[title]"]');
                    const companyInput = item.querySelector('input[name*="[company]"]');
                    const durationInput = item.querySelector('input[name*="[duration]"]');
                    const locationInput = item.querySelector('input[name*="[location]"]');
                    const descriptionInput = item.querySelector('textarea[name*="[description]"]');
                    
                    if (titleInput && companyInput && durationInput && descriptionInput) {
                        experiences.push({
                            title: titleInput.value,
                            company: companyInput.value,
                            duration: durationInput.value,
                            location: locationInput ? locationInput.value : '',
                            description: descriptionInput.value
                        });
                    }
                });
                document.getElementById('experience_json').value = JSON.stringify(experiences);
                
                // Collect achievements
                const achievements = [];
                document.querySelectorAll('.achievement-item').forEach(item => {
                    const titleInput = item.querySelector('input[name*="[title]"]');
                    const yearInput = item.querySelector('input[name*="[year]"]');
                    const descriptionInput = item.querySelector('textarea[name*="[description]"]');
                    
                    if (titleInput && descriptionInput) {
                        achievements.push({
                            title: titleInput.value,
                            year: yearInput ? yearInput.value : '',
                            description: descriptionInput.value
                        });
                    }
                });
                document.getElementById('achievements_json').value = JSON.stringify(achievements);
            });
            
            // Add more skill categories
            let skillIndex = 1;
            document.getElementById('add-skill-category').addEventListener('click', function() {
                const skillsContainer = document.getElementById('skills-container');
                const newSkillGroup = document.createElement('div');
                newSkillGroup.className = 'skill-category-group mt-3';
                
                newSkillGroup.innerHTML = `
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="skill_category_${skillIndex + 1}" class="form-label">Skill Category <span class="required">*</span></label>
                                <input type="text" id="skill_category_${skillIndex + 1}" name="skills[${skillIndex}][category]" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="skill_items_${skillIndex + 1}" class="form-label">Skills (comma separated) <span class="required">*</span></label>
                                <input type="text" id="skill_items_${skillIndex + 1}" name="skills[${skillIndex}][items]" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-outline-danger remove-skill" style="margin-top: 30px;">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                `;
                
                skillsContainer.appendChild(newSkillGroup);
                skillIndex++;

                // Add event listener to the remove button
                newSkillGroup.querySelector('.remove-skill').addEventListener('click', function() {
                    newSkillGroup.remove();
                });
            });

            // Add more experience items
            let experienceIndex = 1;
            document.getElementById('add-experience').addEventListener('click', function() {
                const experienceContainer = document.getElementById('experience-container');
                const newExperience = document.createElement('div');
                newExperience.className = 'experience-item mt-4 pt-3 border-top';
                
                newExperience.innerHTML = `
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h4 class="mb-0">Additional Experience</h4>
                        <button type="button" class="btn btn-outline-danger remove-experience">
                            <i class="fas fa-times"></i> Remove
                        </button>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="experience_title_${experienceIndex + 1}" class="form-label">Position/Title <span class="required">*</span></label>
                                <input type="text" id="experience_title_${experienceIndex + 1}" name="experience[${experienceIndex}][title]" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="experience_company_${experienceIndex + 1}" class="form-label">Company/Organization <span class="required">*</span></label>
                                <input type="text" id="experience_company_${experienceIndex + 1}" name="experience[${experienceIndex}][company]" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="experience_date_${experienceIndex + 1}" class="form-label">Duration <span class="required">*</span></label>
                                <input type="text" id="experience_date_${experienceIndex + 1}" name="experience[${experienceIndex}][duration]" class="form-control" required>
                                <small class="form-text text-muted">E.g., "2020 - Present", "2018 - 2020"</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="experience_location_${experienceIndex + 1}" class="form-label">Location</label>
                                <input type="text" id="experience_location_${experienceIndex + 1}" name="experience[${experienceIndex}][location]" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="experience_description_${experienceIndex + 1}" class="form-label">Description <span class="required">*</span></label>
                        <textarea id="experience_description_${experienceIndex + 1}" name="experience[${experienceIndex}][description]" class="form-control" rows="3" required></textarea>
                    </div>
                `;
                
                experienceContainer.appendChild(newExperience);
                experienceIndex++;

                // Add event listener to the remove button
                newExperience.querySelector('.remove-experience').addEventListener('click', function() {
                    newExperience.remove();
                });
            });

            // Add more achievement items
            let achievementIndex = 1;
            document.getElementById('add-achievement').addEventListener('click', function() {
                const achievementsContainer = document.getElementById('achievements-container');
                const newAchievement = document.createElement('div');
                newAchievement.className = 'achievement-item mt-4 pt-3 border-top';
                
                newAchievement.innerHTML = `
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h4 class="mb-0">Additional Achievement</h4>
                        <button type="button" class="btn btn-outline-danger remove-achievement">
                            <i class="fas fa-times"></i> Remove
                        </button>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="achievement_title_${achievementIndex + 1}" class="form-label">Achievement Title <span class="required">*</span></label>
                                <input type="text" id="achievement_title_${achievementIndex + 1}" name="achievements[${achievementIndex}][title]" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="achievement_year_${achievementIndex + 1}" class="form-label">Year</label>
                                <input type="text" id="achievement_year_${achievementIndex + 1}" name="achievements[${achievementIndex}][year]" class="form-control">
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="achievement_description_${achievementIndex + 1}" class="form-label">Description <span class="required">*</span></label>
                        <textarea id="achievement_description_${achievementIndex + 1}" name="achievements[${achievementIndex}][description]" class="form-control" rows="2" required></textarea>
                    </div>
                `;
                
                achievementsContainer.appendChild(newAchievement);
                achievementIndex++;

                // Add event listener to the remove button
                newAchievement.querySelector('.remove-achievement').addEventListener('click', function() {
                    newAchievement.remove();
                });
            });
        });
    </script>

    <style>
        /* Hero section styling to match quote-request */
        .form-section {
            padding: 80px 0;
            position: relative;
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            color: white;
            overflow: hidden;
            margin-bottom: -40px;
        }
        
        .form-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('../manifest-template/images/decorative/hero_left_mem_dots_f_circle3.svg') no-repeat left center,
                url('../manifest-template/images/decorative/hero_right_circle-con3.svg') no-repeat right center;
            background-size: 300px, 250px;
            opacity: 0.1;
            z-index: 1;
        }
        
        .form-header {
            text-align: center;
            margin-bottom: 40px;
            position: relative;
            z-index: 2;
            max-width: 800px;
            margin: 0 auto 40px;
            padding: 0 20px;
        }
        
        .form-header h1 {
            font-family: 'Anybody', sans-serif;
            font-weight: 800;
            font-size: 48px;
            margin-bottom: 24px;
            line-height: 1.2;
        }
        
        .form-header .section-subtitle {
            font-size: 20px;
            opacity: 0.9;
            margin-bottom: 40px;
            line-height: 1.6;
        }
        
        .highlight {
            background: linear-gradient(135deg, #FF4900, #FF6B3D);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .form-section-title {
            margin: 30px 0 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e9ecef;
            font-family: 'Anybody', sans-serif;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .team-profile-form {
            max-width: 1000px;
            margin: -40px auto 0;
            background: #fff;
            padding: 50px 60px;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 3;
        }
        
        .form-group {
            margin-bottom: 24px;
        }
        
        .form-control {
            width: 100%;
            padding: 16px 20px;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            font-family: 'Anybody', sans-serif;
            font-size: 16px;
            color: #1a1a1a;
            background: #fff;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            outline: none;
            border-color: #FF4900;
            box-shadow: 0 0 0 3px rgba(255, 73, 0, 0.1);
        }
        
        .required {
            color: #FF4900;
            font-weight: bold;
        }
        
        .form-actions {
            margin-top: 40px;
            text-align: center;
            display: flex;
            justify-content: center;
            gap: 20px;
        }
        
        .skill-category-group,
        .experience-item,
        .achievement-item {
            padding: 30px;
            background: white;
            border: 2px solid #e0e0e0;
            border-radius: 16px;
            margin-bottom: 20px;
        }
        
        .form-section-icon {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, #FF4900, #FF6B3D);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 16px;
        }
        
        .form-label {
            font-family: 'Anybody', sans-serif;
            font-weight: 600;
            font-size: 14px;
            color: #1a1a1a;
            margin-bottom: 8px;
            display: block;
        }
        
        /* Match buttons with template styling */
        .btn-primary { 
            background: #000000; 
            color: #FFFCFA; 
            font-weight: 700; 
            font-size: 17px; 
            line-height: 1.2; 
            padding: 12px 24px; 
            min-width: 140px; 
            height: 57px; 
            border-radius: 12px; 
            border: none;
            display: inline-flex; 
            align-items: center; 
            justify-content: center;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #FF4900 0%, #FF6B35 100%);
            box-shadow: 0 6px 20px rgba(255, 73, 0, 0.3);
            transform: translateY(-2px);
            color: #FFFFFF;
        }
        
        .btn-outline-secondary {
            background: #FFFFFF;
            color: #000000;
            font-weight: 700;
            font-size: 17px;
            line-height: 1.2;
            padding: 12px 24px;
            min-width: 140px;
            height: 57px;
            border-radius: 12px;
            border: 1px solid #000000;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }
        
        .btn-outline-secondary:hover {
            background-color: #FF4900;
            color: #FFFFFF;
            border-color: #FF4900;
        }
        
        .btn-outline-primary {
            background: #FFFFFF;
            color: #000000;
            font-weight: 600;
            font-size: 16px;
            padding: 8px 16px;
            border-radius: 8px;
            border: 1px solid #000000;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }
        
        .btn-outline-primary:hover {
            background: #000000;
            color: #FFFFFF;
        }
        
        .btn-outline-danger {
            color: #FF4900;
            border-color: #FF4900;
            background: transparent;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .btn-outline-danger:hover {
            background-color: #FF4900;
            color: white;
        }
        
        .alert {
            padding: 20px;
            margin-bottom: 30px;
            border-radius: 12px;
            font-family: 'Anybody', sans-serif;
        }
        
        .alert-success {
            background-color: #d1e7dd;
            border: 2px solid #badbcc;
            color: #0f5132;
            box-shadow: 0 4px 15px rgba(15, 81, 50, 0.1);
        }
        
        .alert-danger {
            background-color: #f8d7da;
            border: 2px solid #f5c2c7;
            color: #842029;
            box-shadow: 0 4px 15px rgba(132, 32, 41, 0.1);
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .form-header h1 {
                font-size: 36px;
            }
            
            .form-header .section-subtitle {
                font-size: 18px;
            }
            
            .team-profile-form {
                margin: -20px 20px 0;
                padding: 30px 24px;
                border-radius: 16px;
            }
            
            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</x-layouts.inner-pages>