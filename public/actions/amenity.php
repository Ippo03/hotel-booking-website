<?php 

/**
 * This action filters hotel rooms based on selected amenities and stores the filtered results in a session variable.
 * It then redirects the user back to the room listing page.
 */

// Boot the application
require_once __DIR__ .'/../../boot/boot.php';

// Import necessary classes
use Hotel\User;
use Hotel\Room;

// Start or continue the session
session_start();

// Retrieve amenities values from the request
$freeWifi = $_REQUEST['free_wifi'];
$petsAllowed = $_REQUEST['pets_allowed'];
$freeParking = $_REQUEST['free_parking'];
$gym = $_REQUEST['gym'];
$spa = $_REQUEST['spa'];
$airCondition = $_REQUEST['air_condition'];
$roomService = $_REQUEST['room_service'];
$pool = $_REQUEST['pool'];

// Get the current URL from the request
$URL = $_REQUEST['current_url'];

// Create an array to store amenity filters
$amenities = [
    'wifi' => $freeWifi ? 1 : 0,
    'pet_friendly' => $petsAllowed ? 1 : 0,
    'parking' => $freeParking  ? 1 : 0,
    'gym' => $gym ? 1 : 0,
    'spa' => $spa ? 1 : 0,
    'air_condition' => $airCondition ? 1 : 0,
    'room_service' => $roomService ? 1 : 0,
    'pool' => $pool ? 1 : 0,
];

// Create a Room instance
$room = new Room();

// Filter rooms based on selected amenities
$filteredRooms = $room->filterAmenities($amenities);

// Store the filtered rooms in the session
$_SESSION['filtered_rooms'] = $filteredRooms;

// Redirect back to the room page with referrer information
header(sprintf('Location: %s', $URL === NULL ? '../pages/list.php?referrer=actions/amenity' : $URL));

?>
