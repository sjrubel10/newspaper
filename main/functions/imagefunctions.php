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

/*$newTableSql = "CREATE TABLE `movie`.`news` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `title` VARCHAR(128) NOT NULL , `description` VARCHAR(512) NOT NULL , `images` VARCHAR(128) NOT NULL , `category` VARCHAR(30) NOT NULL , `recorded` TINYINT(1) NOT NULL DEFAULT '1' , `userid` INT(11) NOT NULL , `createddate` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , `is_comment` TINYINT(1) NOT NULL DEFAULT '1' , `commentid` INT(11) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
";*/