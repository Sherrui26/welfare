// Execute immediately and also on DOMContentLoaded
(function removeNoResultsMessage() {
    function hideMessages() {
        // Find and remove any no-results-message divs
        const noResultsMessages = document.querySelectorAll('#no-results-message');
        noResultsMessages.forEach(el => {
            el.remove(); // Completely remove from DOM
        });

        // Also set up a MutationObserver to catch any dynamically added ones
        const observer = new MutationObserver(mutations => {
            mutations.forEach(mutation => {
                if (mutation.addedNodes.length) {
                    mutation.addedNodes.forEach(node => {
                        if (node.id === 'no-results-message' || 
                            (node.querySelector && node.querySelector('#no-results-message'))) {
                            const message = node.id === 'no-results-message' ? 
                                node : node.querySelector('#no-results-message');
                            if (message) message.remove();
                        }
                    });
                }
            });
        });

        // Watch the entire body for changes
        observer.observe(document.body, { childList: true, subtree: true });
    }

    // Run immediately
    hideMessages();
    
    // Also run when DOM is fully loaded
    document.addEventListener('DOMContentLoaded', hideMessages);
})();
