<?php
/**
 * Created by PhpStorm.
 * User: Sj
 * Date: 10/30/2023
 * Time: 10:57 PM
 */
require "../../main/init.php";
if( isset( $_SESSION['logged_in'] ) && $_SESSION['logged_in'] ){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
//            var_test_die( $_POST );
            $user_id = 1;
            // Validate email format
            $result = 0;
            if (isset($_POST) && !empty($_POST)) {
                $deleteOrAdd = sanitize($_POST['deleteOrAdd']);

                if ( is_numeric( $user_id ) ) {
//                    $update =updateUserToAdmi( $user_id, $admin, $deleteOrAdd );
                    $update = 1;
                    if ( $update ) {
                        $message = 'Successfully ';

                        $result = array(
                            'success' => true,
                            'message' => $message,
                            'status_code' => 200
                        );
                    } else {
                        $result = array(
                            'success' => false,
                            'message' => "Error in the prepared statement or Database Connection",
                            'status_code' => 400
                        );
                    }

                } else {
                    $result = array(
                        'success' => false,
                        'message' => "User is not Exist.",
                        'status_code' => 400
                    );
                }

            } else {
                $result = array(
                    'success' => false,
                    'message' => "Invalid request.",
                    'status_code' => 400
                );
            }

            echo json_encode($result);
        }
}else{
    $result = array(
        'success'=> false,
        'message'=>"You are not eligible to comment",
        'status_code'=> 400
    );
}


