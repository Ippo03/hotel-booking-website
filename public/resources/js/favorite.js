/*
   This script enhances the functionality of a favorite button.
   It allows users to click the heart icon to toggle their favorite status and submits the associated
   form when the button is clicked.
*/

// Wait for the DOM to fully load
document.addEventListener("DOMContentLoaded", () => {
    const favoriteForm = document.querySelector(".favoriteForm");
    const favoriteButton = document.querySelector(".heart-icon i");

    // Event listener for clicking the heart icon
    favoriteButton.addEventListener("click", (e) => {
        // Prevent the default behavior of the click event
        e.preventDefault(); 

        // Toggle the "clicked" class on the heart icon
        favoriteButton.classList.toggle("clicked"); 

        // Submit the associated form
        favoriteForm.submit();
    });
});
