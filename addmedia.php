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
<input type="file" id="fileInput" multiple>
<div id="imageContainer"></div>

<form action="post.php" method="post">
    <input type="hidden" id="selectedImage" name="selectedImage" accept="image/">
    <textarea name="postContent" placeholder="Write your post content here..."></textarea>
    <button type="submit">Post</button>
</form>

<div class="gallery">
    <?php
    // Example usage:
    $folderPath = "assets/uploads"; // Path to the folder containing images
    $allimages = getAllImagesInfo($folderPath);
    foreach ($allimages as $imageinfos) {
        echo '<div class="image-container">';
        echo '<img class="image" src="' . $imageinfos['path'] . '" alt="' . $imageinfos['name'] . '">';
        echo '</div>';
    }
    ?>

    <button id="openPopup">Open Popup</button>
    <div id="popupContainer">
        <div class="popup">
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
            <div class="content">
                 Your content goes here
            </div>
        </div>
    </div>

</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!--<script src="scripts.js"></script>-->
</body>
</html>

<script>
    $(document).ready(function() {
        $('#fileInput').change(function() {
            $('#imageContainer').empty();
            let files = $(this)[0].files;
            console.log(files);
            for (let i = 0; i < files.length; i++) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    $('#imageContainer').append(`<img class="imageThumbnail" src="${e.target.result}" data-src="${e.target.result}">`);
                }
                reader.readAsDataURL(files[i]);
            }
        });

        $(document).on('click', '.imageThumbnail', function() {
            $('.imageThumbnail').removeClass('selected');
            $(this).addClass('selected');
            let selectedImageSrc = $(this).data('src');
            $('#selectedImage').val(selectedImageSrc);
        });



        $('#openPopup').click(function() {
            $('#popupContainer').fadeIn();
        });

        $('#closePopup').click(function() {
            $('#popupContainer').fadeOut();
        });

    });

</script>
