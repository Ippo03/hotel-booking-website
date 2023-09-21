/*
   This script handles the behavior of extra options images and dropdowns.
   It allows users to click on extra options images to display related dropdowns and closes the dropdowns
   when clicking outside of them.
*/

// Wait for the DOM to fully load
document.addEventListener('DOMContentLoaded', function () {
    const extraOptionsImages = document.querySelectorAll('.extra-options-image'); 

    // Event listener for clicking extra options images
    extraOptionsImages.forEach(image => {
        image.addEventListener('click', function (event) {
            event.stopPropagation(); // Prevent event propagation
            const extraOptions = document.querySelectorAll('.extra');
            extraOptions.forEach(option => {
                option.computedStyleMap.display = 'block'; // Display the dropdown
            });
        });
    });

    // Event listener for clicking outside the dropdown
    document.addEventListener('click', function (event) {
        const extraOptions = document.querySelector('.extra');
        if (!extraOptions.contains(event.target)) {
            extraOptions.classList.add('hidden'); // Close the dropdown by adding a 'hidden' class
        }
    });
});
