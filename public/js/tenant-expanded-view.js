let expandedCard = null;
let expandedCardContainer = null; // Initialize as null

document.addEventListener('DOMContentLoaded', () => {
    // Find the container *after* the DOM is loaded
    expandedCardContainer = document.getElementById('expandedCardContainer');
    
    if (!expandedCardContainer) {
        console.error('Expanded card container element not found after DOM load!');
        return; // Stop if critical element is missing
    }

    // Setup functions that rely on DOM elements being present
    setupTenantCards();
    setupAddTenantButton();
});

function setupTenantCards() { // Uses Event Delegation
    const tenantCardsContainer = document.getElementById('tenantCardsContainer');
    if (!tenantCardsContainer) {
        console.error('Tenant cards container not found!');
        return;
    }
    // console.log('Setting up tenant card click listener...');
    tenantCardsContainer.addEventListener('click', function(event) {
        const card = event.target.closest('.tenant-card');
        if (!card) return; 
        
        // console.log('Tenant card wrapper clicked.');

        // Check if a button inside the card was clicked first
        if (event.target.closest('.view-residents-btn')) {
            // console.log('View Residents button clicked, stopping propagation.');
            event.stopPropagation(); 
            openResidentOverlay(event.target.closest('.view-residents-btn'));
            return;
        }
        if (event.target.closest('button[onclick^="editTenant"]')) { // Check for edit button
            // console.log('Edit Tenant button clicked, stopping.');
             const tenantId = card.dataset.tenantId;
             editTenant(tenantId);
             return;
         }
         if (event.target.closest('button[onclick^="deleteTenant"]')) { // Check for delete button
             // console.log('Delete Tenant button clicked, stopping.');
             const tenantId = card.dataset.tenantId;
             deleteTenant(tenantId);
             return;
         }

        // If no button was clicked, proceed to show expanded view
        // console.log('Card clicked (not a button), calling showExpandedView.');
        showExpandedView(card);
    });
    // console.log('Tenant card click listener attached.');
}

function setupAddTenantButton() {
    // console.log("Setting up Add Tenant button listener..."); 
    const addTenantBtn = document.getElementById('addTenantButton');
    if (addTenantBtn) {
        addTenantBtn.addEventListener('click', () => {
            // console.log("Add Tenant button clicked!"); 
            openTenantModal('add');
        });
        // console.log("Event listener attached to Add Tenant button.");
    } else {
        console.error('Add New Tenant button not found!');
    }
}

