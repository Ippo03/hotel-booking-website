<?php

/**
 * This script handles user authentication and token verification.
 *
 * It first registers an autoloading function for classes, and then it checks if there is a user token in the request.
 * If a token is present, it attempts to verify the user and sets the user information in memory.
 */

error_reporting(E_ERROR);

// Register autoload function
spl_autoload_register(function ($class) {
    $class = str_replace('\\', '/', $class);
    require_once sprintf(__DIR__.'/../app/%s.php', $class);
});

use Hotel\User;

// Create user
$user = new User();

// Check if there is a token in the request
$userToken = $_COOKIE['user_token'];
if ($userToken) {
    // Verify user
    if ($user->verifyToken($userToken)) {
        // Set user in memory
        $userInfo = $user->getTokenPayload($userToken);
    }
}

