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

    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
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
    <div class="editor-container">
        <span class="editorText">Description</span>
        <?php echo display_rich_text_editor_toolbar(); ?>
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
                // $("#editor").prepend( display_rich_text_editor_toolbar() );
                $("#editortoolbar").fadeIn(1000);
            }
            isClicked++;

        });

        function display_rich_text_editor_toolbar() {
            let toolbar = "<div class='toolbar'>\
                            <button id='bold-button' class='box_padding'><i class='fas fa-bold'></i></button>\
                            <button id='italic-button' class='box_padding'><i class='fas fa-italic'></i></button>\
                            <button id='underline-button' class='box_padding'><i class='fas fa-underline'></i></button>\
                            <button id='p-button' class='box_padding'><i class='fas fa-paragraph'></i></button>\
                            <button id='h1-button' class='box_padding'><i class='fas fa-heading'></i>1</button>\
                            <button id='h2-button' class='box_padding'><i class='fas fa-heading'></i>2</button>\
                            <input type='color' class='color_picker' id='text-color-picker'>\
                            <button id='multiply-button' class='box_padding'><i class='fas fa-superscript'></i>2</button>\
                            <button id='cube-button' class='box_padding'><i class='fas fa-superscript'></i>3</button>\
                            <button id='square-root-button' class='box_padding'><i class='fas fa-square-root-alt'></i></button>\
                            <button id='left-align-button' class='box_padding'><i class='fas fa-align-left'></i></button>\
                            <button id='center-align-button' class='box_padding'><i class='fas fa-align-center'></i></button>\
                            <button id='right-align-button' class='box_padding'><i class='fas fa-align-right'></i></button>\
                            <button id='ordered-list-button' class='box_padding'><i class='fas fa-list-ol'></i></button>\
                            <button id='link-button' class='box_padding'><i class='fas fa-link'></i></button>\
                            <button id='unlink-button' class='box_padding'><i class='fas fa-unlink'></i></button>\
                            <button id='insert_image'><i class='fas fa-image'></i></button>\
                            <button id='insert_table'><i class='fas fa-table'></i></button>\
                            <button id='clean-button' class='box_padding'><i class='fas fa-trash'></i></button>\
                        </div>";

            return toolbar;
        }

        $("#editor").on("input", function() {
            /*var editorContent = $(this).html();
            var sanitizedContent = editorContent.replace(/<p>/g, "").replace(/<\/p>/g, "");
            $(this).html("<p>" + sanitizedContent + "</p>");*/
        });

        $("#clean-button").click(function( event ) {
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

        function make_edit( event, action, arg1, arg2 ){
            event.preventDefault();
            document.execCommand( action, arg1, arg2);
        }

        $("#bold-button").click(function( event ) {
            make_edit( event, "bold", false, null );
        });

        $("#italic-button").click(function( event ) {
            make_edit( event, "italic", false, null );
        });

        $("#underline-button").click(function( event ) {
            make_edit( event, "underline", false, null );
        });

        $("#p-button").click(function( event ) {
            make_edit( event, "formatBlock", false, "<p>" );
        });
        $("#h1-button").click(function( event ) {
            make_edit( event, "formatBlock", false, "<h1>" );
        });

        $("#h2-button").click(function( event ) {
            make_edit( event, "formatBlock", false, "<h2>" );
        });

        $("#text-color-picker").change(function( event ) {
            var color = $("#text-color-picker").val();
            make_edit( event, "foreColor", false, color);
        });

        $("#font-size-select").change(function( event ) {
            var fontSize = $("#font-size-select").val();
            make_edit( event, "fontSize", false, fontSize);
        });

        $("#square-root-button").click(function( event ) {
            make_edit( event, "insertHTML", false, "√" );
        });

        $("#multiply-button").click(function( event ) {
            make_edit( event, "insertHTML", false, "<sup>2</sup>" );
        });

        $("#cube-button").click(function( event ) {
            make_edit( event, "insertHTML", false, "<sup>3</sup>" );
        });

        $("#left-align-button").click(function( event ) {
            make_edit( event, "justifyLeft", false, null );
        });

        $("#center-align-button").click(function( event ) {
            make_edit( event, "justifyCenter", false, null );
        });

        $("#right-align-button").click(function( event ) {
            make_edit( event, "justifyRight", false, null );
        });

        $("#ordered-list-button").click(function( event ) {
            make_edit( event, "insertOrderedList", false, null );
        });

        $("#link-button").click(function( event ) {
            var url = prompt("Enter a URL:");
            if (url) {
                make_edit( event, "createLink", false, url );
            }
        });

        $("#unlink-button").click(function( event ) {
            make_edit( event, "unlink", false, null );
        });
        $("#insert_image").click(function( event ) {
            insertImage( event );
        });
        $("#insert_table").click(function( event ) {
            insertTable( event );
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
