// Filter button selection logic
const filterButtons = document.querySelectorAll('.filter-btn');
filterButtons.forEach(button => {
    button.addEventListener('click', function() {
        // Remove selected class from all buttons
        filterButtons.forEach(btn => {
            btn.classList.remove('selected');
        });
        
        // Add selected class to the clicked button
        this.classList.add('selected');
        
        // Get the filter value from data-filter attribute
        const filterValue = this.getAttribute('data-filter');
        
        // Apply filtering to table rows
        filterRoomTable(filterValue);
    });
});

// Function to filter the room table based on button selection
function filterRoomTable(filterValue) {
    // Get table container
    const tableContainer = document.querySelector('.overflow-hidden.rounded-lg.border.border-gray-200');
    
    // More specific selector for room rows
    const roomRows = tableContainer.querySelectorAll('div.bg-white.px-4.py-3.flex.items-center.justify-between.border-b');
    
    // Get all detail rows
    const detailRows = tableContainer.querySelectorAll('div.staff-list-row');
    
    // Count visible rows for debugging
    let availableCount = 0;
    let occupiedCount = 0;
    let maintenanceCount = 0;
    let totalRooms = 0;
    
    // Loop through each room row and determine if it should be shown
    roomRows.forEach((row, index) => {
        totalRooms++;
        
        // Get the room status from all possible status elements
        const statusElement = row.querySelector('.status');
        let roomStatus = "";
        
        if (statusElement) {
            // Check the class list for status indicators in addition to the text content
            const isAvailable = statusElement.classList.contains('status-available');
            const isOccupied = statusElement.classList.contains('status-occupied');
            const isMaintenance = statusElement.classList.contains('status-maintenance');
            
            // Get text content as a backup
            roomStatus = statusElement.textContent.trim().toLowerCase();
            
            // Use class presence for more reliable detection
            if (isAvailable) {
                availableCount++;
                roomStatus = 'available';
            } else if (isOccupied) {
                occupiedCount++;
                roomStatus = 'occupied';
            } else if (isMaintenance) {
                maintenanceCount++;
                roomStatus = 'maintenance';
            }
            
        }
        
        // Find the corresponding detail row 
        // (it's the next element sibling, but we double-check to make sure it's a staff-list-row)
        let detailRow = null;
        const nextElement = row.nextElementSibling;
        if (nextElement && nextElement.classList.contains('staff-list-row')) {
            detailRow = nextElement;
        }
        
        let shouldShow = true;
        
        // Apply filter based on selection
        if (filterValue === 'available') {
            // Show only available rooms
            shouldShow = roomStatus === 'available';
        } else if (filterValue === 'occupied') {
            // Show only occupied rooms
            shouldShow = roomStatus === 'occupied';
        } else if (filterValue === 'maintenance') {
            // Show only rooms under maintenance
            shouldShow = roomStatus === 'maintenance';
        }
        // If "all" is selected, shouldShow remains true for all rows
        
        // Show or hide the row and its detail row
        if (shouldShow) {
            row.style.display = '';
            if (detailRow) {
                detailRow.style.display = '';
            }
        } else {
            row.style.display = 'none';
            if (detailRow) {
                detailRow.style.display = 'none';
            }
        }
    });
    
    // Update the table appearance after filtering
    updateTableAfterFiltering(Array.from(roomRows));
}

