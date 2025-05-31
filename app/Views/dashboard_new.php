<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="<?= base_url('css/floorplan.css') ?>">
<link rel="stylesheet" href="<?= base_url('css/index/index-main.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php if (isset($pageTitle)): ?>
<h1 class="text-2xl font-bold mb-4 text-gray-700 dark-mode-text tracking-wide"><?= esc($pageTitle) ?></h1>
<?php else: ?>
<h1 class="text-2xl font-bold mb-4 text-gray-700 dark-mode-text tracking-wide">Welcome, <?= esc($username) ?>.</h1>
<?php endif; ?>

<!-- Overview Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
    <!-- Card 1 - Available Rooms -->
    <div class="card expandable-card">
        <div class="card-content" onclick="toggleDetails('details1')">
            <i class="fas fa-chevron-down absolute top-1/2 right-4 transform -translate-y-1/2 text-gray-400"></i>
            <h2 class="text-xl font-bold mb-4">Available Rooms</h2>
            <p class="text-2xl font-bold text-blue-400"><?= esc($availableRooms) ?></p>
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
            <p class="text-2xl font-bold text-yellow-500"><?= esc($occupiedRooms) ?></p>
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
            <p class="text-2xl font-bold text-green-500"><?= esc($availableBedspaces['total']) > 0 ? count($availableBedspaces['byType']) : '0' ?></p>
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
            <p class="text-2xl font-bold text-red-500"><?= $roomsUnderMaintenance > 0 ? esc($roomsUnderMaintenance) : '-' ?></p>
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
                        <div class="font-medium">Room <?= esc($maintenanceSchedule['lastMaintenance']['room']) ?></div>
                        <div class="text-gray-500 text-xs"><?= esc($maintenanceSchedule['lastMaintenance']['daysAgo']) ?> days ago</div>
                    </div>
                    <div class="bg-gray-50 p-1.5 rounded">
                        <div class="text-gray-600 mb-0.5">Next Scheduled:</div>
                        <div class="font-medium">Room <?= esc($maintenanceSchedule['nextScheduled']['room']) ?></div>
                        <div class="text-gray-500 text-xs">in <?= esc($maintenanceSchedule['nextScheduled']['daysAhead']) ?> days</div>
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
            <p class="text-2xl font-bold text-red-500"><?= esc($roomsBlocked) ?></p>
        </div>
        <div id="details5" class="details">
            <div class="p-3 text-xs">
                <div class="space-y-1.5">
                    <?php foreach ($blockedDetails as $room): ?>
                    <div class="bg-red-50 p-1.5 rounded flex justify-between items-center">
                        <div class="flex items-center">
                            <i class="fas fa-ban text-red-500 mr-1.5"></i>
                            <span class="font-medium">Room <?= esc($room['room']) ?></span>
                        </div>
                        <span class="text-red-700"><?= esc($room['reason']) ?></span>
                    </div>
                    <?php endforeach; ?>
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
                <span class="activity-badge text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-full">Last Activity: <?= esc($lastActivityTime) ?></span>
            </h2>
            <div class="overflow-y-auto" style="height: 300px;">
                <!-- Timeline container with styled connection line -->
                <div class="timeline-container relative pl-6 before:content-[''] before:absolute before:left-[20px] before:top-4 before:bottom-2 before:w-0.5 before:bg-gradient-to-b before:from-green-300 before:via-purple-300 before:to-blue-300 before:opacity-70">
                    <!-- Activity Items -->
                    <div class="space-y-5 pt-1 pb-2">
                        <?php foreach ($recentActivities as $activity): ?>
                            <?= view('partials/activity_item', [
                                'color' => $activity['color'],
                                'icon' => $activity['icon'],
                                'title' => $activity['title'],
                                'description' => $activity['description'],
                                'time' => $activity['time']
                            ]) ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="mt-4 text-center">
                <button class="px-4 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs font-medium rounded-full transition-colors duration-200" id="viewAllActivityBtn">
                    View All Activity
                </button>
            </div>
        </div>
    </div>
