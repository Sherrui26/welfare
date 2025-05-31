document.addEventListener('DOMContentLoaded', function() {
    // Initialize activity pagination
    initActivityPagination();
    
    function initActivityPagination() {
        const paginationSections = document.querySelectorAll('[id^="activityPaginationButtons"]');
        
        paginationSections.forEach(paginationSection => {
            if (!paginationSection) return;
            
            const prevButton = paginationSection.querySelector('[id^="activityPrevPage"]');
            const nextButton = paginationSection.querySelector('[id^="activityNextPage"]');
            const pageButtons = paginationSection.querySelectorAll('.activity-page-btn');
            
            if (!pageButtons.length) return;
            
            // Add click handlers to page buttons
            pageButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Remove active styling from all page buttons
                    pageButtons.forEach(btn => {
                        btn.classList.remove('bg-purple-500');
                        btn.classList.remove('text-white');
                        btn.classList.remove('border-purple-500');
                        btn.classList.remove('active');
                        btn.classList.add('bg-white');
                        btn.classList.add('text-gray-500');
                        btn.classList.add('border-gray-300');
                    });
                    
                    // Add active styling to the clicked button
                    this.classList.add('active');
                    this.classList.add('bg-purple-500');
                    this.classList.add('text-white');
                    this.classList.add('border-purple-500');
                    this.classList.remove('bg-white');
                    this.classList.remove('text-gray-500');
                    this.classList.remove('border-gray-300');
                    
                    // Get current page number
                    const pageNum = parseInt(this.textContent.trim());
                    
                    // Enable/disable prev/next buttons
                    prevButton.disabled = pageNum === 1;
                    if (pageNum === 1) {
                        prevButton.classList.add('opacity-50');
                        prevButton.classList.add('cursor-not-allowed');
                    } else {
                        prevButton.classList.remove('opacity-50');
                        prevButton.classList.remove('cursor-not-allowed');
                    }
                    
                    // Update the Next button based on if we're on the last page
                    const lastPage = pageButtons.length;
                    nextButton.disabled = pageNum === lastPage;
                    if (pageNum === lastPage) {
                        nextButton.classList.add('opacity-50');
                        nextButton.classList.add('cursor-not-allowed');
                    } else {
                        nextButton.classList.remove('opacity-50');
                        nextButton.classList.remove('cursor-not-allowed');
                    }
                    
                    // Update the activity range indicators
                    updateActivityRangeIndicator(pageNum, paginationSection);
                });
            });
            
            // Add functionality to previous button
            if (prevButton) {
                prevButton.addEventListener('click', function() {
                    if (!this.disabled) {
                        // Find currently active button
                        const activeButton = paginationSection.querySelector('.pagination-button.active');
                        if (!activeButton) return;
                        
                        const currentPage = parseInt(activeButton.textContent.trim());
                        
                        if (currentPage > 1) {
                            // Click previous page button - click the button with page number = currentPage - 1
                            const prevPageButton = Array.from(pageButtons).find(btn => 
                                parseInt(btn.textContent.trim()) === currentPage - 1
                            );
                            if (prevPageButton) prevPageButton.click();
                        }
                    }
                });
            }
            
            // Add functionality to next button
            if (nextButton) {
                nextButton.addEventListener('click', function() {
                    if (!this.disabled) {
                        // Find currently active button
                        const activeButton = paginationSection.querySelector('.pagination-button.active');
                        if (!activeButton) return;
                        
                        const currentPage = parseInt(activeButton.textContent.trim());
                        
                        if (currentPage < pageButtons.length) {
                            // Click next page button - click the button with page number = currentPage + 1
                            const nextPageButton = Array.from(pageButtons).find(btn => 
                                parseInt(btn.textContent.trim()) === currentPage + 1
                            );
                            if (nextPageButton) nextPageButton.click();
                        }
                    }
                });
            }
        });
    }
    
    function updateActivityRangeIndicator(page, paginationSection) {
        const parentModal = paginationSection.closest('.rounded-lg');
        if (!parentModal) return;
        
        const startRecordElement = parentModal.querySelector('[id^="activityStartRecord"]');
        const endRecordElement = parentModal.querySelector('[id^="activityEndRecord"]');
        const totalRecordsElement = parentModal.querySelector('[id^="activityTotalRecords"]');
        
        if (!startRecordElement || !endRecordElement || !totalRecordsElement) return;
        
        const totalRecords = parseInt(totalRecordsElement.textContent);
        const itemsPerPage = 5; // Assuming 5 items per page
        
        const startRecord = (page - 1) * itemsPerPage + 1;
        const endRecord = Math.min(page * itemsPerPage, totalRecords);
        
        startRecordElement.textContent = startRecord;
        endRecordElement.textContent = endRecord;
    }
});
