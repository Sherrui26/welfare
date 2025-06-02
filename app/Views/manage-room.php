<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="<?= base_url('css/manage-room.css') ?>">
<link rel="stylesheet" href="<?= base_url('css/scrollbar.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>

 <!-- Room Details Modal -->
<div id="roomDetailsModal" class="fixed inset-0 bg-black bg-opacity-50 z-[100] hidden flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full mx-4 overflow-hidden max-h-[90vh]">
            <div class="border-b p-4 bg-gray-50">
                <div class="modal-header-with-back">
                    <h3 class="text-xl font-semibold" id="modalRoomNumber">Room Details</h3>
                    <button id="closeModal" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="p-6 max-h-[calc(90vh-4rem)] overflow-y-auto">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Room Image -->
                    <div class="md:col-span-1">
                        <div class="bg-gray-200 rounded-lg h-48 flex items-center justify-center overflow-hidden">
                            <img id="roomImage" src="https://placehold.co/600x400?text=Room+Image" alt="Room Image" class="object-cover w-full h-full" />
                        </div>
                        <div class="mt-4">
                            <span id="modalRoomStatus" class="status status-available inline-block mb-2">Available</span>
                            <p class="text-sm text-gray-500" id="roomLastUpdated">Last updated: Today, 10:45 AM</p>
                        </div>
                        
                        <!-- Action Buttons - Moved under status -->
                        <div class="mt-4 flex flex-col space-y-2">
                            <button class="w-full px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700">
                                <i class="fas fa-edit mr-2"></i>Edit Room
                            </button>
                            <button class="w-full px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100" id="assignTenantBtn">
                                <i class="fas fa-user-plus mr-2"></i>Assign Occupant
                            </button>
                            <button class="w-full px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-calendar-alt mr-2"></i>Schedule Maintenance
                            </button>
                        </div>
                    </div>
                    
                    <!-- Room Info -->
                    <div class="md:col-span-2">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <h4 class="font-medium text-gray-500 mb-1">Room Type</h4>
                                <p id="roomType">Standard Dormitory</p>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-500 mb-1">Floor</h4>
                                <p id="roomFloor">3rd Floor</p>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-500 mb-1">Capacity</h4>
                                <p id="roomCapacity">6 persons</p>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-500 mb-1">Monthly Rate</h4>
                                <p id="roomRate">$350 per bed</p>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-500 mb-1">Last Maintenance</h4>
                                <p id="roomMaintenance">Jan 15, 2025</p>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-500 mb-1">Cleaning Schedule</h4>
                                <p id="roomCleaning">Weekly (Thursday)</p>
                            </div>
                        </div>
                        
                        <!-- Amenities -->
                        <div class="mt-6">
                            <h4 class="font-medium text-gray-700 mb-2">Amenities</h4>
                            <div class="flex flex-wrap gap-2">
                                <span class="bg-[#e9d5ff] text-[#7c3aed] text-xs px-2 py-1 rounded-full">Air Conditioning</span>
                                <span class="bg-[#e9d5ff] text-[#7c3aed] text-xs px-2 py-1 rounded-full">WiFi</span>
                                <span class="bg-[#e9d5ff] text-[#7c3aed] text-xs px-2 py-1 rounded-full">Bunk Beds</span>
                                <span class="bg-[#e9d5ff] text-[#7c3aed] text-xs px-2 py-1 rounded-full">Lockers</span>
                                <span class="bg-[#e9d5ff] text-[#7c3aed] text-xs px-2 py-1 rounded-full">Shared Bathroom</span>
                                <span class="bg-[#e9d5ff] text-[#7c3aed] text-xs px-2 py-1 rounded-full">Common Area</span>
                            </div>
                        </div>
                        
                        <!-- Current Tenants -->
                        <div class="mt-6">
                            <h4 class="font-medium text-gray-700 mb-2">Current Occupants</h4>
                            <div id="modalTenantList" class="border rounded-lg overflow-hidden">
                                <!-- Will be populated by JavaScript -->
                                <div class="tenant-placeholder">
                                    <i class="fas fa-bed"></i>
                                    <p>Room information loading...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
