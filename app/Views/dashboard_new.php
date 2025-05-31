<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<h1 class="text-2xl font-bold mb-4 text-gray-700 dark-mode-text tracking-wide">Welcome, Sharul Aiman.</h1>

<!-- Overview Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
    <!-- Card 1 -->
    <div class="card expandable-card">
        <div class="card-content" onclick="toggleDetails('details1')">
            <i class="fas fa-chevron-down absolute top-1/2 right-4 transform -translate-y-1/2 text-gray-400"></i>
            <h2 class="text-xl font-bold mb-4">Available Rooms</h2>
            <p class="text-2xl font-bold text-blue-400">83</p>
        </div>
        <div id="details1" class="details">
            <div class="p-3 text-xs">
                <div class="grid grid-cols-2 gap-2">
                    <div class="bg-blue-50 p-1.5 rounded">
                        <div class="flex items-center text-blue-700 font-medium mb-1">
                            <i class="fas fa-bed mr-1.5"></i>Free Bedspaces
                        </div>
                        <div class="text-lg font-bold text-blue-800">155</div>
                        <div class="text-xs text-blue-600">from 32 rooms</div>
                    </div>
                    <div class="bg-yellow-50 p-1.5 rounded">
                        <div class="flex items-center text-yellow-700 font-medium mb-1">
                            <i class="fas fa-user-check mr-1.5"></i>Occupied
                        </div>
                        <div class="text-lg font-bold text-yellow-800">206</div>
                        <div class="text-xs text-yellow-600">from 51 rooms</div>
                    </div>
                </div>
                <div class="mt-2 mb-1 text-xs text-gray-500">Occupancy Rate: 61%</div>
                <div class="w-full bg-gray-200 rounded-full h-1.5 mb-2">
                    <div class="bg-blue-500 h-1.5 rounded-full" style="width: 61%"></div>
                </div>
                <a href="<?= base_url('manage-room') ?>" class="text-purple-500 hover:text-blue-700 text-xs font-medium flex items-center justify-end">
                    <span>See Room Details</span>
                    <i class="fas fa-arrow-right ml-1 text-xs"></i>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Card 2 -->
    <div class="card expandable-card">
        <div class="card-content" onclick="toggleDetails('details3')">
            <i class="fas fa-chevron-down absolute top-1/2 right-4 transform -translate-y-1/2 text-gray-400"></i>
            <h2 class="text-xl font-bold mb-4">Occupied Rooms</h2>
            <p class="text-2xl font-bold text-yellow-500">51</p>
        </div>
        <div id="details3" class="details">
            <div class="p-3 text-xs">
                <!-- Card details content here -->
                <a href="<?= base_url('manage-room') ?>" class="text-yellow-500 hover:text-yellow-700 text-xs font-medium flex items-center justify-end mt-1">
                    <span>Manage Occupied Rooms</span>
                    <i class="fas fa-arrow-right ml-1 text-xs"></i>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Card 3 -->
    <div class="card expandable-card">
        <div class="card-content" onclick="toggleDetails('details2')">
            <i class="fas fa-chevron-down absolute top-1/2 right-4 transform -translate-y-1/2 text-gray-400"></i>
            <h2 class="text-xl font-bold mb-4">Available Bedspaces</h2>
            <p class="text-2xl font-bold text-green-500">32</p>
        </div>
        <div id="details2" class="details">
            <div class="p-3 text-xs">
                <!-- Card details content here -->
                <a href="<?= base_url('manage-room') ?>" class="text-green-500 hover:text-green-700 text-xs font-medium flex items-center justify-end mt-1">
                    <span>View Available Rooms</span>
                    <i class="fas fa-arrow-right ml-1 text-xs"></i>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Card 4 -->
    <div class="card expandable-card">
        <div class="card-content" onclick="toggleDetails('details4')">
            <i class="fas fa-chevron-down absolute top-1/2 right-4 transform -translate-y-1/2 text-gray-400"></i>
            <h2 class="text-xl font-bold mb-4">Under Maintenance</h2>
            <p class="text-2xl font-bold text-red-500">-</p>
        </div>
        <div id="details4" class="details">
            <div class="p-3 text-xs">
                <!-- Card details content here -->
                <a href="<?= base_url('maintenance') ?>" class="text-red-500 hover:text-red-700 text-xs font-medium flex items-center justify-end mt-2">
                    <span>View Maintenance Schedule</span>
                    <i class="fas fa-arrow-right ml-1 text-xs"></i>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Card 5 -->
    <div class="card expandable-card">
        <div class="card-content" onclick="toggleDetails('details5')">
            <i class="fas fa-chevron-down absolute top-1/2 right-4 transform -translate-y-1/2 text-gray-400"></i>
            <h2 class="text-xl font-bold mb-4">Rooms Blocked</h2>
            <p class="text-2xl font-bold text-red-500">3</p>
        </div>
        <div id="details5" class="details">
            <div class="p-3 text-xs">
                <!-- Card details content here -->
                <a href="<?= base_url('manage-room') ?>" class="text-red-500 hover:text-red-700 text-xs font-medium flex items-center justify-end mt-2">
                    <span>Manage Blocked Rooms</span>
                    <i class="fas fa-arrow-right ml-1 text-xs"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Floor Plan Preview -->
