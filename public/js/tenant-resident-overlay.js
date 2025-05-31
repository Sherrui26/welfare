// Variables for Resident Overlay Pagination
let allResidents = [];
let currentResidentPage = 1;
let residentsPerPage = 10; // Default, will be synced with selector
let currentTenantCode = null;
let currentResidentQuery = '';

// Predefined data for more realistic dummy content
const DUMMY_DEPARTMENTS = ['Engineering', 'Operations & Logistics', 'Site Services', 'Administration', 'Security & Safety', 'Catering Crew', 'Maintenance Unit', 'Project Management', 'Human Resources', 'Quality Assurance'];
const DUMMY_WORK_LOCATIONS = ['Main Site - Block A', 'Sector 7 Workshop', 'Central Dormitory Complex', 'Gatehouse Operations', 'West Wing Facilities', 'East Wing Offices', 'Logistics Hub', 'Technical Support Center', 'Mess Hall Alpha', 'Site Command Post'];
const DUMMY_FIRST_NAMES = ['Ahmad', 'Muhammad', 'Lee', 'Tan', 'Siti', 'Nor', 'Rajesh', 'Priya', 'Chen', 'Wang', 'John', 'Jane', 'Omar', 'Fatima'];
const DUMMY_LAST_NAMES = ['Abdullah', 'Bin Hassan', 'Tan', 'Lim', 'Kaur', 'Kumar', 'Li', 'Zhang', 'Doe', 'Smith', 'Ali', 'Yusof'];


// Add new functions for Resident Overlay
function openResidentOverlay(button) {
    const card = button.closest('.tenant-card');
    const tenantName = card.querySelector('h2').textContent;
    currentTenantCode = card.getAttribute('data-tenant'); // Store tenant code
    
    const overlay = document.getElementById('residentOverlay');
    overlay.querySelector('#overlayTenantName').textContent = tenantName;
    
    // Reset search and pagination
    currentResidentPage = 1;
    currentResidentQuery = '';
    document.getElementById('residentSearchInput').value = '';
    const perPageSelect = document.getElementById('residentsPerPageSelect');
    if (perPageSelect) {
        residentsPerPage = parseInt(perPageSelect.value) || 10;
    }
    
    // Show loading state
    const tableBody = overlay.querySelector('#residentTableBody');
    tableBody.innerHTML = '<tr><td colspan="6" class="text-center py-4 text-gray-500">Loading residents... <i class="fas fa-spinner fa-spin ml-2"></i></td></tr>';
    
    // Use the ModalNavigation utility if available
    if (window.ModalNavigation) {
        window.ModalNavigation.open(overlay);
    } else {
        // Show the overlay backdrop immediately but delay adding 'active' for transition
        overlay.classList.remove('hidden');
        overlay.classList.add('flex'); // Use flex to enable centering
        
        // Force reflow to ensure animation works
        void overlay.offsetWidth;
        
        // Add 'active' after a tiny delay to ensure the transition triggers
        setTimeout(() => {
            overlay.classList.add('active');
        }, 20); 
    }
    
    // Simulate fetching residents for the tenant
    fetchResidents(currentTenantCode);
    
    // Setup search input listener if not already done
    const searchInput = document.getElementById('residentSearchInput');
    if (!searchInput.dataset.listenerAttached) {
        searchInput.addEventListener('input', handleResidentSearch);
        searchInput.dataset.listenerAttached = 'true'; // Prevent adding multiple listeners
    }
    
    // Setup pagination listeners (prev/next are handled in initializeResidentOverlay, page numbers in update)
}

