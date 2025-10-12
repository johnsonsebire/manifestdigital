<x-layouts.frontend title="About Us | Our Story & Mission - Manifest Digital" :transparent-header="true" preloader='advanced'>

    @push('styles')
        @vite(['resources/css/about.css'])
    @endpush

    <x-about.hero />
    <x-about.story />
    <x-about.mission-vision />
    <x-about.values />
    <x-about.timeline />
    <x-about.team />
    <x-about.testimonials />

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

            document.querySelectorAll('.timeline-item, .value-card, .team-member, .testimonial-card').forEach(el => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(30px)';
                el.style.transition = 'all 0.6s ease-out';
                observer.observe(el);
            });

            // Team Member Modal Functionality
            const teamMembers = {
                'kwame-asante': {
                    name: 'Kwame Asante',
                    role: 'CEO & Founder',
                    photo: 'fas fa-user-tie',
                    contact: {
                        email: 'kwame@manifestdigital.com',
                        phone: '+233 24 123 4567',
                        location: 'Accra, Ghana',
                        linkedin: 'linkedin.com/in/kwame-asante'
                    },
                    bio: `Kwame is a visionary technology entrepreneur with over 10 years of experience in digital transformation and business strategy. He founded Manifest Digital with the mission to bridge the digital divide in Africa by providing world-class technology solutions to organizations across the continent.

                    Before founding Manifest, Kwame led digital initiatives at several multinational corporations, where he gained deep insights into the challenges organizations face when adopting new technologies. His expertise spans AI innovation, sustainable business growth, and strategic partnerships.

                    Kwame holds an MBA in International Business and is passionate about mentoring the next generation of African tech entrepreneurs. He's a frequent speaker at technology conferences and has been featured in leading business publications for his insights on digital transformation in emerging markets.`,
                    skills: {
                        'Strategic Leadership': ['Business Strategy', 'Digital Transformation', 'Team Building', 'Stakeholder Management'],
                        'Technology Expertise': ['AI & Machine Learning', 'Enterprise Architecture', 'Digital Innovation', 'Product Strategy'],
                        'Business Development': ['Partnership Development', 'Market Expansion', 'Investment Relations', 'Client Relations']
                    },
                    experience: [
                        {
                            period: '2018 - Present',
                            title: 'CEO & Founder',
                            company: 'Manifest Digital',
                            description: 'Founded and scaled a digital agency serving 100+ clients across Ghana, UK, and USA. Built a remote-first team of 25+ professionals delivering innovative technology solutions.'
                        },
                        {
                            period: '2015 - 2018',
                            title: 'Digital Strategy Director',
                            company: 'TechCorp Africa',
                            description: 'Led digital transformation initiatives for enterprise clients, resulting in 40% average efficiency improvements and $2M+ in cost savings.'
                        },
                        {
                            period: '2012 - 2015',
                            title: 'Senior Business Analyst',
                            company: 'Global Innovations Ltd',
                            description: 'Analyzed business processes and implemented technology solutions for international clients across finance, healthcare, and manufacturing sectors.'
                        }
                    ],
                    achievements: [
                        {
                            icon: 'fas fa-award',
                            title: 'Ghana Tech Entrepreneur of the Year',
                            description: '2023 - Recognized for outstanding contribution to Ghana\'s tech ecosystem'
                        },
                        {
                            icon: 'fas fa-users',
                            title: '100+ Successful Projects',
                            description: 'Led delivery of over 100 digital transformation projects across 3 continents'
                        },
                        {
                            icon: 'fas fa-chart-line',
                            title: '$5M+ Revenue Generated',
                            description: 'Built Manifest Digital to $5M+ annual revenue in under 5 years'
                        }
                    ]
                },
                // Add other team members data here...
            };

            // Team member click handlers
            document.querySelectorAll('.team-member, .photo-team-member, .circle-team-member').forEach(member => {
                member.addEventListener('click', function() {
                    const memberId = this.dataset.member;
                    openTeamModal(memberId);
                });
            });

            function openTeamModal(memberId) {
                const member = teamMembers[memberId];
                if (!member) return;

                // Populate modal content
                document.getElementById('modalName').textContent = member.name;
                document.getElementById('modalRole').textContent = member.role;
                
                // Update photo placeholder
                const photoPlaceholder = document.getElementById('modalPhotoPlaceholder');
                photoPlaceholder.innerHTML = `<i class="${member.photo}"></i>`;
                
                // Populate contact information
                const contactContainer = document.getElementById('modalContact');
                contactContainer.innerHTML = '';
                
                Object.entries(member.contact).forEach(([key, value]) => {
                    const contactItem = document.createElement('div');
                    contactItem.className = 'contact-item';
                    
                    let icon;
                    switch(key) {
                        case 'email': icon = 'fas fa-envelope'; break;
                        case 'phone': icon = 'fas fa-phone'; break;
                        case 'location': icon = 'fas fa-map-marker-alt'; break;
                        case 'linkedin': icon = 'fab fa-linkedin'; break;
                        case 'github': icon = 'fab fa-github'; break;
                        case 'dribbble': icon = 'fab fa-dribbble'; break;
                        case 'kaggle': icon = 'fab fa-kaggle'; break;
                        default: icon = 'fas fa-link';
                    }
                    
                    contactItem.innerHTML = `<i class="${icon}"></i> ${value}`;
                    contactContainer.appendChild(contactItem);
                });

                // Populate bio, skills, experience, achievements...
                document.getElementById('modalBio').innerHTML = member.bio.replace(/\n\n/g, '</p><p>');

                // Show modal
                const modal = document.getElementById('teamModal');
                modal.classList.add('active');
                document.body.style.overflow = 'hidden';
            }

            function closeTeamModal() {
                const modal = document.getElementById('teamModal');
                modal.classList.remove('active');
                document.body.style.overflow = '';
            }

            // Close modal on outside click
            document.getElementById('teamModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeTeamModal();
                }
            });

            // Close modal on escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeTeamModal();
                }
            });

            // Make closeTeamModal globally available
            window.closeTeamModal = closeTeamModal;
        </script>
    @endpush

</x-layouts.frontend>