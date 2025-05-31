<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="<?= base_url('css/floorplan.css') ?>">
<link rel="stylesheet" href="<?= base_url('css/index/index-main.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h1 class="text-2xl font-bold mb-4 text-gray-700 dark-mode-text tracking-wide">Welcome, Sharul Aiman.</h1>

<!-- Overview Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
    <!-- Card 1 - Available Rooms -->
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
    
    <!-- Card 2 - Occupied Rooms -->
    <div class="card expandable-card">
        <div class="card-content" onclick="toggleDetails('details3')">
            <i class="fas fa-chevron-down absolute top-1/2 right-4 transform -translate-y-1/2 text-gray-400"></i>
            <h2 class="text-xl font-bold mb-4">Occupied Rooms</h2>
            <p class="text-2xl font-bold text-yellow-500">51</p>
        </div>
        <div id="details3" class="details">
            <div class="p-3 text-xs">
                <div class="flex justify-between items-center mb-2">
                    <div class="flex items-center">
                        <div class="w-2 h-2 bg-yellow-500 rounded-full mr-1.5"></div>
                        <span class="text-gray-600">Occupancy Rate:</span>
                    </div>
                    <span class="font-bold">61%</span>
                </div>
                <div class="flex justify-between items-center mb-2">
                    <div class="flex items-center">
                        <div class="w-2 h-2 bg-orange-500 rounded-full mr-1.5"></div>
                        <span class="text-gray-600">Expiring Soon:</span>
                    </div>
                    <span class="font-bold text-orange-500">7 rooms</span>
                </div>
                <div class="flex justify-between items-center mb-2">
                    <div class="flex items-center">
                        <div class="w-2 h-2 bg-red-500 rounded-full mr-1.5"></div>
                        <span class="text-gray-600">Pending Payments:</span>
                    </div>
                    <span class="font-bold text-red-500">3 rooms</span>
                </div>
                <a href="<?= base_url('manage-room') ?>" class="text-yellow-500 hover:text-yellow-700 text-xs font-medium flex items-center justify-end mt-1">
                    <span>Manage Occupied Rooms</span>
                    <i class="fas fa-arrow-right ml-1 text-xs"></i>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Card 3 - Available Bedspaces -->
    <div class="card expandable-card">
        <div class="card-content" onclick="toggleDetails('details2')">
            <i class="fas fa-chevron-down absolute top-1/2 right-4 transform -translate-y-1/2 text-gray-400"></i>
            <h2 class="text-xl font-bold mb-4">Available Bedspaces</h2>
            <p class="text-2xl font-bold text-green-500">32</p>
        </div>
        <div id="details2" class="details">
            <div class="p-3 text-xs">
                <!-- Room Types Card Slider -->
                <div class="relative mb-2">
                    <!-- Previous Button -->
                    <button id="vacantPrevButton" class="absolute left-0 top-1/2 transform -translate-y-1/2 z-10 bg-white shadow-sm border border-gray-200 text-gray-600 hover:text-purple-500 hover:border-blue-300 transition-all p-1.5 rounded-full disabled:opacity-50 disabled:cursor-not-allowed" style="left: -5px;" disabled>
                        <i class="fas fa-chevron-left text-xs"></i>
                    </button>
                    
                    <!-- Cards Container with overflow hidden -->
                    <div class="overflow-hidden">
                        <div id="vacantRoomsContainer" class="flex transition-transform duration-300 ease-in-out">
                            <!-- Type Card 1: 2-Bed -->
                            <div class="vacant-type-card flex-shrink-0 w-1/3 px-1">
                                <div class="bg-gradient-to-r from-blue-50 to-blue-100 rounded-lg p-2 border border-blue-200 text-center">
                                    <div class="text-blue-800 font-medium text-xs">2-Bed</div>
                                    <div class="text-xl font-bold text-blue-800 leading-tight">3</div>
                                    <div class="text-xs text-blue-600">6 beds</div>
                                </div>
                            </div>
                            
                            <!-- Type Card 2: 3-Bed -->
                            <div class="vacant-type-card flex-shrink-0 w-1/3 px-1">
                                <div class="bg-gradient-to-r from-purple-50 to-purple-100 rounded-lg p-2 border border-purple-200 text-center">
                                    <div class="text-purple-800 font-medium text-xs">3-Bed</div>
                                    <div class="text-xl font-bold text-purple-800 leading-tight">0</div>
                                    <div class="text-xs text-purple-600">0 beds</div>
                                </div>
                            </div>
                            
                            <!-- Type Card 3: 4-Bed -->
                            <div class="vacant-type-card flex-shrink-0 w-1/3 px-1">
                                <div class="bg-gradient-to-r from-green-50 to-green-100 rounded-lg p-2 border border-green-200 text-center">
                                    <div class="text-green-800 font-medium text-xs">4-Bed</div>
                                    <div class="text-xl font-bold text-green-800 leading-tight">4</div>
                                    <div class="text-xs text-green-600">16 beds</div>
                                </div>
                            </div>
                            
                            <!-- Type Card 4: 5-Bed -->
                            <div class="vacant-type-card flex-shrink-0 w-1/3 px-1">
                                <div class="bg-gradient-to-r from-red-50 to-red-100 rounded-lg p-2 border border-red-200 text-center">
                                    <div class="text-red-800 font-medium text-xs">5-Bed</div>
                                    <div class="text-xl font-bold text-red-800 leading-tight">17</div>
                                    <div class="text-xs text-red-600">85 beds</div>
                                </div>
                            </div>
                            
                            <!-- Type Card 5: 6-Bed -->
                            <div class="vacant-type-card flex-shrink-0 w-1/3 px-1">
                                <div class="bg-gradient-to-r from-amber-50 to-amber-100 rounded-lg p-2 border border-amber-200 text-center">
                                    <div class="text-amber-800 font-medium text-xs">6-Bed</div>
                                    <div class="text-xl font-bold text-amber-800 leading-tight">8</div>
                                    <div class="text-xs text-amber-600">48 beds</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Next Button -->
                    <button id="vacantNextButton" class="absolute right-0 top-1/2 transform -translate-y-1/2 z-10 bg-white shadow-sm border border-gray-200 text-gray-600 hover:text-purple-500 hover:border-blue-300 transition-all p-1.5 rounded-full" style="right: -5px;">
                        <i class="fas fa-chevron-right text-xs"></i>
                    </button>
                </div>
                
                <div class="flex items-center justify-between mt-2 pt-1.5 border-t border-gray-200">
                    <div class="flex items-center text-gray-600">
                        <i class="fas fa-check-circle text-green-500 mr-1.5"></i>
                        <span>Total available:</span>
                    </div>
                    <span class="font-bold text-green-700">155 bedspaces</span>
                </div>
                
                <a href="<?= base_url('manage-room') ?>" class="text-green-500 hover:text-green-700 text-xs font-medium flex items-center justify-end mt-1">
                    <span>View Available Rooms</span>
                    <i class="fas fa-arrow-right ml-1 text-xs"></i>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Card 4 - Under Maintenance -->
    <div class="card expandable-card">
        <div class="card-content" onclick="toggleDetails('details4')">
            <i class="fas fa-chevron-down absolute top-1/2 right-4 transform -translate-y-1/2 text-gray-400"></i>
            <h2 class="text-xl font-bold mb-4">Under Maintenance</h2>
            <p class="text-2xl font-bold text-red-500">-</p>
        </div>
        <div id="details4" class="details">
            <div class="p-3 text-xs">
                <div class="bg-green-50 p-2 rounded mb-2 flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-500 mr-1.5"></i>
                    <span class="text-green-700 font-medium">All rooms operational</span>
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <div class="bg-gray-50 p-1.5 rounded">
                        <div class="text-gray-600 mb-0.5">Last Maintenance:</div>
                        <div class="font-medium">Room 202</div>
                        <div class="text-gray-500 text-xs">3 days ago</div>
                    </div>
                    <div class="bg-gray-50 p-1.5 rounded">
                        <div class="text-gray-600 mb-0.5">Next Scheduled:</div>
                        <div class="font-medium">Room 105</div>
                        <div class="text-gray-500 text-xs">in 5 days</div>
                    </div>
                </div>
                <a href="<?= base_url('maintenance') ?>" class="text-red-500 hover:text-red-700 text-xs font-medium flex items-center justify-end mt-2">
                    <span>View Maintenance Schedule</span>
                    <i class="fas fa-arrow-right ml-1 text-xs"></i>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Card 5 - Rooms Blocked -->
    <div class="card expandable-card">
        <div class="card-content" onclick="toggleDetails('details5')">
            <i class="fas fa-chevron-down absolute top-1/2 right-4 transform -translate-y-1/2 text-gray-400"></i>
            <h2 class="text-xl font-bold mb-4">Rooms Blocked</h2>
            <p class="text-2xl font-bold text-red-500">3</p>
        </div>
        <div id="details5" class="details">
            <div class="p-3 text-xs">
                <div class="space-y-1.5">
                    <div class="bg-red-50 p-1.5 rounded flex justify-between items-center">
                        <div class="flex items-center">
                            <i class="fas fa-ban text-red-500 mr-1.5"></i>
                            <span class="font-medium">Room 103</span>
                        </div>
                        <span class="text-red-700">Plumbing issues</span>
                    </div>
                    <div class="bg-red-50 p-1.5 rounded flex justify-between items-center">
                        <div class="flex items-center">
                            <i class="fas fa-ban text-red-500 mr-1.5"></i>
                            <span class="font-medium">Room 215</span>
                        </div>
                        <span class="text-red-700">Electrical repairs</span>
                    </div>
                    <div class="bg-red-50 p-1.5 rounded flex justify-between items-center">
                        <div class="flex items-center">
                            <i class="fas fa-ban text-red-500 mr-1.5"></i>
                            <span class="font-medium">Room 307</span>
                        </div>
                        <span class="text-red-700">Renovation</span>
                    </div>
                </div>
                <a href="<?= base_url('manage-room') ?>" class="text-red-500 hover:text-red-700 text-xs font-medium flex items-center justify-end mt-2">
                    <span>Manage Blocked Rooms</span>
                    <i class="fas fa-arrow-right ml-1 text-xs"></i>
                </a>
            </div>
        </div>
    </div>
    
