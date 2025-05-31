// Floor plan selector functionality
document.addEventListener("DOMContentLoaded", function () {
    const floorSelector = document.getElementById('floorSelector');
    
    // Update the floor selector options to point to the new image paths
    if (floorSelector) {
        // Update the options to point to the new image paths
        Array.from(floorSelector.options).forEach(option => {
            if (option.value.includes('RSC7_B')) {
                option.value = 'images/' + option.value;
            }
        });
        
        floorSelector.addEventListener('change', function() {
            const selectedFloor = this.value;
            const floorPlanImage = document.getElementById('floorPlanImage');
            
            if (floorPlanImage) {
                // Extract floor number from filename
                const floorMatch = selectedFloor.match(/B(\d+)/);
                const floorNumber = floorMatch ? floorMatch[1] : '1';

                // Hide all overlays immediately
                const allOverlays = document.querySelectorAll('.room-overlay');
                allOverlays.forEach(overlay => {
                    overlay.style.display = "none"; // Change opacity to display none
                });

                // Change the image source
                floorPlanImage.src = selectedFloor;

                // Show only the overlays for the selected floor
                const currentFloorOverlays = document.querySelectorAll(`.floor-${floorNumber}`);
                currentFloorOverlays.forEach(overlay => {
                    overlay.style.display = "block"; // Show overlays for the new floor
                });

                // Reset zoom and position
                if (typeof resetView === 'function') {
                    resetView();
                }

                // Wait for the new image to load before recalculating overlays
                floorPlanImage.onload = function() {
                    if (typeof setRoomOverlays === 'function') {
                        setRoomOverlays();
                    }
                };
            }
        });
    }
    
    // Navigation buttons for floor plan
    const navUp = document.getElementById('navUp');
    const navDown = document.getElementById('navDown');
    const navLeft = document.getElementById('navLeft');
    const navRight = document.getElementById('navRight');
    
    // Pan amount in pixels
    const panAmount = 50;
    
    if (navUp) {
        navUp.addEventListener('click', function() {
            if (typeof translateY !== 'undefined') {
                translateY += panAmount;
                if (typeof applyZoom === 'function') {
                    applyZoom();
                }
            }
        });
    }
    
    if (navDown) {
        navDown.addEventListener('click', function() {
            if (typeof translateY !== 'undefined') {
                translateY -= panAmount;
                if (typeof applyZoom === 'function') {
                    applyZoom();
                }
            }
        });
    }
    
    if (navLeft) {
        navLeft.addEventListener('click', function() {
            if (typeof translateX !== 'undefined') {
                translateX += panAmount;
                if (typeof applyZoom === 'function') {
                    applyZoom();
                }
            }
        });
    }
    
    if (navRight) {
        navRight.addEventListener('click', function() {
            if (typeof translateX !== 'undefined') {
                translateX -= panAmount;
                if (typeof applyZoom === 'function') {
                    applyZoom();
                }
            }
        });
    }
}); 