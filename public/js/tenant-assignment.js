document.addEventListener('DOMContentLoaded', function() {
    // DOM elements for Assign Occupant Modal
    const assignOccupantModal = document.getElementById('assignOccupantModal');
    const assignTenantBtn = document.getElementById('assignTenantBtn');
    const closeAssignOccupantModal = document.getElementById('closeAssignOccupantModal');
    const cancelAssignOccupant = document.getElementById('cancelAssignOccupant');
    const backToRoomDetailsModal = document.getElementById('backToRoomDetailsModal');
    const assignOccupantForm = document.getElementById('assignOccupantForm');
    const roomDetailsModal = document.getElementById('roomDetailsModal');
    
    // Elements inside the modal
    const companySearchInput = document.getElementById('companySearchInput');
    const companySearchResults = document.getElementById('companySearchResults');
    const selectedCompanyCard = document.getElementById('selectedCompanyCard');
    const clearSelectedCompany = document.getElementById('clearSelectedCompany');
    const findCompanyBtn = document.getElementById('findCompany');
    
    // Form elements with pending checkboxes
    const passportIC = document.getElementById('passportIC');
    const passportExpiry = document.getElementById('passportExpiry');
    const pendingPassport = document.getElementById('pendingPassport');
    const permitNumber = document.getElementById('permitNumber');
    const permitExpiry = document.getElementById('permitExpiry');
    const pendingPermit = document.getElementById('pendingPermit');
    
    // Emergency contact field and "none" checkbox
    const emergencyContact = document.getElementById('emergencyContact');
    const noEmergencyContact = document.getElementById('noEmergencyContact');
    const phoneNo = document.getElementById('phoneNo');
    const noPhoneNo = document.getElementById('noPhoneNo');
    
    // Current context
    let currentRoomNumber = '';
    let currentRoomType = '';
    let availableBeds = [];
    
    // Animation timing constants to ensure consistency
    const FADE_OUT_DURATION = 300; // ms
    const TRANSITION_DELAY = 20; // ms
    
    // Demo company data (in a real app, this would come from your backend)
    const demoCompanies = [
        { id: 'BA', name: 'BEFORE AFTER', contact: '+60 12-345-6789', availableRooms: 12 },
        { id: 'LP', name: 'LB POWER', contact: '+60 13-456-7890', availableRooms: 8 },
        { id: 'ES', name: 'EMBUNAN SUCI SDN. BHD.', contact: '+60 14-567-8901', availableRooms: 10 },
        { id: 'EX', name: 'EXCELLIGENT SDN. BHD.', contact: '+60 15-678-9012', availableRooms: 6 },
        { id: 'KK', name: 'KEDAI KOPI DAN MAKANAN WENG FATT', contact: '+60 16-789-0123', availableRooms: 7 },
        { id: 'MB', name: 'MUHAMMAD BASHEER BIN ZAINUDIN', contact: '+60 17-890-1234', availableRooms: 5 },
        { id: 'PM', name: 'POS MALAYSIA BERHAD', contact: '+60 18-901-2345', availableRooms: 9 },
        { id: 'SP', name: 'SRI PAANDI', contact: '+60 19-012-3456', availableRooms: 4 },
        { id: 'VT', name: 'VEGTALK TRADING', contact: '+60 11-123-4567', availableRooms: 8 },
        { id: 'YS', name: 'YEE SIONG HENG CONFECTIONERY', contact: '+60 16-234-5678', availableRooms: 4 }
    ];
    
    // Set default values for date of birth
    function setDefaultDates() {
        const dateOfBirth = document.getElementById('dateOfBirth');
        const today = new Date();
        
        // Format date as YYYY-MM-DD for the input
        const formatDate = (date) => {
            const d = new Date(date);
            const month = '' + (d.getMonth() + 1);
            const day = '' + d.getDate();
            const year = d.getFullYear();
            return [year, month.padStart(2, '0'), day.padStart(2, '0')].join('-');
        };
        
        // Set a default date of birth (20 years ago)
        const twentyYearsAgo = new Date(today);
        twentyYearsAgo.setFullYear(today.getFullYear() - 20);
        if (dateOfBirth) {
            dateOfBirth.value = formatDate(twentyYearsAgo);
        }
        
        // Set default expiry dates (1 year from now)
        const oneYearLater = new Date(today);
        oneYearLater.setFullYear(today.getFullYear() + 1);
        if (passportExpiry) {
            passportExpiry.value = formatDate(oneYearLater);
        }
        if (permitExpiry) {
            permitExpiry.value = formatDate(oneYearLater);
        }
    }
    
    // Handle pending checkboxes
    function setupPendingCheckboxes() {
        if (pendingPassport) {
            pendingPassport.addEventListener('change', function() {
                passportIC.disabled = this.checked;
                passportExpiry.disabled = this.checked;
                
                if (this.checked) {
                    passportIC.value = '';
                    passportExpiry.value = '';
                    passportIC.classList.add('bg-gray-100');
                    passportExpiry.classList.add('bg-gray-100');
                } else {
                    passportIC.classList.remove('bg-gray-100');
                    passportExpiry.classList.remove('bg-gray-100');
                    // Restore default expiry date for passport
                    const today = new Date();
                    const oneYearLater = new Date(today);
                    oneYearLater.setFullYear(today.getFullYear() + 1);
                    passportExpiry.value = formatDate(oneYearLater);
                }
            });
        }
        
        if (pendingPermit) {
            pendingPermit.addEventListener('change', function() {
                permitNumber.disabled = this.checked;
                permitExpiry.disabled = this.checked;
                
                if (this.checked) {
                    permitNumber.value = '';
                    permitExpiry.value = '';
                    permitNumber.classList.add('bg-gray-100');
                    permitExpiry.classList.add('bg-gray-100');
                } else {
                    permitNumber.classList.remove('bg-gray-100');
                    permitExpiry.classList.remove('bg-gray-100');
                    // Restore default expiry date
                    const today = new Date();
                    const oneYearLater = new Date(today);
                    oneYearLater.setFullYear(today.getFullYear() + 1);
                    permitExpiry.value = formatDate(oneYearLater);
                }
            });
        }
        
        // Handle the emergency contact "none" checkbox
        if (noEmergencyContact) {
            noEmergencyContact.addEventListener('change', function() {
                emergencyContact.disabled = this.checked;
                if (this.checked) {
                    // In a real app, you would get the supervisor's number from the company data
                    // For now, just use a placeholder
                    emergencyContact.value = 'Supervisor number will be used';
                    emergencyContact.classList.add('bg-gray-100');
                } else {
                    emergencyContact.value = '';
                    emergencyContact.classList.remove('bg-gray-100');
                }
            });
        }
        
        // Handle the phone number "none" checkbox
        if (noPhoneNo) {
            noPhoneNo.addEventListener('change', function() {
                phoneNo.disabled = this.checked;
                if (this.checked) {
                    phoneNo.value = 'Not available';
                    phoneNo.classList.add('bg-gray-100');
                } else {
                    phoneNo.value = '';
                    phoneNo.classList.remove('bg-gray-100');
                }
            });
        }
    }
    
    // Initialize select options for beds based on availability
    function initializeBedOptions(availableBeds, totalCapacity) {
        const bedNumberSelect = document.getElementById('bedNumber');
        
        // Clear existing options
        bedNumberSelect.innerHTML = '';
        
        // Add available beds as options
        availableBeds.forEach(bedNum => {
            const option = document.createElement('option');
            option.value = bedNum;
            option.textContent = `Bed ${bedNum}`;
            bedNumberSelect.appendChild(option);
        });
        
        // Set first available bed as default selection
        if (availableBeds.length > 0) {
            bedNumberSelect.value = availableBeds[0];
        }
        
        // Update the bed counter display
        const availableBedsDisplay = document.getElementById('assignAvailableBeds');
        if (availableBedsDisplay) {
            availableBedsDisplay.textContent = `${availableBeds.length}/${totalCapacity}`;
        }
    }
    
    // Open Assign Occupant Modal from Room Details
    if (assignTenantBtn) {
        assignTenantBtn.addEventListener('click', function() {
            // Get room information from the room details modal
            const roomNumberText = document.getElementById('modalRoomNumber').textContent;
            const roomTypeText = document.getElementById('roomType').textContent;
            const roomCapacityText = document.getElementById('roomCapacity').textContent;
            
            // Extract room number from "Room X Details"
            currentRoomNumber = roomNumberText.replace('Room ', '').replace(' Details', '');
            currentRoomType = roomTypeText;
            
            // Extract capacity as number
            const capacityMatch = roomCapacityText.match(/(\d+)/);
            const roomCapacity = capacityMatch ? parseInt(capacityMatch[1]) : 6;
            
            // Set modal room information
            document.getElementById('assignRoomNumber').textContent = currentRoomNumber;
            document.getElementById('assignRoomType').textContent = currentRoomType;
            
            // In a real application, you would fetch the actual available beds
            // For demo, let's assume some beds are available based on the room number
            const occupiedCount = (currentRoomNumber.charCodeAt(0) % 3); // Just a random formula for demo
            availableBeds = Array.from({length: roomCapacity}, (_, i) => i + 1)
                .filter(bedNum => bedNum > occupiedCount);
            
            document.getElementById('assignAvailableBeds').textContent = 
                `${availableBeds.length}/${roomCapacity}`;
            
            // Initialize bed selection options with available beds
            initializeBedOptions(availableBeds, roomCapacity);
            
            // Set default dates
            setDefaultDates();
            
            // Setup pending checkboxes
            setupPendingCheckboxes();
            
            // Reset company selection
            resetCompanySelection();
            
            // Try to use the ModalNavigation utility for consistent animations
            if (window.ModalNavigation) {
                window.ModalNavigation.transition(roomDetailsModal, assignOccupantModal);
                return;
            }
            
            // Prepare the content of the destination modal (assign occupant)
            const assignContent = assignOccupantModal.querySelector('.bg-white');
            if (assignContent) {
                assignContent.style.transform = 'translateY(20px)';
                assignContent.style.opacity = '0';
                assignContent.style.transition = 'transform 0.25s ease-out, opacity 0.2s ease-out';
            }
            
            // Hide the current modal (room details) with animation
            roomDetailsModal.classList.remove('active');
            
            // Hide the content of the current modal first
            const roomContent = roomDetailsModal.querySelector('.bg-white');
            if (roomContent) {
                roomContent.style.transform = 'translateY(10px)';
                roomContent.style.opacity = '0';
            }
            
            // After brief delay to let the content hide, fully hide the current modal
            setTimeout(() => {
                roomDetailsModal.classList.add('hidden');
                
                // Show the destination modal but keep content hidden
                assignOccupantModal.classList.remove('hidden');
                
                // Force browser to process DOM changes before starting animation
                void assignOccupantModal.offsetWidth;
                
                // Now make the destination modal active
                assignOccupantModal.classList.add('active');
                
                // After a brief delay, animate in the content
                setTimeout(() => {
                    if (assignContent) {
                        assignContent.style.transform = 'translateY(0)';
                        assignContent.style.opacity = '1';
                    }
                }, 50);
            }, FADE_OUT_DURATION);
        });
    }
    
    // Close modal handlers
    if (closeAssignOccupantModal) {
        closeAssignOccupantModal.addEventListener('click', function() {
            // Try to use the ModalNavigation utility if available
            if (window.ModalNavigation) {
                window.ModalNavigation.close(assignOccupantModal);
                return;
            }
            
            // Fallback handling if ModalNavigation is not available
            // Find the backdrop element
            const backdrop = document.querySelector('.persistent-modal-backdrop') || 
                             document.querySelector('.modal-backdrop');
            
            // Close the modal
            assignOccupantModal.classList.remove('active');
            setTimeout(() => {
                assignOccupantModal.classList.add('hidden');
                
                // Manually hide the backdrop if it exists
                if (backdrop) {
                    backdrop.style.opacity = '0';
                    setTimeout(() => {
                        backdrop.style.display = 'none';
                    }, 200);
                }
            }, FADE_OUT_DURATION);
        });
    }
    
    if (cancelAssignOccupant) {
        cancelAssignOccupant.addEventListener('click', function() {
            // Try to use the ModalNavigation utility if available
            if (window.ModalNavigation) {
                window.ModalNavigation.close(assignOccupantModal);
                return;
            }
            
            // Fallback handling if ModalNavigation is not available
            // Find the backdrop element
            const backdrop = document.querySelector('.persistent-modal-backdrop') || 
                             document.querySelector('.modal-backdrop');
            
            // Close the modal
            assignOccupantModal.classList.remove('active');
            setTimeout(() => {
                assignOccupantModal.classList.add('hidden');
                
                // Manually hide the backdrop if it exists
                if (backdrop) {
                    backdrop.style.opacity = '0';
                    setTimeout(() => {
                        backdrop.style.display = 'none';
                    }, 200);
                }
            }, FADE_OUT_DURATION);
        });
    }
    
    // Back button handler
    if (backToRoomDetailsModal) {
        backToRoomDetailsModal.addEventListener('click', function() {
            // Try to use the ModalNavigation utility for consistent animations
            if (window.ModalNavigation) {
                window.ModalNavigation.transition(assignOccupantModal, roomDetailsModal);
                return;
            }
            
            // Prepare the content of the destination modal (room details)
            const roomContent = roomDetailsModal.querySelector('.bg-white');
            if (roomContent) {
                roomContent.style.transform = 'translateY(20px)';
                roomContent.style.opacity = '0';
                roomContent.style.transition = 'transform 0.25s ease-out, opacity 0.2s ease-out';
            }
            
            // Hide the current modal (assign occupant) with animation
            assignOccupantModal.classList.remove('active');
            
            // Hide the content of the current modal first
            const assignContent = assignOccupantModal.querySelector('.bg-white');
            if (assignContent) {
                assignContent.style.transform = 'translateY(10px)';
                assignContent.style.opacity = '0';
            }
            
            // After brief delay to let the content hide, fully hide the current modal
            setTimeout(() => {
                assignOccupantModal.classList.add('hidden');
                
                // Show the destination modal but keep content hidden
                roomDetailsModal.classList.remove('hidden');
                
                // Force browser to process DOM changes before starting animation
                void roomDetailsModal.offsetWidth;
                
                // Now make the destination modal active
                roomDetailsModal.classList.add('active');
                
                // After a brief delay, animate in the content
                setTimeout(() => {
                    if (roomContent) {
                        roomContent.style.transform = 'translateY(0)';
                        roomContent.style.opacity = '1';
                    }
                }, 50);
            }, FADE_OUT_DURATION);
        });
    }
    
    // Reset company selection
    function resetCompanySelection() {
        selectedCompanyCard.style.display = 'none';
        companySearchInput.value = '';
        companySearchResults.innerHTML = `
            <div class="p-4 text-center text-gray-500">
                <i class="fas fa-building mb-2 text-lg"></i>
                <p>Search for companies above or click "Find Company"</p>
            </div>
        `;
    }
    
    // Clear selected company
    if (clearSelectedCompany) {
        clearSelectedCompany.addEventListener('click', function() {
            resetCompanySelection();
        });
    }
    
    // Search for companies as the user types
    if (companySearchInput) {
        companySearchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            if (searchTerm.length < 2) {
                // Only show the message if no company is selected
                if (selectedCompanyCard.style.display === 'none') {
                companySearchResults.innerHTML = `
                    <div class="p-4 text-center text-gray-500">
                        <i class="fas fa-building mb-2 text-lg"></i>
                        <p>Type at least 2 characters to search</p>
                    </div>
                `;
                } else {
                    // Clear search results but don't show message when company is selected
                    companySearchResults.innerHTML = '';
                }
                return;
            }
            
            // Filter companies based on search term
            const filteredCompanies = demoCompanies.filter(company => 
                company.name.toLowerCase().includes(searchTerm) || 
                company.id.toLowerCase().includes(searchTerm)
            );
            
            // Display results
            displaySearchResults(filteredCompanies);
        });
    }
    
    // Find Company button click
    if (findCompanyBtn) {
        findCompanyBtn.addEventListener('click', function() {
            // Check if search results are already displayed
            const resultsDisplayed = companySearchResults.innerHTML.includes('company-result');
            
            if (resultsDisplayed) {
                // If results are displayed, just clear them but don't reset the selected company
                companySearchResults.innerHTML = '';
            } else {
                // If a company is already selected, just show all companies without resetting
                if (selectedCompanyCard.style.display !== 'none') {
                    displaySearchResults(demoCompanies);
                } else {
                    // If no company selected, show all companies
                displaySearchResults(demoCompanies);
                }
            }
        });
    }
    
    // Display company search results
    function displaySearchResults(companies) {
        if (companies.length === 0) {
            companySearchResults.innerHTML = `
                <div class="p-4 text-center text-gray-500">
                    <i class="fas fa-exclamation-circle mb-2 text-lg"></i>
                    <p>No companies found matching your search</p>
                </div>
            `;
            return;
        }
        
        companySearchResults.innerHTML = '';
        companies.forEach(company => {
            const companyElement = document.createElement('div');
            companyElement.className = 'p-3 border-b border-gray-200 hover:bg-gray-100 cursor-pointer company-result';
            companyElement.innerHTML = `
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                        <span class="text-purple-600 font-bold">${company.id}</span>
                    </div>
                    <div>
                        <h5 class="font-medium">${company.name}</h5>
                        <div class="text-xs text-gray-500">
                            Contact: ${company.contact}
                        </div>
                    </div>
                    <div class="ml-auto">
                        <span class="company-rooms-tag">Rooms: ${company.availableRooms}</span>
                    </div>
                </div>
            `;
            
            // Add click event to select this company
            companyElement.addEventListener('click', function() {
                selectCompany(company);
            });
            
            companySearchResults.appendChild(companyElement);
        });
    }
    
    // Select a company from search results
    function selectCompany(company) {
        // Update the selected company card
        document.getElementById('selectedCompanyInitials').textContent = company.id;
        document.getElementById('selectedCompanyName').textContent = company.name;
        document.getElementById('selectedCompanyContact').textContent = company.contact;
        document.getElementById('selectedCompanyRooms').textContent = company.availableRooms;
        
        // Show the selected company card
        selectedCompanyCard.style.display = 'block';
        
        // Clear the search results
        companySearchResults.innerHTML = '';
    }
    
    // Form submission handler
    if (assignOccupantForm) {
        assignOccupantForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Check if a company has been selected
            if (selectedCompanyCard.style.display === 'none') {
                // Show error notification
                showNotification('error', 'Please select a company first');
                return;
            }
            
            // Collect form data and set up confirmation
            const formData = new FormData(assignOccupantForm);
            
            // Create an object with data from the form
            const data = {
                roomNumber: document.getElementById('assignRoomNumber').textContent,
                roomType: document.getElementById('assignRoomType').textContent,
                bedNumber: formData.get('bedNumber'),
                company: {
                    name: document.getElementById('selectedCompanyName').textContent,
                    contact: document.getElementById('selectedCompanyContact').textContent
                },
                fullName: formData.get('fullName'),
                nationality: formData.get('nationality'),
                passportIC: pendingPassport.checked ? 'Pending' : formData.get('passportIC'),
                passportExpiry: pendingPassport.checked ? 'Pending' : formData.get('passportExpiry'),
                phoneNo: noPhoneNo.checked ? 'Not available' : formData.get('phoneNo'),
                gender: formData.get('gender'),
                dateOfBirth: formData.get('dateOfBirth'),
                emergencyContact: noEmergencyContact.checked ? 'Supervisor Number' : formData.get('emergencyContact'),
                permitNumber: pendingPermit.checked ? 'Pending' : formData.get('permitNumber'),
                permitExpiry: pendingPermit.checked ? 'Pending' : formData.get('permitExpiry'),
                checkIn: new Date().toISOString().split('T')[0], // Current date as check-in date
                remarks: formData.get('remarks'),
                idProvided: !!document.getElementById('photoFileName')?.textContent // If the photoFileName is populated
            };
            
            // First hide the assignment form with animation
            assignOccupantModal.classList.remove('active');
            setTimeout(() => {
                assignOccupantModal.classList.add('hidden');
                
                // Populate confirmation modal
                populateConfirmationModal(data);
                
                // Show confirmation modal
                const confirmAssignmentModal = document.getElementById('confirmAssignmentModal');
                confirmAssignmentModal.classList.remove('hidden');
                setTimeout(() => {
                    confirmAssignmentModal.classList.add('active');
                }, TRANSITION_DELAY);
            }, FADE_OUT_DURATION);
        });
    }
    
    // Function to populate the confirmation modal
    function populateConfirmationModal(data) {
        // Get confirmation modal elements
        const confirmModal = document.getElementById('confirmAssignmentModal');
        
        // Populate modal with data
        document.getElementById('confirmRoomNumber').textContent = data.roomNumber;
        document.getElementById('confirmRoomType').textContent = data.roomType;
        document.getElementById('confirmBedNumber').textContent = `Bed ${data.bedNumber}`;
        
        const confirmCompanyNameEl = document.getElementById('confirmCompanyName');
        confirmCompanyNameEl.textContent = data.company.name;
        confirmCompanyNameEl.title = data.company.name; // Set title attribute for tooltip
        
        document.getElementById('confirmCompanyContact').textContent = data.company.contact;
        
        document.getElementById('confirmFullName').textContent = data.fullName;
        document.getElementById('confirmGender').textContent = data.gender === 'male' ? 'Male' : 'Female';
        
        // Get selected nationality text from the select element
        const nationalitySelect = document.getElementById('nationality');
        const selectedNationality = nationalitySelect.options[nationalitySelect.selectedIndex].text;
        document.getElementById('confirmNationality').textContent = selectedNationality;
        
        document.getElementById('confirmPhone').textContent = data.phoneNo || 'Not provided';
        document.getElementById('confirmPassportIC').textContent = data.passportIC;
        document.getElementById('confirmPassportExpiry').textContent = data.passportExpiry;
        document.getElementById('confirmPermitNumber').textContent = data.permitNumber;
        document.getElementById('confirmPermitExpiry').textContent = data.permitExpiry;
        
        document.getElementById('confirmRemarks').textContent = data.remarks || 'No remarks provided';
        
        // Format the date to be more readable
        const checkInDate = new Date(data.checkIn);
        const formattedDate = checkInDate.toISOString().split('T')[0];
        const isToday = new Date().toISOString().split('T')[0] === formattedDate;
        document.getElementById('confirmCheckInDate').textContent = `${formattedDate}${isToday ? ' (Today)' : ''}`;
        
        // Set ID provided information
        if (data.idProvided) {
            document.getElementById('confirmIDProvided').innerHTML = 
                `<i class="fas fa-check-circle text-green-500 mr-1"></i> Yes`;
        } else {
            document.getElementById('confirmIDProvided').innerHTML = 
                `<i class="fas fa-times-circle text-red-500 mr-1"></i> No`;
        }
        
        // Store the data for use when confirming
        confirmModal.assignmentData = data;
    }
    
    // Handle confirmation modal buttons
    const closeConfirmModal = document.getElementById('closeConfirmModal');
    const backToEditBtn = document.getElementById('backToEditBtn');
    const assignAnotherBtn = document.getElementById('assignAnotherBtn');
    const confirmAssignBtn = document.getElementById('confirmAssignBtn');
    const confirmAssignmentModal = document.getElementById('confirmAssignmentModal');
    
    if (closeConfirmModal) {
        closeConfirmModal.addEventListener('click', function() {
            // Hide confirmation modal with animation
            confirmAssignmentModal.classList.remove('active');
            setTimeout(() => {
                confirmAssignmentModal.classList.add('hidden');
                
                // Return to assignment form
                showAssignmentForm();
            }, FADE_OUT_DURATION);
        });
    }
    
    if (backToEditBtn) {
        backToEditBtn.addEventListener('click', function() {
            // Hide confirmation modal with animation
            confirmAssignmentModal.classList.remove('active');
            setTimeout(() => {
                confirmAssignmentModal.classList.add('hidden');
                
                // Return to assignment form
                showAssignmentForm();
            }, FADE_OUT_DURATION);
        });
    }
    
    if (confirmAssignBtn) {
        confirmAssignBtn.addEventListener('click', function() {
            // Get the stored assignment data
            const assignmentData = confirmAssignmentModal.assignmentData;
            
            // In a real app, you would send this data to your backend
            console.log('Assignment confirmed:', assignmentData);
            
            // Show success notification
            showNotification('success', `${assignmentData.fullName} has been assigned to Room ${assignmentData.roomNumber}, Bed ${assignmentData.bedNumber}`);
            
            // Try to use the ModalNavigation utility if available
            if (window.ModalNavigation) {
                window.ModalNavigation.close(confirmAssignmentModal);
                return;
            }
            
            // Fallback handling if ModalNavigation is not available
            // Find the backdrop element
            const backdrop = document.querySelector('.persistent-modal-backdrop') || 
                             document.querySelector('.modal-backdrop');
            
            // Close the confirmation modal with animation
            confirmAssignmentModal.classList.remove('active');
            setTimeout(() => {
                confirmAssignmentModal.classList.add('hidden');
                
                // Manually hide the backdrop if it exists
                if (backdrop) {
                    backdrop.style.opacity = '0';
                    setTimeout(() => {
                        backdrop.style.display = 'none';
                    }, 200);
                }
            }, FADE_OUT_DURATION);
        });
    }
    
    if (assignAnotherBtn) {
        assignAnotherBtn.addEventListener('click', function() {
            // Get the stored assignment data
            const assignmentData = confirmAssignmentModal.assignmentData;
            
            // In a real app, you would send this data to your backend
            console.log('Assignment confirmed, adding another:', assignmentData);
            
            // Show success notification
            showNotification('success', `${assignmentData.fullName} has been assigned to Room ${assignmentData.roomNumber}, Bed ${assignmentData.bedNumber}`);
            
            // Hide confirmation modal with animation
            confirmAssignmentModal.classList.remove('active');
            setTimeout(() => {
                confirmAssignmentModal.classList.add('hidden');
                
                // Show the assignment form again for adding another occupant
                showAssignmentForm();
                
                // Reset the form fields but keep the company selected
                resetFormFieldsOnly();
            }, FADE_OUT_DURATION);
        });
    }
    
    // Function to show the assignment form again
    function showAssignmentForm() {
        assignOccupantModal.classList.remove('hidden');
        setTimeout(() => {
            assignOccupantModal.classList.add('active');
        }, TRANSITION_DELAY);
    }
    
    // Function to reset only the form fields without affecting company selection
    function resetFormFieldsOnly() {
        // Reset text inputs except the company search
        const textInputs = assignOccupantForm.querySelectorAll('input[type="text"]:not(#companySearchInput)');
        textInputs.forEach(input => {
            input.value = '';
        });
        
        // Reset checkboxes
        const checkboxes = assignOccupantForm.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach(checkbox => {
            checkbox.checked = false;
        });
        
        // Reset radio buttons (set Male as default)
        const maleRadio = assignOccupantForm.querySelector('input[name="gender"][value="male"]');
        if (maleRadio) maleRadio.checked = true;
        
        // Reset file upload
        if (photoUpload) {
            photoUpload.value = '';
            photoPreview.classList.add('hidden');
        }
        
        // Reset date fields
        setDefaultDates();
        
        // Reset the nationality dropdown to default
        if (document.getElementById('nationality')) {
            document.getElementById('nationality').selectedIndex = 0;
        }
        
        // Reset remarks
        if (document.getElementById('remarks')) {
            document.getElementById('remarks').value = '';
        }
        
        // Focus on full name field to start entering new occupant details
        if (document.getElementById('fullName')) {
            document.getElementById('fullName').focus();
        }
    }
    
    // Helper function to show notifications
    function showNotification(type, message) {
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        notification.innerHTML = `
            <div class="notification-icon">
                <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
            </div>
            <div class="notification-content">
                <h4>${type === 'success' ? 'Success!' : 'Error!'}</h4>
                <p>${message}</p>
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
                    document.body.removeChild(notification);
                }, 500);
            });
        }
        
        // Remove notification after 5 seconds
        setTimeout(() => {
            if (document.body.contains(notification)) {
                notification.classList.add('fade-out');
                setTimeout(() => {
                    if (document.body.contains(notification)) {
                        document.body.removeChild(notification);
                    }
                }, 500);
            }
        }, 5000);
    }

    // Add document click handler to close company search results when clicking outside
    document.addEventListener('click', function(event) {
        // Check if company search elements exist
        if (!companySearchResults || !companySearchInput || !findCompanyBtn) return;
        
        // Check if click is outside the company search area
        const isClickInsideSearchResults = companySearchResults.contains(event.target);
        const isClickOnSearchInput = companySearchInput === event.target;
        const isClickOnFindCompanyBtn = findCompanyBtn === event.target || findCompanyBtn.contains(event.target);
        
        // If click is outside search area and results are displayed (not the default message)
        if (!isClickInsideSearchResults && !isClickOnSearchInput && !isClickOnFindCompanyBtn) {
            // Only reset if a company has not been selected yet (selectedCompanyCard is not visible)
            // and search results (not the default message) are being displayed
            if (companySearchResults.innerHTML.includes('company-result') && selectedCompanyCard.style.display === 'none') {
                resetCompanySelection();
            } else if (companySearchResults.innerHTML.includes('company-result')) {
                // If company is already selected, just clear the search results
                companySearchResults.innerHTML = '';
            }
        }
    });

    // Add photo upload preview functionality
    const photoUpload = document.getElementById('photoUpload');
    const photoPreview = document.getElementById('photoPreview');
    const photoFileName = document.getElementById('photoFileName');
    const removePhoto = document.getElementById('removePhoto');

    if (photoUpload && photoPreview && photoFileName && removePhoto) {
        photoUpload.addEventListener('change', function(e) {
            if (e.target.files.length > 0) {
                const file = e.target.files[0];
                photoFileName.textContent = file.name;
                photoPreview.classList.remove('hidden');
            }
        });

        removePhoto.addEventListener('click', function() {
            photoUpload.value = '';
            photoPreview.classList.add('hidden');
        });
    }
});
