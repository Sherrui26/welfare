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
