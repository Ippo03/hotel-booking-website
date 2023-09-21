/*
   This script is responsible for creating and displaying a map with markers for room locations.
   It uses the Leaflet library for mapping and populates the map with markers based on room data.
*/

// Define the coordinates for Athens
athensLat = 37.9838;
athensLng = 23.7275;

// Function to create a Leaflet map
function createMap(id, lat, lng) {
    var map = L.map(id, {
        center: [lat, lng],
        zoom: 13
    });

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap'
    }).addTo(map);

    return map;
}

// Wait for the DOM to fully load
document.addEventListener("DOMContentLoaded", () => {
    // Check if city coordinates are defined, if not, use Athens coordinates
    if (typeof cityLat === "undefined" || typeof cityLng === "undefined") {
        var map = createMap("map", athensLat, athensLng);

        // Loop through roomsData and add markers for each room
        roomsData.forEach(function(room) {
            var roomMarker = L.marker([room.location_lat, room.location_long]).addTo(map);
            roomMarker.bindPopup(room.name);
        });
    } else {
        var map = createMap("whole-map", cityLat, cityLng);

        // Add a marker for the single room data
        var roomMarker = L.marker([roomData.location_lat, roomData.location_long]).addTo(map);
        roomMarker.bindPopup(roomData.name);
    }

    // Additional code for handling map toggling and modal interaction
    $("#map-toggle").click(function() {
        $("#map-modal").fadeIn();
    });

    $("#map-modal").click(function(event) {
        if ($(event.target).is("#map-modal")) {
            $(this).fadeOut();
        }
    });
});
