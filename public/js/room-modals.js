document.addEventListener('DOMContentLoaded', function() {
    // Room Details Modal
    const modal = document.getElementById('roomDetailsModal');
    const closeModal = document.getElementById('closeModal');
    const showRoomDetailsButtons = document.querySelectorAll('.show-room-details');
    
    // Add/Edit Room Modal
    const addRoomModal = document.getElementById('addRoomModal');
    const addRoomButton = document.getElementById('addRoomButton');
    const closeAddRoomModal = document.getElementById('closeAddRoomModal');
    const cancelAddRoomButton = document.getElementById('cancelAddRoom');
    
    // Animation timing constant
    const FADE_OUT_DURATION = 300; // ms
    
    // Close Room Details Modal handler
    if (closeModal && modal) {
        closeModal.addEventListener('click', function() {
            // Use ModalNavigation utility if available
            if (window.ModalNavigation) {
                window.ModalNavigation.close(modal);
            } else {
                // Fallback to direct animation
                modal.classList.remove('active');
                setTimeout(() => {
                    modal.classList.add('hidden');
                }, FADE_OUT_DURATION);
            }
        });
    }
    
    // Show Room Details Modal for each room button
    if (showRoomDetailsButtons.length > 0 && modal) {
        showRoomDetailsButtons.forEach(button => {
            button.addEventListener('click', function() {
                const roomNumber = this.getAttribute('data-room');
                
                // Update modal title with room number
                document.getElementById('modalRoomNumber').textContent = `Room ${roomNumber} Details`;
                
                // Fetch and populate room data (in a real app, this would be an API call)
                populateRoomDetails(roomNumber);
                
                // Use ModalNavigation utility if available
                if (window.ModalNavigation) {
                    window.ModalNavigation.open(modal);
                } else {
                    // Fallback to direct animation
                    modal.classList.remove('hidden');
                    // Force reflow to ensure animation works
                    void modal.offsetWidth;
                    setTimeout(() => {
                        modal.classList.add('active');
                    }, 20);
                }
            });
        });
    }
    
    // Close Add/Edit Room Modal
    if (closeAddRoomModal && addRoomModal) {
        closeAddRoomModal.addEventListener('click', function() {
            // Use ModalNavigation utility if available
            if (window.ModalNavigation) {
                window.ModalNavigation.close(addRoomModal);
            } else {
                // Fallback to direct animation
                addRoomModal.classList.remove('active');
                setTimeout(() => {
                    addRoomModal.classList.add('hidden');
                }, FADE_OUT_DURATION);
            }
        });
    }
    
    // Cancel button in Add/Edit Room Modal
    if (cancelAddRoomButton && addRoomModal) {
        cancelAddRoomButton.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Use ModalNavigation utility if available
            if (window.ModalNavigation) {
                window.ModalNavigation.close(addRoomModal);
            } else {
                // Fallback to direct animation
                addRoomModal.classList.remove('active');
                setTimeout(() => {
                    addRoomModal.classList.add('hidden');
                }, FADE_OUT_DURATION);
            }
        });
    }
    
    // Function to populate room details (would be populated from backend in a real app)
    function populateRoomDetails(roomNumber) {
        // Set the status based on the room number
        const roomStatus = document.getElementById('modalRoomStatus');
        if (roomStatus) {
            // Just some demo logic to show different statuses
            if (roomNumber === '601' || roomNumber === '407') {
                roomStatus.className = 'status status-occupied';
                roomStatus.textContent = 'Occupied';
            } else if (roomNumber === '505' || roomNumber === '608') {
                roomStatus.className = 'status status-maintenance';
                roomStatus.textContent = 'Maintenance';
            } else if (roomNumber === '302' || roomNumber === '210') {
                roomStatus.className = 'status status-unavailable';
                roomStatus.textContent = 'Unavailable';
            } else {
                roomStatus.className = 'status status-available';
                roomStatus.textContent = 'Available';
            }
        }
        
        // Set other room details
        document.getElementById('roomType').textContent = 'Standard Dormitory';
        document.getElementById('roomFloor').textContent = roomNumber.charAt(0) + 'th Floor';
        document.getElementById('roomCapacity').textContent = '6 persons';
        document.getElementById('roomRate').textContent = '$350 per bed';
        document.getElementById('roomMaintenance').textContent = 'Jan 15, 2025';
        document.getElementById('roomCleaning').textContent = 'Weekly (Thursday)';
        
        // Show tenants if room is occupied
        const tenantList = document.getElementById('modalTenantList');
        if (tenantList) {
            // Clear previous tenant list
            tenantList.innerHTML = '';
            
            if (roomStatus.textContent === 'Occupied') {
                // Demo tenants
                const tenants = [
                    { name: 'Ahmad Faisal', id: 'AE123456', company: 'Sri Paandi', checkIn: '2023-06-01', checkout: '2023-12-31' },
                    { name: 'Rajesh Kumar', id: 'AU789012', company: 'Global Tech', checkIn: '2023-07-15', checkout: '2023-10-15' }
                ];
                
                tenants.forEach(tenant => {
                    const tenantItem = document.createElement('div');
                    tenantItem.className = 'tenant-item';
                    tenantItem.innerHTML = `
                        <div class="flex items-center p-3 border-b">
                            <div class="flex-shrink-0 w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-indigo-500"></i>
                            </div>
                            <div class="ml-3 flex-grow">
                                <h4 class="font-medium">${tenant.name}</h4>
                                <div class="flex text-xs text-gray-500">
                                    <span class="mr-3">${tenant.id}</span>
                                    <span>${tenant.company || 'No Company'}</span>
                                </div>
                            </div>
                            <button class="text-red-600 hover:text-red-800" title="End Tenancy">
                                <i class="fas fa-times-circle"></i>
                            </button>
                        </div>
                    `;
                    tenantList.appendChild(tenantItem);
                });
            } else {
                // Show placeholder for empty tenant list
                const emptyMessage = document.createElement('div');
                emptyMessage.className = 'tenant-placeholder';
                emptyMessage.innerHTML = `
                    <i class="fas fa-bed"></i>
                    <p>No current occupants</p>
                `;
                tenantList.appendChild(emptyMessage);
            }
        }
        
        // Set room image
        document.getElementById('roomImage').src = `https://placehold.co/600x400?text=Room+${roomNumber}`;
    }
}); 