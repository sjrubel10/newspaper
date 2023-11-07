<?php
function insertData( $insert_data ){
    $sendMethod =  $insert_data['send_method'];
    $receiveMethod = $insert_data['receive_method'];
    $sendAmount = $insert_data['send_amount'];
    $receiveAmount = $insert_data['receive_amount'];
    $bKashNumber = $insert_data['bKash_number'];
    $bKashTransactionID = $insert_data['bKash_tRX_ID'];
    $skrillEmail = $insert_data['skrill_email'];
    $contactNumber = $insert_data['contact_no'];
    $userID = 1;
    $recorded = 1;
    $conn = Db_connect();

// Prepare the SQL statement
    $sql = $conn->prepare("INSERT INTO `buysell` (`send_method`, `receive_method`, `send_amount`, `receive_amount`, `bKash_number`, `bKash_tRX_ID`, `skrill_email`, `contact_no`, `user_id`, `recorded`) 
                       VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

// Bind parameters
    $sql->bind_param("ssiiiisiii", $sendMethod, $receiveMethod, $sendAmount, $receiveAmount, $bKashNumber, $bKashTransactionID, $skrillEmail, $contactNumber, $userID, $recorded);

// Execute the statement
    if ($sql->execute()) {
        $result = array(
            'success' => true,
            'message'=>"New record created successfully",
            'status_code'=>202
        );
    } else {
        $result = array(
            'success' => false,
            'message'=>"Error: " . $sql->error,
            'status_code'=>303
        );
    }
// Close the statement and connection
    $sql->close();
    $conn->close();
    return $result;
}
