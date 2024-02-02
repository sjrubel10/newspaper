<?php
require_once "../init.php";
if( isset( $_SESSION['logged_in'] ) && $_SESSION['logged_in'] ){

    if( $_SESSION['logged_in_user_data']['admin']=== 1 ) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $title = isset($_POST["title"]) ? ucwords ( sanitize( trim( $_POST["title"] ) ) ):"";

            var_test_die( $_POST );
            $newkey = substr(md5($title), 0, 8);;
            $description = $_POST["description"] ?? "";
            $category = isset( $_POST["category"]) ? sanitize( $_POST["category"] ):"";
            $imageFileName = isset( $_POST['metadata']["postImage"]) ? sanitize( $_POST['metadata']["postImage"] ):"";
            $additional_images = isset( $_POST['metadata']["postGalleryImage"]) ? sanitize( $_POST['metadata']["postGalleryImage"] ):"";

            $metadata =
            $userid = 1;
            $conn = Db_connect();
            $result = insertNews( $title, $newkey, $description, $imageFileName, $additional_images, $category, $userid, $conn );
            if( $result['success'] && isset( $result['last_insert_id'] ) ){
                $post_id = $result['last_insert_id'];
                $post_meta = isset( $_POST['metadata'] ) ? sanitize_array( $_POST['metadata'], 'sanitize' ) : [];
                $tableName =
                $result = insert_post_meta( $post_meta, $result['last_insert_id'] );
            }
            $result = array(
                'success' => false,
                'message'=>"Successfulxly Created New Post",
                'status_code'=>202
            );
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

