<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<h1 class="text-2xl font-bold mb-4 text-gray-700 dark-mode-text tracking-wide">Manage Rooms</h1>

<!-- Room Search and Filters -->
<div class="card bg-white shadow-md rounded-lg p-6 mb-6">
    <h2 class="text-xl font-bold mb-4">Room Search</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Room Number</label>
            <input type="text" class="w-full p-2 border border-gray-300 rounded-md" placeholder="Enter room number">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Room Type</label>
            <select class="w-full p-2 border border-gray-300 rounded-md">
                <option value="">All Types</option>
                <option value="single">Single</option>
                <option value="double">Double</option>
                <option value="triple">Triple</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <select class="w-full p-2 border border-gray-300 rounded-md">
                <option value="">All Statuses</option>
                <option value="available">Available</option>
                <option value="occupied">Occupied</option>
                <option value="maintenance">Under Maintenance</option>
                <option value="blocked">Blocked</option>
            </select>
        </div>
    </div>
    <div class="flex justify-end">
        <button class="bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700">
            <i class="fas fa-search mr-2"></i>Search
        </button>
    </div>
</div>

<!-- Room Listing -->
<div class="card bg-white shadow-md rounded-lg p-6 mb-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold">Room List</h2>
        <button class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
            <i class="fas fa-plus mr-2"></i>Add New Room
        </button>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-3 px-4 text-left text-sm font-medium text-gray-600">Room No.</th>
                    <th class="py-3 px-4 text-left text-sm font-medium text-gray-600">Type</th>
                    <th class="py-3 px-4 text-left text-sm font-medium text-gray-600">Bedspaces</th>
                    <th class="py-3 px-4 text-left text-sm font-medium text-gray-600">Available</th>
                    <th class="py-3 px-4 text-left text-sm font-medium text-gray-600">Status</th>
                    <th class="py-3 px-4 text-left text-sm font-medium text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <!-- Example rooms - In a real app, these would come from your database -->
                <tr class="hover:bg-gray-50">
                    <td class="py-3 px-4 text-sm text-gray-700">101</td>
                    <td class="py-3 px-4 text-sm text-gray-700">Double</td>
                    <td class="py-3 px-4 text-sm text-gray-700">2</td>
                    <td class="py-3 px-4 text-sm text-gray-700">1</td>
                    <td class="py-3 px-4 text-sm">
                        <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded-full text-xs">Partially Available</span>
                    </td>
                    <td class="py-3 px-4 text-sm text-gray-700">
                        <button class="text-blue-500 hover:text-blue-700 mr-2">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="text-purple-500 hover:text-purple-700 mr-2">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="text-red-500 hover:text-red-700">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                <tr class="hover:bg-gray-50">
                    <td class="py-3 px-4 text-sm text-gray-700">102</td>
                    <td class="py-3 px-4 text-sm text-gray-700">Single</td>
                    <td class="py-3 px-4 text-sm text-gray-700">1</td>
                    <td class="py-3 px-4 text-sm text-gray-700">0</td>
                    <td class="py-3 px-4 text-sm">
                        <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full text-xs">Occupied</span>
                    </td>
                    <td class="py-3 px-4 text-sm text-gray-700">
                        <button class="text-blue-500 hover:text-blue-700 mr-2">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="text-purple-500 hover:text-purple-700 mr-2">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="text-red-500 hover:text-red-700">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                <tr class="hover:bg-gray-50">
                    <td class="py-3 px-4 text-sm text-gray-700">103</td>
                    <td class="py-3 px-4 text-sm text-gray-700">Triple</td>
                    <td class="py-3 px-4 text-sm text-gray-700">3</td>
                    <td class="py-3 px-4 text-sm text-gray-700">3</td>
                    <td class="py-3 px-4 text-sm">
                        <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs">Available</span>
                    </td>
                    <td class="py-3 px-4 text-sm text-gray-700">
                        <button class="text-blue-500 hover:text-blue-700 mr-2">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="text-purple-500 hover:text-purple-700 mr-2">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="text-red-500 hover:text-red-700">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                <tr class="hover:bg-gray-50">
                    <td class="py-3 px-4 text-sm text-gray-700">104</td>
                    <td class="py-3 px-4 text-sm text-gray-700">Double</td>
                    <td class="py-3 px-4 text-sm text-gray-700">2</td>
                    <td class="py-3 px-4 text-sm text-gray-700">0</td>
                    <td class="py-3 px-4 text-sm">
                        <span class="bg-red-100 text-red-700 px-2 py-1 rounded-full text-xs">Maintenance</span>
                    </td>
                    <td class="py-3 px-4 text-sm text-gray-700">
                        <button class="text-blue-500 hover:text-blue-700 mr-2">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="text-purple-500 hover:text-purple-700 mr-2">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="text-red-500 hover:text-red-700">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    <div class="mt-4 flex justify-between items-center">
        <p class="text-sm text-gray-600">Showing 1-4 of 32 rooms</p>
        <div class="flex space-x-2">
            <button class="px-3 py-1 border border-gray-300 rounded-md text-sm disabled:opacity-50">Previous</button>
            <button class="px-3 py-1 bg-purple-600 text-white rounded-md text-sm">1</button>
            <button class="px-3 py-1 border border-gray-300 rounded-md text-sm">2</button>
            <button class="px-3 py-1 border border-gray-300 rounded-md text-sm">3</button>
            <button class="px-3 py-1 border border-gray-300 rounded-md text-sm">Next</button>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Room specific JavaScript can go here
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Manage Room page loaded');
    });
</script>
<?= $this->endSection() ?>
