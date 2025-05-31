// Dark mode toggle function
document.addEventListener("DOMContentLoaded", function () {
    const toggleDarkMode = document.getElementById("toggleDarkMode");
    if (!toggleDarkMode) return;
    
    const icon = toggleDarkMode.querySelector("i");

    // Function to set dark mode state
    function setDarkMode(isDarkMode) {
        // Add transition disabling class
        document.documentElement.classList.add("disable-transitions");
        
        // Force pagination buttons to have consistent transition
        const paginationButtons = document.querySelectorAll('.pagination-button');
        paginationButtons.forEach(button => {
            button.style.transition = 'none';
        });

        requestAnimationFrame(() => {
            document.documentElement.classList.toggle("dark-mode", isDarkMode);
            document.body.classList.toggle("dark-mode", isDarkMode);
            localStorage.setItem("darkMode", isDarkMode);
            
            // Update icon
            if (icon) {
                icon.classList.toggle("fa-moon", !isDarkMode);
                icon.classList.toggle("fa-sun", isDarkMode);
            }

            // Apply correct overlay opacity immediately
            updateOverlayOpacity();
            
            // Update resident overlay if open
            updateResidentOverlayStyles();
            
            // Also toggle dark mode on room modal if it exists
            const modal = document.getElementById('roomDetailsModal');
            if (modal) {
                if (isDarkMode) {
                    modal.classList.add('dark-mode');
                } else {
                    modal.classList.remove('dark-mode');
                }
            }

            setTimeout(() => {
                document.documentElement.classList.remove("disable-transitions");
                // Restore pagination button transitions after dark mode is applied
                paginationButtons.forEach(button => {
                    button.style.transition = '';
                });
            }, 50); // Slightly longer timeout for better transition consistency
        });
    }

    // Load dark mode preference
    const savedDarkMode = localStorage.getItem("darkMode") === "true";
    setDarkMode(savedDarkMode);

    // Toggle dark mode on button click
    toggleDarkMode.addEventListener("click", function () {
        const isDarkMode = !document.documentElement.classList.contains("dark-mode");
        setDarkMode(isDarkMode);
    });
});

// Function to update overlay opacity based on dark mode
function updateOverlayOpacity() {
    const isDarkMode = document.documentElement.classList.contains("dark-mode");

    // Select all currently visible overlays (not hidden ones)
    const visibleOverlays = document.querySelectorAll(".room-overlay");

    visibleOverlays.forEach(overlay => {
        overlay.style.opacity = isDarkMode ? "0.3" : "0.5"; // Apply correct opacity
    });

    console.log("Overlay opacity updated:", isDarkMode ? "Dark mode (0.3)" : "Light mode (0.5)");
}

// Function to update resident overlay styling based on dark mode
function updateResidentOverlayStyles() {
    const isDarkMode = document.documentElement.classList.contains("dark-mode");
    const residentOverlay = document.getElementById('residentOverlay');
    
    if (!residentOverlay || residentOverlay.classList.contains('hidden')) {
        return; // Skip if overlay doesn't exist or is hidden
    }
    
    // Force pagination refresh to apply correct dark/light mode styling
    if (window.displayResidents) {
        window.displayResidents();
    }
} 