<!-- Add New Room Modal -->
<div id="addRoomModal" class="fixed inset-0 bg-black bg-opacity-50 z-[100] hidden items-center justify-center" style="display: none;">
        <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full mx-4 overflow-hidden max-h-[90vh]">
            <div class="border-b p-4 bg-gray-50">
                <div class="modal-header-with-back">
                    <button id="backToDetailsModal" class="modal-back-button hidden">
                        <i class="fas fa-arrow-left"></i>
                        <span>Back</span>
                    </button>
                    <h3 class="text-xl font-semibold" id="addRoomModalTitle">Add New Room</h3>
                    <button id="closeAddRoomModal" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="p-6">
                <form id="addRoomForm">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Left Column - Room Image & Status -->
                        <div class="md:col-span-1">
                            <div class="bg-gray-200 rounded-lg h-48 flex items-center justify-center overflow-hidden">
                                <img id="roomImagePreview" src="https://placehold.co/600x400?text=Room+Image" alt="Room Preview" class="object-cover w-full h-full" />
                            </div>
                            <div class="mt-4">
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Initial Status</label>
                                <select id="status" name="status" class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
                                    <option value="available" selected>Available</option>
                                    <option value="maintenance">Under Maintenance</option>
                                    <option value="blocked">Blocked</option>
                                </select>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="mt-4 flex flex-col space-y-2">
                                <button type="submit" class="w-full px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700">
                                    <i class="fas fa-plus-circle mr-2"></i>Add New Room
                                </button>
                                <label for="roomImage" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 text-center cursor-pointer">
                                    <i class="fas fa-upload mr-2"></i>Upload Image
                                    <input id="roomImage" name="roomImage" type="file" class="hidden" accept="image/*">
                                </label>
                            </div>
                        </div>
                        
                        <!-- Right Column - Room Info -->
                        <div class="md:col-span-2">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="room_number" class="block text-sm font-medium text-gray-700 mb-1">Room Number</label>
                                    <input type="text" id="room_number" name="room_number" class="w-full px-3 py-2 border border-gray-300 rounded-md" placeholder="e.g. B1-01" required>
                                </div>
                                <div>
                                    <label for="floor" class="block text-sm font-medium text-gray-700 mb-1">Floor Number</label>
                                    <select id="floor" name="floor" class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
                                        <option value="" disabled selected>Select floor</option>
                                        <option value="B1">B1</option>
                                        <option value="B2">B2</option>
                                        <option value="B3">B3</option>
                                        <option value="B4">B4</option>
                                        <option value="B5">B5</option>
                                        <option value="B6">B6</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="capacity" class="block text-sm font-medium text-gray-700 mb-1">Total Bedspaces</label>
                                    <input type="number" id="capacity" name="capacity" class="w-full px-3 py-2 border border-gray-300 rounded-md" placeholder="e.g. 6" value="6" min="1" max="12" required>
                                </div>
                                <div>
                                    <label for="roomArea" class="block text-sm font-medium text-gray-700 mb-1">Room Area (m²)</label>
                                    <div class="flex items-center">
                                        <input type="number" id="roomArea" name="roomArea" class="w-full px-3 py-2 border border-gray-300 rounded-md" placeholder="e.g. 25">
                                        <div class="ml-2">
                                            <label class="inline-flex items-center">
                                                <input type="checkbox" name="noRoomArea" id="noRoomArea" class="form-checkbox">
                                                <span class="ml-2 text-xs text-gray-600">Unknown</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Room Type -->
                            <div class="mt-6">
                                <h4 class="font-medium text-gray-700 mb-2">Room Type</h4>
                                <div class="flex items-center space-x-4 mt-2">
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="room_type" value="standard" class="form-radio" checked>
                                        <span class="ml-2">Standard (6-bed)</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="room_type" value="premium" class="form-radio">
                                        <span class="ml-2">Premium (4-bed)</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="room_type" value="deluxe" class="form-radio">
                                        <span class="ml-2">Deluxe (2-bed)</span>
                                    </label>
                                </div>
                            </div>
                            
                            <!-- Maintenance Notes (conditional) -->
                            <div id="maintenanceFields" class="mt-6 hidden">
                                <h4 class="font-medium text-gray-700 mb-2">Maintenance Information</h4>
                                <div class="space-y-4">
                                    <div>
                                        <label for="maintenance_note" class="block text-sm font-medium text-gray-700 mb-1">Maintenance Notes</label>
                                        <textarea id="maintenance_note" name="maintenance_note" class="w-full px-3 py-2 border border-gray-300 rounded-md" rows="3" placeholder="Enter maintenance details"></textarea>
                                    </div>
                                    <div>
                                        <label for="next_maintenance_date" class="block text-sm font-medium text-gray-700 mb-1">Next Maintenance Date</label>
                                        <input type="date" id="next_maintenance_date" name="next_maintenance_date" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Block Reason (conditional) -->
                            <div id="blockFields" class="mt-6 hidden">
                                <h4 class="font-medium text-gray-700 mb-2">Block Information</h4>
                                <div>
                                    <label for="block_reason" class="block text-sm font-medium text-gray-700 mb-1">Reason for Blocking</label>
                                    <textarea id="block_reason" name="block_reason" class="w-full px-3 py-2 border border-gray-300 rounded-md" rows="3" placeholder="Enter reason for blocking the room"></textarea>
                                </div>
                            </div>
                            
                            <!-- Amenities Selection -->
                            <div class="mt-6">
                                <h4 class="font-medium text-gray-700 mb-2">Furniture & Amenities</h4>
                                <div class="flex flex-wrap gap-2 mb-3" id="amenitiesList">
                                    <label class="amenity-label cursor-pointer">
                                        <input type="checkbox" name="amenities[]" value="bed_wooden_single" class="hidden amenity-checkbox">
                                        <span class="bg-gray-200 hover:bg-[#e9d5ff] text-gray-700 hover:text-[#7c3aed] text-xs px-2 py-1 rounded-full inline-block">Bed - Wooden Single</span>
                                    </label>
                                    <label class="amenity-label cursor-pointer">
                                        <input type="checkbox" name="amenities[]" value="bed_wooden_queen" class="hidden amenity-checkbox">
                                        <span class="bg-gray-200 hover:bg-[#e9d5ff] text-gray-700 hover:text-[#7c3aed] text-xs px-2 py-1 rounded-full inline-block">Bed - Wooden Queen</span>
                                    </label>
                                    <label class="amenity-label cursor-pointer">
                                        <input type="checkbox" name="amenities[]" value="bed_metal_double_decker" class="hidden amenity-checkbox">
                                        <span class="bg-gray-200 hover:bg-[#e9d5ff] text-gray-700 hover:text-[#7c3aed] text-xs px-2 py-1 rounded-full inline-block">Bed - Metal Double Decker</span>
                                    </label>
                                    <label class="amenity-label cursor-pointer">
                                        <input type="checkbox" name="amenities[]" value="bed_metal_single" class="hidden amenity-checkbox">
                                        <span class="bg-gray-200 hover:bg-[#e9d5ff] text-gray-700 hover:text-[#7c3aed] text-xs px-2 py-1 rounded-full inline-block">Bed - Metal Single</span>
                                    </label>
                                    <label class="amenity-label cursor-pointer">
                                        <input type="checkbox" name="amenities[]" value="mattress_queen" class="hidden amenity-checkbox">
                                        <span class="bg-gray-200 hover:bg-[#e9d5ff] text-gray-700 hover:text-[#7c3aed] text-xs px-2 py-1 rounded-full inline-block">Mattress - Queen</span>
                                    </label>
                                    <label class="amenity-label cursor-pointer">
                                        <input type="checkbox" name="amenities[]" value="mattress_single" class="hidden amenity-checkbox">
                                        <span class="bg-gray-200 hover:bg-[#e9d5ff] text-gray-700 hover:text-[#7c3aed] text-xs px-2 py-1 rounded-full inline-block">Mattress - Single</span>
                                    </label>
                                    <label class="amenity-label cursor-pointer">
                                        <input type="checkbox" name="amenities[]" value="cupboard_lockers" class="hidden amenity-checkbox">
                                        <span class="bg-gray-200 hover:bg-[#e9d5ff] text-gray-700 hover:text-[#7c3aed] text-xs px-2 py-1 rounded-full inline-block">Cupboard/Lockers</span>
                                    </label>
                                    <label class="amenity-label cursor-pointer">
                                        <input type="checkbox" name="amenities[]" value="curtain" class="hidden amenity-checkbox">
                                        <span class="bg-gray-200 hover:bg-[#e9d5ff] text-gray-700 hover:text-[#7c3aed] text-xs px-2 py-1 rounded-full inline-block">Curtain</span>
                                    </label>
                                </div>
                                
                                <div class="flex items-center gap-2">
                                    <input type="text" id="customAmenity" class="px-3 py-2 border border-gray-300 rounded-md text-sm" placeholder="Add custom amenity...">
                                    <button type="button" id="addCustomAmenity" class="px-3 py-2 bg-orange-600 text-white rounded-md hover:bg-orange-700 text-sm">
                                        <i class="fas fa-plus"></i> Add
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Additional Notes -->
                            <div class="mt-6">
                                <label for="roomNotes" class="block text-sm font-medium text-gray-700 mb-1">Additional Notes</label>
                                <textarea id="roomNotes" name="roomNotes" class="w-full px-3 py-2 border border-gray-300 rounded-md h-20" placeholder="Add any special notes about this room..."></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
