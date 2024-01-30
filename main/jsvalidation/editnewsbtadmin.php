<?php
require_once "../init.php";
if( isset( $_SESSION['logged_in'] ) && $_SESSION['logged_in'] ){
    if( $_SESSION['logged_in_user_data']['admin']=== 1 ) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $title = isset( $_POST["title"] ) ? trim( $_POST["title"] ) : "";
            $newkey = substr( md5( $title ), 0, 8 );;
            $description = isset( $_POST["description"] ) ? $_POST["description"]: "";
            $category = isset( $_POST["category"] ) ? sanitize( $_POST["category"] ): "";
            $imageFileName = isset( $_POST["postImage"] ) ? sanitize( $_POST["postImage"] ) : Null;
            $additional_images = isset( $_POST["postGalleryImage"] ) ? sanitize( $_POST["postGalleryImage"] ) : Null;
            $userid = 1;

            $newskey = $_POST['newskey'];
            $conn = Db_connect();
            $newsid = 1;
            $result = updateNews( $title, $description, $imageFileName, $additional_images, $category, $newskey );
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
}else{
    $result = array(
        'success'=> false,
        'message'=>"You are not eligible to access this Request",
        'status_code'=> 400
    );
}
echo json_encode( $result );
?>


