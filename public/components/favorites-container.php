<!-- Favorites Container - Displays user's favorite properties -->
<div id="favorites" class="favorites-container light-gray-background">
    <!-- Favorites Header - Contains user-related information -->
    <div class="favorites-header flex-align-center justify-between">
        <!-- Left Side of Header - User information -->
        <div class="header-left-side flex-center-left flex-col">
            <h1 class="text-left font-bold">My next Trip</h1>
            <div class="saved-info flex-center">
                <img src="../resources/assets/icons/red-favorite.png" alt="Favorite"/>
                <p id="favorite-count"><?php echo count($userFavorites);?> properties saved</p>
            </div>
        </div>
        <!-- Map Container - For displaying the map toggle -->
        <div class="map-container">
            <!-- Map Toggle - Button to toggle map display -->
            <div class="view-map" id="map-toggle">
                <img src="../resources/assets/icons/pin.png" alt="Map"/>
                View Map
            </div>
        </div>
        <!-- Map Modal - Modal container for displaying the map -->
        <div class="modal" id="map-modal">
            <div class="modal-content" id="map-content">
                <!-- Map Display -->
                <div id="map" style="height: 300px;"></div>
            </div>
        </div>
    </div>
    <?php
    // Check if the user has favorite properties
    if (count($userFavorites) > 0) {
    ?>
    <!-- List of Favorite Properties -->
    <ol class="display-flex no-padding no-margin no-list-style">
        <?php
        // Loop through user's favorite properties
        foreach ($userFavorites as $favorite) {
        ?>
        <li data-room-id="<?php echo $favorite['room_id']; ?>">
            <!-- Favorite Property Details -->
            <div class="favorite-room flex-align-col text-center dark-gray-background">
                <div class="fav-image-container inline-block">
                    <img class="inline block" src="../resources/assets/images/rooms/<?php echo $favorite['photo_url'];?>." alt="Hotel <?php echo $favorite['room_id'];?>"/>
                    <img class="close-icon" src="../resources/assets/icons/delete.png" alt="Delete Favorite"/>
                </div>
                <!-- Favorite Property Title with Link -->
                <a class="fav-title justify-center dark-blue font-bold no-decoration" href="room.php?room_id=<?php echo $favorite['room_id']; ?>"><?php echo $favorite['name'];?></a> 
                <!-- Property Location -->
                <div class="fav-loc flex-center-loc">
                    <div class="loc-title flex-center">
                        <img class="icon" src="../resources/assets/icons/pin.png" alt="Location"/>
                        <h3><?php echo sprintf('%s, %s', $favorite['city'], $favorite['area']);?></h3>
                    </div>
                    <!-- Distance from Center -->
                    <div class="distance">
                        <h3><?php echo sprintf('%s from center', round(getDistanceFromCenter($favorite['city'], $favorite['location_lat'], $favorite['location_long']), 2));?></h3>
                    </div>
                </div>
                <!-- Right Side - Hotel Rating -->
                <div class="right-side">
                    <?php 
                        $avgReviews = round($favorite['avg_reviews'], 1);
                        $reviewLabel = getReviewLabel($avgReviews);
                        $reviewCount = $favorite['count_reviews'];
                    ?>
                    <!-- Hotel Rating Display -->
                    <div class="hotel-rating flex-center">
                        <div class="hotel-rating-label flex-align-col">
                            <label for="rating"><?php echo $reviewLabel;?></label>
                            <span class="rating-count"><?php echo $reviewCount;?> reviews</span>
                        </div>
                        <span class="rating-value dark-blue-background white"><?php echo $avgReviews;?></span>
                    </div>
                </div>
                <!-- View Room Button -->
                <button class="view-room-btn orange-background" type="submit">
                    <a class="flex-center white no-text-decoration" href="room.php?room_id=<?php echo $favorite['room_id'];?>">View Room</a>
                </button>
            </div>
        </li>
        <?php
        }
        ?>
    </ol>
    <?php
    } else {
    ?>
    <!-- Message when the user has no favorite properties -->
    <h4>You don't have any favorites</h4>
    <?php
    }
    ?>
</div>
