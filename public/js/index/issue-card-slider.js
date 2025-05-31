// JavaScript for Issue & Clearance Card Slider
document.addEventListener('DOMContentLoaded', function() {
    // Issue & Clearance Card Slider functionality
    const issueCardsContainer = document.getElementById('issueCardsContainer');
    const issuePrevButton = document.getElementById('issuePrevButton');
    const issueNextButton = document.getElementById('issueNextButton');
    let issueCurrentPosition = 0;
    const issueCards = document.querySelectorAll('.issue-card');
    const issueVisibleCards = window.innerWidth < 768 ? 1 : 3; // Show 1 card on mobile, 3 on desktop
    const issueTotalCards = issueCards.length;
    const issueMaxPosition = Math.max(0, issueTotalCards - issueVisibleCards);
    
    // Initialize prev/next button states
    updateIssueButtons();
    
    // Add event listeners to buttons
    issuePrevButton.addEventListener('click', function() {
        if (issueCurrentPosition > 0) {
            issueCurrentPosition--;
            updateIssueSlider();
        }
    });
    
    issueNextButton.addEventListener('click', function() {
        if (issueCurrentPosition < issueMaxPosition) {
            issueCurrentPosition++;
            updateIssueSlider();
        }
    });
    
    // Function to update the slider position
    function updateIssueSlider() {
        const cardWidth = issueCards[0].offsetWidth;
        const translateX = -1 * issueCurrentPosition * cardWidth;
        issueCardsContainer.style.transform = `translateX(${translateX}px)`;
        updateIssueButtons();
    }
    
    // Function to update button states
    function updateIssueButtons() {
        issuePrevButton.disabled = issueCurrentPosition === 0;
        issuePrevButton.classList.toggle('opacity-50', issueCurrentPosition === 0);
        issuePrevButton.classList.toggle('cursor-not-allowed', issueCurrentPosition === 0);
        
        issueNextButton.disabled = issueCurrentPosition >= issueMaxPosition;
        issueNextButton.classList.toggle('opacity-50', issueCurrentPosition >= issueMaxPosition);
        issueNextButton.classList.toggle('cursor-not-allowed', issueCurrentPosition >= issueMaxPosition);
    }
    
    // Handle window resize for responsive behavior
    window.addEventListener('resize', function() {
        const newVisibleCards = window.innerWidth < 768 ? 1 : 3;
        if (newVisibleCards !== issueVisibleCards) {
            issueVisibleCards = newVisibleCards;
            issueMaxPosition = Math.max(0, issueTotalCards - issueVisibleCards);
            issueCurrentPosition = Math.min(issueCurrentPosition, issueMaxPosition);
            updateIssueSlider();
        }
    });
    
    // Records Modal functionality
    const viewAllRecordsBtn = document.getElementById('viewAllRecordsBtn');
    const recordsModal = document.getElementById('recordsModal');
    const closeRecordsModal = document.getElementById('closeRecordsModal');
    
    if (viewAllRecordsBtn && recordsModal && closeRecordsModal) {
        // Open modal when clicking the View All Records button
        viewAllRecordsBtn.addEventListener('click', function() {
            window.ModalNavigation.open(recordsModal);
        });
        
        // Close modal when clicking the close button
        closeRecordsModal.addEventListener('click', function() {
            window.ModalNavigation.close(recordsModal);
        });
        
        // Close modal when clicking outside
        recordsModal.addEventListener('click', function(e) {
            if (e.target === recordsModal) {
                window.ModalNavigation.close(recordsModal);
            }
        });
        
        // Initialize Records pagination
        initRecordsPagination();
    }
    
    // Records pagination functionality
    function initRecordsPagination() {
        const paginationButtons = document.querySelectorAll('#recordPaginationButtons .record-page-btn');
        const prevButton = document.getElementById('recordPrevPage');
        const nextButton = document.getElementById('recordNextPage');
        const recordsPerPageSelect = document.getElementById('recordsPerPage');
        
        if (paginationButtons.length) {
            // Add click handlers to page buttons
            paginationButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Remove active styling from all page buttons
                    paginationButtons.forEach(btn => {
                        btn.classList.remove('bg-purple-500');
                        btn.classList.remove('text-white');
                        btn.classList.remove('border-purple-500');
                        btn.classList.remove('active');
                        btn.classList.add('bg-white');
                        btn.classList.add('text-gray-700');
                        btn.classList.add('border-gray-300');
                    });
                    
                    // Add active styling to the clicked button
                    this.classList.add('active');
                    this.classList.add('bg-purple-500');
                    this.classList.add('text-white');
                    this.classList.remove('bg-white');
                    this.classList.remove('text-gray-700');
                    
                    // Update prev/next button states
                    const pageNum = parseInt(this.textContent.trim());
                    prevButton.disabled = (pageNum === 1);
                    prevButton.classList.toggle('opacity-50', pageNum === 1);
                    prevButton.classList.toggle('cursor-not-allowed', pageNum === 1);
                    nextButton.disabled = (pageNum === paginationButtons.length);
                    nextButton.classList.toggle('opacity-50', pageNum === paginationButtons.length);
                    nextButton.classList.toggle('cursor-not-allowed', pageNum === paginationButtons.length);
                    
                    // Update showing records text
                    updateRecordsDisplay(pageNum);
                });
            });
            
            // Add click handlers for prev/next buttons
            if (prevButton) {
                prevButton.addEventListener('click', function() {
                    if (this.disabled) return;
                    
                    const activePage = document.querySelector('#recordPaginationButtons .record-page-btn.active');
                    if (!activePage) return;
                    
                    const currentPage = parseInt(activePage.textContent.trim());
                    
                    if (currentPage > 1) {
                        // Click previous page button - click the button with page number = currentPage - 1
                        const prevPageButton = Array.from(paginationButtons).find(btn => 
                            parseInt(btn.textContent.trim()) === currentPage - 1
                        );
                        if (prevPageButton) prevPageButton.click();
                    }
                });
            }
            
            if (nextButton) {
                nextButton.addEventListener('click', function() {
                    if (this.disabled) return;
                    
                    const activePage = document.querySelector('#recordPaginationButtons .record-page-btn.active');
                    if (!activePage) return;
                    
                    const currentPage = parseInt(activePage.textContent.trim());
                    
                    if (currentPage < paginationButtons.length) {
                        // Click next page button - click the button with page number = currentPage + 1
                        const nextPageButton = Array.from(paginationButtons).find(btn => 
                            parseInt(btn.textContent.trim()) === currentPage + 1
                        );
                        if (nextPageButton) nextPageButton.click();
                    }
                });
            }
            
            // Add change handler for records per page
            if (recordsPerPageSelect) {
                recordsPerPageSelect.addEventListener('change', function() {
                    // Reset to first page when changing records per page
                    paginationButtons[0].click();
                    updateRecordsDisplay(1);
                });
            }
            
            // Function to update the records display
            function updateRecordsDisplay(pageNum) {
                const itemsPerPage = recordsPerPageSelect ? parseInt(recordsPerPageSelect.value) : 50;
                const totalRecords = 24; // Total number of records (hardcoded for demo)
                const startRecord = (pageNum - 1) * itemsPerPage + 1;
                const endRecord = Math.min(pageNum * itemsPerPage, totalRecords);
                
                document.getElementById('recordStartRecord').textContent = startRecord;
                document.getElementById('recordEndRecord').textContent = endRecord;
                document.getElementById('recordTotalRecords').textContent = totalRecords;
            }
            
            // Initialize display
            updateRecordsDisplay(1);
        }
    }
});