</div>
<!-- Assign Occupant Modal -->
<div id="assignOccupantModal" class="fixed inset-0 bg-black bg-opacity-50 z-[100] hidden flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full mx-4 overflow-hidden max-h-[90vh]">
            <div class="border-b p-4 bg-gray-50">
                <div class="modal-header-with-back">
                    <button id="backToRoomDetailsModal" class="modal-back-button">
                        <i class="fas fa-arrow-left"></i>
                        <span>Back</span>
                    </button>
                    <h3 class="text-xl font-semibold" id="assignOccupantModalTitle">Assign Occupant</h3>
                    <button id="closeAssignOccupantModal" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="p-6 max-h-[calc(90vh-4rem)] overflow-y-auto">
                <form id="assignOccupantForm">
                    <div class="mb-6">
                        <h4 class="font-medium text-gray-700 mb-4">Room Information</h4>
                        <div class="bg-gray-100 p-3 rounded-lg">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <span class="text-sm text-gray-500">Room Number:</span>
                                    <p id="assignRoomNumber" class="font-medium">7-03-05</p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500">Room Type:</span>
                                    <p id="assignRoomType" class="font-medium">Standard (6-bed)</p>
                                </div>
                                <div class="flex items-center">
                                    <div class="flex-grow">
                                        <span class="mr-2">Available Beds:</span> 
                                        <span id="assignAvailableBeds" class="font-medium">6/6</span>
                                    </div>
                                    <div class="flex-shrink-0 ml-2">
                                        <label for="bedNumber" class="text-xs text-gray-500 form-label">Bed:</label>
                                        <select id="bedNumber" name="bedNumber" class="ml-1 w-20 py-1 px-2 text-sm border border-gray-300 rounded-md" required>
                                            <option value="1">Bed 1</option>
                                            <option value="2">Bed 2</option>
                                            <option value="3">Bed 3</option>
                                            <option value="4">Bed 4</option>
                                            <option value="5">Bed 5</option>
                                            <option value="6">Bed 6</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-6">
                        <div class="flex justify-between items-center mb-4">
                            <h4 class="font-medium text-gray-700">Company Selection</h4>
                            <div class="flex gap-2">
                                <button type="button" class="px-3 py-1 text-sm border border-gray-300 rounded-lg hover:bg-gray-100" id="findCompany">
                                    <i class="fas fa-building mr-1"></i> Find Company
                                </button>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <input type="text" class="w-full p-2 border border-gray-300 rounded-lg dark:placeholder-gray-400" placeholder="Search company name..." id="companySearchInput">
                        </div>
                        
                        <div class="bg-gray-50 rounded-lg border border-gray-200 max-h-[300px] overflow-y-auto mb-4" id="companySearchResults">
                            <!-- Company search results will be displayed here -->
                            <div class="p-4 text-center text-gray-500">
                                <i class="fas fa-building mb-2 text-lg"></i>
                                <p>Search for companies above or click "Find Company"</p>
                            </div>
                        </div>
                        
                        <div class="bg-white rounded-lg border border-gray-300 p-4 mb-4" id="selectedCompanyCard" style="display: none;">
                            <div class="flex justify-between items-start">
                                <div class="flex items-start">
                                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                                        <span id="selectedCompanyInitials" class="text-purple-600 font-bold">SP</span>
                                    </div>
                                    <div>
                                        <h5 class="font-medium" id="selectedCompanyName">-</h5>
                                        <div class="text-sm text-gray-500 mt-1">
                                            Contact: <span id="selectedCompanyContact">-</span>
                                        </div>
                                        <div class="text-sm mt-1 flex items-center">
                                            <span class="mr-2">Available Rooms:</span> 
                                            <span id="selectedCompanyRooms" class="company-rooms-tag">-</span>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="text-red-500 hover:text-red-700" id="clearSelectedCompany">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-6">
                        <h4 class="font-medium text-gray-700 mb-4">Occupant Details</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="fullName" class="form-label block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                <input type="text" id="fullName" name="fullName" class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
                            </div>
                            <div>
                                <label for="nationality" class="form-label block text-sm font-medium text-gray-700 mb-1">Nationality</label>
                                <select id="nationality" name="nationality" class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
                                    <option value="" disabled selected>Select nationality</option>
                                    <option value="nepal">Nepal</option>
                                    <option value="bangladesh">Bangladesh</option>
                                    <option value="india">India</option>
                                    <option value="myanmar">Myanmar</option>
                                    <option value="indonesia">Indonesia</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            
                            <!-- Passport Section -->
                            <div>
                                <label for="passportIC" class="form-label block text-sm font-medium text-gray-700 mb-1">Passport/IC No.</label>
                                <input type="text" id="passportIC" name="passportIC" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                            </div>
                            <div>
                                <label for="passportExpiry" class="form-label block text-sm font-medium text-gray-700 mb-1">Passport Expiry Date</label>
                                <div class="flex items-center">
                                    <input type="date" id="passportExpiry" name="passportExpiry" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                                    <div class="ml-2">
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" name="pendingPassport" id="pendingPassport" class="form-checkbox">
                                            <span class="ml-2 text-xs text-gray-600">Pending</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Permit Section -->
                            <div>
                                <label for="permitNumber" class="form-label block text-sm font-medium text-gray-700 mb-1">Permit Number</label>
                                <input type="text" id="permitNumber" name="permitNumber" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                            </div>
                            <div>
                                <label for="permitExpiry" class="form-label block text-sm font-medium text-gray-700 mb-1">Permit Expiry Date</label>
                                <div class="flex items-center">
                                    <input type="date" id="permitExpiry" name="permitExpiry" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                                    <div class="ml-2">
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" name="pendingPermit" id="pendingPermit" class="form-checkbox">
                                            <span class="ml-2 text-xs text-gray-600">Pending</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Personal Details -->
                            <div>
                                <label for="dateOfBirth" class="form-label block text-sm font-medium text-gray-700 mb-1">Date of Birth</label>
                                <input type="date" id="dateOfBirth" name="dateOfBirth" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                            </div>
                            <div>
                                <label class="form-label block text-sm font-medium text-gray-700 mb-1">Gender</label>
                                <div class="flex items-center space-x-4 mt-2">
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="gender" value="male" class="form-radio" required>
                                        <span class="ml-2">Male</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="gender" value="female" class="form-radio">
                                        <span class="ml-2">Female</span>
                                    </label>
                                </div>
                            </div>
                            
                            <!-- Contact Information -->
                            <div>
                                <label for="phoneNo" class="form-label block text-sm font-medium text-gray-700 mb-1">Phone No.</label>
                                <div class="flex items-center">
                                    <input type="text" id="phoneNo" name="phoneNo" class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
                                    <div class="ml-2">
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" name="noPhoneNo" id="noPhoneNo" class="form-checkbox">
                                            <span class="ml-2 text-xs text-gray-600">None</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label for="emergencyContact" class="form-label block text-sm font-medium text-gray-700 mb-1">Emergency Contact No.</label>
                                <div class="flex items-center">
                                    <input type="text" id="emergencyContact" name="emergencyContact" class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
                                    <div class="ml-2">
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" name="noEmergencyContact" id="noEmergencyContact" class="form-checkbox">
                                            <span class="ml-2 text-xs text-gray-600">None</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <label for="remarks" class="form-label block text-sm font-medium text-gray-700 mb-1">Remarks</label>
                            <textarea id="remarks" name="remarks" class="w-full px-3 py-2 border border-gray-300 rounded-md h-20" placeholder="Add any special notes or requirements..."></textarea>
                        </div>

                        <div class="mt-4">
                            <label class="form-label block text-sm font-medium text-gray-700 mb-1">Upload Photo/ID</label>
                            <div class="flex items-center justify-center w-full">
                                <label for="photoUpload" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-all duration-200">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <i class="fas fa-cloud-upload-alt text-gray-400 text-2xl mb-2"></i>
                                        <p class="mb-2 text-sm text-gray-500"><span class="font-medium">Click to upload</span> or drag and drop</p>
                                        <p class="text-xs text-gray-500">PNG, JPG or PDF (MAX. 5MB)</p>
                                    </div>
                                    <input id="photoUpload" name="photoUpload" type="file" class="hidden" accept="image/*,.pdf" />
                                </label>
                            </div>
                            <div id="photoPreview" class="mt-2 hidden">
                                <div class="flex items-center justify-between p-2 bg-gray-50 rounded-lg border border-gray-200">
                                    <div class="flex items-center">
                                        <i class="fas fa-file-image text-blue-500 text-xl mr-2"></i>
                                        <span id="photoFileName" class="text-sm text-gray-700 truncate">filename.jpg</span>
                                    </div>
                                    <button type="button" id="removePhoto" class="text-red-500 hover:text-red-700">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex justify-end gap-3">
                        <button type="button" id="cancelAssignOccupant" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700">
                            <i class="fas fa-user-plus mr-2"></i>Assign Occupant
                        </button>
                    </div>
                </form>
            </div>
        </div>
