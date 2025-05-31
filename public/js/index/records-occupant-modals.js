document.addEventListener('DOMContentLoaded', function() {
    // Get modal elements
    const recordsModal = document.getElementById('recordsModal');
    const occupantDetailsModal = document.getElementById('occupantDetailsModal');
    const viewAllRecordsBtn = document.getElementById('viewAllRecordsBtn');
    const closeRecordsModal = document.getElementById('closeRecordsModal');
    const closeOccupantDetailsModal = document.getElementById('closeOccupantDetailsModal');
    const backToRecordsModal = document.getElementById('backToRecordsModal');
    
    // Get all "View Details" buttons in the records table
    const viewDetailsButtons = document.querySelectorAll('#recordsModal .view-details-btn');
    
    // Sample occupant data
    const occupantData = {
        // Ahmad Zaki (New Issue)
        "0": {
            name: "Ahmad Zaki",
            id: "88159831",
            company: "Global Tech",
            room: "Room 101",
            building: "RSC7",
            floor: "First Floor",
            date: "Oct 1, 2023",
            time: "10:25 AM",
            gender: "Male",
            status: "New Issue",
            statusClass: "bg-indigo-100 text-indigo-800 dark:bg-green-500 dark:text-white",
            duration: "Oct 1, 2023 - Present",
            items: {
                accessCard: { status: "Returned", icon: "check-circle", color: "green" },
                roomKey: { status: "Returned", icon: "check-circle", color: "green" },
                lockerKey: { status: "N/A", icon: "minus-circle", color: "gray" },
                blanket: { status: "Returned", icon: "check-circle", color: "green" },
                bedSheet: { status: "Returned", icon: "check-circle", color: "green" },
                pillow: { status: "Returned", icon: "check-circle", color: "green" },
                pillowCase: { status: "Returned", icon: "check-circle", color: "green" }
            },
            remarks: "All items in good condition. No damages reported."
        },
        // Rahul Singh (New Issue)
        "1": {
            name: "Rahul Singh",
            id: "PA9284617",
            company: "Sri Paandi",
            room: "Room 202",
            building: "RSC7",
            floor: "Second Floor",
            date: "Oct 2, 2023",
            time: "2:15 PM",
            gender: "Male",
            status: "New Issue",
            statusClass: "bg-indigo-100 text-indigo-800 dark:bg-green-500 dark:text-white",
            duration: "Oct 2, 2023 - Present",
            items: {
                accessCard: { status: "Issued", icon: "check-circle", color: "blue" },
                roomKey: { status: "Issued", icon: "check-circle", color: "blue" },
                lockerKey: { status: "Issued", icon: "check-circle", color: "blue" },
                blanket: { status: "Issued", icon: "check-circle", color: "blue" },
                bedSheet: { status: "Issued", icon: "check-circle", color: "blue" },
                pillow: { status: "Issued", icon: "check-circle", color: "blue" },
                pillowCase: { status: "Issued", icon: "check-circle", color: "blue" }
            },
            remarks: "Tenant requested extra pillow. Noted maintenance issue with bathroom light."
        },
        // Muhd Faiz (Cleared)
        "2": {
            name: "Muhd Faiz",
            id: "88127719",
            company: "Sri Paandi",
            room: "Room 404",
            building: "RSC7",
            floor: "Fourth Floor",
            date: "Oct 3, 2023",
            time: "11:45 AM",
            gender: "Male",
            status: "Cleared",
            statusClass: "bg-red-100 text-red-800 dark:bg-red-500 dark:text-white",
            duration: "Jun 15, 2023 - Oct 3, 2023",
            items: {
                accessCard: { status: "Returned", icon: "check-circle", color: "green" },
                roomKey: { status: "Returned", icon: "check-circle", color: "green" },
                lockerKey: { status: "Returned", icon: "check-circle", color: "green" },
                blanket: { status: "Damaged", icon: "exclamation-circle", color: "red" },
                bedSheet: { status: "Returned", icon: "check-circle", color: "green" },
                pillow: { status: "Returned", icon: "check-circle", color: "green" },
                pillowCase: { status: "Missing", icon: "times-circle", color: "red" }
            },
            remarks: "Blanket has small burn mark, deduction of RM50 from deposit. Pillow case missing, deduction of RM15."
        },
        // Wan Ahmad (New Issue)
        "3": {
            name: "Wan Ahmad",
            id: "88159831",
            company: "East Coast",
            room: "Room 305",
            building: "RSC7",
            floor: "Third Floor",
            date: "Oct 3, 2023",
            time: "3:30 PM",
            gender: "Male",
            status: "New Issue",
            statusClass: "bg-indigo-100 text-indigo-800 dark:bg-green-500 dark:text-white",
            duration: "Oct 3, 2023 - Present",
            items: {
                accessCard: { status: "Issued", icon: "check-circle", color: "blue" },
                roomKey: { status: "Issued", icon: "check-circle", color: "blue" },
                lockerKey: { status: "N/A", icon: "minus-circle", color: "gray" },
                blanket: { status: "Issued", icon: "check-circle", color: "blue" },
                bedSheet: { status: "Issued", icon: "check-circle", color: "blue" },
                pillow: { status: "Issued", icon: "check-circle", color: "blue" },
                pillowCase: { status: "Issued", icon: "check-circle", color: "blue" }
            },
            remarks: "No special requests. All items provided in good condition."
        },
        // Lee Min Ho (Cleared)
        "4": {
            name: "Lee Min Ho",
            id: "88127755",
            company: "Global Tech",
            room: "Room 201",
            building: "RSC7",
            floor: "Second Floor",
            date: "Oct 4, 2023",
            time: "9:15 AM",
            gender: "Male",
            status: "Cleared",
            statusClass: "bg-red-100 text-red-800 dark:bg-red-500 dark:text-white",
            duration: "Aug 10, 2023 - Oct 4, 2023",
            items: {
                accessCard: { status: "Returned", icon: "check-circle", color: "green" },
                roomKey: { status: "Returned", icon: "check-circle", color: "green" },
                lockerKey: { status: "Returned", icon: "check-circle", color: "green" },
                blanket: { status: "Returned", icon: "check-circle", color: "green" },
                bedSheet: { status: "Returned", icon: "check-circle", color: "green" },
                pillow: { status: "Returned", icon: "check-circle", color: "green" },
                pillowCase: { status: "Returned", icon: "check-circle", color: "green" }
            },
            remarks: "All items returned in excellent condition. Tenant maintained room well."
        }
    };
    
    // Function to show the Records Modal
    function showRecordsModal() {
        recordsModal.classList.remove('hidden');
        setTimeout(() => {
            recordsModal.classList.add('active');
            document.body.classList.add('overflow-hidden');
        }, 10);
    }
    
    // Function to hide the Records Modal
    function hideRecordsModal() {
        recordsModal.classList.remove('active');
        setTimeout(() => {
            recordsModal.classList.add('hidden');
            if (!occupantDetailsModal.classList.contains('active')) {
                document.body.classList.remove('overflow-hidden');
            }
        }, 300);
    }
    
    // Function to show the Occupant Details Modal
    function showOccupantDetailsModal(occupantIndex) {
        // Get occupant data
        const occupant = occupantData[occupantIndex];
        if (!occupant) return;
        
        // Update modal content with occupant data
        document.getElementById('occupantStatusBadge').textContent = occupant.status;
        document.getElementById('occupantStatusBadge').className = `px-2.5 py-0.5 rounded-full text-xs font-medium ${occupant.statusClass} mr-3`;
        document.getElementById('occupantDate').textContent = `${occupant.date} • ${occupant.time}`;
        document.getElementById('occupantName').textContent = occupant.name;
        document.getElementById('occupantID').textContent = occupant.id;
        document.getElementById('occupantCompany').textContent = occupant.company;
        document.getElementById('occupantGender').textContent = occupant.gender;
        document.getElementById('occupantRoom').textContent = occupant.room;
        document.getElementById('occupantBuilding').textContent = occupant.building;
        document.getElementById('occupantFloor').textContent = occupant.floor;
        document.getElementById('occupantDuration').textContent = occupant.duration;
        document.getElementById('occupantRemarks').textContent = occupant.remarks || '-';
        
        // Update item statuses
        updateItemStatus('accessCardStatus', occupant.items.accessCard);
        updateItemStatus('roomKeyStatus', occupant.items.roomKey);
        updateItemStatus('lockerKeyStatus', occupant.items.lockerKey);
        updateItemStatus('blanketStatus', occupant.items.blanket);
        updateItemStatus('bedSheetStatus', occupant.items.bedSheet);
        updateItemStatus('pillowStatus', occupant.items.pillow);
        updateItemStatus('pillowCaseStatus', occupant.items.pillowCase);
        
        // Show the modal
        occupantDetailsModal.classList.remove('hidden');
        setTimeout(() => {
            occupantDetailsModal.classList.add('active');
            document.body.classList.add('overflow-hidden');
        }, 10);
    }
    
    // Function to update item status
    function updateItemStatus(elementId, itemData) {
        const element = document.getElementById(elementId);
        if (element) {
            element.innerHTML = `
                <i class="fas fa-${itemData.icon} text-${itemData.color}-500 mr-1.5"></i>
                <span class="text-sm font-medium">${itemData.status}</span>
            `;
        }
    }
    
    // Function to hide the Occupant Details Modal
    function hideOccupantDetailsModal() {
        occupantDetailsModal.classList.remove('active');
        setTimeout(() => {
            occupantDetailsModal.classList.add('hidden');
            if (!recordsModal.classList.contains('active')) {
                document.body.classList.remove('overflow-hidden');
            }
        }, 300);
    }
    
    // Event listeners
    if (viewAllRecordsBtn) {
        viewAllRecordsBtn.addEventListener('click', showRecordsModal);
    }
    
    if (closeRecordsModal) {
        closeRecordsModal.addEventListener('click', hideRecordsModal);
    }
    
    if (closeOccupantDetailsModal) {
        closeOccupantDetailsModal.addEventListener('click', hideOccupantDetailsModal);
    }
    
    if (backToRecordsModal) {
        backToRecordsModal.addEventListener('click', function() {
            hideOccupantDetailsModal();
            showRecordsModal();
        });
    }
    
    // Add click handler to View Details buttons
    viewDetailsButtons.forEach((button, index) => {
        button.addEventListener('click', function() {
            hideRecordsModal();
            setTimeout(() => {
                showOccupantDetailsModal(index);
            }, 300);
        });
    });
});
