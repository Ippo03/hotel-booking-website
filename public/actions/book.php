<?php

/**
 * This action handles the booking process for a hotel room. It verifies user authentication,
 * checks for a valid room ID, processes the booking, and redirects the user to the room's page
 * with booking details if successful, or displays an alert if any errors occur.
 */

// Boot the application
 require_once __DIR__ .'/../../boot/boot.php';

// Import necessary classes
use Hotel\User;
use Hotel\Booking;

// Include utility functions
include "../defines/Utility.php";

// Check if a room ID is provided in the request
$roomId = $_REQUEST['room_id'];
if (empty($roomId)) {
    // Redirect to the homepage if no room ID is provided
    header('Location: /');
    return;
}

// If no user is logged in, display an alert and redirect
if (!checkForLoggedInUser($roomId, 'Please log in to book a room.', sprintf('../pages/room.php?room_id=%s', $roomId))) {
    return;
}

// Get the user ID of the currently logged-in user
$userId = getCurrentUserId();

// Create a Booking instance
$booking = new Booking();

// Get the check-in and check-out dates from the request
$checkInDate = $_REQUEST['check_in_date'];
$checkOutDate = $_REQUEST['check_out_date'];

// Check if check-in and check-out dates are empty
if (empty($checkInDate) || empty($checkOutDate)) {
    // Display an alert and redirect if dates are not provided
    displayAlert('Please select a check-in and check-out date.', sprintf('../pages/room.php?room_id=%s', $roomId));
    return;
} else {
    // Insert the booking for the room
    $booking->insertBooking($roomId, $userId, $checkInDate, $checkOutDate);
}

// Redirect back to the room's page with check-in and check-out date information
header(sprintf('Location: ../pages/room.php?room_id=%s&check_in_date=%s&check_out_date=%s', $roomId, urlencode($checkInDate), urlencode($checkOutDate)));


?>