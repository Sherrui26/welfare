/**
 * Welfare System - Room Management JavaScript
 * Handles AJAX interactions, modals, and dynamic UI updates for the room management view
 */
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips, action menus, and other UI components
    initializeUI();
    
    // Setup event listeners for room actions (edit, delete, view)
    setupRoomActions();
    
    // Setup event listeners for modals
    setupModalListeners();
    
    // Setup event listeners for form submissions
    setupFormSubmissions();
    
    // Setup event listeners for filtering and pagination
    setupFiltering();
});

/**
 * Initialize UI components
 */
function initializeUI() {
    // Initialize action menus (three dots menu)
    document.querySelectorAll('.action-menu-button').forEach(button => {
        button.addEventListener('click', function(e) {
            e.stopPropagation();
            const menuContainer = this.closest('.action-menu-container');
            const menu = menuContainer.querySelector('.action-menu');
            
            // Close all other menus first
            document.querySelectorAll('.action-menu').forEach(m => {
                if (m !== menu) m.classList.add('hidden');
            });
            
            // Toggle this menu
            menu.classList.toggle('hidden');
        });
    });
    
    // Close menus when clicking outside
    document.addEventListener('click', function() {
        document.querySelectorAll('.action-menu').forEach(menu => {
            menu.classList.add('hidden');
        });
    });
    
    // Toggle room details when clicking on expand icon
    document.querySelectorAll('.toggle-details').forEach(button => {
        button.addEventListener('click', function(e) {
            e.stopPropagation();
            const targetId = this.getAttribute('data-target');
            const detailsSection = document.getElementById(targetId);
            const icon = this.querySelector('.toggle-icon');
            
            if (detailsSection) {
                detailsSection.classList.toggle('hidden');
                
                // Toggle icon
                if (detailsSection.classList.contains('hidden')) {
                    icon.classList.remove('fa-chevron-up');
                    icon.classList.add('fa-chevron-down');
                } else {
                    icon.classList.remove('fa-chevron-down');
                    icon.classList.add('fa-chevron-up');
                }
            }
        });
    });
    
    // Make entire row clickable to toggle details
    document.querySelectorAll('[data-toggle="collapse"]').forEach(row => {
        row.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const detailsSection = document.getElementById(targetId.replace('#', ''));
            const toggleButton = this.querySelector('.toggle-details');
            
            if (detailsSection && toggleButton) {
                toggleButton.click();
            }
        });
    });
}

/**
 * Setup event listeners for room actions
 */
function setupRoomActions() {
    // View room details
    document.querySelectorAll('.view-room-btn').forEach(button => {
        button.addEventListener('click', function() {
            const roomId = this.getAttribute('data-room-id');
            loadRoomDetails(roomId);
        });
    });
    
    // Edit room
    document.querySelectorAll('.edit-room-btn').forEach(button => {
        button.addEventListener('click', function() {
            const roomId = this.getAttribute('data-room-id');
            loadRoomForEdit(roomId);
        });
    });
    
    // Delete room
    document.querySelectorAll('.delete-room-btn').forEach(button => {
        button.addEventListener('click', function() {
            const roomId = this.getAttribute('data-room-id');
            const roomNumber = this.closest('.room-row').querySelector('.room-number').textContent.trim();
            confirmDeleteRoom(roomId, roomNumber);
        });
    });
}

/**
 * Setup modal listeners
 */
function setupModalListeners() {
    // Add Room Modal
    const addRoomBtn = document.getElementById('addRoomBtn');
    if (addRoomBtn) {
        addRoomBtn.addEventListener('click', function() {
            const modal = document.getElementById('addRoomModal');
            if (modal) {
                modal.classList.remove('hidden');
                
                // Reset form
                const form = modal.querySelector('form');
                if (form) form.reset();
            }
        });
    }
    
    // Close modals
    document.querySelectorAll('.close-modal').forEach(button => {
        button.addEventListener('click', function() {
            const modal = this.closest('.modal');
            if (modal) modal.classList.add('hidden');
        });
    });
    
    // Close modals when clicking outside the content
    document.querySelectorAll('.modal').forEach(modal => {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.add('hidden');
            }
        });
    });
}

/**
 * Setup form submissions
 */
