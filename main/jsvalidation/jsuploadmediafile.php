<?php
require_once "../init.php";
if( isset( $_FILES['fileInput'] ) && isset( $_POST ) ) {
    $targetDir = $_SERVER['DOCUMENT_ROOT']."/newspaper/assets/uploads/";
    $targetFile = $targetDir . basename($_FILES["fileInput"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));
    $error_result = array(
        'success' => false,
        'message' => "No file uploaded.",
        'status_code' => 400
    );
//    var_test_die( $_FILES['fileInput']['tmp_name'] );
    if( file_exists($targetFile) ){
        $error_result = array(
            'success' => false,
            'message' => "Please Select Any Image Than Submit",
            'status_code' => 400
        );
        $uploadOk = 0;
        $check = false;
    }else{
        $check = getimagesize($_FILES["fileInput"]["tmp_name"]);
    }
    if($check !== false) {
        $uploadOk = 1;
    } else {
        $error_result = array(
            'success' => false,
            'message' => "File is not an image.",
            'status_code' => 400
        );
        $uploadOk = 0;
    }

    if (file_exists($targetFile)) {
        $error_result = array(
            'success' => false,
            'message' => "Sorry, file already exists.",
            'status_code' => 400
        );
        $uploadOk = 0;
    }

    if ($_FILES["fileInput"]["size"] > 5000000) { // Adjust size limit as needed
        $error_result = array(
            'success' => false,
            'message' => "Sorry, your file is too large.",
            'status_code' => 400
        );
        $uploadOk = 0;
    }
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" && $imageFileType != "webp") {
        $error_result = array(
            'success' => false,
            'message' => "Sorry, only JPG, JPEG, PNG & GIF files are allowed.",
            'status_code' => 400
        );
        $uploadOk = 0;
    }
    if ($uploadOk == 0) {
        $result = $error_result;
    } else {
        $image_name_info = explode(".", sanitize( trim( $_FILES['fileInput']['name'] ) ) );
        $image_name= $image_name_info[0];
        $size= sanitize( $_FILES['fileInput']['size']);
        $image_description= sanitize( $_POST['image_desc']);
        $image_ext= $image_name_info[1];
        $image_slug=  str_replace(' ', '-', $image_name_info[0]);
        $image_alt_text= sanitize( $_POST['image_alt_text']);
        $image_link= sanitize( $_POST['image_desc']);
        $inserted_id = insertImage( $image_name, $image_description, $image_ext, $image_slug, $image_alt_text, $image_link );
        if (move_uploaded_file($_FILES["fileInput"]["tmp_name"], $targetFile)) {
            $result = array(
                'success' => true,
                'message' => "The file ". basename( $_FILES["fileInput"]["name"]). " has been uploaded.",
                'status_code' => 200
            );
        } else {
            $result = array(
                'success' => false,
                'message' => "Sorry, there was an error uploading your file.",
                'status_code' => 400
            );
        }
    }
} else {
    $result = array(
        'success' => false,
        'message' => "No file uploaded.",
        'status_code' => 400
    );
}

echo json_encode( $result );
?>
