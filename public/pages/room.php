<?php

/**
 * This PHP and HTML file represents a detailed page for a specific hotel room on the Cozy Inn hotel booking website.
 * It provides information about the room, including its name, location, price, amenities, and a description.
 * Users can mark/unmark the room as a favorite, check its availability, and book the room for specific dates.
 * Additionally, users can view and add reviews for the room, and a map is displayed with the room's location.
 */

// Enable CORS for all origins
header('Access-Control-Allow-Origin: *');

// Boot the application
require_once __DIR__.'/../../boot/boot.php';

// Import necessary classes
use Hotel\User;
use Hotel\Room;
use Hotel\Favorite;
use Hotel\Review;
use Hotel\Booking;

// Include Utility functions
include "../defines/Utility.php";

// Initialize Room and Favorite services
$room = new Room();
$favorite = new Favorite();

// Check if a room ID is provided in the request
$roomId = $_REQUEST['room_id'];
if (empty($roomId)) {
    // Redirect to the homepage if no room ID is provided
    header('Location: index.php');
    return;
}

// Load room information based on the provided room ID
$roomInfo = $room->get($roomId);
if (empty($roomInfo)) {
    // Redirect to the homepage if the room information is not found
    header('Location: index.php');
    return;
}

// Calculate the city's latitude and longitude for the map
$cityLat = calculateCityLat($roomInfo['city']);
$cityLng = calculateCityLng($roomInfo['city']);

// Check if a user is verified and fetch user information
list($isVerified, $userInfo) = isUserVerified() ? [true, getUserInfo()] : [false, null];

// Get the user's ID
$userId = $userInfo['user_id'];

// Check if the current room is marked as a favorite for the logged-in user
$isFavorite = $favorite->isFavorite($roomId, $userId);

// Initialize the Review service and retrieve all room reviews
$review = new Review();
$allReviews = $review->getReviewsByRoom($roomId);

// Check if the user is attempting to book the room for specific dates
$checkInDate = $_REQUEST['check_in_date'];
$checkOutDate = $_REQUEST['check_out_date'];

// Initialize the Booking service
$booking = new Booking();

// Check if the room is already booked for the specified dates
$alreadyBooked = $booking->isBooked($roomId, $checkInDate, $checkOutDate);

// Check if the user has already booked the room for the specified dates
$userBookings = $booking->getListByUserId($userId);
$roomExists = false;

// Check if the room has already been booked by the user
foreach ($userBookings as $booking) {
    if ($booking['room_id'] == $roomId) {
        $roomExists = true;
        break;
    }
}

// Define some room amenities and count their number
$amenities = [
    'count_of_guests' => [
        'icon' => '../resources/assets/icons/single-room.png',
        'text' => 'Count of Guests',
        'alt' => 'Count of Guests',
    ],
    'parking' => [
        'icon' => '../resources/assets/icons/parking.png',
        'text' => 'Parking',
        'alt' => 'Free Parking',
    ],
    'wifi' => [
        'icon' => '../resources/assets/icons/wifi.png',
        'text' => 'Wifi',
        'alt' => 'Free Wifi',
    ],
    'pet_friendly' => [
        'icon' => '../resources/assets/icons/pet-friendly.png',
        'text' => 'Pet Friendly',
        'alt' => 'Pet Friendly',
    ],
    'gym' => [
        'icon' => '../resources/assets/icons/gym.png',
        'text' => 'Gym',
        'alt' => 'Gym',
    ],
    'pool' => [
        'icon' => '../resources/assets/icons/pool.png',
        'text' => 'Pool',
        'alt' => 'Pool',
    ],
];

$amenitiesCount = count($amenities);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <!-- Set the title of the page using the room name -->
    <title><?php echo $roomInfo['name'];?> - CozyInn</title>
    <!-- Import essential CSS and icon assets -->
    <link rel="stylesheet" href="../resources/css/global.css"/>
    <link rel="stylesheet" href="../resources/css/room.css"/>
    <link rel="icon" href="../resources/assets/icons/favicon.png">
    <!-- Include jQuery library for JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Include Font Awesome CSS for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Define JavaScript variables using PHP data -->
    <script>
        var roomData = <?php echo json_encode($roomInfo);?>; // Room information
        var cityLat = <?php echo $cityLat;?>; // City latitude
        var cityLng = <?php echo $cityLng;?>; // City longitude
    </script>
