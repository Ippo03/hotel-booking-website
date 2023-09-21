/*
   This script enhances the functionality of a room type selection dropdown and a room location dropdown.
   It saves the selected room type and room location to session storage and displays an associated icon for the selected room type.
*/

// Wait for the DOM to fully load
document.addEventListener("DOMContentLoaded", () => {
    const $roomTypeSelect = document.querySelector("#roomTypeSelect");
    const $roomTypeIcon = document.querySelector("#roomTypeIcon");
    const $roomLocSelect = document.getElementById("locSelect");

    // Define an object to map room types to their corresponding icons
    const roomTypeIcons = {
        "0": { title: "Guests", url: "" },
        "1": { title: "Single Room", url: "../resources/assets/icons/single-room.png" },
        "2": { title: "Double Room", url: "../resources/assets/icons/double-room.png" },
        "3": { title: "Triple Room", url: "../resources/assets/icons/triple-room.png" },
        "4": { title: "Fourfold Room", url: "../resources/assets/icons/fourfold-room.png" },
    };

    // Try to retrieve the selected room type and room location from local storage
    const selectedRoomType = sessionStorage.getItem("selectedRoomType");
    const selectedRoomLoc = sessionStorage.getItem("selectedRoomLoc");

    // Set the room type select element's value based on the stored value
    if (selectedRoomType !== null) {
        $roomTypeSelect.value = selectedRoomType;
        updateRoomTypeIcon(selectedRoomType);
    }

    // Set the room location select element's value based on the stored value
    if (selectedRoomLoc !== null) {
        $roomLocSelect.value = selectedRoomLoc;
    }

    // Event listener for room location dropdown changes
    $roomLocSelect.addEventListener("change", (e) => {
        const selectedRoomLoc = $roomLocSelect.value;

        // Store the selected room location in local storage
        sessionStorage.setItem("selectedRoomLoc", selectedRoomLoc);
    });

    // Event listener for room type dropdown changes
    $roomTypeSelect.addEventListener("change", (e) => {
        const selectedRoomType = $roomTypeSelect.value;
        updateRoomTypeIcon(selectedRoomType);

        // Store the selected room type in local storage
        sessionStorage.setItem("selectedRoomType", selectedRoomType);
    });

    // Function to update the room type icon
    function updateRoomTypeIcon(selectedRoomType) {
        if (selectedRoomType === "0") {
            // Hide the image if no room type is selected
            $roomTypeIcon.style.display = "none";
            $roomTypeIcon.src = roomTypeIcons["0"].url;
            $roomTypeIcon.alt = roomTypeIcons["0"].title;
        } else {
            // Show the image if a room type is selected and an icon exists for it
            $roomTypeIcon.style.display = "inline";
            $roomTypeIcon.src = roomTypeIcons[selectedRoomType].url;
            $roomTypeIcon.alt = roomTypeIcons[selectedRoomType].title;
        }
    }
});
