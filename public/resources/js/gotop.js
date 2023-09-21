/*
   This script enhances the behavior of a "Go to Top" button.
   It shows and hides the button based on the user's scroll position and allows users to smoothly
   scroll to the top of the page when the button is clicked.
*/

// Wait for the DOM to fully load
document.addEventListener('DOMContentLoaded', function () {
    const $goToTopButton = document.querySelector('.go-to-top a');
    
    // Show/hide the button based on scroll position
    window.addEventListener('scroll', function () {
        if (window.scrollY > (this.window.outerHeight + this.window.innerHeight) / 2) { 
            $goToTopButton.style.display = 'block'; // Display the button when scrolling halfway down the page
        } else {
            $goToTopButton.style.display = 'none'; // Hide the button when scrolling back up
        }
    });

    // Scroll to the top smoothly when the button is clicked
    $goToTopButton.addEventListener('click', function (e) {
         // Prevent the default behavior of the click event
        e.preventDefault();
        
        window.scrollTo({
            top: 0,
            // Scroll smoothly
            behavior: 'smooth', 
            // Animation duration in milliseconds
            duration: 2000 
        });
    });
});

