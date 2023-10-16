<?php
function Db_connect(){
    $servername = "localhost";
    $username = "wpdbuser";
    $password = "";
    $database = "movie";

    // Create a connection
    $conn = new mysqli( $servername, $username, $password, $database );

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Return the connection object
    return $conn;

}