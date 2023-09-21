<?php

/**
 * This PHP and HTML file represents the main page of the Cozy Inn hotel booking website.
 * It includes functionality for searching, sorting, and displaying hotel rooms, along with a header, search form, hotel listings, and a footer.
 */

// Boot the application
require __DIR__.'/../../boot/boot.php';

// Import necessary classes
use Hotel\User;
use Hotel\Room;
use Hotel\RoomType;

// Import utility functions
include "../defines/Utility.php";

// Start session
session_start();

// Get cities
$room = new Room();
$allCities = $room->getCities();

// Get all room types
$type = new RoomType();
$allTypes = $type->getAllTypes();

// Get all rooms
$rooms = $room->getRoomsList();

// Get rooms by price
$roomsByPrice = $room->getRoomsByPrice();

// Get rooms by rating
$roomsByRating = $room->getRoomsByRating();


// Get selected option and sort rooms
$selectedOption = $_POST["sorting_option"]; 
$roomsList = getRoomsSortedList($selectedOption, $rooms, $roomsByPrice, $roomsByRating);

// Check if a user is verified and fetch user information
list($isVerified, $userInfo) = isUserVerified() ? [true, getUserInfo()] : [false, null];

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <title>Cozy Inn | Find & compare great deals</title>
        <link rel="icon" href="../resources/assets/icons/favicon.png">
        <!-- Import essential assets for initial page rendering -->
        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
        <link href="../resources/css/global.css" type="text/css" rel="stylesheet"/>
        <link href="../resources/css/hotel.css" type="text/css" rel="stylesheet"/>
        <script src="../resources/js/room-sorting.js"></script>
    </head>
    <body>
        <!-- Display header -->
        <?php include "../components/header.php"; ?>
        <main>
            <!-- Display search form -->
            <?php include "../components/search-form.php"; ?>   
            <div class="hotel-recommendations light-gray-background">
                <!-- Display sorting bar -->
                <div class="sorting-bar flex-center sorting-bar-margin-index">
                    <form method="POST" action="index.php" id="sorting-form">
                        <label for="hotel-sorting">Sort by:</label>
                        <select class="orange-background no-border" id="hotel-sorting" name="sorting_option">
                            <option class="sorting-option" value="default">Our recommendations</option>
                            <option class="sorting-option" value="price">Price only</option>
                            <option class="sorting-option" value="rating">Rating only</option>
                        </select>
                    </form>
                    <!-- Display stays found and map -->
                    <?php include "../components/info-bar.php"; ?>
                </div>
                <!-- Display initial hotels -->
                <?php include "../components/hotel.php"; ?>
                <!-- Display go to top button -->
                <?php include "../components/top-btn.php"; ?>
            </div>
        </main>
        <!-- Display footer -->
        <?php include "../components/footer.php"; ?>
        <!-- Place at the end of the body for better performance -->
        <script src="../resources/js/date.js"></script>
        <script src="../resources/js/room-icons.js"></script>
        <script src="../resources/js/gotop.js"></script>
        <script src="../resources/js/search-values.js"></script>
        <script>
            var roomsData = <?php echo json_encode($rooms); ?>;
        </script>
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="crossorigin=""/>
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="crossorigin=""></script>
        <script src="../resources/js/map.js"></script>
    </body>
</html>