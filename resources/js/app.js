document.addEventListener('DOMContentLoaded', () => {
// Entry point for our application JavaScript
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

     window.addEventListener('scroll', updateReadingTracker, {
         passive: true
     });
     window.addEventListener('resize', updateReadingTracker, {
         passive: true
     });

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
             anime.set(textRotate, {
                 translateY: '0px'
             });
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
             anime.set(textRotate, {
                 translateY: `-${currentIndex * itemHeight}px`
             });
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

        
     });

