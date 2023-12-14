<?php

// Database connection code goes here

/*if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Validate user credentials (you should use password_hash() in production)
    // Perform a SELECT query from the 'users' table to check if the user exists

    // Example:
    // $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    // Execute the query and check if a row is returned

    if ($user_exists) {
        echo "Login successful";
    } else {
        echo "Invalid credentials";
    }
}

<?php
// Include the Facebook SDK
require_once 'path/to/facebook-php-sdk/autoload.php';

// Initialize the Facebook SDK with your app credentials
$fb = new Facebook\Facebook([
    'app_id' => 'your-app-id',
    'app_secret' => 'your-app-secret',
    'default_graph_version' => 'v12.0',
]);

// Get access token from the client-side
$accessToken = $_POST['accessToken'];

// Get user data from Facebook using the access token
try {
    $response = $fb->get('/me?fields=id,name,email', $accessToken);
    $userData = $response->getGraphUser();
    $facebookId = $userData->getId();
    $email = $userData->getEmail();

    // Check if the user with this Facebook ID already exists in your database
    // If not, you may want to create a new account or link it to an existing account
    // ...

    // Respond to the client-side (you may want to send a token for further authentication)
    echo "Facebook login successful. User ID: $facebookId, Email: $email";
} catch (\Facebook\Exceptions\FacebookResponseException $e) {
    // Handle Facebook API errors
    echo 'Graph returned an error: ' . $e->getMessage();
} catch (\Facebook\Exceptions\FacebookSDKException $e) {
    // Handle SDK errors
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
}
?>

*/


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login and Registration System</title>
    <link rel="stylesheet" href="style.css">

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .login-container {
            margin-bottom: 20px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

    </style>
</head>
<body>
    <div class="container">
        <div class="login-container">
            <form id="loginForm">
                <h2>Normal Login</h2>
                <input type="text" id="username" name="username" placeholder="Username" required>
                <input type="password" id="password" name="password" placeholder="Password" required>
                <button type="button" onclick="normalLogin()">Login</button>
            </form>
        </div>
        <div class="social-login-container">
            <h2>Social Login</h2>
            <button onclick="facebookLogin()">Login with Facebook</button>
            <button onclick="googleLogin()">Login with Google</button>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="script.js"></script>
</body>
</html>

<script>
    function normalLogin() {
        var username = $("#username").val();
        var password = $("#password").val();

        $.ajax({
            type: "POST",
            url: "login.php",
            data: {
                username: username,
                password: password
            },
            success: function (response) {
                alert(response);
            }
        });
    }


    function facebookLogin() {
        // Initialize the Facebook SDK
        FB.init({
            appId: 'your-app-id',
            autoLogAppEvents: true,
            xfbml: true,
            version: 'v12.0'
        });

        // Trigger the Facebook login dialog
        FB.login(function(response) {
            if (response.authResponse) {
                // User is logged in with Facebook
                // You can now make an AJAX call to your server to handle the login
                // Send the 'response.authResponse.accessToken' to your server
                var accessToken = response.authResponse.accessToken;

                $.ajax({
                    type: "POST",
                    url: "facebook_login.php",
                    data: { accessToken: accessToken },
                    success: function (response) {
                        alert(response);
                    }
                });
            } else {
                // User cancelled login or did not grant permission
                console.log('Facebook login cancelled');
            }
        }, {scope: 'public_profile,email'});
    }


    function googleLogin() {
        // Implement Google login functionality
    }

</script>
