<!-- This is the header component of the Cozy Inn website. It contains a logo and navigation links.
     If the user is not verified (not logged in), it displays "Sign Up" and "Sign In" links.
     If the user is verified (logged in), it displays a user profile menu with links to user-related actions
     such as bookings, favorites, reviews, and sign out. -->
<header>  
    <a title="a Greek hotel searching platform" href="index.php">
        <h1>Cozy Inn</h1>
    </a>
    <nav>
        <ul>
        <?php
                // Check if the user is not verified (not logged in)
                if (!$isVerified) {
            ?>
                <!-- Display Sign Up and Sign In links -->
                <li>
                    <a href="register.php" target="_blank">
                        <img src="../resources/assets/icons/sign-up.png" alt="Sign Up"/>
                        Sign Up
                    </a>
                </li>
                <li>
                    <a href="login.php" target="_blank">
                        <img src="../resources/assets/icons/log-in.png" alt="Log In"/>
                        Sign In
                    </a>
                </li>
            <?php
                } else {
            ?>
                <!-- Display user profile menu if the user is verified (logged in) -->
                <li class="profile-dropdown">
                    <a href="profile.php" class="profile-menu" target="_blank">
                        <img src="../resources/assets/icons/profile.png" alt="Profile"/>
                        <?php echo $userInfo['name'] ?>
                    </a>
                    <div class="profile-dropdown-content">
                        <!-- Display user-related links in the dropdown -->
                        <a href="profile.php#bookings">
                            <img src="../resources/assets/icons/booking.png" alt="Bookings"/>
                            Bookings
                        </a>
                        <a href="profile.php#favorites">
                            <img src="../resources/assets/icons/favorite.png" alt="Favorites"/>
                            Favorites
                        </a>
                        <a href="profile.php#reviews">
                            <img src="../resources/assets/icons/reviews.png" alt="Reviews"/>
                            Reviews
                        </a>
                        <a href="../actions/signout.php">
                            <img src="../resources/assets/icons/sign-out.png" alt="Sign Out"/>
                            Sign Out
                        </a>
                    </div>
                </li>
            <?php
                }
            ?>
        </ul>
    </nav> 
</header>
