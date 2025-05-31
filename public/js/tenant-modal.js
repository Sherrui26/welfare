// Functions for Tenant Modal operations
let currentTenantModalMode = 'add';

function openTenantModal(mode = 'add', tenantData = null) {
    currentTenantModalMode = mode;
    const modal = document.getElementById('tenantModal');
    if (!modal) {
        console.error('Tenant modal not found in the DOM');
        return;
    }
    
    const titleElement = modal.querySelector('.modal-title');
    const submitButton = modal.querySelector('#saveTenantBtn');
    
    // Set up modal based on mode
    if (mode === 'add') {
        if (titleElement) titleElement.textContent = 'Add New Tenant';
        if (submitButton) submitButton.textContent = 'Add Tenant';
        // Reset form fields
        const form = modal.querySelector('form');
        if (form) form.reset();
    } else if (mode === 'edit' && tenantData) {
        if (titleElement) titleElement.textContent = 'Edit Tenant';
        if (submitButton) submitButton.textContent = 'Save Changes';
        // Fill form with tenant data
        fillTenantForm(tenantData);
    }
    
    // Show modal with animation - using the modal navigation pattern from manage-room
    if (window.ModalNavigation) {
        window.ModalNavigation.open(modal);
    } else {
        // Fallback direct animation
        modal.classList.remove('hidden');
        
        // Force reflow to ensure animation works
        void modal.offsetWidth;
        
        setTimeout(() => {
            modal.classList.add('active', 'flex');
        }, 20);
    }
}

function closeTenantModal() {
    const modal = document.getElementById('tenantModal');
    if (!modal) return;
    
    // Hide modal with animation
    if (window.ModalNavigation) {
        window.ModalNavigation.close(modal);
    } else {
        modal.classList.remove('active');
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }, 300); // Match CSS transition duration
    }
}

function fillTenantForm(tenantData) {
    if (!tenantData) return;
    
    const modal = document.getElementById('tenantModal');
    if (!modal) return;
    
    // Example field mappings - adjust based on your actual form fields
    const fields = {
        'tenantName': tenantData.name || '',
        'tenantCode': tenantData.code || '',
        'contactPerson': tenantData.contactPerson || '',
        'staffCount': tenantData.staffCount || '',
        'contractStatus': tenantData.status || 'active'
    };
    
    // Apply values to form fields
    Object.keys(fields).forEach(fieldId => {
        const field = modal.querySelector(`#${fieldId}`);
        if (field) {
            if (field.tagName === 'SELECT') {
                field.value = fields[fieldId];
            } else {
                field.value = fields[fieldId];
            }
        }
    });
}

function saveTenant() {
    // Get form data
    const form = document.getElementById('tenantForm');
    if (!form) {
        console.error('Tenant form not found');
        return;
    }
    
    // Simple validation
    const requiredFields = ['tenantName', 'tenantCode', 'contactPerson'];
    let isValid = true;
    
    requiredFields.forEach(fieldId => {
        const field = document.getElementById(fieldId);
        if (field && !field.value.trim()) {
            field.classList.add('border-red-500');
            isValid = false;
        } else if (field) {
            field.classList.remove('border-red-500');
        }
    });
    
    if (!isValid) {
        // Show validation message
        const errorMsg = document.getElementById('tenantFormError');
        if (errorMsg) {
            errorMsg.textContent = 'Please fill all required fields';
            errorMsg.classList.remove('hidden');
        }
        return;
    }
    
    // Process the form data
    // For demonstration, log the data and close modal
    console.log('Saving tenant in mode:', currentTenantModalMode);
    
    // In a real app, you would submit this data to your backend
    
    // After successful save, close modal and refresh tenant list
    closeTenantModal();
    
    // For demonstration purposes, we'll reload the page to show the "changes"
    // In a real app, you would update the UI without a page reload
    setTimeout(() => {
        alert('Tenant ' + (currentTenantModalMode === 'add' ? 'added' : 'updated') + ' successfully!');
        // location.reload(); // Uncomment in production
    }, 300);
}

// Make functions globally accessible
window.openTenantModal = openTenantModal;
window.closeTenantModal = closeTenantModal;
window.saveTenant = saveTenant; 