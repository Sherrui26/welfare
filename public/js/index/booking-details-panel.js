document.addEventListener('DOMContentLoaded', function() {
    // Get DOM elements
    const bookingDetailsPanel = document.getElementById('bookingDetailsPanel');
    const bookingDetailsContent = document.getElementById('bookingDetailsContent');
    const closeBookingDetails = document.getElementById('closeBookingDetails');
    const bookingModalContent = document.querySelector('#bookingsModal > div');
    const bookingItems = document.querySelectorAll('.booking-item');
    
    // Sample booking data - this would typically come from your backend
    const bookingData = {
        "1": {
            id: "1",
            guestName: "John Smith",
            guestAvatar: "JS",
            avatarColor: "blue",
            nationality: "Nepal",
            gender: "Male",
            roomNumber: "Room 101",
            bedInfo: "Bed 3 • 5-bed",
            checkInDate: "Oct 1, 2023",
            checkInTime: "11:30 AM",
            checkOutDate: "Oct 7, 2023",
            checkOutTime: "12:00 PM",
            status: "Checked In",
            statusIcon: "check-circle",
            statusColor: "green",
            duration: "6 nights",
            paymentStatus: "Paid",
            totalAmount: "$120.00",
            depositAmount: "$20.00",
            paidAmount: "$120.00",
            bookedBy: "Online",
            specialRequests: "Extra pillow, near window",
            notes: "First-time guest. Celebrating birthday during stay.",
            history: [
                { date: "Sep 25, 2023", time: "13:45", action: "Booking created", by: "John Smith (Self)" },
                { date: "Sep 28, 2023", time: "09:30", action: "Payment received", by: "System" },
                { date: "Oct 1, 2023", time: "11:30", action: "Checked in", by: "Admin Aiman" }
            ],
            actions: [
                { icon: "print", label: "Print Receipt" },
                { icon: "edit", label: "Edit Booking" },
                { icon: "sign-out-alt", label: "Check Out" },
                { icon: "exchange-alt", label: "Room Transfer" },
                { icon: "times-circle", label: "Cancel Booking" }
            ]
        },
        "2": {
            id: "2",
            guestName: "Jane Cooper",
            guestAvatar: "JC",
            avatarColor: "pink",
            nationality: "India",
            gender: "Female",
            roomNumber: "Room 102",
            bedInfo: "Bed 1 • 2-bed",
            checkInDate: "Sep 25, 2023",
            checkInTime: "10:00 AM",
            checkOutDate: "Oct 1, 2023",
            checkOutTime: "10:15 AM",
            status: "Checked Out",
            statusIcon: "sign-out-alt",
            statusColor: "red",
            duration: "6 nights",
            paymentStatus: "Paid",
            totalAmount: "$180.00",
            depositAmount: "$30.00",
            paidAmount: "$180.00",
            bookedBy: "Phone",
            specialRequests: "None",
            notes: "Regular guest, prefers quiet rooms",
            history: [
                { date: "Sep 20, 2023", time: "11:23", action: "Booking created", by: "Admin Aiman" },
                { date: "Sep 20, 2023", time: "11:25", action: "Payment received", by: "Admin Aiman" },
                { date: "Sep 25, 2023", time: "10:00", action: "Checked in", by: "Sarah Miller" },
                { date: "Oct 1, 2023", time: "10:15", action: "Checked out", by: "Admin Aiman" }
            ],
            actions: [
                { icon: "print", label: "Print Receipt" },
                { icon: "file-alt", label: "View Invoice" },
                { icon: "book", label: "New Booking" }
            ]
        },
        "3": {
            id: "3",
            guestName: "Alice Johnson",
            guestAvatar: "AJ",
            avatarColor: "green",
            nationality: "Indonesia",
            gender: "Female",
            roomNumber: "Room 303",
            bedInfo: "Bed 4 • 6-bed",
            checkInDate: "Sep 28, 2023",
            checkInTime: "2:15 PM",
            checkOutDate: "Oct 3, 2023",
            checkOutTime: "12:00 PM",
            status: "Checked Out",
            statusIcon: "sign-out-alt",
            statusColor: "red",
            duration: "5 nights",
            paymentStatus: "Paid",
            totalAmount: "$150.00",
            depositAmount: "$30.00",
            paidAmount: "$150.00",
            bookedBy: "Website",
            specialRequests: "Extra towels",
            notes: "",
            history: [
                { date: "Sep 15, 2023", time: "19:30", action: "Booking created", by: "Alice Johnson (Self)" },
                { date: "Sep 15, 2023", time: "19:32", action: "Payment received", by: "System" },
                { date: "Sep 28, 2023", time: "14:15", action: "Checked in", by: "Sarah Miller" },
                { date: "Oct 3, 2023", time: "11:45", action: "Checked out", by: "Admin Aiman" }
            ],
            actions: [
                { icon: "print", label: "Print Receipt" },
                { icon: "file-alt", label: "View Invoice" },
                { icon: "book", label: "New Booking" }
            ]
        },
        "4": {
            id: "4",
            guestName: "Michael Brown",
            guestAvatar: "MB",
            avatarColor: "purple",
            nationality: "Bangladesh",
            gender: "Male",
            roomNumber: "Room 205",
            bedInfo: "Bed 2 • 4-bed",
            checkInDate: "Oct 5, 2023",
            checkInTime: "9:30 AM",
            checkOutDate: "Oct 19, 2023",
            checkOutTime: "12:00 PM",
            status: "Upcoming",
            statusIcon: "clock",
            statusColor: "yellow",
            duration: "14 nights",
            paymentStatus: "Deposit Paid",
            totalAmount: "$420.00",
            depositAmount: "$70.00",
            paidAmount: "$70.00",
            bookedBy: "Admin",
            specialRequests: "Airport pickup",
            notes: "Long-term guest, visiting for business",
            history: [
                { date: "Sep 30, 2023", time: "10:15", action: "Booking created", by: "Admin Aiman" },
                { date: "Sep 30, 2023", time: "10:30", action: "Deposit payment received", by: "Admin Aiman" }
            ],
            actions: [
                { icon: "user-check", label: "Check In" },
                { icon: "edit", label: "Edit Booking" },
                { icon: "times-circle", label: "Cancel Booking" }
            ]
        }
    };
    
    // Function to show booking details
    function showBookingDetails(bookingId) {
        const booking = bookingData[bookingId];
        if (!booking) return;
        
        // Create details HTML
        let detailsHTML = `
            <div class="mb-6">
                <div class="flex items-center">
                    <div class="h-12 w-12 rounded-full bg-${booking.avatarColor}-100 flex items-center justify-center mr-4 shadow-sm border border-${booking.avatarColor}-200">
                        <span class="text-${booking.avatarColor}-600 font-medium text-lg">${booking.guestAvatar}</span>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">${booking.guestName}</h3>
                        <p class="text-sm text-gray-500">${booking.nationality} • ${booking.gender}</p>
                    </div>
                </div>
            </div>
            
            <div class="space-y-5">
                <!-- Booking Status -->
                <div class="bg-white rounded-lg border border-gray-200 p-4">
                    <h4 class="text-sm font-semibold text-gray-700 mb-3">Booking Status</h4>
                    <div class="flex items-center mb-3">
                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-${booking.statusColor}-100 text-${booking.statusColor}-800">
                            <i class="fas fa-${booking.statusIcon} mr-1"></i> ${booking.status}
                        </span>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <p class="text-xs text-gray-500">Check-in</p>
                            <p class="text-sm font-medium">${booking.checkInDate}</p>
                            <p class="text-xs text-gray-500">${booking.checkInTime}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Check-out</p>
                            <p class="text-sm font-medium">${booking.checkOutDate}</p>
                            <p class="text-xs text-gray-500">${booking.checkOutTime}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Duration</p>
                            <p class="text-sm font-medium">${booking.duration}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Booked via</p>
                            <p class="text-sm font-medium">${booking.bookedBy}</p>
                        </div>
                    </div>
                </div>
                
                <!-- Room Information -->
                <div class="bg-white rounded-lg border border-gray-200 p-4">
                    <h4 class="text-sm font-semibold text-gray-700 mb-3">Room Details</h4>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <p class="text-xs text-gray-500">Room Number</p>
                            <p class="text-sm font-medium">${booking.roomNumber}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Bed Info</p>
                            <p class="text-sm font-medium">${booking.bedInfo}</p>
                        </div>
                    </div>
                </div>
                
                <!-- Payment Information -->
                <div class="bg-white rounded-lg border border-gray-200 p-4">
                    <h4 class="text-sm font-semibold text-gray-700 mb-3">Payment Details</h4>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <p class="text-xs text-gray-500">Payment Status</p>
                            <p class="text-sm font-medium">${booking.paymentStatus}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Total Amount</p>
                            <p class="text-sm font-medium">${booking.totalAmount}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Deposit</p>
                            <p class="text-sm font-medium">${booking.depositAmount}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Paid Amount</p>
                            <p class="text-sm font-medium">${booking.paidAmount}</p>
                        </div>
                    </div>
                </div>`;
                
        // Add special requests if available
        if (booking.specialRequests) {
            detailsHTML += `
                <div class="bg-white rounded-lg border border-gray-200 p-4">
                    <h4 class="text-sm font-semibold text-gray-700 mb-2">Special Requests</h4>
                    <p class="text-sm text-gray-600">${booking.specialRequests}</p>
                </div>`;
        }
                
        // Add notes if available
        if (booking.notes) {
            detailsHTML += `
                <div class="bg-white rounded-lg border border-gray-200 p-4">
                    <h4 class="text-sm font-semibold text-gray-700 mb-2">Notes</h4>
                    <p class="text-sm text-gray-600">${booking.notes}</p>
                </div>`;
        }
                
        // Add booking history
        if (booking.history && booking.history.length > 0) {
            detailsHTML += `
                <div class="bg-white rounded-lg border border-gray-200 p-4">
                    <h4 class="text-sm font-semibold text-gray-700 mb-3">Booking History</h4>
                    <div class="space-y-3">`;
                    
            booking.history.forEach(item => {
                detailsHTML += `
                        <div class="flex items-start">
                            <div class="h-5 w-5 rounded-full bg-blue-100 flex items-center justify-center mr-2 mt-0.5">
                                <div class="h-2 w-2 rounded-full bg-blue-500"></div>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">${item.date} • ${item.time}</p>
                                <p class="text-sm">${item.action}</p>
                                <p class="text-xs text-gray-500">${item.by}</p>
                            </div>
                        </div>`;
            });
                    
            detailsHTML += `
                    </div>
                </div>`;
        }
                
        // Add action buttons
        if (booking.actions && booking.actions.length > 0) {
            detailsHTML += `
                <div class="bg-white rounded-lg border border-gray-200 p-4">
                    <h4 class="text-sm font-semibold text-gray-700 mb-3">Actions</h4>
                    <div class="flex flex-wrap gap-2">`;
                    
            booking.actions.forEach(action => {
                detailsHTML += `
                        <button class="flex items-center gap-1.5 px-3 py-1.5 rounded-md bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-medium transition-colors">
                            <i class="fas fa-${action.icon}"></i>
                            <span>${action.label}</span>
                        </button>`;
            });
                    
            detailsHTML += `
                </div>
            </div>`;
        }
                
        detailsHTML += `
            </div>`;
            
        // Set the content and show the panel
        bookingDetailsContent.innerHTML = detailsHTML;
        bookingDetailsPanel.style.width = '400px';
        bookingDetailsPanel.setAttribute('data-active-item', bookingId);
        
        // Update the collapse button
        const closeBtn = document.getElementById('closeBookingDetails');
        closeBtn.classList.add('active-collapse-btn');
        closeBtn.style.left = '0';
        closeBtn.querySelector('i').classList.remove('fa-chevron-left');
        closeBtn.querySelector('i').classList.add('fa-chevron-right');
        
        // Add active class to selected booking
        bookingItems.forEach(item => {
            if (item.dataset.bookingId === bookingId) {
                item.classList.add('selected-booking');
            } else {
                item.classList.remove('selected-booking');
            }
        });
    }
    
    // Function to hide booking details
    function hideBookingDetails() {
        bookingDetailsPanel.style.width = '0';
        bookingDetailsPanel.removeAttribute('data-active-item');
        
        // Update the collapse button
        const closeBtn = document.getElementById('closeBookingDetails');
        closeBtn.classList.remove('active-collapse-btn');
        closeBtn.style.left = '0';
        closeBtn.querySelector('i').classList.remove('fa-chevron-right');
        closeBtn.querySelector('i').classList.add('fa-chevron-left');
        
        // Remove active class from all bookings
        bookingItems.forEach(item => {
            item.classList.remove('selected-booking');
        });
    }
    
    // Add click event listeners to booking items
    bookingItems.forEach(item => {
        item.addEventListener('click', function() {
            const bookingId = this.dataset.bookingId;
            showBookingDetails(bookingId);
        });
    });
    
    // Add click event listener to close button
    closeBookingDetails.addEventListener('click', hideBookingDetails);
    
    // Add CSS for active booking
    const style = document.createElement('style');
    style.textContent = `
        .booking-item.selected-booking {
            background: linear-gradient(to right, rgba(139, 92, 246, 0.15), rgba(139, 92, 246, 0.03)) !important;
            border-color: rgba(167, 139, 250, 0.5) !important;
            box-shadow: none !important;
            position: relative;
        }
        
        .booking-item.selected-booking::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background-color: #8b5cf6;
            border-top-left-radius: 0.5rem;
            border-bottom-left-radius: 0.5rem;
        }
        
        /* Internal highlighting elements */
        .booking-item.selected-booking .h-8.w-8.rounded-full {
            border-width: 1px;
            border-color: rgba(167, 139, 250, 0.5) !important;
        }
        
        .booking-item.selected-booking .text-sm.font-medium.text-gray-900 {
            color: #6d28d9 !important; /* Purple-700 */
        }
        
        /* Dark mode styles */
        .dark-mode .booking-item.selected-booking {
            background: linear-gradient(to right, rgba(139, 92, 246, 0.25), rgba(139, 92, 246, 0.05)) !important;
            border-color: rgba(167, 139, 250, 0.5) !important;
            box-shadow: none !important;
        }
        
        .dark-mode .booking-item.selected-booking::before {
            background-color: #a78bfa;
            width: 4px;
            box-shadow: none;
        }
        
        .dark-mode .booking-item.selected-booking .text-sm.font-medium.text-gray-900 {
            color: #d8b4fe !important; /* Purple-300 - brighter */
            text-shadow: none;
        }
        
        .dark-mode .booking-item.selected-booking .text-xs.text-gray-500 {
            color: #e9d5ff !important; /* Purple-200 - brighter */
        }
        
        /* Style for closeBookingDetails button */
        #closeBookingDetails, #closeBookingDetails:focus, #closeBookingDetails:active {
            outline: 0 !important;
            box-shadow: none !important;
            --tw-ring-offset-shadow: none !important;
            --tw-ring-shadow: none !important;
        }
        
        #closeBookingDetails:hover {
            background-color: #e5e7eb !important;
        }
        
        .dark-mode #closeBookingDetails, .dark-mode #closeBookingDetails:focus, .dark-mode #closeBookingDetails:active {
            background-color: #374151 !important;
            border-color: #4b5563 !important;
        }
        
        .dark-mode #closeBookingDetails:hover {
            background-color: #4b5563 !important;
        }
        
        /* Booking details panel styling */
        #bookingDetailsInnerContentWrapper {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            border-radius: 0 0.5rem 0.5rem 0;
        }
        
        .dark-mode #bookingDetailsInnerContentWrapper {
            background-color: #1f2937 !important;
            border-color: #374151 !important;
        }
        
        .dark-mode #bookingDetailsPanelHeader {
            background-color: #111827 !important;
            border-color: #374151 !important;
        }
        
        .dark-mode #bookingDetailsPanelHeaderText {
            color: #f3f4f6 !important;
        }
    `;
    document.head.appendChild(style);
    
    // Initialize booking pagination
    initBookingPagination();
});
