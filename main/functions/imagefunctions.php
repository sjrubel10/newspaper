<?php

function insertImage( $image_name, $image_description, $image_ext, $image_slug, $image_alt_text, $image_link ) {
    // Database connection settings
    // Prepare and bind SQL statement with placeholders
    $conn = Db_connect();
    $sql = "INSERT INTO images ( image_name, image_description, image_ext, image_slug, image_alt_text, image_link ) 
            VALUES ( ?, ?, ?, ?, ?, ? )";
    $stmt = $conn->prepare( $sql );
    $stmt->bind_param("ssssss", $image_name, $image_description, $image_ext, $image_slug, $image_alt_text, $image_link );

    // Execute the statement
    if ( $stmt->execute() ) {
        $last_id = $conn->insert_id; // Get the ID of the last inserted record
        $stmt->close();
        $conn->close();
        return $last_id; // Return the inserted pointer (ID)
    } else {
        $stmt->close();
        $conn->close();
        return "Error: " . $sql . "<br>" . $conn->error;
    }
}

function resizeAndSaveImage($file, $targetDir, $maxSize = 150, $maxWidth = 600, $maxHeight = 400) {
    // Get image details
    list($width, $height, $type, $attr) = getimagesize($file["tmp_name"]);

    // Calculate new dimensions
    $aspectRatio = $width / $height;
    $newWidth = min($width, $maxWidth);
    $newHeight = min($height, $maxHeight);

    if ($width > $newWidth) {
        $newHeight = $newWidth / $aspectRatio;
    }

    if ($height > $newHeight) {
        $newWidth = $newHeight * $aspectRatio;
    }

    // Create a new image resource with the new dimensions
    $newImage = imagecreatetruecolor($newWidth, $newHeight);

    // Load the original image based on its type
    switch ($type) {
        case IMAGETYPE_JPEG:
            $sourceImage = imagecreatefromjpeg($file["tmp_name"]);
            break;
        case IMAGETYPE_PNG:
            $sourceImage = imagecreatefrompng($file["tmp_name"]);
            break;
        case IMAGETYPE_GIF:
            $sourceImage = imagecreatefromgif($file["tmp_name"]);
            break;
        default:
            // Unsupported image type
            return false;
    }

    // Resize the image
    imagecopyresampled($newImage, $sourceImage, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

    // Save the resized image
    $filename = $targetDir . uniqid() . "_" . $file["name"];
    imagejpeg($newImage, $filename, 80); // Save as JPEG with 80% quality

    // Free up memory
    imagedestroy($sourceImage);
    imagedestroy($newImage);

    // Check file size
    if (filesize($filename) <= ($maxSize * 1024)) {
        return $filename; // Return the resized image filename if size is within limit
    } else {
        unlink($filename); // Delete the file if it exceeds the size limit
        return false;
    }
}

function resizeImage($sourceImagePath, $destinationImagePath, $squareSize) {
    // Get the dimensions of the source image
    list($sourceWidth, $sourceHeight) = getimagesize($sourceImagePath);

    // Create a new square canvas
    $destinationImage = imagecreatetruecolor($squareSize, $squareSize);

    // Determine offsets based on the aspect ratio
    if ($sourceWidth > $sourceHeight) {
        $square = $sourceHeight;
        $offsetX = ($sourceWidth - $sourceHeight) / 2;
        $offsetY = 0;
    } elseif ($sourceHeight > $sourceWidth) {
        $square = $sourceWidth;
        $offsetX = 0;
        $offsetY = ($sourceHeight - $sourceWidth) / 2;
    } else {
        // It's already a square
        $square = $sourceWidth;
        $offsetX = $offsetY = 0;
    }

    // Load the source image
    $sourceImage = imagecreatefromstring(file_get_contents($sourceImagePath));

    // Resize and center the image on the canvas
    imagecopyresampled(
        $destinationImage,
        $sourceImage,
        0,
        0,
        $offsetX,
        $offsetY,
        $squareSize,
        $squareSize,
        $square,
        $square
    );

    // Save the resized image
    imagejpeg($destinationImage, $destinationImagePath, 90);

    // Free up memory
    imagedestroy($sourceImage);
    imagedestroy($destinationImage);
}

// Example usage:
$sourceImagePath = 'source.jpg';
$destinationImagePath = 'resized.jpg';
$squareSize = 300; // Adjust the size as needed
//resizeImage($sourceImagePath, $destinationImagePath, $squareSize);

//$image_table_sql = 'CREATE TABLE `newsportal`.`images` ( `id` INT NOT NULL AUTO_INCREMENT , `image_name` VARCHAR(256) NOT NULL , `image_description` TEXT NULL DEFAULT NULL , `image_ext` VARCHAR(11) NULL DEFAULT NULL , `recorded` TINYINT(1) NOT NULL , `image_slag` INT NULL DEFAULT NULL , `image_alt_text` INT NULL DEFAULT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
/*$newTableSql = "CREATE TABLE `movie`.`news` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `title` VARCHAR(128) NOT NULL , `description` VARCHAR(512) NOT NULL , `images` VARCHAR(128) NOT NULL , `category` VARCHAR(30) NOT NULL , `recorded` TINYINT(1) NOT NULL DEFAULT '1' , `userid` INT(11) NOT NULL , `createddate` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , `is_comment` TINYINT(1) NOT NULL DEFAULT '1' , `commentid` INT(11) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;*/