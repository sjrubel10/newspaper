<?php
function getNews( $conn, $limit, $category = false ){
    if( $category ){
        $sql = "SELECT * FROM news WHERE `recorded`=1 AND `post_status`=1 AND `category`= '$category' ORDER BY id DESC LIMIT $limit";
    }else{
        $sql = "SELECT * FROM news WHERE `recorded`=1 AND `post_status`=1 ORDER BY id DESC";
    }
    $result = $conn->query($sql);
    if ( $result ) {
        $newsRecords = array();
        while ($row = $result->fetch_assoc()) {
            $newsRecords[] = $row;
        }
        $conn->close();
        // Return the retrieved records
        return $newsRecords;
    } else {
        // Handle query error (you can log or return an error message)
        $conn->close();
        return [];
    }
}
function getNews_search( $conn, $limit, $search = '' ){
    $sql = "SELECT * FROM news WHERE `recorded`=1 AND `post_status`=1 AND `title` LIKE '%$search%' ORDER BY id DESC LIMIT $limit";
    $result = $conn->query($sql);
    if ( $result ) {
        $newsRecords = array();
        while ($row = $result->fetch_assoc()) {
            $newsRecords[] = $row;
        }
        $conn->close();
        // Return the retrieved records
        return $newsRecords;
    } else {
        // Handle query error (you can log or return an error message)
        $conn->close();
        return [];
    }
}

function getNewsByKey( $conn, $key ) {
    $key = $conn->real_escape_string($key); // Sanitize the input to prevent SQL injection
    $newsData = [];
    // Prepare the SQL statement
    $stmt = $conn->prepare("SELECT * FROM news WHERE `newskey` = ?");
    if ( $stmt ){
        // Bind the parameter and execute the statement
        $stmt->bind_param("s", $key);
        $stmt->execute();
        // Get the result
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $newsData = $result->fetch_assoc(); // Fetch the row as an associative array
            $stmt->close(); // Close the prepared statement
            return $newsData;
        } else {
            $stmt->close(); // Close the prepared statement
            return $newsData; // Return null if no matching record is found
        }
    } else {
        // Handle prepare error (you can log or return an error message)
        return $newsData;
    }
}

function insertNews( $title, $newkey, $description, $images, $category, $userid, $conn ) {
    // Prepare SQL statement
    $stmt = $conn->prepare("INSERT INTO news (`title`, `newskey`, `description`, `images`, `category`, `userid`) VALUES (?, ?, ?, ?, ?, ?)");

    if (!$stmt) {
        // Handle the prepare error
        $result = array(
            'success' => false,
            'message' => "Prepare error: " . $conn->error,
            'status_code' => 500 // You can choose an appropriate status code
        );
        return $result;
    }

    // Bind parameters and execute the statement
    $stmt->bind_param("sssssi", $title, $newkey, $description, $images, $category, $userid);

    if ($stmt->execute()) {
        $result = array(
            'success' => true,
            'message' => "New record inserted successfully",
            'status_code' => 202
        );
    } else {
        $result = array(
            'success' => false,
            'message' => "Error: " . $stmt->error,
            'status_code' => 404
        );
    }

    // Close the statement
    $stmt->close();
    return $result;
}