</div>

<!-- Interactive Floor Plan, Quick Actions & Recent Activity in One Row -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-6">
    <!-- Floor Plan (Takes 2/3 space) -->
    <div class="card basic-card bg-white shadow-md rounded-lg p-6 lg:col-span-2">
        <h2 class="text-xl font-bold mb-4">RSC7 Floor Plan</h2>
        <div class="relative bg-white rounded-lg" style="min-height: 450px;">
            <!-- Floor selector -->
            <div class="absolute top-4 left-4 z-10">
                <div class="select-wrapper">
                    <select id="floorSelector"
                        class="bg-gray-100 border border-gray-300 text-gray-700 py-2 px-4 pr-8 rounded-lg shadow-sm">
                        <option value="RSC7_B1.png">Floor 1</option>
                        <option value="RSC7_B2.png">Floor 2</option>
                        <option value="RSC7_B3.png">Floor 3</option>
                    </select>
                    <i
                        class="fas fa-chevron-down absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-500 pointer-events-none text-sm"></i>
                </div>
            </div>

            <!-- Floor plan image container -->
            <div id="floorPlanContainer" class="overflow-hidden relative w-full h-full rounded-lg">
                <div id="floorPlanWrapper" class="absolute">
                    <img id="floorPlanImage" src="<?= base_url('images/RSC7_B1.png') ?>" alt="Floor plan"
                        class="transition-transform duration-300" />

                    <!-- Room Overlays for Floor 1 -->
                    <div id="room-1" class="room-overlay floor-1 full"></div>
                    <div id="room-2" class="room-overlay floor-1 full"></div>
                    <div id="room-3" class="room-overlay floor-1 available"></div>
                    <div id="room-4" class="room-overlay floor-1 available"></div>
                    <div id="room-5" class="room-overlay floor-1 full"></div>
                    <div id="room-6" class="room-overlay floor-1 maintenance"></div>
                    <div id="room-9" class="room-overlay floor-1 blocked"></div>
                    <div id="room-10" class="room-overlay floor-1 available"></div>
                    <div id="room-7" class="room-overlay floor-1 available"></div>
                    <div id="room-8" class="room-overlay floor-1 maintenance"></div>

                    <!-- Room Overlays for Floor 2 -->
                    <div id="room-7-02-18" class="room-overlay floor-2 full"></div>
                    <div id="room-7-02-17" class="room-overlay floor-2 full"></div>
                    <div id="room-7-02-16" class="room-overlay floor-2 available"></div>
                    <div id="room-7-02-15" class="room-overlay floor-2 available"></div>
                    <div id="room-7-02-14" class="room-overlay floor-2 full"></div>
                    <div id="room-7-02-19" class="room-overlay floor-2 maintenance"></div>
                    <div id="room-7-02-20" class="room-overlay floor-2 full"></div>
                    <div id="room-7-02-21" class="room-overlay floor-2 available"></div>
                    <div id="room-7-02-22" class="room-overlay floor-2 available"></div>
                    <div id="room-7-02-23" class="room-overlay floor-2 blocked"></div>
                    <div id="room-7-02-04-rect" class="room-overlay floor-2 full"></div>
                    <div id="room-7-02-27" class="room-overlay floor-2 available"></div>
                    <div id="room-7-02-08" class="room-overlay floor-2 full"></div>
                    <div id="room-7-02-09" class="room-overlay floor-2 maintenance"></div>
                    <div id="room-7-02-10" class="room-overlay floor-2 available"></div>
                    <div id="room-7-02-11" class="room-overlay floor-2 full"></div>
                    <div id="room-7-02-12" class="room-overlay floor-2 full"></div>
                    <div id="room-7-02-13" class="room-overlay floor-2 available"></div>
                    <div id="room-7-02-07" class="room-overlay floor-2 full"></div>
                    <div id="room-7-02-06" class="room-overlay floor-2 maintenance"></div>
                    <div id="room-7-02-05" class="room-overlay floor-2 available"></div>
                    <div id="room-7-02-02" class="room-overlay floor-2 full"></div>
                    <!-- Polygon rooms -->
                    <div id="room-7-02-25" class="room-overlay floor-2 blocked polygon-overlay"></div>
                    <div id="room-7-02-26" class="room-overlay floor-2 maintenance polygon-overlay"></div>
                    <div id="room-7-02-01" class="room-overlay floor-2 available polygon-overlay"></div>
                    <div id="room-7-02-03" class="room-overlay floor-2 full polygon-overlay"></div>
                    <div id="room-7-02-04-poly" class="room-overlay floor-2 full polygon-overlay"></div>
                </div>
            </div>

            <!-- Navigation controls -->
            <div class="absolute bottom-4 left-4">
                <div
                    class="bg-gray-100 bg-opacity-80 border border-gray-300 shadow-md rounded-lg p-2">
                    <div class="grid grid-cols-3 gap-1 w-24 h-24">
                        <div></div>
                        <button id="navUp"
                            class="flex items-center justify-center text-gray-700 hover:bg-gray-200 rounded p-1">
                            <i class="fas fa-chevron-up"></i>
                        </button>
                        <div></div>
                        <button id="navLeft"
                            class="flex items-center justify-center text-gray-700 hover:bg-gray-200 rounded p-1">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <div class="flex items-center justify-center">
                            <button id="resetView"
                                class="flex items-center justify-center bg-gray-400 rounded-full w-4 h-4 hover:bg-gray-600"></button>
                        </div>
                        <button id="navRight"
                            class="flex items-center justify-center text-gray-700 hover:bg-gray-200 rounded p-1">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                        <div></div>
                        <button id="navDown"
                            class="flex items-center justify-center text-gray-700 hover:bg-gray-200 rounded p-1">
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        <div></div>
                    </div>
                </div>
            </div>

            <!-- Zoom controls -->
            <div class="absolute bottom-4 right-4 flex space-x-2">
                <button id="zoomIn"
                    class="w-12 h-12 bg-gray-100 hover:bg-gray-200 rounded-lg border border-gray-300 shadow-md flex items-center justify-center">
                    <i class="fas fa-plus text-gray-700 text-xl"></i>
                </button>
                <button id="zoomOut"
                    class="w-12 h-12 bg-gray-100 hover:bg-gray-200 rounded-lg border border-gray-300 shadow-md flex items-center justify-center">
                    <i class="fas fa-minus text-gray-700 text-xl"></i>
                </button>
            </div>
        </div>
        <div class="mt-4 text-center">
            <a href="<?= base_url('floor-plan') ?>" class="text-purple-500 hover:text-purple-700 text-sm font-medium inline-flex items-center">
                <span>View Full Floor Plan</span>
                <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
    </div>

    <!-- Quick Actions & Recent Activity in the same column -->
    <div class="grid grid-cols-1 gap-4 h-full">
        <!-- Quick Actions -->
        <div class="card bg-white shadow-md rounded-lg p-6 overflow-hidden">
            <h2 class="text-xl font-bold mb-5 flex items-center">
                Quick Actions
            </h2>
            <div class="grid grid-cols-2 gap-3">
                <!-- Search Available Rooms -->
                <div class="group cursor-pointer transform transition-all duration-300 hover:-translate-y-1">
                    <a href="<?= base_url('manage-room') ?>" class="block">
                        <div class="backdrop-blur-sm bg-gray-100 bg-opacity-70 border-2 border-gray-200 text-gray-800 p-4 rounded-lg shadow-sm hover:shadow-md flex flex-col items-center justify-center h-32 relative overflow-hidden">
                           <div class="relative z-10 flex flex-col items-center">
                                <div class="mb-3 text-green-500 opacity-80">
                                    <i class="fas fa-search text-2xl"></i>
                                </div>
                                <span class="text-sm font-medium text-center">Search Rooms</span>
                            </div>
                        </div>
                    </a>
                </div>
                
                <!-- Manage Tenant -->
                <div class="group cursor-pointer transform transition-all duration-300 hover:-translate-y-1">
                    <a href="<?= base_url('manage-tenant') ?>" class="block">
                        <div class="backdrop-blur-sm bg-gray-100 bg-opacity-70 border-2 border-gray-200 text-gray-800 p-4 rounded-lg shadow-sm hover:shadow-md flex flex-col items-center justify-center h-32 relative overflow-hidden">
                            <div class="relative z-10 flex flex-col items-center">
                                <div class="mb-3 text-purple-500 opacity-80">
                                    <i class="fas fa-users text-2xl"></i>
                                </div>
                                <span class="text-sm font-medium text-center">Manage Tenant</span>
                            </div>
                        </div>
                    </a>
                </div>
                
                <!-- Update Room Maintenance -->
                <div class="group cursor-pointer transform transition-all duration-300 hover:-translate-y-1">
                    <a href="<?= base_url('maintenance') ?>" class="block">
                        <div class="backdrop-blur-sm bg-gray-100 bg-opacity-70 border-2 border-gray-200 text-gray-800 p-4 rounded-lg shadow-sm hover:shadow-md flex flex-col items-center justify-center h-32 relative overflow-hidden">
                            <div class="relative z-10 flex flex-col items-center">
                                <div class="mb-3 text-red-500 opacity-80">
                                    <i class="fas fa-tools text-2xl"></i>
                                </div>
                                <span class="text-sm font-medium text-center">Room Maintenance</span>
                            </div>
                        </div>
                    </a>
                </div>
                
                <!-- Generate Report -->
                <div class="group cursor-pointer transform transition-all duration-300 hover:-translate-y-1">
                    <a href="<?= base_url('generate-report') ?>" class="block">
                        <div class="backdrop-blur-sm bg-gray-100 bg-opacity-70 border-2 border-gray-200 text-gray-800 p-4 rounded-lg shadow-sm hover:shadow-md flex flex-col items-center justify-center h-32 relative overflow-hidden">
                            <div class="relative z-10 flex flex-col items-center">
                                <div class="mb-3 text-yellow-500 opacity-80">
                                    <i class="fas fa-chart-bar text-2xl"></i>
                                </div>
                                <span class="text-sm font-medium text-center">Generate Report</span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="card basic-card bg-white shadow-md rounded-lg p-6 h-full flex-grow">
            <h2 class="text-xl font-bold mb-4 flex items-center justify-between">
                <span>Recent Activity</span>
                <span class="activity-badge text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-full">Last Activity: Today, 2:37 PM</span>
            </h2>
            <div class="overflow-y-auto" style="height: 300px;">
                <!-- Timeline container with styled connection line -->
                <div class="timeline-container relative pl-6 before:content-[''] before:absolute before:left-[20px] before:top-4 before:bottom-2 before:w-0.5 before:bg-gradient-to-b before:from-green-300 before:via-purple-300 before:to-blue-300 before:opacity-70">
                    <!-- Activity Items -->
                    <div class="space-y-5 pt-1 pb-2">
                        <!-- Activity 1 -->
                        <div class="timeline-item relative rounded-lg p-3 bg-gradient-to-r from-white to-gray-50 border border-gray-100">
                            <!-- Colored dot -->
                            <div class="absolute -left-6 top-4 w-3 h-3 bg-green-500 rounded-full shadow-sm z-10"></div>
                            <div class="flex justify-between items-start">
                                <div class="flex items-start">
                                    <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center mr-3 shadow-sm border border-green-200">
                                        <i class="fas fa-sign-in-alt text-green-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-800">Check-in: Room 101</p>
                                        <p class="text-xs text-gray-500 mt-0.5">John Smith has checked in</p>
                                    </div>
                                </div>
                                <span class="text-xs text-gray-400 bg-gray-50 px-2 py-1 rounded-full">11:32 AM</span>
                            </div>
                        </div>
                        
                        <!-- Activity 2 -->
                        <div class="timeline-item relative rounded-lg p-3 bg-gradient-to-r from-white to-gray-50 border border-gray-100">
                            <!-- Colored dot -->
                            <div class="absolute -left-6 top-4 w-3 h-3 bg-red-500 rounded-full shadow-sm z-10"></div>
                            <div class="flex justify-between items-start">
                                <div class="flex items-start">
                                    <div class="h-10 w-10 rounded-full bg-red-100 flex items-center justify-center mr-3 shadow-sm border border-red-200">
                                        <i class="fas fa-sign-out-alt text-red-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-800">Check-out: Room 102</p>
                                        <p class="text-xs text-gray-500 mt-0.5">Jane Cooper has checked out</p>
                                    </div>
                                </div>
                                <span class="text-xs text-gray-400 bg-gray-50 px-2 py-1 rounded-full">10:15 AM</span>
                            </div>
                        </div>
                        
                        <!-- Activity 3 -->
                        <div class="timeline-item relative rounded-lg p-3 bg-gradient-to-r from-white to-gray-50 border border-gray-100">
                            <!-- Colored dot -->
                            <div class="absolute -left-6 top-4 w-3 h-3 bg-yellow-500 rounded-full shadow-sm z-10"></div>
                            <div class="flex justify-between items-start">
                                <div class="flex items-start">
                                    <div class="h-10 w-10 rounded-full bg-yellow-100 flex items-center justify-center mr-3 shadow-sm border border-yellow-200">
                                        <i class="fas fa-tools text-yellow-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-800">Maintenance: Room 103</p>
                                        <p class="text-xs text-gray-500 mt-0.5">Plumbing issue reported</p>
                                    </div>
                                </div>
                                <span class="text-xs text-gray-400 bg-gray-50 px-2 py-1 rounded-full">9:45 AM</span>
                            </div>
                        </div>
                        
                        <!-- Activity 4 -->
                        <div class="timeline-item relative rounded-lg p-3 bg-gradient-to-r from-white to-gray-50 border border-gray-100">
                            <!-- Colored dot -->
                            <div class="absolute -left-6 top-4 w-3 h-3 bg-blue-500 rounded-full shadow-sm z-10"></div>
                            <div class="flex justify-between items-start">
                                <div class="flex items-start">
                                    <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center mr-3 shadow-sm border border-blue-200">
                                        <i class="fas fa-money-bill-wave text-blue-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-800">Payment Received: Room 201</p>
                                        <p class="text-xs text-gray-500 mt-0.5">Monthly rent payment processed</p>
                                    </div>
                                </div>
                                <span class="text-xs text-gray-400 bg-gray-50 px-2 py-1 rounded-full">8:20 AM</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
