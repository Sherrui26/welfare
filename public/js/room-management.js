document.addEventListener('DOMContentLoaded', function() {
    // Add/Edit Room Modal
    const addRoomModal = document.getElementById('addRoomModal');
    const addRoomButton = document.getElementById('addRoomButton');
    const addRoomForm = document.getElementById('addRoomForm');
    const submitButton = addRoomForm ? addRoomForm.querySelector('button[type="submit"]') : null;
    const roomDetailsModal = document.getElementById('roomDetailsModal');
    let isEditMode = false;
    let currentRoomId = null;
    
    // Animation timing constants
    const FADE_OUT_DURATION = 300; // ms
    
    // Function to reset form and set for "Add New Room" mode
    function setAddNewRoomMode() {
        isEditMode = false;
        currentRoomId = null;
        addRoomForm.reset();
        
        // Reset room image
        document.getElementById('roomImagePreview').src = 'https://placehold.co/600x400?text=Room+Image';
        
        // Reset checkboxes and radio buttons
        document.getElementById('noRoomArea').checked = false;
        document.querySelector('input[name="bathroomType"][value="attached"]').checked = true;
        
        // Enable room area input
        document.getElementById('roomArea').disabled = false;
        
        // Reset all amenities to unchecked and default styling
        const amenityLabels = addRoomForm.querySelectorAll('.amenity-label');
        amenityLabels.forEach(label => {
            const checkbox = label.querySelector('input[type="checkbox"]');
            const span = label.querySelector('span');
            
            checkbox.checked = false;
            span.classList.add('bg-gray-200', 'text-gray-700');
            span.classList.remove('bg-[#e9d5ff]', 'text-[#7c3aed]');
        });
        
        // Remove any custom amenities
        const amenitiesList = document.getElementById('amenitiesList');
        const defaultAmenities = [
            'bed_wooden_single', 'bed_wooden_queen', 'bed_metal_double_decker', 
            'bed_metal_single', 'mattress_queen', 'mattress_single', 
            'cupboard_lockers', 'curtain'
        ];
        
        // Get all amenity labels
        const currentLabels = Array.from(amenitiesList.querySelectorAll('.amenity-label'));
        
        // Remove any custom ones (those with values not in defaultAmenities)
        currentLabels.forEach(label => {
            const checkbox = label.querySelector('input[type="checkbox"]');
            if (!defaultAmenities.includes(checkbox.value)) {
                amenitiesList.removeChild(label);
            }
        });
        
        // Set button text for Add mode
        submitButton.innerHTML = '<i class="fas fa-plus-circle mr-2"></i>Add New Room';
        
        // Set modal title to "Add New Room"
        addRoomModal.querySelector('h3').textContent = 'Add New Room';
        
        // Hide back button in Add mode
        document.getElementById('backToDetailsModal').classList.add('hidden');
    }
    
    // Function to set form into "Edit Room" mode with existing data
    function setEditRoomMode(roomData) {
        isEditMode = true;
        currentRoomId = roomData.roomNumber;
        
        // Set form fields with room data
        document.getElementById('roomNumber').value = roomData.roomNumber || '';
        document.getElementById('floorNumber').value = roomData.floorNumber || '';
        document.getElementById('totalBedspaces').value = roomData.totalBedspaces || '6';
        
        // Handle room area and the "Unknown" checkbox
        if (roomData.roomArea) {
            document.getElementById('roomArea').value = roomData.roomArea;
            document.getElementById('roomArea').disabled = false;
            document.getElementById('noRoomArea').checked = false;
        } else {
            document.getElementById('roomArea').value = '';
            document.getElementById('roomArea').disabled = true;
            document.getElementById('noRoomArea').checked = true;
        }
        
        // Set bathroom type
        const bathroomType = roomData.bathroomType || 'attached';
        document.querySelector(`input[name="bathroomType"][value="${bathroomType}"]`).checked = true;
        
        // Set room status
        document.getElementById('roomStatus').value = roomData.status || 'available';
        
        // Set room image if available
        if (roomData.imageUrl) {
            document.getElementById('roomImagePreview').src = roomData.imageUrl;
        }
        
        // Check amenities and update their visual appearance
        const amenities = roomData.amenities || [];
        const amenityLabels = addRoomForm.querySelectorAll('.amenity-label');
        
        amenityLabels.forEach(label => {
            const checkbox = label.querySelector('input[type="checkbox"]');
            const span = label.querySelector('span');
            
            if (amenities.includes(checkbox.value)) {
                checkbox.checked = true;
                span.classList.remove('bg-gray-200', 'text-gray-700');
                span.classList.add('bg-[#e9d5ff]', 'text-[#7c3aed]');
            } else {
                checkbox.checked = false;
                span.classList.add('bg-gray-200', 'text-gray-700');
                span.classList.remove('bg-[#e9d5ff]', 'text-[#7c3aed]');
            }
        });
        
        // Add any custom amenities not in the predefined list
        const amenitiesList = document.getElementById('amenitiesList');
        const existingValues = Array.from(amenityLabels).map(label => 
            label.querySelector('input[type="checkbox"]').value
        );
        
        amenities.forEach(amenity => {
            if (!existingValues.includes(amenity)) {
                // Convert from snake_case to display text
                const amenityText = amenity
                    .split('_')
                    .map(word => word.charAt(0).toUpperCase() + word.slice(1))
                    .join(' ');
                
                // Create new label element
                const newLabel = document.createElement('label');
                newLabel.className = 'amenity-label cursor-pointer';
                
                // Create checkbox
                const checkbox = document.createElement('input');
                checkbox.type = 'checkbox';
                checkbox.name = 'amenities[]';
                checkbox.value = amenity;
                checkbox.className = 'hidden amenity-checkbox';
                checkbox.checked = true; // It's in the data, so check it
                
                // Create span for display
                const span = document.createElement('span');
                span.className = 'bg-[#e9d5ff] text-[#7c3aed] text-xs px-2 py-1 rounded-full inline-block';
                span.textContent = amenityText;
                
                // Add to label
                newLabel.appendChild(checkbox);
                newLabel.appendChild(span);
                
                // Add click event
                newLabel.addEventListener('click', function(e) {
                    const checkboxEl = this.querySelector('input[type="checkbox"]');
                    const spanEl = this.querySelector('span');
                    
                    // Toggle checkbox state
                    checkboxEl.checked = !checkboxEl.checked;
                    
                    // Update visual appearance
                    if (checkboxEl.checked) {
                        spanEl.classList.remove('bg-gray-200', 'text-gray-700');
                        spanEl.classList.add('bg-[#e9d5ff]', 'text-[#7c3aed]');
                    } else {
                        spanEl.classList.add('bg-gray-200', 'text-gray-700');
                        spanEl.classList.remove('bg-[#e9d5ff]', 'text-[#7c3aed]');
                    }
                    
                    e.preventDefault();
                });
                
                // Add to amenities list
                amenitiesList.appendChild(newLabel);
            }
        });
        
        // Set notes if available
        if (roomData.notes) {
            document.getElementById('roomNotes').value = roomData.notes;
        }
        
        // Set button text for Edit mode
        submitButton.innerHTML = '<i class="fas fa-save mr-2"></i>Update Room';
        
        // Set modal title to "Edit Room"
        addRoomModal.querySelector('h3').textContent = 'Edit Room ' + roomData.roomNumber;
        
        // Show back button in Edit mode
        document.getElementById('backToDetailsModal').classList.remove('hidden');
    }
    
    // Add New Room button click
    if (addRoomButton && addRoomModal) {
        addRoomButton.addEventListener('click', function() {
            // Set to Add New Room mode
            setAddNewRoomMode();
            
            // Check if dark mode is active and apply to modal
            if (document.body.classList.contains('dark-mode')) {
                addRoomModal.classList.add('dark-mode');
            } else {
                addRoomModal.classList.remove('dark-mode');
            }
            
            // Use ModalNavigation utility if available
            if (window.ModalNavigation) {
                window.ModalNavigation.open(addRoomModal);
            } else {
                // Show modal with animation (fallback)
                addRoomModal.classList.remove('hidden');
                setTimeout(() => {
                    addRoomModal.classList.add('active');
                }, 20);
            }
        });
    }
    
    // Edit Room link click handler (will be delegated to parent elements)
    document.addEventListener('click', function(e) {
        // Check if the clicked element is an Edit Room link in the action menu
        if (e.target.textContent === 'Edit Room' || 
            (e.target.parentElement && e.target.parentElement.textContent === 'Edit Room')) {
            
            e.preventDefault();
            
            // Find the room number from the closest toggle-actions button
            const actionMenu = e.target.closest('.action-menu');
            if (!actionMenu) return;
            
            const toggleButton = actionMenu.previousElementSibling;
            if (!toggleButton) return;
            
            const roomNumber = toggleButton.getAttribute('data-room');
            if (!roomNumber) return;
            
            // Prepare dummy room data (in a real app, you'd fetch this from your backend)
            const roomData = {
                roomNumber: roomNumber,
                floorNumber: roomNumber.substring(0, 1),
                totalBedspaces: '6',
                roomArea: '25',
                bathroomType: 'attached',
                status: 'available',
                amenities: ['bed_wooden_single', 'bed_metal_single', 'cupboard_lockers', 'curtain', 'wifi'],
                notes: 'Regular cleaning on Thursdays',
                imageUrl: 'https://placehold.co/600x400?text=Room+' + roomNumber
            };
            
            // Set form to Edit mode with room data
            setEditRoomMode(roomData);
            
            // Check if dark mode is active and apply to modal
            if (document.body.classList.contains('dark-mode')) {
                addRoomModal.classList.add('dark-mode');
            } else {
                addRoomModal.classList.remove('dark-mode');
            }
            
            // Use ModalNavigation utility if available
            if (window.ModalNavigation) {
                window.ModalNavigation.open(addRoomModal);
            } else {
                // Show modal with animation (fallback)
                addRoomModal.classList.remove('hidden');
                setTimeout(() => {
                    addRoomModal.classList.add('active');
                }, 20);
            }
            
            // Close the action menu
            actionMenu.classList.add('hidden');
        }
    });
    
    // Form submission handler
    if (addRoomForm) {
        addRoomForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Validate room area or "Unknown" checkbox
            const roomAreaInput = document.getElementById('roomArea');
            const noRoomAreaCheckbox = document.getElementById('noRoomArea');
            
            if (!roomAreaInput.value && !noRoomAreaCheckbox.checked) {
                roomAreaInput.classList.add('border-red-500');
                roomAreaInput.focus();
                
                // Create a small error message
                const errorDiv = document.createElement('div');
                errorDiv.className = 'text-red-500 text-xs mt-1 roomarea-error';
                errorDiv.textContent = 'Please enter a room area or check "Unknown"';
                
                // Remove any existing error message first
                const existingError = roomAreaInput.parentElement.querySelector('.roomarea-error');
                if (existingError) existingError.remove();
                
                // Add error message after the input container
                roomAreaInput.parentElement.parentElement.appendChild(errorDiv);
                
                return; // Prevent form submission
            }
            
            // Remove any error styling if validation passes
            roomAreaInput.classList.remove('border-red-500');
            const existingError = roomAreaInput.parentElement.parentElement.querySelector('.roomarea-error');
            if (existingError) existingError.remove();
            
            // Gather form data
            const formData = new FormData(this);
            const formDataObj = Object.fromEntries(formData);
            
            // Close the add room modal first
            addRoomModal.classList.remove('active');
            setTimeout(() => {
                addRoomModal.classList.add('hidden');
                
                // Then show the confirmation dialog after a short delay
                // Create confirmation dialog
                showRoomConfirmationDialog(formDataObj, function() {
                    // This is the callback that runs when user confirms
            
            // For demo purposes, simulate a successful save
            let successMessage;
            if (isEditMode) {
                successMessage = `Room ${currentRoomId} has been updated successfully.`;
            } else {
                successMessage = `New room ${formData.get('roomNumber')} has been created successfully.`;
            }
            
            // Show success notification
            const notification = document.createElement('div');
            notification.className = 'notification success';
            notification.innerHTML = `
                <div class="notification-icon"><i class="fas fa-check-circle"></i></div>
                <div class="notification-content">
                    <h4>Success!</h4>
                    <p>${successMessage}</p>
                </div>
                <div class="notification-close"><i class="fas fa-times"></i></div>
            `;
            document.body.appendChild(notification);
            
            // Add close button functionality
            const closeBtn = notification.querySelector('.notification-close');
            if (closeBtn) {
                closeBtn.addEventListener('click', function() {
                    notification.classList.add('fade-out');
                    setTimeout(() => {
                        if (document.body.contains(notification)) {
                            document.body.removeChild(notification);
                        }
                    }, 500);
                });
            }
            
            // Remove notification after 5 seconds
            setTimeout(() => {
                notification.classList.add('fade-out');
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 500);
            }, 5000);
                });
            }, FADE_OUT_DURATION + 20); // Delay slightly more than animation duration
        });
    }
    
    // Function to prepare room confirmation dialog content
    function prepareRoomConfirmationDialog(dialogElement, formData, onConfirm) {
        // Get selected amenities
        const selectedAmenities = [];
        document.querySelectorAll('.amenity-label input:checked').forEach(checkbox => {
            const label = checkbox.closest('label').querySelector('span').textContent;
            selectedAmenities.push(label);
        });
        
        // Extract values we need to display
        const roomNumber = formData.roomNumber;
        const floorNumber = document.getElementById('floorNumber').options[document.getElementById('floorNumber').selectedIndex].text;
        const totalBedspaces = formData.totalBedspaces;
        const roomArea = formData.noRoomArea ? 'Unknown' : `${formData.roomArea} m²`;
        const bathroomType = document.querySelector('input[name="bathroomType"]:checked').value === 'attached' ? 
            'Attached Bathroom' : 'Common Toilet';
        const notes = formData.roomNotes ? formData.roomNotes : 'None';
        const statusText = formData.roomStatus === 'available' ? 'Available' : 
                           formData.roomStatus === 'maintenance' ? 'Under Maintenance' : 
                           'Unavailable';
                           
        // Conditionally show 'Confirm & Add Another' button
        const addAnotherButtonHTML = !isEditMode ? `
            <button type="button" id="confirmAndAddAnother" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                <i class="fas fa-plus-circle mr-2"></i>Confirm & Add Another
            </button>
        ` : '';

        // Create dialog content - mirroring confirmAssignmentModal structure
        dialogElement.innerHTML = `
            <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full mx-4 overflow-hidden">
                <div class="border-b p-4 bg-gray-50">
                    <div class="modal-header-with-back">
                        <h3 class="text-xl font-semibold">Confirm Room Details</h3>
                        <button id="closeConfirmDialog" class="text-gray-500 hover:text-gray-700">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="p-6 max-h-[calc(90vh-8rem)] overflow-y-auto">
                    <div class="bg-purple-50 p-4 rounded-lg mb-6 border border-purple-200">
                        <div class="flex items-center text-purple-700">
                            <i class="fas fa-info-circle mr-2 text-lg"></i>
                            <p>Please review the details below before ${isEditMode ? 'updating' : 'creating'} this room.</p>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 mb-6">
                         <h4 class="font-medium text-gray-700 border-b border-gray-200 pb-2 mb-3">Room Information</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <div class="flex"><span class="text-gray-500 w-1/3">Room:</span><span class="font-medium">${roomNumber}</span></div>
                                <div class="flex"><span class="text-gray-500 w-1/3">Floor:</span><span class="font-medium">${floorNumber}</span></div>
                                <div class="flex"><span class="text-gray-500 w-1/3">Bedspaces:</span><span class="font-medium">${totalBedspaces}</span></div>
                            </div>
                            <div class="space-y-2">
                                <div class="flex"><span class="text-gray-500 w-1/3">Area:</span><span class="font-medium">${roomArea}</span></div>
                                <div class="flex"><span class="text-gray-500 w-1/3">Bathroom:</span><span class="font-medium">${bathroomType}</span></div>
                                <div class="flex"><span class="text-gray-500 w-1/3">Status:</span><span class="font-medium">${statusText}</span></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 mb-6">
                        <h4 class="font-medium text-gray-700 border-b border-gray-200 pb-2 mb-3">Furniture & Amenities</h4>
                        <div class="flex flex-wrap gap-1">
                            ${selectedAmenities.length > 0 ? 
                                selectedAmenities.map(amenity => 
                                    `<span class="bg-[#e9d5ff] text-[#7c3aed] text-xs px-2 py-1 rounded-full inline-block m-1">${amenity}</span>`
                                ).join('') : 
                                '<span class="text-gray-500 text-sm p-2">None selected</span>'}
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                         <h4 class="font-medium text-gray-700 border-b border-gray-200 pb-2 mb-3">Additional Notes</h4>
                        <p class="text-sm">${notes}</p>
                    </div>
                    
                    <div class="flex justify-between mt-6">
                         <div>
                             <button type="button" id="backToEditBtn" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 flex items-center">
                                 <i class="fas fa-arrow-left"></i><span class="ml-2">Back to Edit</span>
                             </button>
                         </div>
                         <div class="flex gap-3">
                             ${addAnotherButtonHTML}
                             <button type="button" id="confirmRoomAction" class="px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700">
                                 <i class="fas ${isEditMode ? 'fa-save' : 'fa-check-circle'} mr-2"></i>${isEditMode ? 'Update Room' : 'Confirm Creation'}
                             </button>
                         </div>
                    </div>
                </div>
            </div>
        `;
        
        // Set up event handlers after the dialog is in the DOM
        setTimeout(() => {
            const closeButton = document.getElementById('closeConfirmDialog');
            const backButton = document.getElementById('backToEditBtn');
            const confirmButton = document.getElementById('confirmRoomAction');
            const addAnotherButton = document.getElementById('confirmAndAddAnother');
            const modalContent = dialogElement.querySelector('.bg-white');
            const addRoomModalContent = addRoomModal.querySelector('.bg-white');

            // Remove debug logs
            console.log('Back button found:', backButton);

            // Function to hide confirmation and show Add Room modal with animation
            const hideConfirmAndShowAddRoom = () => {
                // If ModalNavigation utility is available, use it for better transitions
                if (window.ModalNavigation) {
                    // First set dialog to fade out
                    dialogElement.style.transition = 'opacity 0.2s ease';
                    dialogElement.style.opacity = '0';
                    
                    setTimeout(() => {
                        if (document.body.contains(dialogElement)) {
                            document.body.removeChild(dialogElement);
                        }
                        
                        // Make sure the add room modal is properly shown
                        addRoomModal.classList.remove('hidden');
                        window.ModalNavigation.open(addRoomModal);
                    }, 300);
                    return;
                }
                
                // Remove debug log
                console.log('hideConfirmAndShowAddRoom function called');
                // Apply smooth fade out transition
                dialogElement.style.transition = 'opacity 0.2s ease';
                dialogElement.style.opacity = '0';
                
                // Find the persistent backdrop and apply smooth fade if returning to add room
                const persistentBackdrop = document.querySelector('.persistent-modal-backdrop');
                if (persistentBackdrop) {
                    persistentBackdrop.style.transition = 'opacity 0.2s ease';
                    // Don't hide backdrop completely if returning to add room modal
                    persistentBackdrop.style.opacity = '0.5';
                }
                
                setTimeout(() => {
                    if (document.body.contains(dialogElement)) {
                        document.body.removeChild(dialogElement);
                    }
                    
                    // Reset Add Room modal styles for entry animation
                    addRoomModal.classList.remove('hidden'); 
                    addRoomModalContent.style.opacity = '0';
                    addRoomModalContent.style.transform = 'translateY(20px)';
                    
                    // Add active class slightly later to trigger transition
                    setTimeout(() => {
                         addRoomModal.classList.add('active');
                         // Force recalculation - helps ensure transition plays
                         void addRoomModalContent.offsetWidth;
                         addRoomModalContent.style.opacity = '1';
                         addRoomModalContent.style.transform = 'translateY(0)';
                         
                         // Reset backdrop to fully visible
                         if (persistentBackdrop) {
                             persistentBackdrop.style.opacity = '1';
                         }
                    }, 20); 
                }, 300); // Match the transition duration
            };

            // Use event delegation for better reliability
            dialogElement.addEventListener('click', function(e) {
                const target = e.target;
                
                // Check if the click was on the close button or any of its children
                if (target.id === 'closeConfirmDialog' || target.closest('#closeConfirmDialog')) {
                    e.preventDefault();
                    hideConfirmAndShowAddRoom();
                    return;
                }
                
                // Check if the click was on the back button or any of its children
                if (target.id === 'backToEditBtn' || target.closest('#backToEditBtn')) {
                    e.preventDefault();
                    hideConfirmAndShowAddRoom();
                    return;
                }
                
                // Check if the click was on the confirm button or any of its children
                if (target.id === 'confirmRoomAction' || target.closest('#confirmRoomAction')) {
                    e.preventDefault();
                    
                    // Hide confirmation modal with smooth fade out
                    dialogElement.style.transition = 'opacity 0.2s ease';
                    dialogElement.style.opacity = '0';
                    
                    // Find the persistent backdrop and apply smooth fade
                    const persistentBackdrop = document.querySelector('.persistent-modal-backdrop');
                    if (persistentBackdrop) {
                        persistentBackdrop.style.transition = 'opacity 0.2s ease';
                        persistentBackdrop.style.opacity = '0';
                    }
                    
                    setTimeout(() => {
                        if (document.body.contains(dialogElement)) {
                            document.body.removeChild(dialogElement);
                        }
                        
                        // Now, properly close the original Add Room modal 
                        // which will also remove its backdrop.
                        if (window.ModalNavigation && window.ModalNavigation.close) {
                            window.ModalNavigation.close(addRoomModal);
                        } else {
                            // Fallback if ModalNavigation is not available
                            addRoomModal.classList.remove('active');
                            setTimeout(() => {
                                addRoomModal.classList.add('hidden');
                                
                                // Manually hide the backdrop if ModalNavigation isn't available
                                if (persistentBackdrop) {
                                    persistentBackdrop.style.display = 'none';
                                }
                            }, FADE_OUT_DURATION);
                        }
                        
                        // Execute the original onConfirm callback (e.g., show notification)
                        if (typeof onConfirm === 'function') {
                            onConfirm();
                        }
                    }, 300); // Match the transition duration
                    return;
                }
                
                // Check if the click was on the add another button or any of its children
                if (target.id === 'confirmAndAddAnother' || target.closest('#confirmAndAddAnother')) {
                    e.preventDefault();
                    
                    // Hide confirmation modal with smooth fade
                    dialogElement.style.transition = 'opacity 0.2s ease';
                    dialogElement.style.opacity = '0';
                    
                    setTimeout(() => {
                        if (document.body.contains(dialogElement)) {
                           document.body.removeChild(dialogElement);
                        }
                        
                        // Perform confirmation action
                        if (typeof onConfirm === 'function') {
                            onConfirm(); // This usually shows the success notification
                        }
                        
                        // Then reset the Add Room form and show it again with animation
                        setAddNewRoomMode(); // Reset the form
                        addRoomModal.classList.remove('hidden');
                        addRoomModalContent.style.opacity = '0';
                        addRoomModalContent.style.transform = 'translateY(20px)';
                        
                        setTimeout(() => {
                            addRoomModal.classList.add('active');
                            // Force recalculation
                            void addRoomModalContent.offsetWidth;
                            addRoomModalContent.style.opacity = '1';
                            addRoomModalContent.style.transform = 'translateY(0)';
                        }, 20); 
                        
                    }, 300); // Match transition duration
                }
            });
        }, 10);
    }
    
    // Function to show room confirmation dialog (for direct use, not through form submission)
    function showRoomConfirmationDialog(formData, onConfirm) {
        // Create confirmation modal
        const confirmDialog = document.createElement('div');
        confirmDialog.className = 'fixed inset-0 bg-black bg-opacity-50 z-[110] hidden flex items-center justify-center';
        confirmDialog.id = 'roomConfirmationDialog';
        
        // Prepare the dialog content
        prepareRoomConfirmationDialog(confirmDialog, formData, onConfirm);
        
        // Add to document
        document.body.appendChild(confirmDialog);
        
        // Show dialog with animation
        confirmDialog.classList.remove('hidden');
        setTimeout(() => {
            confirmDialog.classList.add('active');
        }, 20);
    }
    
    // Back button handler - from Edit Room to Room Details
    const backToDetailsButton = document.getElementById('backToDetailsModal');
    if (backToDetailsButton && addRoomModal && roomDetailsModal) {
        backToDetailsButton.addEventListener('click', function() {
            // Use ModalNavigation utility for smooth transitions
            if (window.ModalNavigation) {
                window.ModalNavigation.transition(addRoomModal, roomDetailsModal);
            } else {
                // Fallback transition
                addRoomModal.classList.remove('active');
                setTimeout(() => {
                    addRoomModal.classList.add('hidden');
                    roomDetailsModal.classList.remove('hidden');
                    setTimeout(() => {
                        roomDetailsModal.classList.add('active');
                    }, 20);
                }, FADE_OUT_DURATION);
            }
        });
    }
    
    // Room image upload preview
    const roomImageInput = document.getElementById('roomImage');
    if (roomImageInput) {
        roomImageInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('roomImagePreview').src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    }
    
    // When "Edit Room" button in room details modal is clicked
    const editRoomButton = document.querySelector('#roomDetailsModal .bg-orange-600');
    if (editRoomButton) {
        editRoomButton.addEventListener('click', function() {
            // Get room number from modal title
            const modalTitle = document.getElementById('modalRoomNumber').textContent;
            const roomNumber = modalTitle.replace('Room ', '').replace(' Details', '');
            
            // Prepare room data based on details shown in the modal
            const roomData = {
                roomNumber: roomNumber,
                floorNumber: roomNumber.substring(0, 1),
                totalBedspaces: document.getElementById('roomCapacity').textContent.replace(' persons', ''),
                roomArea: '25', // You may need to extract this from the modal if shown
                bathroomType: document.querySelectorAll('#roomDetailsModal .bg-\\[\\#e9d5ff\\]').some(el => 
                    el.textContent.toLowerCase().includes('shared') || el.textContent.toLowerCase().includes('common')) 
                    ? 'common' : 'attached',
                status: document.getElementById('modalRoomStatus').textContent.toLowerCase(),
                amenities: Array.from(document.querySelectorAll('#roomDetailsModal .bg-\\[\\#e9d5ff\\]'))
                            .map(el => {
                                const text = el.textContent.toLowerCase();
                                if (text.includes('bed') && text.includes('wooden') && text.includes('single')) return 'bed_wooden_single';
                                if (text.includes('bed') && text.includes('wooden') && text.includes('queen')) return 'bed_wooden_queen';
                                if (text.includes('bed') && text.includes('metal') && text.includes('double')) return 'bed_metal_double_decker';
                                if (text.includes('bed') && text.includes('metal') && text.includes('single')) return 'bed_metal_single';
                                if (text.includes('bed') && text.includes('queen')) return 'bed_queen';
                                if (text.includes('bed') && text.includes('single')) return 'bed_single';
                                if (text.includes('cupboard') || text.includes('locker')) return 'cupboard_lockers';
                                if (text.includes('curtain')) return 'curtain';
                                if (text.includes('air') || text.includes('ac')) return 'air_conditioning';
                                if (text.includes('wifi')) return 'wifi';
                                return text.replace(/\s/g, '_');
                            }),
                notes: '',
                imageUrl: document.getElementById('roomImage').src
            };
            
            // Set form to Edit mode with the data
            setEditRoomMode(roomData);
            
            // Use ModalNavigation utility for smoother transitions
            if (window.ModalNavigation) {
                window.ModalNavigation.transition(roomDetailsModal, addRoomModal);
            } else {
                // Close room details modal and open edit room modal
                roomDetailsModal.classList.remove('active');
                setTimeout(() => {
                    roomDetailsModal.classList.add('hidden');
                    
                    // Check if dark mode is active and apply to modal
                    if (document.body.classList.contains('dark-mode')) {
                        addRoomModal.classList.add('dark-mode');
                    } else {
                        addRoomModal.classList.remove('dark-mode');
                    }
                    
                    // Show edit modal with animation
                    addRoomModal.classList.remove('hidden');
                    setTimeout(() => {
                        addRoomModal.classList.add('active');
                    }, 20);
                }, FADE_OUT_DURATION);
            }
        });
    }

    // Add event handler for the "Unknown" checkbox for room area
    const noRoomAreaCheckbox = document.getElementById('noRoomArea');
    if (noRoomAreaCheckbox) {
        noRoomAreaCheckbox.addEventListener('change', function() {
            const roomAreaInput = document.getElementById('roomArea');
            if (this.checked) {
                roomAreaInput.disabled = true;
                roomAreaInput.value = '';
            } else {
                roomAreaInput.disabled = false;
            }
        });
    }
    
    // Amenities selection handling
    const amenityLabels = document.querySelectorAll('.amenity-label');
    if (amenityLabels.length > 0) {
        amenityLabels.forEach(label => {
            label.addEventListener('click', function(e) {
                const checkbox = this.querySelector('input[type="checkbox"]');
                const span = this.querySelector('span');
                
                // Toggle checkbox state
                checkbox.checked = !checkbox.checked;
                
                // Update visual appearance based on checkbox state
                if (checkbox.checked) {
                    span.classList.remove('bg-gray-200', 'text-gray-700');
                    span.classList.add('bg-[#e9d5ff]', 'text-[#7c3aed]');
                } else {
                    span.classList.add('bg-gray-200', 'text-gray-700');
                    span.classList.remove('bg-[#e9d5ff]', 'text-[#7c3aed]');
                }
                
                // Prevent the default behavior to avoid issues with checkbox toggling
                e.preventDefault();
            });
        });
    }
    
    // Custom amenity adding functionality
    const addCustomAmenityBtn = document.getElementById('addCustomAmenity');
    const customAmenityInput = document.getElementById('customAmenity');
    const amenitiesList = document.getElementById('amenitiesList');
    
    if (addCustomAmenityBtn && customAmenityInput && amenitiesList) {
        addCustomAmenityBtn.addEventListener('click', function() {
            const amenityText = customAmenityInput.value.trim();
            
            if (amenityText.length > 0) {
                // Convert to snake_case for value
                const amenityValue = amenityText.toLowerCase().replace(/\s+/g, '_');
                
                // Create new label element
                const newLabel = document.createElement('label');
                newLabel.className = 'amenity-label cursor-pointer';
                
                // Create checkbox
                const checkbox = document.createElement('input');
                checkbox.type = 'checkbox';
                checkbox.name = 'amenities[]';
                checkbox.value = amenityValue;
                checkbox.className = 'hidden amenity-checkbox';
                checkbox.checked = true; // Check by default since it's newly added
                
                // Create span for display
                const span = document.createElement('span');
                span.className = 'bg-[#e9d5ff] text-[#7c3aed] text-xs px-2 py-1 rounded-full inline-block';
                span.textContent = amenityText;
                
                // Add to label
                newLabel.appendChild(checkbox);
                newLabel.appendChild(span);
                
                // Add click event
                newLabel.addEventListener('click', function(e) {
                    const checkboxEl = this.querySelector('input[type="checkbox"]');
                    const spanEl = this.querySelector('span');
                    
                    // Toggle checkbox state
                    checkboxEl.checked = !checkboxEl.checked;
                    
                    // Update visual appearance
                    if (checkboxEl.checked) {
                        spanEl.classList.remove('bg-gray-200', 'text-gray-700');
                        spanEl.classList.add('bg-[#e9d5ff]', 'text-[#7c3aed]');
                    } else {
                        spanEl.classList.add('bg-gray-200', 'text-gray-700');
                        spanEl.classList.remove('bg-[#e9d5ff]', 'text-[#7c3aed]');
                    }
                    
                    e.preventDefault();
                });
                
                // Add to amenities list
                amenitiesList.appendChild(newLabel);
                
                // Clear input field
                customAmenityInput.value = '';
            }
        });
        
        // Allow pressing Enter in the custom amenity input field
        customAmenityInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                addCustomAmenityBtn.click();
            }
        });
    }
}); 