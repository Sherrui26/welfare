// Simple direct approach for row highlighting
document.addEventListener('DOMContentLoaded', function() {
    // Apply the highlighting directly via inline script
    applyRowHighlighting();
    
    // Also watch for DOM changes to handle dynamic content
    watchForChanges();
});

function applyRowHighlighting() {
    // Direct approach - apply the hover effect using direct DOM manipulation
    const style = document.createElement('style');
    style.textContent = `
        /* Direct row highlight hover effect */
        .bg-white.px-4.py-3.flex.items-center:has(.records-view-btn:hover),
        .bg-white.px-4.py-3.flex.items-center:has(.records-toggle-btn:hover) {
            background-color: rgba(124, 58, 237, 0.05) !important;
            position: relative;
        }
        
        .bg-white.px-4.py-3.flex.items-center:has(.records-view-btn:hover)::before,
        .bg-white.px-4.py-3.flex.items-center:has(.records-toggle-btn:hover)::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background-color: #7c3aed;
            z-index: 10;
        }
        
        /* Dark mode styling */
        .dark-mode .bg-white.px-4.py-3.flex.items-center:has(.records-view-btn:hover),
        .dark-mode .bg-white.px-4.py-3.flex.items-center:has(.records-toggle-btn:hover) {
            background-color: rgba(124, 58, 237, 0.1) !important;
        }
        
        .dark-mode .bg-white.px-4.py-3.flex.items-center:has(.records-view-btn:hover)::before,
        .dark-mode .bg-white.px-4.py-3.flex.items-center:has(.records-toggle-btn:hover)::before {
            background-color: #8b5cf6;
        }
    `;
    document.head.appendChild(style);
    
    // Fallback for browsers that don't support :has
    // Apply event listeners to all buttons
    document.querySelectorAll('.records-view-btn, .records-toggle-btn').forEach(button => {
        // Find the parent row
        let row = button.closest('.bg-white.px-4.py-3.flex.items-center');
        if (!row) return;
        
        // Add hover effects
        button.addEventListener('mouseenter', () => {
            row.classList.add('record-row-highlighted');
        });
        
        button.addEventListener('mouseleave', () => {
            row.classList.remove('record-row-highlighted');
        });
    });
}

function watchForChanges() {
    // Create a new observer for any changes to the DOM
    const observer = new MutationObserver(mutations => {
        let shouldRefresh = false;
        
        // Check if any new buttons were added
        mutations.forEach(mutation => {
            if (mutation.addedNodes.length) {
                mutation.addedNodes.forEach(node => {
                    if (node.nodeType === 1) { // Element node
                        if (node.querySelector('.records-view-btn, .records-toggle-btn')) {
                            shouldRefresh = true;
                        }
                    }
                });
            }
        });
        
        // If new buttons were added, refresh the event listeners
        if (shouldRefresh) {
            setTimeout(() => {
                document.querySelectorAll('.records-view-btn, .records-toggle-btn').forEach(button => {
                    // Only add listeners if they haven't been added before
                    if (!button.hasAttribute('data-hover-initialized')) {
                        let row = button.closest('.bg-white.px-4.py-3.flex.items-center');
                        if (!row) return;
                        
                        button.addEventListener('mouseenter', () => {
                            row.classList.add('record-row-highlighted');
                        });
                        
                        button.addEventListener('mouseleave', () => {
                            row.classList.remove('record-row-highlighted');
                        });
                        
                        button.setAttribute('data-hover-initialized', 'true');
                    }
                });
            }, 50);
        }
    });
    
    // Start observing the entire document
    observer.observe(document.body, {
        childList: true,
        subtree: true
    });
}
