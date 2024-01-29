<?php
function findImage( $imageName, $folderPath ) {
    // Check if the folder exists
    if (!is_dir($folderPath)) {
        return "Folder doesn't exist!";
    }
    // Get all files in the folder
    $files = scandir($folderPath);
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') {
            continue; // Skip current and parent directory entries
        }
        // Check if the file is an image file
        if (is_file($folderPath . DIRECTORY_SEPARATOR . $file) && getimagesize($folderPath . DIRECTORY_SEPARATOR . $file)) {
            // Check if the filename matches without extension
            $fileNameWithoutExtension = pathinfo($file, PATHINFO_FILENAME);
            if (strtolower($fileNameWithoutExtension) === strtolower($imageName)) {
                return $folderPath . DIRECTORY_SEPARATOR . $file; // Return the path to the image
            }
        }
    }

    return "Image not found!";
}


function directories_from_directory( $directory ){
    $contents = scandir($directory);
    // Filter out only directories
    $folders = array_filter($contents, function($item) use ($directory) {
        // Exclude "." and ".." directories
        if ($item === '.' || $item === '..') {
            return false;
        }
        // Check if the item is a directory
        return is_dir($directory . DIRECTORY_SEPARATOR . $item);
    });

    return $folders;
}

function getAllImagesInfo($folderPath) {

    // Check if the folder exists
    if (!is_dir($folderPath)) {
        return "Folder doesn't exist!";
    }
    // Get all files in the folder
    $files = scandir($folderPath);

    $imagesInfo = array();

    // Search for the images
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') {
            continue; // Skip current and parent directory entries
        }
//        var_test( $file );
        $filePath = $folderPath . DIRECTORY_SEPARATOR . $file;
        // Check if the file is an image file
        if (is_file($filePath) && getimagesize($filePath)) {
            $image_name = pathinfo($file, PATHINFO_FILENAME);
            $image_extension = pathinfo($file, PATHINFO_EXTENSION);
            $imageInfo = array(
                'path' => "http://".domainName."/newspaper/assets/uploads/".$image_name.'.'.$image_extension,
                'name' => $image_name,
                'extension' => $image_extension,
                'size' => filesize($filePath) // Get size of the image file in bytes
            );
            $imagesInfo[] = $imageInfo;
        }
    }

    return $imagesInfo;
}
