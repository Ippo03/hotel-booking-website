<?php

/*
   This script includes functions for managing user sessions, retrieving user information,
   sorting and displaying room data, calculating distances, and handling form inputs and alerts.
*/

// Boot the application
require __DIR__.'/../../boot/boot.php';

// Import necessary classes
use Hotel\User;

// Start the session
session_start();

// Function to get the current user's ID from the session
function getCurrentUserId()
{
    return $_SESSION['user_id'] ?? null;
}

// Function to set the current user's ID in the session
function setCurrentUserId($userId)
{
    $_SESSION['user_id'] = $userId;
}

// Function to check if a user is logged in
function checkForLoggedInUser($roomId, $message, $loc = 'http://localhost/hotel-booking-app/public/index.php')
{
    if (empty(getCurrentUserId())) {
        // Display an alert if the user is not logged in
        displayAlert($message, $loc);
        return false;
    }

    return true;
}

// Function to get user information based on the current user's ID
function getUserInfo() {
    $user = new User();
    $userId = getCurrentUserId();
    
    if (empty($userId)) {
        return null;
    } else {
        // Fetch and return user data
        return $user->getByUserId($userId);
    }
}

// Function to check if a user is verified
function isUserVerified() {
    if (isset($_SESSION['is_verified']) && $_SESSION['is_verified'] === true) {
        return true;
    } else {
        return false;
    }
}

// Function to sort a list of rooms based on a selected option
function getRoomsSortedList($selectedOption, $rooms, $roomsByPrice, $roomsByRating) {
    if ($selectedOption == "default") {
        // The "Our recommendations" option is selected
        $roomsList = $rooms;
    } elseif ($selectedOption === "price") {
        // The "Price only" option is selected
        $roomsList = $roomsByPrice;
    } elseif ($selectedOption === "rating") {
        // The "Rating only" option is selected
        $roomsList = $roomsByRating;
    } else {
        // The "Our recommendations" option is selected (fallback)
        $roomsList = $rooms;
    }

    return $roomsList;
}

// Function to calculate the latitude of a city
function calculateCityLat($city)
{
    $centers = [
        "Athens" => [37.983810, 23.727539],
        "Thessaloniki" => [40.640062, 22.944419],
        "Santorini" => [36.393156, 25.461509],
        "Kavala" => [40.936905, 24.413554],
    ];

    return $centers[$city][0];
}

// Function to calculate the longitude of a city
function calculateCityLng($city)
{
    $centers = [
        "Athens" => [37.983810, 23.727539],
        "Thessaloniki" => [40.640062, 22.944419],
        "Santorini" => [36.393156, 25.461509],
        "Kavala" => [40.936905, 24.413554],
    ];

    return $centers[$city][1];
}

// Function to calculate the distance of a location from the center of a city
function getDistanceFromCenter($city, $lat, $lng)
{
    $centers = [
        "Athens" => [37.983810, 23.727539],
        "Thessaloniki" => [40.640062, 22.944419],
        "Santorini" => [36.393156, 25.461509],
        "Kavala" => [40.936905, 24.413554],
    ];

    $center = $centers[$city];
    
    // Perform distance calculation
    $lat1 = deg2rad($center[0]);
    $lon1 = deg2rad($center[1]);
    $lat2 = deg2rad($lat);
    $lon2 = deg2rad($lng);
    
    $deltaLat = $lat2 - $lat1;
    $deltaLon = $lon2 - $lon1;
    
    $a = sin($deltaLat / 2) ** 2 + cos($lat1) * cos($lat2) * sin($deltaLon / 2) ** 2;
    $c = 2 * asin(sqrt($a));
    
    // Earth's radius in kilometers
    $earthRadius = 6371; 
    $distance = $earthRadius * $c;
    
    return $distance; 
}


// Function to find the intersection of two arrays based on a key
function findIntersection($arr1, $arr2, $key) {
    $intersection = array();

    // Iterate through both arrays and find matching elements
    foreach ($arr1 as $item1) {
        foreach ($arr2 as $item2) {
            if ($item1[$key] === $item2[$key]) {
                $intersection[] = $item1;
                break; 
            }
        }
    }

    return $intersection;
}

// Function to get a label based on the average reviews
function getReviewLabel($avg_reviews)
{
    switch ($avg_reviews) {
        case $avg_reviews == "NULL":
            return "No Reviews";
        case $avg_reviews >= 4.5:
            return 'Superb';
        case $avg_reviews >= 4:
            return 'Fabulous';
        case $avg_reviews >= 3.5:
            return 'Very Good';
        case $avg_reviews >= 3:
            return 'Good';
        case $avg_reviews >= 2.5:
            return 'Pleasant';
        default:
            return 'Poor';
    }
}

