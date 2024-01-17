<?php
function display_rich_text_editor_toolbar(){
    $toolbar = "<div id='editortoolbar' class='toolbar' style='display:none;'>
                <button id='bold-button' class='box_padding'><i class='fas fa-bold'></i></button>
                <button id='italic-button' class='box_padding'><i class='fas fa-italic'></i></button>
                <button id='underline-button' class='box_padding'><i class='fas fa-underline'></i></button>
                <button id='p-button' class='box_padding'><i class='fas fa-paragraph'></i></button>
                <button id='h1-button' class='box_padding'><i class='fas fa-heading'></i>1</button>
                <button id='h2-button' class='box_padding'><i class='fas fa-heading'></i>2</button>
                <input type='color' class='color_picker' id='text-color-picker'>
            
                <button id='multiply-button' class='box_padding'><i class='fas fa-superscript'></i>2</button>
                <button id='cube-button' class='box_padding'><i class='fas fa-superscript'></i>3</button>
                <button id='square-root-button' class='box_padding'><i class='fas fa-square-root-alt'></i></button>
            
                <button id='left-align-button' class='box_padding'><i class='fas fa-align-left'></i></button>
                <button id='center-align-button' class='box_padding'><i class='fas fa-align-center'></i></button>
                <button id='right-align-button' class='box_padding'><i class='fas fa-align-right'></i></button>
                <button id='ordered-list-button' class='box_padding'><i class='fas fa-list-ol'></i></button>
                <button id='link-button' class='box_padding'><i class='fas fa-link'></i></button>
                <button id='unlink-button' class='box_padding'><i class='fas fa-unlink'></i></button>
                <button id='insert_image'><i class='fas fa-image'></i></button>
                <button id='insert_table'><i class='fas fa-table'></i></button>
                <button id='clean-button' class='box_padding'><i class='fas fa-trash'></i></button>
            </div>";

    return $toolbar;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Text Editor</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
        }

        .editor-container {
            display: flex;
            flex-direction: column;
            width: 800px;
            margin: 20px auto;
        }

        .editor {
            border: 1px solid #ccc;
            min-height: 300px;
            padding: 10px;
            margin-bottom: 10px;
        }

        .toolbar {
            display: flex;
            justify-content: space-between;
            background-color: #f5f5f5;
            padding: 10px;
        }
        .toolbar button {
            background: none;
            border: none;
            cursor: pointer;
            padding: 5px;
        }
        .toolbar button:hover {
            background-color: #ddd;
        }
        .color_picker{
            width: 25px;
            height: 20px;
        }

        .editor table {
            border-collapse: collapse;
            width: 100%;
        }
        .editor table, .text_editor th, .editor td {
            border: 1px solid #ddd;
        }
        .editor th, .editor td {
            padding: 8px;
            text-align: left;
        }
        .editor-container p{
            margin: 0px;
        }

    </style>
</head>
<body>
<form >
    <div class="editor-container" id="editor-container">
        <span class="editorText" id="editorText">Description</span>
<!--        --><?php //echo display_rich_text_editor_toolbar(); ?>
        <div contenteditable="true" class="editor" id="editor">
            <p> Text Here </p>
        </div>
    </div>
    <input type="file" id="imageInput" accept="image/*">

    <div class="btnholder" id="btnholder">
        <div class="submitaa">Submit</div>
    </div>
</form>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
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

    });
</script>
</body>
</html>
