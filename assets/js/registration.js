/*$(document).ready(function() {
    $("#registrationForm").submit(function(event) {
        event.preventDefault();

        // Frontend validation (you can add more checks)
        let isValid = true;
        $(".error-message").text("");

        if ($("#username").val() === "") {
            $("#usernameError").text("Username is required.");
            isValid = false;
        }

        // Add validation for other fields (email, password, first name, last name, age, etc.)

        if (isValid) {
            let inputData = $("#registrationForm").serialize();
            // Submit the form via AJAX to the PHP script for backend validation
            $.post("main/api/registration.php", inputData, function(data) {
                $("#message").html(data);
            });
        }
    });
});*/

$(document).ready(function() {

    function isValidEmail(email) {
        // Simple email format validation using a regular expression
        let emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
        return emailPattern.test(email);
    }

    function isValidUsername(username) {
        // Username validation (letters and numbers only)
        return /^[a-zA-Z0-9]+$/.test(username);
    }

    $("#registrationForm").submit(function(event) {
        event.preventDefault();
        let isValid = true;
        $(".error-message").text("");

        // Validation for email format
        let email = $("#email").val();
        if (!isValidEmail(email)) {
            $("#emailError").text("Invalid email format.");
            isValid = false;
        }

        // Validation for username (letters and numbers only)
        let username = $("#username").val();
        if (!isValidUsername(username)) {
            $("#usernameError").text("Username can only contain letters and numbers.");
            isValid = false;
        }

        // Other form field validations (password, first name, last name, age, etc.)

        if (isValid) {
            // Submit the form via AJAX to the PHP script for backend validation
            $.post("main/jsvalidation/registration.php", $("#registrationForm").serialize(), function(data) {
                $("#message").html(data);
            });
        }
    });
});

