// Zoom and pan functionality for floor plan
let isDragging = false;
let startX, startY;
let translateX = 0, translateY = 0;
let scale = 1;
let lastTranslateX = 0, lastTranslateY = 0;
const PAN_STEP = 30;

// Apply zoom and pan transformations
function applyZoom() {
    const floorPlanWrapper = document.getElementById('floorPlanWrapper');
    if (!floorPlanWrapper) return;

    floorPlanWrapper.style.transform = `translate(${translateX}px, ${translateY}px) scale(${scale})`;

    // Update room overlays after zoom/pan
    if (typeof setRoomOverlays === 'function') {
        setRoomOverlays();
    }

    // Update zoom level display if it exists
    const zoomLevel = document.getElementById('zoomLevel');
    if (zoomLevel) {
        zoomLevel.textContent = `${Math.round(scale * 100)}%`;
    }

    // Enable/disable zoom buttons based on current scale
    const zoomInBtn = document.getElementById('zoomIn');
    const zoomOutBtn = document.getElementById('zoomOut');
    
    if (zoomInBtn) {
        zoomInBtn.disabled = scale >= 3;
    }
    
    if (zoomOutBtn) {
        zoomOutBtn.disabled = scale <= 0.5;
    }
}

// Zoom in function
function zoomIn() {
    scale *= 1.2;
    applyZoom();
}

// Zoom out function
function zoomOut() {
    scale /= 1.2;
    applyZoom();
}

// Start dragging
function startDrag(e) {
    if (e.type === 'touchstart') {
        startX = e.touches[0].clientX;
        startY = e.touches[0].clientY;
    } else {
        startX = e.clientX;
        startY = e.clientY;
    }
    
    isDragging = true;
    
    const floorPlanContainer = document.getElementById('floorPlanContainer');
    if (floorPlanContainer) {
        floorPlanContainer.style.cursor = 'grabbing';
    }
    
    e.preventDefault();
}

// Dragging
function drag(e) {
    if (!isDragging) return;
    
    let currentX, currentY;
    if (e.type === 'touchmove') {
        currentX = e.touches[0].clientX;
        currentY = e.touches[0].clientY;
        e.preventDefault();
    } else {
        currentX = e.clientX;
        currentY = e.clientY;
        e.preventDefault();
    }
    
    const dx = currentX - startX;
    const dy = currentY - startY;
    translateX += dx;
    translateY += dy;
    
    // Apply limits to prevent dragging too far
    const maxDrag = 1000 * scale;
    translateX = Math.max(-maxDrag, Math.min(translateX, maxDrag));
    translateY = Math.max(-maxDrag, Math.min(translateY, maxDrag));
    
    applyZoom();
    startX = currentX; // Update start positions
    startY = currentY;
}

// End dragging
function endDrag() {
    isDragging = false;
    const floorPlanContainer = document.getElementById('floorPlanContainer');
    if (floorPlanContainer) {
        floorPlanContainer.style.cursor = 'grab';
    }
}

// Reset view to default
function resetView() {
    scale = 1;
    translateX = 0;
    translateY = 0;
    applyZoom();
}

// Initialize zoom and pan functionality
document.addEventListener("DOMContentLoaded", function () {
    const floorPlanContainer = document.getElementById('floorPlanContainer');
    const zoomInBtn = document.getElementById('zoomIn');
    const zoomOutBtn = document.getElementById('zoomOut');
    const resetBtn = document.getElementById('resetView');
    
    if (floorPlanContainer) {
        floorPlanContainer.addEventListener('mousedown', startDrag);
        floorPlanContainer.addEventListener('touchstart', startDrag, { passive: false });
        document.addEventListener('mousemove', drag);
        document.addEventListener('touchmove', drag, { passive: false });
        document.addEventListener('mouseup', endDrag);
        document.addEventListener('touchend', endDrag);
        
        // Mouse wheel zoom
        /*floorPlanContainer.addEventListener('wheel', function(e) {
            e.preventDefault();
            if (e.deltaY < 0) {
                zoomIn();
            } else {
                zoomOut();
            }
        });*/
    }
    
    // Button controls
    if (zoomInBtn) {
        zoomInBtn.addEventListener('click', zoomIn);
    }
    
    if (zoomOutBtn) {
        zoomOutBtn.addEventListener('click', zoomOut);
    }
    
    if (resetBtn) {
        resetBtn.addEventListener('click', resetView);
    }
    
    // Initialize floor plan image
    const floorPlanImage = document.getElementById('floorPlanImage');
    if (floorPlanImage) {
        floorPlanImage.addEventListener('load', function () {
            floorPlanImage.style.width = '100%';
            floorPlanImage.style.height = 'auto';
            if (typeof setRoomOverlays === 'function') {
                setRoomOverlays();
            }
            applyZoom(); // Initialize position
        });
    }
}); 