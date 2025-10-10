/**
 * Project Navigation
 * Handles project-to-project navigation and transitions
 */
class ProjectNavigation {
    constructor() {
        this.bindEvents();
    }

    bindEvents() {
        // Delegate clicks on project cards
        document.addEventListener('click', (e) => {
            const projectCard = e.target.closest('.project-card');
            if (projectCard) {
                const projectLink = projectCard.querySelector('.project-link');
                if (projectLink) {
                    e.preventDefault();
                    this.navigateToProject(projectLink.href, projectCard);
                }
            }
        });

        // Handle browser back/forward
        window.addEventListener('popstate', (e) => {
            if (e.state && e.state.projectUrl) {
                this.navigateToProject(e.state.projectUrl, null, false);
            }
        });
    }

    async navigateToProject(url, sourceCard, pushState = true) {
        try {
            // Start transition animation
            await this.animateTransitionOut(sourceCard);

            // Update browser history
            if (pushState) {
                history.pushState({ projectUrl: url }, '', url);
            }

            // Load new project content
            const response = await fetch(url);
            const html = await response.text();
            
            // Extract main content
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const content = doc.querySelector('.project-detail-content');

            // Update document title
            document.title = doc.title;

            // Insert new content
            const mainContent = document.querySelector('main');
            if (mainContent && content) {
                mainContent.innerHTML = content.innerHTML;
            }

            // Animate new content
            await this.animateTransitionIn();

            // Initialize any required scripts for new content
            this.initializeProjectScripts();

        } catch (error) {
            console.error('Navigation error:', error);
            // Fallback to traditional navigation
            window.location.href = url;
        }
    }

    async animateTransitionOut(sourceCard) {
        return new Promise(resolve => {
            anime({
                targets: '.main-content',
                opacity: [1, 0],
                translateY: [0, 20],
                duration: 400,
                easing: 'easeInOutQuad',
                complete: resolve
            });
        });
    }

    async animateTransitionIn() {
        return new Promise(resolve => {
            anime({
                targets: '.main-content',
                opacity: [0, 1],
                translateY: [20, 0],
                duration: 600,
                easing: 'easeOutQuad',
                complete: resolve
            });
        });
    }

    initializeProjectScripts() {
        // Re-initialize any required project detail scripts
        if (typeof ProjectDetailManager !== 'undefined') {
            new ProjectDetailManager().init();
        }
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    window.projectNavigation = new ProjectNavigation();
});