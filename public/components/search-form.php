<?php
    // Get the current file name
    $currentFile = basename($_SERVER["PHP_SELF"]);
?>

<form id="search-form" action="list.php" method="GET">
    <!-- This is a search form component that includes various search inputs such as location, check-in and check-out dates,
         guests, and a price slider. Its appearance is adjusted based on the current page. -->
    <div class="search-bar flex-center <?php echo $currentFile === "list.php" ? "flex-col light-gray-background search-bar-margin-list" : "search-bar-margin-index";?>">
        <?php
            if ($currentFile === "list.php") {
        ?>
        <h1>Find your stay</h1>
        <?php
            }
        include "loc-search.php"; 
        ?>
        <div class="date-search-container flex-center <?php echo $currentFile === "index.php" ? "orange-background search-container" : "flex-col" ?>">
            <?php include "check-in-search.php"; 
            if ($currentFile === "index.php") {
            ?>
                <div class="wall"></div>
            <?php 
                }
            include "check-out-search.php"; 
            ?>
        </div>
        <?php include "guest-search.php"; 
        if ($currentFile === "list.php") {
        ?>
        <div id="price-slider-container">
            <input type="range" name="price" id="price-slider" min="0" max="500" step="10">
            <p class="text-center" id="price-display">Selected Price: $250</p>
        </div>
        <?php 
            }
        ?>
        <div class="search-btn">
            <button class="orange-background" type="submit">Search</button>
        </div> 
    </div>  
</form>
