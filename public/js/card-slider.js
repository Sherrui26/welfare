document.addEventListener('DOMContentLoaded', function() {
    // Main category cards slider
    initCategoryCardsSlider();
    
    // Vacant rooms slider
    initVacantRoomsSlider();
    
    // Fix timeline height
    initTimelineHeight();
    
    // Main category cards slider initialization
    function initCategoryCardsSlider() {
        const cardsContainer = document.getElementById('categoryCardsContainer');
        const prevButton = document.getElementById('prevButton');
        const nextButton = document.getElementById('nextButton');
        const cards = document.querySelectorAll('.category-card');
        
        if (!cardsContainer || !prevButton || !nextButton || cards.length === 0) return;
        
        // Number of cards to show at once (based on screen size)
        let cardsToShow = window.innerWidth >= 768 ? 3 : 1;
        let currentIndex = 0;
        
        // Set initial position and button states
        updateSliderPosition(cardsContainer, cards, currentIndex, cardsToShow);
        updateButtonStates(prevButton, nextButton, currentIndex, cards.length, cardsToShow);
        
        // Handle window resize
        window.addEventListener('resize', function() {
            cardsToShow = window.innerWidth >= 768 ? 3 : 1;
            updateSliderPosition(cardsContainer, cards, currentIndex, cardsToShow);
            updateButtonStates(prevButton, nextButton, currentIndex, cards.length, cardsToShow);
        });
        
        // Button click handlers
        prevButton.addEventListener('click', function() {
            if (currentIndex > 0) {
                currentIndex--;
                updateSliderPosition(cardsContainer, cards, currentIndex, cardsToShow);
                updateButtonStates(prevButton, nextButton, currentIndex, cards.length, cardsToShow);
            }
        });
        
        nextButton.addEventListener('click', function() {
            if (currentIndex < cards.length - cardsToShow) {
                currentIndex++;
                updateSliderPosition(cardsContainer, cards, currentIndex, cardsToShow);
                updateButtonStates(prevButton, nextButton, currentIndex, cards.length, cardsToShow);
            }
        });
    }
    
    // Vacant rooms slider initialization
    function initVacantRoomsSlider() {
        const cardsContainer = document.getElementById('vacantRoomsContainer');
        const prevButton = document.getElementById('vacantPrevButton');
        const nextButton = document.getElementById('vacantNextButton');
        const cards = document.querySelectorAll('.vacant-type-card');
        
        if (!cardsContainer || !prevButton || !nextButton || cards.length === 0) return;
        
        // Number of cards to show at once (based on screen size)
        let cardsToShow = 3;
        let currentIndex = 0;
        
        // Set initial position and button states
        updateSliderPosition(cardsContainer, cards, currentIndex, cardsToShow);
        updateButtonStates(prevButton, nextButton, currentIndex, cards.length, cardsToShow);
        
        // Button click handlers
        prevButton.addEventListener('click', function() {
            if (currentIndex > 0) {
                currentIndex--;
                updateSliderPosition(cardsContainer, cards, currentIndex, cardsToShow);
                updateButtonStates(prevButton, nextButton, currentIndex, cards.length, cardsToShow);
            }
        });
        
        nextButton.addEventListener('click', function() {
            if (currentIndex < cards.length - cardsToShow) {
                currentIndex++;
                updateSliderPosition(cardsContainer, cards, currentIndex, cardsToShow);
                updateButtonStates(prevButton, nextButton, currentIndex, cards.length, cardsToShow);
            }
        });
    }
    
    // Update slider position based on current index
    function updateSliderPosition(container, cards, currentIndex, cardsToShow) {
        const cardWidth = 100 / cardsToShow;
        const translateX = -currentIndex * cardWidth;
        container.style.transform = `translateX(${translateX}%)`;
        
        // Set width of each card
        cards.forEach(card => {
            card.style.width = `${cardWidth}%`;
        });
    }
    
    // Update the enabled/disabled state of the navigation buttons
    function updateButtonStates(prevButton, nextButton, currentIndex, totalCards, cardsToShow) {
        prevButton.disabled = currentIndex === 0;
        nextButton.disabled = currentIndex >= totalCards - cardsToShow;
        
        // Update the visual state
        prevButton.style.opacity = prevButton.disabled ? '0.5' : '1';
        nextButton.style.opacity = nextButton.disabled ? '0.5' : '1';
    }
    
    // Fix timeline height
    function initTimelineHeight() {
        function adjustTimelineHeight() {
            const timelineContainer = document.querySelector('.overflow-y-auto.h-40 .relative.min-h-full');
            const timelineLine = document.querySelector('.overflow-y-auto.h-40 .relative.min-h-full .absolute');
            const activityItems = document.querySelectorAll('.overflow-y-auto.h-40 .space-y-4 > div');
            
            if (timelineContainer && timelineLine && activityItems.length > 0) {
                // Calculate the total height of all activity items plus padding
                const lastItem = activityItems[activityItems.length - 1];
                const lastItemBottom = lastItem.offsetTop + lastItem.offsetHeight;
                
                // Set the line height to cover the entire content
                timelineLine.style.height = `${lastItemBottom + 10}px`;
            }
        }
        
        // Adjust timeline on page load and resize
        window.addEventListener('load', adjustTimelineHeight);
        window.addEventListener('resize', adjustTimelineHeight);
    }
}); 