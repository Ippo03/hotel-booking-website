// This script handles the checkbox form for amenities.
// It restores the checkbox states from sessionStorage, and when a checkbox is changed,
// it saves the state to sessionStorage and submits the form.

// Wait for the DOM to fully load
document.addEventListener("DOMContentLoaded", () => {
    // Find the amenity form and all the amenity checkboxes
    const $amenityForm = document.querySelector(".checkbox-grid");
    const $amenities = document.querySelectorAll(".amenities input[type=checkbox]");

    // Restore checkbox states from sessionStorage
    $amenities.forEach((amenity) => {
        // Get the saved state from sessionStorage
        const savedState = sessionStorage.getItem(amenity.name);
        if (savedState) {
            // Set the checkbox's checked state based on the saved state
            amenity.checked = savedState === "true";
        }
    });

    // Add change event listeners to each checkbox
    $amenities.forEach((amenity) => {
        amenity.addEventListener("change", (e) => {
            // Save the checkbox state to sessionStorage when it changes
            sessionStorage.setItem(e.target.name, e.target.checked);
            // Submit the form to update the amenities
            $amenityForm.submit();
        });
    });
});
