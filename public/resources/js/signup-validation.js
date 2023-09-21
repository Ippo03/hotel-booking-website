/*
   The script enhances the functionality of the signup form by validating user input and enabling/disabling
   the "Create Account" button based on the input's validity. It also provides error messages for invalid input.
*/

// Wait for the DOM to fully load
document.addEventListener("DOMContentLoaded", () => {
    const $form = document.querySelector(".signup-form-info");
    const $createAccBtn = document.querySelector("#createAccBtn");

    // Array of allowed field IDs
    const allowedIds = ["userName", "firstName", "lastName", "emailAddress", "password", "confirmPassword", "agreeTerms"];

    // Object to track field validation state
    let isValidList = {
        userName: { valid: false, value: "", errorMsg: "" },
        firstName: { valid: false, value: "", errorMsg: "" },
        lastName: { valid: false, value: "", errorMsg: "" },
        emailAddress: { valid: false, value: "", errorMsg: "" },
        password: { valid: false, value: "", errorMsg: "" },
        confirmPassword: { valid: false, value: "", errorMsg: "" },
        agreeTerms: { valid: false, value: "", errorMsg: "" },
    };

    // Function to validate a field based on its name and value
    function validateField(fieldName, fieldValue) {
        switch (fieldName) {
            case "userName":
            case "firstName":
            case "lastName":
                return getNameValidation(fieldValue);
            case "emailAddress":
                return getEmailValidation(fieldValue);
            case "password":
                return getPasswordValidation(fieldValue);
            case "confirmPassword":
                return matchPasswords(fieldValue, $form.querySelector("#password").value);
            case "agreeTerms":
                return getAgreeTermsValidation(fieldValue);
            default:
                return false;
        }
    }

    // Function to update the field's validity in the isValidList object
    function updateFieldValidity(fieldName, isValid, errorMsg) {
        isValidList[fieldName].valid = isValid;
        isValidList[fieldName].value = fieldValue;
        isValidList[fieldName].errorMsg = errorMsg;
    }

    // Input event handler for field changes
    function handleFieldInput(e) {
        fieldName = e.target.id;
        if (allowedIds.includes(fieldName)) {
            fieldValue = e.target.type === "checkbox" ? e.target.checked : e.target.value;
            const isValidInput = validateField(fieldName, fieldValue).valid;
            errorMsgInput = validateField(fieldName, fieldValue).errorMsg;
            updateFieldValidity(fieldName, isValidInput, errorMsgInput);
            hideErrorMessage(fieldName);
            checkCreateAccBtn();
        }
    }

    // Change event handler for field changes (e.g., when losing focus)
    function handleFieldChange(e) {
        fieldName = e.target.id;
        if (allowedIds.includes(fieldName)) {
            const isValidChange = isValidList[fieldName].valid;
            const errorMsgChange = isValidList[fieldName].errorMsg;
            hideErrorMessage(fieldName);
            if (!isValidChange && fieldValue !== "") {
                displayErrorMessage(fieldName, errorMsgChange);
            } else {
                hideErrorMessage(fieldName);
            }

            checkCreateAccBtn();
        }
    }

    // Function to display an error message for a field
    function displayErrorMessage(fieldName, errorMessage) {
        const [$errorElement, $errorIcon] = getErrorElements(fieldName);
        let errorTemplate = errorMessage;

        if (fieldName === "userName") {
            errorTemplate = `User${errorMessage.toLowerCase()}`;
        } else if (fieldName === "firstName") {
            errorTemplate = `First${errorMessage.toLowerCase()}`;
        } else if (fieldName === "lastName") {
            errorTemplate = `Last${errorMessage.toLowerCase()}`;
        }

        $errorElement.innerText = errorTemplate;
        $errorElement.classList.remove("invisible");
        $errorIcon.classList.remove("invisible");
    }

    // Function to hide the error message for a field
    function hideErrorMessage(fieldName) {
        const [$errorElement, $errorIcon] = getErrorElements(fieldName);
        $errorElement.textContent = "";
        $errorElement.classList.add("invisible");
        $errorIcon.classList.add("invisible");
    }

    // Function to get error elements for a field
    function getErrorElements(fieldName) {
        const $errorElement = document.getElementById(`${fieldName}Error`);
        const $errorIcon = document.getElementById(`${fieldName}Warning`);
        return [$errorElement, $errorIcon];
    }

    // Function to check the "Create Account" button's status
    function checkCreateAccBtn() {
        const isValid = Object.values(isValidList).every((row) => row.valid === true);
        $createAccBtn.disabled = !isValid;
        isValid ? $createAccBtn.classList.remove("faint") : $createAccBtn.classList.add("faint");
    }

    // Input event listener to handle input changes and validate fields.
    $form.addEventListener("input", handleFieldInput);
    // Change event listener to handle field changes (e.g., when losing focus).
    $form.addEventListener("change", handleFieldChange);

    $createAccBtn.addEventListener("click", (e) => {
        // Handle form submission here
    });
});
