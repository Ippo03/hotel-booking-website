/*
   This script enhances the date input fields by providing functionality 
   for selecting check-in and check-out dates and using arrows to navigate through the date options.
   It uses the jQuery Datepicker plugin for date input fields and custom JavaScript functions for 
   managing date values and interactions with the date arrows. Additionally, it stores the selected
   dates in session storage.
*/

// jQuery Datepicker for date input fields
$(document).ready(function() {
    $(".datepicker").datepicker({
        dateFormat: 'yy-mm-dd'
    });
});

// Function to get the number of days in a given month and year
function getDaysInMonth(year, month) {
    const lastDay = new Date(year, month, 0);
    return lastDay.getDate();
}

// Function to split a date string (yyyy-mm-dd) into an array of year, month, and day parts
function splitDateParts(date) {
    return date.split("-").map(part => parseInt(part));
}

// Function to adjust the value of a date input field to a specified date
function adjustDateValue(datePicker, year, month, day) {
    const formattedMonth = String(month).padStart(2, '0');
    const formattedDay = String(day).padStart(2, '0');
    datePicker.value = `${year}-${formattedMonth}-${formattedDay}`;
}

// Function to update the date input field to the previous day
function updateLeftDates(year, month, day, datePicker) {
    const newDay = day - 1;

    if (newDay < 1) {
        // If the new day is less than 1, switch to the previous month or year
        const newMonth = month === 1 ? 12 : month - 1;
        const newYear = month === 1 ? year - 1 : year;
        const daysInNewMonth = getDaysInMonth(newYear, newMonth);
        adjustDateValue(datePicker, newYear, newMonth, daysInNewMonth);
    } else {
        // Otherwise, simply decrement the day
        adjustDateValue(datePicker, year, month, newDay);
    }
}

// Function to update the date input field to the next day
function updateRightDates(year, month, day, datePicker) {
    const daysInCurrentMonth = getDaysInMonth(year, month);
    const newDay = day + 1;

    if (newDay > daysInCurrentMonth) {
        // If the new day exceeds the days in the current month, switch to the next month or year
        const newMonth = month === 12 ? 1 : month + 1;
        const newYear = month === 12 ? year + 1 : year;
        adjustDateValue(datePicker, newYear, newMonth, 1);
    } else {
        // Otherwise, simply increment the day
        adjustDateValue(datePicker, year, month, newDay);
    }
}

// Wait for the DOM to fully load
document.addEventListener("DOMContentLoaded", () => {
    const $dateSearchContainer = document.querySelector(".date-search-container");

    // Add a click event listener to the date search container
    $dateSearchContainer.addEventListener("click", (e) => {
        const target = e.target;
        const $datePickerIn = document.querySelector(".datepicker-in");
        const $datePickerOut = document.querySelector(".datepicker-out");

        if (target.classList.contains("left-arrow-in") || target.classList.contains("right-arrow-in")) {
            // Handle left and right arrows for check-in date
            if ($datePickerIn.value == "") {
                $datePickerIn.value = new Date().toISOString().slice(0, 10); 
            }

            const [year, month, day] = splitDateParts($datePickerIn.value);
            
            if (target.classList.contains("left-arrow-in")) {
                updateLeftDates(year, month, day, $datePickerIn);
            } else if (target.classList.contains("right-arrow-in")) {
                updateRightDates(year, month, day, $datePickerIn);
            }

            // Store the selected check-in date in session storage
            sessionStorage.setItem("selectedCheckInDate", $datePickerIn.value);

        } else if (target.classList.contains("left-arrow-out") || target.classList.contains("right-arrow-out")) {
            // Handle left and right arrows for check-out date
            if ($datePickerOut.value == "") {
                $datePickerOut.value = new Date().toISOString().slice(0, 10); 
            }

            const [year, month, day] = splitDateParts($datePickerOut.value);
            
            if (target.classList.contains("left-arrow-out")) {
                updateLeftDates(year, month, day, $datePickerOut);
            } else if (target.classList.contains("right-arrow-out")) {
                updateRightDates(year, month, day, $datePickerOut);
            }

            // Store the selected check-out date in session storage
            sessionStorage.setItem("selectedCheckOutDate", $datePickerOut.value);
        }
    });             
});
