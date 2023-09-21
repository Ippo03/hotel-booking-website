<?php

/**
 * This PHP script handles the removal of a booking. It retrieves the booking ID from the request,
 * removes the booking, and then redirects the user to the profile page.
 */

// Boot the application
require_once __DIR__ .'/../../boot/boot.php';

// Import necessary classes
use Hotel\User;
use Hotel\Booking;

// Include utility functions
include "../defines/Utility.php";

// Get the booking ID from the request
$bookingId = $_REQUEST['booking_id'];

// Check if a booking ID is provided
if (empty($bookingId)) {
    // Redirect to the home page if no booking ID is provided
    header('Location: /');
    return;
}

// Create a Booking instance
$booking = new Booking();

// Remove the booking
$booking->removeBooking($bookingId);

// Redirect to the profile page
displayLoading('../pages/profile.php');

?>

