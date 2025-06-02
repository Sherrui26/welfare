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
                <?php 
                // Calculate total rooms and bedspaces
                $totalRooms = $availableRooms + $occupiedRooms + $roomsUnderMaintenance + $roomsBlocked;
                $totalBedspaces = isset($availableBedspaces['total']) ? $availableBedspaces['total'] : 0;
                $occupiedRatio = $totalRooms > 0 ? ($occupiedRooms / $totalRooms * 100) : 0;
                $occupancyRate = round($occupiedRatio);
                ?>
                <div class="grid grid-cols-2 gap-2">
                    <div class="bg-blue-50 p-1.5 rounded">
                        <div class="flex items-center text-blue-700 font-medium mb-1">
                            <i class="fas fa-bed mr-1.5"></i>Free Bedspaces
                        </div>
                        <div class="text-lg font-bold text-blue-800"><?= esc($availableBedspaces['total'] ?? 0) ?></div>
                        <div class="text-xs text-blue-600">from <?= esc($availableRooms ?? 0) ?> rooms</div>
                    </div>
                    <div class="bg-yellow-50 p-1.5 rounded">
                        <div class="flex items-center text-yellow-700 font-medium mb-1">
                            <i class="fas fa-user-check mr-1.5"></i>Occupied
                        </div>
                        <div class="text-lg font-bold text-yellow-800"><?= $totalRooms > 0 ? esc($occupiedRooms) : 0 ?></div>
                        <div class="text-xs text-yellow-600">from <?= $totalRooms > 0 ? esc($occupiedRooms) : 0 ?> rooms</div>
                    </div>
                </div>
                <div class="mt-2 mb-1 text-xs text-gray-500">Occupancy Rate: <?= esc($occupancyRate) ?>%</div>
                <div class="w-full bg-gray-200 rounded-full h-1.5 mb-2">
                    <div class="bg-blue-500 h-1.5 rounded-full" style="width: <?= esc($occupancyRate) ?>%"></div>
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
                <?php 
                // Calculate occupancy rate (using the same calculation from the first card)
                $totalRooms = $availableRooms + $occupiedRooms + $roomsUnderMaintenance + $roomsBlocked;
                $occupiedRatio = $totalRooms > 0 ? ($occupiedRooms / $totalRooms * 100) : 0;
                $occupancyRate = round($occupiedRatio);
                
                // Fetch expiring rooms and pending payments from controller data if available
                $expiringRooms = isset($expiringRooms) ? $expiringRooms : 0;
                $pendingPayments = isset($pendingPayments) ? $pendingPayments : 0;
                ?>
                <div class="flex justify-between items-center mb-2">
                    <div class="flex items-center">
                        <div class="w-2 h-2 bg-yellow-500 rounded-full mr-1.5"></div>
                        <span class="text-gray-600">Occupancy Rate:</span>
                    </div>
                    <span class="font-bold"><?= esc($occupancyRate) ?>%</span>
                </div>
                
                <div class="flex justify-between items-center mb-2">
                    <div class="flex items-center">
                        <div class="w-2 h-2 bg-orange-500 rounded-full mr-1.5"></div>
                        <span class="text-gray-600">Expiring Soon:</span>
                    </div>
                    <?php if($expiringRooms > 0): ?>
                        <span class="font-bold text-orange-500"><?= esc($expiringRooms) ?> rooms</span>
                    <?php else: ?>
                        <span class="text-gray-500">No data</span>
                    <?php endif; ?>
                </div>
                
                <div class="flex justify-between items-center mb-2">
                    <div class="flex items-center">
                        <div class="w-2 h-2 bg-red-500 rounded-full mr-1.5"></div>
                        <span class="text-gray-600">Pending Payments:</span>
                    </div>
                    <?php if($pendingPayments > 0): ?>
                        <span class="font-bold text-red-500"><?= esc($pendingPayments) ?> rooms</span>
                    <?php else: ?>
                        <span class="text-gray-500">No data</span>
                    <?php endif; ?>
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
                            <?php if (isset($availableBedspaces['byType']) && count($availableBedspaces['byType']) > 0): ?>
                                <?php 
                                // Define styles for different room types
                                $styles = [
                                    '1-bed' => ['gradient' => 'from-blue-50 to-blue-100', 'border' => 'blue-200', 'text' => 'blue-800', 'detail' => 'blue-600'],
                                    '2-bed' => ['gradient' => 'from-blue-50 to-blue-100', 'border' => 'blue-200', 'text' => 'blue-800', 'detail' => 'blue-600'],
                                    '3-bed' => ['gradient' => 'from-purple-50 to-purple-100', 'border' => 'purple-200', 'text' => 'purple-800', 'detail' => 'purple-600'],
                                    '4-bed' => ['gradient' => 'from-green-50 to-green-100', 'border' => 'green-200', 'text' => 'green-800', 'detail' => 'green-600'],
                                    '5-bed' => ['gradient' => 'from-red-50 to-red-100', 'border' => 'red-200', 'text' => 'red-800', 'detail' => 'red-600'],
                                    '6-bed' => ['gradient' => 'from-amber-50 to-amber-100', 'border' => 'amber-200', 'text' => 'amber-800', 'detail' => 'amber-600'],
                                ];
                                
                                // Loop through each room type
                                foreach ($availableBedspaces['byType'] as $type => $data): 
                                    // Set default style if the room type isn't in our style array
                                    $style = $styles[$type] ?? $styles['2-bed'];
                                ?>
                                    <div class="vacant-type-card flex-shrink-0 w-1/3 px-1">
                                        <div class="bg-gradient-to-r <?= $style['gradient'] ?> rounded-lg p-2 border border-<?= $style['border'] ?> text-center">
                                            <div class="text-<?= $style['text'] ?> font-medium text-xs"><?= esc($type) ?></div>
                                            <div class="text-xl font-bold text-<?= $style['text'] ?> leading-tight"><?= esc($data['rooms']) ?></div>
                                            <div class="text-xs text-<?= $style['detail'] ?>"><?= esc($data['beds']) ?> beds</div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="w-full text-center py-4">
                                    <p class="text-gray-500 text-sm">No available bedspaces data.</p>
                                </div>
                            <?php endif; ?>
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
                    <span class="font-bold text-green-700"><?= esc($availableBedspaces['total'] ?? 0) ?> bedspaces</span>
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
                <?php if ($roomsUnderMaintenance <= 0): ?>
                <div class="bg-green-50 p-2 rounded mb-2 flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-500 mr-1.5"></i>
                    <span class="text-green-700 font-medium">All rooms operational</span>
                </div>
                <?php else: ?>
                <div class="bg-yellow-50 p-2 rounded mb-2 flex items-center justify-center">
                    <i class="fas fa-tools text-yellow-500 mr-1.5"></i>
                    <span class="text-yellow-700 font-medium"><?= esc($roomsUnderMaintenance) ?> room(s) under maintenance</span>
                </div>
                <?php endif; ?>
                <div class="grid grid-cols-2 gap-2">
                    <div class="bg-gray-50 p-1.5 rounded">
                        <div class="text-gray-600 mb-0.5">Last Maintenance:</div>
                        <?php if (isset($maintenanceSchedule['lastMaintenance']) && $maintenanceSchedule['lastMaintenance'] !== null): ?>
                            <div class="font-medium">Room <?= esc($maintenanceSchedule['lastMaintenance']['room']) ?></div>
                            <div class="text-gray-500 text-xs"><?= esc($maintenanceSchedule['lastMaintenance']['daysAgo']) ?> days ago</div>
                        <?php else: ?>
                            <div class="font-medium">No data</div>
                            <div class="text-gray-500 text-xs">No maintenance yet</div>
                        <?php endif; ?>
                    </div>
                    <div class="bg-gray-50 p-1.5 rounded">
                        <div class="text-gray-600 mb-0.5">Next Scheduled:</div>
                        <?php if (isset($maintenanceSchedule['nextScheduled']) && $maintenanceSchedule['nextScheduled'] !== null): ?>
                            <div class="font-medium">Room <?= esc($maintenanceSchedule['nextScheduled']['room']) ?></div>
                            <div class="text-gray-500 text-xs">in <?= esc($maintenanceSchedule['nextScheduled']['daysAhead']) ?> days</div>
                        <?php else: ?>
                            <div class="font-medium">No data</div>
                            <div class="text-gray-500 text-xs">Not scheduled yet</div>
                        <?php endif; ?>
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
                    <?php if (!empty($blockedDetails) && is_array($blockedDetails)): ?>
                        <?php foreach ($blockedDetails as $room): ?>
                        <div class="bg-red-50 p-1.5 rounded flex justify-between items-center">
                            <div class="flex items-center">
                                <i class="fas fa-ban text-red-500 mr-1.5"></i>
                                <span class="font-medium">Room <?= esc($room['room']) ?></span>
                            </div>
                            <span class="text-red-700"><?= esc($room['reason']) ?></span>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="bg-gray-50 p-2 rounded text-center">
                            <p class="text-gray-500 text-sm">No blocked rooms at this time.</p>
                        </div>
                    <?php endif; ?>
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
                    <?php 
                    // Get room overlays from controller data
                    $roomOverlaysFloor1 = isset($roomOverlays['floor1']) ? $roomOverlays['floor1'] : [];
                    
                    // Define fallback rooms if no data is available
                    $defaultRooms = [
                        'room-1' => 'available',
                        'room-2' => 'available',
                        'room-3' => 'available',
                        'room-4' => 'available', 
                        'room-5' => 'available',
                        'room-6' => 'available',
                        'room-7' => 'available',
                        'room-8' => 'available',
                        'room-9' => 'available',
                        'room-10' => 'available'
                    ];
                    
                    // Use either the data from the controller or default rooms as fallback
                    $roomsToDisplay = !empty($roomOverlaysFloor1) ? $roomOverlaysFloor1 : $defaultRooms;
                    
                    // Display room overlays
                    foreach ($roomsToDisplay as $roomId => $status) :
                    ?>
                        <div id="<?= $roomId ?>" class="room-overlay floor-1 <?= $status ?>"></div>
                    <?php endforeach; ?>

                    <!-- Room Overlays for Floor 2 -->
                    <?php 
                    // Get room overlays from controller data
                    $roomOverlaysFloor2 = isset($roomOverlays['floor2']) ? $roomOverlays['floor2'] : [];
                    
                    // Define fallback rooms if no data is available
                    $defaultRoomsFloor2 = [
                        'room-7-02-18' => 'available',
                        'room-7-02-17' => 'available',
                        'room-7-02-16' => 'available',
                        'room-7-02-15' => 'available', 
                        'room-7-02-14' => 'available',
                        'room-7-02-19' => 'available',
                        'room-7-02-20' => 'available',
                        'room-7-02-21' => 'available',
                        'room-7-02-22' => 'available',
                        'room-7-02-23' => 'available',
                        'room-7-02-04-rect' => 'available',
                        'room-7-02-27' => 'available',
                        'room-7-02-08' => 'available',
                        'room-7-02-09' => 'available',
                        'room-7-02-10' => 'available',
                        'room-7-02-11' => 'available',
                        'room-7-02-12' => 'available',
                        'room-7-02-13' => 'available',
                        'room-7-02-07' => 'available',
                        'room-7-02-06' => 'available',
                    ];
                    
                    // Use either the data from the controller or default rooms as fallback
                    $roomsToDisplay = !empty($roomOverlaysFloor2) ? $roomOverlaysFloor2 : $defaultRoomsFloor2;
                    
                    // Display room overlays
                    foreach ($roomsToDisplay as $roomId => $status) :
                    ?>
                        <div id="<?= $roomId ?>" class="room-overlay floor-2 <?= $status ?>"></div>
                    <?php endforeach; ?>
                    <!-- Polygon rooms and special rooms -->
                    <?php
                    // Get polygon room overlays from controller data
                    $polygonRooms = isset($roomOverlays['polygons']) ? $roomOverlays['polygons'] : [
                        'room-7-02-05' => 'available',
                        'room-7-02-02' => 'full',
                        'room-7-02-25' => 'blocked',
                        'room-7-02-26' => 'maintenance',
                        'room-7-02-01' => 'available',
                        'room-7-02-03' => 'full',
                        'room-7-02-04-poly' => 'full'
                    ];
                    
                    // Display polygon room overlays
                    foreach ($polygonRooms as $roomId => $status) :
                        $isPolygon = strpos($roomId, 'poly') !== false || in_array($roomId, [
                            'room-7-02-25', 'room-7-02-26', 'room-7-02-01', 'room-7-02-03'
                        ]);
                        $polygonClass = $isPolygon ? 'polygon-overlay' : '';
                    ?>
                        <div id="<?= $roomId ?>" class="room-overlay floor-2 <?= $status ?> <?= $polygonClass ?>"></div>
                    <?php endforeach; ?>
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
                <span class="activity-badge text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-full">Last Activity: <?= isset($lastActivityTime) ? esc($lastActivityTime) : 'No recent activity' ?></span>
            </h2>
            <div class="overflow-y-auto" style="height: 300px;">
                <!-- Timeline container with styled connection line -->
                <div class="timeline-container relative pl-6 before:content-[''] before:absolute before:left-[20px] before:top-4 before:bottom-2 before:w-0.5 before:bg-gradient-to-b before:from-green-300 before:via-purple-300 before:to-blue-300 before:opacity-70">
                    <!-- Activity Items -->
                    <div class="space-y-5 pt-1 pb-2">
                        <?php if (!empty($recentActivities) && is_array($recentActivities)): ?>
                            <?php foreach ($recentActivities as $activity): ?>
                                <?= view('partials/activity_item', [
                                    'color' => $activity['color'] ?? 'blue',
                                    'icon' => $activity['icon'] ?? 'fa-info-circle',
                                    'title' => $activity['title'] ?? 'Activity',
                                    'description' => $activity['description'] ?? 'No details available',
                                    'time' => $activity['time'] ?? 'unknown time'
                                ]) ?>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="text-center py-6">
                                <div class="text-gray-400 mb-2"><i class="fas fa-history text-2xl"></i></div>
                                <p class="text-gray-500">No recent activity data available.</p>
                                <p class="text-sm text-gray-400 mt-1">Activity records will appear here as they occur.</p>
                            </div>
                        <?php endif; ?>
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
<!-- Recent Issue and Clearance -->
<div class="card basic-card bg-white shadow-md rounded-lg p-6 mb-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold text-gray-800">Recent Issue & Clearance</h2>
            <div class="flex space-x-2">
            <?php
            // The active filter would normally be set based on user selection
            // Here we'll default to 'Today' but this would be dynamic in production
            $activeFilter = 'today'; // Default filter
            ?>
            <button class="filter-btn <?= $activeFilter === 'today' ? 'selected' : '' ?>" data-filter="today">Today</button>
            <button class="filter-btn <?= $activeFilter === 'week' ? 'selected' : '' ?>" data-filter="week">This Week</button>
            <button class="filter-btn <?= $activeFilter === 'month' ? 'selected' : '' ?>" data-filter="month">This Month</button>
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
                                <?php
                                // Get recent activities from controller data
                                // The controller passes 'recentActivities' which we'll use for both issues and clearances
                                $issueAndClearances = isset($recentActivities) ? $recentActivities : [];
                                
                                // Filter by activity type if needed based on filter selection
                                // This would be implemented with JavaScript for real-time filtering
                                
                                
                                if (!empty($issueAndClearances)): 
                                    // Loop through each issue/clearance item
                                    foreach ($issueAndClearances as $item):
                                ?>
                                    <div class="issue-card flex-shrink-0 w-full md:w-1/3 px-2">
                                        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300">
                                            <div class="p-4 border-b border-gray-100">
                                                <div class="flex justify-between items-center">
                                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-medium <?= $item['type'] === 'issue' ? 'bg-indigo-100 text-indigo-800' : 'bg-red-100 text-red-800' ?>">
                                                        <?= $item['type'] === 'issue' ? 'New Issue' : 'Cleared' ?>
                                                    </span>
                                                    <span class="text-xs text-gray-500"><?= esc($item['date']) ?></span>
                                                </div>
                                                <div class="mt-2">
                                                    <div class="flex items-center">
                                                        <div>
                                                            <p class="text-sm font-medium text-gray-900"><?= esc($item['tenant_name']) ?></p>
                                                            <p class="text-xs text-gray-500"><?= esc($item['tenant_id']) ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="px-4 py-2 bg-gray-50">
                                                <div class="flex justify-between items-center">
                                                    <span class="text-xs text-gray-500">Room <?= esc($item['room']) ?></span>
                                                    <button class="text-xs text-blue-500 hover:text-blue-700 font-medium px-3 py-1 rounded border border-blue-200 hover:bg-blue-50 view-details-btn" data-id="<?= esc($item['id']) ?>">
                                                        View Details
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php 
                                    endforeach;
                                else:
                                ?>
                                    <div class="issue-card flex-shrink-0 w-full px-2">
                                        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden shadow-sm p-8 text-center">
                                            <div class="text-gray-400 mb-4"><i class="fas fa-clipboard-list text-4xl"></i></div>
                                            <p class="text-gray-600 font-medium mb-2">No issue or clearance data available for this period.</p>
                                            <p class="text-sm text-gray-400">Any new issuance or clearance will appear here.</p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                
                                <!-- No additional hardcoded cards here - they will be generated dynamically in the loop above -->
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

                        <?php
                        // This would typically come from a StaffActivityModel or similar
                        // For example: $staffActivities = $staffActivityModel->getRecentStaffActivities(5);
                        // Currently we'll check if this variable is passed from controller
                        if (isset($staffActivities) && !empty($staffActivities) && is_array($staffActivities)): 
                            foreach ($staffActivities as $index => $activity):
                                // For the last item, don't add a border-b class
                                $borderClass = ($index < count($staffActivities) - 1) ? 'border-b border-gray-200' : '';
                        ?>
                        <div class="bg-white px-4 py-3 flex <?= $borderClass ?>">
                            <div class="w-1/4 flex items-center">
                                <div class="h-8 w-8 rounded-full bg-<?= getColorForRole($activity['role'] ?? 'staff') ?>-100 flex items-center justify-center mr-2">
                                    <span class="text-<?= getColorForRole($activity['role'] ?? 'staff') ?>-600 font-medium"><?= getInitials($activity['staff_name'] ?? 'Unknown') ?></span>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900"><?= esc($activity['staff_name'] ?? 'Unknown') ?></p>
                                    <p class="text-xs text-gray-500"><?= esc($activity['role'] ?? 'Staff') ?></p>
                                </div>
                            </div>
                            <div class="w-1/3">
                                <p class="text-sm text-gray-800"><?= esc($activity['description'] ?? 'No description available') ?></p>
                            </div>
                            <div class="w-1/5 text-right">
                                <p class="text-xs text-gray-500"><?= esc($activity['formatted_date'] ?? 'Unknown date') ?></p>
                            </div>
                            <div class="w-1/5 flex items-center justify-end space-x-4">
                                <button class="records-view-btn view-details-btn" data-activity-id="<?= esc($activity['id'] ?? '') ?>">
                                    <i class="fas fa-info-circle text-sm text-gray-600"></i>
                                </button>
                                <button class="records-view-btn view-details-btn" data-activity-id="<?= esc($activity['id'] ?? '') ?>">
                                    <i class="fas fa-ellipsis-v text-sm text-gray-600"></i>
                                </button>                                  
                            </div>
                        </div>
                        <?php endforeach; else: ?>
                        <div class="bg-white px-4 py-10 text-center">
                            <div class="text-gray-400 mb-2"><i class="fas fa-clipboard-list text-3xl"></i></div>
                            <p class="text-gray-500 mb-1">No staff activity records available</p>
                            <p class="text-sm text-gray-400">Staff actions will be logged and displayed here</p>
                        </div>
                        <?php endif; ?>
                        <?php
                        // Helper functions for staff activity display
                        if (!function_exists('getInitials')) {
                                  function getInitials($name) {
                                      $words = explode(' ', $name);
                                      $initials = '';
                                      foreach ($words as $word) {
                                          $initials .= !empty($word) ? strtoupper(substr($word, 0, 1)) : '';
                                      }
                                      return substr($initials, 0, 2); // Return max 2 characters
                                  }
                              }
                              if (!function_exists('getColorForRole')) {
                                  function getColorForRole($role) {
                                      $role = strtolower($role);
                                      switch($role) {
                                          case 'administrator': return 'indigo';
                                          case 'staff': return 'blue';
                                          case 'maintenance': return 'green';
                                          case 'system': return 'purple';
                                          default: return 'gray';
                                      }
                                  }
                              }
                        ?>
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
                    <?php
                    // This would typically come from RoomModel
                    // For example: $roomCategories = $roomModel->getRoomCategoriesWithOccupancy();
                    // For now we'll simulate with a placeholder variable if not set
                    $roomCategories = isset($roomCategories) ? $roomCategories : [];
                              
                    // Define colors for different bed space categories
                    $colors = [
                        2 => ['bg' => 'blue', 'text' => 'blue'],
                        3 => ['bg' => 'purple', 'text' => 'purple'],
                        4 => ['bg' => 'green', 'text' => 'green'],
                        5 => ['bg' => 'red', 'text' => 'red'],
                        6 => ['bg' => 'amber', 'text' => 'amber'],
                        7 => ['bg' => 'indigo', 'text' => 'indigo'],
                        8 => ['bg' => 'pink', 'text' => 'pink'],
                    ];
                              
                    if (!empty($roomCategories)):
                        foreach ($roomCategories as $bedCount => $category):
                            $color = isset($colors[$bedCount]) ? $colors[$bedCount] : ['bg' => 'gray', 'text' => 'gray'];
                            $occupancyPercent = isset($category['total']) && $category['total'] > 0 
                                ? round(($category['occupied'] / $category['total']) * 100) 
                                : 0;
                            $occupancyDasharray = "{$occupancyPercent}, 100";
                    ?>
                    <!-- Category Card for <?= $bedCount ?> Bed Spaces -->
                    <div class="category-card flex-shrink-0 w-full md:w-1/3 px-2">
                        <div class="bg-gradient-to-r from-<?= $color['bg'] ?>-50 to-<?= $color['bg'] ?>-100 rounded-lg p-4 border border-<?= $color['bg'] ?>-200">
                            <div class="flex justify-between items-center mb-2">
                                <h3 class="text-sm font-medium text-<?= $color['text'] ?>-800"><?= $bedCount ?> Bed Spaces</h3>
                                <span class="text-xs px-2 py-1 bg-<?= $color['bg'] ?>-200 text-<?= $color['text'] ?>-800 rounded-full"><?= $category['total'] ?? 0 ?> Total</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="flex items-center">
                                        <div class="w-3 h-3 rounded-full bg-green-500 mr-1"></div>
                                        <span class="text-xs text-gray-600">Available: <?= $category['available'] ?? 0 ?> rooms (<?= ($category['available'] ?? 0) * $bedCount ?> beds)</span>
                                    </div>
                                    <div class="flex items-center mt-1">
                                        <div class="w-3 h-3 rounded-full bg-yellow-500 mr-1"></div>
                                        <span class="text-xs text-gray-600">Occupied: <?= $category['occupied'] ?? 0 ?> rooms (<?= ($category['occupied'] ?? 0) * $bedCount ?> beds)</span>
                                    </div>
                                </div>
                                <div class="h-16 w-16 relative">
                                    <svg viewBox="0 0 36 36" class="h-16 w-16">
                                        <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#E5E7EB" stroke-width="3" />
                                        <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#FBBF24" stroke-width="3" stroke-dasharray="<?= $occupancyDasharray ?>" />
                                        <text x="18" y="19" class="text-xs font-medium" text-anchor="middle" dominant-baseline="middle" fill="#4B5563" style="font-size: 10px;"><?= $occupancyPercent ?>%</text>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                        endforeach;
                        else:
                        // Add placeholder cards if no data is available
                        $placeholderCategories = [2, 3, 4];
                        foreach ($placeholderCategories as $bedCount):
                            $color = $colors[$bedCount];
                    ?>
                    <!-- Placeholder Category Card -->
                    <div class="category-card flex-shrink-0 w-full md:w-1/3 px-2">
                        <div class="bg-gradient-to-r from-<?= $color['bg'] ?>-50 to-<?= $color['bg'] ?>-100 rounded-lg p-4 border border-<?= $color['bg'] ?>-200">
                            <div class="flex justify-between items-center mb-2">
                                <h3 class="text-sm font-medium text-<?= $color['text'] ?>-800"><?= $bedCount ?> Bed Spaces</h3>
                                <span class="text-xs px-2 py-1 bg-<?= $color['bg'] ?>-200 text-<?= $color['text'] ?>-800 rounded-full">0 Total</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="flex items-center">
                                        <div class="w-3 h-3 rounded-full bg-green-500 mr-1"></div>
                                        <span class="text-xs text-gray-600">Available: 0 rooms (0 beds)</span>
                                    </div>
                                    <div class="flex items-center mt-1">
                                        <div class="w-3 h-3 rounded-full bg-yellow-500 mr-1"></div>
                                        <span class="text-xs text-gray-600">Occupied: 0 rooms (0 beds)</span>
                                    </div>
                                </div>
                                <div class="h-16 w-16 relative">
                                    <svg viewBox="0 0 36 36" class="h-16 w-16">
                                        <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#E5E7EB" stroke-width="3" />
                                        <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#FBBF24" stroke-width="3" stroke-dasharray="0, 100" />
                                        <text x="18" y="19" class="text-xs font-medium" text-anchor="middle" dominant-baseline="middle" fill="#4B5563" style="font-size: 10px;">0%</text>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                        endforeach;
                        endif;
                    ?>
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
                            <?php if (!empty($allActivities) && is_array($allActivities)): ?>
                                <?php 
                                // Group activities by date
                                $groupedActivities = [];
                                $today = date('Y-m-d');
                                $yesterday = date('Y-m-d', strtotime('-1 day'));
                                
                                foreach ($allActivities as $activity) {
                                    $activityDate = isset($activity['date']) ? $activity['date'] : date('Y-m-d');
                                    
                                    if ($activityDate === $today) {
                                        $groupKey = 'Today';
                                    } else if ($activityDate === $yesterday) {
                                        $groupKey = 'Yesterday';
                                    } else {
                                        $groupKey = date('d.m.Y', strtotime($activityDate));
                                    }
                                    
                                    if (!isset($groupedActivities[$groupKey])) {
                                        $groupedActivities[$groupKey] = [];
                                    }
                                    
                                    $groupedActivities[$groupKey][] = $activity;
                                }
                                
                                // Display grouped activities
                                foreach ($groupedActivities as $dateGroup => $activities): 
                                ?>
                                    <!-- <?= $dateGroup ?>'s Activities -->
                                    <div class="border-b border-gray-100 pb-2 mb-4">
                                        <h4 class="text-sm font-medium text-gray-500 mb-3 ml-2"><?= esc($dateGroup) ?></h4>
                                        
                                        <?php foreach ($activities as $activity): ?>
                                            <!-- Activity Item -->
                                            <div class="timeline-item relative rounded-lg p-3 bg-gradient-to-r from-white to-gray-50 border border-gray-100 hover:bg-gray-100 cursor-pointer activity-item" data-activity-id="<?= $activity['id'] ?? 0 ?>">
                                                <div class="absolute -left-6 top-4 w-3 h-3 bg-<?= $activity['color'] ?? 'blue' ?>-500 rounded-full shadow-sm z-10"></div>
                                                <div class="flex justify-between items-start">
                                                    <div class="flex items-start">
                                                        <div class="h-10 w-10 rounded-full bg-<?= $activity['color'] ?? 'blue' ?>-100 flex items-center justify-center mr-3 shadow-sm border border-<?= $activity['color'] ?? 'blue' ?>-200">
                                                            <i class="fas <?= $activity['icon'] ?? 'fa-info-circle' ?> text-<?= $activity['color'] ?? 'blue' ?>-600"></i>
                                                        </div>
                                                        <div>
                                                            <p class="text-sm font-medium text-gray-800"><?= esc($activity['title'] ?? 'Activity') ?></p>
                                                            <p class="text-xs text-gray-500 mt-0.5"><?= esc($activity['description'] ?? 'No details available') ?></p>
                                                        </div>
                                                    </div>
                                                    <span class="text-xs text-gray-400 bg-gray-50 px-2 py-1 rounded-full"><?= esc($activity['time'] ?? '') ?></span>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="text-center py-8">
                                    <div class="text-gray-400 mb-3"><i class="fas fa-history text-3xl"></i></div>
                                    <p class="text-gray-500">No activity records found.</p>
                                    <p class="text-sm text-gray-400 mt-1">Activity history will appear here as events occur.</p>
                                </div>
                            <?php endif; ?>
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
                        
                        <?php if (!empty($records) && is_array($records)): ?>
                            <?php foreach ($records as $index => $record): ?>
                                <!-- Record Item -->
                                <div class="bg-white px-4 py-3 flex items-center border-b border-gray-200">
                                    <div class="w-1/6">
                                        <?php 
                                        $statusClass = 'bg-indigo-100 text-indigo-800';
                                        if ($record['status'] === 'Cleared') {
                                            $statusClass = 'bg-red-100 text-red-800';
                                        } elseif ($record['status'] === 'Pending') {
                                            $statusClass = 'bg-yellow-100 text-yellow-800';
                                        }
                                        ?>
                                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium <?= $statusClass ?>">
                                            <?= esc($record['status'] ?? 'New Issue') ?>
                                        </span>
                                    </div>
                                    <div class="w-1/5">
                                        <p class="text-sm font-medium text-gray-900"><?= esc($record['company'] ?? '') ?></p>
                                    </div>
                                    <div class="w-1/5">
                                        <p class="text-sm text-gray-800"><?= esc($record['occupant_name'] ?? '') ?></p>
                                        <p class="text-xs text-gray-500">[<?= esc($record['occupant_id'] ?? '') ?>]</p>
                                    </div>
                                    <div class="w-1/6">
                                        <p class="text-sm text-gray-800"><?= esc($record['room'] ?? '') ?></p>
                                    </div>
                                    <div class="w-1/6">
                                        <p class="text-sm text-gray-800"><?= esc($record['date'] ?? '') ?></p>
                                        <p class="text-xs text-gray-500"><?= esc($record['time'] ?? '') ?></p>
                                    </div>
                                    <div class="w-1/6 flex justify-end space-x-2">
                                        <button class="records-view-btn view-details-btn" data-record-id="<?= $record['id'] ?? 0 ?>">
                                            <i class="fas fa-info-circle"></i>
                                        </button>
                                        <div class="relative">
                                            <button class="records-toggle-btn toggle-record-actions">
                                                <i class="fas fa-ellipsis-h"></i>
                                            </button>
                                            <div class="action-menu absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10 hidden">
                                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">View Details</a>
                                                <a href="<?= base_url('print-record/' . ($record['id'] ?? 0)) ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Print Record</a>
                                                <a href="<?= base_url('download-record/' . ($record['id'] ?? 0)) ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Download PDF</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <!-- Empty State -->
                            <div class="text-center py-8 bg-white">
                                <div class="text-gray-400 mb-3"><i class="fas fa-file-alt text-3xl"></i></div>
                                <p class="text-gray-500">No records found.</p>
                                <p class="text-sm text-gray-400 mt-1">Records will appear here when they are created.</p>
                            </div>
                        <?php endif; ?>
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
                <!-- Data will be loaded dynamically via JavaScript -->
                <!-- Basic Information -->
                <div class="mb-6">
                    <div class="flex items-center">
                        <div id="occupantStatusBadge" class="px-2.5 py-0.5 rounded-full text-xs font-medium mr-3">
                            <!-- Status will be inserted here -->
                        </div>
                        <div id="occupantDate" class="text-sm text-gray-500">
                            <!-- Date will be inserted here -->
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
                                <span id="occupantName" class="text-sm font-medium text-right"></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500">Emp/Passport/IC No:</span>
                                <span id="occupantID" class="text-sm font-medium text-right"></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500">Company:</span>
                                <span id="occupantCompany" class="text-sm font-medium text-right"></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500">Gender:</span>
                                <span id="occupantGender" class="text-sm font-medium text-right"></span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Room Information -->
                    <div class="bg-white rounded-lg border border-gray-200 p-4">
                        <h4 class="text-sm font-semibold text-gray-700 mb-4 border-b pb-2">Room Information</h4>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500">Room Number:</span>
                                <span id="occupantRoom" class="text-sm font-medium text-right"></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500">Building:</span>
                                <span id="occupantBuilding" class="text-sm font-medium text-right"></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500">Floor:</span>
                                <span id="occupantFloor" class="text-sm font-medium text-right"></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500">Duration:</span>
                                <span id="occupantDuration" class="text-sm font-medium text-right"></span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Item Checklist -->
                <div class="bg-white rounded-lg border border-gray-200 p-4 mb-6">
                    <h4 class="text-sm font-semibold text-gray-700 mb-4 border-b pb-2">Item Checklist</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div id="itemChecklistLeft" class="space-y-3">
                            <!-- Left column checklist items will be inserted here -->
                        </div>
                        <div id="itemChecklistRight" class="space-y-3">
                            <!-- Right column checklist items will be inserted here -->
                        </div>
                    </div>
                </div>
                
                <!-- Remarks Section -->
                <div class="bg-white rounded-lg border border-gray-200 p-4 mb-6">
                    <h4 class="text-sm font-semibold text-gray-700 mb-3 border-b pb-2">Remarks</h4>
                    <p id="occupantRemarks" class="text-sm text-gray-700"></p>
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
                        
                        <?php if (!empty($adminActivities) && is_array($adminActivities)): ?>
                            <?php foreach ($adminActivities as $activity): ?>
                                <!-- Activity Item -->
                                <div class="bg-white px-4 py-3 flex items-center border-b border-gray-200">
                                    <div class="w-1/6">
                                        <?php 
                                        $typeClass = 'bg-gray-100 text-gray-800'; // Default for System
                                        if ($activity['type'] === 'Admin') {
                                            $typeClass = 'bg-purple-100 text-purple-800';
                                        } elseif ($activity['type'] === 'Staff') {
                                            $typeClass = 'bg-blue-100 text-blue-800';
                                        }
                                        ?>
                                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium <?= $typeClass ?>">
                                            <?= esc($activity['type']) ?>
                                        </span>
                                    </div>
                                    <div class="w-1/5">
                                        <p class="text-sm font-medium text-gray-900"><?= esc($activity['user_name'] ?? 'System') ?></p>
                                        <p class="text-xs text-gray-500"><?= esc($activity['user_role'] ?? 'Automated') ?></p>
                                    </div>
                                    <div class="w-1/4">
                                        <p class="text-sm text-gray-800"><?= esc($activity['action'] ?? '') ?></p>
                                    </div>
                                    <div class="w-1/5">
                                        <p class="text-sm text-gray-800"><?= esc($activity['date'] ?? '') ?></p>
                                        <p class="text-xs text-gray-500"><?= esc($activity['time'] ?? '') ?></p>
                                    </div>
                                    <div class="w-1/6 flex justify-end">
                                        <button class="text-xs text-blue-500 hover:text-blue-700 font-medium px-3 py-1 rounded border border-blue-200 hover:bg-blue-50 view-activity-btn" data-activity-id="<?= $activity['id'] ?? 0 ?>">
                                            View Details
                                        </button>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <!-- Empty State -->
                            <div class="text-center py-8 bg-white">
                                <div class="text-gray-400 mb-3"><i class="fas fa-history text-3xl"></i></div>
                                <p class="text-gray-500">No activity logs found.</p>
                                <p class="text-sm text-gray-400 mt-1">Activity logs will appear here when actions are performed.</p>
                            </div>
                        <?php endif; ?>
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
                <?php if (isset($activityDetails) && !empty($activityDetails)) : ?>
                <!-- Basic Information -->
                <div class="mb-6">
                    <div class="flex items-center">
                        <div id="activityTypeBadge" class="px-2.5 py-0.5 rounded-full text-xs font-medium 
                            <?php if (esc($activityDetails['type']) === 'Admin') : ?>
                                bg-purple-100 text-purple-800
                            <?php elseif (esc($activityDetails['type']) === 'Staff') : ?>
                                bg-blue-100 text-blue-800
                            <?php else : ?>
                                bg-gray-100 text-gray-800
                            <?php endif; ?> mr-3">
                            <?= esc($activityDetails['type']) ?>
                        </div>
                        <div id="activityDate" class="text-sm text-gray-500">
                            <?= esc($activityDetails['date']) ?> • <?= esc($activityDetails['time']) ?>
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
                                <span id="activityUser" class="text-sm font-medium text-right"><?= esc($activityDetails['user_name']) ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500">Role:</span>
                                <span id="activityRole" class="text-sm font-medium text-right"><?= esc($activityDetails['user_role']) ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500">Department:</span>
                                <span id="activityDepartment" class="text-sm font-medium text-right"><?= esc($activityDetails['user_department']) ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500">IP Address:</span>
                                <span id="activityIPAddress" class="text-sm font-medium text-right"><?= esc($activityDetails['ip_address']) ?></span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Action Information -->
                    <div class="bg-white rounded-lg border border-gray-200 p-4">
                        <h4 class="text-sm font-semibold text-gray-700 mb-4 border-b pb-2 text-center">Action Information</h4>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500">Action Type:</span>
                                <span id="actionType" class="text-sm font-medium text-right"><?= esc($activityDetails['action_type']) ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500">Resource:</span>
                                <span id="actionResource" class="text-sm font-medium text-right"><?= esc($activityDetails['resource']) ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500">Status:</span>
                                <span id="actionStatus" class="text-sm font-medium text-right"><?= esc($activityDetails['status']) ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500">Duration:</span>
                                <span id="actionDuration" class="text-sm font-medium text-right"><?= esc($activityDetails['duration']) ?></span>
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
                                <span id="actionSummary"><?= esc($activityDetails['summary']) ?></span>
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
                                    <?php if (!empty($activityDetails['changed_fields'])) : ?>
                                        <?php foreach ($activityDetails['changed_fields'] as $field) : ?>
                                            <div class="grid grid-cols-3 text-sm border-t pt-2">
                                                <div class="text-gray-700"><?= esc($field['name']) ?></div>
                                                <div class="text-gray-500"><?= esc($field['old_value'] ?? '-') ?></div>
                                                <div class="text-green-600"><?= esc($field['new_value']) ?></div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <div class="text-sm text-gray-500 py-2 text-center">No fields were changed</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- System Notes -->
                <div class="bg-white rounded-lg border border-gray-200 p-4 mb-6">
                    <h4 class="text-sm font-semibold text-gray-700 mb-3 border-b pb-2 text-center">System Notes</h4>
                    <p id="systemNotes" class="text-sm text-gray-700">
                        <?= esc($activityDetails['system_notes']) ?>
                    </p>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex justify-center space-x-3">
                    <button class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-md font-medium text-sm transition-colors" 
                            data-activity-id="<?= esc($activityDetails['id']) ?>">
                        <i class="fas fa-print mr-2"></i>Print Activity
                    </button>
                    <button class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-md font-medium text-sm transition-colors"
                            data-activity-id="<?= esc($activityDetails['id']) ?>">
                        <i class="fas fa-history mr-2"></i>View Related Activities
                    </button>
                </div>
                <?php else : ?>
                <div class="flex flex-col items-center justify-center py-8">
                    <div class="text-gray-400 mb-3">
                        <i class="fas fa-search fa-3x"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-700 mb-1">No Activity Details Found</h3>
                    <p class="text-sm text-gray-500 text-center max-w-md">
                        Activity details will appear here when you select an activity from the log.
                    </p>
                </div>
                <?php endif; ?>
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
<script src="<?= base_url('js/notifications.js') ?>" defer></script>
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
