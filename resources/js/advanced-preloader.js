
document.addEventListener('DOMContentLoaded', function() {
    // Animate progress bar
    anime({
        targets: '.preloader-progress-bar',
        width: '100%',
        duration: 3000,
        easing: 'easeInOutQuad'
    });

    // Animate logo
    anime({
        targets: '.preloader-logo',
        scale: [0.8, 1],
        opacity: [0, 1],
        duration: 1000,
        easing: 'easeOutElastic(1, .8)',
        delay: 500
    });

    // Animate dots
    anime({
        targets: '.preloader-dot',
        scale: [0, 1],
        opacity: [0, 1],
        duration: 600,
        delay: anime.stagger(100, {start: 800}),
        easing: 'easeOutElastic(1, .8)'
    });

    // Animate text
    anime({
        targets: '.preloader-text',
        opacity: [0, 1],
        translateY: [20, 0],
        duration: 800,
        delay: 1200,
        easing: 'easeOutQuad'
    });

    // Hide preloader and show content
    setTimeout(() => {
        anime({
            targets: '#preloader',
            opacity: 0,
            duration: 800,
            easing: 'easeInOutQuad',
            complete: function() {
                document.getElementById('preloader').style.display = 'none';
                
                // Animate main content
                const mainContent = document.querySelector('body > *:not(#preloader):not(.notification-topbar)');
                if (mainContent) {
                    anime({
                        targets: mainContent,
                        opacity: [0, 1],
                        translateY: [30, 0],
                        duration: 1000,
                        easing: 'easeOutQuad'
                    });
                }
            }
        });
    }, 4500);
});
