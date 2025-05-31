// Room overlay functionality
function setRoomOverlays() {
    // Check which floor plan image is currently displayed
    const floorPlanImage = document.getElementById('floorPlanImage');

    if (!floorPlanImage) {
        console.warn('Floor plan image not found');
        return;
    }

    // Make sure image dimensions are available
    if (floorPlanImage.naturalWidth === 0) {
        floorPlanImage.onload = setRoomOverlays;
        return;
    }

    const imgSrc = floorPlanImage.src;
    const imgWidth = floorPlanImage.naturalWidth;
    const imgHeight = floorPlanImage.naturalHeight;
    const renderedWidth = floorPlanImage.clientWidth;
    const renderedHeight = floorPlanImage.clientHeight;

    const widthScale = renderedWidth / imgWidth;
    const heightScale = renderedHeight / imgHeight;

    // Detect which floor based on image src
    const currentFloor = determineFloorFromImageSrc(imgSrc);

    // Set all room overlays based on current floor
    // First, make all overlays invisible
    const allRooms = document.querySelectorAll('.room-overlay');
    allRooms.forEach(room => {
        room.style.visibility = 'hidden';
    });

    // Then make only the relevant floor's rooms visible and position them
    if (currentFloor === 1) {
        // Show Floor 1 rooms
        const floor1Rooms = document.querySelectorAll('.floor-1');
        floor1Rooms.forEach(room => {
            room.style.visibility = 'visible';
        });

        // Floor 1 rectangular rooms
        setRectRoom('room-1', 3760, 2574, 4408, 3035, widthScale, heightScale);
        setRectRoom('room-2', 3760, 3046, 4408, 3499, widthScale, heightScale);
        setRectRoom('room-3', 3760, 3505, 4408, 4029, widthScale, heightScale);
        setRectRoom('room-4', 3760, 4035, 4408, 4366, widthScale, heightScale);
        setRectRoom('room-5', 4836, 3499, 5455, 4041, widthScale, heightScale);
        setRectRoom('room-6', 4836, 3043, 5455, 3505, widthScale, heightScale);
        setRectRoom('room-9', 5616, 3510, 6400, 4035, widthScale, heightScale);
        setRectRoom('room-10', 5616, 4045, 6388, 4522, widthScale, heightScale);

        // Floor 1 polygon rooms
        setPolygonRoom('room-7', [
            { x: 4836, y: 2575 },
            { x: 5275, y: 2575 },
            { x: 5461, y: 2720 },
            { x: 5455, y: 3039 },
            { x: 4836, y: 3039 }
        ], widthScale, heightScale);

        setPolygonRoom('room-8', [
            { x: 5618, y: 3039 },
            { x: 6231, y: 3033 },
            { x: 6400, y: 3165 },
            { x: 6394, y: 3508 },
            { x: 5618, y: 3502 }
        ], widthScale, heightScale);
    }
    else if (currentFloor === 2) {
        // Show Floor 2 rooms - all rooms that don't have .floor-1 or .floor-3 classes
        const floor2Rooms = document.querySelectorAll('.floor-2');
        floor2Rooms.forEach(room => {
            room.style.visibility = 'visible';
        });

        // Floor 2 rectangular rooms
        setRectRoom('room-7-02-18', 3297, 1584, 3796, 1994, widthScale, heightScale);
        setRectRoom('room-7-02-17', 3291, 1994, 3796, 2409, widthScale, heightScale);
        setRectRoom('room-7-02-16', 3285, 2412, 3796, 2837, widthScale, heightScale);
        setRectRoom('room-7-02-15', 3291, 2837, 3796, 3222, widthScale, heightScale);
        setRectRoom('room-7-02-14', 3291, 3210, 3796, 3577, widthScale, heightScale);
        setRectRoom('room-7-02-19', 3291, 1199, 3796, 1584, widthScale, heightScale);
        setRectRoom('room-7-02-20', 3958, 1996, 4428, 2418, widthScale, heightScale);
        setRectRoom('room-7-02-21', 3958, 2416, 4428, 2839, widthScale, heightScale);
        setRectRoom('room-7-02-22', 3958, 2833, 4428, 3212, widthScale, heightScale);
        setRectRoom('room-7-02-23', 3958, 3211, 4422, 3578, widthScale, heightScale);
        setRectRoom('room-7-02-04-rect', 4801, 2850, 5318, 3212, widthScale, heightScale);
        setRectRoom('room-7-02-27', 5529, 3124, 5890, 3720, widthScale, heightScale);
        setRectRoom('room-7-02-08', 2473, 1198, 2942, 1581, widthScale, heightScale);
        setRectRoom('room-7-02-09', 2473, 1589, 2942, 1993, widthScale, heightScale);
        setRectRoom('room-7-02-10', 2473, 1999, 2942, 2412, widthScale, heightScale);
        setRectRoom('room-7-02-11', 2473, 2408, 2942, 2839, widthScale, heightScale);
        setRectRoom('room-7-02-12', 2473, 2847, 2948, 3209, widthScale, heightScale);
        setRectRoom('room-7-02-13', 2473, 3227, 2942, 3573, widthScale, heightScale);
        setRectRoom('room-7-02-07', 1847, 1999, 2334, 2418, widthScale, heightScale);
        setRectRoom('room-7-02-06', 1853, 2413, 2334, 2839, widthScale, heightScale);
        setRectRoom('room-7-02-05', 1847, 2840, 2334, 3212, widthScale, heightScale);
        setRectRoom('room-7-02-02', 975, 3213, 1504, 3573, widthScale, heightScale);

        // Floor 2 polygon rooms
        setPolygonRoom('room-7-02-25', [
            { x: 4789, y: 1969 },
            { x: 5168, y: 1975 },
            { x: 5180, y: 2360 },
            { x: 5517, y: 2363 },
            { x: 5523, y: 2833 },
            { x: 4789, y: 2841 }
        ], widthScale, heightScale);

        setPolygonRoom('room-7-02-26', [
            { x: 5890, y: 3124 },
            { x: 6178, y: 3130 },
            { x: 6293, y: 3245 },
            { x: 6678, y: 3251 },
            { x: 6672, y: 3720 },
            { x: 5896, y: 3714 }
        ], widthScale, heightScale);

        setPolygonRoom('room-7-02-01', [
            { x: 126, y: 3251 },
            { x: 752, y: 3251 },
            { x: 752, y: 3522 },
            { x: 644, y: 3504 },
            { x: 638, y: 3734 },
            { x: 114, y: 3728 }
        ], widthScale, heightScale);

        setPolygonRoom('room-7-02-03', [
            { x: 1029, y: 2835 },
            { x: 1504, y: 2847 },
            { x: 1498, y: 3215 },
            { x: 975, y: 3212 },
            { x: 981, y: 2935 }
        ], widthScale, heightScale);

        setPolygonRoom('room-7-02-04-poly', [
            { x: 1041, y: 2839 },
            { x: 1498, y: 2099 },
            { x: 1498, y: 2845 }
        ], widthScale, heightScale);
    }
    else if (currentFloor === 3) {
        // Show Floor 3 rooms
        const floor3Rooms = document.querySelectorAll('.floor-3');
        floor3Rooms.forEach(room => {
            room.style.visibility = 'visible';
        });

        // Floor 3 rooms positioning would go here
        setRectRoom('room-301', 3760, 2574, 4408, 3035, widthScale, heightScale);
        setRectRoom('room-302', 4836, 3043, 5455, 3505, widthScale, heightScale);
        // Add more rooms for floor 3 as needed
    }
}

