/*
   This section of the code defines functions for validating various form fields 
   such as names, email addresses, passwords, and the agree terms checkbox.
*/

// Function for validating name (username, firstname, lastname)
function getNameValidation(name) {
    const MIN_LENGTH = 4;
    const MAX_LENGTH = 18;
    const allowedCharsRegex = /^[a-zA-Z0-9]+$/;
    const reservedNames = [
        "admin", "administrator", "root", "superuser", "guest", "test", "user", "username",
        "webmaster", "moderator", "support", "contact", "info", "billing", "helpdesk"
    ];
    const nameLength = name.length;

    if (nameLength < MIN_LENGTH || nameLength > MAX_LENGTH) {
        return { valid: false, errorMsg: "Name must be between 4 and 18 characters long" };
    }

    if (!allowedCharsRegex.test(name)) {
        return { valid: false, errorMsg: "Name must contain only letters and numbers" };
    }

    if (reservedNames.includes(name)) {
        return { valid: false, errorMsg: "Name is reserved" };
    }

    return { valid: true, errorMsg: "" };
}

// Function for validating email address
function getEmailValidation(email) {
    const MAX_LENGTH = 255;
    const emailRegex = /^[a-zA-Z0-9]+@[a-zA-Z0-9]+\.[a-zA-Z0-9]+$/;

    if (email === "") {
        return { valid: false, errorMsg: "Email cannot be empty" };
    }

    if (email.length > MAX_LENGTH) {
        return { valid: false, errorMsg: "Email must be less than 255 characters long" };
    }

    if (!emailRegex.test(email)) {
        return { valid: false, errorMsg: "Email is invalid" };
    }

    return { valid: true, errorMsg: "" };
}

// Function for validating password
function getPasswordValidation(password) {
    const MIN_LENGTH = 8;
    const MAX_LENGTH = 25;
    const passwordLength = password.length;
    const hasLowerCase = /[a-z]/.test(password);
    const hasUpperCase = /[A-Z]/.test(password);
    const hasNumber = /\d/.test(password);
    const hasSpecialChar = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/.test(password);
    const commonPasswords = [
        "password", "123456", "qwerty", "123456789", "abc123", "password123", "letmein", "admin",
        "welcome", "12345678"
    ];

    if (passwordLength < MIN_LENGTH || passwordLength > MAX_LENGTH) {
        return { valid: false, errorMsg: "Password must be between 8 and 25 characters long" };
    }

    if (!hasLowerCase || !hasUpperCase || !hasNumber || !hasSpecialChar) {
        return {
            valid: false,
            errorMsg: "Password must contain at least one lowercase letter, one uppercase letter, one number, and one special character"
        };
    }

    if (commonPasswords.includes(password)) {
        return { valid: false, errorMsg: "Password is too common" };
    }

    return { valid: true, errorMsg: "" };
}

// Function for validating password confirmation
function matchPasswords(password1, password2) {
    return password1 === password2 ? { valid: true, errorMsg: "" } : { valid: false, errorMsg: "Passwords do not match" };
}

// Function for validating agree terms checkbox
function getAgreeTermsValidation(agreeTerms) {
    return agreeTerms ? { valid: true, errorMsg: "" } : { valid: false, errorMsg: "You must agree to the terms and conditions" };
}
