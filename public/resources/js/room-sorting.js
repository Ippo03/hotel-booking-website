/*
   This script enhances the functionality of a hotel sorting select dropdown.
   It saves the selected sorting option to session storage and restores it when the DOM is loaded.
   Additionally, it submits a form when the sorting option is changed.
*/

// Wait for the DOM to fully load
document.addEventListener("DOMContentLoaded", () => {
    const $sortingSelect = document.getElementById("hotel-sorting");
    const $form = document.getElementById("sorting-form");

    // Restore the selected option value from sessionStorage when the DOM is loaded
    const savedSortingOption = sessionStorage.getItem("selectedSortingOption");
    if (savedSortingOption) {
        $sortingSelect.value = savedSortingOption;
        $sortingSelect.classList.add("selected");
    }

    // Event listener for the sorting select change
    $sortingSelect.addEventListener("change", (e) => {
        const selectedValue = e.target.value;
        
        // Store the selected value in sessionStorage
        sessionStorage.setItem("selectedSortingOption", selectedValue);

        // Submit the form
        $form.submit();
    });
});
