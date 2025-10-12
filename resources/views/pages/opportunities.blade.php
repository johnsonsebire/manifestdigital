<x-layouts.opportunities title="Careers & Opportunities | Join Our Team - Manifest Digital" :transparent-header="true" preloader='advanced'>

    @push('styles')
        @vite(['resources/assets/css/opportunities.css'])
    @endpush

    <x-opportunities.hero />
    <x-opportunities.culture />
    <x-opportunities.testimonials />
    <x-opportunities.listing />
    <x-opportunities.application-form />

    @push('scripts')
        <script>
            // Animate elements on scroll
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -100px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.life-value-card, .benefits-card, .opportunity-card, .testimonial-card').forEach(el => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(30px)';
                el.style.transition = 'all 0.6s ease-out';
                observer.observe(el);
            });

            // Opportunities filtering functionality
            const filterBtns = document.querySelectorAll('.filter-btn');
            const opportunityCards = document.querySelectorAll('.opportunity-card');
            const searchInput = document.getElementById('opportunitySearch');
            const noResultsMessage = document.getElementById('noResultsMessage');

            // Filter by category
            filterBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    // Update active state
                    filterBtns.forEach(b => {
                        b.classList.remove('active');
                        b.setAttribute('aria-pressed', 'false');
                    });
                    btn.classList.add('active');
                    btn.setAttribute('aria-pressed', 'true');

                    const category = btn.dataset.filter;
                    filterOpportunities(category, searchInput.value);
                });
            });

            // Search functionality
            if (searchInput) {
                searchInput.addEventListener('input', (e) => {
                    const activeFilter = document.querySelector('.filter-btn.active').dataset.filter;
                    filterOpportunities(activeFilter, e.target.value);
                });
            }

            function filterOpportunities(category, searchTerm) {
                let visibleCount = 0;

                opportunityCards.forEach(card => {
                    const cardCategory = card.dataset.category;
                    const cardText = card.textContent.toLowerCase();
                    const matchesCategory = category === 'all' || cardCategory === category;
                    const matchesSearch = !searchTerm || cardText.includes(searchTerm.toLowerCase());

                    if (matchesCategory && matchesSearch) {
                        card.style.display = 'block';
                        visibleCount++;
                    } else {
                        card.style.display = 'none';
                    }
                });

                // Show/hide no results message
                if (noResultsMessage) {
                    noResultsMessage.style.display = visibleCount === 0 ? 'block' : 'none';
                }
            }

            // Opportunity modal functionality
            const opportunityModal = new bootstrap.Modal(document.getElementById('opportunityModal'));
            const opportunityData = {
                'senior-fullstack-dev': {
                    title: 'Senior Full-Stack Developer',
                    type: 'Full-Time',
                    department: 'Development',
                    location: 'Remote / Lagos, Nigeria',
                    schedule: 'Full-Time, 40 hours/week',
                    experience: '3+ years',
                    posted: '3 days ago',
                    description: 'Join our development team to build cutting-edge web applications using modern technologies. Lead projects and mentor junior developers while working on exciting projects for clients across various industries.',
                    responsibilities: [
                        'Lead development of scalable web applications',
                        'Collaborate with design and product teams',
                        'Mentor junior developers and conduct code reviews',
                        'Participate in technical architecture decisions',
                        'Ensure code quality and best practices',
                        'Stay updated with latest technologies and trends'
                    ],
                    requirements: [
                        'Bachelor\'s degree in Computer Science or related field',
                        '3+ years of experience in full-stack development',
                        'Proficiency in React, Node.js, and Laravel',
                        'Experience with MySQL and database design',
                        'Knowledge of TypeScript, Docker, and AWS',
                        'Strong problem-solving and communication skills'
                    ],
                    skills: ['React', 'Node.js', 'Laravel', 'MySQL', 'TypeScript', 'Docker', 'AWS']
                }
                // Add other job data as needed
            };

            window.openOpportunityModal = function(jobId) {
                const job = opportunityData[jobId];
                if (!job) return;

                // Populate modal content
                document.getElementById('opportunityModalLabel').textContent = job.title;
                document.querySelector('.modal-type-badge').textContent = job.type;
                document.querySelector('.modal-department-badge').textContent = job.department;
                document.querySelector('.modal-location').textContent = job.location;
                document.querySelector('.modal-schedule').textContent = job.schedule;
                document.querySelector('.modal-experience').textContent = job.experience;
                document.querySelector('.modal-posted').textContent = job.posted;
                document.querySelector('.modal-description').textContent = job.description;

                // Populate responsibilities
                const responsibilitiesList = document.querySelector('.modal-responsibilities');
                responsibilitiesList.innerHTML = '';
                job.responsibilities.forEach(item => {
                    const li = document.createElement('li');
                    li.textContent = item;
                    responsibilitiesList.appendChild(li);
                });

                // Populate requirements
                const requirementsList = document.querySelector('.modal-requirements');
                requirementsList.innerHTML = '';
                job.requirements.forEach(item => {
                    const li = document.createElement('li');
                    li.textContent = item;
                    requirementsList.appendChild(li);
                });

                // Populate skills
                const skillsContainer = document.querySelector('.modal-skills');
                skillsContainer.innerHTML = '';
                job.skills.forEach(skill => {
                    const badge = document.createElement('span');
                    badge.className = 'badge';
                    badge.textContent = skill;
                    skillsContainer.appendChild(badge);
                });

                opportunityModal.show();
            };

            // Application form functionality
            let currentStep = 1;
            const totalSteps = 4;

            window.goToStep = function(stepNumber) {
                if (stepNumber < 1 || stepNumber > totalSteps) return;

                // Hide all steps
                document.querySelectorAll('.career-form-step').forEach(step => {
                    step.classList.remove('active');
                });

                // Show target step
                document.querySelector(`[data-step="${stepNumber}"]`).classList.add('active');

                // Update progress indicators
                document.querySelectorAll('.career-progress-step').forEach((indicator, index) => {
                    const step = index + 1;
                    indicator.classList.remove('active', 'completed');
                    
                    if (step === stepNumber) {
                        indicator.classList.add('active');
                    } else if (step < stepNumber) {
                        indicator.classList.add('completed');
                    }
                });

                // Update navigation buttons
                const prevBtn = document.getElementById('prevBtn');
                const nextBtn = document.getElementById('nextBtn');
                const submitBtn = document.getElementById('submitBtn');

                prevBtn.style.display = stepNumber === 1 ? 'none' : 'block';
                nextBtn.style.display = stepNumber === totalSteps ? 'none' : 'block';
                submitBtn.style.display = stepNumber === totalSteps ? 'block' : 'none';

                currentStep = stepNumber;
            };

            // Navigation button handlers
            document.getElementById('prevBtn').addEventListener('click', () => {
                goToStep(currentStep - 1);
            });

            document.getElementById('nextBtn').addEventListener('click', () => {
                if (validateCurrentStep()) {
                    goToStep(currentStep + 1);
                }
            });

            // Form validation
            function validateCurrentStep() {
                const currentStepElement = document.querySelector('.career-form-step.active');
                const requiredFields = currentStepElement.querySelectorAll('[required]');
                let isValid = true;

                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        field.classList.add('is-invalid');
                        isValid = false;
                    } else {
                        field.classList.remove('is-invalid');
                    }
                });

                return isValid;
            }

            // File upload handling
            document.querySelectorAll('.file-upload-area').forEach(area => {
                const input = area.querySelector('input[type="file"]');
                const content = area.querySelector('.file-upload-content');
                const preview = area.querySelector('.file-preview');

                area.addEventListener('click', () => input.click());
                area.addEventListener('dragover', (e) => {
                    e.preventDefault();
                    area.classList.add('dragover');
                });
                area.addEventListener('dragleave', () => {
                    area.classList.remove('dragover');
                });
                area.addEventListener('drop', (e) => {
                    e.preventDefault();
                    area.classList.remove('dragover');
                    input.files = e.dataTransfer.files;
                    handleFileSelection(input);
                });

                input.addEventListener('change', () => handleFileSelection(input));
            });

            function handleFileSelection(input) {
                const files = input.files;
                const area = input.closest('.file-upload-area');
                const preview = area.querySelector('.file-preview');

                if (files.length > 0) {
                    const file = files[0];
                    preview.classList.remove('d-none');
                    preview.querySelector('.file-name').textContent = file.name;
                    preview.querySelector('.file-size').textContent = formatFileSize(file.size);
                }
            }

            function formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
            }

            // Form submission
            document.getElementById('applicationForm').addEventListener('submit', (e) => {
                e.preventDefault();
                if (validateCurrentStep()) {
                    // Simulate form submission
                    const submitBtn = document.getElementById('submitBtn');
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Submitting...';
                    submitBtn.disabled = true;

                    setTimeout(() => {
                        showSuccessPage();
                    }, 2000);
                }
            });

            function showSuccessPage() {
                document.querySelector('.application-form').classList.add('d-none');
                document.getElementById('applicationSuccess').classList.remove('d-none');
                
                // Generate application reference
                const reference = 'MD-' + new Date().getFullYear() + '-APP-' + Math.floor(Math.random() * 10000);
                document.getElementById('applicationReference').textContent = reference;

                // Scroll to success section
                document.getElementById('applicationSuccess').scrollIntoView({ behavior: 'smooth' });
            }

            window.startApplication = function() {
                document.getElementById('opportunities-section').scrollIntoView({ behavior: 'smooth' });
                setTimeout(() => {
                    document.querySelector('.application-form').scrollIntoView({ behavior: 'smooth' });
                }, 500);
                opportunityModal.hide();
            };
        </script>
    @endpush

</x-layouts.opportunities>