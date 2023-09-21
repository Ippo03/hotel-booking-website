<?php

/**
 * This PHP script handles user login. It verifies user credentials, creates a user token,
 * sets it as a cookie, and updates the current user ID in the session upon successful login.
 * After a successful login, it redirects the user to the main page.
 */

// Boot the application
require_once __DIR__.'/../../boot/boot.php';

// Import necessary classes
use Hotel\User;

// Include utility functions
include "../defines/Utility.php";

// Start a session
session_start();

// Return to the home page if the request method is not POST
if (strtolower($_SERVER['REQUEST_METHOD']) != 'post') {
    header('Location: /');
    return;
}

// If a user is already logged in, return to the main page
if (!empty(getCurrentUserId())) {
    header('Location: /');
    return;
}

// Verify user credentials
$user = new User();
try {
    // Verify email and password
    if (!$user->verify($_REQUEST['email'], $_REQUEST['password'])) {
        throw new Exception('Invalid credentials');
    }
} catch (Exception $ex) {
    // Display an alert for invalid credentials and redirect to the login page
    displayAlert('Invalid credentials. Try again!', '../pages/login.php');
    return;
}

// Get user information by email
$userInfo = $user->getByEmail($_REQUEST['email']);

// Create a token as a cookie for the user, valid for 30 days
$token = $user->getUserToken($userInfo['user_id']);
setcookie('user_token', $token, time() + 30 * 24 * 60 * 60, '/');

// Update the current user ID in the session
$_SESSION['user_id'] = $userInfo['user_id'];

// Store the verification status in the session
$_SESSION['is_verified'] = true; 

// Redirect to the main page
header('Location: ../pages/index.php');

?>