// Helper function to detect floor from image source
function determineFloorFromImageSrc(src) {
    if (src.includes('B1') || src.toLowerCase().includes('floor1')) {
        return 1;
    } else if (src.includes('B2') || src.toLowerCase().includes('floor2')) {
        return 2;
    } else if (src.includes('B3') || src.toLowerCase().includes('floor3')) {
        return 3;
    }
    return 1; // Default to floor 1
}

// Helper function to position rectangular room overlays
function setRectRoom(id, x1, y1, x2, y2, widthScale, heightScale) {
    const room = document.getElementById(id);
    if (!room) return;

    const left = x1 * widthScale;
    const top = y1 * heightScale;
    const width = (x2 - x1) * widthScale;
    const height = (y2 - y1) * heightScale;

    room.style.left = `${left}px`;
    room.style.top = `${top}px`;
    room.style.width = `${width}px`;
    room.style.height = `${height}px`;
}

// Helper function to position polygon room overlays
function setPolygonRoom(id, points, widthScale, heightScale) {
    const room = document.getElementById(id);
    if (!room) return;

    // Find bounding box
    let minX = Infinity, minY = Infinity, maxX = 0, maxY = 0;
    points.forEach(point => {
        minX = Math.min(minX, point.x);
        minY = Math.min(minY, point.y);
        maxX = Math.max(maxX, point.x);
        maxY = Math.max(maxY, point.y);
    });

    // Position the container div
    const left = minX * widthScale;
    const top = minY * heightScale;
    const width = (maxX - minX) * widthScale;
    const height = (maxY - minY) * heightScale;

    room.style.left = `${left}px`;
    room.style.top = `${top}px`;
    room.style.width = `${width}px`;
    room.style.height = `${height}px`;

    // Create polygon shape for the div
    const polygonPoints = points.map(point => {
        const x = (point.x - minX) * widthScale;
        const y = (point.y - minY) * heightScale;
        return `${x}px ${y}px`;
    }).join(', ');

    room.style.clipPath = `polygon(${polygonPoints})`;
}

// Initialize room overlays when the DOM is loaded
document.addEventListener("DOMContentLoaded", function () {
    // Set initial room overlays
    window.addEventListener('resize', setRoomOverlays);
    
    // Initial setup after a short delay to ensure images are loaded
    setTimeout(setRoomOverlays, 100);
}); 