</div>


                    <!-- Info Tables -->
                    <!-- Recent Bookings Card -->
                    <div class="card basic-card bg-white shadow-md rounded-lg p-6 mb-6">
                        <div class="flex justify-between items-center mb-4">
                          <h2 class="text-lg font-semibold text-gray-800">Recent Issue & Clearance</h2>
                          <div class="flex space-x-2">
                            <button class="filter-btn selected">Today</button>
                            <button class="filter-btn">This Week</button>
                            <button class="filter-btn">This Month</button>
                          </div>
                        </div>
                        
                        <!-- Card Slider Container -->
                        <div class="relative mb-2">
                          <!-- Previous Button -->
                          <button id="issuePrevButton" class="absolute left-0 top-1/2 transform -translate-y-1/2 z-10 bg-white shadow-md border border-gray-200 text-gray-600 hover:text-blue-500 hover:border-blue-300 transition-all p-2 disabled:opacity-50 disabled:cursor-not-allowed" style="left: -10px;" disabled>
                            <i class="fas fa-chevron-left"></i>
                          </button>
                          
                          <!-- Cards Container with overflow hidden -->
                          <div class="overflow-hidden">
                            <div id="issueCardsContainer" class="flex transition-transform duration-300 ease-in-out">
                              <!-- Issuance Card 1 -->
                              <div class="issue-card flex-shrink-0 w-full md:w-1/3 px-2">
                                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300">
                                  <div class="p-4 border-b border-gray-100">
                                    <div class="flex justify-between items-center">
                                      <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-green-500 dark:text-white">New Issue</span>
                                      <span class="text-xs text-gray-500">Oct 1, 2023</span>
                                    </div>
                                    <div class="mt-2">
                                      <div class="flex items-center">
                                        <div>
                                          <p class="text-sm font-medium text-gray-900">Global Tech</p>
                                          <p class="text-xs text-gray-500">Ahmad Zaki [88159831]</p>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="px-4 py-2 bg-gray-50">
                                    <div class="flex justify-between items-center">
                                      <span class="text-xs text-gray-500">Room 101</span>
                                      <button class="text-xs text-blue-500 hover:text-blue-700 font-medium px-3 py-1 rounded border border-blue-200 hover:bg-blue-50 view-details-btn">
                                        View Details
                                      </button>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              
                              <!-- Issuance Card 2 -->
                              <div class="issue-card flex-shrink-0 w-full md:w-1/3 px-2">
                                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300">
                                  <div class="p-4 border-b border-gray-100">
                                    <div class="flex justify-between items-center">
                                      <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-green-500 dark:text-white">New Issue</span>
                                      <span class="text-xs text-gray-500">Oct 2, 2023</span>
                                    </div>
                                    <div class="mt-2">
                                      <div class="flex items-center">
                                        <div>
                                          <p class="text-sm font-medium text-gray-900">Sri Paandi</p>
                                          <p class="text-xs text-gray-500">Rahul Singh [PA9284617]</p>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="px-4 py-2 bg-gray-50">
                                    <div class="flex justify-between items-center">
                                      <span class="text-xs text-gray-500">Room 202</span>
                                      <button class="text-xs text-blue-500 hover:text-blue-700 font-medium px-3 py-1 rounded border border-blue-200 hover:bg-blue-50 view-details-btn">
                                        View Details
                                      </button>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              
                              <!-- Clearance Card 1 -->
                              <div class="issue-card flex-shrink-0 w-full md:w-1/3 px-2">
                                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300">
                                  <div class="p-4 border-b border-gray-100">
                                    <div class="flex justify-between items-center">
                                      <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-500 dark:text-white">Cleared</span>
                                      <span class="text-xs text-gray-500">Oct 3, 2023</span>
                                    </div>
                                    <div class="mt-2">
                                      <div class="flex items-center">
                                        <div>
                                          <p class="text-sm font-medium text-gray-900">Sri Paandi</p>
                                          <p class="text-xs text-gray-500">Muhd Faiz [88127719]</p>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="px-4 py-2 bg-gray-50">
                                    <div class="flex justify-between items-center">
                                      <span class="text-xs text-gray-500">Room 404</span>
                                      <button class="text-xs text-blue-500 hover:text-blue-700 font-medium px-3 py-1 rounded border border-blue-200 hover:bg-blue-50 view-details-btn">
                                        View Details
                                      </button>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              
                              <!-- Additional issuance card -->
                              <div class="issue-card flex-shrink-0 w-full md:w-1/3 px-2">
                                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300">
                                  <div class="p-4 border-b border-gray-100">
                                    <div class="flex justify-between items-center">
                                      <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-green-500 dark:text-white">New Issue</span>
                                      <span class="text-xs text-gray-500">Oct 3, 2023</span>
                                    </div>
                                    <div class="mt-2">
                                      <div class="flex items-center">
                                        <div>
                                          <p class="text-sm font-medium text-gray-900">East Coast</p>
                                          <p class="text-xs text-gray-500">Wan Ahmad [88159831]</p>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="px-4 py-2 bg-gray-50">
                                    <div class="flex justify-between items-center">
                                      <span class="text-xs text-gray-500">Room 305</span>
                                      <button class="text-xs text-blue-500 hover:text-blue-700 font-medium px-3 py-1 rounded border border-blue-200 hover:bg-blue-50 view-details-btn">
                                        View Details
                                      </button>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              
                              <!-- Additional clearance card -->
                              <div class="issue-card flex-shrink-0 w-full md:w-1/3 px-2">
                                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300">
                                  <div class="p-4 border-b border-gray-100">
                                    <div class="flex justify-between items-center">
                                      <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-500 dark:text-white">Cleared</span>
                                      <span class="text-xs text-gray-500">Oct 4, 2023</span>
                                    </div>
                                    <div class="mt-2">
                                      <div class="flex items-center">
                                        <div>
                                          <p class="text-sm font-medium text-gray-900">Global Tech</p>
                                          <p class="text-xs text-gray-500">Lee Min Ho [88127755]</p>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="px-4 py-2 bg-gray-50">
                                    <div class="flex justify-between items-center">
                                      <span class="text-xs text-gray-500">Room 201</span>
                                      <button class="text-xs text-blue-500 hover:text-blue-700 font-medium px-3 py-1 rounded border border-blue-200 hover:bg-blue-50 view-details-btn">
                                        View Details
                                      </button>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          
                          <!-- Next Button -->
                          <button id="issueNextButton" class="absolute right-0 top-1/2 transform -translate-y-1/2 z-10 bg-white shadow-md border border-gray-200 text-gray-600 hover:text-blue-500 hover:border-blue-300 transition-all p-2" style="right: -10px;">
                            <i class="fas fa-chevron-right"></i>
                          </button>
                        </div>
                        
                        <div class="mt-4 text-center">
                            <button class="px-4 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs font-medium rounded-full transition-colors duration-200" id="viewAllRecordsBtn">
                                View All Records
                            </button>
                        </div>
                      </div>
                      
                      <!-- Admin & Staff Activity Log -->
                      <div class="card basic-card bg-white shadow-md rounded-lg p-6 mb-6">
                        <div class="flex justify-between items-center mb-4">
                          <h2 class="text-lg font-semibold text-gray-800">Admin & Staff Activity Log</h2>
                          <div class="flex items-center">
                            <div class="relative">
                              <input type="text" placeholder="Search activities..." class="text-xs bg-gray-100 border border-gray-200 rounded-md pl-8 pr-2 py-1">
                              <i class="fas fa-search absolute left-2 top-1/2 transform -translate-y-1/2 text-gray-400 text-xs"></i>
                            </div>
                          </div>
                        </div>
                        
                        <div class="overflow-x-auto">
                          <div class="inline-block min-w-full">
                            <div class="overflow-hidden rounded-lg border border-gray-200">
                              <!-- Table Header -->
                              <div class="bg-gray-50 px-4 py-3 flex border-b border-gray-200">
                                <div class="w-1/4 flex items-center">
                                  <span class="text-xs font-medium text-gray-700 mr-2">Staff Member</span>
                                  <i class="fas fa-sort text-gray-400 text-xs"></i>
                                </div>
                                <div class="w-1/3 flex items-center">
                                  <span class="text-xs font-medium text-gray-700 mr-2">Activity</span>
                                  <i class="fas fa-sort text-gray-400 text-xs"></i>
                                </div>
                                <div class="w-1/5 flex items-center justify-end">
                                  <span class="text-xs font-medium text-gray-700 mr-2">Date & Time</span>
                                  <i class="fas fa-sort-down text-gray-700 text-xs"></i>
                                </div>
                                <div class="w-1/5 flex items-center justify-end">
                                  <span class="text-xs font-medium text-gray-700">Actions</span>
                                </div>
                              </div>
                              
                              <!-- Log Item 1 -->
                              <div class="bg-white px-4 py-3 flex border-b border-gray-200">
                                <div class="w-1/4 flex items-center">
                                  <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center mr-2">
                                    <span class="text-indigo-600 font-medium">AA</span>
                                  </div>
                                  <div>
                                    <p class="text-sm font-medium text-gray-900">Admin Aiman</p>
                                    <p class="text-xs text-gray-500">Administrator</p>
                                  </div>
                                </div>
                                <div class="w-1/3">
                                  <p class="text-sm text-gray-800">Assigned Room 103 to John Doe</p>
                                </div>
                                <div class="w-1/5 text-right">
                                  <p class="text-xs text-gray-500">Oct 1, 2023 • 10:25 AM</p>
                                </div>
                                <div class="w-1/5 flex items-center justify-end space-x-4">
                                  <button class="records-view-btn view-details-btn">
                                    <i class="fas fa-info-circle text-sm text-gray-600"></i>
                                  </button>
                                  <button class="records-view-btn view-details-btn">
                                    <i class="fas fa-ellipsis-v text-sm text-gray-600"></i>
                                  </button>                                  
                                </div>
                              </div>
                              
                              <!-- Log Item 2 -->
                              <div class="bg-white px-4 py-3 flex border-b border-gray-200">
                                <div class="w-1/4 flex items-center">
                                  <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center mr-2">
                                    <span class="text-blue-600 font-medium">SM</span>
                                  </div>
                                  <div>
                                    <p class="text-sm font-medium text-gray-900">Sarah Miller</p>
                                    <p class="text-xs text-gray-500">Staff</p>
                                  </div>
                                </div>
                                <div class="w-1/3">
                                  <p class="text-sm text-gray-800">Marked Room 202 for maintenance</p>
                                </div>
                                <div class="w-1/5 text-right">
                                  <p class="text-xs text-gray-500">Oct 2, 2023 • 2:15 PM</p>
                                </div>
                                <div class="w-1/5 flex items-center justify-end space-x-4">
                                  <button class="records-view-btn view-details-btn">
                                    <i class="fas fa-info-circle text-sm text-gray-600"></i>
                                  </button>
                                  <button class="records-view-btn view-details-btn">
                                    <i class="fas fa-ellipsis-v text-sm text-gray-600"></i>
                                  </button>   
                                </div>
                              </div>
                              
                              <!-- Log Item 3 -->
                              <div class="bg-white px-4 py-3 flex">
                                <div class="w-1/4 flex items-center">
                                  <div class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center mr-2">
                                    <span class="text-green-600 font-medium">RJ</span>
                                  </div>
                                  <div>
                                    <p class="text-sm font-medium text-gray-900">Robert Johnson</p>
                                    <p class="text-xs text-gray-500">Maintenance</p>
                                  </div>
                                </div>
                                <div class="w-1/3">
                                  <p class="text-sm text-gray-800">Completed maintenance for Room 105</p>
                                </div>
                                <div class="w-1/5 text-right">
                                  <p class="text-xs text-gray-500">Oct 3, 2023 • 11:45 AM</p>
                                </div>
                                <div class="w-1/5 flex items-center justify-end space-x-4">
                                  <button class="records-view-btn view-details-btn">
                                    <i class="fas fa-info-circle text-sm text-gray-600"></i>
                                  </button>
                                  <button class="records-view-btn view-details-btn">
                                    <i class="fas fa-ellipsis-v text-sm text-gray-600"></i>
                                  </button>   
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        
                        <div class="mt-4 flex justify-between items-center">
                          <div class="flex items-center">
                            <span class="text-xs text-gray-500">Showing 3 of 24 activities</span>
                          </div>
                          <div class="flex items-center space-x-1">
                            <button class="pagination-button w-8 h-8 flex items-center justify-center rounded-md border border-gray-300 bg-white text-gray-500 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                              <i class="fas fa-chevron-left text-xs"></i>
                            </button>
                            <button class="pagination-button active w-8 h-8 flex items-center justify-center rounded-md border border-gray-300 bg-purple-500 text-white">
                              1
                            </button>
                            <button class="pagination-button w-8 h-8 flex items-center justify-center rounded-md border border-gray-300 bg-white text-gray-700 hover:bg-gray-50">
                              2
                            </button>
                            <button class="pagination-button w-8 h-8 flex items-center justify-center rounded-md border border-gray-300 bg-white text-gray-700 hover:bg-gray-50">
                              3
                            </button>
                            <button class="pagination-button w-8 h-8 flex items-center justify-center rounded-md border border-gray-300 bg-white text-gray-500 hover:bg-gray-50">
                              <i class="fas fa-chevron-right text-xs"></i>
                            </button>
                          </div>
                        </div>
                        
                        <div class="mt-4 text-center">
                          <button id="viewAllStaffActivitiesBtn" class="px-4 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs font-medium rounded-full transition-colors duration-200">
                              View All Staff Activities
                          </button>
                        </div>
                      </div>
                      
                      <!-- Room Category Breakdown -->
                      <div class="card basic-card bg-white shadow-md rounded-lg p-6 mb-6">
                        <div class="flex justify-between items-center mb-4">
                          <h2 class="text-lg font-semibold text-gray-800">Room Category Breakdown</h2>
                          <div class="flex items-center space-x-2">
                            <button class="text-xs px-3 py-1 rounded-md bg-gray-100 text-gray-700 hover:bg-gray-200">
                              <i class="fas fa-download mr-1"></i> Export
                            </button>
                            <button class="text-xs px-3 py-1 rounded-md bg-purple-500 text-white hover:bg-purple-600">
                              <i class="fas fa-chart-pie mr-1"></i> View Details
                            </button>
                          </div>
                        </div>
                        
                        <!-- Card Slider Container -->
                        <div class="relative mb-4">
                          <!-- Previous Button -->
                          <button id="prevButton" class="absolute left-0 top-1/2 transform -translate-y-1/2 z-10 bg-white shadow-md border border-gray-200 text-gray-600 hover:text-purple-500 hover:border-blue-300 transition-all p-2 disabled:opacity-50 disabled:cursor-not-allowed" style="left: -10px;" disabled>
                            <i class="fas fa-chevron-left"></i>
                          </button>
                          
                          <!-- Cards Container with overflow hidden -->
                          <div class="overflow-hidden">
                            <div id="categoryCardsContainer" class="flex transition-transform duration-300 ease-in-out">
                              <!-- Category Card 1 -->
                              <div class="category-card flex-shrink-0 w-full md:w-1/3 px-2">
                                <div class="bg-gradient-to-r from-blue-50 to-blue-100 rounded-lg p-4 border border-blue-200">
                                  <div class="flex justify-between items-center mb-2">
                                    <h3 class="text-sm font-medium text-blue-800">2 Bed Spaces</h3>
                                    <span class="text-xs px-2 py-1 bg-blue-200 text-blue-800 rounded-full">16 Total</span>
                                  </div>
                                  <div class="flex items-center justify-between">
                                    <div>
                                      <div class="flex items-center">
                                        <div class="w-3 h-3 rounded-full bg-green-500 mr-1"></div>
                                        <span class="text-xs text-gray-600">Available: 3 rooms (6 beds)</span>
                                      </div>
                                      <div class="flex items-center mt-1">
                                        <div class="w-3 h-3 rounded-full bg-yellow-500 mr-1"></div>
                                        <span class="text-xs text-gray-600">Occupied: 13 rooms (26 beds)</span>
                                      </div>
                                    </div>
                                    <div class="h-16 w-16 relative">
                                      <svg viewBox="0 0 36 36" class="h-16 w-16">
                                        <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#E5E7EB" stroke-width="3" />
                                        <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#FBBF24" stroke-width="3" stroke-dasharray="81, 100" />
                                        <text x="18" y="19" class="text-xs font-medium" text-anchor="middle" dominant-baseline="middle" fill="#4B5563" style="font-size: 10px;">81%</text>
                                      </svg>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              
                              <!-- Category Card 2 -->
                              <div class="category-card flex-shrink-0 w-full md:w-1/3 px-2">
                                <div class="bg-gradient-to-r from-purple-50 to-purple-100 rounded-lg p-4 border border-purple-200">
                                  <div class="flex justify-between items-center mb-2">
                                    <h3 class="text-sm font-medium text-purple-800">3 Bed Spaces</h3>
                                    <span class="text-xs px-2 py-1 bg-purple-200 text-purple-800 rounded-full">4 Total</span>
                                  </div>
                                  <div class="flex items-center justify-between">
                                    <div>
                                      <div class="flex items-center">
                                        <div class="w-3 h-3 rounded-full bg-green-500 mr-1"></div>
                                        <span class="text-xs text-gray-600">Available: 0 rooms (0 beds)</span>
                                      </div>
                                      <div class="flex items-center mt-1">
                                        <div class="w-3 h-3 rounded-full bg-yellow-500 mr-1"></div>
                                        <span class="text-xs text-gray-600">Occupied: 4 rooms (12 beds)</span>
                                      </div>
                                    </div>
                                    <div class="h-16 w-16 relative">
                                      <svg viewBox="0 0 36 36" class="h-16 w-16">
                                        <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#E5E7EB" stroke-width="3" />
                                        <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#FBBF24" stroke-width="3" stroke-dasharray="100, 100" />
                                        <text x="18" y="19" class="text-xs font-medium" text-anchor="middle" dominant-baseline="middle" fill="#4B5563" style="font-size: 10px;">100%</text>
                                      </svg>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              
                              <!-- Category Card 3 -->
                              <div class="category-card flex-shrink-0 w-full md:w-1/3 px-2">
                                <div class="bg-gradient-to-r from-green-50 to-green-100 rounded-lg p-4 border border-green-200">
                                  <div class="flex justify-between items-center mb-2">
                                    <h3 class="text-sm font-medium text-green-800">4 Bed Spaces</h3>
                                    <span class="text-xs px-2 py-1 bg-green-200 text-green-800 rounded-full">11 Total</span>
                                  </div>
                                  <div class="flex items-center justify-between">
                                    <div>
                                      <div class="flex items-center">
                                        <div class="w-3 h-3 rounded-full bg-green-500 mr-1"></div>
                                        <span class="text-xs text-gray-600">Available: 4 rooms (16 beds)</span>
                                      </div>
                                      <div class="flex items-center mt-1">
                                        <div class="w-3 h-3 rounded-full bg-yellow-500 mr-1"></div>
                                        <span class="text-xs text-gray-600">Occupied: 7 rooms (28 beds)</span>
                                      </div>
                                    </div>
                                    <div class="h-16 w-16 relative">
                                      <svg viewBox="0 0 36 36" class="h-16 w-16">
                                        <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#E5E7EB" stroke-width="3" />
                                        <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#FBBF24" stroke-width="3" stroke-dasharray="64, 100" />
                                        <text x="18" y="19" class="text-xs font-medium" text-anchor="middle" dominant-baseline="middle" fill="#4B5563" style="font-size: 10px;">64%</text>
                                      </svg>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              
                              <!-- Category Card 4 -->
                              <div class="category-card flex-shrink-0 w-full md:w-1/3 px-2">
                                <div class="bg-gradient-to-r from-red-50 to-red-100 rounded-lg p-4 border border-red-200">
                                  <div class="flex justify-between items-center mb-2">
                                    <h3 class="text-sm font-medium text-red-800">5 Bed Spaces</h3>
                                    <span class="text-xs px-2 py-1 bg-red-200 text-red-800 rounded-full">39 Total</span>
                                  </div>
                                  <div class="flex items-center justify-between">
                                    <div>
                                      <div class="flex items-center">
                                        <div class="w-3 h-3 rounded-full bg-green-500 mr-1"></div>
                                        <span class="text-xs text-gray-600">Available: 17 rooms (85 beds)</span>
                                      </div>
                                      <div class="flex items-center mt-1">
                                        <div class="w-3 h-3 rounded-full bg-yellow-500 mr-1"></div>
                                        <span class="text-xs text-gray-600">Occupied: 22 rooms (110 beds)</span>
                                      </div>
                                    </div>
                                    <div class="h-16 w-16 relative">
                                      <svg viewBox="0 0 36 36" class="h-16 w-16">
                                        <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#E5E7EB" stroke-width="3" />
                                        <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#FBBF24" stroke-width="3" stroke-dasharray="56, 100" />
                                        <text x="18" y="19" class="text-xs font-medium" text-anchor="middle" dominant-baseline="middle" fill="#4B5563" style="font-size: 10px;">56%</text>
                                      </svg>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              
                              <!-- Category Card 5 -->
                              <div class="category-card flex-shrink-0 w-full md:w-1/3 px-2">
                                <div class="bg-gradient-to-r from-amber-50 to-amber-100 rounded-lg p-4 border border-amber-200">
                                  <div class="flex justify-between items-center mb-2">
                                    <h3 class="text-sm font-medium text-amber-800">6 Bed Spaces</h3>
                                    <span class="text-xs px-2 py-1 bg-amber-200 text-amber-800 rounded-full">13 Total</span>
                                  </div>
                                  <div class="flex items-center justify-between">
                                    <div>
                                      <div class="flex items-center">
                                        <div class="w-3 h-3 rounded-full bg-green-500 mr-1"></div>
                                        <span class="text-xs text-gray-600">Available: 8 rooms (48 beds)</span>
                                      </div>
                                      <div class="flex items-center mt-1">
                                        <div class="w-3 h-3 rounded-full bg-yellow-500 mr-1"></div>
                                        <span class="text-xs text-gray-600">Occupied: 5 rooms (30 beds)</span>
                                      </div>
                                    </div>
                                    <div class="h-16 w-16 relative">
                                      <svg viewBox="0 0 36 36" class="h-16 w-16">
                                        <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#E5E7EB" stroke-width="3" />
                                        <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#FBBF24" stroke-width="3" stroke-dasharray="38, 100" />
                                        <text x="18" y="19" class="text-xs font-medium" text-anchor="middle" dominant-baseline="middle" fill="#4B5563" style="font-size: 10px;">38%</text>
                                      </svg>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          
                          <!-- Next Button -->
                          <button id="nextButton" class="absolute right-0 top-1/2 transform -translate-y-1/2 z-10 bg-white shadow-md border border-gray-200 text-gray-600 hover:text-purple-500 hover:border-blue-300 transition-all p-2" style="right: -10px;">
                            <i class="fas fa-chevron-right"></i>
                          </button>
                        </div>
                        
                        <!-- Room Category Details -->
                        <div class="overflow-x-auto">
                          <div class="inline-block min-w-full">
                            <div class="overflow-hidden rounded-lg border border-gray-200">
                              <!-- Table Header -->
                              <div class="bg-gray-50 px-4 py-3 flex items-center border-b border-gray-200">
                                <div class="flex items-center w-1/6">
                                  <span class="text-xs font-medium text-gray-700 mr-2">Room Type</span>
                                  <i class="fas fa-sort text-gray-400 text-xs"></i>
                                </div>
                                <div class="flex items-center justify-center w-1/12">
                                  <span class="text-xs font-medium text-gray-700 mr-2">Total Rooms</span>
                                  <i class="fas fa-sort text-gray-400 text-xs"></i>
                                </div>
                                <div class="flex items-center justify-center w-1/12">
                                  <span class="text-xs font-medium text-gray-700 mr-2">Empty</span>
                                  <i class="fas fa-sort text-gray-400 text-xs"></i>
                                </div>
                                <div class="flex items-center justify-center w-1/12 border-r border-gray-200 pr-4">
                                  <span class="text-xs font-medium text-gray-700 mr-2">Occupied</span>
                                  <i class="fas fa-sort text-gray-400 text-xs"></i>
                                </div>
                                <div class="flex items-center justify-center w-1/6 pl-4">
                                  <span class="text-xs font-medium text-gray-700 mr-2">Available Bedspaces</span>
                                  <i class="fas fa-sort text-gray-400 text-xs"></i>
                                </div>
                                <div class="flex items-center justify-center w-1/6">
                                  <span class="text-xs font-medium text-gray-700 mr-2">Total Bedspaces</span>
                                  <i class="fas fa-sort text-gray-400 text-xs"></i>
                                </div>
                                <div class="flex items-center w-1/4">
                                  <span class="text-xs font-medium text-gray-700 mr-2">Occupancy Rate</span>
                                  <i class="fas fa-sort-down text-gray-700 text-xs"></i>
                                </div>
                              </div>
                              
                              <!-- Room Item 1 -->
                              <div class="bg-white px-4 py-3 flex items-center justify-between border-b border-gray-200 hover:bg-gray-50 transition-colors duration-150">
                                <div class="flex items-center w-1/6">
                                  <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center mr-3" title="2-Person Room">
                                    <i class="fas fa-bed text-blue-600 text-sm"></i>
                                  </div>
                                  <p class="text-sm font-medium text-gray-900">2 Bed Spaces</p>
                                </div>
                                <div class="w-1/12 text-center">
                                  <p class="text-sm text-gray-800">16</p>
                                </div>
                                <div class="w-1/12 text-center">
                                  <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">3</span>
                                </div>
                                <div class="w-1/12 text-center border-r border-gray-200 pr-4">
                                  <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">13</span>
                                </div>
                                <div class="w-1/6 text-center pl-4">
                                  <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">6</span>
                                </div>
                                <div class="w-1/6 text-center">
                                  <p class="text-sm text-gray-800">32</p>
                                </div>
                                <div class="w-1/4">
                                  <div class="flex items-center">
                                    <div class="w-24 bg-gray-200 rounded-full h-1.5 mr-2">
                                      <div class="bg-purple-500 h-1.5 rounded-full" style="width: 81%"></div>
                                    </div>
                                    <span class="text-sm text-gray-500">81%</span>
                                  </div>
                                </div>
                              </div>
                              
                              <!-- Room Item 2 -->
                              <div class="bg-white px-4 py-3 flex items-center justify-between border-b border-gray-200 hover:bg-gray-50 transition-colors duration-150">
                                <div class="flex items-center w-1/6">
                                  <div class="h-8 w-8 rounded-full bg-purple-100 flex items-center justify-center mr-3" title="3-Person Room">
                                    <i class="fas fa-bed text-purple-600 text-sm"></i>
                                  </div>
                                  <p class="text-sm font-medium text-gray-900">3 Bed Spaces</p>
                                </div>
                                <div class="w-1/12 text-center">
                                  <p class="text-sm text-gray-800">4</p>
                                </div>
                                <div class="w-1/12 text-center">
                                  <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">0</span>
                                </div>
                                <div class="w-1/12 text-center border-r border-gray-200 pr-4">
                                  <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">4</span>
                                </div>
                                <div class="w-1/6 text-center pl-4">
                                  <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">0</span>
                                </div>
                                <div class="w-1/6 text-center">
                                  <p class="text-sm text-gray-800">12</p>
                                </div>
                                <div class="w-1/4">
                                  <div class="flex items-center">
                                    <div class="w-24 bg-gray-200 rounded-full h-1.5 mr-2">
                                      <div class="bg-purple-500 h-1.5 rounded-full" style="width: 100%"></div>
                                    </div>
                                    <span class="text-sm text-gray-500">100%</span>
                                  </div>
                                </div>
                              </div>
                              
                              <!-- Room Item 3 -->
                              <div class="bg-white px-4 py-3 flex items-center justify-between border-b border-gray-200 hover:bg-gray-50 transition-colors duration-150">
                                <div class="flex items-center w-1/6">
                                  <div class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center mr-3" title="4-Person Room">
                                    <i class="fas fa-bed text-green-600 text-sm"></i>
                                  </div>
                                  <p class="text-sm font-medium text-gray-900">4 Bed Spaces</p>
                                </div>
                                <div class="w-1/12 text-center">
                                  <p class="text-sm text-gray-800">11</p>
                                </div>
                                <div class="w-1/12 text-center">
                                  <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">4</span>
                                </div>
                                <div class="w-1/12 text-center border-r border-gray-200 pr-4">
                                  <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">7</span>
                                </div>
                                <div class="w-1/6 text-center pl-4">
                                  <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">16</span>
                                </div>
                                <div class="w-1/6 text-center">
                                  <p class="text-sm text-gray-800">44</p>
                                </div>
                                <div class="w-1/4">
                                  <div class="flex items-center">
                                    <div class="w-24 bg-gray-200 rounded-full h-1.5 mr-2">
                                      <div class="bg-purple-500 h-1.5 rounded-full" style="width: 64%"></div>
                                    </div>
                                    <span class="text-sm text-gray-500">64%</span>
                                  </div>
                                </div>
                              </div>
                              
                              <!-- Room Item 4 -->
                              <div class="bg-white px-4 py-3 flex items-center justify-between border-b border-gray-200 hover:bg-gray-50 transition-colors duration-150">
                                <div class="flex items-center w-1/6">
                                  <div class="h-8 w-8 rounded-full bg-red-100 flex items-center justify-center mr-3" title="5-Person Room">
                                    <i class="fas fa-bed text-red-600 text-sm"></i>
                                  </div>
                                  <p class="text-sm font-medium text-gray-900">5 Bed Spaces</p>
                                </div>
                                <div class="w-1/12 text-center">
                                  <p class="text-sm text-gray-800">39</p>
                                </div>
                                <div class="w-1/12 text-center">
                                  <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">17</span>
                                </div>
                                <div class="w-1/12 text-center border-r border-gray-200 pr-4">
                                  <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">22</span>
                                </div>
                                <div class="w-1/6 text-center pl-4">
                                  <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">85</span>
                                </div>
                                <div class="w-1/6 text-center">
                                  <p class="text-sm text-gray-800">195</p>
                                </div>
                                <div class="w-1/4">
                                  <div class="flex items-center">
                                    <div class="w-24 bg-gray-200 rounded-full h-1.5 mr-2">
                                      <div class="bg-purple-500 h-1.5 rounded-full" style="width: 56%"></div>
                                    </div>
                                    <span class="text-sm text-gray-500">56%</span>
                                  </div>
                                </div>
                              </div>
                              
                              <!-- Room Item 5 -->
                              <div class="bg-white px-4 py-3 flex items-center justify-between border-b border-gray-200 hover:bg-gray-50 transition-colors duration-150">
                                <div class="flex items-center w-1/6">
                                  <div class="h-8 w-8 rounded-full bg-amber-100 flex items-center justify-center mr-3" title="6-Person Room">
                                    <i class="fas fa-bed text-amber-600 text-sm"></i>
                                  </div>
                                  <p class="text-sm font-medium text-gray-900">6 Bed Spaces</p>
                                </div>
                                <div class="w-1/12 text-center">
                                  <p class="text-sm text-gray-800">13</p>
                                </div>
                                <div class="w-1/12 text-center">
                                  <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">8</span>
                                </div>
                                <div class="w-1/12 text-center border-r border-gray-200 pr-4">
                                  <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">5</span>
                                </div>
                                <div class="w-1/6 text-center pl-4">
                                  <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">48</span>
                                </div>
                                <div class="w-1/6 text-center">
                                  <p class="text-sm text-gray-800">78</p>
                                </div>
                                <div class="w-1/4">
                                  <div class="flex items-center">
                                    <div class="w-24 bg-gray-200 rounded-full h-1.5 mr-2">
                                      <div class="bg-purple-500 h-1.5 rounded-full" style="width: 38%"></div>
                                    </div>
                                    <span class="text-sm text-gray-500">38%</span>
                                  </div>
                                </div>
                              </div>
                              
                              <!-- Total Row -->
                              <div class="bg-gray-50 px-4 py-3 flex items-center justify-between">
                                <div class="flex items-center w-1/6">
                                  <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center mr-3" title="Total for all rooms">
                                    <i class="fas fa-calculator text-gray-600 text-sm"></i>
                                  </div>
                                  <p class="text-sm font-medium text-gray-900">Total</p>
                                </div>
                                <div class="w-1/12 text-center">
                                  <p class="text-sm font-medium text-gray-800">83</p>
                                </div>
                                <div class="w-1/12 text-center">
                                  <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">32</span>
                                </div>
                                <div class="w-1/12 text-center border-r border-gray-200 pr-4">
                                  <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">51</span>
                                </div>
                                <div class="w-1/6 text-center pl-4">
                                  <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">155</span>
                                </div>
                                <div class="w-1/6 text-center">
                                  <p class="text-sm font-medium text-gray-800">361</p>
                                </div>
                                <div class="w-1/4">
                                  <div class="flex items-center">
                                    <div class="w-24 bg-gray-200 rounded-full h-2.5 mr-2">
                                      <div class="bg-purple-500 h-2.5 rounded-full" style="width: 61%"></div>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700">61%</span>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        
                        <!-- Pagination Controls -->
                        <div class="mt-4 flex justify-between items-center">
                          <div class="flex items-center">
                            <span class="text-xs text-gray-500">Showing all 6 room types</span>
                          </div>
                        </div>
                      </div>
                    </div>

