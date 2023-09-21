<?php
    // Get the current file name
    $currentFile = basename($_SERVER["PHP_SELF"]);

    // Determine which rooms to display based on the current page
    if ($currentFile === "index.php") {
        $rooms = $rooms;
    } else {
        $rooms = $allAvailableRooms;
    }
?>

<!-- This component displays the number of stays found, a "View Map" button, and a map modal. -->
<div class="stays-found">Stays Found: <?php echo count($rooms) ?></div>
<div class="map-container">
    <div class="view-map" id="map-toggle">
        <img src="../resources/assets/icons/pin.png" alt="Map"/>
        View Map
    </div>
</div>
<div class="modal" id="map-modal">
    <div class="modal-content" id="map-content">
        <div id="map" style="height: 300px;"></div>
    </div>
</div>
