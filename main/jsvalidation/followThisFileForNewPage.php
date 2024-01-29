<?php
/**
 * Created by PhpStorm.
 * User: Sj
 * Date: 10/30/2023
 * Time: 10:57 PM
 */
require "../../main/init.php";
if( isset( $_SESSION['logged_in'] ) && $_SESSION['logged_in'] ){
    if( $_SESSION['logged_in_user_data']['admin']=== 1 ) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $result_data = [];
            // Validate email format

            $result = array(
                'data' => $result_data,
                'success'=> true,
                'message'=>"Successful",
                'status_code'=> 202
            );
        }else{
            $result = array(
                'success'=> false,
                'message'=>"Post Is Not Valid",
                'status_code'=> 400
            );
        }
    }else{
        $result = array(
            'success'=> false,
            'message'=>"You are not eligible to access this page",
            'status_code'=> 400
        );
    }
}else{
    $result = array(
        'success'=> false,
        'message'=>"You are not eligible to access this page",
        'status_code'=> 400
    );
}

echo json_encode( $result );


