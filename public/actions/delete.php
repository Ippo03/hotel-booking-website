<?php

/**
 * This action handles the removal of a favorite room for a logged-in user. 
 * It checks for a POST request, verifies user authentication, and removes the favorite room.
 * It then sends a JSON response indicating success or failure.
 */

// Send a JSON response indicating success or failure
header('Content-Type: application/json');

// Boot the application
require_once __DIR__ . '/../../boot/boot.php';

// Import necessary classes
use Hotel\User;
use Hotel\Favorite;

// Include utility functions
include "../defines/Utility.php";

// Check if it's a POST request
if (strtolower($_SERVER['REQUEST_METHOD']) == 'post') {
    // Check if a user is logged in
    $userId = getCurrentUserId();
    if (!empty($userId)) {
        // Get the favorite room id from the request
        $favoriteRoomId = $_REQUEST['favoriteRoom'];
        
        // Create favorite
        $favorite = new Favorite();
        
        // Remove favorite room
        $success = $favorite->removeFavorite($favoriteRoomId, $userId);

        if ($success) {
            // Send a JSON response indicating success
            echo json_encode(array('success' => true, 'message' => 'Favorite room removed'));
        } else {
            // Send a JSON response indicating an error
            echo json_encode(array('success' => false, 'error' => 'Failed to remove favorite room'));
        }
    } else {
        // Send a JSON response indicating user not logged in
        echo json_encode(array('success' => false, 'error' => 'User not logged in'));
    }
} else {
    // Send a JSON response indicating invalid request method
    echo json_encode(array('success' => false, 'error' => 'Invalid request method'));
}

?>

