<!-- Activity Modal -->
<div id="activityModal" class="fixed inset-0 z-[100] hidden flex items-center justify-center">
    <div class="rounded-lg shadow-xl max-w-6xl w-full mx-4 overflow-hidden max-h-[90vh] flex bg-white activity-modal-bg">
        <!-- Activity List Panel -->
        <div class="flex-1 flex flex-col">
            <div class="border-b p-4 bg-gray-50">
                <div class="modal-header-with-back flex justify-between items-center">
                    <h3 class="text-xl font-semibold">Activity History</h3>
                    <button id="closeActivityModal" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="flex flex-col flex-1 overflow-hidden">
                <div class="p-6 overflow-y-auto flex-1">
                    <!-- Activity Filters -->
                    <div class="flex justify-between items-center mb-4">
                        <div class="flex space-x-2">
                            <button class="filter-btn selected">All Activities</button>
                            <button class="filter-btn">Check-ins</button>
                            <button class="filter-btn">Check-outs</button>
                            <button class="filter-btn">Maintenance</button>
                            <button class="filter-btn">Payments</button>
                        </div>
                        <div class="flex space-x-2">
                            <select class="text-xs bg-gray-100 border border-gray-200 rounded-md py-1 px-2">
                                <option>Today</option>
                                <option>Last 7 days</option>
                                <option>Last 30 days</option>
                                <option>All time</option>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Activity Timeline -->
                    <div class="timeline-container relative pl-6 before:content-[''] before:absolute before:left-[20px] before:top-4 before:bottom-2 before:w-0.5 before:bg-gradient-to-b before:from-green-300 before:via-purple-300 before:to-blue-300 before:opacity-70">
                        <div class="space-y-5 pt-1 pb-2">
                            <!-- Today's Activities -->
                            <div class="border-b border-gray-100 pb-2 mb-4">
                                <h4 class="text-sm font-medium text-gray-500 mb-3 ml-2">Today</h4>
                                
                                <!-- Activity Item 1 -->
                                <div class="timeline-item relative rounded-lg p-3 bg-gradient-to-r from-white to-gray-50 border border-gray-100 hover:bg-gray-100 cursor-pointer activity-item" data-activity-id="1">
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
                                
                                <!-- Activity Item 2 -->
                                <div class="timeline-item relative rounded-lg p-3 bg-gradient-to-r from-white to-gray-50 border border-gray-100 hover:bg-gray-100 cursor-pointer activity-item" data-activity-id="2">
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
                                
                                <!-- Activity Item 3 -->
                                <div class="timeline-item relative rounded-lg p-3 bg-gradient-to-r from-white to-gray-50 border border-gray-100 hover:bg-gray-100 cursor-pointer activity-item" data-activity-id="3">
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
                            </div>
                            
                            <!-- Yesterday's Activities -->
                            <div class="border-b border-gray-100 pb-2 mb-4">
                                <h4 class="text-sm font-medium text-gray-500 mb-3 ml-2">Yesterday</h4>
                                
                                <!-- Activity Item 4 -->
                                <div class="timeline-item relative rounded-lg p-3 bg-gradient-to-r from-white to-gray-50 border border-gray-100 hover:bg-gray-100 cursor-pointer activity-item" data-activity-id="4">
                                    <div class="absolute -left-6 top-4 w-3 h-3 bg-purple-500 rounded-full shadow-sm z-10"></div>
                                    <div class="flex justify-between items-start">
                                        <div class="flex items-start">
                                            <div class="h-10 w-10 rounded-full bg-purple-100 flex items-center justify-center mr-3 shadow-sm border border-purple-200">
                                                <i class="fas fa-calendar-alt text-purple-600"></i>
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-gray-800">New Booking: Room 305</p>
                                                <p class="text-xs text-gray-500 mt-0.5">Reservation for next week</p>
                                            </div>
                                        </div>
                                        <span class="text-xs text-gray-400 bg-gray-50 px-2 py-1 rounded-full">4:30 PM</span>
                                    </div>
                                </div>
                                
                                <!-- Activity Item 5 -->
                                <div class="timeline-item relative rounded-lg p-3 bg-gradient-to-r from-white to-gray-50 border border-gray-100 hover:bg-gray-100 cursor-pointer activity-item" data-activity-id="5">
                                    <div class="absolute -left-6 top-4 w-3 h-3 bg-green-500 rounded-full shadow-sm z-10"></div>
                                    <div class="flex justify-between items-start">
                                        <div class="flex items-start">
                                            <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center mr-3 shadow-sm border border-green-200">
                                                <i class="fas fa-tools text-green-600"></i>
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-gray-800">Maintenance Completed: Room 202</p>
                                                <p class="text-xs text-gray-500 mt-0.5">Electrical issues fixed</p>
                                            </div>
                                        </div>
                                        <span class="text-xs text-gray-400 bg-gray-50 px-2 py-1 rounded-full">2:15 PM</span>
                                    </div>
                                </div>
                            </div>

                            <!-- 04.05.2025's Activities -->
                            <div class="border-b border-gray-100 pb-2 mb-4">
                                <h4 class="text-sm font-medium text-gray-500 mb-3 ml-2">04.05.2025</h4>
                                
                                <!-- Activity Item 6 -->
                                <div class="timeline-item relative rounded-lg p-3 bg-gradient-to-r from-white to-gray-50 border border-gray-100 hover:bg-gray-100 cursor-pointer activity-item" data-activity-id="6">
                                    <div class="absolute -left-6 top-4 w-3 h-3 bg-purple-500 rounded-full shadow-sm z-10"></div>
                                    <div class="flex justify-between items-start">
                                        <div class="flex items-start">
                                            <div class="h-10 w-10 rounded-full bg-purple-100 flex items-center justify-center mr-3 shadow-sm border border-purple-200">
                                                <i class="fas fa-calendar-alt text-purple-600"></i>
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-gray-800">New Booking: Room 305</p>
                                                <p class="text-xs text-gray-500 mt-0.5">Reservation for next week</p>
                                            </div>
                                        </div>
                                        <span class="text-xs text-gray-400 bg-gray-50 px-2 py-1 rounded-full">4:30 PM</span>
                                    </div>
                                </div>
                                
                                <!-- Activity Item 7 -->
                                <div class="timeline-item relative rounded-lg p-3 bg-gradient-to-r from-white to-gray-50 border border-gray-100 hover:bg-gray-100 cursor-pointer activity-item" data-activity-id="7">
                                    <div class="absolute -left-6 top-4 w-3 h-3 bg-green-500 rounded-full shadow-sm z-10"></div>
                                    <div class="flex justify-between items-start">
                                        <div class="flex items-start">
                                            <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center mr-3 shadow-sm border border-green-200">
                                                <i class="fas fa-tools text-green-600"></i>
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-gray-800">Maintenance Completed: Room 202</p>
                                                <p class="text-xs text-gray-500 mt-0.5">Electrical issues fixed</p>
                                            </div>
                                        </div>
                                        <span class="text-xs text-gray-400 bg-gray-50 px-2 py-1 rounded-full">2:15 PM</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                        
                <!-- Pagination Controls - Updated with footer styling -->
                <div class="border-t border-gray-200 bg-gray-50 p-4 mt-auto pagination-footer">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center">
                            <span class="text-sm text-gray-600 dark-mode-text">Showing <span id="activityStartRecord">1</span> - <span id="activityEndRecord">5</span> of <span id="activityTotalRecords">57</span> activities</span>
                        </div>
                        <div class="flex-1 flex justify-center">
                            <div class="flex items-center space-x-1" id="activityPaginationButtons">
                                <button class="pagination-button w-8 h-8 flex items-center justify-center rounded-md border border-gray-300 bg-white text-gray-500 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed" id="activityPrevPage" disabled>
                                    <i class="fas fa-chevron-left text-xs"></i>
                                </button>
                                <button class="activity-page-btn pagination-button w-8 h-8 flex items-center justify-center rounded-md border active bg-purple-500 text-white">
                                    1
                                </button>
                                <button class="activity-page-btn pagination-button w-8 h-8 flex items-center justify-center rounded-md border bg-white text-gray-700 hover:bg-gray-50 border-gray-300">
                                    2
                                </button>
                                <button class="activity-page-btn pagination-button w-8 h-8 flex items-center justify-center rounded-md border bg-white text-gray-700 hover:bg-gray-50 border-gray-300">
                                    3
                                </button>
                                <button class="activity-page-btn pagination-button w-8 h-8 flex items-center justify-center rounded-md border bg-white text-gray-700 hover:bg-gray-50 border-gray-300">
                                    4
                                </button>
                                <button class="activity-page-btn pagination-button w-8 h-8 flex items-center justify-center rounded-md border bg-white text-gray-700 hover:bg-gray-50 border-gray-300">
                                    5
                                </button>
                                <button class="pagination-button w-8 h-8 flex items-center justify-center rounded-md border border-gray-300 bg-white text-gray-500 hover:bg-gray-50" id="activityNextPage">
                                    <i class="fas fa-chevron-right text-xs"></i>
                                </button>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="text-sm text-gray-600">Records per page</span>
                            <select class="border border-gray-300 rounded-lg p-1 text-sm">
                                <option>10</option>
                                <option>25</option>
                                <option selected>50</option>
                                <option>100</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            
        <!-- Activity Details Panel (hidden by default) -->
        <div id="activityDetailsPanel" class="w-0 transition-all duration-300 ease-in-out overflow-visible thin-scrollbar relative">
            <!-- Collapse button - positioned at left edge -->
            <button id="closeActivityDetails" class="absolute left-0 top-0 bottom-0 w-5 flex items-center justify-center text-gray-500 hover:text-gray-700 bg-gray-100 hover:bg-gray-200 border-l border-t border-b border-gray-200 rounded-l transition-all duration-200 z-20 shadow-sm" style="outline: 0 !important; box-shadow: none !important; --tw-ring-offset-shadow: none !important; --tw-ring-shadow: none !important; --tw-ring-width: 0 !important;">
                <i class="fas fa-chevron-left text-sm"></i>
            </button>
            
            <!-- Inner container for actual visible panel content and background -->
            <div id="activityDetailsInnerContentWrapper" class="h-full bg-gray-50 border-l border-gray-200 ml-5 shadow-lg rounded-r-lg overflow-hidden">
                <div class="h-full flex flex-col">
                    <div id="activityDetailsPanelHeader" class="p-4 border-b border-gray-200 flex items-center bg-gray-100">
                        <h3 id="activityDetailsPanelHeaderText" class="text-lg font-semibold text-gray-800">Activity Details</h3>
                    </div>
                    <div class="p-6 overflow-y-auto flex-grow thin-scrollbar">
                        <div id="activityDetailsContent">
                            <!-- Content will be dynamically populated -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Records Modal -->
