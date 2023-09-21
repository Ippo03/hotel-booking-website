/*
   This script enhances the functionality of a hotel search form.
   It listens for changes in the form elements and stores selected values in sessionStorage.
   It also retrieves and sets the check-in and check-out dates from sessionStorage.
*/

// Wait for the DOM to be fully loaded
document.addEventListener("DOMContentLoaded", () => {
    // Get references to relevant DOM elements
    const $searchForm = document.getElementById("search-form");
    const $datePickerIn = document.querySelector(".datepicker-in");
    const $datePickerOut = document.querySelector(".datepicker-out");

    // Try to retrieve the selected check-in and check-out dates from sessionStorage
    const selectedCheckInDate = sessionStorage.getItem("selectedCheckInDate");
    const selectedCheckOutDate = sessionStorage.getItem("selectedCheckOutDate");

    // Set the check-in datepicker's value based on the stored value
    if (selectedCheckInDate !== null) {
        $datePickerIn.value = selectedCheckInDate;
    }

    // Set the check-out datepicker's value based on the stored value
    if (selectedCheckOutDate !== null) {
        $datePickerOut.value = selectedCheckOutDate;
    }

    // Listen for changes in the search form
    $searchForm.addEventListener("change", (e) => {
        // Determine which form element changed by its ID and store its value in sessionStorage
        switch (e.target.id) {
            case "locSelect":
                sessionStorage.setItem("selectedRoomLoc", e.target.value);
                break;
            case "roomTypeSelect":
                sessionStorage.setItem("selectedRoomType", e.target.value);
                break;
        }
    });
});
