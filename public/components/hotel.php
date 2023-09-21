<?php 
    // Get the current file name
    $currentFile = basename($_SERVER["PHP_SELF"]);
    
    // Determine which rooms to display based on the current page
    if ($currentFile === "index.php") {
        $rooms = $roomsList;
    } else {
        $rooms = $allAvailableRooms;
    }
?>

<!-- This component displays a list of search results, including hotel information, images, ratings, and prices.
     The content and appearance of the results vary based on the current page (index or list view). -->
<div class="search-results-container" id="search-results-container">
    <div class="info">
        <?php
        foreach($rooms as $room) { 
        ?>
            <article class="hotel flex-align-center <?php echo $currentFile === "index.php" ? "article-margin-index" : "article-margin-list"; ?>">
                <form method="post" action="../room.php"> 
                    <div class="hotel-content flex-align-center white-background <?php echo $currentFile === "index.php" ? "hotel-content-width-index" : "hotel-content-width-list"; ?>">
                        <aside class="media">
                        <?php
                            $endpoint = $room['photo_url']; 
                            $roomId = $room['room_id'];
                            $url = '../resources/assets/images/rooms/'.$endpoint;
                        ?>
                        <img src="<?php echo $url ?>" alt="Room Number <?php echo $roomId ?>" width="100%" height="auto">
                        </aside>
                        <div class="hotel-info">
                            <h1><?php echo $room['name'];?></h1>
                            <h2><?php echo sprintf('%s, %s', $room['city'], $room['area']);?></h2>
                            <p><?php echo $room['description_short'];?></p>
                        </div>
                        <div class="right-side flex-center-col">
                            <?php 
                                $avgReviews = round($room['avg_reviews'], 1);
                                $reviewLabel = getReviewLabel($avgReviews);
                                $reviewCount = $room['count_reviews'];
                            ?>
                            <div class="hotel-rating flex-center">
                                <div class="hotel-rating-label flex-align-col">
                                    <label for="rating"><?php echo $reviewLabel;?></label>
                                    <span class="rating-count"><?php echo $reviewCount;?> reviews</span>
                                </div>
                                <span class="rating-value dark-blue-background white"><?php echo $avgReviews;?></span>
                            </div>
                            <div class="price">
                                <p>Price per night:</p>
                                <p class="price-value text-right font-bold green"><?php echo $room['price'];?>€</p>
                            </div>
                            <button class="view-room-btn orange-background" type="submit">
                                <a href="room.php?room_id=<?php echo $room['room_id']?>&check_in_date=<?php echo $checkInDate ?>&check_out_date=<?php echo $checkOutDate ?>">View Room</a>
                            </button>
                        </div>
                    </div>
                </form>
            </article>
        <?php 
        }
        ?>
    </div>
</div>
