// Filter Panel Functionality
document.addEventListener('DOMContentLoaded', function() {
    // Toggle Filters Panel
    const toggleFiltersButton = document.getElementById('toggleFilters');
    const filterPanel = document.getElementById('filterPanel');
    
    if (toggleFiltersButton && filterPanel) {
        toggleFiltersButton.addEventListener('click', function() {
            filterPanel.classList.toggle('visible');
            
            // Update the button text only if there's a span
            const text = this.querySelector('span');
            if (text) {
                if (filterPanel.classList.contains('visible')) {
                    text.textContent = 'Close Filters';
                } else {
                    text.textContent = 'Filters';
                }
            }
            
            // No longer changing the icon class
        });
    }
    
    // Handle filters functionality
    const filterStatusInputs = document.querySelectorAll('input[name="filter-status"]');
    const filterFloorInputs = document.querySelectorAll('input[name="filter-floor"]');
    const filterTypeInputs = document.querySelectorAll('input[name="filter-type"]');
    const searchInput = document.getElementById('searchRooms');
    const clearFiltersBtn = document.getElementById('clearFilters');
    const resetFiltersBtn = document.getElementById('resetFilters');
    const roomItems = document.querySelectorAll('.room-item');
    
    // Function to apply filters
    function applyFilters() {
        // Get selected values
        const selectedStatuses = Array.from(filterStatusInputs)
            .filter(input => input.checked)
            .map(input => input.value);
        
        const selectedFloors = Array.from(filterFloorInputs)
            .filter(input => input.checked)
            .map(input => input.value);
        
        const selectedTypes = Array.from(filterTypeInputs)
            .filter(input => input.checked)
            .map(input => input.value);
        
        const searchTerm = searchInput.value.toLowerCase();
        
        // Show/hide rooms based on filters
        roomItems.forEach(item => {
            const roomNumber = item.querySelector('[data-room]').getAttribute('data-room');
            const roomStatus = item.getAttribute('data-status');
            const roomFloor = roomNumber.charAt(0);
            const roomType = item.getAttribute('data-type') || 'standard';
            
            // Check if room matches filters
            const matchesStatus = selectedStatuses.length === 0 || selectedStatuses.includes(roomStatus);
            const matchesFloor = selectedFloors.length === 0 || selectedFloors.includes(roomFloor);
            const matchesType = selectedTypes.length === 0 || selectedTypes.includes(roomType);
            const matchesSearch = !searchTerm || roomNumber.includes(searchTerm);
            
            // Show or hide based on all filters
            if (matchesStatus && matchesFloor && matchesType && matchesSearch) {
                item.classList.remove('hidden');
            } else {
                item.classList.add('hidden');
            }
        });
        
        // Update the count of visible rooms
        updateVisibleRoomCount();
    }
    
    // Function to clear all filters
    function clearAllFilters() {
        // Uncheck all filter inputs
        filterStatusInputs.forEach(input => {
            input.checked = false;
        });
        
        filterFloorInputs.forEach(input => {
            input.checked = false;
        });
        
        filterTypeInputs.forEach(input => {
            input.checked = false;
        });
        
        // Clear search input
        searchInput.value = '';
        
        // Show all rooms
        roomItems.forEach(item => {
            item.classList.remove('hidden');
        });
        
        // Update the count
        updateVisibleRoomCount();
    }
    
    // Function to reset to advanced filters default state
    function resetAdvancedFilters() {
        // Hide the filter panel
        filterPanel.classList.remove('visible');
        
        // Set filters to show everything
        clearAllFilters();
        
        // Update the toggle button text only if there's a span
        const text = toggleFiltersButton.querySelector('span');
        if (text) {
            text.textContent = 'Filters';
        }
        
        // No longer changing the icon class
    }
    
    // Function to update the visible room count
    function updateVisibleRoomCount() {
        const visibleCount = Array.from(roomItems).filter(item => !item.classList.contains('hidden')).length;
        const totalCount = roomItems.length;
        
        const countDisplay = document.getElementById('roomCountDisplay');
        if (countDisplay) {
            countDisplay.textContent = `Showing ${visibleCount} of ${totalCount} rooms`;
        }
    }
    
    // Add event listeners to filters
    filterStatusInputs.forEach(input => {
        input.addEventListener('change', applyFilters);
    });
    
    filterFloorInputs.forEach(input => {
        input.addEventListener('change', applyFilters);
    });
    
    filterTypeInputs.forEach(input => {
        input.addEventListener('change', applyFilters);
    });
    
    if (searchInput) {
        searchInput.addEventListener('input', applyFilters);
    }
    
    if (clearFiltersBtn) {
        clearFiltersBtn.addEventListener('click', clearAllFilters);
    }
    
    if (resetFiltersBtn) {
        resetFiltersBtn.addEventListener('click', resetAdvancedFilters);
    }
    
    // Initialize room count
    updateVisibleRoomCount();
}); 