// Simulate fetching a larger list of residents with improved data
function fetchResidents(tenantCode) {
    console.log(`Fetching residents for ${tenantCode} - this will be a more detailed list.`);
    allResidents = [];
    // For demonstration, generate a random number of residents between 25-85
    const numResidents = Math.floor(Math.random() * 61) + 25;
    
    for (let i = 0; i < numResidents; i++) {
        const firstName = DUMMY_FIRST_NAMES[Math.floor(Math.random() * DUMMY_FIRST_NAMES.length)];
        const lastName = DUMMY_LAST_NAMES[Math.floor(Math.random() * DUMMY_LAST_NAMES.length)];
        
        let empNoOrIcPassportValue;
        const idType = Math.random();
        if (idType < 0.45) { // 45% chance EMP No
            empNoOrIcPassportValue = `EMP${String(Math.floor(Math.random() * 9000) + 1000).padStart(4, '0')}`;
        } else if (idType < 0.85) { // 40% chance IC (Malaysian-like)
            const year = String(Math.floor(Math.random() * 40) + 60).padStart(2, '0'); // YY (e.g., 60-99 for 1960-1999)
            const month = String(Math.floor(Math.random() * 12) + 1).padStart(2, '0');
            const day = String(Math.floor(Math.random() * 28) + 1).padStart(2, '0');
            const region = String(Math.floor(Math.random() * 14) + 1).padStart(2, '0'); // Simplified region code
            const suffix = String(Math.floor(Math.random() * 10000)).padStart(4, '0');
            empNoOrIcPassportValue = `${year}${month}${day}-${region}-${suffix}`;
        } else { // 15% chance Passport (generic alpha-numeric)
            const prefix = String.fromCharCode(65 + Math.floor(Math.random() * 26)); // Random uppercase letter
            empNoOrIcPassportValue = `${prefix}${String(Math.floor(Math.random() * 90000000) + 10000000)}`;
        }

        allResidents.push({
            id: `RES-${tenantCode}-${i + 1}`,
            name: `${firstName} ${lastName}`,
            empNoOrIcPassport: empNoOrIcPassportValue,
            roomNo: `B${Math.floor(Math.random() * 5) + 1}-L${Math.floor(Math.random() * 4) + 1}-R${String(Math.floor(Math.random() * 20) + 1).padStart(2, '0')}`, // e.g., B1-L1-R01
            department: DUMMY_DEPARTMENTS[Math.floor(Math.random() * DUMMY_DEPARTMENTS.length)],
            workLocation: DUMMY_WORK_LOCATIONS[Math.floor(Math.random() * DUMMY_WORK_LOCATIONS.length)],
        });
    }
    
    // Initial display with pagination
    displayResidents();
}

function displayResidents() {
    const tableBody = document.getElementById('residentTableBody');
    const overlay = document.getElementById('residentOverlay');
    if (!tableBody || !overlay) return;

    const lowerCaseQuery = currentResidentQuery.toLowerCase();
    
    // Filter residents based on current query - expanded search fields
    const filteredResidents = allResidents.filter(resident => 
        resident.name.toLowerCase().includes(lowerCaseQuery) ||
        (resident.empNoOrIcPassport && resident.empNoOrIcPassport.toLowerCase().includes(lowerCaseQuery)) ||
        (resident.roomNo && resident.roomNo.toLowerCase().includes(lowerCaseQuery)) ||
        (resident.department && resident.department.toLowerCase().includes(lowerCaseQuery)) ||
        (resident.workLocation && resident.workLocation.toLowerCase().includes(lowerCaseQuery))
    );
    
    const totalFilteredResidents = filteredResidents.length;
    const totalPages = Math.ceil(totalFilteredResidents / residentsPerPage) || 1; // Ensure totalPages is at least 1
    
    // Clamp current page
    currentResidentPage = Math.max(1, Math.min(currentResidentPage, totalPages));
    
    const startIndex = (currentResidentPage - 1) * residentsPerPage;
    const endIndex = startIndex + residentsPerPage;
    const paginatedResidents = filteredResidents.slice(startIndex, endIndex);
    
    tableBody.innerHTML = ''; // Clear previous content or loading state
    
    if (paginatedResidents.length === 0 && totalFilteredResidents === 0) {
        tableBody.innerHTML = `<tr><td colspan="6" class="text-center py-4 text-gray-500">No residents found matching your criteria.</td></tr>`;
    } else if (paginatedResidents.length === 0 && totalFilteredResidents > 0) {
        // This case might happen if currentResidentPage is out of bounds after filtering, should be handled by clamping
        tableBody.innerHTML = `<tr><td colspan="6" class="text-center py-4 text-gray-500">No residents on this page. Try another page or refine search.</td></tr>`;
    } else {
        paginatedResidents.forEach(resident => {
            const row = `
                <tr class="transition-colors duration-150 hover:bg-gray-50">
                    <td class="py-3 px-4 border-b border-gray-200 text-sm">
                        <span class="text-current">${resident.name}</span>
                    </td>
                    <td class="py-3 px-4 border-b border-gray-200 text-sm">
                        <span class="text-current">${resident.empNoOrIcPassport}</span>
                    </td>
                    <td class="py-3 px-4 border-b border-gray-200 text-sm">
                        <span class="text-current">${resident.roomNo}</span>
                    </td>
                    <td class="py-3 px-4 border-b border-gray-200 text-sm">
                        <span class="text-current">${resident.department}</span>
                    </td>
                    <td class="py-3 px-4 border-b border-gray-200 text-sm">
                        <span class="text-current">${resident.workLocation}</span>
                    </td>
                    <td class="py-3 px-4 border-b border-gray-200 text-sm">
                        <button class="text-purple-600 hover:text-purple-500 p-1 rounded hover:bg-purple-100 transition-all duration-150 mr-1" title="Edit Resident">
                            <i class="fas fa-edit fa-fw"></i>
                        </button>
                        <button class="text-blue-600 hover:text-blue-500 p-1 rounded hover:bg-blue-100 transition-all duration-150 mr-1" title="View Details">
                            <i class="fas fa-eye fa-fw"></i>
                        </button>
                        <button class="text-red-600 hover:text-red-500 p-1 rounded hover:bg-red-100 transition-all duration-150" title="Delete Resident">
                            <i class="fas fa-trash-alt fa-fw"></i>
                        </button>
                    </td>
                </tr>
            `;
            tableBody.innerHTML += row;
        });
    }
    
    // Update pagination controls
    updateResidentPagination(totalFilteredResidents, totalPages);
}