</div>
<!-- Confirmation Modal -->
<div id="confirmAssignmentModal" class="fixed inset-0 bg-black bg-opacity-50 z-[110] hidden flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full mx-4 overflow-hidden max-h-[90vh]">
            <div class="border-b p-4 bg-gray-50">
                <div class="modal-header-with-back">
                    <h3 class="text-xl font-semibold">Confirm Assignment</h3>
                    <button id="closeConfirmModal" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="p-6 max-h-[calc(90vh-4rem)] overflow-y-auto">
                <div class="bg-purple-50 p-4 rounded-lg mb-6 border border-purple-200">
                    <div class="flex items-center text-purple-700">
                        <i class="fas fa-info-circle mr-2 text-lg"></i>
                        <p>Please review the details below before confirming this assignment.</p>
                    </div>
                </div>
                
                <!-- Room and Company Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <!-- Room Details -->
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <h4 class="font-medium text-gray-700 border-b border-gray-200 pb-2 mb-3">Room Information</h4>
                        <div class="space-y-2">
                            <div class="flex">
                                <span class="text-gray-500 w-1/3">Room:</span>
                                <span id="confirmRoomNumber" class="font-medium">7-03-05</span>
                            </div>
                            <div class="flex">
                                <span class="text-gray-500 w-1/3">Type:</span>
                                <span id="confirmRoomType" class="font-medium">Standard (6-bed)</span>
                            </div>
                            <div class="flex">
                                <span class="text-gray-500 w-1/3">Bed Number:</span>
                                <span id="confirmBedNumber" class="font-medium">Bed 3</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Company Details -->
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <h4 class="font-medium text-gray-700 border-b border-gray-200 pb-2 mb-3">Company Information</h4>
                        <div class="space-y-2">
                            <div class="flex items-start">
                                <span class="text-gray-500 w-1/3 flex-shrink-0">Company:</span>
                                <div class="flex-grow">
                                    <span id="confirmCompanyName" class="font-medium" title="">Sri Paandi</span>
                                </div>
                            </div>
                            <div class="flex">
                                <span class="text-gray-500 w-1/3">Contact:</span>
                                <span id="confirmCompanyContact" class="font-medium">+60 19-012-3456</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Occupant Details -->
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 mb-6">
                    <h4 class="font-medium text-gray-700 border-b border-gray-200 pb-2 mb-3">Occupant Details</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <div class="flex">
                                <span class="text-gray-500 w-1/3">Name:</span>
                                <span id="confirmFullName" class="font-medium">Ahmad Noor</span>
                            </div>
                            <div class="flex">
                                <span class="text-gray-500 w-1/3">Gender:</span>
                                <span id="confirmGender" class="font-medium">Male</span>
                            </div>
                            <div class="flex">
                                <span class="text-gray-500 w-1/3">Nationality:</span>
                                <span id="confirmNationality" class="font-medium">Bangladesh</span>
                            </div>
                            <div class="flex">
                                <span class="text-gray-500 w-1/3">Phone:</span>
                                <span id="confirmPhone" class="font-medium">+60 12-345-6789</span>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <div class="flex">
                                <span class="text-gray-500 w-1/3">Passport/IC:</span>
                                <span id="confirmPassportIC" class="font-medium">BA0987654</span>
                            </div>
                            <div class="flex">
                                <span class="text-gray-500 w-1/3">Passport Expiry:</span>
                                <span id="confirmPassportExpiry" class="font-medium">2025-06-15</span>
                            </div>
                            <div class="flex">
                                <span class="text-gray-500 w-1/3">Permit:</span>
                                <span id="confirmPermitNumber" class="font-medium">P12345678</span>
                            </div>
                            <div class="flex">
                                <span class="text-gray-500 w-1/3">Permit Expiry:</span>
                                <span id="confirmPermitExpiry" class="font-medium">2025-06-15</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Extra info if needed -->
                    <div class="mt-4 pt-3 border-t border-gray-200">
                        <div class="flex">
                            <span class="text-gray-500 w-1/6">Remarks:</span>
                            <span id="confirmRemarks" class="font-medium">New worker, first time in Malaysia.</span>
                        </div>
                    </div>
                </div>
                
                <!-- Check-in Information -->
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 mb-6">
                    <h4 class="font-medium text-gray-700 border-b border-gray-200 pb-2 mb-3">Check-in Information</h4>
                    <div class="space-y-2">
                        <div class="flex">
                            <span class="text-gray-500 w-1/3">Check-in Date:</span>
                            <span id="confirmCheckInDate" class="font-medium">2025-02-16 (Today)</span>
                        </div>
                        <div class="flex">
                            <span class="text-gray-500 w-1/3">ID Provided:</span>
                            <span id="confirmIDProvided" class="font-medium">
                                <i class="fas fa-check-circle text-green-500 mr-1"></i> Yes (passport.jpg)
                            </span>
                        </div>
                    </div>
                </div>
                
                <!-- Confirmation Buttons -->
                <div class="flex justify-between mt-6">
                    <div>
                        <button id="backToEditBtn" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-arrow-left mr-2"></i>Back to Edit
                        </button>
                    </div>
                    <div class="flex gap-3">
                        <button id="assignAnotherBtn" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                            <i class="fas fa-user-plus mr-2"></i>Confirm & Add Another
                        </button>
                        <button id="confirmAssignBtn" class="px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700">
                            <i class="fas fa-check-circle mr-2"></i>Confirm Assignment
                        </button>
                    </div>
                </div>
            </div>
        </div>
