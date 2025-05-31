/**
 * Modal Navigation - Manages consistent transitions between modals
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
        z-index: 998;
        display: none;
        opacity: 0;
        transition: opacity 0.15s ease-out; /* Quicker transition */
    `;
    document.body.appendChild(persistentBackdrop);
    
    // Save a reference to all modals
    const modals = {
        roomDetails: document.getElementById('roomDetailsModal'),
        addRoom: document.getElementById('addRoomModal'),
        assignOccupant: document.getElementById('assignOccupantModal')
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
    
    // Expose the modal navigation helper to the global scope
    window.ModalNavigation = {
        /**
         * Transition smoothly between two modals
         * @param {HTMLElement|string} fromModal - The modal to hide (element or id)
         * @param {HTMLElement|string} toModal - The modal to show (element or id)
         * @returns {Promise} - Resolves when transition is complete
         */
        transition: function(fromModal, toModal) {
            // Get modal elements if strings were provided
            const from = typeof fromModal === 'string' ? document.getElementById(fromModal) : fromModal;
            const to = typeof toModal === 'string' ? document.getElementById(toModal) : toModal;
            
            if (!from || !to) {
                console.error('Modal transition failed: Invalid modal elements');
                return Promise.reject('Invalid modal elements');
            }
            
            return new Promise((resolve) => {
                // Show the persistent backdrop if not already visible
                if (persistentBackdrop.style.display !== 'block') {
                    persistentBackdrop.style.display = 'block';
                    // Force reflow
                    void persistentBackdrop.offsetWidth;
                    persistentBackdrop.style.opacity = '1';
                }
                
                // Prepare the "to" modal for animation
                // Reset the transform of inner content to starting position
                const toContent = to.querySelector('.bg-white');
                if (toContent) {
                    toContent.style.transform = 'translateY(20px)';
                    toContent.style.opacity = '0';
                }
                
                // Make the destination modal visible but without content showing yet
                // Important: Set background to transparent to avoid double overlay
                to.style.backgroundColor = 'transparent';
                to.classList.remove('hidden');
                
                // Hide the current modal content but keep the background
                const fromContent = from.querySelector('.bg-white');
                if (fromContent) {
                    fromContent.style.transition = 'transform 0.2s ease-out, opacity 0.2s ease-out';
                    fromContent.style.transform = 'translateY(10px)';
                    fromContent.style.opacity = '0';
                }
                
                // Short delay to allow the fromContent to hide
                setTimeout(() => {
                    // Now hide the first modal completely
                    from.classList.remove('active');
                    from.classList.add('hidden');
                    from.style.backgroundColor = '';
                    
                    // Force browser to process these changes
                    void to.offsetWidth;
                    
                    // Show the new modal and animate its content in
                    to.classList.add('active');
                    
                    if (toContent) {
                        // Small delay before animating content in
                        setTimeout(() => {
                            toContent.style.transition = 'transform 0.25s ease-out, opacity 0.25s ease-out';
                            toContent.style.transform = 'translateY(0)';
                            toContent.style.opacity = '1';
                            
                            resolve();
                        }, 50);
                    } else {
                        resolve();
                    }
                }, 200);
            });
        },
        
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
        console.log('Modal Debug Mode Enabled');
        
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