function setupFormSubmissions() {
    // Add Room Form
    const addRoomForm = document.getElementById('addRoomForm');
    if (addRoomForm) {
        addRoomForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const url = `${baseUrl}room/create`;
            
            // Display loading indicator
            showLoading(true);
            
            fetch(url, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                showLoading(false);
                
                if (data.success) {
                    // Show success message
                    showAlert('success', data.message);
                    
                    // Close modal
                    document.getElementById('addRoomModal').classList.add('hidden');
                    
                    // Reload page to show new room
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    // Show error message
                    showAlert('error', data.message);
                    
                    // Display validation errors if any
                    if (data.errors) {
                        displayValidationErrors(data.errors);
                    }
                }
            })
            .catch(error => {
                showLoading(false);
                showAlert('error', 'An error occurred while creating the room');
                console.error('Error:', error);
            });
        });
    }
    
    // Edit Room Form
    const editRoomForm = document.getElementById('editRoomForm');
    if (editRoomForm) {
        editRoomForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const roomId = document.getElementById('editRoomId').value;
            const url = `${baseUrl}/room/update/${roomId}`;
            
            // Display loading indicator
            showLoading(true);
            
            fetch(url, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                showLoading(false);
                
                if (data.success) {
                    // Show success message
                    showAlert('success', data.message);
                    
                    // Close modal
                    document.getElementById('editRoomModal').classList.add('hidden');
                    
                    // Reload page to show updated room
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    // Show error message
                    showAlert('error', data.message);
                    
                    // Display validation errors if any
                    if (data.errors) {
                        displayValidationErrors(data.errors);
                    }
                }
            })
            .catch(error => {
                showLoading(false);
                showAlert('error', 'An error occurred while updating the room');
                console.error('Error:', error);
            });
        });
    }
    
    // Delete Room Form
    const deleteRoomForm = document.getElementById('deleteRoomForm');
    if (deleteRoomForm) {
        deleteRoomForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const roomId = document.getElementById('deleteRoomId').value;
            const url = `${baseUrl}/room/delete/${roomId}`;
            
            // Display loading indicator
            showLoading(true);
            
            fetch(url, {
                method: 'POST'
            })
            .then(response => response.json())
            .then(data => {
                showLoading(false);
                
                if (data.success) {
                    // Show success message
                    showAlert('success', data.message);
                    
                    // Close modal
                    document.getElementById('deleteRoomModal').classList.add('hidden');
                    
                    // Reload page to update room list
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    // Show error message
                    showAlert('error', data.message);
                }
            })
            .catch(error => {
                showLoading(false);
                showAlert('error', 'An error occurred while deleting the room');
                console.error('Error:', error);
            });
        });
    }
}

/**
 * Load room details for the view modal
 */
function loadRoomDetails(roomId) {
    // Display loading indicator
    showLoading(true);
    
    const url = `${baseUrl}/room/getRoomDetails/${roomId}`;
    
    fetch(url)
    .then(response => response.json())
    .then(data => {
        showLoading(false);
        
        if (data.success) {
            const roomDetails = data.roomDetails;
            const room = roomDetails.room;
            
            // Update modal with room details
            document.getElementById('modalRoomNumber').textContent = `Room ${room.room_number}`;
            
            // Set room status with appropriate class
            const statusElement = document.getElementById('modalRoomStatus');
            statusElement.textContent = room.status.charAt(0).toUpperCase() + room.status.slice(1);
            statusElement.className = 'status';
            statusElement.classList.add(`status-${room.status}`);
            
            // Update room info
            document.getElementById('roomType').textContent = room.room_type.charAt(0).toUpperCase() + room.room_type.slice(1);
            document.getElementById('roomFloor').textContent = `${room.floor} Floor`;
            document.getElementById('roomCapacity').textContent = `${room.capacity} beds`;
            
            // Update occupancy info
            const occupiedBedspaces = roomDetails.occupiedBedspaces;
            const availableBedspaces = roomDetails.availableBedspaces;
            document.getElementById('occupiedBedspaces').textContent = occupiedBedspaces;
            document.getElementById('availableBedspaces').textContent = availableBedspaces;
            
            // Update occupants list
            const occupantsList = document.getElementById('occupantsList');
            occupantsList.innerHTML = '';
            
            if (roomDetails.occupants.length > 0) {
                roomDetails.occupants.forEach(occupant => {
                    const occupantItem = document.createElement('div');
                    occupantItem.className = 'flex justify-between items-center py-2 border-b border-gray-100';
                    
                    // Format the check-in date
                    const checkInDate = new Date(occupant.check_in_date);
                    const formattedDate = checkInDate.toLocaleDateString('en-US', {
                        year: 'numeric',
                        month: 'short',
                        day: 'numeric'
                    });
                    
                    occupantItem.innerHTML = `
                        <div>
                            <span class="font-medium">${occupant.occupant_name}</span>
                            <p class="text-xs text-gray-500">${occupant.nationality}</p>
                        </div>
                        <div class="text-xs text-gray-500">
                            Since: ${formattedDate}
                        </div>
                    `;
                    
                    occupantsList.appendChild(occupantItem);
                });
            } else {
                occupantsList.innerHTML = '<p class="text-gray-500 py-2">No occupants in this room</p>';
            }
            
            // Update amenities list
            const amenitiesList = document.getElementById('amenitiesList');
            amenitiesList.innerHTML = '';
            
            if (roomDetails.amenities.length > 0) {
                roomDetails.amenities.forEach(amenity => {
                    const amenityItem = document.createElement('span');
                    amenityItem.className = 'bg-gray-100 text-gray-700 text-xs px-2 py-1 rounded-full inline-block mr-1 mb-1';
                    amenityItem.textContent = amenity.name;
                    amenitiesList.appendChild(amenityItem);
                });
            } else {
                amenitiesList.innerHTML = '<p class="text-gray-500">No amenities listed</p>';
            }
            
            // Update maintenance logs
            const maintenanceList = document.getElementById('maintenanceList');
            maintenanceList.innerHTML = '';
            
            if (roomDetails.maintenanceLogs.length > 0) {
                roomDetails.maintenanceLogs.forEach(log => {
                    const logItem = document.createElement('div');
                    logItem.className = 'bg-gray-50 p-2 rounded-lg mb-2';
                    
                    // Format the dates
                    const logDate = new Date(log.maintenance_date);
                    const formattedLogDate = logDate.toLocaleDateString('en-US', {
                        year: 'numeric',
                        month: 'short',
                        day: 'numeric'
                    });
                    
                    logItem.innerHTML = `
                        <div class="flex justify-between">
                            <span class="font-medium text-sm">${log.maintenance_type}</span>
                            <span class="text-xs text-gray-500">${formattedLogDate}</span>
                        </div>
                        <p class="text-xs text-gray-700 mt-1">${log.maintenance_note}</p>
                    `;
                    
                    maintenanceList.appendChild(logItem);
                });
            } else {
                maintenanceList.innerHTML = '<p class="text-gray-500">No maintenance records</p>';
            }
            
            // Show the modal
            document.getElementById('roomDetailsModal').classList.remove('hidden');
        } else {
            showAlert('error', data.message || 'Failed to load room details');
        }
    })
    .catch(error => {
        showLoading(false);
        showAlert('error', 'An error occurred while loading room details');
        console.error('Error:', error);
    });
}

