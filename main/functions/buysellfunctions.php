<?php
function insertBuyData( $insert_data, $user_id ){
    $conn = Db_connect();
    $sendMethod = isset($insert_data['send_method']) ? sanitize( $insert_data['send_method'] ) : "" ;
    $receiveMethod = isset($insert_data['receive_method']) ? sanitize( $insert_data['receive_method'] ) : "";
    $sendAmount = isset( $insert_data['send_amount'] ) ? sanitize( $insert_data['send_amount'] ) : NULL;
    $receiveAmount = isset($insert_data['receive_amount']) ? sanitize( $insert_data['receive_amount'] ) : NULL;
    $bKashNumber = isset($insert_data['bKash_number']) ? sanitize( $insert_data['bKash_number'] ) : NULL;
    $bKashTransactionID = isset($insert_data['bKash_tRX_ID']) ? sanitize( $insert_data['bKash_tRX_ID'] ) : NULL;
    $skrillEmail = isset($insert_data['skrill_email']) ? sanitize( $insert_data['skrill_email'] ) : "";
    $contactNumber = isset( $insert_data['contact_no']) ? sanitize( $insert_data['contact_no'] ) : NULL;
    $userID = $user_id;
    $recorded = 1;

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
