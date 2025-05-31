document.addEventListener('DOMContentLoaded', function() {
    // Get DOM elements
    const bookingsModal = document.getElementById('bookingsModal');
    const closeBookingsModal = document.getElementById('closeBookingsModal');
    const bookingDetailsModal = document.getElementById('bookingDetailsModal');
    const closeBookingDetailsModal = document.getElementById('closeBookingDetailsModal');
    const bookingDetailsModalContent = document.getElementById('bookingDetailsModalContent');
    const viewAllBookingsBtn = document.getElementById('viewAllBookingsBtn');
    
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
                { icon: "edit", label: "Edit Booking" },
                { icon: "sign-out-alt", label: "Check Out" },
                { icon: "exchange-alt", label: "Room Transfer" },
                { icon: "times-circle", label: "Cancel Booking" }
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
        detailsHTML += `
            <div class="flex justify-center space-x-3 mt-6">
                <button class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-md font-medium text-sm transition-colors">
                    <i class="fas fa-print mr-2"></i>Print
                </button>
                <button class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-md font-medium text-sm transition-colors">
                    <i class="fas fa-edit mr-2"></i>Edit Booking
                </button>
            </div>`;
                
        detailsHTML += `
            </div>`;
            
        // Set the content and show the modal
        bookingDetailsModalContent.innerHTML = detailsHTML;
        bookingDetailsModal.classList.remove('hidden');
    }
    
    // Add click event listeners to "View Details" buttons in booking items
    const viewDetailsButtons = document.querySelectorAll('#bookingsModal table button[title="View Details"]');
    viewDetailsButtons.forEach((button, index) => {
        button.addEventListener('click', function(e) {
            e.stopPropagation(); // Prevent event bubbling
            showBookingDetails(String(index + 1)); // Using index+1 as booking IDs
        });
    });
    
    // Event listener for the "View All Bookings" button
    if (viewAllBookingsBtn) {
        viewAllBookingsBtn.addEventListener('click', function() {
            bookingsModal.classList.remove('hidden');
        });
    }
    
    // Event listener for closing the bookings modal
    if (closeBookingsModal) {
        closeBookingsModal.addEventListener('click', function() {
            bookingsModal.classList.add('hidden');
        });
    }
    
    // Event listener for closing the booking details modal
    if (closeBookingDetailsModal) {
        closeBookingDetailsModal.addEventListener('click', function() {
            bookingDetailsModal.classList.add('hidden');
        });
    }
    
    // Close modals when clicking outside
    window.addEventListener('click', function(e) {
        if (e.target === bookingsModal) {
            bookingsModal.classList.add('hidden');
        }
        if (e.target === bookingDetailsModal) {
            bookingDetailsModal.classList.add('hidden');
        }
    });
    
    // Initialize booking pagination
    initBookingPagination();
    
    function initBookingPagination() {
        const paginationButtons = document.querySelectorAll('#bookingPaginationButtons .booking-page-btn');
        const prevButton = document.getElementById('bookingPrevPage');
        const nextButton = document.getElementById('bookingNextPage');
        
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
                    const startRecord = (pageNum - 1) * 4 + 1;
                    const endRecord = Math.min(pageNum * 4, 24);
                    document.getElementById('bookingStartRecord').textContent = startRecord;
                    document.getElementById('bookingEndRecord').textContent = endRecord;
                    
                    // Here you would typically fetch and display the corresponding page of bookings
                    // For demo purposes, we're just updating the UI
                });
            });
            
            // Add click handlers for prev/next buttons
            if (prevButton) {
                prevButton.addEventListener('click', function() {
                    if (this.disabled) return;
                    
                    const activePage = document.querySelector('#bookingPaginationButtons .booking-page-btn.active');
                    const pageNum = parseInt(activePage.textContent.trim());
                    if (pageNum > 1) {
                        document.querySelector(`#bookingPaginationButtons .booking-page-btn:nth-child(${pageNum})`).click();
                    }
                });
            }
            
            if (nextButton) {
                nextButton.addEventListener('click', function() {
                    if (this.disabled) return;
                    
                    const activePage = document.querySelector('#bookingPaginationButtons .booking-page-btn.active');
                    const pageNum = parseInt(activePage.textContent.trim());
                    if (pageNum < paginationButtons.length) {
                        document.querySelector(`#bookingPaginationButtons .booking-page-btn:nth-child(${pageNum + 2})`).click();
                    }
                });
            }
        }
    }
});
