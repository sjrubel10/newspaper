<?php
require_once "../init.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $conn = Db_connect();
    $comment = $conn->real_escape_string($_POST["comment"]);

    // Insert the comment into the database
    $sql = "INSERT INTO comments (comment) VALUES ('$comment')";
    if ($conn->query($sql) === TRUE) {
        echo "Comment added successfully!";
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
