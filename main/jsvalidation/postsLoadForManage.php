<?php
/**
 * Created by PhpStorm.
 * User: Sj
 * Date: 11/2/2023
 * Time: 12:26 AM
 */
require "../../main/init.php";
if( isset( $_SESSION['logged_in'] ) && $_SESSION['logged_in'] ){
    if( $_SESSION['logged_in_user_data']['admin']=== 1 ) {
        if ( $_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST) && !empty($_POST)) {
                $action = sanitize($_POST['action']);
                $result = array(
                    'success' => true,
                    'data' => $_POST,
                    'message' => "Successfully Fetch Data.",
                    'status_code' => 400
                );

            } else {
                $result = array(
                    'success' => false,
                    'data' => [],
                    'message' => "Invalid request.",
                    'status_code' => 400
                );
            }
        }else{
            $result = array(
                'success'=> false,
                'data' => [],
                'message'=>"You are not eligible to access this page",
                'status_code'=> 400
            );
        }
    }else{
        $result = array(
            'success'=> false,
            'data' => [],
            'message'=>"You are not eligible to access this page",
            'status_code'=> 400
        );
    }
}else{
    $result = array(
        'success'=> false,
        'data' => [],
        'message'=>"You are not eligible to access this page",
        'status_code'=> 400
    );
}

echo json_encode( $result );


