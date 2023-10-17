$(document).ready(function() {
    // Check if the user is logged in
    /*$.get("check_login.php", function(data) {
        if (data === "true") {
            $("#loginForm").hide();
            $("#logout-container").show();
        } else {
            $("#loginForm").show();
            $("#logout-container").hide();
        }
    });*/

    $("#loginForm").submit(function(event) {
        event.preventDefault();
        let username = $("#username").val();
        let password = $("#password").val();
        $.post("main/jsvalidation/login.php",
            {
                username: username,
                password: password
            },
            function(data) {
                console.log( data );
                if (data === "success") {
                    $("#message").text("Login successful.");
                    $("#loginForm").hide();
                    $("#logout-container").show();
                } else {
                    $("#message").text("Login failed. Check your username and password.");
                }
                });
        });

    /*$("#logoutForm").submit(function(event) {
        event.preventDefault();

        // Perform session destruction on the server-side when the user logs out
        $.post("logout.php", function(data) {
            if (data === "success") {
                $("#loginForm").show();
                $("#logout-container").hide();
                $("#message").text("Logout successful.");
            }
        });
    });*/

});