// Function to format a date
function getFormattedDate($date) 
{
    // Mapping of month numbers to month labels
    $months = [
        1 => 'Jan',
        2 => 'Feb',
        3 => 'Mar',
        4 => 'Apr',
        5 => 'May',
        6 => 'Jun',
        7 => 'Jul',
        8 => 'Aug',
        9 => 'Sep',
        10 => 'Oct',
        11 => 'Nov',
        12 => 'Dec'
    ];

    $dateComponents = explode('-', $date);
    if (count($dateComponents) === 3) {
        $day = $dateComponents[2];
        $monthNumber = (int)$dateComponents[1];
        $year = $dateComponents[0];

        $monthLabel = isset($months[$monthNumber]) ? $months[$monthNumber] : 'Invalid Month';

        return "$day $monthLabel $year";
    } else {
        return 'Invalid Date';
    }
}

// Function to display a room amenity
function displayRoomAmenity($amenityIcon, $amenityAlt, $amenityValue, $amenityText) {

    echo '<div class="room-amenity">
            <div class="amenity-icon display-flex justify-center">
                <img src="' . $amenityIcon . '" alt="' . $amenityAlt . '"/>
                <span>' . $amenityValue . '</span>
            </div>
            <div class="amenity-text display-flex justify-center">
                <span>' . $amenityText . '</span>
            </div>
          </div>';
}

// Function to generate a form input element
function formInput($class, $id, $text, $name, $required, $type, $image = false, $placeholder = ''){
    echo '<div class="' . $class . '">';
    ?>
            <label for=<?php echo $id; ?>><?php echo $text; ?><span class=<?php echo $required ? "required" : "invisible"; ?>>*</span></label>
            <input id=<?php echo $id; ?> name=<?php echo $name; ?> type=<?php echo $type; ?> <?php if ($placeholder != '') { ?>  placeholder="<?php echo $placeholder; ?>" <?php } ?> />
            <?php if ($image) { ?>
                <img id=<?php echo $id . "Warning"; ?> src="../resources/assets/icons/warning.png" alt=<?php echo $text . " Warning"; ?> class="warning-icon invisible"/>
                <div id=<?php echo $id . "Error"; ?> class="error invisible"></div>
            <?php } ?>
        </div>
    <?php
}

// Function to generate a form checkbox element
function formCheckbox($class, $id, $text, $name, $required, $type, $image = false){
    echo '<div class="' . $class . '">';
    ?>
            <input id=<?php echo $id; ?> name=<?php echo $name; ?> type=<?php echo $type; ?> <?php if ($placeholder != '') { ?>  placeholder="<?php echo $placeholder; ?>" <?php } ?> />
            <label for=<?php echo $id; ?>><?php echo $text; ?><span class=<?php echo $required ? "required" : "invisible"; ?>>*</span></label>
            <?php if ($image) { ?>
                <img id=<?php echo $id . "Warning"; ?> src="../resources/assets/icons/warning.png" alt=<?php echo $text . " Warning"; ?> class="warning-icon invisible"/>
                <div id=<?php echo $id . "Error"; ?> class="error invisible"></div>
            <?php } ?>
        </div>
    <?php
}

// Function to display room information
function displayRoom($roomData, $isActive = false, $isBooking = true)
{
    $roomType = $isBooking ? 'Booking' : 'Review';

    echo '<li>';
    echo '<div class="', strtolower($roomType), '-room display-flex flex-col">';
    if ($isBooking) {
        echo '<div class="booking-room-title">';
        echo '<h3>', $roomData['city'], '</h3>';
        echo '<h4>', sprintf('%s - %s', getFormattedDate($roomData['check_in_date']), getFormattedDate($roomData['check_out_date'])), '</h4>';
        echo '</div>';
    }

    echo '<div class="', strtolower($roomType), '-room-container display-flex white-background">';
    echo '<img src="../resources/assets/images/rooms/', $roomData['photo_url'], '" alt="Hotel ', $roomData['room_id'], '"/>';
    echo '<div class="', strtolower($roomType), '-room-desc display-flex flex-col justify-center">';
    echo '<h3>', $roomData['name'], '</h3>';
    if ($isBooking) {
        echo '<h4>', sprintf('%s - %s · %s', getFormattedDate($roomData['check_in_date']), getFormattedDate($roomData['check_out_date']), $roomData['city']), '</h4>';
    } else {
        $createdTime = explode(' ', $roomData['created_time'])[0];
        echo '<h4>', getFormattedDate($createdTime), '</h4>';
    }

    if (!$isBooking) {
        echo '<div class="review-rating flex-align-center">';
        echo '<p>', $roomData['comment'], '</p>';
        $reviewRate = $roomData['rate'];
        for ($i = 1; $i <= 5; $i++) {
            echo '<i class="fa fa-star white ', $i <= $reviewRate ? 'checked' : '', '"></i>';
        }
        echo '</div>';
    } else {
        echo '<h2>';
        echo '<div class="booking-state text-center dark-blue-background white ', $isActive ? 'active' : '', '">', $isActive ? 'Active' : 'Completed', '</div>';
        echo '</h2>';
    }

    echo '</div>';
    echo '<div class="right-side display-flex flex-col justify-around">';
    echo '<div class="price flex-center-right">';
    if ($isBooking) {
        echo '<h4>€ ', $roomData['total_price'], '</h4>';
        echo '<img src="../resources/assets/icons/extra-options.png" alt="Extra Options" class="extra-options-image"/>';
        echo '<div class="extra">';
        echo '<a href="room.php?room_id=', $roomData['room_id'], '">Rebook Room</a>';
        if ($isActive) {
            echo '<a href="../actions/remove_booking.php?booking_id=', $roomData['booking_id'], '">Cancel Booking</a>';
        } else {
            echo '<a href="../actions/remove_booking.php?booking_id=', $roomData['booking_id'], '">Remove Booking</a>';
        }
        echo '</div>';
    } else {
        echo '<img src="../resources/assets/icons/extra-options.png" alt="Extra Options" class="extra-options-image"/>';
        echo '<div class="extra">';
        echo '<a id="remove_review" href="../actions/remove_review.php?room_id=', $roomData['room_id'], '&review_id=', $roomData['review_id'], '">Remove Review</a>';
        echo '</div>';
    }
    echo '</div>';
    echo '<button class="view-room-btn orange-background" type="submit">';
    echo '<a class="flex-center white no-text-decoration" href="room.php?room_id=', $roomData['room_id'], '">View Room</a>';
    echo '</button>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</li>';
}