// Function to apply advanced filters
function applyAdvancedFilters() {
    // Get filter values
    const floorValue = document.getElementById('floorFilter').value;
    const roomTypeValue = document.getElementById('roomTypeFilter').value;
    const statusValue = document.getElementById('statusFilter').value;
    const companyValue = document.getElementById('companyFilter').value;
    
    // Get table container
    const tableContainer = document.querySelector('.overflow-hidden.rounded-lg.border.border-gray-200');
    
    // More specific selector for room rows
    const roomRows = tableContainer.querySelectorAll('div.bg-white.px-4.py-3.flex.items-center.justify-between.border-b');
    
    // Counter for visible rows
    let visibleRows = 0;
    
    // Loop through each room row and apply filters
    roomRows.forEach(row => {
        // Get room data
        const roomFloor = getRoomFloor(row); // You'd need to extract this from the room number
        const roomType = getRoomType(row); // This would need to be extracted from the displayed data
        
        // Get status using the same method as filterRoomTable
        const statusElement = row.querySelector('.status');
        let roomStatus = "";
        
        if (statusElement) {
            if (statusElement.classList.contains('status-available')) {
                roomStatus = 'available';
            } else if (statusElement.classList.contains('status-occupied')) {
                roomStatus = 'occupied';
            } else if (statusElement.classList.contains('status-maintenance')) {
                roomStatus = 'maintenance';
            }
        }
        
        // Get company info
        const companyCell = row.querySelector('.w-\\[15\\%\\]:nth-of-type(1)');
        const company = companyCell ? companyCell.textContent.trim().toLowerCase() : 'n/a';
        
        // Find the corresponding detail row
        let detailRow = null;
        const nextElement = row.nextElementSibling;
        if (nextElement && nextElement.classList.contains('staff-list-row')) {
            detailRow = nextElement;
        }
        
        // Determine if row should be shown based on filters
        let shouldShow = true;
        
        // Apply floor filter
        if (floorValue && roomFloor !== floorValue) {
            shouldShow = false;
        }
        
        // Apply room type filter
        if (roomTypeValue && roomType !== roomTypeValue) {
            shouldShow = false;
        }
        
        // Apply status filter
        if (statusValue && roomStatus !== statusValue) {
            shouldShow = false;
        }
        
        // Apply company filter
        if (companyValue && !company.includes(companyValue.toLowerCase())) {
            shouldShow = false;
        }
        
        // Show or hide based on filter results
        if (shouldShow) {
            row.style.display = '';
            if (detailRow) detailRow.style.display = '';
            visibleRows++;
        } else {
            row.style.display = 'none';
            if (detailRow) detailRow.style.display = 'none';
        }
    });
    
    // Update the table appearance
    updateTableAfterFiltering(Array.from(roomRows));
    
    // Update the selected filter button
    if (statusValue) {
        // If status filter is used, update the corresponding filter button
        filterButtons.forEach(btn => {
            btn.classList.remove('selected');
        });
        
        const matchingButton = document.querySelector(`.filter-btn[data-filter="${statusValue}"]`);
        if (matchingButton) {
            matchingButton.classList.add('selected');
        } else {
            // If no matching button, select "All" button
            document.querySelector('.filter-btn[data-filter="all"]').classList.add('selected');
        }
    }
    
    // Close the filter panel
    document.getElementById('filterPanel').classList.remove('visible');
}

// Function to reset all filters
function resetAdvancedFilters() {
    // Reset select elements to default values
    document.getElementById('floorFilter').selectedIndex = 0;
    document.getElementById('roomTypeFilter').selectedIndex = 0;
    document.getElementById('statusFilter').selectedIndex = 0;
    document.getElementById('companyFilter').selectedIndex = 0;
    
    // Reset to show all rooms
    const allButton = document.querySelector('.filter-btn[data-filter="all"]');
    if (allButton) {
        // Update selected button
        filterButtons.forEach(btn => {
            btn.classList.remove('selected');
        });
        allButton.classList.add('selected');
        
        // Apply all rooms filter
        filterRoomTable('all');
    }
    
    // Close the filter panel
    document.getElementById('filterPanel').classList.remove('visible');
}

// Helper function to get floor number from room row
function getRoomFloor(row) {
    // Extract room number from the row
    const roomNumberCell = row.querySelector('.w-\\[18\\%\\] span');
    if (!roomNumberCell) return '';
    
    const roomNumber = roomNumberCell.textContent.trim();
    
    // Parse the room number format (7-XX-XX) to get floor
    const parts = roomNumber.split('-');
    if (parts.length > 1) {
        return parts[1].replace(/^0+/, ''); // Remove leading zeros
    }
    
    return '';
}

// Helper function to get room type from row
function getRoomType(row) {
    // For this demo, we'll default to standard as there's no direct way
    // to get this from the table row without additional data attributes
    return 'standard';
}

