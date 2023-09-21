<?php

/**
 * This PHP script handles user registration. It verifies if the email is already in use,
 * inserts a new user into the database, creates a user token, sets it as a cookie, and 
 * informs the user about the successful registration. After registration, it redirects the
 * user to the login page.
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

class EmailInUseException extends Exception {}
class RegistrationFailedException extends Exception {}

$user = new User();
try {
    // Check if the email already exists
    if ($user->getByEmail($_REQUEST['email'])) {
        throw new EmailInUseException('Email already in use');
    }
    // Insert a new user
    if (!$user->insert($_REQUEST['name'], $_REQUEST['email'], $_REQUEST['password'])) {
        throw new RegistrationFailedException('Could not register user');
    }
} catch (EmailInUseException $ex) {
    // Display an alert for an email already in use and redirect to the registration page
    displayAlert('Email already in use', '../pages/register.php');
    return;
} catch (RegistrationFailedException $ex) {
    // Display an alert for a failed registration and redirect to the registration page
    displayAlert('Could not register user', '../pages/register.php');
    return;
}

// Create a token as a cookie for the user, valid for 30 days
$userInfo = $user->getByEmail($_REQUEST['email']);
$token = $user->getUserToken($userInfo['user_id']);
setcookie('user_token', $token, time() + 30 * 24 * 60 * 60, '/');

// Inform the user about the successful registration
displayAlert('Registration successful! Please sign in', '../pages/login.php');

?>