</div>
<!-- Main Content -->
<main class="container mx-auto px-4 py-4">
        <h1 class="text-2xl font-bold mb-4 text-gray-700 dark-mode-text tracking-wide">
            Manage Room
        </h1>

        <div class="max-w-7xl mx-auto bg-white p-6 rounded-lg shadow">
                        <!-- Header Buttons -->
                        <div class="flex justify-between items-center mb-4">
                            <div class="flex space-x-4">
                                <button
                                    class="filter-btn selected" data-filter="all">All
                                    Rooms (496)</button>
                                <button
                                    class="filter-btn" data-filter="available">Available
                                    (141)</button>
                                <button
                                    class="filter-btn" data-filter="occupied">Occupied
                                    (293)</button>
                                <button
                                    class="filter-btn" data-filter="maintenance">Under
                                    Maintenance (62)</button>
                            </div>
                            <div class="flex space-x-4">
                                <button id="collapseAllButton">
                                    <i class="fas fa-compress-alt"></i> Collapse All
                                </button>
                                <button
                                    class="bg-gray-200 p-2 rounded-lg hover:bg-gray-300 transition-colors duration-200" id="toggleFilters">
                                    <i class="fas fa-filter"></i> Filter
                                </button>
                                <button id="addRoomButton"
                                    class="bg-orange-600 text-white p-2 rounded-lg hover:bg-orange-700 transition-colors duration-200">
                                    + Add New Room
                                </button>
                            </div>
                        </div>

                        <!-- Advanced Filter Panel -->
                        <div id="filterPanel" class="mb-6 p-4 bg-filter-50 rounded-lg shadow-sm">
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1" for="floorFilter">Floor</label>
                                    <select id="floorFilter" name="floor" class="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                        <option value="">All Floors</option>
                                        <?php foreach(['B1', 'B2', 'B3', 'B4', 'B5', 'B6'] as $floor): ?>
                                            <option value="<?= $floor ?>" <?= ($filters['floor'] ?? '') == $floor ? 'selected' : '' ?>>
                                                <?= $floor ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1" for="roomTypeFilter">Room Type</label>
                                    <select id="roomTypeFilter" name="room_type" class="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                        <option value="">All Types</option>
                                        <option value="standard" <?= ($filters['room_type'] ?? '') == 'standard' ? 'selected' : '' ?>>Standard (6-bed)</option>
                                        <option value="premium" <?= ($filters['room_type'] ?? '') == 'premium' ? 'selected' : '' ?>>Premium (4-bed)</option>
                                        <option value="deluxe" <?= ($filters['room_type'] ?? '') == 'deluxe' ? 'selected' : '' ?>>Deluxe (2-bed)</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1" for="statusFilter">Status</label>
                                    <select id="statusFilter" name="status" class="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                        <option value="">All Statuses</option>
                                        <option value="available" <?= ($filters['status'] ?? '') == 'available' ? 'selected' : '' ?>>Available</option>
                                        <option value="occupied" <?= ($filters['status'] ?? '') == 'occupied' ? 'selected' : '' ?>>Occupied</option>
                                        <option value="maintenance" <?= ($filters['status'] ?? '') == 'maintenance' ? 'selected' : '' ?>>Under Maintenance</option>
                                        <option value="blocked" <?= ($filters['status'] ?? '') == 'blocked' ? 'selected' : '' ?>>Blocked</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1" for="capacityFilter">Capacity</label>
                                    <select id="capacityFilter" name="capacity" class="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                        <option value="">All Capacities</option>
                                        <?php foreach(range(1, 12) as $capacity): ?>
                                            <option value="<?= $capacity ?>" <?= ($filters['capacity'] ?? '') == $capacity ? 'selected' : '' ?>>
                                                <?= $capacity ?> beds
                                            </option>
                                        <?php endforeach; ?>
                                     </select>
                                 </div>
                            </div>
                            <div class="flex justify-end mt-4">
                                <button id="resetFilters" type="button" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 mr-2">Reset</button>
                                <button id="applyFilters" type="button" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">Apply Filters</button>
                            </div>
                        </div>

                        <!-- Search Bar with Quick Stats -->
                        <div class="mb-6 mt-4">
                        <div class="relative mb-4">
                                <input
                                    id="searchInput"
                                    class="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200"
                                    placeholder="Search room, tenant name, ID number..." 
                                    type="text" 
                                    value="<?= $search ?? '' ?>" />
                                <i class="fas fa-search absolute right-3 top-3 text-gray-400"></i>
                        </div>

                        <!-- Quick Stats Cards -->
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                <!-- Occupancy Rate Card -->
                                <?php 
                                    $occupancyRate = 0;
                                    if ($roomStats['total_capacity'] > 0) {
                                        $occupancyRate = round(($roomStats['total_occupied'] / $roomStats['total_capacity']) * 100);
                                    }
                                ?>
                                <div class="stats-card p-3 rounded-lg shadow-sm border-l-4 border-green-500">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <p class="text-xs text-gray-500">Occupancy Rate</p>
                                            <p class="text-xl font-bold"><?= $occupancyRate ?>%</p>
                                        </div>
                                        <div class="text-green-500 text-2xl">
                                            <i class="fas fa-bed"></i>
                                        </div>
                                    </div>
                                    <div class="text-xs text-gray-500 mt-2">
                                        <?= $roomStats['total_occupied'] ?> of <?= $roomStats['total_capacity'] ?> beds occupied
                                    </div>
                                </div>
                                
                                <!-- Available Rooms Card -->
                                <div class="stats-card p-3 rounded-lg shadow-sm border-l-4 border-blue-500">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <p class="text-xs text-gray-500">Available Rooms</p>
                                            <p class="text-xl font-bold"><?= $roomStats['available_count'] ?></p>
                                        </div>
                                        <div class="text-blue-500 text-2xl">
                                            <i class="fas fa-door-open"></i>
                                        </div>
                                    </div>
                                    <div class="text-xs text-gray-500 mt-2">
                                        <?= count($rooms) ?> total rooms in database
                                    </div>
                                </div>
                                
                                <!-- Maintenance Card -->
                                <div class="stats-card p-3 rounded-lg shadow-sm border-l-4 border-yellow-500">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <p class="text-xs text-gray-500">Maintenance</p>
                                            <p class="text-xl font-bold"><?= $roomStats['maintenance_count'] ?></p>
                                        </div>
                                        <div class="text-yellow-500 text-2xl">
                                            <i class="fas fa-tools"></i>
                                        </div>
                                    </div>
                                    <div class="text-xs text-gray-500 mt-2">
                                        <?= $roomStats['blocked_count'] ?> rooms currently blocked
                                    </div>
                                </div>
                                
                                <!-- Total Occupants Card -->
                                <div class="stats-card p-3 rounded-lg shadow-sm border-l-4 border-purple-500">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <p class="text-xs text-gray-500">Total Occupants</p>
                                            <p class="text-xl font-bold"><?= $roomStats['total_occupied'] ?></p>
                                        </div>
                                        <div class="text-purple-500 text-2xl">
                                            <i class="fas fa-users"></i>
                                        </div>
                                    </div>
                                    <div class="text-xs text-gray-500 mt-2">
                                        <?= $roomStats['total_capacity'] - $roomStats['total_occupied'] ?> available bedspaces
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Table -->
                        <div class="overflow-hidden rounded-lg border border-gray-200">
                            <!-- Table header row -->
                            <div class="bg-gray-50 px-4 py-3 flex items-center justify-between border-b border-gray-200">
                                <div class="w-16 px-3">
                                    <span class="text-xs font-medium text-gray-700">No.</span>
                                </div>
                                <div class="w-[18%] pl-4">
                                    <span class="text-xs font-medium text-gray-700 mr-2">Room No</span>
                                    <i class="fas fa-sort text-gray-400 text-xs"></i>
                                </div>
                                <div class="w-[22%]">
                                    <span class="text-xs font-medium text-gray-700 mr-2">Room Status</span>
                                    <i class="fas fa-sort text-gray-400 text-xs"></i>
                                </div>
                                <div class="w-[15%] flex items-center">
                                    <span class="text-xs font-medium text-gray-700 mr-2">Company</span>
                                    <i class="fas fa-sort text-gray-400 text-xs"></i>
                                </div>
                                <div class="w-[15%] flex items-center">
                                    <span class="text-xs font-medium text-gray-700 mr-2">Check-in Date</span>
                                    <i class="fas fa-sort text-gray-400 text-xs"></i>
                                </div>
                                <div class="w-[15%] flex items-center">
                                    <span class="text-xs font-medium text-gray-700 mr-2">Bedspace</span>
                                    <i class="fas fa-sort text-gray-400 text-xs"></i>
                                </div>
                                <div class="w-[10%] flex justify-end items-center space-x-2">
                                    <span class="text-xs font-medium text-gray-700">Actions</span>
                                </div>
                            </div>

                            <!-- Empty State (No Rooms Found) -->
                            <?php if (empty($rooms)): ?>
                            <div class="bg-white px-4 py-8 text-center border-b border-gray-200">
                                <div class="text-gray-400 mb-2"><i class="fas fa-bed fa-2x"></i></div>
                                <h3 class="text-lg font-medium text-gray-900">No rooms found</h3>
                                <p class="text-gray-500 mt-1">Try adjusting your search or filter criteria</p>
                                <button id="clearFiltersBtn" class="mt-3 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 inline-flex items-center">
                                    <i class="fas fa-undo mr-2"></i> Clear all filters
                                </button>
                            </div>
                            <?php else: ?>
                            
                            <!-- Dynamic Room Listing -->
                            <?php $counter = 1; foreach ($rooms as $room): ?>
                                <!-- Room <?= $room['room_number'] ?> -->
                                <div class="bg-white px-4 py-3 flex items-center justify-between border-b border-gray-200">
                                    <div class="w-16 px-3"><?= $counter ?>.</div>
                                    <div class="w-[18%] pl-4">
                                        <span><?= esc($room['room_number']) ?></span>
                                    </div>
                                    <div class="w-[22%]">
                                        <?php
                                            $statusClass = '';
                                            switch($room['status']) {
                                                case 'available':
                                                    $statusClass = 'status-available';
                                                    break;
                                                case 'occupied':
                                                    $statusClass = 'status-occupied';
                                                    break;
                                                case 'maintenance':
                                                    $statusClass = 'status-maintenance';
                                                    break;
                                                case 'blocked':
                                                    $statusClass = 'status-blocked';
                                                    break;
                                            }
                                        ?>
                                        <span class="status <?= $statusClass ?>">
                                            <?php if ($room['status'] == 'available'): ?>
                                                Available
                                            <?php elseif ($room['status'] == 'occupied'): ?>
                                                Occupied
                                            <?php elseif ($room['status'] == 'maintenance'): ?>
                                                Under Maintenance
                                            <?php elseif ($room['status'] == 'blocked'): ?>
                                                Blocked
                                            <?php endif; ?>
                                        </span>
                                    </div>
                                    <div class="w-[15%]">
                                        <?php if (!empty($room['room_type'])): ?>
                                            <?= ucfirst(esc($room['room_type'])) ?>
                                        <?php else: ?>
                                            Standard
                                        <?php endif; ?>
                                    </div>
                                    <div class="w-[15%]"><?= $room['capacity'] ?></div>
                                    <div class="w-[15%]">
                                        <?php if (isset($room['occupied_count'])): ?>
                                            <?= $room['occupied_count'] ?>/<?= $room['capacity'] ?>
                                        <?php else: ?>
                                            0/<?= $room['capacity'] ?>
                                        <?php endif; ?>
                                    </div>
                                    <div class="w-[10%] flex justify-end items-center space-x-2">
                                        <button class="icon-button show-room-details w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center hover:bg-gray-200 transition-colors" 
                                                data-room-id="<?= $room['id'] ?>" 
                                                data-room-number="<?= esc($room['room_number']) ?>">
                                            <i class="fas fa-info-circle"></i>
                                        </button>
                                        <button class="icon-button toggle-staff w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center hover:bg-gray-200 transition-colors" 
                                                data-room-id="<?= $room['id'] ?>" 
                                                aria-expanded="false">
                                            <i class="fas fa-chevron-down text-xs"></i>
                                        </button>
                                        <div class="relative">
                                            <button class="icon-button toggle-actions w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center hover:bg-gray-200 transition-colors" 
                                                    data-room-id="<?= $room['id'] ?>">
                                                <i class="fas fa-ellipsis-h"></i>
                                            </button>
                                            <div class="action-menu absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10 hidden">
                                                <button class="edit-room-btn block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" 
                                                        data-room-id="<?= $room['id'] ?>">
                                                    Edit Room
                                                </button>
                                                <?php if ($room['status'] == 'available'): ?>
                                                    <button class="assign-occupant-btn block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" 
                                                            data-room-id="<?= $room['id'] ?>">
                                                        Assign Occupant
                                                    </button>
                                                    <button class="schedule-maintenance-btn block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" 
                                                            data-room-id="<?= $room['id'] ?>">
                                                        Schedule Maintenance
                                                    </button>
                                                    <button class="block-room-btn block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100" 
                                                            data-room-id="<?= $room['id'] ?>">
                                                        Block Room
                                                    </button>
                                                <?php elseif ($room['status'] == 'occupied'): ?>
                                                    <button class="view-occupants-btn block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" 
                                                            data-room-id="<?= $room['id'] ?>">
                                                        View Occupants
                                                    </button>
                                                    <button class="schedule-maintenance-btn block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" 
                                                            data-room-id="<?= $room['id'] ?>">
                                                        Schedule Maintenance
                                                    </button>
                                                <?php elseif ($room['status'] == 'maintenance'): ?>
                                                    <button class="view-maintenance-btn block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" 
                                                            data-room-id="<?= $room['id'] ?>">
                                                        View Maintenance Log
                                                    </button>
                                                    <button class="complete-maintenance-btn block w-full text-left px-4 py-2 text-sm text-green-600 hover:bg-gray-100" 
                                                            data-room-id="<?= $room['id'] ?>">
                                                        Mark as Available
                                                    </button>
                                                <?php elseif ($room['status'] == 'blocked'): ?>
                                                    <button class="unblock-room-btn block w-full text-left px-4 py-2 text-sm text-green-600 hover:bg-gray-100" 
                                                            data-room-id="<?= $room['id'] ?>">
                                                        Unblock Room
                                                    </button>
                                                <?php endif; ?>
                                                <button class="delete-room-btn block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100" 
                                                        data-room-id="<?= $room['id'] ?>">
                                                    Delete Room
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-white px-0 border-b border-gray-200 staff-list-row">
                                    <div class="staff-list pl-20" id="staff-<?= $room['id'] ?>" style="display: none;">
                                        <div class="p-4">
                                            <div class="flex justify-between">
                                                <!-- Beds/Occupants Grid (left side) -->
                                                <div class="grid grid-cols-3 gap-2 flex-1 mr-8 room-occupants-container" data-room-id="<?= $room['id'] ?>">
                                                    <!-- Will be populated by JavaScript -->
                                                    <div class="text-sm p-2 bg-gray-200 rounded text-center">
                                                        <p class="text-gray-500"><i class="fas fa-spinner fa-spin mr-2"></i>Loading...</p>
                                                    </div>
                                                </div>

                                                <!-- Room Info (right side) -->
                                                <div class="flex flex-col space-y-2 min-w-[200px]">
                                                    <div class="flex items-center space-x-4">
                                                        <span class="text-gray-600 text-sm">Room Type:</span>
                                                        <span class="text-sm">
                                                            <?php if (!empty($room['room_type'])): ?>
                                                                <?= ucfirst(esc($room['room_type'])) ?> (<?= $room['capacity'] ?>-bed)
                                                            <?php else: ?>
                                                                Standard (<?= $room['capacity'] ?>-bed)
                                                            <?php endif; ?>
                                                        </span>
                                                    </div>
                                                    <div class="flex items-center space-x-4">
                                                        <span class="text-gray-600 text-sm">Floor:</span>
                                                        <span class="text-sm"><?= $room['floor'] ?></span>
                                                    </div>
                                                    <div class="flex items-center space-x-4">
                                                        <span class="text-gray-600 text-sm">Status:</span>
                                                        <?php if ($room['status'] == 'available'): ?>
                                                            <span class="text-green-600 text-sm">
                                                                <i class="fas fa-check-circle"></i> Available
                                                            </span>
                                                        <?php elseif ($room['status'] == 'occupied'): ?>
                                                            <span class="text-blue-600 text-sm">
                                                                <i class="fas fa-users"></i> Occupied
                                                            </span>
                                                        <?php elseif ($room['status'] == 'maintenance'): ?>
                                                            <span class="text-yellow-600 text-sm">
                                                                <i class="fas fa-tools"></i> Under Maintenance
                                                            </span>
                                                        <?php elseif ($room['status'] == 'blocked'): ?>
                                                            <span class="text-red-600 text-sm">
                                                                <i class="fas fa-ban"></i> Blocked
                                                            </span>
                                                        <?php endif; ?>
                                                    </div>
                                                    <button class="view-room-details-btn w-fit px-3 py-1.5 bg-blue-50 text-blue-600 rounded-md text-sm hover:bg-blue-100 transition-colors duration-200 flex items-center"
                                                            data-room-id="<?= $room['id'] ?>">
                                                        <span>View Details</span>
                                                        <i class="fas fa-chevron-right ml-2 text-xs"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php $counter++; endforeach; ?>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Pagination controls -->
                        <?= $pager->links() ?>                 
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Footer -->
<footer class="py-4 text-center text-gray-500 text-sm">
    <p>&copy; <?= date('Y') ?> RSC7 Management System. All rights reserved.</p>
