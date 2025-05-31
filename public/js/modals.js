/**
 * Modal functionality for RSC7 System with smooth transitions
 * 
 * This script provides consistent and smooth transitions for modals, similar to
 * the implementation in manage-room.html.
 */

document.addEventListener('DOMContentLoaded', function() {
    // Animation timing constants
    const FADE_OUT_DURATION = 200; // ms - Faster fade out
    const TRANSITION_DELAY = 20;   // ms
    
    // Create a persistent backdrop element for smooth transitions
    const persistentBackdrop = document.createElement('div');
    persistentBackdrop.classList.add('persistent-modal-backdrop');
    persistentBackdrop.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 98;
        display: none;
        opacity: 0;
        transition: opacity 0.15s ease-out; /* Quicker transition */
    `;
    document.body.appendChild(persistentBackdrop);
    
    // Save references to all modals
    const modals = {
        activity: document.getElementById('activityModal'),
        bookings: document.getElementById('bookingsModal'),
        staffActivities: document.getElementById('staffActivitiesModal'),
        notifications: document.getElementById('notificationsModal'),
        records: document.getElementById('recordsModal'),
        activityLog: document.getElementById('activityLogModal'),
        activityDetails: document.getElementById('activityDetailsModal')
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
    
    // Modal Navigation utility
    window.ModalNavigation = {
        /**
         * Close a modal with proper animation
         * @param {HTMLElement|string} modal - The modal to close (element or id)
         */
        close: function(modal) {
            const modalElement = typeof modal === 'string' ? document.getElementById(modal) : modal;
            
            if (!modalElement) {
                console.error('Modal close failed: Invalid modal element');
                return;
            }
            
            // Start hiding the backdrop
            persistentBackdrop.style.opacity = '0';
            
            modalElement.classList.remove('active');
            setTimeout(() => {
                modalElement.classList.add('hidden');
                
                // Hide backdrop element completely if no modals are visible
                if (!isAnyModalVisible()) {
                    persistentBackdrop.style.display = 'none';
                }
                
                // Re-enable body scrolling
                document.body.classList.remove('overflow-hidden');
            }, FADE_OUT_DURATION);
        },
        
        /**
         * Show a modal with proper animation
         * @param {HTMLElement|string} modal - The modal to show (element or id)
         */
        open: function(modal) {
            const modalElement = typeof modal === 'string' ? document.getElementById(modal) : modal;
            
            if (!modalElement) {
                console.error('Modal open failed: Invalid modal element');
                return;
            }
            
            // Show the persistent backdrop first
            persistentBackdrop.style.display = 'block';
            void persistentBackdrop.offsetWidth; // Force reflow
            persistentBackdrop.style.opacity = '1';
            
            // Prepare modal content for animation
            const modalContent = modalElement.querySelector('.bg-white, .modal-content');
            if (modalContent) {
                modalContent.style.transform = 'translateY(20px)';
                modalContent.style.opacity = '0';
                modalContent.style.transition = 'transform 0.25s ease-out, opacity 0.2s ease-out';
            }
            
            // Set background to transparent to avoid double overlay
            modalElement.style.backgroundColor = 'transparent';
            
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
                
                // Disable scrolling on body
                document.body.classList.add('overflow-hidden');
            }, TRANSITION_DELAY);
        }
    };
    
    // Activity Modal
    const viewAllActivityBtn = document.getElementById('viewAllActivityBtn');
    const activityModal = document.getElementById('activityModal');
    const closeActivityModal = document.getElementById('closeActivityModal');
    
    if(viewAllActivityBtn && activityModal && closeActivityModal) {
        viewAllActivityBtn.addEventListener('click', function() {
            window.ModalNavigation.open(activityModal);
        });
        
        closeActivityModal.addEventListener('click', function() {
            window.ModalNavigation.close(activityModal);
        });
    }
    
    // Bookings Modal
    const viewAllBookingsBtn = document.getElementById('viewAllBookingsBtn');
    const bookingsModal = document.getElementById('bookingsModal');
    const closeBookingsModal = document.getElementById('closeBookingsModal');
    
    if(viewAllBookingsBtn && bookingsModal && closeBookingsModal) {
        viewAllBookingsBtn.addEventListener('click', function() {
            window.ModalNavigation.open(bookingsModal);
        });
        
        closeBookingsModal.addEventListener('click', function() {
            window.ModalNavigation.close(bookingsModal);
        });
    }
    
    // Staff Activities Modal
    const viewAllStaffActivitiesBtn = document.getElementById('viewAllStaffActivitiesBtn');
    const staffActivitiesModal = document.getElementById('staffActivitiesModal');
    const closeStaffActivitiesModal = document.getElementById('closeStaffActivitiesModal');
    
    if(viewAllStaffActivitiesBtn && staffActivitiesModal && closeStaffActivitiesModal) {
        viewAllStaffActivitiesBtn.addEventListener('click', function() {
            window.ModalNavigation.open(staffActivitiesModal);
        });
        
        closeStaffActivitiesModal.addEventListener('click', function() {
            window.ModalNavigation.close(staffActivitiesModal);
        });
    }
    
    // Notifications Modal
    const viewAllNotificationsBtn = document.getElementById('viewAllNotificationsBtn');
    const notificationsModal = document.getElementById('notificationsModal');
    const closeNotificationsModal = document.getElementById('closeNotificationsModal');
    
    if(viewAllNotificationsBtn && notificationsModal && closeNotificationsModal) {
        viewAllNotificationsBtn.addEventListener('click', function() {
            window.ModalNavigation.open(notificationsModal);
        });
        
        closeNotificationsModal.addEventListener('click', function() {
            window.ModalNavigation.close(notificationsModal);
        });
    }
    
    // Records Modal
    const viewAllRecordsBtn = document.getElementById('viewAllRecordsBtn');
    const recordsModal = document.getElementById('recordsModal');
    const closeRecordsModal = document.getElementById('closeRecordsModal');
    
    if(viewAllRecordsBtn && recordsModal && closeRecordsModal) {
        viewAllRecordsBtn.addEventListener('click', function() {
            window.ModalNavigation.open(recordsModal);
        });
        
        closeRecordsModal.addEventListener('click', function() {
            window.ModalNavigation.close(recordsModal);
        });
    }
    
    // Global modal close on background click
    Object.values(modals).forEach(modal => {
        if (modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    window.ModalNavigation.close(this);
                }
            });
        }
    });
    
    // Handle notification panel toggle separately
    const notificationToggle = document.getElementById('notificationToggle');
    const notificationPanel = document.getElementById('notificationPanel');
    
    if(notificationToggle && notificationPanel) {
        notificationToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            notificationPanel.classList.toggle('hidden');
        });
        
        document.addEventListener('click', function(e) {
            if (!notificationPanel.contains(e.target) && e.target !== notificationToggle) {
                notificationPanel.classList.add('hidden');
            }
        });
    }
    
    // Filter button styles for all modal filter buttons
    document.querySelectorAll('.filter-btn').forEach(btn => {
        // Filter buttons now use the consistent filter-btn class from manage-room.css
        // No need to add additional classes as they're already styled
        
        // Add click handler
        btn.addEventListener('click', function() {
            // Remove selected class from all sibling buttons
            this.parentNode.querySelectorAll('.filter-btn').forEach(b => {
                b.classList.remove('selected');
            });
            
            // Add selected class to clicked button
            this.classList.add('selected');
            
            // Hide any no-results messages that might be showing
            const noResultsMessage = document.getElementById('no-results-message');
            if (noResultsMessage) {
                noResultsMessage.style.display = 'none';
            }
        });
    });
}); 