function showExpandedView(card) {
    // console.log('showExpandedView called for card:', card);
    // If there's already an expanded card, close it first
    if (expandedCard) {
        // console.log('Closing previously expanded card.');
        collapseExpandedView(true); // Pass true to indicate we're switching cards
    }
    
    expandedCard = card;
    // console.log('Expanded card set.');
    
    // Get card data
    const tenantName = card.querySelector('h2').textContent;
    const tenantCode = card.getAttribute('data-tenant');
    const staffCount = card.getAttribute('data-staff-count');
    const roomCount = card.getAttribute('data-rooms');
    
    const status = card.getAttribute('data-status');
    
    // Find contact person
    const contactPersonElement = card.querySelector('.flex:has(.fa-user-tie)');
    const contactPerson = contactPersonElement ? contactPersonElement.querySelector('span').textContent : 'Unknown';
    
    // Get logo color from card
    const logoDiv = card.querySelector('.company-logo');
    const logoBgClass = Array.from(logoDiv.classList).find(cls => cls.startsWith('bg-'));
    const logoTextClass = Array.from(logoDiv.querySelector('span').classList).find(cls => cls.startsWith('text-'));
    
    // Highlight the selected card with color matching its status
    const highlightColor = status === 'active' ? 'ring-green-500' : 'ring-yellow-500';
    card.classList.add('ring-2', highlightColor);
    
    // Create expanded view content
    let contractDuration = "12 months";
    let contractStart = "January 1, 2023";
    let contractEnd = "December 31, 2023";
    
    // If status is pending-renewal, make contract end sooner
    if (status === 'pending-renewal') {
        contractEnd = "March 31, 2023";
    }
    
    // Create detailed content
    expandedCardContainer.innerHTML = `
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center">
                <div class="w-14 h-14 ${logoBgClass} rounded-full flex items-center justify-center mr-4 shadow-sm">
                    <span class="${logoTextClass} font-bold text-xl">${tenantCode}</span>
                </div>
                <div>
                    <h2 class="font-bold text-2xl text-gray-800 dark-mode:text-gray-100">${tenantName}</h2>
                    <p class="text-sm text-gray-600 dark-mode:text-gray-400 font-medium"><i class="fas fa-building mr-2"></i>Corporate Tenant</p>
                </div>
            </div>
            <button onclick="collapseExpandedView()" class="text-gray-500 hover:text-gray-700 dark-mode:text-gray-300 dark-mode:hover:text-gray-100 text-xl">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="expanded-content">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white dark-mode:bg-[#1F2937] rounded-lg shadow-sm border border-gray-200 dark-mode:border-gray-700 overflow-hidden">
                    <div class="bg-gray-100 dark-mode:bg-gray-700 px-4 py-3 border-b border-gray-200 dark-mode:border-gray-600">
                        <h3 class="text-md font-semibold text-gray-700 dark-mode:text-gray-300"><i class="fas fa-info-circle mr-2"></i>Basic Information</h3>
                    </div>
                    <div class="p-4">
                        <div class="flex items-center mb-3 pb-3 border-b border-gray-100 dark-mode:border-gray-700">
                            <div class="text-gray-500 dark-mode:text-gray-400 w-10 flex-shrink-0"><i class="fas fa-user-tie"></i></div>
                            <div>
                                <p class="text-xs text-gray-500 dark-mode:text-gray-400">Contact Person</p>
                                <p class="font-medium text-gray-800 dark-mode:text-gray-200">${contactPerson}</p>
                            </div>
                        </div>
                        <div class="flex items-center mb-3 pb-3 border-b border-gray-100 dark-mode:border-gray-700">
                            <div class="text-gray-500 dark-mode:text-gray-400 w-10 flex-shrink-0"><i class="fas fa-users"></i></div>
                            <div>
                                <p class="text-xs text-gray-500 dark-mode:text-gray-400">Number of Staff</p>
                                <p class="font-medium text-gray-800 dark-mode:text-gray-200">${staffCount}</p>
                            </div>
                        </div>
                        <div class="flex items-center mb-3 pb-3 border-b border-gray-100 dark-mode:border-gray-700">
                            <div class="text-gray-500 dark-mode:text-gray-400 w-10 flex-shrink-0"><i class="fas fa-door-open"></i></div>
                            <div>
                                <p class="text-xs text-gray-500 dark-mode:text-gray-400">Rented Rooms</p>
                                <p class="font-medium text-gray-800 dark-mode:text-gray-200">${roomCount}</p>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <div class="text-gray-500 dark-mode:text-gray-400 w-10 flex-shrink-0"><i class="fas fa-check-circle"></i></div>
                            <div>
                                <p class="text-xs text-gray-500 dark-mode:text-gray-400">Status</p>
                                <p class="font-medium ${status === 'active' ? 'text-green-600 dark-mode:text-green-400' : 'text-yellow-600 dark-mode:text-yellow-400'}">
                                    ${status === 'active' ? 'Active' : 'Pending Renewal'}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white dark-mode:bg-[#1F2937] rounded-lg shadow-sm border border-gray-200 dark-mode:border-gray-700 overflow-hidden">
                    <div class="bg-gray-100 dark-mode:bg-gray-700 px-4 py-3 border-b border-gray-200 dark-mode:border-gray-600">
                        <h3 class="text-md font-semibold text-gray-700 dark-mode:text-gray-300"><i class="fas fa-address-card mr-2"></i>Contact Information</h3>
                    </div>
                    <div class="p-4">
                        <div class="flex items-center mb-3 pb-3 border-b border-gray-100 dark-mode:border-gray-700">
                            <div class="text-gray-500 dark-mode:text-gray-400 w-10 flex-shrink-0"><i class="fas fa-building"></i></div>
                            <div>
                                <p class="text-xs text-gray-500 dark-mode:text-gray-400">Full Company Name</p>
                                <p class="font-medium text-gray-800 dark-mode:text-gray-200">${tenantName} Ltd.</p>
                            </div>
                        </div>
                        <div class="flex items-center mb-3 pb-3 border-b border-gray-100 dark-mode:border-gray-700">
                            <div class="text-gray-500 dark-mode:text-gray-400 w-10 flex-shrink-0"><i class="fas fa-map-marker-alt"></i></div>
                            <div>
                                <p class="text-xs text-gray-500 dark-mode:text-gray-400">Address</p>
                                <p class="font-medium text-gray-800 dark-mode:text-gray-200">123 Business Ave., Suite ${Math.floor(Math.random() * 100) + 100}</p>
                            </div>
                        </div>
                        <div class="flex items-center mb-3 pb-3 border-b border-gray-100 dark-mode:border-gray-700">
                            <div class="text-gray-500 dark-mode:text-gray-400 w-10 flex-shrink-0"><i class="fas fa-phone"></i></div>
                            <div>
                                <p class="text-xs text-gray-500 dark-mode:text-gray-400">Phone</p>
                                <p class="font-medium text-gray-800 dark-mode:text-gray-200">+971 ${Math.floor(Math.random() * 900) + 100} ${Math.floor(Math.random() * 9000) + 1000}</p>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <div class="text-gray-500 dark-mode:text-gray-400 w-10 flex-shrink-0"><i class="fas fa-envelope"></i></div>
                            <div>
                                <p class="text-xs text-gray-500 dark-mode:text-gray-400">Email</p>
                                <p class="font-medium text-gray-800 dark-mode:text-gray-200">info@${tenantCode.toLowerCase()}.com</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white dark-mode:bg-[#1F2937] rounded-lg shadow-sm border border-gray-200 dark-mode:border-gray-700 overflow-hidden">
                    <div class="bg-gray-100 dark-mode:bg-gray-700 px-4 py-3 border-b border-gray-200 dark-mode:border-gray-600">
                        <h3 class="text-md font-semibold text-gray-700 dark-mode:text-gray-300"><i class="fas fa-file-contract mr-2"></i>Contract Details</h3>
                    </div>
                    <div class="p-4">
                        <div class="flex items-center mb-3 pb-3 border-b border-gray-100 dark-mode:border-gray-700">
                            <div class="text-gray-500 dark-mode:text-gray-400 w-10 flex-shrink-0"><i class="fas fa-calendar-alt"></i></div>
                            <div>
                                <p class="text-xs text-gray-500 dark-mode:text-gray-400">Duration</p>
                                <p class="font-medium text-gray-800 dark-mode:text-gray-200">${contractDuration}</p>
                            </div>
                        </div>
                        <div class="flex items-center mb-3 pb-3 border-b border-gray-100 dark-mode:border-gray-700">
                            <div class="text-gray-500 dark-mode:text-gray-400 w-10 flex-shrink-0"><i class="fas fa-play-circle"></i></div>
                            <div>
                                <p class="text-xs text-gray-500 dark-mode:text-gray-400">Start Date</p>
                                <p class="font-medium text-gray-800 dark-mode:text-gray-200">${contractStart}</p>
                            </div>
                        </div>
                        <div class="flex items-center mb-3 pb-3 border-b border-gray-100 dark-mode:border-gray-700">
                            <div class="text-gray-500 dark-mode:text-gray-400 w-10 flex-shrink-0"><i class="fas fa-stop-circle"></i></div>
                            <div>
                                <p class="text-xs text-gray-500 dark-mode:text-gray-400">End Date</p>
                                <p class="font-medium ${status === 'pending-renewal' ? 'text-yellow-600 dark-mode:text-yellow-400' : 'text-gray-800 dark-mode:text-gray-200'}">${contractEnd}</p>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <div class="text-gray-500 dark-mode:text-gray-400 w-10 flex-shrink-0"><i class="fas fa-money-bill-wave"></i></div>
                            <div>
                                <p class="text-xs text-gray-500 dark-mode:text-gray-400">Payment Terms</p>
                                <p class="font-medium text-gray-800 dark-mode:text-gray-200">Monthly, due on the 5th</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-white dark-mode:bg-[#1F2937] rounded-lg shadow-sm border border-gray-200 dark-mode:border-gray-700 overflow-hidden mb-6">
                <div class="bg-gray-100 dark-mode:bg-gray-700 px-4 py-3 border-b border-gray-200 dark-mode:border-gray-600">
                    <h3 class="text-md font-semibold text-gray-700 dark-mode:text-gray-300"><i class="fas fa-sticky-note mr-2"></i>Additional Information</h3>
                </div>
                <div class="p-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500 dark-mode:text-gray-400 mb-1">Special Requirements:</p>
                            <p class="text-gray-800 dark-mode:text-gray-200">24/7 access, dedicated parking spaces</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark-mode:text-gray-400 mb-1">Security Deposit:</p>
                            <p class="text-gray-800 dark-mode:text-gray-200">$${(Math.floor(Math.random() * 5000) + 2000).toLocaleString()}</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <p class="text-sm text-gray-500 dark-mode:text-gray-400 mb-1">Notes:</p>
                        <p class="text-gray-800 dark-mode:text-gray-200">Tenant has been with us since 2020. Very reliable with payments.</p>
                    </div>
                </div>
            </div>
            
            <div class="flex flex-wrap gap-2 justify-end">
                <button class="px-4 py-2.5 bg-white dark-mode:bg-gray-700 text-gray-700 dark-mode:text-gray-200 rounded-lg border border-gray-300 dark-mode:border-gray-600 hover:bg-gray-50 dark-mode:hover:bg-gray-600 transition-colors shadow-sm flex items-center">
                    <i class="fas fa-users text-orange-500 dark-mode:text-orange-400 mr-2"></i> View Residents
                </button>
                <button class="px-4 py-2.5 bg-white dark-mode:bg-gray-700 text-gray-700 dark-mode:text-gray-200 rounded-lg border border-gray-300 dark-mode:border-gray-600 hover:bg-gray-50 dark-mode:hover:bg-gray-600 transition-colors shadow-sm flex items-center">
                    <i class="fas fa-file-alt text-orange-500 dark-mode:text-orange-400 mr-2"></i> View Contract
                </button>
                <button class="px-4 py-2.5 bg-white dark-mode:bg-gray-700 text-gray-700 dark-mode:text-gray-200 rounded-lg border border-gray-300 dark-mode:border-gray-600 hover:bg-gray-50 dark-mode:hover:bg-gray-600 transition-colors shadow-sm flex items-center">
                    <i class="fas fa-edit text-gray-500 dark-mode:text-gray-400 mr-2"></i> Edit Details
                </button>
                <button class="px-4 py-2.5 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition-colors shadow-sm flex items-center">
                    <i class="fas fa-file-export mr-2"></i> Export Data
                </button>
                <button class="px-4 py-2.5 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors shadow-sm flex items-center">
                    <i class="fas fa-print mr-2"></i> Print Details
                </button>
            </div>
        </div>
    `;
    
    // Make the container visible and add active class
    // console.log('Adding .active class to expandedCardContainer:', expandedCardContainer);
    if (!expandedCardContainer) {
        console.error('expandedCardContainer element is null! Cannot show expanded view.');
        return; // Stop if container doesn't exist
    }
    expandedCardContainer.classList.add('active');
    // console.log('Finished adding .active class.');
    
    // Add class to trigger content animation after a slight delay
    // to ensure the container is rendered first
    // console.log('Setting timeout to add .show-content class.');
    setTimeout(() => {
        // console.log('Timeout triggered. Finding .expanded-content...');
        const content = expandedCardContainer.querySelector('.expanded-content');
        if (content) {
            // console.log('Adding .show-content class to:', content);
            content.classList.add('show-content');
        } else {
            // console.error('.expanded-content not found inside expandedCardContainer!');
        }
    }, 50); // Small delay for smooth transition
    
    // Scroll the expanded card container's title into view after a short delay
    // to allow the container to become visible and start expanding
    // console.log('Setting timeout for scrolling to title.');
    setTimeout(() => {
        const titleElement = expandedCardContainer.querySelector('h2');
        if (titleElement) {
            // console.log('Scrolling to title element:', titleElement);
            titleElement.scrollIntoView({ behavior: 'smooth', block: 'start' });
        } else {
            // Fallback: scroll the container itself if title isn't found immediately
            // console.log('Title not found, scrolling container instead.');
            expandedCardContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }, 100); // Delay slightly to ensure element is available and animation started
    
    // console.log('showExpandedView finished.');
}

function collapseExpandedView(isSwitchingCards = false) {
    // console.log('collapseExpandedView called. isSwitchingCards:', isSwitchingCards);
    if (!expandedCard) {
        // console.log('No expanded card to collapse.');
        return;
    }
    
    // Store reference to the card being closed for scrolling later
    const cardToScrollTo = expandedCard;
    
    // Remove the highlight from the card
    expandedCard.classList.remove('ring-2', 'ring-green-500', 'ring-yellow-500');

    // Remove the active class to hide the container with animation
    if (!expandedCardContainer) {
        console.error('expandedCardContainer element is null! Cannot collapse view properly.');
    } else {
        expandedCardContainer.classList.remove('active');
    }
    
    // Remove the content show class
    const content = expandedCardContainer ? expandedCardContainer.querySelector('.expanded-content') : null;
    if (content) {
        content.classList.remove('show-content');
    }
    
    // Clear the reference *after* starting animations and storing the card
    expandedCard = null;
    
    // After the collapse animation finishes, scroll the original card back into view
    // Use a timeout matching the CSS transition duration (0.45s)
    if (!isSwitchingCards) { // Only scroll back if not immediately opening another card
        setTimeout(() => {
            if (cardToScrollTo) {
                // console.log('Scrolling back to card:', cardToScrollTo);
                cardToScrollTo.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }
        }, 450); // Match CSS transition duration
    }
    
    // console.log('collapseExpandedView finished.');
}

// Make the collapseExpandedView function available globally for the onclick handler
window.collapseExpandedView = collapseExpandedView; 