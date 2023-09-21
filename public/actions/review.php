<?php

/**
 * This PHP script handles the submission of room reviews. It checks if a user is logged in, validates the CSRF token,
 * and inserts a new review into the database. After submission, it redirects the user back to the room's page with the reviews section.
 */

// Boot the application
require_once __DIR__.'/../../boot/boot.php';

// Import necessary classes
use Hotel\User;
use Hotel\Room;
use Hotel\Review;

// Include utility functions
include "../defines/Utility.php";

// Check if a room ID is provided in the POST request
$roomId = $_POST['room_id'];
if (empty($roomId)) {
    // Redirect to the home page if no room ID is provided
    header('Location: /');
    return;
}

// If no user is logged in, display an alert and redirect
if (!checkForLoggedInUser($roomId, 'Please log in to review a room.', sprintf('../pages/room.php?room_id=%s', $roomId))) {
    return;
}

// Get the user ID
$userId = getCurrentUserId();

// Verify the CSRF token
$csrf = $_POST['csrf'];
if (empty($csrf) || !User::verifyCsrf($csrf)) {
    header('Location: /');
    return;
}

// Create a Review instance
$review = new Review();

// Get the rate and comment from the POST data
$rate = $_POST['rate'];
$comment = $_POST['comment'];

// Check if the rate is provided
if (empty($rate)) {
    displayAlert('Please select a rate.', sprintf('../pages/room.php?room_id=%s', $roomId));
    return;
}

// Check if the comment is provided
if (empty($comment)) {
    displayAlert('Please enter a comment.', sprintf('../pages/room.php?room_id=%s', $roomId));
    return;
}

// Add the review
$review->insertReview($roomId, $userId, $_POST['rate'], $_POST['comment']);

// Redirect back to the room's page with the reviews section
header(sprintf('Location: ../pages/room.php?room_id=%s#reviews', $roomId));

?>
