 @props(['class' => '',
 'ctaHeading' => 'Ready to take your project to the next level?',
 'ctaButtonText' => 'Get Started',
 ])
 <section class="cta-footer {{ $class }}">
        <div class="cta">
            <!-- Decorative elements for CTA section -->
            <img src="{{asset('frontend/images/decorative/cta_left_mem_dots_f_circle2.svg')}}" alt="" class="decorative-element cta-left">
            <img src="{{asset('frontend/images/decorative/cta_top_right_mem_dots_f_tri (1).svg')}}" alt="" class="decorative-element cta-top-right">
            <img src="{{asset('frontend/images/decorative/right_under_cta_mem_dots_f_circle2.svg')}}" alt="" class="decorative-element cta-right-under">
            <img src="{{asset('frontend/images/decorative/left_under_cta_mem_dots_f_tri (1).svg')}}" alt="" class="decorative-element cta-left-under">

            <h2>{{ $ctaHeading }}</h2>
            <a href="{{ url('get-started') }}" class="btn-cta">{{ $ctaButtonText }}</a>
            <!-- <img src="images/decorative/left_under_footer_mem_donut (1).svg" alt="" class="decorative-element cta-button-donut"> -->
        </div>
        <footer>
            <div class="footer-content">
                <div class="footer-logo"></div>
                <nav class="footer-nav">
                    <div>
                        <a href="{{ url('about') }}">About Us</a>
                        <a href="{{ url('opportunities') }}">Opportunities</a>
                        <a href="{{ url('blog') }}">Our Blog</a>
                        <a href="{{ url('solutions') }}">Solutions</a>
                        <a href="{{ url('policies') }}">Policies</a>
                    </div>
                    <div>
                        <a href="{{url('mobile-app-design')}}">Mobile App Design</a>
                        <a href="{{url('website-development')}}">Website Development</a>
                        <a href="{{url('sap-consulting')}}">SAP Consulting</a>
                        <a href="{{url('brand-positioning')}}">Brand Positioning</a>
                        <a href="{{url('it-training')}}">IT Training</a>
                    </div>
                    <div>
                        <a href="{{url('seo-services')}}">SEO Services</a>
                        <a href="{{url('qa-testing')}}">QA Testing</a>
                        <a href="{{url('blockchain-solutions')}}">Blockchain Solutions</a>
                        <a href="{{url('cyber-security')}}">Cyber Security</a>
                        <a href="{{url('cloud-computing')}}">Cloud Computing</a>
                    </div>
                </nav>
            </div>
            <div class="social">
                <h3 class="social-heading">Connect With Us</h3>
                <div class="social-icons">
                    <a href="#" class="social-icon" aria-label="X (Twitter)"><i class="fab fa-x-twitter"></i></a>
                    <a href="#" class="social-icon" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-icon" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#" class="social-icon" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
            <div class="copyright"><p>Copyright 2025 - Manifest Digital</p></div>
        </footer>
    </section>

    <!-- Scroll to top button -->
    <button class="scroll-to-top" aria-label="Scroll to top">
        <i class="fas fa-arrow-up"></i>
    </button>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('frontend/js/script.js')}}"></script>
    <script>
        // ========================
        // Reading Tracker
        // ========================
        const readingTracker = document.querySelector('.reading-tracker');
        
        function updateReadingTracker() {
            const windowHeight = window.innerHeight;
            const documentHeight = document.documentElement.scrollHeight;
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            const trackLength = documentHeight - windowHeight;
            const percentScrolled = (scrollTop / trackLength) * 100;
            
            if (readingTracker) {
                readingTracker.style.width = percentScrolled + '%';
            }
        }
        
        window.addEventListener('scroll', updateReadingTracker, { passive: true });
        window.addEventListener('resize', updateReadingTracker, { passive: true });
        
        // Initial update
        updateReadingTracker();
        
        // ========================
        // Notification Topbar (Managed with Preloader)
        // ========================
        const notificationTopbar = document.querySelector('.notification-topbar');
        const notificationClose = document.querySelector('.notification-close');
        
        // Function to show notification after preloader
        function showNotificationAfterPreloader() {
            const notificationClosed = localStorage.getItem('notificationClosed');
            
            if (notificationClosed !== 'true' && notificationTopbar) {
                // Show notification with smooth animation
                setTimeout(() => {
                    notificationTopbar.style.display = 'flex';
                    // Trigger reflow for smooth animation
                    notificationTopbar.offsetHeight;
                    notificationTopbar.classList.add('show');
                    document.body.classList.add('notification-visible');
                }, 300);
            }
        }
        
        // Close notification handler
        if (notificationClose) {
            notificationClose.addEventListener('click', function() {
                if (notificationTopbar) {
                    // Remove show class first for animation
                    notificationTopbar.classList.remove('show');
                    document.body.classList.remove('notification-visible');
                    
                    // Hide completely after animation completes
                    setTimeout(() => {
                        notificationTopbar.style.display = 'none';
                    }, 400); // Match CSS transition duration
                    
                    localStorage.setItem('notificationClosed', 'true');
                }
            });
        }
        
        // Call this function after preloader completes (will be called from preloader script)
        window.showNotificationAfterPreloader = showNotificationAfterPreloader;
        
        // ========================
        // Scroll Animations
        // ========================
        
        // Intersection Observer for scroll animations
        const observerOptions = {
            root: null,
            rootMargin: '0px',
            threshold: 0.1 // Trigger when 10% of element is visible
        };
        
        const animateOnScroll = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animated');
                    // Optional: unobserve after animation to improve performance
                    // animateOnScroll.unobserve(entry.target);
                }
            });
        }, observerOptions);
        
        // Observe all elements with animation classes
        const animatedElements = document.querySelectorAll(
            '.animate-on-scroll, .fade-in-left, .fade-in-right, .scale-in, .stagger-children'
        );
        
        animatedElements.forEach(element => {
            animateOnScroll.observe(element);
        });
        
        // ========================
        // Scroll to top functionality
        // ========================
        const scrollToTopBtn = document.querySelector('.scroll-to-top');
        const ctaFooterSection = document.querySelector('.cta-footer');
        
        function updateScrollButton() {
            // Show/hide button based on scroll position
            if (window.pageYOffset > 300) {
                scrollToTopBtn.classList.add('show');
            } else {
                scrollToTopBtn.classList.remove('show');
            }
            
            // Check if button is over dark background
            if (ctaFooterSection) {
                const ctaRect = ctaFooterSection.getBoundingClientRect();
                const viewportHeight = window.innerHeight;
                
                // If the CTA/footer section is visible in viewport
                if (ctaRect.top < viewportHeight && ctaRect.bottom > 0) {
                    scrollToTopBtn.classList.add('on-dark');
                } else {
                    scrollToTopBtn.classList.remove('on-dark');
                }
            }
        }
        
        window.addEventListener('scroll', updateScrollButton);
        
        // Initial check
        updateScrollButton();
        
        scrollToTopBtn.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
        
        // Robust text rotation animation using Anime.js
        document.addEventListener('DOMContentLoaded', function() {
            const textRotate = document.querySelector('.text-rotate');
            const textContainer = document.querySelector('.text-rotate-container');
            const underlineSvg = document.querySelector('.underline-svg');
            
            if (!textRotate || !textContainer) return;
            
            const textItems = Array.from(document.querySelectorAll('.text-rotate-item'));
            if (textItems.length === 0) return;
            
            let currentIndex = 0;
            let itemWidths = [];
            let itemHeight = 74; // Base height from CSS - will be updated based on screen size
            let animationTimeline;
            
            // Function to get current item height based on screen size
            function getCurrentItemHeight() {
                const isMobile = window.innerWidth <= 768;
                return isMobile ? 48 : 74;
            }
            
            // Function to measure text widths accurately
            function measureTextWidths() {
                itemWidths = [];
                const isMobile = window.innerWidth <= 768;
                
                textItems.forEach((item, index) => {
                    // Create temporary measurement element
                    const testDiv = document.createElement('div');
                    testDiv.style.cssText = `
                        position: absolute;
                        top: -9999px;
                        left: -9999px;
                        visibility: hidden;
                        white-space: nowrap;
                        font-family: 'Anybody', sans-serif;
                        font-weight: 800;
                        font-size: ${isMobile ? '36px' : '64px'};
                        line-height: 1;
                        padding: 0;
                        margin: 0;
                        border: none;
                    `;
                    testDiv.textContent = item.textContent;
                    document.body.appendChild(testDiv);
                    
                    // Get the computed width
                    const width = testDiv.getBoundingClientRect().width;
                    itemWidths.push(Math.ceil(width) + 2); // Add small buffer for precision
                    
                    // Store width on element for reference
                    item.setAttribute('data-width', width);
                    
                    // Clean up
                    document.body.removeChild(testDiv);
                });
                
                console.log('Measured widths:', itemWidths.map((w, i) => `${textItems[i].textContent}: ${w}px`));
            }
            
            // Function to update container and underline width smoothly
            function updateWidth(targetWidth, duration = 400) {
                if (!textContainer) return;
                
                // Animate container width
                anime({
                    targets: textContainer,
                    width: targetWidth + 'px',
                    duration: duration,
                    easing: 'easeOutCubic'
                });
                
                // Animate underline width if present
                if (underlineSvg) {
                    anime({
                        targets: underlineSvg,
                        width: targetWidth + 'px',
                        duration: duration,
                        easing: 'easeOutCubic'
                    });
                }
            }
            
            // Function to animate to next text item
            function animateToNext() {
                const nextIndex = (currentIndex + 1) % textItems.length;
                const nextWidth = itemWidths[nextIndex];
                
                // Update item height for current screen size
                itemHeight = getCurrentItemHeight();
                
                // First, animate the width change slightly before text movement for better visual flow
                updateWidth(nextWidth, 300);
                
                // Then animate the text movement
                setTimeout(() => {
                    anime({
                        targets: textRotate,
                        translateY: `-${(nextIndex) * itemHeight}px`,
                        duration: 600,
                        easing: 'easeOutCubic',
                        complete: () => {
                            currentIndex = nextIndex;
                            
                            // If we've completed a full cycle, reset to beginning seamlessly
                            if (currentIndex === 0) {
                                // Wait a moment then reset position without animation
                                setTimeout(() => {
                                    anime.set(textRotate, {
                                        translateY: '0px'
                                    });
                                }, 100);
                            }
                        }
                    });
                }, 150); // Slight delay to let width animation start first
            }
            
            // Function to start the animation loop
            function startRotationAnimation() {
                // Set initial state
                currentIndex = 0;
                anime.set(textRotate, { translateY: '0px' });
                updateWidth(itemWidths[0], 0);
                
                // Create repeating timeline
                const runLoop = () => {
                    // Stay on current item for 2.5 seconds, then animate
                    setTimeout(() => {
                        animateToNext();
                        // Schedule next iteration
                        setTimeout(runLoop, 1000); // Wait for animation to complete
                    }, 2500);
                };
                
                // Start the loop
                runLoop();
            }
            
            // Function to handle responsive changes
            function handleResize() {
                // Update item height for current screen size
                itemHeight = getCurrentItemHeight();
                
                // Re-measure widths on resize
                measureTextWidths();
                
                // Update current width immediately
                if (itemWidths[currentIndex]) {
                    updateWidth(itemWidths[currentIndex], 200);
                }
                
                // Reset position with correct height
                anime.set(textRotate, { translateY: `-${currentIndex * itemHeight}px` });
            }
            
            // Initialize the animation
            function initTextRotation() {
                try {
                    measureTextWidths();
                    startRotationAnimation();
                } catch (error) {
                    console.error('Error initializing text rotation:', error);
                    // Fallback: just show first item
                    if (itemWidths[0]) {
                        updateWidth(itemWidths[0], 0);
                    }
                }
            }
            
            // Start animation after a short delay to ensure everything is loaded
            setTimeout(initTextRotation, 100);
            
            // Handle window resize with debouncing
            let resizeTimeout;
            window.addEventListener('resize', () => {
                clearTimeout(resizeTimeout);
                resizeTimeout = setTimeout(handleResize, 250);
            });
            
            // Pause animation when page is not visible (performance optimization)
            document.addEventListener('visibilitychange', () => {
                if (document.hidden) {
                    // Page is hidden, pause animations
                    anime.remove(textRotate);
                    anime.remove(textContainer);
                    if (underlineSvg) anime.remove(underlineSvg);
                } else {
                    // Page is visible again, restart
                    setTimeout(initTextRotation, 100);
                }
            });
        });
        
        // Mobile menu functionality
        const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
        const mobileNav = document.querySelector('.mobile-nav');
        const mobileNavOverlay = document.querySelector('.mobile-nav-overlay');
        
        function toggleMobileMenu() {
            mobileMenuToggle.classList.toggle('active');
            mobileNav.classList.toggle('active');
            mobileNavOverlay.classList.toggle('active');
            
            // Prevent body scroll when menu is open
            if (mobileNav.classList.contains('active')) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = '';
            }
        }
        
        if (mobileMenuToggle) {
            mobileMenuToggle.addEventListener('click', toggleMobileMenu);
        }
        
        if (mobileNavOverlay) {
            mobileNavOverlay.addEventListener('click', toggleMobileMenu);
        }
        
        // Note: Mobile nav link handling moved below to dropdown section
        
        // Close menu on escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && mobileNav.classList.contains('active')) {
                toggleMobileMenu();
            }
        });

        // ========================
        // Dropdown Menu Functionality
        // ========================
        
        // Desktop dropdown - click to toggle
        const navDropdown = document.querySelector('.nav-dropdown');
        const dropdownToggle = document.querySelector('.dropdown-toggle');
        
        if (dropdownToggle) {
            dropdownToggle.addEventListener('click', function(e) {
                e.preventDefault();
                navDropdown.classList.toggle('active');
            });
        }
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (navDropdown && !navDropdown.contains(e.target)) {
                navDropdown.classList.remove('active');
            }
        });
        
        // Close dropdown on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && navDropdown) {
                navDropdown.classList.remove('active');
            }
        });
        
        // Mobile dropdown functionality
        const mobileDropdown = document.querySelector('.mobile-dropdown');
        const mobileDropdownToggle = document.querySelector('.mobile-dropdown-toggle');
        
        if (mobileDropdownToggle) {
            mobileDropdownToggle.addEventListener('click', function(e) {
                e.preventDefault();
                mobileDropdown.classList.toggle('active');
            });
        }
        
        // Prevent mobile dropdown toggle from closing the main mobile menu
        const mobileDropdownLinks = document.querySelectorAll('.mobile-dropdown-menu a');
        mobileDropdownLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                // Only close the main menu if it's a real navigation (not # or #something)
                if (link.getAttribute('href') !== '#' && !link.getAttribute('href').startsWith('#')) {
                    if (mobileNav.classList.contains('active')) {
                        toggleMobileMenu();
                    }
                }
            });
        });
        
        // Update the mobile nav links selector to exclude dropdown toggle
        const updatedMobileNavLinks = document.querySelectorAll('.mobile-nav nav > a, .mobile-nav .mobile-nav-buttons a');
        updatedMobileNavLinks.forEach(link => {
            link.addEventListener('click', () => {
                if (mobileNav.classList.contains('active')) {
                    toggleMobileMenu();
                }
            });
        });

           document.addEventListener('DOMContentLoaded', function() {
            // Animate background elements
            anime({
                targets: '.bg-element-1',
                rotate: 360,
                duration: 20000,
                loop: true,
                easing: 'linear'
            });
            
            anime({
                targets: '.bg-element-2',
                rotate: -360,
                duration: 15000,
                loop: true,
                easing: 'linear'
            });
            
            anime({
                targets: '.bg-element-3',
                rotate: 360,
                duration: 25000,
                loop: true,
                easing: 'linear'
            });
            
            // Logo container animation
            anime({
                targets: '.loader-logo',
                scale: [0.9, 1],
                rotateY: [0, 360],
                duration: 3000,
                easing: 'easeInOutQuad',
                loop: true,
                direction: 'alternate'
            });
            
            // Logo image reveal with smooth entrance
            setTimeout(() => {
                const logoImage = document.querySelector('.logo-image');
                if (logoImage) {
                    logoImage.classList.add('loaded');
                }
            }, 500);
            
            // Logo image pulse animation
            anime({
                targets: '.logo-image',
                scale: [1, 1.1, 1],
                duration: 2000,
                delay: 1000,
                loop: true,
                easing: 'easeInOutQuad'
            });
            
            // Loading dots animation - target only preloader dots
            anime({
                targets: '.loading-dots .dot',
                opacity: [0.3, 1],
                scale: [1, 1.2],
                duration: 600,
                delay: anime.stagger(100),
                loop: true,
                direction: 'alternate',
                easing: 'easeInOutQuad'
            });
            
            // Loading text fade in
            anime({
                targets: '.loading-text',
                opacity: [0, 1],
                translateY: [20, 0],
                duration: 800,
                delay: 1000,
                easing: 'easeOutQuad'
            });
            
            // Progress bar fill
            anime({
                targets: '.progress-fill',
                width: ['0%', '100%'],
                duration: 3000,
                delay: 1500,
                easing: 'easeInOutQuad'
            });
            
            // Hide preloader after animations complete
            setTimeout(function() {
                // Fade out preloader
                anime({
                    targets: '#preloader',
                    opacity: [1, 0],
                    duration: 600,
                    easing: 'easeOutQuad',
                    complete: function() {
                        document.getElementById('preloader').style.display = 'none';
                        // Keep overflow hidden during content animations to prevent scrollbar flash
                        document.body.style.overflow = 'hidden';
                        
                        // Show notification after preloader if not previously closed
                        if (typeof window.showNotificationAfterPreloader === 'function') {
                            window.showNotificationAfterPreloader();
                        }
                        
                        // Animate main content in
                        anime({
                            targets: '.main-content',
                            opacity: [0, 1],
                            translateY: [30, 0],
                            duration: 800,
                            easing: 'easeOutQuad'
                        });
                        
                        // Staggered animation for sections
                        anime({
                            targets: 'header, main, .cta-footer',
                            opacity: [0, 1],
                            translateY: [20, 0],
                            duration: 600,
                            delay: anime.stagger(200),
                            easing: 'easeOutQuad',
                            complete: function() {
                                // Remove loading class and restore overflow after all animations complete
                                document.body.classList.remove('loading');
                                document.body.style.overflow = '';
                            }
                        });
                    }
                });
            }, 4500); // Total preloader duration: 4.5 seconds
        });

        // ========================
        // Mega Menu Service Switching
        // ========================
        
        const serviceContent = {
            web: {
                'Design & UX': [
                    { name: 'Responsive Design', url: '#responsive-design' },
                    { name: 'UI/UX Design', url: '#ui-design' },
                    { name: 'Frontend Development', url: '#frontend' },
                    { name: 'User Testing', url: '#user-testing' }
                ],
                'Development': [
                    { name: 'HTML5/CSS3', url: '#html-css' },
                    { name: 'JavaScript/React', url: '#javascript' },
                    { name: 'Backend APIs', url: '#backend' },
                    { name: 'Database Design', url: '#database' }
                ],
                'Tools & Frameworks': [
                    { name: 'WordPress', url: '#wordpress' },
                    { name: 'Laravel', url: '#laravel' },
                    { name: 'Vue.js', url: '#vue' },
                    { name: 'Node.js', url: '#nodejs' }
                ]
            },
            mobile: {
                'iOS Development': [
                    { name: 'Swift Programming', url: '#swift' },
                    { name: 'SwiftUI', url: '#swiftui' },
                    { name: 'App Store Submission', url: '#app-store' },
                    { name: 'Core Data', url: '#core-data' }
                ],
                'Android Development': [
                    { name: 'Kotlin Programming', url: '#kotlin' },
                    { name: 'Android Studio', url: '#android-studio' },
                    { name: 'Google Play Store', url: '#play-store' },
                    { name: 'Material Design', url: '#material-design' }
                ],
                'Cross-Platform': [
                    { name: 'React Native', url: '#react-native' },
                    { name: 'Flutter', url: '#flutter' },
                    { name: 'Ionic', url: '#ionic' },
                    { name: 'Xamarin', url: '#xamarin' }
                ]
            },
            ecommerce: {
                'Platform Development': [
                    { name: 'WooCommerce', url: '#woocommerce' },
                    { name: 'Shopify Plus', url: '#shopify' },
                    { name: 'Magento', url: '#magento' },
                    { name: 'Custom Solutions', url: '#custom-ecommerce' }
                ],
                'Payment Integration': [
                    { name: 'Stripe Integration', url: '#stripe' },
                    { name: 'PayPal Gateway', url: '#paypal' },
                    { name: 'Mobile Money', url: '#mobile-money' },
                    { name: 'Bank Transfers', url: '#bank-transfer' }
                ],
                'Store Management': [
                    { name: 'Inventory System', url: '#inventory' },
                    { name: 'Order Management', url: '#orders' },
                    { name: 'Analytics Dashboard', url: '#analytics' },
                    { name: 'Customer Support', url: '#support' }
                ]
            },
            api: {
                'API Development': [
                    { name: 'REST APIs', url: '#rest-api' },
                    { name: 'GraphQL', url: '#graphql' },
                    { name: 'Webhook Integration', url: '#webhooks' },
                    { name: 'API Documentation', url: '#api-docs' }
                ],
                'Third-party Integration': [
                    { name: 'Social Media APIs', url: '#social-apis' },
                    { name: 'Payment Gateways', url: '#payment-apis' },
                    { name: 'CRM Integration', url: '#crm-apis' },
                    { name: 'Email Services', url: '#email-apis' }
                ],
                'Data & Security': [
                    { name: 'Authentication', url: '#auth' },
                    { name: 'Rate Limiting', url: '#rate-limit' },
                    { name: 'Data Validation', url: '#validation' },
                    { name: 'API Testing', url: '#api-testing' }
                ]
            }
        };

        function updateServiceCategories(serviceType) {
            const categoriesContainer = document.getElementById('serviceCategories');
            const content = serviceContent[serviceType];
            
            if (!content || !categoriesContainer) return;
            
            let html = '';
            Object.keys(content).forEach(category => {
                html += `
                    <div class="category-column">
                        <h4>${category}</h4>
                        <ul>
                            ${content[category].map(item => 
                                `<li><a href="${item.url}">${item.name}</a></li>`
                            ).join('')}
                        </ul>
                    </div>
                `;
            });
            
            categoriesContainer.innerHTML = html;
        }

        function initMegaMenuSwitching() {
            const serviceItems = document.querySelectorAll('.service-item[data-service]');
            
            serviceItems.forEach(item => {
                item.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Remove active class from all service items
                    serviceItems.forEach(si => si.classList.remove('active'));
                    
                    // Add active class to clicked item
                    this.classList.add('active');
                    
                    // Get service type and update categories
                    const serviceType = this.getAttribute('data-service');
                    updateServiceCategories(serviceType);
                });
            });
            
            // Initialize with web development content
            updateServiceCategories('web');
        }

        // Component loading functionality
        async function loadComponent(componentName, targetId) {
            try {
                const response = await fetch(`{{ asset('frontend/components') }}/${componentName}.html`);
                const html = await response.text();
                document.getElementById(targetId).innerHTML = html;
            } catch (error) {
                console.error(`Failed to load ${componentName}:`, error);
            }
        }
        
        // Load components when DOM is ready
        document.addEventListener('DOMContentLoaded', async function() {
            // Load both components in parallel
            await Promise.all([
                loadComponent('mega-menu', 'mega-menu-placeholder'),
                loadComponent('drop-down', 'dropdown-placeholder')
            ]);
            
            // Initialize mega menu functionality after components are loaded
            initMegaMenuSwitching();
        });
    </script>
    
 
</body>
</html>
