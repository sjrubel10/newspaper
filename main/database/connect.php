<?php
function Db_connect(){
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "newsportal";

    // Create a connection
    $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Set the character set to utf8mb4
    if (!mysqli_set_charset($conn, "utf8mb4")) {
        die("Error loading character set utf8mb4: " . mysqli_error($conn));
    }

    // Return the connection object
    return $conn;
}
