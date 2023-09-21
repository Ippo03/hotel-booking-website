<?php

/**
 * This PHP and HTML file represents the "Hotel List" page of the Cozy Inn hotel booking website.
 * It allows users to search for available hotel rooms, apply filters, and view search results.
 * The page includes the header, search form, amenity filters, hotel listings, and footer.
 */

// Boot the application
require_once __DIR__.'/../../boot/boot.php';

// Import necessary classes
use Hotel\Room;
use Hotel\User;
use Hotel\RoomType;

// Import utility functions
include "../defines/Utility.php";

// Start session
session_start();

// Initialize room 
$room = new Room();

// Check if a user is verified and fetch user information
list($isVerified, $userInfo) = isUserVerified() ? [true, getUserInfo()] : [false, null];

// Get all cities
$allCities = $room->getCities();

// Get all room types
$type = new RoomType();
$allTypes = $type->getAllTypes();

// Get page parameters
$selectedCity = $_REQUEST['city'];
$selectedTypeId = $_REQUEST['room_type'];
$checkInDate = new DateTime($_REQUEST['check_in_date']);
$checkOutDate = new DateTime($_REQUEST['check_out_date']); 
$price = $_REQUEST['price'];  

// Convert dates to the correct format
$checkInDate = $checkInDate->format('Y-m-d');
$checkOutDate = $checkOutDate->format('Y-m-d');

// Get current date
$currentDateTime = date("Y-m-d");

// Get referring page
if (isset($_GET['referrer'])) {
    $referrer = $_GET['referrer'];
}

// Check if the selected dates are valid
if (($checkInDate <= $currentDateTime || $checkOutDate <= $currentDateTime) && $referrer !== "actions/amenity") {
    // Inform the user about the error and redirect to main page
    displayAlert("Please select a valid date", "index.php");
    
    return;
}

// Check if the check in date is before the check out date
if ($checkInDate >= $checkOutDate && $referrer !== "actions/amenity") {
    // Inform the user about the error and redirect to home page
    displayAlert("Check in date cannot be after check out date", "index.php");

    return;
}

// Get all available rooms
$allAvailableRooms = $room->search($checkInDate, $checkOutDate, $selectedCity, $selectedTypeId, $price);

// Get filtered rooms
$filteredRooms = $_SESSION['filtered_rooms'];

// Find the intersection between the filtered rooms and the available rooms
if (!empty($filteredRooms)) {
    $allAvailableRooms = findIntersection($filteredRooms, $allAvailableRooms, "room_id");
}

$amenities = [
    "Free Wifi",
    "Pets Allowed",
    "Free Parking",
    "Gym",
    "Spa",
    "Air Condition",
    "Room Service",
    "Pool"
];

// Grid columns
$numCols = 2; 

// Get the current URL
$currentUrl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <meta name="robots" contents="noindex,nofollow"/>
        <title>Hotel List</title>
        <link rel="icon" href="../resources/assets/icons/favicon.png">
        <!-- Import essential assets for initial page rendering -->
        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
        <link href="../resources/css/global.css" type="text/css" rel="stylesheet"/>
        <link href="../resources/css/hotel.css" type="text/css" rel="stylesheet"/>
    </head>
    <body>
        <!-- Display header -->
        <?php include "../components/header.php"; ?>
        <main>
            <div class="sorting-bar flex-align-center justify-evenly sorting-bar-margin-list">
                <!-- Display stays found and map -->
                <?php include "../components/info-bar.php"; ?>
            </div>
            <div class="container flex-center">
                <div class="asides flex-center flex-col">
                    <aside class="list-search-bar">
                        <!-- Display search form -->
                        <?php include "../components/search-form.php"; ?>
                    </aside>
                    <aside class="list-filters">
                        <!-- Display amenity filters -->
                        <div class="amenities flex-center flex-col light-gray-background">
                            <h1>Amenities</h1>
                            <form class="checkbox-grid display-flex justify-between" action="../actions/amenity.php" method="GET">
                                <?php
                                // Add a hidden input field to store the current URL
                                echo '<input type="hidden" name="current_url" value="' . htmlspecialchars($currentUrl) . '">';
                                for ($i = 0; $i < count($amenities); $i += $numCols) {
                                    echo '<div class="checkbox-row flex-align-center justify-between">';
                                    for ($j = 0; $j < $numCols; $j++) {
                                        $index = $i + $j;
                                        if ($index < count($amenities)) {
                                            $amenity = $amenities[$index];
                                            $id = str_replace(' ', '_', strtolower($amenity));
                                            ?>
                                            <div class="checkbox-container">
                                                <input id="<?php echo $id; ?>" type="checkbox" name="<?php echo $id; ?>"/>
                                                <label for="<?php echo $id; ?>"><?php echo $amenity; ?></label>
                                            </div>
                                            <?php
                                        }
                                    }
                                    echo '</div>';
                                }
                                ?>
                            </form>
                        </div>
                    </aside>    
                    <!-- Display clear filters button -->
                    <button type="button" class="clear-filters orange-background" id="clear-filters">Clear Filters</button>
                </div>
                <!-- Display search results -->
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
        <script src="../resources/js/price.js"></script>
        <script src="../resources/js/amenities.js"></script>
        <script src="../resources/js/clear-filters.js"></script>
        <script src="../resources/js/gotop.js"></script>
        <script src="../resources/js/search-values.js"></script>
        <script>
            var roomsData = <?php echo json_encode($allAvailableRooms); ?>;
        </script>
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="crossorigin=""/>
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="crossorigin=""></script>
        <script src="../resources/js/map.js"></script>
    </body>
</html>






