<?php
require "../../main/init.php";

// Validate and insert data into the database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate email format

    if( isset( $_POST ) && !empty( $_POST ) ){
        $result = user_registration( $_POST );
    }else{
        $result = 0;
    }

    echo json_encode( $result );
}
?>
