// This script handles the clearing of filters in the sidebar.
// It listens for clicks on elements within the ".asides" container, and when a
// "clear-filters" element is clicked, it clears various filter-related elements
// and their associated session storage data.

// Wait for the DOM to fully load
document.addEventListener("DOMContentLoaded", () => {
    // Find the ".asides" container
    const $asidesContainer = document.querySelector(".asides");

    // Add a click event listener to the ".asides" container
    $asidesContainer.addEventListener("click", (e) => {
        // Check if the clicked element has the "clear-filters" class
        if (e.target.classList.contains("clear-filters")) {
            // Find all form elements within the ".asides" container
            const $formElements = $asidesContainer.querySelectorAll("input, select, input[type=checkbox]");

            // Loop through each form element
            $formElements.forEach((element) => {
                // Perform different actions based on the element's ID
                switch (element.id) {
                    case "locSelect":
                        // Clear the location select input and its session storage data
                        element.value = "";
                        sessionStorage.removeItem("selectedRoomLoc");
                        break;
                    case "dateInInput":
                        // Clear the check-in date input and its session storage data
                        element.value = "";
                        sessionStorage.removeItem("selectedCheckInDate");
                        break;
                    case "dateOutInput":
                        // Clear the check-out date input and its session storage data
                        element.value = "";
                        sessionStorage.removeItem("selectedCheckOutDate");
                        break;
                    case "roomTypeSelect":
                        // Reset the room type select input and hide an associated icon
                        element.value = "0";
                        const $roomTypeIcon = document.querySelector("#roomTypeIcon");
                        $roomTypeIcon.style.display = "none";
                        sessionStorage.removeItem("selectedRoomType");
                        break;
                    case "price-slider":
                        // Reset the price slider input and update the displayed price
                        element.value = "500";
                        document.querySelector("#price-display").innerHTML = "Selected Price: $500";
                        break;
                    default:
                        // Handle checkbox elements
                        if (element.type === "checkbox") {
                            // Uncheck the checkbox and clear its session storage data
                            element.checked = false;
                            sessionStorage.removeItem(element.name);
                            sessionStorage.removeItem("filtered_rooms");
                            // Redirect to an action (e.g., to apply the amenity filter)
                            window.location.href = "../actions/amenity.php";
                        }
                        break;
                }
            });
        }
    });
});
