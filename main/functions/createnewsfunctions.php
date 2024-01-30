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
function getNews_for_control( $limit, $action ){
    $conn = Db_connect();
    $post_status = $action['post_status'];
    if( $action['recorded'] === 1 ){
        $sql = "SELECT * FROM news WHERE `recorded`=1 AND `post_status`= $post_status ORDER BY id DESC LIMIT $limit";
    }else{
        $sql = "SELECT * FROM news WHERE `recorded`= 0 ORDER BY id DESC LIMIT $limit";
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

function insertNews( $title, $newkey, $description, $images, $additional_images, $category, $userid, $conn ) {
    // Prepare SQL statement
    $stmt = $conn->prepare("INSERT INTO news (`title`, `newskey`, `description`, `images`, additional_images, `category`, `userid`) VALUES (?, ?, ?, ?, ?, ?, ?)");

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
    $stmt->bind_param("ssssssi", $title, $newkey, $description, $images, $additional_images, $category, $userid);

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

function updateNews( $title, $description, $images, $additional_images, $category, $newskey ) {
    $conn = Db_connect();
    // Prepare SQL statement for update
    $stmt = $conn->prepare("UPDATE news SET `title`=?, `description`=?, `images`=?, `additional_images`=?, `category`=? WHERE `newskey`=?");
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
    $stmt->bind_param("ssssss", $title, $description, $images, $additional_images, $category, $newskey );

    if ($stmt->execute()) {
        $result = array(
            'success' => true,
            'message' => "Record updated successfully",
            'status_code' => 200 // Use 200 OK status code for successful update
        );
    } else {
        $result = array(
            'success' => false,
            'message' => "Error: " . $stmt->error,
            'status_code' => 500 // Use 500 Internal Server Error for database error
        );
    }

    // Close the statement
    $stmt->close();
    return $result;
}