</head>
    <body>
    <!-- Display header -->
    <?php include "../components/header.php";?>
    <main>
        <div class="container light-gray-background flex-col">
            <div class="title-bar flex-align-center justify-between orange-background">
                <div class="room-info flex-center">
                    <!-- Display the room title and location -->
                    <div class="room-title">
                        <?php echo sprintf('%s - %s, %s', $roomInfo['name'], $roomInfo['city'], $roomInfo['area']); ?>
                    </div>
                    <!-- Display room average rating -->
                    <div class="wall"></div>
                    <div class="room-review">
                        <span>Reviews:</span>
                        <?php for ($i = 1; $i <= 5; $i++) { ?>
                            <i class="fa fa-star white <?= $roomInfo['avg_reviews'] >= $i ? 'checked' : ''; ?>"></i>
                        <?php } ?>
                    </div>
                    <div class="wall"></div>
                    <!-- Form to mark/unmark the room as a favorite -->
                    <form name="favoriteForm" class="favoriteForm flex" method="POST" action="../actions/favorite.php">
                        <input type="hidden" name="room_id" value="<?php echo $roomId; ?>"/>
                        <input type="hidden" name="is_favorite" value="<?php echo $isFavorite ? '1' : '0'; ?>"/>
                        <div class="fav-icon">
                            <ul class="fav-star no-padding no-margin no-list-style">
                                <li class="star">
                                    <span class="heart-icon"><i id="heart" class="fa fa-heart white btn-pointer <?php echo $isFavorite ? 'clicked' : ''; ?>"></i></span>
                                </li>
                            </ul>
                        </div>
                    </form>
                </div>
                <!-- Display room price -->
                <div class="price">
                    <span>Per night: </span>
                    <span><?php echo $roomInfo['price']; ?>€</span>        
                </div>
            </div>
            <!-- Display room image -->
            <img class="room-image" src="../resources/assets/images/rooms/<?php echo $roomInfo['photo_url'];?>" alt="Hotel <?php echo $roomInfo['room_id'];?>"/>
            <!-- Display room amenities -->
            <div class="room-amenities flex-align-center justify-evenly orange-background">
                <?php 
                    $counter = 0;
                    foreach ($roomInfo as $amenity => $value) {
                        if (array_key_exists($amenity, $amenities)) {
                            $amenityData = $amenities[$amenity];
                            $icon = $amenityData['icon'];
                            $text = $amenityData['text'];
                            $alt = $amenityData['alt'];
                            $value = $value ? 'Yes' : 'No';
                            displayRoomAmenity($icon, $alt, $value, $text);

                            // Increment the current amenity index
                            $counter++;

                            // Check if it's not the last amenity to add the "wall" div
                            if ($counter < $amenitiesCount) {
                                echo '<div class="wall"></div>';
                            }
                        }
                    }
                ?>
            </div>
            <!-- Display room description -->
            <div class="room-desc">
                <h2>Room Description</h2>
                <p><?php echo htmlentities($roomInfo['description_long']); ?></p>
            </div>
            <div class="book-now display-flex justify-right"> 
            <?php if ($alreadyBooked){ ?>
                <?php if ($roomExists){ ?>
                    <!-- Display message when the room is booked by the user -->
                    <span class="mine green-background">Booked by You</span>
                <?php } else { ?>
                    <!-- Display message when the room is already booked -->
                    <span class="other red-background">Already Booked</span>
                <?php } ?>
            <?php } else { ?>
                <!-- Display form to book the room -->
                <form name="bookNowForm" method="POST" action="../actions/book.php">
                    <input type="hidden" name="room_id" value="<?php echo $roomId;?>"/>
                    <input type="hidden" name="check_in_date" value="<?php echo $checkInDate;?>"/>
                    <input type="hidden" name="check_out_date" value="<?php echo $checkOutDate;?>"/>
                    <button class="book-btn light-sky-blue-background" type="submit">Book Now</button>
                </form>
            <?php } ?>
            </div>
            <!-- Display the map with room location -->
            <div id="whole-map" style="height: 250px;"></div>
            <!-- Display room reviews -->
            <div class="room-reviews-container flex-col" id="reviews">
                <h2>Reviews</h2>
                <?php 
                    if (count($allReviews) > 0) {
                        foreach ($allReviews as $counter => $review) {
                ?>
                    <div class="room-reviews display-flex flex-col">
                        <div class="review-stars display-flex">
                            <span class="text"><?= sprintf('%d. %s', $counter + 1, $review['user_name']); ?></span>
                            <?php for ($i = 1; $i <= 5; $i++) { ?>
                                <i class="fa fa-star white <?= $review['rate'] >= $i ? 'checked' : ''; ?>"></i>
                            <?php } ?>
                        </div>
                        <div class="review-info display-flex flex-col">
                            <span class="when">Created at: <?php echo $review['created_time']; ?></span>
                            <span class="desc">"<?php echo htmlentities($review['comment']);?>"</span>
                        </div>
                    </div>
                <?php
                    }
                } else {
                ?>
                    <!-- Display message when there are no reviews -->
                    <p>No reviews yet. Be the first to leave a review!</p>
                <?php 
                    }
                ?>
            </div>
            <!-- Form to add a review -->
            <div class="add-review-container display-flex flex-col">
                <h2>Add Review</h2>
                <form name="addReviewForm" class="addReviewForm block" method="POST" action="../actions/review.php">
                    <input type="hidden" name="room_id" value="<?php echo $roomId; ?>"/>
                    <input type="hidden" name="csrf" value="<?php echo User::getCsrf(); ?>"/>
                    <div class="rate">
                        <?php for ($i = 1; $i <= 5; $i++){ ?>
                            <input class="no-display" type="radio" id="star<?= $i; ?>" name="rate" value="<?= $i; ?>"/>
                            <label class="inline-block btn-pointer" for="star<?= $i; ?>" title="<?= $i; ?> star"><?= $i; ?> star</label>
                        <?php } ?>
                    </div>
                    <textarea name="comment" rows="5" cols="40" placeholder="Write your review here..."></textarea>
                    <input class="submit-btn block white orange-background btn-pointer no-border" type="submit" value="Submit">
                </form>
            </div>
        </div>
    </main>
    <!-- Include Leaflet library and custom JavaScript files -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="../resources/js/map.js"></script>
    <script src="../resources/js/favorite.js" type="text/javascript"></script>
</body>
</html>