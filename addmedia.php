<?php
require "main/init.php";

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
$rootPath = $_SERVER['DOCUMENT_ROOT'] . "/newspaper/assets";
$folderStructure = buildFolderStructure($rootPath);

$path = array();
$target = 'slideImages';


if (findParentIndex($folderStructure, $target, $path)) {
    $result = implode('/', array_reverse($path))."/";
} else {
    $result = false;
}


var_test_die( $result );

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Upload</title>
    <link rel="stylesheet" href="assets/css/mediafile.css">
</head>
<body>
    <button id="openPopup">Open Popup</button>
    <!--<div id="popupContainer">
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
    </div>-->

<!--</div>-->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="assets/js/addmedia.js"></script>
</body>
</html>
