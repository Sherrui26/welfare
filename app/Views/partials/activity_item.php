<div class="timeline-item relative rounded-lg p-3 bg-gradient-to-r from-white to-gray-50 border border-gray-100">
    <!-- Colored dot -->
    <div class="absolute -left-6 top-4 w-3 h-3 bg-<?= $color ?>-500 rounded-full shadow-sm z-10"></div>
    <div class="flex justify-between items-start">
        <div class="flex items-start">
            <div class="h-10 w-10 rounded-full bg-<?= $color ?>-100 flex items-center justify-center mr-3 shadow-sm border border-<?= $color ?>-200">
                <i class="fas <?= $icon ?> text-<?= $color ?>-600"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-800"><?= esc($title) ?></p>
                <p class="text-xs text-gray-500 mt-0.5"><?= esc($description) ?></p>
            </div>
        </div>
        <span class="text-xs text-gray-400 bg-gray-50 px-2 py-1 rounded-full"><?= esc($time) ?></span>
    </div>
</div>
