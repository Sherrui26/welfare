// Custom pagination handler for this page
document.addEventListener('DOMContentLoaded', function() {
    // Get the pagination elements for this specific section
    const paginationContainer = document.querySelector('.mt-4.flex.justify-between.items-center .flex.items-center.space-x-1');
    if (paginationContainer) {
        const buttons = paginationContainer.querySelectorAll('.pagination-button');
        const prevButton = buttons[0]; // First button (left arrow)
        const nextButton = buttons[buttons.length - 1]; // Last button (right arrow)
        const pageButtons = Array.from(buttons).slice(1, buttons.length - 1); // Number buttons
        
        // Add click handlers to page buttons
        pageButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Remove active styling from all page buttons
                pageButtons.forEach(btn => {
                    btn.classList.remove('active');
                    btn.classList.remove('bg-purple-500');
                    btn.classList.remove('text-white');
                    btn.classList.add('bg-white');
                    btn.classList.add('text-gray-700');
                });
                
                // Add active styling to the clicked button
                this.classList.add('active');
                this.classList.add('bg-purple-500');
                this.classList.add('text-white');
                this.classList.remove('bg-white');
                this.classList.remove('text-gray-700');
                
                // Get current page number
                const pageNum = parseInt(this.textContent.trim());
                
                // Enable/disable prev/next buttons
                prevButton.disabled = pageNum === 1;
                if (pageNum === 1) {
                    prevButton.classList.add('disabled');
                    prevButton.setAttribute('disabled', 'disabled');
                } else {
                    prevButton.classList.remove('disabled');
                    prevButton.removeAttribute('disabled');
                }
                
                // Update the Next button based on if we're on the last page
                const lastPage = pageButtons.length;
                nextButton.disabled = pageNum === lastPage;
                if (pageNum === lastPage) {
                    nextButton.classList.add('disabled');
                    nextButton.setAttribute('disabled', 'disabled');
                } else {
                    nextButton.classList.remove('disabled');
                    nextButton.removeAttribute('disabled');
                }
            });
        });
        
        // Add functionality to previous button
        prevButton.addEventListener('click', function() {
            if (!this.disabled) {
                // Find currently active button
                const activeButton = paginationContainer.querySelector('.pagination-button.active');
                const currentPage = parseInt(activeButton.textContent.trim());
                
                if (currentPage > 1) {
                    // Click previous page button
                    pageButtons[currentPage - 2].click();
                }
            }
        });
        
        // Add functionality to next button
        nextButton.addEventListener('click', function() {
            if (!this.disabled) {
                // Find currently active button
                const activeButton = paginationContainer.querySelector('.pagination-button.active');
                const currentPage = parseInt(activeButton.textContent.trim());
                
                if (currentPage < pageButtons.length) {
                    // Click next page button
                    pageButtons[currentPage - 1 + 1].click();
                }
            }
        });
    }
});
