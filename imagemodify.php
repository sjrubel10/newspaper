<?php
require "main/init.php"; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Image Upload and Resize</title>
</head>
<body>
<h2>Upload and Resize Image</h2>
<form action="" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit">
</form>

<?php
$resized_image_path = '';
// Check if form is submitted
if(isset($_POST["submit"])) {
    // Check if file is selected
    if(isset($_FILES["fileToUpload"])) {
        $target_dir1 = "assets/uploads/images/images300/";
        $target_dir = "assets/uploads/images/rawimages/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
//        var_test_die( $target_file );
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["fileToUpload"]["size"] > 500000) {
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
        } else {
            // If everything is ok, try to upload file and resize
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                // Include the function to resize the uploaded image

                // Define maximum dimensions and size for resized image
                $max_size_kb = 100;
                $max_width = 300;
                $max_height = 300;

                // Call the resizeImage function to resize and save the uploaded image
                $resized_image_path = resizeImage($target_file, $target_dir1, $imageFileType, $max_size_kb, $max_width, $max_height);
                echo "<br>The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded and resized.<br>";
                echo "Resized image saved: " . $resized_image_path;
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }
}
?>
<img src="<?php echo $resized_image_path;?>">
</body>
</html>
