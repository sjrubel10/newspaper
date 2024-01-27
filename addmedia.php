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


    <?php
    // Example usage:
    $folderPath = "assets/uploads"; // Path to the folder containing images
    $allimages = getAllImagesInfo($folderPath);
    ?>

    <button id="openPopup">Open Popup</button>
    <div id="popupContainer">
        <div class="popup">
            <div class="uploadMediaImage">
                <input type="file" id="fileInput" multiple>
                <div id="imageContainer"></div>

                <form action="post.php" method="post">
                    <input type="hidden" id="selectedImage" name="selectedImage" accept="image/">
                    <textarea name="postContent" placeholder="Write your post content here..."></textarea>
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
    </div>

<!--</div>-->

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

        function display_media_images( imageinfos ){
            let images ='<div class="image-container" id="' + imageinfos['name'] + '">\
                            <img class="image" src="' +imageinfos['path']+ '" alt="' + imageinfos['name'] + '">\
                        </div>';
            $("#mediaImageContainer").append( images );
        }
        function findObjectWithName(array, name) {
            // Iterate through each element in the array
            for ( let element of array ) {
                // If the element is an object and has a 'Name' property matching the given name, return it
                if (typeof element === 'object' && element.hasOwnProperty('name') && element.name === name ) {
                    return element;
                }
                // If the element is an array, recursively call this function to search within the array
                else if ( Array.isArray( element ) ) {
                    const found = findObjectWithName( element, name );
                    if ( found ) return found;
                }
            }
            // If no matching object is found, return null
            return [];
        }

        $(document).on('click', '.image-container', function() {
            let allimages = <?php echo json_encode( $allimages );?>;
            let clickedId = $(this).attr('id');
            // alert(clickedId);
// Function to find the object with the specified name
            const result = findObjectWithName( allimages, clickedId );
// Output the result
            console.log(result);
//

        });

        $('#openPopup').click(function() {
            var allimages = <?php echo json_encode( $allimages );?>;
            $('#popupContainer').fadeIn();
            for( var i=0 ; i<allimages.length; i++){
                display_media_images( allimages[i] );
            }
        });

        $('#closePopup').click(function() {
            $('#popupContainer').fadeOut();
            $('#imageContainer').empty();
        });

    });

</script>
