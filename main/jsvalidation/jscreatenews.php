<?php
require_once "../init.php";
if( isset( $_SESSION['logged_in'] ) && $_SESSION['logged_in'] ){

    if( $_SESSION['logged_in_user_data']['admin']=== 1 ) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $title = isset($_POST["title"]) ? ucwords ( sanitize( trim( $_POST["title"] ) ) ):"";
            $newkey = substr(md5($title), 0, 8);;
            $description = $_POST["description"] ?? "";
            $category = isset( $_POST["category"]) ? sanitize( $_POST["category"] ):"";
            $imageFileName = isset( $_POST["postImage"]) ? sanitize( $_POST["postImage"] ):"";
            $additional_images = isset( $_POST["postGalleryImage"]) ? sanitize( $_POST["postGalleryImage"] ):"";
            $userid = 1;
            $conn = Db_connect();
            // Handle image upload
            /*$timestamp = time(); // Get current timestamp
            $imageFileName = $timestamp . '_' . basename($_FILES["images"]["name"]); // Append timestamp to the image file name
            $targetDir = "../../assets/uploads/";
            $targetFile = $targetDir . $imageFileName;*/
            $result = insertNews( $title, $newkey, $description, $imageFileName, $additional_images, $category, $userid, $conn );
//            move_uploaded_file($_FILES["images"]["tmp_name"], $targetFile);
        //    resizeAndSaveImage($_FILES["images"]["tmp_name"], $targetFile);
            $result = array(
                'success' => false,
                'message'=>"Successfully Created New Post",
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

