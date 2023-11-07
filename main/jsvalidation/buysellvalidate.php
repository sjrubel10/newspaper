<?php
require_once "../init.php";
if( isset( $_SESSION['logged_in'] ) && $_SESSION['logged_in'] ){
        if ( $_SERVER["REQUEST_METHOD"] == "POST") {
            if( isset( $_POST )){
                $result = insertData( $_POST );
                $conn = Db_connect();
            }else{
                $result = array(
                    'success' => false,
                    'message'=>"Post is not set",
                    'status_code'=>303
                );
            }

        } else {
            $result = array(
                'success' => false,
                'message'=>"Post is not valid",
                'status_code'=>303
            );
        }
}else{
    $result = array(
        'success'=> false,
        'message'=>"You are not eligible to access this Request",
        'status_code'=> 400
    );
}
echo json_encode( $result );
?>