<div id="recordsModal" class="fixed inset-0 z-[100] hidden flex items-center justify-center">
    <div class="rounded-lg shadow-xl max-w-6xl w-full mx-4 overflow-hidden max-h-[90vh] flex bg-white activity-modal-bg">
        <!-- Records List Panel -->
        <div class="flex-1 flex flex-col">
            <div class="border-b p-4 bg-gray-50">
                <div class="modal-header-with-back flex justify-between items-center">
                    <h3 class="text-xl font-semibold">Issue & Clearance Records</h3>
                    <button id="closeRecordsModal" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="flex flex-col flex-1 overflow-hidden">
                <div class="p-6 overflow-y-auto flex-1">
                    <!-- Records Filters -->
                    <div class="flex justify-between items-center mb-4">
                        <div class="flex space-x-2">
                            <button class="filter-btn selected">All Records</button>
                            <button class="filter-btn">New Issues</button>
                            <button class="filter-btn">Cleared</button>
                            <button class="filter-btn">Pending</button>
                        </div>
                        <div class="flex space-x-2">
                            <select class="text-xs bg-gray-100 border border-gray-200 rounded-md py-1 px-2">
                                <option>Today</option>
                                <option>Last 7 days</option>
                                <option>Last 30 days</option>
                                <option>All time</option>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Records Table -->
                    <div class="overflow-hidden rounded-lg border border-gray-200">
                        <!-- Table Header -->
                        <div class="bg-gray-50 px-4 py-3 flex items-center border-b border-gray-200">
                            <div class="w-1/6 flex items-center">
                                <span class="text-xs font-medium text-gray-700 mr-2">Status</span>
                                <i class="fas fa-sort text-gray-400 text-xs"></i>
                            </div>
                            <div class="w-1/5 flex items-center">
                                <span class="text-xs font-medium text-gray-700 mr-2">Company</span>
                                <i class="fas fa-sort text-gray-400 text-xs"></i>
                            </div>
                            <div class="w-1/5 flex items-center">
                                <span class="text-xs font-medium text-gray-700 mr-2">Occupant</span>
                                <i class="fas fa-sort text-gray-400 text-xs"></i>
                            </div>
                            <div class="w-1/6 flex items-center">
                                <span class="text-xs font-medium text-gray-700 mr-2">Room</span>
                                <i class="fas fa-sort text-gray-400 text-xs"></i>
                            </div>
                            <div class="w-1/6 flex items-center">
                                <span class="text-xs font-medium text-gray-700 mr-2">Date</span>
                                <i class="fas fa-sort-down text-gray-700 text-xs"></i>
                            </div>
                            <div class="w-1/6 flex items-center justify-end">
                                <span class="text-xs font-medium text-gray-700">Actions</span>
                            </div>
                        </div>
                        
                        <!-- Record Item 1 -->
                        <div class="bg-white px-4 py-3 flex items-center border-b border-gray-200">
                            <div class="w-1/6">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-green-500 dark:text-white">New Issue</span>
                            </div>
                            <div class="w-1/5">
                                <p class="text-sm font-medium text-gray-900">Global Tech</p>
                            </div>
                            <div class="w-1/5">
                                <p class="text-sm text-gray-800">Ahmad Zaki</p>
                                <p class="text-xs text-gray-500">[88159831]</p>
                            </div>
                            <div class="w-1/6">
                                <p class="text-sm text-gray-800">Room 101</p>
                            </div>
                            <div class="w-1/6">
                                <p class="text-sm text-gray-800">Oct 1, 2023</p>
                                <p class="text-xs text-gray-500">10:25 AM</p>
                            </div>
                            <div class="w-1/6 flex justify-end space-x-2">
                                <button class="records-view-btn view-details-btn">
                                    <i class="fas fa-info-circle"></i>
                                </button>
                                <div class="relative">
                                    <button class="records-toggle-btn toggle-record-actions">
                                        <i class="fas fa-ellipsis-h"></i>
                                    </button>
                                    <div class="action-menu absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10 hidden">
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">View Details</a>
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Print Record</a>
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Download PDF</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Record Item 2 -->
                        <div class="bg-white px-4 py-3 flex items-center border-b border-gray-200">
                            <div class="w-1/6">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-green-500 dark:text-white">New Issue</span>
                            </div>
                            <div class="w-1/5">
                                <p class="text-sm font-medium text-gray-900">Sri Paandi</p>
                            </div>
                            <div class="w-1/5">
                                <p class="text-sm text-gray-800">Rahul Singh</p>
                                <p class="text-xs text-gray-500">[PA9284617]</p>
                            </div>
                            <div class="w-1/6">
                                <p class="text-sm text-gray-800">Room 202</p>
                            </div>
                            <div class="w-1/6">
                                <p class="text-sm text-gray-800">Oct 2, 2023</p>
                                <p class="text-xs text-gray-500">2:15 PM</p>
                            </div>
                            <div class="w-1/6 flex justify-end space-x-2">
                                <button class="records-view-btn view-details-btn">
                                    <i class="fas fa-info-circle"></i>
                                </button>
                                <div class="relative">
                                    <button class="records-toggle-btn toggle-record-actions">
                                        <i class="fas fa-ellipsis-h"></i>
                                    </button>
                                    <div class="action-menu absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10 hidden">
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">View Details</a>
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Print Record</a>
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Download PDF</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Record Item 3 -->
                        <div class="bg-white px-4 py-3 flex items-center border-b border-gray-200">
                            <div class="w-1/6">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-500 dark:text-white">Cleared</span>
                            </div>
                            <div class="w-1/5">
                                <p class="text-sm font-medium text-gray-900">Sri Paandi</p>
                            </div>
                            <div class="w-1/5">
                                <p class="text-sm text-gray-800">Muhd Faiz</p>
                                <p class="text-xs text-gray-500">[88127719]</p>
                            </div>
                            <div class="w-1/6">
                                <p class="text-sm text-gray-800">Room 404</p>
                            </div>
                            <div class="w-1/6">
                                <p class="text-sm text-gray-800">Oct 3, 2023</p>
                                <p class="text-xs text-gray-500">11:45 AM</p>
                            </div>
                            <div class="w-1/6 flex justify-end space-x-2">
                                <button class="records-view-btn view-details-btn">
                                    <i class="fas fa-info-circle"></i>
                                </button>
                                <div class="relative">
                                    <button class="records-toggle-btn toggle-record-actions">
                                        <i class="fas fa-ellipsis-h"></i>
                                    </button>
                                    <div class="action-menu absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10 hidden">
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">View Details</a>
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Print Record</a>
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Download PDF</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Record Item 4 -->
                        <div class="bg-white px-4 py-3 flex items-center border-b border-gray-200">
                            <div class="w-1/6">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-green-500 dark:text-white">New Issue</span>
                            </div>
                            <div class="w-1/5">
                                <p class="text-sm font-medium text-gray-900">East Coast</p>
                            </div>
                            <div class="w-1/5">
                                <p class="text-sm text-gray-800">Wan Ahmad</p>
                                <p class="text-xs text-gray-500">[88159831]</p>
                            </div>
                            <div class="w-1/6">
                                <p class="text-sm text-gray-800">Room 305</p>
                            </div>
                            <div class="w-1/6">
                                <p class="text-sm text-gray-800">Oct 3, 2023</p>
                                <p class="text-xs text-gray-500">3:30 PM</p>
                            </div>
                            <div class="w-1/6 flex justify-end space-x-2">
                                <button class="records-view-btn view-details-btn">
                                    <i class="fas fa-info-circle"></i>
                                </button>
                                <div class="relative">
                                    <button class="records-toggle-btn toggle-record-actions">
                                        <i class="fas fa-ellipsis-h"></i>
                                    </button>
                                    <div class="action-menu absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10 hidden">
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">View Details</a>
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Print Record</a>
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Download PDF</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Record Item 5 -->
                        <div class="bg-white px-4 py-3 flex items-center">
                            <div class="w-1/6">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-500 dark:text-white">Cleared</span>
                            </div>
                            <div class="w-1/5">
                                <p class="text-sm font-medium text-gray-900">Global Tech</p>
                            </div>
                            <div class="w-1/5">
                                <p class="text-sm text-gray-800">Lee Min Ho</p>
                                <p class="text-xs text-gray-500">[88127755]</p>
                            </div>
                            <div class="w-1/6">
                                <p class="text-sm text-gray-800">Room 201</p>
                            </div>
                            <div class="w-1/6">
                                <p class="text-sm text-gray-800">Oct 4, 2023</p>
                                <p class="text-xs text-gray-500">9:15 AM</p>
                            </div>
                            <div class="w-1/6 flex justify-end space-x-2">
                                <button class="records-view-btn view-details-btn">
                                    <i class="fas fa-info-circle"></i>
                                </button>
                                <div class="relative">
                                    <button class="records-toggle-btn toggle-record-actions">
                                        <i class="fas fa-ellipsis-h"></i>
                                    </button>
                                    <div class="action-menu absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10 hidden">
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">View Details</a>
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Print Record</a>
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Download PDF</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Pagination Controls -->
                <div class="border-t border-gray-200 bg-gray-50 p-4 mt-auto pagination-footer">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center">
                            <span class="text-sm text-gray-600 dark-mode-text">Showing <span id="recordStartRecord">1</span> - <span id="recordEndRecord">5</span> of <span id="recordTotalRecords">24</span> records</span>
                        </div>
                        <div class="flex-1 flex justify-center">
                            <div class="flex items-center space-x-1" id="recordPaginationButtons">
                                <button class="pagination-button w-8 h-8 flex items-center justify-center rounded-md border border-gray-300 bg-white text-gray-500 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed" id="recordPrevPage" disabled>
                                    <i class="fas fa-chevron-left text-xs"></i>
                                </button>
                                <button class="record-page-btn pagination-button w-8 h-8 flex items-center justify-center rounded-md border active bg-purple-500 text-white">
                                    1
                                </button>
                                <button class="record-page-btn pagination-button w-8 h-8 flex items-center justify-center rounded-md border bg-white text-gray-700 hover:bg-gray-50 border-gray-300">
                                    2
                                </button>
                                <button class="record-page-btn pagination-button w-8 h-8 flex items-center justify-center rounded-md border bg-white text-gray-700 hover:bg-gray-50 border-gray-300">
                                    3
                                </button>
                                <button class="record-page-btn pagination-button w-8 h-8 flex items-center justify-center rounded-md border bg-white text-gray-700 hover:bg-gray-50 border-gray-300">
                                    4
                                </button>
                                <button class="record-page-btn pagination-button w-8 h-8 flex items-center justify-center rounded-md border bg-white text-gray-700 hover:bg-gray-50 border-gray-300">
                                    5
                                </button>
                                <button class="pagination-button w-8 h-8 flex items-center justify-center rounded-md border border-gray-300 bg-white text-gray-500 hover:bg-gray-50" id="recordNextPage">
                                    <i class="fas fa-chevron-right text-xs"></i>
                                </button>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="text-sm text-gray-600">Records per page</span>
                            <select class="border border-gray-300 rounded-lg p-1 text-sm" id="recordsPerPage">
                                <option>10</option>
                                <option>25</option>
                                <option selected>50</option>
                                <option>100</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Occupant Details Modal -->
