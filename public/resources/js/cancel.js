// This code handles the removal of a favorite room.
// It listens for the click event on elements with the "close-icon" class within list items.
// When clicked, it sends an AJAX request to delete the room from the database and updates the UI accordingly.

// Wait for the document to be fully loaded
$(document).ready(function() {
    // Add a click event listener to elements with the "close-icon" class
    $(".close-icon").click(function(event) {
        event.preventDefault();

        // Find the closest <li> element to the clicked icon
        const $li = $(this).closest("li");
        const $favoriteRoom = $li.attr("data-room-id");

        // Send an AJAX request to delete the favorite room from the database
        $.ajax({
            type: 'POST',
            url: '../actions/delete.php',
            data: { favoriteRoom: $favoriteRoom },
            dataType: 'json', 
            success: function(responseData) {
                if (responseData.success) {
                    // Remove the list item from the DOM
                    $li.remove();

                    // Decrease the favorite count in the UI
                    decreaseFavoriteCount();
                } else {
                    console.error('Error:', responseData.error);
                }
            },
            error: function(xhr, textStatus, errorThrown) {
                console.error('Error:', errorThrown);
            }
        });
    });
});

// Function to decrease the favorite count in the UI
function decreaseFavoriteCount() {
    const $favoriteCount = $("#favorite-count");
    const favoriteCount = parseInt($favoriteCount.text());

    // Update the favorite count in the UI
    $favoriteCount.text((favoriteCount - 1) + " properties saved");
}
