<?php
    // Get the current file name
    $currentFile = basename($_SERVER["PHP_SELF"]);
?>

<!-- This component represents a location search container with a search icon and a dropdown for selecting a city. 
     Its appearance is adjusted based on the current page. -->
<div class="loc-search-container flex-center orange-background search-container <?php echo $currentFile === "index.php" ? "search-container-width-index" : "search-container-width-list"; ?>">
    <img src="../resources/assets/icons/search.png" alt="Search"/>
    <select class="orange-background no-border" id="locSelect" name="city" class="loc-search">
        <option value="">Location</option>
        <?php
            // Populate the dropdown with city options
            foreach ($allCities as $city) {
        ?>
            <option value="<?php echo $city; ?>"><?php echo $city; ?></option>
        <?php
            }
        ?>
    </select>
</div>