<div id="occupantDetailsModal" class="fixed inset-0 z-[101] hidden flex items-center justify-center">
    <div class="rounded-lg shadow-xl max-w-4xl w-full mx-4 overflow-hidden max-h-[90vh] flex-col bg-white activity-modal-bg">
        <!-- Modal Header -->
        <div class="border-b p-4 bg-gray-50">
            <div class="modal-header-with-back flex justify-between items-center">
                <button id="backToRecordsModal" class="modal-back-button">
                    <i class="fas fa-arrow-left"></i>
                    <span>Back</span>
                </button>
                <h3 class="text-xl font-semibold text-center flex-grow text-center">Occupant Details</h3>
                <button id="closeOccupantDetailsModal" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        
        <!-- Modal Content -->
        <div class="p-6 overflow-y-auto flex-grow thin-scrollbar transition-all duration-300">
            <div id="occupantDetailsContent">
                <!-- Basic Information -->
                <div class="mb-6">
                    <div class="flex items-center">
                        <div id="occupantStatusBadge" class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 mr-3">
                            New Issue
                        </div>
                        <div id="occupantDate" class="text-sm text-gray-500">
                            Oct 1, 2023 • 10:25 AM
                        </div>
                    </div>
                </div>
                
                <!-- Occupant Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Personal Information -->
                    <div class="bg-white rounded-lg border border-gray-200 p-4">
                        <h4 class="text-sm font-semibold text-gray-700 mb-4 border-b pb-2">Personal Information</h4>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500">Full Name:</span>
                                <span id="occupantName" class="text-sm font-medium text-right">Ahmad Zaki</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500">Emp/Passport/IC No:</span>
                                <span id="occupantID" class="text-sm font-medium text-right">88159831</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500">Company:</span>
                                <span id="occupantCompany" class="text-sm font-medium text-right">Global Tech</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500">Gender:</span>
                                <span id="occupantGender" class="text-sm font-medium text-right">Male</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Room Information -->
                    <div class="bg-white rounded-lg border border-gray-200 p-4">
                        <h4 class="text-sm font-semibold text-gray-700 mb-4 border-b pb-2">Room Information</h4>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500">Room Number:</span>
                                <span id="occupantRoom" class="text-sm font-medium text-right">Room 101</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500">Building:</span>
                                <span id="occupantBuilding" class="text-sm font-medium text-right">RSC7</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500">Floor:</span>
                                <span id="occupantFloor" class="text-sm font-medium text-right">First Floor</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500">Duration:</span>
                                <span id="occupantDuration" class="text-sm font-medium text-right">Oct 1, 2023 - Present</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Item Checklist -->
                <div class="bg-white rounded-lg border border-gray-200 p-4 mb-6">
                    <h4 class="text-sm font-semibold text-gray-700 mb-4 border-b pb-2">Item Checklist</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-700">Access Card/Temporary Pass:</span>
                                <div id="accessCardStatus" class="flex items-center">
                                    <i class="fas fa-check-circle text-green-500 mr-1.5"></i>
                                    <span class="text-sm font-medium">Returned</span>
                                </div>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-700">Room Key:</span>
                                <div id="roomKeyStatus" class="flex items-center">
                                    <i class="fas fa-check-circle text-green-500 mr-1.5"></i>
                                    <span class="text-sm font-medium">Returned</span>
                                </div>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-700">Locker Key:</span>
                                <div id="lockerKeyStatus" class="flex items-center">
                                    <i class="fas fa-minus-circle text-gray-400 mr-1.5"></i>
                                    <span class="text-sm font-medium text-gray-500">N/A</span>
                                </div>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-700">Blanket:</span>
                                <div id="blanketStatus" class="flex items-center">
                                    <i class="fas fa-check-circle text-green-500 mr-1.5"></i>
                                    <span class="text-sm font-medium">Returned</span>
                                </div>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-700">Bed Sheet:</span>
                                <div id="bedSheetStatus" class="flex items-center">
                                    <i class="fas fa-check-circle text-green-500 mr-1.5"></i>
                                    <span class="text-sm font-medium">Returned</span>
                                </div>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-700">Pillow:</span>
                                <div id="pillowStatus" class="flex items-center">
                                    <i class="fas fa-check-circle text-green-500 mr-1.5"></i>
                                    <span class="text-sm font-medium">Returned</span>
                                </div>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-700">Pillow Case:</span>
                                <div id="pillowCaseStatus" class="flex items-center">
                                    <i class="fas fa-check-circle text-green-500 mr-1.5"></i>
                                    <span class="text-sm font-medium">Returned</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Remarks Section -->
                <div class="bg-white rounded-lg border border-gray-200 p-4 mb-6">
                    <h4 class="text-sm font-semibold text-gray-700 mb-3 border-b pb-2">Remarks</h4>
                    <p id="occupantRemarks" class="text-sm text-gray-700">
                        All items in good condition. No damages reported.
                    </p>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex justify-center space-x-3">
                    <button class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-md font-medium text-sm transition-colors">
                        <i class="fas fa-print mr-2"></i>Print Record
                    </button>
                    <button class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-md font-medium text-sm transition-colors">
                        <i class="fas fa-edit mr-2"></i>Edit Record
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Admin & Staff Activity Log Modal -->
<div id="activityLogModal" class="fixed inset-0 z-[100] hidden flex items-center justify-center">
    <div class="rounded-lg shadow-xl max-w-6xl w-full mx-4 overflow-hidden max-h-[90vh] flex bg-white activity-modal-bg">
        <!-- Activity List Panel -->
        <div class="flex-1 flex flex-col">
            <div class="border-b p-4 bg-gray-50">
                <div class="modal-header-with-back flex justify-between items-center">
                    <h3 class="text-xl font-semibold text-center flex-grow">Admin & Staff Activity Log</h3>
                    <button id="closeActivityLogModal" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="flex flex-col flex-1 overflow-hidden">
                <div class="p-6 overflow-y-auto flex-1">
                    <!-- Activity Filters -->
                    <div class="flex justify-between items-center mb-4">
                        <div class="flex space-x-2">
                            <button class="filter-btn selected">All Activities</button>
                            <button class="filter-btn">Admin</button>
                            <button class="filter-btn">Staff</button>
                            <button class="filter-btn">System</button>
                        </div>
                        <div class="flex space-x-2">
                            <select class="text-xs bg-gray-100 border border-gray-200 rounded-md py-1 px-2">
                                <option>Today</option>
                                <option>Last 7 days</option>
                                <option>Last 30 days</option>
                                <option>All time</option>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Activity Table -->
                    <div class="overflow-hidden rounded-lg border border-gray-200">
                        <!-- Table Header -->
                        <div class="bg-gray-50 px-4 py-3 flex items-center border-b border-gray-200">
                            <div class="w-1/6 flex items-center">
                                <span class="text-xs font-medium text-gray-700 mr-2">Type</span>
                                <i class="fas fa-sort text-gray-400 text-xs"></i>
                            </div>
                            <div class="w-1/5 flex items-center">
                                <span class="text-xs font-medium text-gray-700 mr-2">User</span>
                                <i class="fas fa-sort text-gray-400 text-xs"></i>
                            </div>
                            <div class="w-1/4 flex items-center">
                                <span class="text-xs font-medium text-gray-700 mr-2">Action</span>
                                <i class="fas fa-sort text-gray-400 text-xs"></i>
                            </div>
                            <div class="w-1/5 flex items-center">
                                <span class="text-xs font-medium text-gray-700 mr-2">Date</span>
                                <i class="fas fa-sort-down text-gray-700 text-xs"></i>
                            </div>
                            <div class="w-1/6 flex items-center justify-end">
                                <span class="text-xs font-medium text-gray-700">Details</span>
                            </div>
                        </div>
                        
                        <!-- Activity Item 1 -->
                        <div class="bg-white px-4 py-3 flex items-center border-b border-gray-200">
                            <div class="w-1/6">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">Admin</span>
                            </div>
                            <div class="w-1/5">
                                <p class="text-sm font-medium text-gray-900">John Doe</p>
                                <p class="text-xs text-gray-500">Admin</p>
                            </div>
                            <div class="w-1/4">
                                <p class="text-sm text-gray-800">Added new tenant</p>
                            </div>
                            <div class="w-1/5">
                                <p class="text-sm text-gray-800">Oct 1, 2023</p>
                                <p class="text-xs text-gray-500">10:25 AM</p>
                            </div>
                            <div class="w-1/6 flex justify-end">
                                <button class="text-xs text-blue-500 hover:text-blue-700 font-medium px-3 py-1 rounded border border-blue-200 hover:bg-blue-50 view-activity-btn">
                                    View Details
                                </button>
                            </div>
                        </div>
                        
                        <!-- Activity Item 2 -->
                        <div class="bg-white px-4 py-3 flex items-center border-b border-gray-200">
                            <div class="w-1/6">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Staff</span>
                            </div>
                            <div class="w-1/5">
                                <p class="text-sm font-medium text-gray-900">Jane Smith</p>
                                <p class="text-xs text-gray-500">Maintenance</p>
                            </div>
                            <div class="w-1/4">
                                <p class="text-sm text-gray-800">Resolved maintenance ticket</p>
                            </div>
                            <div class="w-1/5">
                                <p class="text-sm text-gray-800">Oct 2, 2023</p>
                                <p class="text-xs text-gray-500">2:15 PM</p>
                            </div>
                            <div class="w-1/6 flex justify-end">
                                <button class="text-xs text-blue-500 hover:text-blue-700 font-medium px-3 py-1 rounded border border-blue-200 hover:bg-blue-50 view-activity-btn">
                                    View Details
                                </button>
                            </div>
                        </div>
                        
                        <!-- Activity Item 3 -->
                        <div class="bg-white px-4 py-3 flex items-center border-b border-gray-200">
                            <div class="w-1/6">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">System</span>
                            </div>
                            <div class="w-1/5">
                                <p class="text-sm font-medium text-gray-900">System</p>
                                <p class="text-xs text-gray-500">Automated</p>
                            </div>
                            <div class="w-1/4">
                                <p class="text-sm text-gray-800">Daily backup completed</p>
                            </div>
                            <div class="w-1/5">
                                <p class="text-sm text-gray-800">Oct 3, 2023</p>
                                <p class="text-xs text-gray-500">1:00 AM</p>
                            </div>
                            <div class="w-1/6 flex justify-end">
                                <button class="text-xs text-blue-500 hover:text-blue-700 font-medium px-3 py-1 rounded border border-blue-200 hover:bg-blue-50 view-activity-btn">
                                    View Details
                                </button>
                            </div>
                        </div>
                        
                        <!-- Activity Item 4 -->
                        <div class="bg-white px-4 py-3 flex items-center border-b border-gray-200">
                            <div class="w-1/6">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">Admin</span>
                            </div>
                            <div class="w-1/5">
                                <p class="text-sm font-medium text-gray-900">Sarah Wong</p>
                                <p class="text-xs text-gray-500">Admin</p>
                            </div>
                            <div class="w-1/4">
                                <p class="text-sm text-gray-800">Modified room allocation</p>
                            </div>
                            <div class="w-1/5">
                                <p class="text-sm text-gray-800">Oct 3, 2023</p>
                                <p class="text-xs text-gray-500">3:45 PM</p>
                            </div>
                            <div class="w-1/6 flex justify-end">
                                <button class="text-xs text-blue-500 hover:text-blue-700 font-medium px-3 py-1 rounded border border-blue-200 hover:bg-blue-50 view-activity-btn">
                                    View Details
                                </button>
                            </div>
                        </div>
                        
                        <!-- Activity Item 5 -->
                        <div class="bg-white px-4 py-3 flex items-center">
                            <div class="w-1/6">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Staff</span>
                            </div>
                            <div class="w-1/5">
                                <p class="text-sm font-medium text-gray-900">Mike Johnson</p>
                                <p class="text-xs text-gray-500">Security</p>
                            </div>
                            <div class="w-1/4">
                                <p class="text-sm text-gray-800">Completed security inspection</p>
                            </div>
                            <div class="w-1/5">
                                <p class="text-sm text-gray-800">Oct 4, 2023</p>
                                <p class="text-xs text-gray-500">9:15 AM</p>
                            </div>
                            <div class="w-1/6 flex justify-end">
                                <button class="text-xs text-blue-500 hover:text-blue-700 font-medium px-3 py-1 rounded border border-blue-200 hover:bg-blue-50 view-activity-btn">
                                    View Details
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Pagination Controls -->
                <div class="border-t border-gray-200 bg-gray-50 p-4 mt-auto pagination-footer">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center">
                            <span class="text-sm text-gray-600 dark-mode-text">Showing <span id="activityStartRecord">1</span> - <span id="activityEndRecord">5</span> of <span id="activityTotalRecords">42</span> activities</span>
                        </div>
                        <div class="flex-1 flex justify-center">
                            <div class="flex items-center space-x-1" id="activityPaginationButtons">
                                <button class="pagination-button w-8 h-8 flex items-center justify-center rounded-md border border-gray-300 bg-white text-gray-500 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed" id="activityPrevPage" disabled>
                                    <i class="fas fa-chevron-left text-xs"></i>
                                </button>
                                <button class="activity-page-btn pagination-button w-8 h-8 flex items-center justify-center rounded-md border active bg-purple-500 text-white">
                                    1
                                </button>
                                <button class="activity-page-btn pagination-button w-8 h-8 flex items-center justify-center rounded-md border bg-white text-gray-700 hover:bg-gray-50 border-gray-300">
                                    2
                                </button>
                                <button class="activity-page-btn pagination-button w-8 h-8 flex items-center justify-center rounded-md border bg-white text-gray-700 hover:bg-gray-50 border-gray-300">
                                    3
                                </button>
                                <button class="activity-page-btn pagination-button w-8 h-8 flex items-center justify-center rounded-md border bg-white text-gray-700 hover:bg-gray-50 border-gray-300">
                                    4
                                </button>
                                <button class="activity-page-btn pagination-button w-8 h-8 flex items-center justify-center rounded-md border bg-white text-gray-700 hover:bg-gray-50 border-gray-300">
                                    5
                                </button>
                                <button class="pagination-button w-8 h-8 flex items-center justify-center rounded-md border border-gray-300 bg-white text-gray-500 hover:bg-gray-50" id="activityNextPage">
                                    <i class="fas fa-chevron-right text-xs"></i>
                                </button>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="text-sm text-gray-600">Activities per page</span>
                            <select class="border border-gray-300 rounded-lg p-1 text-sm" id="activitiesPerPage">
                                <option>10</option>
                                <option>25</option>
                                <option selected>50</option>
                                <option>100</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Activity Details Modal -->
