/*
   This scropt enhances the behavior of dropdown menus triggered by clicking on images.
   It shows and hides the dropdown content when the image is clicked and when clicking outside the dropdown.
*/

// Wait for the DOM to fully load
document.addEventListener("DOMContentLoaded", () => {
    const extraOptionsImages = document.querySelectorAll(".extra-options-image");

    // Loop through each image
    extraOptionsImages.forEach(image => {
        // Next element is the dropdown content
        const dropdownContent = image.nextElementSibling; 

        // Event listener for clicking on the image
        image.addEventListener("click", (e) => {
            // Prevent the click event from propagating to the window
            e.stopPropagation(); 
            // Show the dropdown content
            dropdownContent.style.display = "block";
        });

        // Event listener for clicking anywhere in the window
        window.addEventListener("click", (e) => {
            // Close the dropdown if the click is outside the dropdown content and not on the image
            if (!dropdownContent.contains(e.target) && e.target !== image) {
                // Hide the dropdown content
                dropdownContent.style.display = "none"; 
            }
        });
    });
});
