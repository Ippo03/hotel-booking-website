<?php

/**
 * This PHP script handles the addition and removal of rooms from a user's favorites.
 * It checks if the user is logged in, then adds or removes the selected room from their favorites.
 * Finally, it responds with a JSON object indicating the success or failure of the operation.
 */

// Boot the application
require_once __DIR__ .'/../../boot/boot.php';

// Import necessary classes
use Hotel\User;
use Hotel\Favorite;

// Include utility functions
include "../defines/Utility.php";

// Check if a room ID is provided in the POST request
$roomId = $_POST['room_id'];
if (empty($roomId)) {
    // Redirect to the homepage if no room ID is provided
    header('Location: /');
    return;
}

// If no user is logged in, display an alert
if (!checkForLoggedInUser($roomId, 'Please log in to favorite a room.', sprintf('../pages/room.php?room_id=%s', $roomId))) {
    return;
}

// Get the user ID of the currently logged-in user
$userId = getCurrentUserId();

// Create a Favorite instance
$favorite = new Favorite();

// Check if the room should be added or removed from favorites
$isFavorite = $_POST['is_favorite'];
if (!$isFavorite) {
    // Add the room to favorites
    $favorite->addFavorite($roomId, $userId);
    // Display a loading message and redirect back to the room's page
    displayLoading(sprintf('http://localhost/hotel-booking-app/public/pages/room.php?room_id=%s', $roomId));
} else {
    // Remove the room from favorites
    $favorite->removeFavorite($roomId, $userId);
    // Display a loading message and redirect back to the room's page
    displayLoading(sprintf('http://localhost/hotel-booking-app/public/pages/room.php?room_id=%s', $roomId));
}

// Respond with a JSON object indicating the operation status
header('Content-Type: application/json');

// Return to the room's page
header(sprintf('Location: ../pages/room.php?room_id=%s', $roomId));

?>

