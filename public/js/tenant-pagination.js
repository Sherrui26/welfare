// Variables for tenant pagination
let currentTenantPage = 1;
let tenantsPerPage = 6; // Default
let allTenantCards = []; // To store reference to all cards initially

function initializeTenantPagination() {
    // Store all initial cards
    allTenantCards = Array.from(document.querySelectorAll('#tenantCardGrid .tenant-card'));
    
    // Reset to first page when initializing
    currentTenantPage = 1;
    
    // Get initial tenants per page from selector if available
    const perPageSelect = document.getElementById('tenantsPerPageSelect');
    if (perPageSelect && perPageSelect.value) {
        tenantsPerPage = parseInt(perPageSelect.value);
    }
    
    // Set up pagination navigation
    const prevPageBtn = document.getElementById('prevPage');
    const nextPageBtn = document.getElementById('nextPage');
    
    if (prevPageBtn) {
        prevPageBtn.addEventListener('click', function() {
            if (currentTenantPage > 1) {
                changeTenantPage(currentTenantPage - 1);
            }
        });
    }
    
    if (nextPageBtn) {
        nextPageBtn.addEventListener('click', function() {
            const visibleCards = getVisibleTenantCards();
            const totalPages = Math.ceil(visibleCards.length / tenantsPerPage);
            if (currentTenantPage < totalPages) {
                changeTenantPage(currentTenantPage + 1);
            }
        });
    }
    
    // Set up the tenantsPerPage selector
    if (perPageSelect) {
        perPageSelect.addEventListener('change', function() {
            changeTenantsPerPage(parseInt(this.value));
        });
    }
    
    // Calculate and update the initial tenant display
    updateTenantDisplay();
}

function getVisibleTenantCards() {
    // Only returns tenant cards that are not hidden by filters
    // "hidden" is the class used by the filter functions
    return allTenantCards.filter(card => !card.classList.contains('hidden'));
}

function changeTenantPage(page) {
    const visibleCards = getVisibleTenantCards();
    const totalPages = Math.ceil(visibleCards.length / tenantsPerPage);
    
    // Ensure page is within valid range
    currentTenantPage = Math.max(1, Math.min(page, totalPages));
    
    // Update display with new page
    updateTenantDisplay();
}

function changeTenantsPerPage(perPage) {
    tenantsPerPage = perPage;
    currentTenantPage = 1; // Reset to first page when changing items per page
    updateTenantDisplay();
    
    // Regenerate pagination buttons based on new items per page count
    generateTenantPaginationButtons();
}

function updateTenantDisplay() {
    const visibleCards = getVisibleTenantCards();
    const totalVisible = visibleCards.length;
    const totalPages = Math.ceil(totalVisible / tenantsPerPage);
    
    // If current page is out of bounds after filtering, reset to page 1
    if (currentTenantPage > totalPages && totalPages > 0) {
        currentTenantPage = 1;
    }
    
    const startIndex = (currentTenantPage - 1) * tenantsPerPage;
    const endIndex = startIndex + tenantsPerPage;
    
    // First, hide all tenant cards from pagination
    allTenantCards.forEach(card => {
        card.classList.add('pagination-hidden');
    });
    
    // Then show only the cards for current page
    for (let i = 0; i < visibleCards.length; i++) {
        if (i >= startIndex && i < endIndex) {
            visibleCards[i].classList.remove('pagination-hidden');
        } else {
            visibleCards[i].classList.add('pagination-hidden');
        }
    }
    
    // Update pagination counters
    updatePaginationCounters(totalVisible);
    
    // Update pagination buttons visibility
    updateTenantPaginationButtons();
    
    // Generate pagination number buttons if they don't exist yet
    if (document.querySelectorAll('.tenant-page-btn').length === 0) {
        generateTenantPaginationButtons();
    }
}

function generateTenantPaginationButtons() {
    const visibleCards = getVisibleTenantCards();
    const totalPages = Math.ceil(visibleCards.length / tenantsPerPage);
    const paginationContainer = document.getElementById('tenantPaginationButtons');
    
    // Clear existing page number buttons
    const existingButtons = document.querySelectorAll('.tenant-page-btn');
    existingButtons.forEach(btn => btn.remove());
    
    if (!paginationContainer) return;
    
    // Get the next button as reference for insertion
    const nextPageBtn = document.getElementById('nextPage');
    if (!nextPageBtn) return;
    
    // Determine which page buttons to show (max 5)
    const maxButtons = 5;
    let startPage = Math.max(1, currentTenantPage - Math.floor(maxButtons / 2));
    let endPage = Math.min(totalPages, startPage + maxButtons - 1);
    
    // Adjust if we're near the end
    if (endPage - startPage + 1 < maxButtons && startPage > 1) {
        startPage = Math.max(1, endPage - maxButtons + 1);
    }
    
    // Create page number buttons
    for (let i = startPage; i <= endPage; i++) {
        const isActive = i === currentTenantPage;
        const pageButton = document.createElement('button');
        pageButton.className = `tenant-page-btn pagination-button w-8 h-8 flex items-center justify-center rounded-md border ${isActive ? 'active bg-purple-500 text-white border-purple-500' : 'bg-white text-gray-500 hover:bg-gray-50 border-gray-300'}`;
        pageButton.textContent = i;
        pageButton.addEventListener('click', function() {
            changeTenantPage(i);
        });
        
        // Insert before the next button
        paginationContainer.insertBefore(pageButton, nextPageBtn);
    }
}

function updateTenantPaginationButtons() {
    const visibleCards = getVisibleTenantCards();
    const totalPages = Math.ceil(visibleCards.length / tenantsPerPage);
    
    // Enable/disable prev/next buttons
    const prevPageBtn = document.getElementById('prevPage');
    const nextPageBtn = document.getElementById('nextPage');
    
    if (prevPageBtn) {
        prevPageBtn.disabled = currentTenantPage <= 1;
        if (prevPageBtn.disabled) {
            prevPageBtn.classList.add('opacity-50', 'cursor-not-allowed');
            prevPageBtn.classList.remove('hover:bg-gray-50');
        } else {
            prevPageBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            prevPageBtn.classList.add('hover:bg-gray-50');
        }
    }
    
    if (nextPageBtn) {
        nextPageBtn.disabled = currentTenantPage >= totalPages || totalPages === 0;
        if (nextPageBtn.disabled) {
            nextPageBtn.classList.add('opacity-50', 'cursor-not-allowed');
            nextPageBtn.classList.remove('hover:bg-gray-50');
        } else {
            nextPageBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            nextPageBtn.classList.add('hover:bg-gray-50');
        }
    }
    
    // Regenerate the page number buttons to make sure they match the current state
    generateTenantPaginationButtons();
}

// Utility function to get the current page number
function getCurrentTenantPage() {
    return currentTenantPage;
}

// Utility function to get the current tenants per page
function getCurrentTenantsPerPage() {
    return tenantsPerPage;
}

// Make functions globally accessible if needed in other files
window.getCurrentTenantPage = getCurrentTenantPage;
window.getCurrentTenantsPerPage = getCurrentTenantsPerPage;
window.changeTenantsPerPage = changeTenantsPerPage; 