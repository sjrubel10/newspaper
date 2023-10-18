<?php
/**
 * Created by PhpStorm.
 * User: Sj
 * Date: 10/9/2023
 * Time: 10:10 PM
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
    <link rel="stylesheet" href="assets/css/header.css">
    <link rel="stylesheet" href="assets/css/common.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/login.js"></script>
    <title>Login</title>
</head>
<body>
<?php

//include "views/header.php"; ?>
<?php include_once "views/header.php"?>
<div class="logincontainer">
    <h2>Login</h2>
    <form id="loginForm" method="post">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
        </div>
        <button class="loginSubmit" type="submit">Login</button>
    </form>
    <div id="message"></div>
</div>
<!--<div class="container" id="logout-container">
    <h2>Logout</h2>
    <form id="logoutForm" method="post">
        <button type="submit">Logout</button>
    </form>
</div>-->


<?php
include "views/footer.php"; ?>

