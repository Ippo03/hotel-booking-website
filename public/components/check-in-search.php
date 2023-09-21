<?php 
    // Get the current file name
    $currentFile = basename($_SERVER["PHP_SELF"]);
?>

<!-- This component represents a search container for the "Check In" date input and arrows.
     Its appearance adjusts based on the current page. -->
<div class="from-search flex-center orange-background <?php echo $currentFile === "list.php" ? "search-container search-container-width-list from-search-margin-list" : "from-search-margin-index"; ?>">
    <?php 
        // Check if the current file is "index.php"
        if ($currentFile === "index.php") {
    ?>
        <!-- Display an image for the "index.php" page -->
        <img src="../resources/assets/icons/date.png" alt="Calendar"/>
    <?php 
        }
    ?>
    <!-- Input field for Check In date -->
    <input id="dateInInput" class="datepicker datepicker-in no-border orange-background" type="text" name="check_in_date" placeholder="Check In">
    
    <!-- Arrows for adjusting the date -->
    <div class="arrows check-in flex-align-center">
        <img src="../resources/assets/icons/left-arrow.png" class="left-arrow-in" alt="Left Arrow"/>
        <img src="../resources/assets/icons/right-arrow.png" class="right-arrow-in" alt="Right Arrow"/>
    </div>
</div>
