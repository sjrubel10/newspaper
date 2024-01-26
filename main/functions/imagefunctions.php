<?php
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
resizeImage($sourceImagePath, $destinationImagePath, $squareSize);


/*$newTableSql = "CREATE TABLE `movie`.`news` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `title` VARCHAR(128) NOT NULL , `description` VARCHAR(512) NOT NULL , `images` VARCHAR(128) NOT NULL , `category` VARCHAR(30) NOT NULL , `recorded` TINYINT(1) NOT NULL DEFAULT '1' , `userid` INT(11) NOT NULL , `createddate` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , `is_comment` TINYINT(1) NOT NULL DEFAULT '1' , `commentid` INT(11) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
";*/