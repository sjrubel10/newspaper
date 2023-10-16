<?php
function getNews($conn){
    $sql = "SELECT * FROM news ORDER BY id DESC";
    $result = $conn->query($sql);

    $news = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $news[] = $row;
        }
    }

    return $news;
}

function getNewsByKey($conn, $key) {
    $key = $conn->real_escape_string($key); // Sanitize the input to prevent SQL injection

    $sql = "SELECT * FROM news WHERE `newskey` = '$key'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        return $result->fetch_assoc(); // Return the fetched row as an associative array
    } else {
        return null; // Return null if no matching record is found
    }
}


function insertNews( $title, $newkey, $description, $images, $category, $userid, $conn ) {
    // Prepare SQL statement
    // Set your values for $title, $description, $images, $category, $userid before calling this function
    $stmt = $conn->prepare("INSERT INTO news ( `title`,`newskey`, `description`, `images`, `category`, `userid` ) VALUES ( ?, ?, ?, ?, ?, ? )");
    // Bind parameters and execute the statement
    $stmt->bind_param("sssssi", $title, $newkey, $description, $images, $category, $userid);

    // Execute the statement
    if ($stmt->execute()) {
        $result = array(
            'success' => true,
            'message'=>"New record inserted successfully",
            'status_code'=>202
        );
    } else {
        echo "Error: " . $stmt->error;
        $result = array(
            'success' => false,
            'message'=>"Error: " . $stmt->error,
            'status_code'=>404
        );
    }

    // Close the statement
    $stmt->close();
    return $result;
}