<!DOCTYPE html>
<html>
    
<head>
    <title>RSC7 System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="<?= base_url('css/main.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/dark-mode.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/modal-transitions.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/floorplan.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/manage-room.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/modals.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/scrollbar.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/footer.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/record-buttons.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/simple-row-highlight.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/index/index-main.css') ?>">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&amp;display=swap" rel="stylesheet" />
    <script src="<?= base_url('js/main.js') ?>"></script>
    <script src="<?= base_url('js/dashboard.js') ?>"></script>
    <script src="<?= base_url('js/modal-transitions.js') ?>"></script>
    <script src="<?= base_url('js/darkmode.js') ?>"></script>
    <script src="<?= base_url('js/room-overlays.js') ?>"></script>
    <script src="<?= base_url('js/zoom-pan.js') ?>"></script>
    <script src="<?= base_url('js/floor-selector.js') ?>"></script>
    <script src="<?= base_url('js/sidebar.js') ?>"></script>
    <script src="<?= base_url('js/notifications.js') ?>"></script>
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
    
    <script>
        // Apply dark mode immediately if user had it enabled
        (function() {
            if (localStorage.getItem('darkMode') === 'true') {
                document.documentElement.classList.add('dark-mode');
            }
        })();
    </script>
    
</head>

<body class="bg-gray-100 font-roboto">
    <div class="flex min-h-screen">
        <!-- Side Navigation -->
        <div class="bg-white shadow-md sidebar-collapsed transition-all duration-300 fixed top-0 left-0 h-screen z-50"
            id="sidebar">
            <div class="flex flex-col h-full">
                <div class="flex items-center h-16 px-4">
                    <button id="toggleSidebar" class="flex items-center text-gray-700 hover:text-purple-500">
                        <img src="https://placehold.co/32x32" alt="Logo" class="logo-image rounded" />
                        <span class="logo-text ml-3 font-semibold">RSC7 System</span>
                    </button>
                </div>
                <hr class="border-gray-300 my-1">
                <nav class="flex-grow">
                    <ul class="space-y-2">
                        <a href="<?= base_url('/') ?>">
                            <li class="nav-item flex items-center p-4 text-gray-700 bg-gray-200">
                                <i class="fas fa-home text-purple-600"></i>
                                <span class="ml-4 hidden">Dashboard</span>
                            </li>
                        </a>
                        <a href="<?= base_url('manage-room') ?>">
                            <li class="nav-item flex items-center p-4 text-gray-700 hover:bg-gray-200">
                                <i class="fas fa-bed"></i>
                                <span class="ml-4 hidden">Manage Room</span>
                            </li>
                        </a>
                        <a href="<?= base_url('manage-tenant') ?>">
                        <li class="nav-item flex items-center p-4 text-gray-700 hover:bg-gray-200">
                            <i class="fas fa-user"></i>
                            <span class="ml-4 hidden">Manage Tenant</span>
                        </li>
                        </a>
                        <a href="<?= base_url('maintenance') ?>">
                        <li class="nav-item flex items-center p-4 text-gray-700 hover:bg-gray-200">
                            <i class="fas fa-tools"></i>
                            <span class="ml-4 hidden">Maintenance</span>
                        </li>
                        </a>
                        <a href="<?= base_url('floor-plan') ?>">
                        <li class="nav-item flex items-center p-4 text-gray-700 hover:bg-gray-200">
                            <i class="fas fa-th-large"></i>
                            <span class="ml-4 hidden">Floor Plan</span>
                        </li>
                        </a>
                        <a href="<?= base_url('generate-report') ?>">
                        <li class="nav-item flex items-center p-4 text-gray-700 hover:bg-gray-200">
                            <i class="fas fa-file-alt"></i>
                            <span class="ml-4 hidden">Reports</span>
                        </li>
                        </a>
                        <li class="nav-item flex items-center p-4 text-gray-700 hover:bg-gray-200">
                            <i class="fas fa-sign-out-alt"></i>
                            <span class="ml-4 hidden">Logout</span>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <div class="flex-grow">
            <!-- Header -->
            <header class="bg-white shadow-md fixed top-0 transition-all duration-300 z-40" id="header">
                <div class="container mx-auto px-4 py-2 flex justify-between items-center">
                    <div class="flex items-center">
                        <button class="text-gray-500 mr-4">
                            <i class="fas fa-arrow-left"></i>
                            Back
                        </button>
                        <span class="text-gray-500"><?= date('M d, Y') ?></span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-gray-500 mr-4"><?= date('h:i A') ?></span>
                        <div class="flex items-center">
                            <span class="text-gray-500 mr-2">English</span>
                            <img alt="User avatar" class="rounded-full" height="30"
                                src="https://storage.googleapis.com/a1aa/image/qzDnqRLa_XhBeCBbsYSfuNvqerhseVq6B4N-FhHOB0s.jpg"
                                width="30" />
                            <span class="text-gray-500 ml-2">John Doe</span>
                            <button class="text-gray-500 ml-4" id="toggleDarkMode">
                                <i class="fas fa-moon"></i>
                            </button>
                            <div class="relative ml-4">
                                <button class="text-gray-500 has-notifications" id="notificationToggle">
                                    <i class="fas fa-bell"></i>
                                </button>
                                <div class="absolute right-0 mt-2 w-64 bg-white shadow-lg rounded-lg" id="notificationPanel">
                                    <div class="p-3 border-b border-gray-200">
                                        <h3 class="text-sm font-semibold text-gray-700">Notifications</h3>
                                    </div>
                                    <ul class="p-2 max-h-64 overflow-y-auto">
                                        <li class="notification-item p-2 hover:bg-gray-50 rounded border-b border-gray-100">
                                            <div class="flex items-start">
                                                <div class="flex-shrink-0 bg-yellow-100 rounded-full p-1">
                                                    <i class="fas fa-user-clock text-yellow-500 text-sm"></i>
                                                </div>
                                                <div class="ml-2">
                                                    <p class="text-xs font-medium text-gray-700">Room 102 tenant leaving in 5 days</p>
                                                    <p class="text-xs text-gray-500 mt-1">Today, 10:30 AM</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="notification-item p-2 hover:bg-gray-50 rounded border-b border-gray-100">
                                            <div class="flex items-start">
                                                <div class="flex-shrink-0 bg-red-100 rounded-full p-1">
                                                    <i class="fas fa-exclamation-triangle text-red-500 text-sm"></i>
                                                </div>
                                                <div class="ml-2">
                                                    <p class="text-xs font-medium text-gray-700">Urgent maintenance issue in Room 202</p>
                                                    <p class="text-xs text-gray-500 mt-1">Yesterday, 8:15 PM</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="notification-item p-2 hover:bg-gray-50 rounded">
                                            <div class="flex items-start">
                                                <div class="flex-shrink-0 bg-green-100 rounded-full p-1">
                                                    <i class="fas fa-check-circle text-green-500 text-sm"></i>
                                                </div>
                                                <div class="ml-2">
                                                    <p class="text-xs font-medium text-gray-700">New check-in: Room 303</p>
                                                    <p class="text-xs text-gray-500 mt-1">Feb 15, 2:45 PM</p>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="p-2 border-t border-gray-200">
                                        <a href="#" class="text-xs text-blue-500 hover:text-blue-700 font-medium block text-center" id="viewAllNotificationsBtn">View all notifications</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <!-- Main Content -->
            <div class="flex-grow transition-all duration-300" id="mainContent"
                style="margin-left: 64px; margin-top: 64px;">
                <main class="container mx-auto px-4 py-1">
                    <h1 class="text-2xl font-bold mb-4 text-gray-700 dark-mode-text tracking-wide">Welcome, Sharul
                        Aiman.</h1>

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
                </main>
            </div>
        </div>
    </div>
</body>
</html>