function updateResidentPagination(totalFiltered, totalPages) {
    const startRecordEl = document.getElementById('residentStartRecord');
    const endRecordEl = document.getElementById('residentEndRecord');
    const totalRecordsEl = document.getElementById('residentTotalRecords');
    const prevButton = document.getElementById('residentPrevPage');
    const nextButton = document.getElementById('residentNextPage');
    const paginationContainer = document.querySelector('#residentPaginationButtons'); // Corrected selector
    
    if (!startRecordEl || !endRecordEl || !totalRecordsEl || !prevButton || !nextButton || !paginationContainer) {
        console.warn("Pagination elements not found for resident overlay.");
        return;
    }
    
    totalRecordsEl.textContent = totalFiltered;
    
    // Regenerate pagination buttons based on total pages
    const existingPageButtons = paginationContainer.querySelectorAll('.resident-page-btn');
    existingPageButtons.forEach(btn => btn.remove());
    
    // Determine which page buttons to show
    // We'll show up to 5 buttons, centered around the current page when possible
    const maxButtons = 5;
    let startPage = Math.max(1, currentResidentPage - Math.floor(maxButtons / 2));
    let endPage = Math.min(totalPages, startPage + maxButtons - 1);
    
    // Adjust if we're near the end
    if (endPage - startPage + 1 < maxButtons && startPage > 1) {
        startPage = Math.max(1, endPage - maxButtons + 1);
    }
    
    // Check if dark mode is active
    const isDarkMode = document.documentElement.classList.contains('dark-mode');
    
    // Generate and insert page number buttons
    for (let i = startPage; i <= endPage; i++) {
        const isActive = i === currentResidentPage;
        const pageButton = document.createElement('button');
        
        // Apply appropriate styling based on active state and dark mode
        if (isActive) {
            pageButton.className = `resident-pagination-btn resident-page-btn w-8 h-8 flex items-center justify-center rounded-md border active bg-purple-600 text-white border-purple-600`;
        } else {
            if (isDarkMode) {
                pageButton.className = `resident-pagination-btn resident-page-btn w-8 h-8 flex items-center justify-center rounded-md border bg-gray-700 text-gray-300 hover:bg-gray-600 border-gray-600`;
            } else {
                pageButton.className = `resident-pagination-btn resident-page-btn w-8 h-8 flex items-center justify-center rounded-md border bg-white text-gray-500 hover:bg-gray-50 border-gray-300`;
            }
        }
        
        pageButton.textContent = i;
        pageButton.onclick = function() { goToResidentPage(i); };
        
        // Insert before the next button
        paginationContainer.insertBefore(pageButton, nextButton);
    }
    
    // Update prev/next button states
    if (totalFiltered === 0) {
        startRecordEl.textContent = '0';
        endRecordEl.textContent = '0';
        prevButton.disabled = true;
        nextButton.disabled = true;
    } else {
        const start = Math.min((currentResidentPage - 1) * residentsPerPage + 1, totalFiltered);
        const end = Math.min(start + residentsPerPage - 1, totalFiltered);
        startRecordEl.textContent = start;
        endRecordEl.textContent = end;
        prevButton.disabled = currentResidentPage === 1;
        nextButton.disabled = currentResidentPage === totalPages || totalPages === 0;
    }
    
    // Update disabled appearance
    if (prevButton.disabled) {
        prevButton.classList.add('opacity-50');
    } else {
        prevButton.classList.remove('opacity-50');
    }
    
    if (nextButton.disabled) {
        nextButton.classList.add('opacity-50');
    } else {
        nextButton.classList.remove('opacity-50');
    }
    
    // Update prev/next button styles for dark mode
    if (isDarkMode) {
        prevButton.classList.add('dark-pagination-button');
        nextButton.classList.add('dark-pagination-button');
        if (!prevButton.classList.contains('bg-gray-700')) {
            prevButton.classList.remove('bg-white');
            prevButton.classList.add('bg-gray-700');
            prevButton.classList.remove('text-gray-500');
            prevButton.classList.add('text-gray-300');
            prevButton.classList.remove('hover:bg-gray-50');
            prevButton.classList.add('hover:bg-gray-600');
            prevButton.classList.remove('border-gray-300');
            prevButton.classList.add('border-gray-600');
        }
        if (!nextButton.classList.contains('bg-gray-700')) {
            nextButton.classList.remove('bg-white');
            nextButton.classList.add('bg-gray-700');
            nextButton.classList.remove('text-gray-500');
            nextButton.classList.add('text-gray-300');
            nextButton.classList.remove('hover:bg-gray-50');
            nextButton.classList.add('hover:bg-gray-600');
            nextButton.classList.remove('border-gray-300');
            nextButton.classList.add('border-gray-600');
        }
    } else {
        prevButton.classList.remove('dark-pagination-button');
        nextButton.classList.remove('dark-pagination-button');
        if (prevButton.classList.contains('bg-gray-700')) {
            prevButton.classList.add('bg-white');
            prevButton.classList.remove('bg-gray-700');
            prevButton.classList.add('text-gray-500');
            prevButton.classList.remove('text-gray-300');
            prevButton.classList.add('hover:bg-gray-50');
            prevButton.classList.remove('hover:bg-gray-600');
            prevButton.classList.add('border-gray-300');
            prevButton.classList.remove('border-gray-600');
        }
        if (nextButton.classList.contains('bg-gray-700')) {
            nextButton.classList.add('bg-white');
            nextButton.classList.remove('bg-gray-700');
            nextButton.classList.add('text-gray-500');
            nextButton.classList.remove('text-gray-300');
            nextButton.classList.add('hover:bg-gray-50');
            nextButton.classList.remove('hover:bg-gray-600');
            nextButton.classList.add('border-gray-300');
            nextButton.classList.remove('border-gray-600');
        }
    }
}

