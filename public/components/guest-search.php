<?php 
    // Get the current file name
    $currentFile = basename($_SERVER["PHP_SELF"]);
?>

<!-- Room type selector component, which displays a dropdown for selecting room types. 
     Its appearance depends on the current page. -->
<div class="room-search-container flex-center orange-background search-container <?php echo $currentFile === "index.php" ? "search-container-width-index" : "search-container-width-list"; ?>">
    <img id="roomTypeIcon" src="" alt="Guests" style="display: none;" />
    <select class="orange-background no-border" id="roomTypeSelect" name="room_type" title="room type selector">
        <option value="0">Guests</option>
        <?php
            // Iterate through all room types to populate the dropdown
            foreach ($allTypes as $roomType) {
        ?>
            <option value="<?php echo $roomType['type_id']; ?>"><?php echo $roomType['title']; ?></option>
        <?php
            }
        ?>
    </select>
</div> 