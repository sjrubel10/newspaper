<?php
/**
 * Created by PhpStorm.
 * User: Sj
 * Date: 10/30/2023
 * Time: 11:01 PM
 */

function fetchSingleValue( $postKey, $conn ) {
    $query = "SELECT id FROM news WHERE newskey = ?";
    // Prepare the SQL query
    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        die("Error in the prepared statement: " . $conn->error);
    }
    $stmt->bind_param("s", $postKey);
    // Execute the statement
    $result = $stmt->execute();
    // Bind the result
    $stmt->bind_result($result);
    // Fetch the result
     $stmt->fetch();
    // Close the statement and connection
    $stmt->close();
    $conn->close();

    return $result;
}


function updateRecordedStatus( $postId, $action ) {
    $conn = Db_connect();
    $result = false;
    if( $action === "delete" ){
        $sql = " UPDATE `news` SET `post_status` = 0, `recorded` = 0 WHERE `id` = ?";
    }else if( $action === "private" ){
        $sql = " UPDATE `news` SET `post_status` = -1, `recorded` = 1 WHERE `id` = ?";
    }else if( $action === "unpublish" ){
        $sql = " UPDATE `news` SET `post_status` = 0, `recorded` = 1 WHERE `id` = ?";
    }else if( $action === "publish" ){
        $sql = " UPDATE `news` SET `post_status` = 1, `recorded` = 1 WHERE `id` = ?";
    }else{
        return $result;
    }

    // Create a prepared statement
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error in the prepared statement: " . $conn->error);
    }
    // Bind the parameter
    $stmt->bind_param("i", $postId); // "i" represents an integer
    // Execute the statement
    $result = $stmt->execute();
    // Close the statement and connection
    $stmt->close();
    $conn->close();
    return $result;
}

?>
