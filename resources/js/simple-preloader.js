    document.addEventListener('DOMContentLoaded', function() {
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

                     // Trigger notification to show immediately with content
                     const notificationTopbar = document.querySelector('.notification-topbar');
                     const notificationClosed = localStorage.getItem('notificationClosed');
                     
                     if (notificationTopbar && !notificationClosed) {
                         notificationTopbar.classList.add('show');
                         document.body.classList.add('notification-visible');
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
