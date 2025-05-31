// Staff toggle functionality for manage-room.html
document.addEventListener("DOMContentLoaded", function () {
    const toggleButtons = document.querySelectorAll('.toggle-staff');
    
    // First, add this CSS to the page if it doesn't exist
    if (!document.getElementById('staff-toggle-styles')) {
        const styleSheet = document.createElement('style');
        styleSheet.id = 'staff-toggle-styles';
        styleSheet.textContent = `
            .staff-list {
                display: none;
                max-height: 0;
                opacity: 0;
                overflow: hidden;
                transition: max-height 0.3s ease-out, opacity 0.3s ease-out;
            }
            .staff-list.animating {
                display: block;
            }
            .staff-list.expanded {
                display: block;
                max-height: 500px; /* Use a value larger than your content */
                opacity: 1;
            }
        `;
        document.head.appendChild(styleSheet);
    }
    
    // Apply initial state for staff lists - hide all initially
    document.querySelectorAll('.staff-list').forEach(panel => {
        panel.style.display = 'none';
        panel.style.maxHeight = '0px';
        panel.style.opacity = '0';
        panel.style.overflow = 'hidden';
    });
    
    // Setup event listeners for each toggle button
    toggleButtons.forEach(button => {
        // Set initial state
        button.setAttribute('aria-expanded', 'false');
        
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const roomNumber = this.getAttribute('data-room');
            const staffList = document.getElementById(`staff-${roomNumber}`);
            const parentRow = this.closest('.flex.items-center.justify-between');
            const icon = this.querySelector('i');
            
            // Get current state
            const isExpanded = this.getAttribute('aria-expanded') === 'true';
            
            if (isExpanded) {
                // COLLAPSING
                // Update button state and icon
                this.setAttribute('aria-expanded', 'false');
                icon.classList.remove('fa-angle-up');
                icon.classList.add('fa-angle-down');
                
                // Remove highlighting
                parentRow.classList.remove('row-highlighted');
                staffList.classList.remove('staff-list-highlighted');
                
                // Set exact current height before animation
                staffList.style.maxHeight = `${staffList.scrollHeight}px`;
                staffList.style.overflow = 'hidden';
                
                // Force reflow to ensure the height is applied
                staffList.offsetHeight;
                
                // Start collapse animation
                staffList.style.maxHeight = '0px';
                staffList.style.opacity = '0';
                
                // Hide element after animation completes
                setTimeout(() => {
                    staffList.style.display = 'none';
                }, 300);
                
            } else {
                // EXPANDING
                // Update button state and icon
                this.setAttribute('aria-expanded', 'true');
                icon.classList.remove('fa-angle-down');
                icon.classList.add('fa-angle-up');
                
                // Add highlighting
                parentRow.classList.add('row-highlighted');
                staffList.classList.add('staff-list-highlighted');
                
                // Set initial state for animation
                staffList.style.display = 'block';
                staffList.style.maxHeight = '0px';
                staffList.style.opacity = '0';
                staffList.style.overflow = 'hidden';
                
                // Force reflow to ensure display:block is applied
                staffList.offsetHeight;
                
                // Start expand animation
                const height = staffList.scrollHeight;
                staffList.style.maxHeight = `${height}px`;
                staffList.style.opacity = '1';
                
                // Remove height restriction after animation completes
                setTimeout(() => {
                    staffList.style.maxHeight = 'none';
                    staffList.style.overflow = '';
                }, 300);
            }
        });
    });
});

// Utility function for getting ordinal suffixes
function getOrdinalSuffix(num) {
    const j = num % 10,
          k = num % 100;
    if (j == 1 && k != 11) {
        return "st";
    }
    if (j == 2 && k != 12) {
        return "nd";
    }
    if (j == 3 && k != 13) {
        return "rd";
    }
    return "th";
} 