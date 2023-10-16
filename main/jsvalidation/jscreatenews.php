<?php
require_once "../init.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = isset($_POST["title"]) ? trim($_POST["title"]):"";
    $newkey = substr(md5($title), 0, 8);;
    $description = isset($_POST["description"]) ? $_POST["description"]: "";
    $category = isset($_POST["category"]) ? $_POST["category"]:"";
    $userid = 1;
    $conn = Db_connect();
    // Handle image upload
    $timestamp = time(); // Get current timestamp
    $imageFileName = $timestamp . '_' . basename($_FILES["images"]["name"]); // Append timestamp to the image file name
    $targetDir = "../../assets/uploads/";
    $targetFile = $targetDir . $imageFileName;
    $result = insertNews( $title, $newkey, $description, $imageFileName, $category, $userid, $conn );
    move_uploaded_file($_FILES["images"]["tmp_name"], $targetFile);
//    resizeAndSaveImage($_FILES["images"]["tmp_name"], $targetFile);
} else {
    $result = array(
            'success' => false,
            'message'=>"Post is not valid",
            'status_code'=>303
    );
}

echo json_encode( $result );
?>

