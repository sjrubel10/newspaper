<?php
require_once "../init.php";
if( isset( $_SESSION['logged_in'] ) && $_SESSION['logged_in'] ){
    if( $_SESSION['logged_in_user_data']['admin']=== 1 ) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $title = isset($_POST["title"]) ? trim($_POST["title"]):"";
            $newkey = substr(md5($title), 0, 8);;
            $description = isset($_POST["description"]) ? $_POST["description"]: "";
            $category = isset($_POST["category"]) ? $_POST["category"]:"";
            $userid = 1;

            $newskey = $_POST['newskey'];
            $conn = Db_connect();
            // Handle image upload
            $timestamp = time(); // Get current timestamp
            $imageFileName = $timestamp . '_' . basename($_FILES["images"]["name"]); // Append timestamp to the image file name
            $targetDir = "../../assets/uploads/";
            $targetFile = $targetDir . $imageFileName;
            $newsid = 1;
            $result = updateNews( $title, $description, $imageFileName, $category, $newskey );
            move_uploaded_file($_FILES["images"]["tmp_name"], $targetFile);
            //    resizeAndSaveImage($_FILES["images"]["tmp_name"], $targetFile);
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