/**
 * Load room data for editing
 */
function loadRoomForEdit(roomId) {
    // Display loading indicator
    showLoading(true);
    
    const url = `${baseUrl}/room/get/${roomId}`;
    
    fetch(url)
    .then(response => response.json())
    .then(data => {
        showLoading(false);
        
        if (data.success) {
            const room = data.room;
            
            // Set room ID for form submission
            document.getElementById('editRoomId').value = room.id;
            
            // Fill form fields
            document.getElementById('editRoomNumber').value = room.room_number;
            document.getElementById('editFloor').value = room.floor;
            document.getElementById('editRoomType').value = room.room_type;
            document.getElementById('editCapacity').value = room.capacity;
            document.getElementById('editStatus').value = room.status;
            
            // Show/hide status-specific fields
            toggleStatusFields(room.status, 'edit');
            
            // Fill status-specific fields if needed
            if (room.status === 'maintenance') {
                document.getElementById('editMaintenanceNote').value = room.maintenance_note || '';
                if (room.next_maintenance_date) {
                    document.getElementById('editNextMaintenanceDate').value = formatDateForInput(room.next_maintenance_date);
                }
            } else if (room.status === 'blocked') {
                document.getElementById('editBlockReason').value = room.block_reason || '';
            }
            
            // Show the modal
            document.getElementById('editRoomModal').classList.remove('hidden');
        } else {
            showAlert('error', data.message || 'Failed to load room data');
        }
    })
    .catch(error => {
        showLoading(false);
        showAlert('error', 'An error occurred while loading room data');
        console.error('Error:', error);
    });
}

/**
 * Setup filtering functionality
 */
function setupFiltering() {
    // Filter form submission
    const filterForm = document.getElementById('roomFilterForm');
    if (filterForm) {
        filterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Build query string from form data
            const formData = new FormData(this);
            const params = new URLSearchParams();
            
            for (const [key, value] of formData.entries()) {
                if (value) {
                    params.append(key, value);
                }
            }
            
            // Redirect to filtered URL
            window.location.href = `${baseUrl}/room?${params.toString()}`;
        });
    }
    
    // Reset filters
    const resetFiltersBtn = document.getElementById('resetFilters');
    if (resetFiltersBtn) {
        resetFiltersBtn.addEventListener('click', function() {
            window.location.href = `${baseUrl}/room`;
        });
    }
}

/**
 * Confirm room deletion
 */
