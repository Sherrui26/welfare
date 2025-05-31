/**
 * Modal transitions specifically for Records, Occupant Details, and Admin & Staff Activity Log modals
 * 
 * This script extends the system's ModalNavigation from modals.js
 * to handle transitions between related modals with smooth animations.
 * Enhanced with smoother transitions to match manage-room.html feel.
 */

document.addEventListener('DOMContentLoaded', function() {
    // Wait for the main ModalNavigation to be available
    setTimeout(() => {
        if (!window.ModalNavigation) {
            console.error('ModalNavigation not found. Make sure modals.js is loaded before modal-transitions.js');
            return;
        }
        
        // Get all modal elements
        const occupantDetailsModal = document.getElementById('occupantDetailsModal');
        const backToRecordsBtn = document.getElementById('backToRecordsModal');
        const closeOccupantDetailsModal = document.getElementById('closeOccupantDetailsModal');
        const recordsModal = document.getElementById('recordsModal');
        
        // Admin & Staff Activity Log modal elements
        const activityLogModal = document.getElementById('activityLogModal');
        const activityDetailsModal = document.getElementById('activityDetailsModal');
        const closeActivityLogModal = document.getElementById('closeActivityLogModal');
        const closeActivityDetailsModal = document.getElementById('closeActivityDetailsModal');
        const backToActivityLogModal = document.getElementById('backToActivityLogModal');
        const viewAllStaffActivitiesBtn = document.getElementById('viewAllStaffActivitiesBtn');
        
        // Setup occupant details modal basic controls
        if (occupantDetailsModal && closeOccupantDetailsModal) {
            // Add active class to make CSS transitions work
            occupantDetailsModal.classList.add('hidden');
            
            // Set transparent background to work with persistent backdrop
            occupantDetailsModal.style.backgroundColor = 'transparent';
            
            // Setup close button
            closeOccupantDetailsModal.addEventListener('click', function() {
                window.ModalNavigation.close(occupantDetailsModal);
            });
            
            // Global modal close on background click
            occupantDetailsModal.addEventListener('click', function(e) {
                if (e.target === this) {
                    window.ModalNavigation.close(this);
                }
            });
        }
        
        // Setup Admin & Staff Activity Log modals
        if (activityLogModal && closeActivityLogModal) {
            // Add hidden class to make CSS transitions work
            activityLogModal.classList.add('hidden');
            
            // Set transparent background to work with persistent backdrop
            activityLogModal.style.backgroundColor = 'transparent';
            
            // Setup close button
            closeActivityLogModal.addEventListener('click', function() {
                window.ModalNavigation.close(activityLogModal);
            });
            
            // Global modal close on background click
            activityLogModal.addEventListener('click', function(e) {
                if (e.target === this) {
                    window.ModalNavigation.close(this);
                }
            });
        }
        
        // Setup Activity Details modal
        if (activityDetailsModal && closeActivityDetailsModal) {
            // Add hidden class to make CSS transitions work
            activityDetailsModal.classList.add('hidden');
            
            // Set transparent background to work with persistent backdrop
            activityDetailsModal.style.backgroundColor = 'transparent';
            
            // Setup close button
            closeActivityDetailsModal.addEventListener('click', function() {
                window.ModalNavigation.close(activityDetailsModal);
            });
            
            // Global modal close on background click
            activityDetailsModal.addEventListener('click', function(e) {
                if (e.target === this) {
                    window.ModalNavigation.close(this);
                }
            });
        }
        
        // View All Staff Activities button
        if (viewAllStaffActivitiesBtn && activityLogModal) {
            viewAllStaffActivitiesBtn.addEventListener('click', function() {
                window.ModalNavigation.open(activityLogModal);
            });
        }
        
        // Setup view details transitions with enhanced smoothness
        document.querySelectorAll('.view-details-btn').forEach(button => {
            button.addEventListener('click', function() {
                // Only proceed if both modals exist
                if (!recordsModal || !occupantDetailsModal) return;
                
                // Start hiding records modal
                recordsModal.classList.remove('active');
                
                // Hide records modal content with slower, smoother transitions
                // Modal should move DOWNWARD when exiting (opposite of entrance direction)
                const recordsContent = recordsModal.querySelector('.bg-white, .activity-modal-bg');
                if (recordsContent) {
                    recordsContent.style.transition = 'transform 0.35s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.3s ease-in';
                    recordsContent.style.transform = 'translateY(20px)';
                    recordsContent.style.opacity = '0';
                }
                
                // After a longer delay for smoother transition
                setTimeout(() => {
                    recordsModal.classList.add('hidden');
                    
                    // Show occupant details modal but prepare content for animation
                    occupantDetailsModal.classList.remove('hidden');
                    
                    // Prepare content for animation with smoother transitions
                    const occupantContent = occupantDetailsModal.querySelector('.bg-white, .activity-modal-bg');
                    if (occupantContent) {
                        occupantContent.style.transform = 'translateY(30px)';
                        occupantContent.style.opacity = '0';
                        occupantContent.style.transition = 'transform 0.45s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.4s ease-out';
                    }
                    
                    // Slightly longer delay for smoother entry animation
                    setTimeout(() => {
                        occupantDetailsModal.classList.add('active');
                        
                        if (occupantContent) {
                            setTimeout(() => {
                                occupantContent.style.transform = 'translateY(0)';
                                occupantContent.style.opacity = '1';
                            }, 50);
                        }
                    }, 50);
                }, 200); // Longer delay for smoother transition
            });
        });
        
        // Setup back button from occupant details to records
        if (backToRecordsBtn) {
            backToRecordsBtn.addEventListener('click', function() {
                // Only proceed if both modals exist
                if (!recordsModal || !occupantDetailsModal) return;
                
                // Start hiding occupant details modal
                occupantDetailsModal.classList.remove('active');
                
                // Hide occupant details content with smoother transitions
                // Modal should move DOWNWARD when exiting (consistent with forward transition)
                const occupantContent = occupantDetailsModal.querySelector('.bg-white, .activity-modal-bg');
                if (occupantContent) {
                    occupantContent.style.transition = 'transform 0.35s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.3s ease-in';
                    occupantContent.style.transform = 'translateY(20px)';
                    occupantContent.style.opacity = '0';
                }
                
                // After a longer delay for smoother transition
                setTimeout(() => {
                    occupantDetailsModal.classList.add('hidden');
                    
                    // Show records modal but prepare content for animation
                    recordsModal.classList.remove('hidden');
                    
                    // Prepare content for animation - always animate from bottom to top
                    const recordsContent = recordsModal.querySelector('.bg-white, .activity-modal-bg');
                    if (recordsContent) {
                        // Use 30px for a slightly more pronounced animation
                        recordsContent.style.transform = 'translateY(30px)';
                        recordsContent.style.opacity = '0';
                        recordsContent.style.transition = 'transform 0.45s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.4s ease-out';
                    }
                    
                    // Slightly longer delay for smoother entry animation
                    setTimeout(() => {
                        recordsModal.classList.add('active');
                        
                        if (recordsContent) {
                            setTimeout(() => {
                                recordsContent.style.transform = 'translateY(0)';
                                recordsContent.style.opacity = '1';
                            }, 50);
                        }
                    }, 50);
                }, 200); // Longer delay for smoother transition
            });
        }
        
        // Setup view-activity-btn transitions with custom transition that maintains backdrop
        document.querySelectorAll('.view-activity-btn').forEach((button, index) => {
            button.addEventListener('click', function() {
                // Only proceed if both modals exist
                if (!activityLogModal || !activityDetailsModal) return;
                
                // Custom transition to maintain backdrop
                // Hide activity log without closing backdrop
                activityLogModal.classList.remove('active');
                
                // Hide activity log content with transition
                const activityLogContent = activityLogModal.querySelector('.bg-white, .activity-modal-bg');
                if (activityLogContent) {
                    activityLogContent.style.transition = 'transform 0.35s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.3s ease-in';
                    activityLogContent.style.transform = 'translateY(20px)';
                    activityLogContent.style.opacity = '0';
                }
                
                // After the transition is complete, switch modals
                setTimeout(() => {
                    // Hide activity log completely
                    activityLogModal.classList.add('hidden');
                    
                    // Show activity details modal
                    activityDetailsModal.classList.remove('hidden');
                    
                    // Setup animation for activity details content
                    const activityDetailsContent = activityDetailsModal.querySelector('.bg-white, .activity-modal-bg');
                    if (activityDetailsContent) {
                        activityDetailsContent.style.transform = 'translateY(30px)';
                        activityDetailsContent.style.opacity = '0';
                        activityDetailsContent.style.transition = 'transform 0.45s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.4s ease-out';
                    }
                    
                    // Force browser to process the changes
                    void activityDetailsModal.offsetWidth;
                    
                    // Start showing activity details modal
                    activityDetailsModal.classList.add('active');
                    
                    // Animate content in
                    if (activityDetailsContent) {
                        setTimeout(() => {
                            activityDetailsContent.style.transform = 'translateY(0)';
                            activityDetailsContent.style.opacity = '1';
                        }, 50);
                    }
                }, 250);
            });
        });
        
        // Setup back button with custom transition that maintains backdrop
        if (backToActivityLogModal) {
            backToActivityLogModal.addEventListener('click', function() {
                // Only proceed if both modals exist
                if (!activityLogModal || !activityDetailsModal) return;
                
                // Custom transition to maintain backdrop
                // Hide activity details without closing backdrop
                activityDetailsModal.classList.remove('active');
                
                // Hide activity details content with transition
                const activityDetailsContent = activityDetailsModal.querySelector('.bg-white, .activity-modal-bg');
                if (activityDetailsContent) {
                    activityDetailsContent.style.transition = 'transform 0.35s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.3s ease-in';
                    activityDetailsContent.style.transform = 'translateY(20px)';
                    activityDetailsContent.style.opacity = '0';
                }
                
                // After the transition is complete, switch modals
                setTimeout(() => {
                    // Hide activity details completely
                    activityDetailsModal.classList.add('hidden');
                    
                    // Show activity log modal
                    activityLogModal.classList.remove('hidden');
                    
                    // Setup animation for activity log content
                    const activityLogContent = activityLogModal.querySelector('.bg-white, .activity-modal-bg');
                    if (activityLogContent) {
                        activityLogContent.style.transform = 'translateY(30px)';
                        activityLogContent.style.opacity = '0';
                        activityLogContent.style.transition = 'transform 0.45s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.4s ease-out';
                    }
                    
                    // Force browser to process the changes
                    void activityLogModal.offsetWidth;
                    
                    // Start showing activity log modal
                    activityLogModal.classList.add('active');
                    
                    // Animate content in
                    if (activityLogContent) {
                        setTimeout(() => {
                            activityLogContent.style.transform = 'translateY(0)';
                            activityLogContent.style.opacity = '1';
                        }, 50);
                    }
                }, 250);
            });
        }
    }, 100); // Small delay to ensure modals.js has initialized
});
