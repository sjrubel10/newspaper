<?php
require_once "../init.php";
if( isset( $_FILES['fileInput'] ) && isset( $_POST ) ) {
    $targetDir = "../../assets/uploads/";
    $targetFile = $targetDir . basename($_FILES["fileInput"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));

//    var_test_die( $_POST );

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["fileInput"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($targetFile)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["fileInput"]["size"] > 5000000) { // Adjust size limit as needed
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
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
            // File uploaded successfully, perform database insertion if needed
            // Database insertion code goes here
            echo "The file ". basename( $_FILES["fileInput"]["name"]). " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
} else {
    echo "No file uploaded.";
}
?>