// Function to display a custom alert notification
function displayAlert($message, $loc = 'http://localhost/hotel-booking-app/public/index.php') {
    echo '<style>
    /* CSS for the custom alert notification */
    .custom-alert-container {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: rgba(0, 0, 0, 0.7);
        color: #fff;
        text-align: center;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
        z-index: 9999;
      }
      
      .custom-alert-content {
        font-size: 18px;
        margin-bottom: 10px;
      }
      
      .custom-alert-ok-button {
        background-color: #007bff;
        color: #fff;
        border: none;
        padding: 10px 20px;
        cursor: pointer;
        border-radius: 5px;
      }
      </style>
        <script>
        // Wait for the DOM to fully load
        document.addEventListener("DOMContentLoaded", function () {
            // Create a function to display the custom alert notification
            function showCustomAlert(message) {
                // Create a container element for the alert
                var alertContainer = document.createElement("div");
                console.log(alertContainer);
                alertContainer.className = "custom-alert-container";

                // Create the alert content
                var alertContent = document.createElement("div");
                alertContent.className = "custom-alert-content";
                alertContent.textContent = message;

                // Create the "OK" button
                var okButton = document.createElement("button");
                okButton.className = "custom-alert-ok-button";
                okButton.textContent = "OK";

                // Add the content and button to the container
                alertContainer.appendChild(alertContent);
                alertContainer.appendChild(okButton);

                // Append the container to the document body
                // document.body.appendChild();
                document.body.appendChild(alertContainer);

                // Add a click event listener to close the alert when the "OK" button is clicked
                okButton.addEventListener("click", function () {
                    document.body.removeChild(alertContainer);
                    window.location.href = "'. $loc .'"; // Redirect to home page
                });
            }

            // Call your showCustomAlert function after the DOM is fully loaded
            showCustomAlert("' . $message . '");
        });
    </script>';
}

// Function to display a loading overlay
function displayLoading($loc = 'http://localhost/hotel-booking-app/public/index.php')
{
    // Output HTML content
    echo '<!DOCTYPE html>
    <html>
        <head>
            <style>
                #content {
                    display: block;
                }
                #loading-overlay {
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background-color: rgba(255, 255, 255, 0.8);
                    display: none;
                    justify-content: center;
                    align-items: center;
                    z-index: 9999;
                }

                .loading-spinner {
                    border: 5px solid #f3f3f3;
                    border-top: 5px solid #3498db;
                    border-radius: 50%;
                    width: 50px;
                    height: 50px;
                    animation: spin 2s linear infinite;
                }

                @keyframes spin {
                    0% { transform: rotate(0deg); }
                    100% { transform: rotate(360deg); }
                }
                
                #profile-iframe {
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    z-index: -1;
                    border: none;
                }
            </style>
        </head>
        <body>
            <iframe id="profile-iframe" src="'. $loc .'"></iframe>
            <div id="loading-overlay">
                <div class="loading-spinner"></div>
                <p>Loading...</p>
            </div>';

        echo '<script>
            // Function to show the loading overlay
            function showLoading() {
                document.getElementById("loading-overlay").style.display = "flex";
            }

            // Function to hide the loading overlay
            function hideLoading() {
                document.getElementById("loading-overlay").style.display = "none";
            }

            // Function to delay redirect and hide loading overlay
            function delayedRedirect(url) {
                showLoading();
                setTimeout(function() {
                    window.location.href = url;
                }, 1500); // Delay of 1 second (adjust as needed)

                // Hide loading overlay after the delay
                setTimeout(hideLoading, 1500); // Same delay as above
            }

            delayedRedirect("' . $loc . '");
        </script>
        </body>
    </html>';
    exit;
}   

?>