// Function to clean up table appearance after filtering
function updateTableAfterFiltering(roomRows) {
    // Find all visible rows
    const visibleRows = roomRows.filter(row => row.style.display !== 'none');
    
    // Add appropriate border styling to the last visible row
    if (visibleRows.length > 0) {
        visibleRows.forEach(row => {
            row.classList.remove('last-visible-row');
        });
        
        visibleRows[visibleRows.length - 1].classList.add('last-visible-row');
    }
    
    // Check if we have any visible rows
    const noVisibleRows = visibleRows.length === 0;
    
    // Show a message if no rows are visible after filtering
    // but ONLY on the manage-room.html page, not on the index.html page
    if (window.location.pathname.includes('manage-room.html')) {
        let noResultsMessage = document.getElementById('no-results-message');
        
        if (noVisibleRows) {
            if (!noResultsMessage) {
                // Create a "no results" message if it doesn't exist
                const tableContainer = document.querySelector('.overflow-hidden.rounded-lg.border.border-gray-200');
                
                if (tableContainer) {
                    noResultsMessage = document.createElement('div');
                    noResultsMessage.id = 'no-results-message';
                    noResultsMessage.className = 'p-8 text-center text-gray-500';
                    noResultsMessage.innerHTML = '<i class="fas fa-search mb-2 text-2xl"></i><p>No rooms match the selected filter.</p>';
                    
                    tableContainer.appendChild(noResultsMessage);
                }
            }
            
            if (noResultsMessage) {
                noResultsMessage.style.display = 'block';
            }
        } else if (noResultsMessage) {
            // Hide the message if we have visible rows
            noResultsMessage.style.display = 'none';
        }
    } else {
        // On other pages (like index.html), always hide the no-results message
        const noResultsMessage = document.getElementById('no-results-message');
        if (noResultsMessage) {
            noResultsMessage.style.display = 'none';
            // For debugging purposes
            console.log('Hiding no-results-message on non-manage-room page');
        }
    }
}
// Apply the default filter (All Rooms) on page load
document.addEventListener('DOMContentLoaded', function() {
    // Get the currently selected filter button
    const selectedFilter = document.querySelector('.filter-btn.selected');
    
    if (selectedFilter) {
        const filterValue = selectedFilter.getAttribute('data-filter');
        filterRoomTable(filterValue);
    }
    
    // Set up the toggle filter button (already in the HTML)
    // const toggleFiltersButton = document.getElementById('toggleFilters');
    // const filterPanel = document.getElementById('filterPanel');
    // This is already set up in the manage-room.html file
    
    // Set up apply and reset filter buttons
    const applyFiltersBtn = document.getElementById('applyFilters');
    const resetFiltersBtn = document.getElementById('resetFilters');
    
    if (applyFiltersBtn) {
        applyFiltersBtn.addEventListener('click', applyAdvancedFilters);
    }
    
    if (resetFiltersBtn) {
        resetFiltersBtn.addEventListener('click', resetAdvancedFilters);
    }

    // Action Menu Toggles
    const actionToggleButtons = document.querySelectorAll('.toggle-actions');
    
    actionToggleButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.stopPropagation();
            
            // Remove active class from all buttons first
            document.querySelectorAll('.toggle-actions').forEach(btn => {
                btn.classList.remove('active');
            });
            
            // Close all other menus first
            document.querySelectorAll('.action-menu').forEach(menu => {
                if (menu !== this.nextElementSibling) {
                    menu.classList.add('hidden');
                }
            });
            
            // Remove row highlighting from all rows
            document.querySelectorAll('.row-action-highlighted').forEach(row => {
                row.classList.remove('row-action-highlighted');
            });
            
            // Toggle this menu
            const menu = this.nextElementSibling;
            const isVisible = !menu.classList.contains('hidden');
            
            menu.classList.toggle('hidden');
            
            // Add active class to this button if menu is now visible
            if (!isVisible) {
                this.classList.add('active');
                
                // Find the parent row and add highlighting
                const parentRow = this.closest('.flex.items-center.justify-between');
                if (parentRow) {
                    parentRow.classList.add('row-action-highlighted');
                }
            }
        });
    });
    
    // Close action menus when clicking outside
    document.addEventListener('click', function() {
        document.querySelectorAll('.action-menu').forEach(menu => {
            menu.classList.add('hidden');
        });
        
        // Remove active class from all toggle buttons
        document.querySelectorAll('.toggle-actions').forEach(btn => {
            btn.classList.remove('active');
        });
        
        // Remove row highlighting
        document.querySelectorAll('.row-action-highlighted').forEach(row => {
            row.classList.remove('row-action-highlighted');
        });
    });
    
    // Auto-position dropdown menus based on available space
    actionToggleButtons.forEach(button => {
        // Check if this is one of the last three rows (rooms 510, 208, and 610)
        const roomNumber = button.getAttribute('data-room');
        if (roomNumber === '610' || roomNumber === '510' || roomNumber === '208') {
            const menu = button.nextElementSibling;
            menu.classList.remove('mt-2');
            menu.classList.add('bottom-full', 'mb-2');
        }
    });
});
