/**
 * Modal Navigation for Tenant Management - Manages consistent transitions between modals
 * 
 * This script provides consistent and smooth transitions between modals,
 * preventing the jumpy/inconsistent animations that can occur with
 * multiple modal states.
 */

document.addEventListener('DOMContentLoaded', function() {
    // Animation timing constants
    const FADE_OUT_DURATION = 200; // ms - Faster fade out
    const TRANSITION_DELAY = 20;   // ms
    
    // Create a persistent backdrop element
    const persistentBackdrop = document.createElement('div');
    persistentBackdrop.classList.add('persistent-modal-backdrop');
    persistentBackdrop.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 99;
        display: none;
        opacity: 0;
        transition: opacity 0.15s ease-out; /* Quicker transition */
    `;
    document.body.appendChild(persistentBackdrop);
    
    // Save a reference to all modals
    const modals = {
        tenantModal: document.getElementById('tenantModal'),
        residentOverlay: document.getElementById('residentOverlay')
    };
    
    // Make all modal backgrounds transparent
    Object.values(modals).forEach(modal => {
        if (modal) {
            modal.style.backgroundColor = 'transparent';
        }
    });
    
    // Helper to check if any modal is visible
    function isAnyModalVisible() {
        return Object.values(modals).some(modal => 
            modal && modal.classList.contains('active') && !modal.classList.contains('hidden')
        );
    }
    
    // Add event listeners for close buttons
    document.getElementById('closeModal')?.addEventListener('click', function() {
        window.ModalNavigation.close(modals.tenantModal);
    });
    
    document.getElementById('closeResidentOverlay')?.addEventListener('click', function() {
        window.ModalNavigation.close(modals.residentOverlay);
    });
    
    // Expose the modal navigation helper to the global scope
    window.ModalNavigation = {
        /**
         * Close a modal with proper animation
         * @param {HTMLElement|string} modal - The modal to close (element or id)
         * @returns {Promise} - Resolves when modal is closed
         */
        close: function(modal) {
            const modalElement = typeof modal === 'string' ? document.getElementById(modal) : modal;
            
            if (!modalElement) {
                console.error('Modal close failed: Invalid modal element');
                return Promise.reject('Invalid modal element');
            }
            
            // Start hiding the backdrop immediately
            persistentBackdrop.style.opacity = '0';
            
            return new Promise((resolve) => {
                modalElement.classList.remove('active');
                setTimeout(() => {
                    modalElement.classList.add('hidden');
                    modalElement.classList.remove('flex');
                    
                    // Hide backdrop element completely after a shorter delay
                    if (!isAnyModalVisible()) {
                        persistentBackdrop.style.display = 'none';
                    }
                    
                    resolve();
                }, FADE_OUT_DURATION);
            });
        },
        
        /**
         * Show a modal with proper animation
         * @param {HTMLElement|string} modal - The modal to show (element or id)
         * @returns {Promise} - Resolves when modal is shown
         */
        open: function(modal) {
            const modalElement = typeof modal === 'string' ? document.getElementById(modal) : modal;
            
            if (!modalElement) {
                console.error('Modal open failed: Invalid modal element');
                return Promise.reject('Invalid modal element');
            }
            
            // Show the persistent backdrop first
            persistentBackdrop.style.display = 'block';
            // Force reflow
            void persistentBackdrop.offsetWidth;
            persistentBackdrop.style.opacity = '1';
            
            // Prepare modal content for animation
            const modalContent = modalElement.querySelector('.bg-white');
            if (modalContent) {
                modalContent.style.transform = 'translateY(20px)';
                modalContent.style.opacity = '0';
                modalContent.style.transition = 'transform 0.25s ease-out, opacity 0.2s ease-out';
            }
            
            // Set background to transparent to avoid double overlay
            modalElement.style.backgroundColor = 'transparent';
            
            return new Promise((resolve) => {
                modalElement.classList.remove('hidden');
                modalElement.classList.add('flex');
                
                // Force browser to process the unhide
                void modalElement.offsetWidth; // Trigger reflow
                
                setTimeout(() => {
                    modalElement.classList.add('active');
                    
                    if (modalContent) {
                        setTimeout(() => {
                            modalContent.style.transform = 'translateY(0)';
                            modalContent.style.opacity = '1';
                        }, 50);
                    }
                    
                    resolve();
                }, TRANSITION_DELAY);
            });
        }
    };
    
    // Debug and diagnostics - helps identify modal related issues
    if (window.location.search.includes('debug=modal')) {
        console.log('Modal Debug Mode Enabled for Tenant Management');
        
        // Monitor modal state changes
        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                if (mutation.type === 'attributes' && 
                    (mutation.attributeName === 'class' || mutation.attributeName === 'style')) {
                    const modal = mutation.target;
                    console.log(`Modal: ${modal.id} - Classes: ${modal.className} - Hidden: ${modal.classList.contains('hidden')} - Active: ${modal.classList.contains('active')}`);
                }
            });
        });
        
        // Observe all modals
        Object.values(modals).forEach(modal => {
            if (modal) {
                observer.observe(modal, { attributes: true });
                console.log(`Monitoring modal: ${modal.id}`);
            }
        });
    }
}); 