<div class="card bg-white shadow-md rounded-lg p-6 mb-6">
    <h2 class="text-xl font-bold mb-4">RSC7 Floor Plan</h2>
    <div class="relative bg-white rounded-lg" style="min-height: 300px;">
        <!-- Floor selector -->
        <div class="absolute top-4 left-4 z-10">
            <div class="select-wrapper">
                <select id="floorSelector"
                    class="bg-gray-100 border border-gray-300 text-gray-700 py-2 px-4 pr-8 rounded-lg shadow-sm">
                    <option value="RSC7_B1.png">Floor 1</option>
                    <option value="RSC7_B2.png">Floor 2</option>
                    <option value="RSC7_B3.png">Floor 3</option>
                </select>
                <i class="fas fa-chevron-down absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-500 pointer-events-none text-sm"></i>
            </div>
        </div>

        <!-- Floor plan image container -->
        <div id="floorPlanContainer" class="overflow-hidden relative w-full h-full rounded-lg">
            <div id="floorPlanWrapper" class="absolute">
                <img id="floorPlanImage" src="<?= base_url('images/RSC7_B1.png') ?>" alt="Floor plan"
                    class="transition-transform duration-300" />
                <!-- Room overlays would go here -->
            </div>
        </div>
    </div>
    <div class="mt-4 text-center">
        <a href="<?= base_url('floor-plan') ?>" class="text-purple-500 hover:text-purple-700 text-sm font-medium inline-flex items-center">
            <span>View Full Floor Plan</span>
            <i class="fas fa-arrow-right ml-1"></i>
        </a>
    </div>
</div>

<!-- Quick Actions -->
<div class="card bg-white shadow-md rounded-lg p-6 mb-6">
    <h2 class="text-xl font-bold mb-4">Quick Actions</h2>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <!-- Search Rooms -->
        <a href="<?= base_url('manage-room') ?>" class="group cursor-pointer transform transition-all duration-300 hover:-translate-y-1">
            <div class="bg-gray-100 p-4 rounded-lg shadow-sm hover:shadow-md flex flex-col items-center justify-center h-24">
                <div class="mb-2 text-green-500">
                    <i class="fas fa-search text-xl"></i>
                </div>
                <span class="text-sm font-medium text-center">Search Rooms</span>
            </div>
        </a>
        
        <!-- Manage Tenant -->
        <a href="<?= base_url('manage-tenant') ?>" class="group cursor-pointer transform transition-all duration-300 hover:-translate-y-1">
            <div class="bg-gray-100 p-4 rounded-lg shadow-sm hover:shadow-md flex flex-col items-center justify-center h-24">
                <div class="mb-2 text-purple-500">
                    <i class="fas fa-users text-xl"></i>
                </div>
                <span class="text-sm font-medium text-center">Manage Tenant</span>
            </div>
        </a>
        
        <!-- Room Maintenance -->
        <a href="<?= base_url('maintenance') ?>" class="group cursor-pointer transform transition-all duration-300 hover:-translate-y-1">
            <div class="bg-gray-100 p-4 rounded-lg shadow-sm hover:shadow-md flex flex-col items-center justify-center h-24">
                <div class="mb-2 text-red-500">
                    <i class="fas fa-tools text-xl"></i>
                </div>
                <span class="text-sm font-medium text-center">Room Maintenance</span>
            </div>
        </a>
        
        <!-- Generate Report -->
        <a href="<?= base_url('generate-report') ?>" class="group cursor-pointer transform transition-all duration-300 hover:-translate-y-1">
            <div class="bg-gray-100 p-4 rounded-lg shadow-sm hover:shadow-md flex flex-col items-center justify-center h-24">
                <div class="mb-2 text-blue-500">
                    <i class="fas fa-file-alt text-xl"></i>
                </div>
                <span class="text-sm font-medium text-center">Generate Report</span>
            </div>
        </a>
    </div>
</div>

<!-- Footer -->
<footer class="py-4 text-center text-gray-500 text-sm">
    <p>&copy; <?= date('Y') ?> RSC7 Management System. All rights reserved.</p>
</footer>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="<?= base_url('js/room-overlays.js') ?>"></script>
<script src="<?= base_url('js/zoom-pan.js') ?>"></script>
<script src="<?= base_url('js/floor-selector.js') ?>"></script>
<script src="<?= base_url('js/expandable-cards.js') ?>"></script>
<script src="<?= base_url('js/button-logic.js') ?>"></script>
<script src="<?= base_url('js/card-slider.js') ?>"></script>
<script src="<?= base_url('js/modals.js') ?>"></script>
<script src="<?= base_url('js/record-hover-effects.js') ?>"></script>
<script src="<?= base_url('js/index/no-results-message.js') ?>"></script>
<script src="<?= base_url('js/index/activity-details-panel.js') ?>"></script>
<script src="<?= base_url('js/index/activity-pagination.js') ?>"></script>
<script src="<?= base_url('js/index/booking-details-panel.js') ?>"></script>
<script src="<?= base_url('js/index/bookings-modal.js') ?>"></script>
<script src="<?= base_url('js/index/issue-card-slider.js') ?>"></script>
<script src="<?= base_url('js/index/records-occupant-modals.js') ?>"></script>
<script src="<?= base_url('js/index/activity-log-modal.js') ?>"></script>
<script src="<?= base_url('js/index/pagination-handler.js') ?>"></script>
<script src="<?= base_url('js/index/custom-styles.js') ?>"></script>
<?= $this->endSection() ?>