function changeResidentPage(direction) {
    const newPage = currentResidentPage + direction;
    // Fetch total pages on the fly in case it changed due to filtering or other actions
    const totalFilteredResidents = allResidents.filter(resident => 
        resident.name.toLowerCase().includes(currentResidentQuery) ||
        (resident.empNoOrIcPassport && resident.empNoOrIcPassport.toLowerCase().includes(currentResidentQuery)) ||
        (resident.roomNo && resident.roomNo.toLowerCase().includes(currentResidentQuery)) ||
        (resident.department && resident.department.toLowerCase().includes(currentResidentQuery)) ||
        (resident.workLocation && resident.workLocation.toLowerCase().includes(currentResidentQuery))
    ).length;
    const totalPages = Math.ceil(totalFilteredResidents / residentsPerPage) || 1;

    if (newPage >= 1 && newPage <= totalPages) {
        currentResidentPage = newPage;
        displayResidents();
    }
}

function goToResidentPage(pageNum) {
    // Fetch total pages on the fly
    const totalFilteredResidents = allResidents.filter(resident => 
        resident.name.toLowerCase().includes(currentResidentQuery) ||
        (resident.empNoOrIcPassport && resident.empNoOrIcPassport.toLowerCase().includes(currentResidentQuery)) ||
        (resident.roomNo && resident.roomNo.toLowerCase().includes(currentResidentQuery)) ||
        (resident.department && resident.department.toLowerCase().includes(currentResidentQuery)) ||
        (resident.workLocation && resident.workLocation.toLowerCase().includes(currentResidentQuery))
    ).length;
    const totalPages = Math.ceil(totalFilteredResidents / residentsPerPage) || 1;

    if (pageNum >= 1 && pageNum <= totalPages) {
        currentResidentPage = pageNum;
        displayResidents();
    }
}