function confirmDeleteRoom(roomId, roomNumber) {
    const modal = document.getElementById('deleteRoomModal');
    if (modal) {
        // Set room ID and number
        document.getElementById('deleteRoomId').value = roomId;
        document.getElementById('deleteRoomNumber').textContent = roomNumber;
        
        // Show the modal
        modal.classList.remove('hidden');
    }
}

/**
 * Toggle status-specific fields based on selected status
 */
function toggleStatusFields(status, prefix = '') {
    const maintenanceFields = document.getElementById(`${prefix}MaintenanceFields`);
    const blockFields = document.getElementById(`${prefix}BlockFields`);
    
    if (maintenanceFields && blockFields) {
        if (status === 'maintenance') {
            maintenanceFields.classList.remove('hidden');
            blockFields.classList.add('hidden');
        } else if (status === 'blocked') {
            maintenanceFields.classList.add('hidden');
            blockFields.classList.remove('hidden');
        } else {
            maintenanceFields.classList.add('hidden');
            blockFields.classList.add('hidden');
        }
    }
}

/**
 * Format date for input fields (YYYY-MM-DD)
 */
function formatDateForInput(dateString) {
    const date = new Date(dateString);
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    
    return `${year}-${month}-${day}`;
}

/**
 * Display validation errors under form fields
 */
function displayValidationErrors(errors) {
    // Clear previous error messages
    document.querySelectorAll('.error-message').forEach(el => el.remove());
    
    // Add error messages under each field
    for (const field in errors) {
        const inputField = document.querySelector(`[name="${field}"]`);
        if (inputField) {
            const errorSpan = document.createElement('span');
            errorSpan.className = 'error-message text-xs text-red-500 mt-1';
            errorSpan.textContent = errors[field];
            
            const parentElement = inputField.parentElement;
            parentElement.appendChild(errorSpan);
            
            // Highlight the field
            inputField.classList.add('border-red-500');
        }
    }
}

/**
 * Show a notification alert
 */
function showAlert(type, message) {
    const alertContainer = document.getElementById('alertContainer');
    if (!alertContainer) return;
    
    const alertDiv = document.createElement('div');
    alertDiv.className = 'alert fixed top-20 right-4 p-4 rounded-lg shadow-lg max-w-md z-50 transition-all duration-300 transform translate-x-full';
    
    if (type === 'success') {
        alertDiv.classList.add('bg-green-100', 'border-l-4', 'border-green-500', 'text-green-700');
    } else if (type === 'error') {
        alertDiv.classList.add('bg-red-100', 'border-l-4', 'border-red-500', 'text-red-700');
    } else if (type === 'warning') {
        alertDiv.classList.add('bg-yellow-100', 'border-l-4', 'border-yellow-500', 'text-yellow-700');
    } else {
        alertDiv.classList.add('bg-blue-100', 'border-l-4', 'border-blue-500', 'text-blue-700');
    }
    
    alertDiv.innerHTML = `
        <div class="flex items-start">
            <div class="py-1">
                <i class="fas ${type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle'} mr-2"></i>
            </div>
            <div>
                <p>${message}</p>
            </div>
            <button class="ml-auto text-gray-400 hover:text-gray-700 close-alert">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    
    alertContainer.appendChild(alertDiv);
    
    // Show the alert
    setTimeout(() => {
        alertDiv.classList.remove('translate-x-full');
    }, 10);
    
    // Add event listener to close button
    const closeButton = alertDiv.querySelector('.close-alert');
    if (closeButton) {
        closeButton.addEventListener('click', () => {
            alertDiv.classList.add('translate-x-full');
            setTimeout(() => {
                alertDiv.remove();
            }, 300);
        });
    }
    
    // Auto close after 5 seconds
    setTimeout(() => {
        if (alertDiv.parentNode) {
            alertDiv.classList.add('translate-x-full');
            setTimeout(() => {
                if (alertDiv.parentNode) {
                    alertDiv.remove();
                }
            }, 300);
        }
    }, 5000);
}

/**
 * Show/hide loading indicator
 */
function showLoading(show) {
    const loadingIndicator = document.getElementById('loadingIndicator');
    if (loadingIndicator) {
        if (show) {
            loadingIndicator.classList.remove('hidden');
        } else {
            loadingIndicator.classList.add('hidden');
        }
    }
}

// Status change event handlers
document.addEventListener('DOMContentLoaded', function() {
    // Add event listener to status select in add room form
    const addStatusSelect = document.getElementById('roomStatus');
    if (addStatusSelect) {
        addStatusSelect.addEventListener('change', function() {
            toggleStatusFields(this.value);
        });
    }
    
    // Add event listener to status select in edit room form
    const editStatusSelect = document.getElementById('editStatus');
    if (editStatusSelect) {
        editStatusSelect.addEventListener('change', function() {
            toggleStatusFields(this.value, 'edit');
        });
    }
});
