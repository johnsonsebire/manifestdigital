/**
 * Manifest Digital Modal System
 * Beautiful custom modals for replacing browser alerts
 */

class ManifestModal {
    constructor() {
        this.activeModal = null;
        this.toastContainer = null;
        this.init();
    }

    init() {
        // Create toast container
        this.createToastContainer();
        
        // Handle ESC key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.activeModal) {
                this.close();
            }
        });
    }

    createToastContainer() {
        if (!this.toastContainer) {
            this.toastContainer = document.createElement('div');
            this.toastContainer.className = 'toast-container';
            document.body.appendChild(this.toastContainer);
        }
    }

    /**
     * Create and show a modal
     */
    show(options = {}) {
        const {
            type = 'info',
            title = '',
            message = '',
            confirmText = 'OK',
            cancelText = 'Cancel',
            showCancel = false,
            onConfirm = null,
            onCancel = null,
            autoDismiss = false,
            dismissTime = 3000,
            showClose = true
        } = options;

        // Remove existing modal
        this.close();

        // Create modal elements
        const overlay = this.createOverlay();
        const modal = this.createModal(type, title, message, {
            confirmText,
            cancelText,
            showCancel,
            onConfirm,
            onCancel,
            autoDismiss,
            dismissTime,
            showClose
        });

        overlay.appendChild(modal);
        document.body.appendChild(overlay);
        
        // Prevent body scroll
        document.body.style.overflow = 'hidden';

        // Show modal with animation
        requestAnimationFrame(() => {
            overlay.classList.add('active');
        });

        this.activeModal = overlay;

        // Auto dismiss
        if (autoDismiss) {
            setTimeout(() => {
                this.close();
            }, dismissTime);
        }

        return {
            close: () => this.close(),
            overlay
        };
    }

    createOverlay() {
        const overlay = document.createElement('div');
        overlay.className = 'modal-overlay';
        
        // Close on backdrop click
        overlay.addEventListener('click', (e) => {
            if (e.target === overlay) {
                this.close();
            }
        });

        return overlay;
    }

    createModal(type, title, message, options) {
        const modal = document.createElement('div');
        modal.className = `modal ${options.autoDismiss ? 'modal-auto-dismiss' : ''}`;

        const icon = this.getIcon(type);
        
        modal.innerHTML = `
            ${options.showClose ? `
                <button class="modal-close" onclick="window.manifestModal.close()">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            ` : ''}
            
            <div class="modal-header">
                <div class="modal-icon ${type}">
                    ${icon}
                </div>
                ${title ? `<h2 class="modal-title">${title}</h2>` : ''}
            </div>

            ${message ? `
                <div class="modal-body">
                    <p class="modal-message">${message}</p>
                </div>
            ` : ''}

            <div class="modal-actions ${options.showCancel ? 'double' : 'single'}">
                ${options.showCancel ? `
                    <button class="modal-btn modal-btn-secondary" onclick="window.manifestModal.handleCancel()">
                        ${options.cancelText}
                    </button>
                ` : ''}
                <button class="modal-btn ${this.getButtonClass(type)}" onclick="window.manifestModal.handleConfirm()">
                    ${options.confirmText}
                </button>
            </div>
        `;

        // Store callbacks
        this.onConfirm = options.onConfirm;
        this.onCancel = options.onCancel;

        return modal;
    }

    getIcon(type) {
        const icons = {
            success: `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>`,
            error: `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>`,
            warning: `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>`,
            info: `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>`,
            confirm: `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
            </svg>`
        };
        
        return icons[type] || icons.info;
    }

    getButtonClass(type) {
        const classes = {
            success: 'modal-btn-success',
            error: 'modal-btn-danger',
            warning: 'modal-btn-primary',
            info: 'modal-btn-primary',
            confirm: 'modal-btn-primary'
        };
        
        return classes[type] || 'modal-btn-primary';
    }

    handleConfirm() {
        if (this.onConfirm) {
            const result = this.onConfirm();
            // Only close if callback doesn't return false
            if (result !== false) {
                this.close();
            }
        } else {
            this.close();
        }
    }

    handleCancel() {
        if (this.onCancel) {
            this.onCancel();
        }
        this.close();
    }

    close() {
        if (this.activeModal) {
            this.activeModal.classList.remove('active');
            
            setTimeout(() => {
                if (this.activeModal && this.activeModal.parentNode) {
                    this.activeModal.parentNode.removeChild(this.activeModal);
                }
                this.activeModal = null;
                document.body.style.overflow = '';
                this.onConfirm = null;
                this.onCancel = null;
            }, 300);
        }
    }

    /**
     * Show success modal
     */
    success(title, message, options = {}) {
        return this.show({
            type: 'success',
            title,
            message,
            confirmText: 'Great!',
            autoDismiss: true,
            dismissTime: 3000,
            ...options
        });
    }

    /**
     * Show error modal
     */
    error(title, message, options = {}) {
        return this.show({
            type: 'error',
            title,
            message,
            confirmText: 'OK',
            ...options
        });
    }

    /**
     * Show warning modal
     */
    warning(title, message, options = {}) {
        return this.show({
            type: 'warning',
            title,
            message,
            confirmText: 'Understood',
            ...options
        });
    }

    /**
     * Show info modal
     */
    info(title, message, options = {}) {
        return this.show({
            type: 'info',
            title,
            message,
            confirmText: 'OK',
            ...options
        });
    }

    /**
     * Show confirmation modal
     */
    confirm(title, message, options = {}) {
        return this.show({
            type: 'confirm',
            title,
            message,
            confirmText: 'Yes',
            cancelText: 'No',
            showCancel: true,
            showClose: false,
            ...options
        });
    }

    /**
     * Show loading modal
     */
    loading(message = 'Processing...') {
        this.close();

        const overlay = this.createOverlay();
        const modal = document.createElement('div');
        modal.className = 'modal';
        
        modal.innerHTML = `
            <div class="modal-body">
                <div class="modal-loading">
                    <div class="modal-spinner"></div>
                    <span class="modal-loading-text">${message}</span>
                </div>
            </div>
        `;

        overlay.appendChild(modal);
        document.body.appendChild(overlay);
        document.body.style.overflow = 'hidden';

        requestAnimationFrame(() => {
            overlay.classList.add('active');
        });

        this.activeModal = overlay;
        
        return {
            close: () => this.close(),
            updateMessage: (newMessage) => {
                const textEl = modal.querySelector('.modal-loading-text');
                if (textEl) textEl.textContent = newMessage;
            }
        };
    }

    /**
     * Show toast notification
     */
    toast(message, type = 'info', duration = 4000) {
        const toast = document.createElement('div');
        toast.className = `toast ${type}`;
        
        const icon = this.getToastIcon(type);
        
        toast.innerHTML = `
            <div class="toast-icon" style="color: ${this.getToastColor(type)}">
                ${icon}
            </div>
            <div class="toast-content">
                <div class="toast-message">${message}</div>
            </div>
            <button class="toast-close" onclick="this.parentElement.remove()">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        `;

        this.toastContainer.appendChild(toast);

        // Show with animation
        requestAnimationFrame(() => {
            toast.classList.add('show');
        });

        // Auto remove
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.parentNode.removeChild(toast);
                }
            }, 400);
        }, duration);

        return toast;
    }

    getToastIcon(type) {
        const icons = {
            success: `<svg fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>`,
            error: `<svg fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
            </svg>`,
            warning: `<svg fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
            </svg>`,
            info: `<svg fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
            </svg>`
        };
        
        return icons[type] || icons.info;
    }

    getToastColor(type) {
        const colors = {
            success: '#10B981',
            error: '#EF4444',
            warning: '#F59E0B',
            info: '#3B82F6'
        };
        
        return colors[type] || colors.info;
    }
}

// Global instance
window.manifestModal = new ManifestModal();

// Convenience functions for global access
window.showModal = (options) => window.manifestModal.show(options);
window.showSuccess = (title, message, options) => window.manifestModal.success(title, message, options);
window.showError = (title, message, options) => window.manifestModal.error(title, message, options);
window.showWarning = (title, message, options) => window.manifestModal.warning(title, message, options);
window.showInfo = (title, message, options) => window.manifestModal.info(title, message, options);
window.showConfirm = (title, message, options) => window.manifestModal.confirm(title, message, options);
window.showLoading = (message) => window.manifestModal.loading(message);
window.showToast = (message, type, duration) => window.manifestModal.toast(message, type, duration);

// Test function for debugging
window.testModal = () => {
    console.log('Testing modal system...');
    showSuccess('Test Modal', 'This is a test to verify the modal system is working properly.');
};