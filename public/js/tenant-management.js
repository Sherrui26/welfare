document.addEventListener('DOMContentLoaded', function() {
    initializeTenantPage();
});

function initializeTenantPage() {
    // Initialize toggle buttons
    initializeToggles();
    
    // Initialize search functionality
    initializeSearch();
    
    // Initialize filters
    initializeFilters();
    
    // Set up tenant card click events
    setupTenantCards();
    
    // Setup Add New Tenant button
    setupAddTenantButton();
    
    // Initialize main tenant list pagination
    initializeTenantPagination();
    
    // Initialize resident overlay if the function exists
    if (typeof initializeResidentOverlay === 'function') {
        initializeResidentOverlay();
    }
    
    // Add tight-layout class to tenant cards when no expanded view
    document.getElementById('tenantCardsContainer').classList.add('tight-layout');

    // Initial display calculation
    updateTenantDisplay();
}

function initializeToggles() {
    // Toggle the filter panel
    const filterToggle = document.getElementById('toggleFilters');
    const filterPanel = document.getElementById('filterPanel');
    
    if (filterToggle && filterPanel) {
        filterToggle.addEventListener('click', function() {
            filterPanel.classList.toggle('visible');
        });
    }
}

function initializeFilters() {
    // Set up filter buttons
    const filterButtons = document.querySelectorAll('.filter-btn');
    
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remove selected class from all buttons
            filterButtons.forEach(btn => btn.classList.remove('selected'));
            
            // Add selected class to clicked button
            this.classList.add('selected');
            
            // Get filter value
            const filter = this.getAttribute('data-filter');
            
            // Filter tenant cards
            filterTenantCards(filter);
        });
    });
    
    // Set up filter panel actions
    const applyFiltersBtn = document.getElementById('applyFilters');
    const resetFiltersBtn = document.getElementById('resetFilters');
    
    if (applyFiltersBtn) {
        applyFiltersBtn.addEventListener('click', function() {
            applyAdvancedFilters();
        });
    }
    
    if (resetFiltersBtn) {
        resetFiltersBtn.addEventListener('click', function() {
            resetAdvancedFilters();
        });
    }
}

function filterTenantCards(filter) {
    const tenantCards = document.querySelectorAll('.tenant-card');
    const emptyState = document.getElementById('emptyState');
    let matchCount = 0;
    
    tenantCards.forEach(card => {
        const cardStatus = card.getAttribute('data-status');
        
        if (filter === 'all' || cardStatus === filter) {
            card.classList.remove('hidden');
            matchCount++;
        } else {
            card.classList.add('hidden');
        }
    });
    
    // Show empty state if no matches found
    if (emptyState) {
        if (matchCount === 0) {
            emptyState.classList.remove('hidden');
        } else {
            emptyState.classList.add('hidden');
        }
    }
    
    // Update the display with pagination
    updateTenantDisplay();
}

function applyAdvancedFilters() {
    const contractStatus = document.getElementById('contractStatus').value;
    const staffCount = document.getElementById('staffCount').value;
    const sortBy = document.getElementById('sortBy').value;
    
    // Get all tenant cards
    const tenantCards = document.querySelectorAll('.tenant-card');
    const emptyState = document.getElementById('emptyState');
    let matchCount = 0;
    
    tenantCards.forEach(card => {
        let showCard = true;
        
        // Filter by contract status if selected
        if (contractStatus && card.getAttribute('data-status') !== contractStatus) {
            showCard = false;
        }
        
        // Filter by staff count if selected
        if (staffCount && showCard) {
            const cardStaffCount = parseInt(card.getAttribute('data-staff-count'));
            
            if (staffCount === '1-10' && (cardStaffCount < 1 || cardStaffCount > 10)) {
                showCard = false;
            } else if (staffCount === '11-20' && (cardStaffCount < 11 || cardStaffCount > 20)) {
                showCard = false;
            } else if (staffCount === '21+' && cardStaffCount < 21) {
                showCard = false;
            }
        }
        
        // Show or hide the card
        if (showCard) {
            card.classList.remove('hidden');
            matchCount++;
        } else {
            card.classList.add('hidden');
        }
    });
    
    // Show empty state if no matches found
    if (emptyState) {
        if (matchCount === 0) {
            emptyState.classList.remove('hidden');
        } else {
            emptyState.classList.add('hidden');
        }
    }
    
    // Sort cards if needed
    if (sortBy) {
        sortTenantCards(sortBy);
    }
    
    // Update display with pagination
    updateTenantDisplay();
    
    // Update selected filter button based on contract status
    if (contractStatus) {
        const filterButtons = document.querySelectorAll('.filter-btn');
        filterButtons.forEach(btn => btn.classList.remove('selected'));
        
        if (contractStatus === 'active') {
            document.querySelector('.filter-btn[data-filter="active"]').classList.add('selected');
        } else if (contractStatus === 'pending') {
            document.querySelector('.filter-btn[data-filter="pending-renewal"]').classList.add('selected');
        } else {
            document.querySelector('.filter-btn[data-filter="all"]').classList.add('selected');
        }
    }
    
    // Close filter panel
    document.getElementById('filterPanel').classList.remove('visible');
}

