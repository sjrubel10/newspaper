$(document).ready(function() {

    $(document).on('submit', '#imageForm', function(e) {
        e.preventDefault();
        let postId = $(".imagepost").attr('id');
        if( postId === 'mainImage_post' ){
            var imageHolder = 'postImage';
        }else{
            imageHolder = 'postGalleryImage';
        }
        var formData = new FormData($(this)[0]);
        $.ajax({
            url: '../main/jsvalidation/jsuploadmediafile.php',
            type: 'POST',
            data: formData,
            async: false,
            cache: false,
            contentType: false,
            processData: false,
            success: function(response){
                var responseData = JSON.parse(response);
                if( postId === 'mainImage_post' ) {
                    $("#postImage").val( responseData['image_name'] );
                }else{
                    var data = $("#postGalleryImage").val();
                    if( data === '' ){
                        var imgs_name = responseData['image_name'];
                    }else{
                        imgs_name = responseData['image_name']+', '+data;
                    }
                    let imgs = remove_duplicate( imgs_name );

                    $("#postGalleryImage").val( imgs );
                }

            }
        });
        return false;
    });

    $(document).on('change', '#fileInput', function( e ) {
        // $('#fileInput').change(function() {
        $('#imageContainer').empty();
        let files = $(this)[0].files;
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

    function display_media_images( imageinfos, imgClass ){
        let images ='<div class="'+imgClass+'" id="' + imageinfos['name'] + '">\
                                <img class="image" src="' +imageinfos['path']+ '" alt="' + imageinfos['name'] + '">\
                            </div>';
        $("#mediaImageContainer").append( images );
    }

    function display_and_Add_media_image( post_id ){
        let mediaImagePopUp = '<div id="popupContainer">\
                                    <div class="popup">\
                                        <div class="uploadMediaImage">\
                                            <div id="imageContainer"></div>\
                                            <form id="imageForm" enctype="multipart/form-data">\
                                                <input type="file" id="fileInput" name="fileInput" accept="image/*">\
                                                <input type="hidden" id="selectedImage" name="selectedImage">\
                                                <input type="text" id="image_alt_text" name="image_alt_text" placeholder="Write your Image Slug Here...">\
                                                <textarea id="image_desc" name="image_desc" placeholder="Write your post content here..."></textarea>\
                                                <button id="'+post_id+'" class="imagepost" type="submit">Post</button>\
                                            </form>\
                                        </div>\
                                        <div class="mediaImageContainer">\
                                            <button id="closePopup">Close</button>\
                                            <div class="topContainer">\
                                                <select id="selectOption">\
                                                    <option value="option1">Option 1</option>\
                                                    <option value="option2">Option 2</option>\
                                                    <option value="option3">Option 3</option>\
                                                </select>\
                                                <input type="text" id="searchField" placeholder="Search">\
                                                    <button id="submitButton">Submit</button>\
                                            </div>\
                                            <div class="gallery" id="mediaImageContainer"></div>\
                                    </div>\
                                </div>';

        return mediaImagePopUp;
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
        return [];
    }

    function remove_duplicate( str ){
        let arr = str.split(',');
        for (var i = 0; i < arr.length; i++) {
            arr[i] = arr[i].trim();
        }
        let uniqueNames = [];
        $.each(arr, function(i, el){
            if($.inArray(el, uniqueNames) === -1) uniqueNames.push(el);
        });
        let result = uniqueNames.join(', ');
        return result;
    }

    var allimages = [];
    $(document).on('click', '.image-container', function() {
        let clickedId = $(this).attr('id');
        const result = findObjectWithName( allimages, clickedId );
        $("#postImage").val( result['name']+'.'+result['extension'] );
    });

    $(document).on('click', '.image-container-gallery', function() {
        let clickedId = $(this).attr('id');
        const result = findObjectWithName( allimages, clickedId );
        var data = $("#postGalleryImage").val();
        if( data === '' ){
            var imgs_name = result['name']+'.'+result['extension'];
        }else{
            imgs_name = result['name']+'.'+result['extension']+', '+data;
        }
        let imgs = remove_duplicate( imgs_name );

        $("#postGalleryImage").val( imgs );
    });

    $(document).on('click', '.openPopup', function( e ) {
        e.preventDefault();
        $("#popupContainer").empty();
        $("#popupContainer").remove();



        let clickedID = $(this).attr('id');
        if( clickedID === 'openPopup' ){
            var imgClass = "image-container";
            var main_image = 'mainImage_post';
        }else{
             imgClass = "image-container-gallery";
            main_image = 'additionalImage_post';
        }

        var formData = [];
        if (allimages.length === 0) {
            $.ajax({
                url: '../main/jsvalidation/jsgetallimagesfromfolder.php',
                type: 'POST',
                data: formData,
                async: false,
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    var dataArray = JSON.parse(response);
                    allimages = dataArray.data; // Show response from PHP
                    let mediaImagePopUp = display_and_Add_media_image( main_image );
                    $('body').append(mediaImagePopUp);
                    $('#popupContainer').fadeIn();
                    for (var i = 0; i < allimages.length; i++) {
                        display_media_images( allimages[i], imgClass );
                    }
                }
            });
        }else{
            let mediaImagePopUp = display_and_Add_media_image( main_image );
            $('body').append(mediaImagePopUp);
            $('#popupContainer').fadeIn();
            for (var i = 0; i < allimages.length; i++) {
                display_media_images( allimages[i], imgClass );
            }
        }
        // return false;

    });

    $(document).on('click', '#closePopup', function( e ) {
        e.preventDefault();
        // $('#closePopup').click(function() {
        $('#popupContainer').fadeOut();
        $('#imageContainer').empty();
        $('#mediaImageContainer').empty();
    });

});