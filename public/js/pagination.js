// Pagination functionality
document.addEventListener('DOMContentLoaded', function() {
    const paginationButtons = document.querySelectorAll('.pagination-button');
    
    if (paginationButtons.length > 0) {
        // Find the first page number button (not prev/next)
        const pageButtons = Array.from(paginationButtons).filter(btn => !btn.querySelector('i'));
        if (pageButtons.length > 0) {
            // Set default active page to the first number button
            pageButtons[0].classList.add('active');
            pageButtons[0].classList.add('bg-purple-500');
            pageButtons[0].classList.add('text-white');
            pageButtons[0].classList.remove('bg-white');
            pageButtons[0].classList.remove('text-gray-700');
        }
        
        // Add click handlers to page buttons
        paginationButtons.forEach(button => {
            if (!button.querySelector('i')) { // Skip prev/next buttons for now
                button.addEventListener('click', function() {
                    // Remove active class from all buttons
                    paginationButtons.forEach(btn => {
                        if (!btn.querySelector('i')) { // Only target number buttons
                            btn.classList.remove('active');
                            btn.classList.remove('bg-purple-500');
                            btn.classList.remove('text-white');
                            btn.classList.add('bg-white');
                            btn.classList.add('text-gray-700');
                        }
                    });
                    
                    // Add active class to clicked button
                    this.classList.add('active');
                    this.classList.add('bg-purple-500');
                    this.classList.add('text-white');
                    this.classList.remove('bg-white');
                    this.classList.remove('text-gray-700');
                    
                    // Here you would also fetch the appropriate page data
                    // For now, we'll just update the "Showing" text
                    const pageNum = parseInt(this.textContent.trim());
                    const startRecord = (pageNum - 1) * 10 + 1;
                    const endRecord = Math.min(pageNum * 10, 496); // Assuming 496 total records
                    
                    document.querySelector('.showing-text').textContent = 
                        `Showing ${startRecord} - ${endRecord} of 496 rooms`;
                    
                    // Enable/disable prev/next buttons based on current page
                    const prevButton = document.querySelector('.pagination-button:first-child');
                    const nextButton = document.querySelector('.pagination-button:last-child');
                    
                    prevButton.disabled = pageNum === 1;
                    nextButton.disabled = pageNum === 50; // Assuming 50 pages total (496 records / 10 per page)
                    
                    // Add/remove disabled styling
                    if (pageNum === 1) {
                        prevButton.classList.add('opacity-50');
                    } else {
                        prevButton.classList.remove('opacity-50');
                    }
                    
                    if (pageNum === 50) {
                        nextButton.classList.add('opacity-50');
                    } else {
                        nextButton.classList.remove('opacity-50');
                    }
                });
            }
        });
        
        // Add functionality to previous/next buttons
        const prevButton = document.querySelector('.pagination-button:first-child');
        const nextButton = document.querySelector('.pagination-button:last-child');
        
        prevButton.addEventListener('click', function() {
            if (!this.disabled) {
                // Find the currently active button
                const activeButton = document.querySelector('.pagination-button.active');
                const currentPage = parseInt(activeButton.textContent.trim());
                
                if (currentPage > 1) {
                    // Click the previous page button
                    document.querySelector(`.pagination-button:nth-child(${currentPage})`).click();
                }
            }
        });
        
        nextButton.addEventListener('click', function() {
            if (!this.disabled) {
                // Find the currently active button
                const activeButton = document.querySelector('.pagination-button.active');
                const currentPage = parseInt(activeButton.textContent.trim());
                
                if (currentPage < 50) { // Assuming 50 pages total
                    // Click the next page button
                    document.querySelector(`.pagination-button:nth-child(${currentPage + 2})`).click();
                }
            }
        });
        
        // Records per page selector
        const recordsPerPageSelect = document.querySelector('select');
        if (recordsPerPageSelect) {
            recordsPerPageSelect.addEventListener('change', function() {
                // Here you would implement the logic to change records per page
                // For now, just log the selected value
                console.log(`Records per page changed to: ${this.value}`);
                
                // Reset to page 1
                document.querySelector('.pagination-button:nth-child(2)').click();
            });
        }
    }
}); 