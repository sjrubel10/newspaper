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
            // Validate email format
            $result = 0;
            if (isset($_POST) && !empty($_POST)) {
                $action = sanitize($_POST['action']);
                $postKey = sanitize($_POST['postKey']);
                $conn = Db_connect();

                $post_id = fetchSingleValue($postKey, $conn);
                if (is_numeric($post_id)) {
                    $update = updateRecordedStatus($post_id, $action);
                    if ($update) {
                        if ($action === "delete") {
                            $message = 'Post Is Successfully Deleted';
                        } else if ($action === "private") {
                            $message = 'This Post Goes To Private Status';
                        } else if ($action === "unpublish") {
                            $message = 'Successfully Unpublished This Post';
                        } else if ($action === "publish") {
                            $message = 'Successfully Published This Post';
                        } else {
                            $message = 'Something Went Wrong!';
                        }
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
                        'message' => "Post is not Exist.",
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


