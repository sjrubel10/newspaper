<?php
/**
 * Created by PhpStorm.
 * User: Sj
 * Date: 10/9/2023
 * Time: 10:09 PM
 */
require "main/init.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/headerfooter.css">
    <link rel="stylesheet" type="text/css" href="assets/css/registration_login.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/registration.js"></script>
    <title>Registration</title>
</head>
<body>

<?php
//include "views/header.php"; ?>
<div class="container">
    <h2>Registration Form</h2>
    <form id="registrationForm" method="post">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>
            <span id="usernameError" class="error-message"></span>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>
            <span id="emailError" class="error-message"></span>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
            <span id="passwordError" class="error-message"></span>
        </div>
        <div class="form-group">
            <label for="firstName">First Name:</label>
            <input type="text" name="firstName" id="firstName" required>
            <span id="firstNameError" class="error-message"></span>
        </div>
        <div class="form-group">
            <label for="lastName">Last Name:</label>
            <input type="text" name="lastName" id="lastName" required>
            <span id="lastNameError" class="error-message"></span>
        </div>
        <div class="form-group">
            <label for="age">Age:</label>
            <input type="number" name="age" id="age" required>
            <span id="ageError" class="error-message"></span>
        </div>
        <div class="form-group">
            <label>Gender:</label>
            <input type="radio" name="gender" value="male" required> Male
            <input type="radio" name="gender" value="female" required> Female
        </div>
        <button type="submit">Register</button>
    </form>
    <div id="message"></div>
</div>

<?php
include "views/footer.php"; ?>

