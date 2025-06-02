<!DOCTYPE html>
<html>
    
<head>
    <title><?= $title ?? 'RSC7 System' ?></title>
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
    <script src="<?= base_url('js/sidebar.js') ?>"></script>
    <script src="<?= base_url('js/notifications.js') ?>"></script>
    
    <?= $this->renderSection('styles') ?>
    
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
                            <li class="nav-item flex items-center p-4 text-gray-700 <?= uri_string() === '' ? 'bg-gray-200' : 'hover:bg-gray-200' ?>">
                                <i class="fas fa-home <?= uri_string() === '' ? 'text-purple-600' : '' ?>"></i>
                                <span class="ml-4 hidden">Dashboard</span>
                            </li>
                        </a>
                        <a href="<?= base_url('manage-room') ?>">
                            <li class="nav-item flex items-center p-4 text-gray-700 <?= uri_string() === 'manage-room' ? 'bg-gray-200' : 'hover:bg-gray-200' ?>">
                                <i class="fas fa-bed <?= uri_string() === 'manage-room' ? 'text-purple-600' : '' ?>"></i>
                                <span class="ml-4 hidden">Manage Room</span>
                            </li>
                        </a>
                        <a href="<?= base_url('manage-tenant') ?>">
                        <li class="nav-item flex items-center p-4 text-gray-700 <?= uri_string() === 'manage-tenant' ? 'bg-gray-200' : 'hover:bg-gray-200' ?>">
                            <i class="fas fa-user <?= uri_string() === 'manage-tenant' ? 'text-purple-600' : '' ?>"></i>
                            <span class="ml-4 hidden">Manage Tenant</span>
                        </li>
                        </a>
                        <a href="<?= base_url('maintenance') ?>">
                        <li class="nav-item flex items-center p-4 text-gray-700 <?= uri_string() === 'maintenance' ? 'bg-gray-200' : 'hover:bg-gray-200' ?>">
                            <i class="fas fa-tools <?= uri_string() === 'maintenance' ? 'text-purple-600' : '' ?>"></i>
                            <span class="ml-4 hidden">Maintenance</span>
                        </li>
                        </a>
                        <a href="<?= base_url('floor-plan') ?>">
                        <li class="nav-item flex items-center p-4 text-gray-700 <?= uri_string() === 'floor-plan' ? 'bg-gray-200' : 'hover:bg-gray-200' ?>">
                            <i class="fas fa-th-large <?= uri_string() === 'floor-plan' ? 'text-purple-600' : '' ?>"></i>
                            <span class="ml-4 hidden">Floor Plan</span>
                        </li>
                        </a>
                        <a href="<?= base_url('generate-report') ?>">
                        <li class="nav-item flex items-center p-4 text-gray-700 <?= uri_string() === 'generate-report' ? 'bg-gray-200' : 'hover:bg-gray-200' ?>">
                            <i class="fas fa-file-alt <?= uri_string() === 'generate-report' ? 'text-purple-600' : '' ?>"></i>
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
                        <span class="text-gray-500 mr-4"><?= date('h:i A', time() + (8 * 3600)) ?></span>
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
                                <button class="text-gray-500" id="notificationToggle">
                                    <i class="fas fa-bell"></i>
                                </button>
                                <div class="absolute right-0 mt-2 w-64 bg-white shadow-lg rounded-lg" id="notificationPanel">
                                    <div class="p-3 border-b border-gray-200">
                                        <h3 class="text-sm font-semibold text-gray-700">Notifications</h3>
                                    </div>
                                    <ul class="p-2 max-h-64 overflow-y-auto">
                                        <!-- Notification items will be populated by JavaScript -->
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
                    <?= $this->renderSection('content') ?>
                </main>
            </div>
        </div>
    </div>

    <?= $this->renderSection('modals') ?>
    
    <?= $this->renderSection('scripts') ?>
</body>
</html>
