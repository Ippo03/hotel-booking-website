/*
   This script enhances the behavior of the price slider input field.
   It updates and displays the selected price, saves it to local storage, and retrieves it from local storage.
*/

// Wait for the DOM to fully load
document.addEventListener('DOMContentLoaded', function() {
    // Price slider input element
    const $priceSlider = document.getElementById('price-slider'); 
    // Price display element
    const $priceDisplay = document.getElementById('price-display'); 

    // Function to update the price display
    function updatePriceDisplay(price) {
        $priceDisplay.textContent = `Selected Price: $${price}`;
    }

    // Function to save price to local storage
    function savePriceToLocalStorage(price) {
        localStorage.setItem('selectedPrice', price);
    }

    // Function to get price from local storage
    function getPriceFromLocalStorage() {
        return localStorage.getItem('selectedPrice');
    }

    // Initialize the price display with the stored value, if available
    const storedPrice = getPriceFromLocalStorage();
    if (storedPrice !== null) {
        updatePriceDisplay(storedPrice);
        $priceSlider.value = storedPrice;
    }

    // Event listener for input changes on the price slider
    $priceSlider.addEventListener('input', function() {
        const selectedPriceIn = $priceSlider.value;
        updatePriceDisplay(selectedPriceIn);
        
        // Save the selected price to local storage
        savePriceToLocalStorage(selectedPriceIn);
    });
});
