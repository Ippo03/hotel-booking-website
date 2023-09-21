<?php

/**
 * This PHP and HTML file represents the "Register" page of the Cozy Inn hotel booking website.
 * It allows new users to create an account by providing their personal information, including
 * username, first name, last name, gender, email address, password, and agreeing to terms.
 * The page also includes a link to the login page for existing users.
 */

// Boot the application
require_once __DIR__ .'/../../boot/boot.php';

// Import necessary classes
use Hotel\User;

// Import utility functions
include "../defines/Utility.php";

// Checked for existing logged in user
if(!empty(getCurrentUserId())) {
    header('Location: index.php'); die;
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8"/>
        <title>Register Page</title>
        <link href="../resources/css/global.css" type="text/css" rel="stylesheet"/>
        <link href="../resources/css/account.css" type="text/css" rel="stylesheet"/>
        <link rel="icon" href="../resources/assets/icons/favicon.png">
        <script src="../resources/js/signup-validation.js" type="text/javascript"></script>
        <script src="../resources/js/validation-functions.js" type="text/javascript"></script>
    </head>
    <body>
        <main>
            <div class="signup-container white-background border-box">
                <!-- Sign Up Container Title and Subtitle -->
                <div class="signup-title text-center font-bold">
                    <h1>Create Your Cozy Inn Account</h1>
                    <h2>Already have a Cozy Inn Account?<a class="links" href="login.php" target="_blank">Sign In</a></h2>
                </div>

                <!-- Sign Up Form for new Users -->
                <form class="signup-form-info" method="POST" action="../actions/register.php">
                    <?php if (!empty($_GET['error'])) { ?>
                    <div class="error">Register Error</div>
                    <?php } ?>
                    <!-- User's Information -->
                    <div class="signup-user-info flex-align-col">
                        <?php $class1 = "signup-input-container flex-center-left"; ?>
                        <?php $class2 = "signup-checkbox-container flex-center-left"; ?>

                        <!-- Input Field for User's Username -->
                        <?php echo formInput($class1, "userName", "Username", "name", true, "text", true, "ex.JohnDoe99"); ?>

                        <!-- Input Field User's Firstname -->
                        <?php echo formInput($class1, "firstName", "Firstname", "first_name", true, "text", true, "ex.John"); ?>

                        <!-- Input Field User's Lastname -->
                        <?php echo formInput($class1, "lastName", "Lastname", "last_name", true, "text", true, "ex.Doe"); ?>

                        <!-- Input Field User's Gender -->
                        <div class="<?php echo $class1; ?>">
                            <label for="gender">Gender</label>
                            <select id="gender" name="gender">
                                <option value="null" selected>Choose your gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="nonbi">Non Binary/Other</option>
                            </select>
                        </div>

                        <!-- Input Field User's Email Address -->
                        <?php echo formInput($class1, "emailAddress", "Email", "email", true, "email", true, "user@example.com"); ?>

                        <!-- Input Field User's Password -->
                        <?php echo formInput($class1, "password", "Password", "password", true, "password", true); ?>
                        
                        <!-- Input Field User's Confirmed Password -->
                        <?php echo formInput($class1, "confirmPassword", "Confirm Password", "confirm_password", true, "password", true); ?>

                        <!-- Checkbox for News Letter -->
                        <?php echo formCheckbox($class2, "newsLetter", "Join our mailing list and get exclusive deals!", "newsLetter", false, "checkbox"); ?>

                        <!-- Checkbox for Agree Terms -->
                        <?php echo formCheckbox($class2, "agreeTerms", "I have understood and agree with the Terms of Use and the Privacy Policy", "agreeTerms", true, "checkbox", true); ?>
                    
                        <!-- Button to Create Account -->
                        <input id="createAccBtn" class="signup-button faint white no-border btn-pointer" name="CreateButton" type="submit" value="Create Account" disabled/>
                    </div>
                </form>
            </div>
        </main>
    </body>
</html>