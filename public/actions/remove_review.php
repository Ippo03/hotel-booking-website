<?php

/**
 * This PHP script handles the removal of a review. It retrieves the room ID and review ID from the request,
 * removes the review, and then redirects the user to the profile page.
 */

// Boot the application
require_once __DIR__ .'/../../boot/boot.php';

// Import necessary classes
use Hotel\User;
use Hotel\Review;

// Include utility functions
include "../defines/Utility.php";

// Get the room ID and review ID from the request
$roomId = $_REQUEST['room_id'];
$reviewId = $_REQUEST['review_id'];

// Check if both room ID and review ID are provided
if (empty($roomId) || empty($reviewId)) {
    // Redirect to the home page if either ID is missing
    header('Location: /');
    return;
}

// Create a Review instance
$review = new Review();

// Remove the review
$review->removeReview($roomId, $reviewId);

// Redirect to the profile page with the room ID
displayLoading(sprintf('../pages/profile.php', $roomId));

?>
