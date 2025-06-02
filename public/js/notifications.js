// Notification panel toggle functionality with improved reliability
document.addEventListener("DOMContentLoaded", function () {
    const notificationToggle = document.getElementById('notificationToggle');
    const notificationPanel = document.getElementById('notificationPanel');
    const viewAllNotificationsBtn = document.getElementById('viewAllNotificationsBtn');
    
    if (!notificationToggle || !notificationPanel) {
        console.error('Notification elements not found in the DOM');
        return;
    }
    
    // Initial state - make sure panel is hidden
    notificationPanel.classList.remove('show');
    notificationPanel.style.display = 'none';
    
    // Add badge to show there are notifications (in a real app, this would be conditional)
    notificationToggle.classList.add('has-notifications');
    
    // Pre-load notifications data so it's ready immediately when opened
    const sampleNotifications = [
        { id: 1, title: 'New Message', message: 'You have a new message from admin', time: '2 min ago', link: '#' },
        { id: 2, title: 'System Update', message: 'System will be updated tonight', time: '1 hour ago', link: '#' },
        { id: 3, title: 'Welcome!', message: 'Welcome to the welfare system', time: '1 day ago', link: '#' }
    ];
    
    // Toggle notification panel with stronger event handling
    notificationToggle.addEventListener('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        
        // Stop any other click handlers
        if (e.stopImmediatePropagation) {
            e.stopImmediatePropagation();
        }
        
        toggleNotificationPanel();
    }, true); // Use capture phase
    
    // Enhanced panel toggling function
    function toggleNotificationPanel() {
        const isActive = notificationPanel.classList.contains('show');
        
        if (!isActive) {
            // Open panel
            showNotificationPanel();
            fetchNotifications(); // Fetch notifications when panel is opened
        } else {
            // Close panel
            hideNotificationPanel();
        }
    }
    
    // Function to show notification panel
    function showNotificationPanel() {
        notificationPanel.style.display = 'block';
        notificationPanel.style.zIndex = '1000'; // Ensure it's above modal backdrops
        // Use setTimeout to ensure display: block has taken effect before adding animation class
        setTimeout(() => {
            notificationPanel.classList.add('show');
        }, 10);
    }
    
    // Function to hide notification panel
    function hideNotificationPanel() {
        notificationPanel.classList.remove('show');
        // Wait for animation to complete before hiding
        setTimeout(() => {
            notificationPanel.style.display = 'none';
        }, 200); // Match this to the animation duration in CSS
    }
    
    // Handle clicks outside the notification panel (using capture phase)
    document.addEventListener('click', function(e) {
        // Only process if panel is showing and click is outside panel and toggle
        if (notificationPanel.classList.contains('show') && 
            !notificationPanel.contains(e.target) && 
            e.target !== notificationToggle &&
            !notificationToggle.contains(e.target)) {
            
            // Prevent event from reaching other handlers
            e.stopPropagation();
            
            // Hide panel
            hideNotificationPanel();
        }
    }, true); // true = use capture phase for early interception
    
    // Prevent panel from closing when clicking inside it
    notificationPanel.addEventListener('click', function(e) {
        // Stop the event here to prevent document click handler from closing panel
        e.stopPropagation();
        if (e.stopImmediatePropagation) {
            e.stopImmediatePropagation();
        }
    }, true); // true = use capture phase
    
    // Function to fetch notifications from the server
    function fetchNotifications() {
        // Get notification list element
        const notificationList = document.querySelector('#notificationPanel ul');
        
        if (!notificationList) return;
        
        // Add loading indicator
        notificationList.innerHTML = '<li class="p-2 text-center"><span class="text-gray-500">Loading...</span></li>';
        
        // No delay - use pre-loaded notifications data
        // Clear loading indicator
        notificationList.innerHTML = '';
            
            // Add each notification to the list
            sampleNotifications.forEach((notification, index) => {
                const notificationItem = document.createElement('li');
                notificationItem.className = 'notification-item p-2 border-b border-gray-100 hover:bg-gray-50';
                notificationItem.style.animationDelay = `${index * 0.1}s`;
                
                // Create notification HTML
                notificationItem.innerHTML = `
                    <a href="${notification.link || '#'}" class="block">
                        <div class="flex items-center">
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">${notification.title}</p>
                                <p class="text-xs text-gray-500">${notification.message}</p>
                                <p class="text-xs text-gray-400 mt-1">${notification.time}</p>
                            </div>
                        </div>
                    </a>
                `;
                
                notificationList.appendChild(notificationItem);
                
                // Add click event to mark as read
                notificationItem.addEventListener('click', function() {
                    this.classList.add('read');
                    this.style.opacity = '0.6';
                });
            });
        // No artificial delay
    }
    
    // Check for new notifications periodically (every 5 minutes)
    setInterval(function() {
        if (notificationToggle.classList.contains('has-notifications')) {
            // In a real app, you would check for new notifications here
            // and update the badge if there are new ones
        }
    }, 300000); // 5 minutes in milliseconds
});