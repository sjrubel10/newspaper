<?php
require "main/init.php";
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
