// Sidebar toggle functionality
document.addEventListener("DOMContentLoaded", function () {
    // sidebar toggle function to recalculate overlays
    document.getElementById('toggleSidebar').addEventListener('click', function () {
        const sidebar = document.getElementById('sidebar');
        const isExpanding = !sidebar.classList.contains('sidebar-expanded');
        const overlays = document.querySelectorAll('.room-overlay');

        // Hide overlays by setting display: none (instead of opacity)
        overlays.forEach(overlay => overlay.style.display = 'none');

        sidebar.classList.toggle('sidebar-expanded');
        sidebar.classList.toggle('sidebar-collapsed');

        const sidebarWidth = isExpanding ? '250px' : '64px';
        document.getElementById('mainContent').style.marginLeft = sidebarWidth;
        document.getElementById('header').style.left = sidebarWidth;

        // Wait for sidebar transition to finish, then reset overlays instantly
        setTimeout(() => {
            if (typeof setRoomOverlays === 'function') {
                setRoomOverlays(); // Recalculate positions
            }
            overlays.forEach(overlay => {
                overlay.style.display = 'block'; // Show overlays instantly in new position
            });
        }, 300); // Match sidebar transition duration
    });
}); 