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

function buildFolderStructure($path) {
    $structure = array();
    $contents = scandir($path);


    foreach ($contents as $item) {
        if ($item != '.' && $item != '..') {
            $itemPath = $path . DIRECTORY_SEPARATOR . $item;

            if ( is_dir($itemPath ) ) {
                $structure[$item] = buildFolderStructure($itemPath);
            }
        }
    }

    return $structure;
}

function findParentIndex($structure, $target, &$path = array()) {
    foreach ($structure as $index => $substructure) {
        if (is_array($substructure)) {
            if (array_key_exists($target, $substructure)) {
                $path[] = $index;
                return true;
            } elseif (findParentIndex($substructure, $target, $path)) {
                $path[] = $index;
                return true;
            }
        }
    }
    return false;
}
// Example usage:
/*$rootPath = $_SERVER['DOCUMENT_ROOT'] . "/newspaper/assets";
$folderStructure = buildFolderStructure($rootPath);
$path = array();
$target = 'slideImages';
if (findParentIndex($folderStructure, $target, $path)) {
    $result = implode('/', array_reverse($path))."/";
} else {
    $result = false;
}*/

function add_media_display(){
    $media_display = '<div id="popupContainer">
        <div class="popup">
            <div class="uploadMediaImage">
                <div id="imageContainer"></div>

                <form id="imageForm" enctype="multipart/form-data">
                    <input type="file" id="fileInput" name="fileInput" accept="image/*">
                    <input type="hidden" id="selectedImage" name="selectedImage">
                    <input type="text" id="image_alt_text" name="image_alt_text" placeholder="Write your Image Slug Here...">
                    <textarea id="image_desc" name="image_desc" placeholder="Write your post content here..."></textarea>
                    <button type="submit">Post</button>
                </form>
            </div>
            <div class="mediaImageContainer">
                <button id="closePopup">Close</button>
                <div class="topContainer">
                    <select id="selectOption">
                        <option value="option1">Option 1</option>
                        <option value="option2">Option 2</option>
                        <option value="option3">Option 3</option>
                    </select>
                    <input type="text" id="searchField" placeholder="Search">
                    <button id="submitButton">Submit</button>
                </div>
                <div class="gallery" id="mediaImageContainer"></div>
            </div>

        </div>
    </div>';

    return $media_display;
}
