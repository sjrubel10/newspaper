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
    $conn = $conn = Db_connect();
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

function make_addition_image_like( $string ){
    $imageLinks = [];
    if( $string !== null ){
        $imagesArray = explode(', ', $string);

        foreach ($imagesArray as $imageName) {
            $imagePath = 'assets/uploads/' . $imageName;
            $imageLinks[] = $imagePath;
        }
    }

    return $imageLinks;

}

function fetchNewsData( $db, $key ) {
    $newsData = array(); // Initialize $newsData as an array
    $id = $newskey = $title = $description = $images = $additional_images = $category = $recorded = $post_status = $userid = $createddate = $is_comment = $commentid = null;
    try {
        $query = "SELECT `id`, `newskey`, `title`, `description`, `images`, `additional_images`, `category`, `recorded`, `post_status`, `userid`, `createddate`, `is_comment`, `commentid` FROM `news` WHERE `recorded` = 1 AND `newskey` = ?";
        $st = $db->prepare($query);

        if ($st) {
            $st->bind_param("s", $key);
            $st->execute();
            $st->bind_result($id, $newskey, $title, $description, $images, $additional_images, $category, $recorded, $post_status, $userid, $createddate, $is_comment, $commentid);

            while ($st->fetch()) {
                $newsData = array(
                    'id' => $id,
                    'newskey' => $newskey,
                    'title' => $title,
                    'description' => $description,
                    'images' => $images,
                    'additional_images' => make_addition_image_like( $additional_images ),
                    'category' => $category,
                    'recorded' => $recorded,
                    'post_status' => $post_status,
                    'userid' => $userid,
                    'createddate' => $createddate,
                    'is_comment' => $is_comment,
                    'commentid' => $commentid
                );
            }

            $st->close();
        } else {
            throw new Exception("Error: Unable to prepare statement.");
        }
    } catch (Exception $e) {
        // Handle the exception
        error_log('Error fetching news data: ' . $e->getMessage());
        return $newsData; // or handle the error in a different way
    }

    return $newsData;
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

function updateNews( $title, $description, $images, $category, $newskey ) {
    $conn = Db_connect();
    // Prepare SQL statement for update
    $stmt = $conn->prepare("UPDATE news SET `title`=?, `description`=?, `images`=?, `category`=? WHERE `newskey`=?");
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
    $stmt->bind_param("sssss", $title, $description, $images, $category, $newskey );

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