let searchDebounceTimer;
function handleResidentSearch(event) {
    clearTimeout(searchDebounceTimer);
    const searchInput = event.target;
    const loader = searchInput.parentElement.querySelector('#residentSearchLoader'); // Assuming loader is sibling or child

    if(loader) loader.classList.remove('hidden');

    searchDebounceTimer = setTimeout(() => {
        currentResidentQuery = searchInput.value.trim().toLowerCase();
        currentResidentPage = 1; // Reset to first page on new search
        displayResidents();
        if(loader) loader.classList.add('hidden');
    }, 400); // Debounce search input slightly longer
}

function closeResidentOverlay() {
    const overlay = document.getElementById('residentOverlay');
    
    // Use the ModalNavigation utility if available
    if (window.ModalNavigation) {
        window.ModalNavigation.close(overlay);
    } else {
        overlay.classList.remove('active'); // Start the transition out
        // Remove 'flex' and add 'hidden' after transition completes
        setTimeout(() => {
            overlay.classList.remove('flex');
            overlay.classList.add('hidden');
        }, 300); // Match the transition duration in CSS (assuming .3s)
    }
}

function changeResidentsPerPage(perPageValue) {
    const newPerPage = parseInt(perPageValue);
    if (!isNaN(newPerPage) && newPerPage > 0) {
        residentsPerPage = newPerPage;
        currentResidentPage = 1; // Reset to first page
        displayResidents();
    }
}

// Make functions globally accessible
window.openResidentOverlay = openResidentOverlay;
window.closeResidentOverlay = closeResidentOverlay;
window.goToResidentPage = goToResidentPage;
window.changeResidentsPerPage = changeResidentsPerPage;
window.displayResidents = displayResidents; // Expose for dark mode toggle

// Initialize event handlers for resident overlay
document.addEventListener('DOMContentLoaded', function() {
    initializeResidentOverlay();
});

function initializeResidentOverlay() {
    const overlay = document.getElementById('residentOverlay');
    if (!overlay) return;
    
    // Using event delegation for better performance and reliability
    overlay.addEventListener('click', function(event) {
        // If clicking the overlay background (not its children like the modal content)
        if (event.target === overlay) {
            closeResidentOverlay();
        }
    });
    
    const modalContent = overlay.querySelector('.bg-white'); // Target the actual modal box
    if (modalContent) {
        modalContent.addEventListener('click', function(event) {
            event.stopPropagation(); // Prevent clicks inside the modal from closing it
        });
    }
    
    // Setup pagination prev/next buttons
    const prevButton = document.getElementById('residentPrevPage');
    const nextButton = document.getElementById('residentNextPage');
    if (prevButton && !prevButton.dataset.listenerAttached) {
        prevButton.addEventListener('click', () => changeResidentPage(-1));
        prevButton.dataset.listenerAttached = 'true';
    }
    if (nextButton && !nextButton.dataset.listenerAttached) {
        nextButton.addEventListener('click', () => changeResidentPage(1));
        nextButton.dataset.listenerAttached = 'true';
    }
    
    // Setup search input listener (already done in openResidentOverlay, but good to have robust init)
    const searchInput = document.getElementById('residentSearchInput');
    if (searchInput && !searchInput.dataset.listenerAttached) {
        searchInput.addEventListener('input', handleResidentSearch);
        searchInput.dataset.listenerAttached = 'true';
    }
    
    // Setup per page selector
    const perPageSelect = document.getElementById('residentsPerPageSelect');
    if (perPageSelect && !perPageSelect.dataset.listenerAttached) {
        perPageSelect.addEventListener('change', function() {
            changeResidentsPerPage(this.value); // 'this.value' is already a string
        });
        perPageSelect.dataset.listenerAttached = 'true';
    }
} 