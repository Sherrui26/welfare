// Main initialization script
document.addEventListener("DOMContentLoaded", function () {
    console.log("RSC7 Hostel Management System initialized");
    
    // Any global initialization code can go here
    
    // This file is kept minimal as functionality has been separated into individual JS files
    
    // Initialize expandable cards
    // This will be handled by expandable-cards.js
    
    // Handle zoom level adjustments for the Recent Activity section
    function adjustForZoomLevel() {
        const activitySection = document.querySelector('.card.basic-card .overflow-y-auto');
        if (!activitySection) return;
        
        // Get window dimensions to determine the best height
        const windowHeight = window.innerHeight;
        const windowWidth = window.innerWidth;
        
        // Different height configurations based on screen size and zoom level
        if (windowWidth < 768 || windowHeight < 700) {
            // Small screens or zoomed out
            activitySection.style.maxHeight = '10vh';
            activitySection.style.minHeight = '200px';
        } else if (windowHeight < 900) {
            // Medium-sized screens
            activitySection.style.maxHeight = '10vh';
            activitySection.style.minHeight = '250px';
        } else {
            // Large screens
            activitySection.style.maxHeight = '10vh';
            activitySection.style.minHeight = '280px';
        }
        
        // Also adjust the parent container if needed
        const activityCard = activitySection.closest('.card.basic-card');
        if (activityCard) {
            activityCard.style.height = windowHeight < 768 ? 'auto' : '';
        }
    }
    
    // Run on page load and when resizing
    adjustForZoomLevel();
    window.addEventListener('resize', adjustForZoomLevel);
    
    // Additional event for zoom detection (for browsers that support it)
    if ('onwheel' in window) {
        window.addEventListener('wheel', function(e) {
            // Check if CTRL key is pressed (common for zoom)
            if (e.ctrlKey) {
                // Debounce the adjustment to avoid performance issues
                clearTimeout(window.zoomTimer);
                window.zoomTimer = setTimeout(adjustForZoomLevel, 100);
            }
        });
    }
}); 