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



//$image_table_sql = 'CREATE TABLE `newsportal`.`images` ( `id` INT NOT NULL AUTO_INCREMENT , `image_name` VARCHAR(256) NOT NULL , `image_description` TEXT NULL DEFAULT NULL , `image_ext` VARCHAR(11) NULL DEFAULT NULL , `recorded` TINYINT(1) NOT NULL , `image_slag` INT NULL DEFAULT NULL , `image_alt_text` INT NULL DEFAULT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
/*$newTableSql = "CREATE TABLE `movie`.`news` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `title` VARCHAR(128) NOT NULL , `description` VARCHAR(512) NOT NULL , `images` VARCHAR(128) NOT NULL , `category` VARCHAR(30) NOT NULL , `recorded` TINYINT(1) NOT NULL DEFAULT '1' , `userid` INT(11) NOT NULL , `createddate` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , `is_comment` TINYINT(1) NOT NULL DEFAULT '1' , `commentid` INT(11) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;*/

function resizeImage1($source_image, $destination_folder, $imageFileType, $max_size_kb , $max_width , $max_height ) {
    // Load the source image
    $source = imagecreatefromjpeg($source_image);

    // Get the original dimensions of the source image
    $source_width = imagesx($source);
    $source_height = imagesy($source);

    // Calculate aspect ratio
    $source_ratio = $source_width / $source_height;

    // Calculate new dimensions while maintaining aspect ratio
    if ($source_width > $max_width || $source_height > $max_height) {
        if ($max_width / $max_height > $source_ratio) {
            $new_width = $max_height * $source_ratio;
            $new_height = $max_height;
        } else {
            $new_width = $max_width;
            $new_height = $max_width / $source_ratio;
        }
    } else {
        $new_width = $source_width;
        $new_height = $source_height;
    }

    // Create a new true color image with the desired dimensions
    $resized_image = imagecreatetruecolor($new_width, $new_height);
    print_r( $resized_image );

    // Resize the source image to the new dimensions
    imagecopyresampled($resized_image, $source, 0, 0, 0, 0, $new_width, $new_height, $source_width, $source_height);

    // Compress the image to meet maximum file size requirement
    $quality = 90; // Initial quality value
    $output_image_path = tempnam(sys_get_temp_dir(), 'resized_image_') . '.' . $imageFileType; // Temporary file path

    // Iteratively compress the image until its size is within the maximum allowed size
    while (true) {
        ob_start(); // Start output buffering
        imagejpeg($resized_image, null, $quality); // Output image to buffer
        $output_buffer = ob_get_clean(); // Get the contents of the output buffer
        $output_image_size = strlen($output_buffer); // Get size of buffered image

        if ($output_image_size <= $max_size_kb * 1024 || $quality <= 10) {
            break;
        }

        $quality -= 5; // Reduce quality
    }

    // Save the resized image to the destination folder
    $output_image_path = $destination_folder . time() . '.' . $imageFileType;
    file_put_contents($output_image_path, $output_buffer);

    // Free up memory
    imagedestroy($source);
    imagedestroy($resized_image);

    return $output_image_path;
}
function resizeImage11($source_image, $destination_folder, $imageFileType, $max_size_kb, $max_width, $max_height ) {
    // Load the source image
    $source = imagecreatefromjpeg($source_image);

    // Get the original dimensions of the source image
    $source_width = imagesx($source);
    $source_height = imagesy($source);

    // Calculate aspect ratio
    $source_ratio = $source_width / $source_height;

    // Determine dimensions for resizing while maintaining aspect ratio
    if ($source_ratio > 1) {
        // Rectangle is wider than tall, set width to max and calculate height
        $new_width = $max_width;
        $new_height = $max_width / $source_ratio;
    } else {
        // Rectangle is taller than wide, set height to max and calculate width
        $new_height = $max_height;
        $new_width = $max_height * $source_ratio;
    }

    // Create a new true color image with the desired dimensions
    $resized_image = imagecreatetruecolor($new_width, $new_height);

    // Resize the source image to the new dimensions
    imagecopyresampled($resized_image, $source, 0, 0, 0, 0, $new_width, $new_height, $source_width, $source_height);

    // Compress the image to meet maximum file size requirement
    $quality = 90; // Initial quality value
    $output_image_path = tempnam(sys_get_temp_dir(), 'resized_image_') . '.' . $imageFileType; // Temporary file path

    // Iteratively compress the image until its size is within the maximum allowed size
    while (true) {
        ob_start(); // Start output buffering
        imagejpeg($resized_image, null, $quality); // Output image to buffer
        $output_buffer = ob_get_clean(); // Get the contents of the output buffer
        $output_image_size = strlen($output_buffer); // Get size of buffered image

        if ($output_image_size <= $max_size_kb * 1024 || $quality <= 10) {
            break;
        }

        $quality -= 5; // Reduce quality
    }

    // Save the resized image to the destination folder
    $output_image_path = $destination_folder . time() . '.' . $imageFileType;
    file_put_contents($output_image_path, $output_buffer);

    // Free up memory
    imagedestroy($source);
    imagedestroy($resized_image);

    return $output_image_path;
}
function resizeImage($source_image, $destination_folder, $imageFileType, $max_size_kb, $max_width, $max_height) {
    // Load the source image
    $source = imagecreatefromjpeg($source_image);

    // Get the original dimensions of the source image
    $source_width = imagesx($source);
    $source_height = imagesy($source);

    // Check if the image needs to be upscaled
    $upscale = false;
    if ($source_width < $max_width || $source_height < $max_height) {
        $upscale = true;
    }

    // Determine dimensions for resizing while maintaining aspect ratio
    if ($upscale) {
        // Upscale the image to fit the desired dimensions
        $new_width = $max_width;
        $new_height = $max_height;
    } else {
        // Calculate aspect ratio
        $source_ratio = $source_width / $source_height;

        // Determine dimensions for resizing while maintaining aspect ratio
        if ($source_ratio > 1) {
            // Rectangle is wider than tall, set width to max and calculate height
            $new_width = $max_width;
            $new_height = $max_width / $source_ratio;
        } else {
            // Rectangle is taller than wide, set height to max and calculate width
            $new_height = $max_height;
            $new_width = $max_height * $source_ratio;
        }
    }

    // Create a new true color image with the desired dimensions
    $resized_image = imagecreatetruecolor($new_width, $new_height);

    // Resize the source image to the new dimensions
    imagecopyresampled($resized_image, $source, 0, 0, 0, 0, $new_width, $new_height, $source_width, $source_height);

    // Compress the image to meet maximum file size requirement
    $quality = 90; // Initial quality value
    $output_image_path = tempnam(sys_get_temp_dir(), 'resized_image_') . '.' . $imageFileType; // Temporary file path

    // Iteratively compress the image until its size is within the maximum allowed size
    while (true) {
        ob_start(); // Start output buffering
        imagejpeg($resized_image, null, $quality); // Output image to buffer
        $output_buffer = ob_get_clean(); // Get the contents of the output buffer
        $output_image_size = strlen($output_buffer); // Get size of buffered image

        if ($output_image_size <= $max_size_kb * 1024 || $quality <= 10) {
            break;
        }

        $quality -= 5; // Reduce quality
    }

    // Save the resized image to the destination folder
    $output_image_path = $destination_folder . time() . '.' . $imageFileType;
    file_put_contents($output_image_path, $output_buffer);

    // Free up memory
    imagedestroy($source);
    imagedestroy($resized_image);

    return $output_image_path;
}

