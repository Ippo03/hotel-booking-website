<?php

/**
 * This PHP file serves as a user profile page for the "Cozy Inn" website. It allows a logged-in user
 * to view their bookings, favorites, and reviews.
 */

// Boot the application
require_once __DIR__.'/../../boot/boot.php';

// Import necessary classes
use Hotel\Room;
use Hotel\Review;
use Hotel\Booking;
use Hotel\User;
use Hotel\Favorite;

// Include Utility functions
include "../defines/Utility.php";

// Check if a user is verified and fetch user information
list($isVerified, $userInfo) = isUserVerified() ? [true, getUserInfo()] : [false, null];

// Redirect to login page if user is not verified
if(!$isVerified) {
    header('Location: login.php');
    return;
}

// Get the user's ID
$userId = $userInfo['user_id'];

// Initialize favorite services and fetch user favorites
$favorite = new Favorite();
$userFavorites = $favorite->getListByUserId($userId);

// Initialize review services and fetch user reviews
$review = new Review();
$userReviews = $review->getListByUserId($userId);

// Initialize booking services and fetch user bookings
$booking = new Booking();
$userBookings = $booking->getListByUserId($userId);

// Get the current date
$currentDateTime = date("Y-m-d");

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <meta name="robots" contents="noindex,nofollow"/>
        <title>My Cozy Inn Profile</title>
        <link rel="icon" href="../resources/assets/icons/favicon.png">
        <!-- Import essential assets for initial page rendering -->
        <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">   
        <link href="../resources/css/global.css" type="text/css" rel="stylesheet"/>
        <link href="../resources/css/profile.css" type="text/css" rel="stylesheet"/>
    </head>
    <body>
        <!-- Display header -->
        <?php include "../components/header.php"; ?>
        <main>
            <div class="container white-background">
                <!-- Display bookings container -->
                <div id="bookings" class="bookings-container light-gray-background">
                    <?php 
                        if (count($userBookings) > 0) {
                    ?>
                    <ol class="no-list-style display-flex flex-col justify-center">
                        <h1 class="text-left">Bookings & Trips</h1>
                        <?php
                            foreach ($userBookings as $booking) {
                        ?>
                            <li>
                                <?php $isActive = ($currentDateTime < $booking['check_in_date']) ? 1 : 0; ?>
                                <?php echo displayRoom($booking, $isActive); ?>
                            </li>
                        <?php
                            }
                        ?>
                    </ol>
                    <?php
                        } else {
                    ?>
                        <h4>You dont have any bookings</h4>
                    <?php
                        }
                    ?>
                </div>
                <!-- Display favorites container -->
                <?php include "../components/favorites-container.php"; ?>
                <!-- Display reviews container -->
                <div id="reviews" class="reviews-container light-gray-background">
                    <?php
                        if (count($userReviews) > 0) {
                    ?>
                        <ol class="no-list-style display-flex flex-col justify-center">
                            <h1 class="text-left">Reviews</h1>
                            <?php
                                foreach ($userReviews as $review) {
                            ?>
                                <li>
                                    <?php echo displayRoom($review, false, false); ?>
                                </li>
                        <?php
                            }
                        ?>
                    </ol>
                    <?php
                        } else {
                    ?>
                            <h3>No reviews yet</h3>
                    <?php
                        }
                    ?>
                </div>
            </div>
        </main>
        <script src="../resources/js/profile-dropdown.js"></script>
        <script src="../resources/js/extra-options.js"></script>
        <script src="../resources/js/cancel.js"></script>
        <script>
            var roomsData = <?php echo json_encode($userFavorites); ?>;
        </script>
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="crossorigin=""/>
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="crossorigin=""></script>
        <script src="../resources/js/map.js"></script>
    </body>
</html>