function sortTenantCards(sortField) {
    const cardGrid = document.getElementById('tenantCardGrid');
    const cards = Array.from(cardGrid.querySelectorAll('.tenant-card:not(.hidden)'));
    
    cards.sort((a, b) => {
        switch(sortField) {
            case 'name':
                return a.querySelector('h2').textContent.localeCompare(b.querySelector('h2').textContent);
            case 'staffCount':
                return parseInt(b.getAttribute('data-staff-count')) - parseInt(a.getAttribute('data-staff-count'));
            case 'roomCount':
                return parseInt(b.getAttribute('data-rooms')) - parseInt(a.getAttribute('data-rooms'));
            
            default:
                return 0;
        }
    });
    
    // Clear and re-append cards in the sorted order
    cards.forEach(card => cardGrid.appendChild(card));
}

function resetAdvancedFilters() {
    // Reset all filter controls
    document.getElementById('contractStatus').selectedIndex = 0;
    document.getElementById('staffCount').selectedIndex = 0;
    document.getElementById('sortBy').selectedIndex = 0;
    
    // Reset tenant display
    filterTenantCards('all');
    
    // Update filter button selection
    const filterButtons = document.querySelectorAll('.filter-btn');
    filterButtons.forEach(btn => btn.classList.remove('selected'));
    document.querySelector('.filter-btn[data-filter="all"]').classList.add('selected');
    
    // Close filter panel
    document.getElementById('filterPanel').classList.remove('visible');
}

function initializeSearch() {
    const searchInput = document.getElementById('tenantSearch');
    const searchLoader = document.getElementById('searchLoader');
    
    if (searchInput) {
        let searchTimeout = null;
        
        searchInput.addEventListener('input', function() {
            const query = this.value.trim().toLowerCase();
            
            // Clear previous timeout
            if (searchTimeout) {
                clearTimeout(searchTimeout);
            }
            
            // Show loader for searches
            if (query.length > 0) {
                searchLoader.classList.remove('hidden');
            }
            
            // Set a timeout to prevent too many searches while typing
            searchTimeout = setTimeout(() => {
                searchTenants(query);
                searchLoader.classList.add('hidden');
            }, 500);
        });
        
        // Reset search button
        const resetSearchBtn = document.getElementById('resetSearch');
        if (resetSearchBtn) {
            resetSearchBtn.addEventListener('click', function() {
                searchInput.value = '';
                searchTenants('');
            });
        }
    }
}

function searchTenants(query) {
    const tenantCards = document.querySelectorAll('.tenant-card');
    const emptyState = document.getElementById('emptyState');
    let matchCount = 0;
    
    // Reset all highlight effects
    document.querySelectorAll('.search-highlight').forEach(el => {
        el.classList.remove('search-highlight');
    });
    
    if (query === '') {
        // If search is cleared, show all cards based on current filter
        const currentFilter = document.querySelector('.filter-btn.selected').getAttribute('data-filter');
        filterTenantCards(currentFilter);
        return;
    }
    
    tenantCards.forEach(card => {
        const tenantName = card.getAttribute('data-tenant').toLowerCase();
        const cardContent = card.textContent.toLowerCase();
        
        if (cardContent.includes(query) || tenantName.includes(query)) {
            card.classList.remove('hidden');
            matchCount++;
            
            // Add a subtle highlight effect
            card.classList.add('search-highlight');
        } else {
            card.classList.add('hidden');
        }
    });
    
    // Show empty state if no matches found
    if (emptyState) {
        if (matchCount === 0) {
            emptyState.classList.remove('hidden');
        } else {
            emptyState.classList.add('hidden');
        }
    }
    
    // Update display with pagination
    updateTenantDisplay();
}

function updatePaginationCounters(totalVisible) {
    const startRecord = document.getElementById('startRecord');
    const endRecord = document.getElementById('endRecord');
    const totalRecords = document.getElementById('totalRecords');
    const tenantsPerPage = getCurrentTenantsPerPage();
    const currentPage = getCurrentTenantPage();
    
    if (startRecord && endRecord && totalRecords) {
        totalRecords.textContent = totalVisible;
        
        if (totalVisible === 0) {
            startRecord.textContent = '0';
            endRecord.textContent = '0';
        } else {
            const start = (currentPage - 1) * tenantsPerPage + 1;
            const end = Math.min(start + tenantsPerPage - 1, totalVisible);
            startRecord.textContent = start;
            endRecord.textContent = end;
        }
    }
} 