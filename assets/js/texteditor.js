$(document).ready(function() {

    let isClicked = 0
    $('#editor').on('focus', function() {
        if( isClicked === 0 ){
            $("#editorText").after( display_rich_text_editor_toolbar() );
            $("#editortoolbar").fadeIn(1000);
        }
        isClicked++;
    });

    function display_rich_text_editor_toolbar() {
        let toolbar = "<div class='toolbar'>\
                            <button id='bold-button' class='box_padding btnClickedClass'><i class='fas fa-bold'></i></button>\
                            <button id='italic-button' class='box_padding btnClickedClass'><i class='fas fa-italic'></i></button>\
                            <button id='underline-button' class='box_padding btnClickedClass'><i class='fas fa-underline'></i></button>\
                            <button id='p-button' class='box_padding btnClickedClass'><i class='fas fa-paragraph'></i></button>\
                            <button id='h1-button' class='box_padding btnClickedClass'><i class='fas fa-heading'></i>1</button>\
                            <button id='h2-button' class='box_padding btnClickedClass'><i class='fas fa-heading'></i>2</button>\
                            <input type='color' class='color_picker btnClickedClass' id='text-color-picker'>\
                            <button id='multiply-button' class='box_padding btnClickedClass'><i class='fas fa-superscript'></i>2</button>\
                            <button id='cube-button' class='box_padding btnClickedClass'><i class='fas fa-superscript'></i>3</button>\
                            <button id='square-root-button' class='box_padding btnClickedClass'><i class='fas fa-square-root-alt'></i></button>\
                            <button id='left-align-button' class='box_padding btnClickedClass'><i class='fas fa-align-left'></i></button>\
                            <button id='center-align-button' class='box_padding btnClickedClass'><i class='fas fa-align-center'></i></button>\
                            <button id='right-align-button' class='box_padding btnClickedClass'><i class='fas fa-align-right'></i></button>\
                            <button id='ordered-list-button' class='box_padding btnClickedClass'><i class='fas fa-list-ol'></i></button>\
                            <button id='link-button' class='box_padding btnClickedClass'><i class='fas fa-link'></i></button>\
                            <button id='unlink-button' class='box_padding btnClickedClass'><i class='fas fa-unlink'></i></button>\
                            <button id='insert_image'><i class='fas fa-image'></i></button>\
                            <button id='insert_table'><i class='fas fa-table'></i></button>\
                            <button id='clean-button' class='box_padding btnClickedClass'><i class='fas fa-trash'></i></button>\
                        </div>";

        return toolbar;
    }

    $("#editor").on("input", function() {
        /*var editorContent = $(this).html();
        var sanitizedContent = editorContent.replace(/<p>/g, "").replace(/<\/p>/g, "");
        $(this).html("<p>" + sanitizedContent + "</p>");*/
    });

    function make_edit( event, action, arg1, arg2 ){
        event.preventDefault();
        document.execCommand( action, arg1, arg2);
    }

    $('body').on('click', '.btnClickedClassqq', function( event ) {
        event.preventDefault();
        /*let clickedId = $(this).attr('id');
        alert( clickedId );*/

        var buttonId = $(this).attr("id");

        if (buttonId === "bold-button") {
            make_edit( event, "bold", false, null );
        } else if (buttonId === "italic-button") {
            make_edit( event, "italic", false, null );
        } else if (buttonId === "underline-button") {
            make_edit( event, "underline", false, null );
        } else if (buttonId === "p-button") {
            make_edit( event, "formatBlock", false, "<p>" );
        } else if (buttonId === "h1-button") {
            make_edit( event, "formatBlock", false, "<h1>" );
        } else if (buttonId === "h2-button") {
            make_edit( event, "formatBlock", false, "<h2>" );
        } else if (buttonId === "text-color-picker") {
            var color = $("#text-color-picker").val();
            make_edit( event, "foreColor", false, color);
        } else if (buttonId === "multiply-button") {
            make_edit( event, "insertHTML", false, "<sup>2</sup>" );
        } else if (buttonId === "cube-button") {
            make_edit( event, "insertHTML", false, "<sup>3</sup>" );
        } else if (buttonId === "square-root-button") {
            make_edit( event, "insertHTML", false, "√" );
        } else if (buttonId === "left-align-button") {
            make_edit( event, "justifyLeft", false, null );
        } else if (buttonId === "center-align-button") {
            make_edit( event, "justifyCenter", false, null );
        } else if (buttonId === "right-align-button") {
            make_edit( event, "justifyRight", false, null );
        } else if (buttonId === "ordered-list-button") {
            make_edit( event, "insertOrderedList", false, null );
        } else if (buttonId === "link-button") {
            var url = prompt("Enter a URL:");
            if (url) {
                make_edit( event, "createLink", false, url );
            }
        } else if (buttonId === "unlink-button") {
            make_edit( event, "unlink", false, null );
        } else if (buttonId === "insert_image") {
            insertImage( event );
        } else if (buttonId === "insert_table") {
            insertTable( event );
        } else if (buttonId === "clean-button") {
            var content = $("#editor").html();
            // Remove CSS styles (within <style> tags)
            content = content.replace(/<style>[\s\S]*?<\/style>/gi, '');
            // Remove HTML entities
            content = $("<textarea/>").html(content).text();
            // Remove all HTML tags
            content = content.replace(/<[^>]+>/g, '');
            // Wrap the clean text in a <p> tag
            var result = '<p>' + content + '</p';
            // Replace the content of the div with the cleaned HTML
            $("#editor").html(result);
        }

    });

    $('body').on('click', '#bold-button', function( event ) {
        make_edit( event, "bold", false, null );
    });

    $('body').on('click', '#italic-button', function( event ) {
        make_edit( event, "italic", false, null );
    });

    $('body').on('click', '#underline-button', function( event ) {
        make_edit( event, "underline", false, null );
    });

    $('body').on('click', '#p-button', function( event ) {
        make_edit( event, "formatBlock", false, "<p>" );
    });

    $('body').on('click', '#h1-button', function( event ) {
        make_edit( event, "formatBlock", false, "<h1>" );
    });

    $('body').on('click', '#h2-button', function( event ) {
        make_edit( event, "formatBlock", false, "<h2>" );
    });

    $('body').on('change', '#text-color-picker', function( event ) {
        var color = $("#text-color-picker").val();
        make_edit( event, "foreColor", false, color);
    });

    $('body').on('change', '#font-size-select', function( event ) {
        var fontSize = $("#font-size-select").val();
        make_edit( event, "fontSize", false, fontSize);
    });

    $('body').on('click', '#square-root-button', function( event ) {
        make_edit( event, "insertHTML", false, "√" );
    });

    $('body').on('click', '#multiply-button', function( event ) {
        make_edit( event, "insertHTML", false, "<sup>2</sup>" );
    });

    $('body').on('click', '#cube-button', function( event ) {
        make_edit( event, "insertHTML", false, "<sup>3</sup>" );
    });

    $('body').on('click', '#left-align-button', function( event ) {
        make_edit( event, "justifyLeft", false, null );
    });

    $('body').on('click', '#center-align-button', function( event ) {
        make_edit( event, "justifyCenter", false, null );
    });

    $('body').on('click', '#right-align-button', function( event ) {
        make_edit( event, "justifyRight", false, null );
    });

    $('body').on('click', '#ordered-list-button', function( event ) {
        make_edit( event, "insertOrderedList", false, null );
    });

    $('body').on('click', '#link-button', function( event ) {
        event.preventDefault();
        var url = prompt("Enter a URL:");
        if (url) {
            make_edit( event, "createLink", false, url );
        }
    });

    $('body').on('click', '#unlink-button', function( event ) {
        make_edit( event, "unlink", false, null );
    });

    $('body').on('click', '#insert_image', function( event ) {
        insertImage( event );
    });

    $('body').on('click', '#insert_table', function( event ) {
        insertTable( event );
    });

    $('body').on('click', '#clean-button', function( event ) {
        event.preventDefault();
        var content = $("#editor").html();
        // Remove CSS styles (within <style> tags)
        content = content.replace(/<style>[\s\S]*?<\/style>/gi, '');
        // Remove HTML entities
        content = $("<textarea/>").html(content).text();
        // Remove all HTML tags
        content = content.replace(/<[^>]+>/g, '');
        // Wrap the clean text in a <p> tag
        var result = '<p>' + content + '</p';
        // Replace the content of the div with the cleaned HTML
        $("#editor").html(result);
    });
    function insertImage( event ) {
        event.preventDefault();
        var url = prompt('Enter the image URL:');
        if (url) {
            document.execCommand('insertImage', false, url);
        }
    }
    function insertTable( event ) {
        event.preventDefault();
        var rows = prompt('Enter number of rows:');
        var cols = prompt('Enter number of columns:');

        if (rows && cols) {
            var tableHTML = '<table>';
            for (var i = 0; i < rows; i++) {
                tableHTML += '<tr>';
                for (var j = 0; j < cols; j++) {
                    tableHTML += '<td contenteditable="true"></td>';
                }
                tableHTML += '</tr>';
            }
            tableHTML += '</table>';

            document.execCommand('insertHTML', false, tableHTML);
        }
    }



    $(".submitaa").click(function( event ) {
        event.preventDefault();
        $("#editor div").each(function () {
            $(this).replaceWith("<p>" + $(this).html() + "</p>");
        });
        let textContent = document.getElementById("editor").innerHTML;
        // Use regular expressions to remove all styles except font color insert_image
        // var cleanedText = textContent.replace(/style="[^"]*"/g, '');
        let cleanedText = textContent.replace(/<p style="([^"]*color:[^";]*)|([^"]*text-align:[^";]*)[^"]*"[^>]*>/g, '<p style="$1$2">');

        let file = $('#imageInput')[0].files[0];

        console.log('Image data:', cleanedText);

    });

    function get_text_from_rich_text_editor( editorId ) {
        $("#"+editorId+ "div").each(function () {
            $(this).replaceWith("<p>" + $(this).html() + "</p>");
        });
        let textContent = document.getElementById( editorId).innerHTML;
        var updatedContent = textContent.replace(/<p><br><\/p>/g, '');


        return updatedContent.replace(/<p style="([^"]*color:[^";]*)|([^"]*text-align:[^";]*)[^"]*"[^>]*>/g, '');

    }

    $("#news-form").submit(function(event) {
        event.preventDefault();
        // var formData = new FormData($(this)[0]);
        var formData = new FormData(this);
        let editorId = 'editor';
        let texteditorText = get_text_from_rich_text_editor( editorId ).trim();

        formData.append('description', texteditorText);

        $.ajax({
            type: "POST",
            url: 'main/jsvalidation/jscreatenews.php',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                var result= JSON.parse(response);
                console.log( result ); // Show response from PHP (success or error message)
                if(result['success']){
                    window.location.href = "../index.php";
                }
                // You can redirect to another page or clear the form if needed
            }
        });
    });

    function checkInputCharacterLimit( maxLength, editorId, errorSmgShowId ){
        let enteredText = $("#"+editorId).val();
        if (enteredText.length > maxLength) {
            $( '#'+editorId ).val(enteredText.substring(0, maxLength));
            $('#'+errorSmgShowId).text('Maximum length is ' + maxLength + ' characters.');
        } else {
            $('#'+errorSmgShowId).text('');
        }
    }

    $('#title').on('input', function () {
        checkInputCharacterLimit( 60, 'title', 'titleError' )
    });


});