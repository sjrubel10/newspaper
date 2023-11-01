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
                $limit = sanitize($_POST['limit']);
                $loadedIds = sanitize($_POST['loadedIds']);
                $type_of_post = get_type_of_post( $action );
                $new_data = getNews_for_control( $limit, $type_of_post );
                $result = array(
                    'success' => true,
                    'data' => $new_data,
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


