// For expandable cards functions
function toggleDetails(id) {
    const details = document.getElementById(id);
    const card = details.closest('.expandable-card');
    
    // Toggle just the clicked card without closing others
    card.classList.toggle('active');
    details.classList.toggle('show');
    
    // Toggle the arrow direction for this specific card
    const icon = card.querySelector('.fa-chevron-down, .fa-chevron-up');
    if (icon) {
        if (details.classList.contains('show')) {
            // If details are showing, arrow should point up
            icon.classList.remove('fa-chevron-down');
            icon.classList.add('fa-chevron-up');
        } else {
            // If details are hidden, arrow should point down
            icon.classList.remove('fa-chevron-up');
            icon.classList.add('fa-chevron-down');
        }
    }
}

// Initialize expandable cards
document.addEventListener("DOMContentLoaded", function () {
    // Ensure all cards start with the down arrow
    document.querySelectorAll('.expandable-card').forEach(card => {
        const icon = card.querySelector('.fa-chevron-up, .fa-chevron-down');
        if (icon) {
            icon.classList.remove('fa-chevron-up');
            icon.classList.add('fa-chevron-down');
        }
    });
});

// Remove the card click event listener since we're handling icon toggle in toggleDetails function 