<div id="activityDetailsModal" class="fixed inset-0 z-[101] hidden flex items-center justify-center">
    <div class="rounded-lg shadow-xl max-w-4xl w-full mx-4 overflow-hidden max-h-[90vh] flex-col bg-white activity-modal-bg">
        <!-- Modal Header -->
        <div class="border-b p-4 bg-gray-50">
            <div class="modal-header-with-back flex justify-between items-center">
                <button id="backToActivityLogModal" class="modal-back-button">
                    <i class="fas fa-arrow-left"></i>
                    <span>Back</span>
                </button>
                <h3 class="text-xl font-semibold text-center flex-grow">Activity Details</h3>
                <button id="closeActivityDetailsModal" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        
        <!-- Modal Content -->
        <div class="p-6 overflow-y-auto flex-grow thin-scrollbar transition-all duration-300">
            <div id="activityDetailsContent">
                <!-- Basic Information -->
                <div class="mb-6">
                    <div class="flex items-center">
                        <div id="activityTypeBadge" class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 mr-3">
                            Admin
                        </div>
                        <div id="activityDate" class="text-sm text-gray-500">
                            Oct 1, 2023 • 10:25 AM
                        </div>
                    </div>
                </div>
                
                <!-- User Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- User Information -->
                    <div class="bg-white rounded-lg border border-gray-200 p-4">
                        <h4 class="text-sm font-semibold text-gray-700 mb-4 border-b pb-2 text-center">User Information</h4>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500">Name:</span>
                                <span id="activityUser" class="text-sm font-medium text-right">John Doe</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500">Role:</span>
                                <span id="activityRole" class="text-sm font-medium text-right">Admin</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500">Department:</span>
                                <span id="activityDepartment" class="text-sm font-medium text-right">Management</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500">IP Address:</span>
                                <span id="activityIPAddress" class="text-sm font-medium text-right">192.168.1.45</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Action Information -->
                    <div class="bg-white rounded-lg border border-gray-200 p-4">
                        <h4 class="text-sm font-semibold text-gray-700 mb-4 border-b pb-2 text-center">Action Information</h4>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500">Action Type:</span>
                                <span id="actionType" class="text-sm font-medium text-right">Create</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500">Resource:</span>
                                <span id="actionResource" class="text-sm font-medium text-right">Tenant Record</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500">Status:</span>
                                <span id="actionStatus" class="text-sm font-medium text-right">Completed</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500">Duration:</span>
                                <span id="actionDuration" class="text-sm font-medium text-right">2.4 seconds</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Action Details -->
                <div class="bg-white rounded-lg border border-gray-200 p-4 mb-6">
                    <h4 class="text-sm font-semibold text-gray-700 mb-4 border-b pb-2 text-center">Action Details</h4>
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-gray-700 mb-2">
                                <span class="font-medium">Summary:</span>
                                <span id="actionSummary">Added new tenant to the system with room assignment.</span>
                            </p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-700 mb-2">Changed Fields:</p>
                            <div class="bg-gray-50 rounded p-3">
                                <div id="changedFieldsList" class="space-y-2">
                                    <div class="grid grid-cols-3 text-sm">
                                        <div class="text-gray-600">Field</div>
                                        <div class="text-gray-600">Old Value</div>
                                        <div class="text-gray-600">New Value</div>
                                    </div>
                                    <div class="grid grid-cols-3 text-sm border-t pt-2">
                                        <div class="text-gray-700">Tenant Name</div>
                                        <div class="text-gray-500">-</div>
                                        <div class="text-green-600">Ahmad Zaki</div>
                                    </div>
                                    <div class="grid grid-cols-3 text-sm border-t pt-2">
                                        <div class="text-gray-700">Room Number</div>
                                        <div class="text-gray-500">-</div>
                                        <div class="text-green-600">101</div>
                                    </div>
                                    <div class="grid grid-cols-3 text-sm border-t pt-2">
                                        <div class="text-gray-700">ID Number</div>
                                        <div class="text-gray-500">-</div>
                                        <div class="text-green-600">88159831</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- System Notes -->
                <div class="bg-white rounded-lg border border-gray-200 p-4 mb-6">
                    <h4 class="text-sm font-semibold text-gray-700 mb-3 border-b pb-2 text-center">System Notes</h4>
                    <p id="systemNotes" class="text-sm text-gray-700">
                        Action performed through the web interface. Tenant record successfully created with all required fields. Email notification sent to administrative staff.
                    </p>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex justify-center space-x-3">
                    <button class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-md font-medium text-sm transition-colors">
                        <i class="fas fa-print mr-2"></i>Print Activity
                    </button>
                    <button class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-md font-medium text-sm transition-colors">
                        <i class="fas fa-history mr-2"></i>View Related Activities
                    </button>
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