</footer>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Define base URL for AJAX requests
    const baseUrl = '<?= base_url() ?>';
</script>
<script src="<?= base_url('js/manage-room.js') ?>"></script>
<script src="<?= base_url('js/main.js') ?>" defer></script>
<script src="<?= base_url('js/darkmode.js') ?>" defer></script>
<script src="<?= base_url('js/sidebar.js') ?>" defer></script>
<script src="<?= base_url('js/notifications.js') ?>" defer></script>
<script src="<?= base_url('js/modal-navigation.js') ?>" defer></script>
<script src="<?= base_url('js/pagination.js') ?>" defer></script>
<script src="<?= base_url('js/collapse-all.js') ?>" defer></script>
<script src="<?= base_url('js/room-modals.js') ?>" defer></script>
<script src="<?= base_url('js/room-management.js') ?>" defer></script>
<script src="<?= base_url('js/tenant-assignment.js') ?>" defer></script>
<script src="<?= base_url('js/staff-toggle.js') ?>" defer></script>
<script src="<?= base_url('js/button-logic.js') ?>" defer></script>
<script src="<?= base_url('js/filters.js') ?>" defer></script>
<script>
    // Apply dark mode immediately if user had it enabled
    (function() {
        if (localStorage.getItem('darkMode') === 'true') {
            document.documentElement.classList.add('dark-mode');
        }
    })();
</script>
<?= $this->endSection() ?>