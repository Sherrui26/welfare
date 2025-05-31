document.addEventListener('DOMContentLoaded', function() {
    // Activity details panel functionality
    const activityItems = document.querySelectorAll('.activity-item');
    const activityDetailsPanel = document.getElementById('activityDetailsPanel');
    const activityDetailsContent = document.getElementById('activityDetailsContent');
    const closeActivityDetails = document.getElementById('closeActivityDetails');
    const activityModalContent = document.querySelector('#activityModal > div');
    
    // Activity data (in a real app, this would come from a database)
    const activityData = {
        "1": {
            title: "Check-in: Room 101",
            time: "Today, 11:32 AM",
            type: "check-in",
            icon: "sign-in-alt",
            iconColor: "green",
            user: {
                name: "John Smith",
                avatar: "JS",
                role: "Guest"
            },
            room: {
                number: "101",
                type: "5-Bed Room",
                bedNumber: "Bed 3"
            },
            details: "Standard check-in process completed. All documentation verified and payment received.",
            duration: "7 days (Oct 1 - Oct 7, 2023)",
            paymentStatus: "Paid in full",
            staff: "Admin Aiman",
            notes: "Guest requested extra pillow and blanket. Items provided at check-in.",
            actions: [
                { icon: "file-alt", label: "View Receipt" },
                { icon: "edit", label: "Edit Check-in" },
                { icon: "key", label: "Access Key Log" }
            ]
        },
        "2": {
            title: "Check-out: Room 102",
            time: "Today, 10:15 AM",
            type: "check-out",
            icon: "sign-out-alt",
            iconColor: "red",
            user: {
                name: "Jane Cooper",
                avatar: "JC",
                role: "Guest"
            },
            room: {
                number: "102",
                type: "2-Bed Room",
                bedNumber: "Bed 1"
            },
            details: "Standard check-out completed. Room inspection passed with no damages.",
            duration: "6 days (Sep 25 - Oct 1, 2023)",
            paymentStatus: "Completed",
            staff: "Sarah Miller",
            notes: "Room needs deep cleaning before next check-in.",
            cleaningStatus: "Scheduled for 11:30 AM",
            actions: [
                { icon: "file-alt", label: "View Receipt" },
                { icon: "clipboard-check", label: "Inspection Report" },
                { icon: "broom", label: "Cleaning Schedule" }
            ]
        },
        "3": {
            title: "Maintenance: Room 103",
            time: "Today, 9:45 AM",
            type: "maintenance",
            icon: "tools",
            iconColor: "yellow",
            priority: "High",
            issue: "Plumbing issue - Bathroom sink leaking",
            reporter: {
                name: "Alice Johnson",
                avatar: "AJ",
                role: "Guest" 
            },
            room: {
                number: "103",
                type: "4-Bed Room",
                status: "Partially Occupied (3/4 beds)"
            },
            details: "Water leaking from under the sink cabinet. Maintenance team dispatched.",
            assignedTo: "Robert Johnson (Maintenance)",
            estimatedCompletion: "Today, 12:00 PM",
            status: "In Progress",
            updates: [
                { time: "9:50 AM", status: "Assigned to maintenance team" },
                { time: "10:15 AM", status: "Maintenance team arrived" }
            ],
            actions: [
                { icon: "check-circle", label: "Mark Completed" },
                { icon: "user-plus", label: "Reassign" },
                { icon: "comment", label: "Add Comment" }
            ]
        },
        "4": {
            title: "New Booking: Room 305",
            time: "Yesterday, 4:30 PM",
            type: "booking",
            icon: "calendar-alt",
            iconColor: "purple",
            user: {
                name: "Michael Chen",
                avatar: "MC",
                role: "New Guest"
            },
            room: {
                number: "305",
                type: "3-Bed Room",
                bedNumber: "Bed 2"
            },
            details: "New reservation made for next week. Deposit payment received.",
            bookingDuration: "14 days (Oct 10 - Oct 24, 2023)",
            paymentStatus: "50% Deposit Paid",
            staff: "Admin Aiman",
            amount: "$420 total / $210 paid",
            specialRequests: "Guest needs airport pickup service on arrival date",
            actions: [
                { icon: "file-invoice", label: "View Booking" },
                { icon: "edit", label: "Modify Booking" },
                { icon: "times-circle", label: "Cancel Booking" }
            ]
        },
        "5": {
            title: "Maintenance Completed: Room 202",
            time: "Yesterday, 2:15 PM",
            type: "maintenance",
            icon: "tools",
            iconColor: "green",
            issue: "Electrical issues - Power outlet not working",
            room: {
                number: "202",
                type: "5-Bed Room",
                status: "Fully Occupied (5/5 beds)"
            },
            details: "Faulty power outlet replaced. All electrical fixtures tested and working properly.",
            reportedBy: "David Wilson (Guest)",
            completedBy: "Robert Johnson (Maintenance)",
            duration: "Started at 1:30 PM, Completed at 2:15 PM (45 minutes)",
            partsReplaced: "Wall outlet, Wiring",
            cost: "$45.00 (Parts and Labor)",
            notes: "Reminded guests about not overloading the outlets with multiple devices",
            actions: [
                { icon: "file-alt", label: "View Report" },
                { icon: "bell", label: "Notify Tenants" },
                { icon: "clipboard-list", label: "Maintenance History" }
            ]
        },
        "6": {
            title: "New Booking: Room 305",
            time: "Yesterday, 4:30 PM",
            type: "booking",
            icon: "calendar-alt",
            iconColor: "purple",
            user: {
                name: "Michael Chen",
                avatar: "MC",
                role: "New Guest"
            },
            room: {
                number: "305",
                type: "3-Bed Room",
                bedNumber: "Bed 2"
            },
            details: "New reservation made for next week. Deposit payment received.",
            bookingDuration: "14 days (Oct 10 - Oct 24, 2023)",
            paymentStatus: "50% Deposit Paid",
            staff: "Admin Aiman",
            amount: "$420 total / $210 paid",
            specialRequests: "Guest needs airport pickup service on arrival date",
            actions: [
                { icon: "file-invoice", label: "View Booking" },
                { icon: "edit", label: "Modify Booking" },
                { icon: "times-circle", label: "Cancel Booking" }
            ]
        },
        "7": {
            title: "New Booking: Room 305",
            time: "Yesterday, 4:30 PM",
            type: "booking",
            icon: "calendar-alt",
            iconColor: "purple",
            user: {
                name: "Michael Chen",
                avatar: "MC",
                role: "New Guest"
            },
            room: {
                number: "305",
                type: "3-Bed Room",
                bedNumber: "Bed 2"
            },
            details: "New reservation made for next week. Deposit payment received.",
            bookingDuration: "14 days (Oct 10 - Oct 24, 2023)",
            paymentStatus: "50% Deposit Paid",
            staff: "Admin Aiman",
            amount: "$420 total / $210 paid",
            specialRequests: "Guest needs airport pickup service on arrival date",
            actions: [
                { icon: "file-invoice", label: "View Booking" },
                { icon: "edit", label: "Modify Booking" },
                { icon: "times-circle", label: "Cancel Booking" }
            ]
        }
    };
    
    // Function to show activity details
    function showActivityDetails(activityId) {
        const activity = activityData[activityId];
        if (!activity) return;
        
        // Set content based on activity type
        let detailsHTML = `
            <div class="mb-6">
                <div class="flex items-center">
                    <div class="h-12 w-12 rounded-full bg-${activity.iconColor}-100 flex items-center justify-center mr-4 shadow-sm border border-${activity.iconColor}-200">
                        <i class="fas fa-${activity.icon} text-${activity.iconColor}-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">${activity.title}</h3>
                        <p class="text-sm text-gray-500">${activity.time}</p>
                    </div>
                </div>
            </div>
            
            <div class="space-y-5">`;
            
        // Add user/reporter information if available
        if (activity.user || activity.reporter) {
            const person = activity.user || activity.reporter;
            detailsHTML += `
                <div class="bg-white rounded-lg border border-gray-200 p-4">
                    <h4 class="text-sm font-semibold text-gray-700 mb-3">${activity.type === 'maintenance' ? 'Reported By' : 'Guest Information'}</h4>
                    <div class="flex items-center">
                        <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center mr-3 text-blue-700 font-medium">
                            ${person.avatar}
                        </div>
                        <div>
                            <p class="text-sm font-medium">${person.name}</p>
                            <p class="text-xs text-gray-500">${person.role}</p>
                        </div>
                    </div>
                </div>`;
        }
            
        // Add room information
        detailsHTML += `
            <div class="bg-white rounded-lg border border-gray-200 p-4">
                <h4 class="text-sm font-semibold text-gray-700 mb-3">Room Details</h4>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <p class="text-xs text-gray-500">Room Number</p>
                        <p class="text-sm font-medium">${activity.room.number}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Room Type</p>
                        <p class="text-sm font-medium">${activity.room.type}</p>
                    </div>`;
                    
        if (activity.room.bedNumber) {
            detailsHTML += `
                    <div>
                        <p class="text-xs text-gray-500">Bed Assignment</p>
                        <p class="text-sm font-medium">${activity.room.bedNumber}</p>
                    </div>`;
        }
                
        if (activity.room.status) {
            detailsHTML += `
                    <div>
                        <p class="text-xs text-gray-500">Occupancy Status</p>
                        <p class="text-sm font-medium">${activity.room.status}</p>
                    </div>`;
        }
                
        detailsHTML += `
                </div>
            </div>`;
            
        // Add activity-specific details
        detailsHTML += `
            <div class="bg-white rounded-lg border border-gray-200 p-4">
                <h4 class="text-sm font-semibold text-gray-700 mb-3">Activity Details</h4>
                <p class="text-sm text-gray-700 mb-3">${activity.details}</p>
                
                <div class="space-y-2 mt-4">`;
                
        // Add different fields based on activity type
        if (activity.type === 'check-in' || activity.type === 'check-out' || activity.type === 'booking') {
            detailsHTML += `
                    <div class="flex justify-between">
                        <span class="text-xs text-gray-500">Duration:</span>
                        <span class="text-xs font-medium">${activity.duration || activity.bookingDuration}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-xs text-gray-500">Payment Status:</span>
                        <span class="text-xs font-medium">${activity.paymentStatus}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-xs text-gray-500">Processed By:</span>
                        <span class="text-xs font-medium">${activity.staff}</span>
                    </div>`;
                    
            if (activity.amount) {
                detailsHTML += `
                    <div class="flex justify-between">
                        <span class="text-xs text-gray-500">Amount:</span>
                        <span class="text-xs font-medium">${activity.amount}</span>
                    </div>`;
            }
        }
                
        if (activity.type === 'maintenance') {
            detailsHTML += `
                    <div class="flex justify-between">
                        <span class="text-xs text-gray-500">Issue:</span>
                        <span class="text-xs font-medium">${activity.issue}</span>
                    </div>`;
                    
            if (activity.priority) {
                detailsHTML += `
                    <div class="flex justify-between">
                        <span class="text-xs text-gray-500">Priority:</span>
                        <span class="text-xs font-medium">${activity.priority}</span>
                    </div>`;
            }
                    
            if (activity.assignedTo) {
                detailsHTML += `
                    <div class="flex justify-between">
                        <span class="text-xs text-gray-500">Assigned To:</span>
                        <span class="text-xs font-medium">${activity.assignedTo}</span>
                    </div>`;
            }
                    
            if (activity.completedBy) {
                detailsHTML += `
                    <div class="flex justify-between">
                        <span class="text-xs text-gray-500">Completed By:</span>
                        <span class="text-xs font-medium">${activity.completedBy}</span>
                    </div>`;
            }
                    
            if (activity.status) {
                detailsHTML += `
                    <div class="flex justify-between">
                        <span class="text-xs text-gray-500">Status:</span>
                        <span class="text-xs font-medium">${activity.status}</span>
                    </div>`;
            }
                    
            if (activity.estimatedCompletion) {
                detailsHTML += `
                    <div class="flex justify-between">
                        <span class="text-xs text-gray-500">Est. Completion:</span>
                        <span class="text-xs font-medium">${activity.estimatedCompletion}</span>
                    </div>`;
            }
                    
            if (activity.duration) {
                detailsHTML += `
                    <div class="flex justify-between">
                        <span class="text-xs text-gray-500">Duration:</span>
                        <span class="text-xs font-medium">${activity.duration}</span>
                    </div>`;
            }
        }
                
        detailsHTML += `
                </div>
            </div>`;
            
        // Add notes if available
        if (activity.notes) {
            detailsHTML += `
            <div class="bg-white rounded-lg border border-gray-200 p-4">
                <h4 class="text-sm font-semibold text-gray-700 mb-2">Notes</h4>
                <p class="text-sm text-gray-600">${activity.notes}</p>
            </div>`;
        }
            
        // Add updates for maintenance
        if (activity.updates && activity.updates.length > 0) {
            detailsHTML += `
            <div class="bg-white rounded-lg border border-gray-200 p-4">
                <h4 class="text-sm font-semibold text-gray-700 mb-3">Activity Updates</h4>
                <div class="space-y-2">`;
                
            activity.updates.forEach(update => {
                detailsHTML += `
                    <div class="flex items-start">
                        <div class="h-5 w-5 rounded-full bg-blue-100 flex items-center justify-center mr-2 mt-0.5">
                            <div class="h-2 w-2 rounded-full bg-blue-500"></div>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">${update.time}</p>
                            <p class="text-sm">${update.status}</p>
                        </div>
                    </div>`;
            });
                
            detailsHTML += `
                </div>
            </div>`;
        }
            
        // Add action buttons
        if (activity.actions && activity.actions.length > 0) {
            detailsHTML += `
            <div class="bg-white rounded-lg border border-gray-200 p-4">
                <h4 class="text-sm font-semibold text-gray-700 mb-3">Actions</h4>
                <div class="flex flex-wrap gap-2">`;
                
            activity.actions.forEach(action => {
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
        activityDetailsContent.innerHTML = detailsHTML;
        activityDetailsPanel.style.width = '400px';
        activityDetailsPanel.setAttribute('data-active-item', activityId); // Store active item ID
        
        // Update the collapse button
        const closeBtn = document.getElementById('closeActivityDetails');
        closeBtn.classList.add('active-collapse-btn');
        closeBtn.style.left = '0';
        closeBtn.querySelector('i').classList.remove('fa-chevron-left');
        closeBtn.querySelector('i').classList.add('fa-chevron-right');
        
        // Add active class to selected activity
        activityItems.forEach(item => {
            if (item.dataset.activityId === activityId) {
                item.classList.add('selected-activity');
            } else {
                item.classList.remove('selected-activity');
            }
        });
    }
    
    // Function to hide activity details
    function hideActivityDetails() {
        activityDetailsPanel.style.width = '0';
        activityDetailsPanel.removeAttribute('data-active-item'); // Clear active item reference
        
        // Update the collapse button
        const closeBtn = document.getElementById('closeActivityDetails');
        closeBtn.classList.remove('active-collapse-btn');
        closeBtn.style.left = '0';
        closeBtn.querySelector('i').classList.remove('fa-chevron-right');
        closeBtn.querySelector('i').classList.add('fa-chevron-left');
        
        // Remove active class from all activities
        activityItems.forEach(item => {
            item.classList.remove('selected-activity');
        });
    }
    
    // Add click event listeners to activity items
    activityItems.forEach(item => {
        item.addEventListener('click', function() {
            const activityId = this.dataset.activityId;
            showActivityDetails(activityId);
        });
    });
    
    // Add click event listener to close button
    closeActivityDetails.addEventListener('click', hideActivityDetails);
    
    // Add CSS for active activity
    const style = document.createElement('style');
    style.textContent = `
        .activity-item.selected-activity {
            background: linear-gradient(to right, rgba(139, 92, 246, 0.15), rgba(139, 92, 246, 0.03)) !important;
            border-color: rgba(167, 139, 250, 0.5) !important;
            box-shadow: none !important;
            position: relative;
        }
        
        .activity-item.selected-activity::before {
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
        .activity-item.selected-activity .h-10.w-10.rounded-full {
            border-width: 1px;
            border-color: rgba(167, 139, 250, 0.5) !important;
        }
        
        .activity-item.selected-activity .text-sm.font-medium.text-gray-800 {
            color: #6d28d9 !important; /* Purple-700 */
        }
        
        .activity-item.selected-activity .text-xs.text-gray-400.bg-gray-50 {
            background-color: #ddd6fe !important; /* Purple-200 */
            color: #5b21b6 !important; /* Purple-800 */
        }
        
        /* Dark mode styles */
        .dark-mode .activity-item.selected-activity {
            background: linear-gradient(to right, rgba(139, 92, 246, 0.25), rgba(139, 92, 246, 0.05)) !important;
            border-color: rgba(167, 139, 250, 0.5) !important;
            box-shadow: none !important;
        }
        
        .dark-mode .activity-item.selected-activity::before {
            background-color: #a78bfa;
            width: 4px;
            box-shadow: none;
        }
        
        .dark-mode .activity-item.selected-activity .text-sm.font-medium.text-gray-800 {
            color: #d8b4fe !important; /* Purple-300 - brighter */
            text-shadow: none;
        }
        
        .dark-mode .activity-item.selected-activity .text-xs.text-gray-500 {
            color: #e9d5ff !important; /* Purple-200 - brighter */
        }
        
        .dark-mode .activity-item.selected-activity .text-xs.text-gray-400.bg-gray-50 {
            background-color: #7c3aed !important; /* Purple-600 - brighter than before */
            color: white !important;
            font-weight: 600;
            box-shadow: none;
        }
        
        /* Make icon container styling more subtle */
        .dark-mode .activity-item.selected-activity .h-10.w-10.rounded-full {
            border-width: 1px;
            border-color: rgba(167, 139, 250, 0.5) !important;
            box-shadow: none;
        }
    `;
    document.head.appendChild(style);
    
    // Initial setup - add selected-activity class if details are showing
    if (activityDetailsPanel.offsetWidth > 0) {
        const activeItemId = activityDetailsPanel.getAttribute('data-active-item');
        if (activeItemId) {
            document.querySelector(`.activity-item[data-activity-id="${activeItemId}"]`)?.classList.add('selected-activity');
        }
    }
});
