// Collapse All Button Functionality with MutationObserver
document.addEventListener("DOMContentLoaded", function() {
    const collapseAllButton = document.getElementById('collapseAllButton');
    
    if (!collapseAllButton) {
        return;
    }
    
    // Set initial inline style for consistency
    collapseAllButton.style.display = 'none';
    
    // Add button style class for proper appearance
    collapseAllButton.classList.add('bg-gray-200', 'p-2', 'rounded-lg', 'hover:bg-gray-300', 'transition-colors', 'duration-200');
    
    // Function to check if more than one row is expanded and show/hide the button
    function updateCollapseAllButtonVisibility() {
        const expandedRows = document.querySelectorAll('.toggle-staff[aria-expanded="true"]');
        
        if (expandedRows.length > 1) {
            collapseAllButton.style.display = 'inline-flex';
        } else {
            collapseAllButton.style.display = 'none';
        }
    }
    
    // Function to collapse all expanded rows
    function collapseAllRows(e) {
        e.preventDefault();
        e.stopPropagation();
        
        const expandedButtons = document.querySelectorAll('.toggle-staff[aria-expanded="true"]');
        expandedButtons.forEach(button => button.click());
    }
    
    // Add click event to the collapse all button
    collapseAllButton.addEventListener('click', collapseAllRows);
    
    // Set up MutationObserver to watch for attribute changes on toggle buttons
    const observer = new MutationObserver(function(mutations) {
        let shouldUpdate = false;
        
        mutations.forEach(function(mutation) {
            if (mutation.type === 'attributes' && 
                mutation.attributeName === 'aria-expanded' && 
                mutation.target.classList.contains('toggle-staff')) {
                shouldUpdate = true;
            }
        });
        
        if (shouldUpdate) {
            updateCollapseAllButtonVisibility();
        }
    });
    
    // Observe all toggle buttons for attribute changes
    const toggleButtons = document.querySelectorAll('.toggle-staff');
    toggleButtons.forEach(function(button) {
        observer.observe(button, { attributes: true });
    });
    
    // Manual observer for new toggle buttons added dynamically
    const tableContainer = document.querySelector('.overflow-hidden.rounded-lg.border.border-gray-200');
    if (tableContainer) {
        const tableObserver = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.type === 'childList') {
                    const newButtons = mutation.target.querySelectorAll('.toggle-staff:not([observed])');
                    newButtons.forEach(function(button) {
                        button.setAttribute('observed', 'true');
                        observer.observe(button, { attributes: true });
                    });
                }
            });
        });
        
        tableObserver.observe(tableContainer, { 
            childList: true, 
            subtree: true 
        });
    }
    
    // Backup polling method (runs every 500ms)
    const pollInterval = setInterval(function() {
        updateCollapseAllButtonVisibility();
    }, 500);
    
    // Run initial check
    updateCollapseAllButtonVisibility();
}); 