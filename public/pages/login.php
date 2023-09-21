<?php

/**
 * This PHP and HTML file represents the "Log In" page of the Cozy Inn hotel booking website.
 * It allows users to log in with their email address and password or create a new account.
 * The page includes a log in form and an option to navigate to the registration page.
 */

// Boot the application
require_once __DIR__ .'/../../boot/boot.php';

// Import necessary classes
use Hotel\User;

// Import utility functions
include "../defines/Utility.php";

// Start session
session_start();

// Checked for existing logged in user
if(!empty(getCurrentUserId())) {
    header('Location: index.php'); die;
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8"/>
        <title>Log in with email or phone</title>
        <link href="../resources/css/global.css" type="text/css" rel="stylesheet"/>
        <link href="../resources/css/account.css" type="text/css" rel="stylesheet"/>
        <link rel="icon" href="../resources/assets/icons/favicon.png">
    </head>
    <body>
        <main>
            <div class="login-container white-background border-box">
                <!-- Log In Container Title -->
                <h1 class="login-title text-center font-bold">Cozy Inn Account Log In</h1>

                <!-- Log In Form for Users -->
                <form class="login-form-info" method="POST" action="../actions/login.php">
                    <!-- User's Information -->
                    <div class="login-user-info flex-align-col">
                        <?php $class1 = "login-input-container flex-center-left flex-col"; ?>
                        <!-- Input Field for User's Email Address -->
                        <?php echo formInput($class1, "emailAddress", "Email", "email", false, "email"); ?>

                        <!-- Input Field for User's Password -->
                        <?php echo formInput($class1, "password", "Password", "password", false, "password"); ?>

                        <!-- Button to Log In -->
                        <input class="login-button green-background white no-border btn-pointer" name="LogIn" id="LogIn" type="submit" value="Log In"/>
                    </div>
                </form>
            </div>

            <div class="create-acc-container white-background border-box">
                <!-- Create Account Container Title -->
                <h1 class="create-acc-title text-center font-bold">Don't have a Cozy Inn Account?</h1>
                <!-- Link To "register.html" Page -->
                <a class="links-none flex-center-left flex-col" href="register.php" target="_blank">
                    <button class="create-acc-button white no-border btn-pointer">Create Account</button>
                </a>
                <!-- Mini Footer -->
                <p class="text-center">© Cozy Inn | Terms of Use | Privacy Policy</p>
            </div>
        </main>
    </body>
</html>