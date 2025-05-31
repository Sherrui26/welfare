// Notification panel toggle functionality with animation
document.addEventListener("DOMContentLoaded", function () {
    const notificationToggle = document.getElementById('notificationToggle');
    const notificationPanel = document.getElementById('notificationPanel');
    
    // Add class to show notification badge
    notificationToggle.classList.add('has-notifications');
    
    // Toggle notification panel
    notificationToggle.addEventListener('click', function (e) {
        e.stopPropagation();
        notificationPanel.classList.toggle('active');
        
        // Animation for notification items when panel is opened
        if (notificationPanel.classList.contains('active')) {
            const items = notificationPanel.querySelectorAll('.notification-item');
            items.forEach((item, index) => {
                // Stagger animation for each notification item
                item.style.animationDelay = `${index * 0.1}s`;
            });
        }
    });
    
    // Close notification panel when clicking outside
    document.addEventListener('click', function (e) {
        if (!notificationPanel.contains(e.target) && e.target !== notificationToggle) {
            notificationPanel.classList.remove('active');
        }
    });
    
    // Prevent closing panel when clicking inside it
    notificationPanel.addEventListener('click', function (e) {
        e.stopPropagation();
    });
    
    // Optional: Add functionality to mark notifications as read
    const notificationItems = document.querySelectorAll('.notification-item');
    notificationItems.forEach(item => {
        item.addEventListener('click', function() {
            // Add logic to mark as read - could toggle a class or call an API
            this.style.opacity = '0.6';
        });
    });
}); 