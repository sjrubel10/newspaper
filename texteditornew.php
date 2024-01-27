<?php

function rich_text_editor_toolox_display( $editorId )
{
    $left = 'left';
    $center = 'center';
    $right = 'right';
    $text_editor = "<div class='toolbar'>
                        <button id='bold-button' class='box_padding' onclick='toggleBold( event )'><i class='fas fa-bold'></i></button>
                        <button id='italic-button' class='box_padding' onclick='toggleItalic()'><i class='fas fa-italic'></i></button>
                        <button id='underline-button' class='box_padding' onclick='toggleUnderline()'><i class='fas fa-underline'></i></button>
                        <button id='p-button' class='box_padding' onclick='insertParagraph()'><i class='fas fa-paragraph'></i></button>
                        <button id='h1-button' class='box_padding' onclick='insertHeading(1)'><i class='fas fa-heading'></i>1</button>
                        <button id='h2-button' class='box_padding' onclick='insertHeading(2)'><i class='fas fa-heading'></i>2</button>
                        <input type='color' class='color_picker' id='text-color-picker'>
                    
                        <button id='multiply-button' class='box_padding' onclick='insertSuperscript(2)'><i class='fas fa-superscript'></i>2</button>
                        <button id='cube-button' class='box_padding' onclick='insertSuperscript(3)'><i class='fas fa-superscript'></i>3</button>
                        <button id='square-root-button' class='box_padding' onclick='insertSquareRoot()'><i class='fas fa-square-root-alt'></i></button>
                    
                        <button id='left-align-button' class='box_padding' onclick='alignText(\"$left\")'><i class='fas fa-align-left'></i></button>
                        <button id='center-align-button' class='box_padding' onclick='alignText(\"$center\")'><i class='fas fa-align-center'></i></button>
                        <button id='right-align-button' class='box_padding' onclick='alignText(\"$right\")'><i class='fas fa-align-right'></i></button>
                        
                        <button id='ordered-list-button' class='box_padding' onclick='insertOrderedList()'><i class='fas fa-list-ol'></i></button>
                        <button id='link-button' class='box_padding' onclick='insertLink()'><i class='fas fa-link'></i></button>
                        <button id='unlink-button' class='box_padding' onclick='unlink()'><i class='fas fa-unlink'></i></button>
                    
                        <button id='insert_image' onclick='insertImage()'><i class='fas fa-image'></i></button>
                        <button id='insert_table' onclick='insertTable()'><i class='fas fa-table'></i></button>
                    
                        <button id='clean-button' class='box_padding' onclick='cleanContent(\"$editorId\")'><i class='fas fa-trash'></i></button>
                    </div>";

    return $text_editor;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Text Editor with Table</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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

        .text_editor {
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
        .text_editor table {
            border-collapse: collapse;
            width: 100%;
        }
        .text_editor table, .text_editor th, .text_editor td {
            border: 1px solid #ddd;
        }
        .text_editor th, .text_editor td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>

<div class="editor-container">

    <?php
    $editorId = 'editor';
    echo rich_text_editor_toolox_display( $editorId ); ?>
    <div id="<?php echo $editorId;?>" class="text_editor" contenteditable="true"><p>Text Something</p></div>
</div>

<div class="btnholder" id="btnholder">
    <div class="submitaa">Submit</div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    function toggleBold() {
        document.execCommand('bold', false, null);
    }
    function toggleItalic() {
        document.execCommand('italic', false, null);
    }

    function toggleUnderline() {
        document.execCommand('underline', false, null);
    }

    function insertParagraph() {
        document.execCommand('formatBlock', false, 'p');
    }

    function insertHeading(level) {
        document.execCommand('formatBlock', false, 'h' + level);
    }

    function insertSuperscript(power) {
        document.execCommand('insertHTML', false, '<sup>' + power + '</sup>');
    }

    function insertSquareRoot() {
        document.execCommand('insertHTML', false, '<span>&radic;</span>');
    }

    function alignText(align) {
        document.execCommand('justify' + align.charAt(0).toUpperCase() + align.slice(1), false, null);
    }

    function insertOrderedList() {
        document.execCommand('insertOrderedList', false, null);
    }

    function insertLink() {
        var url = prompt('Enter a URL:');
        if (url) {
            document.execCommand('createLink', false, url);
        }
    }

    function unlink() {
        document.execCommand('unlink', false, null);
    }

    function insertImage() {
        var url = prompt('Enter the image URL:');
        if (url) {
            document.execCommand('insertImage', false, url);
        }
    }

    function insertTable() {
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

    $("#text-color-picker").change(function() {
        var color = $("#text-color-picker").val();
        document.execCommand("foreColor", false, color);
    });

    function cleanContent( editorId ) {
        var content = $("#"+editorId).html();
        content = content.replace(/<style>[\s\S]*?<\/style>/gi, '');
        content = $("<textarea/>").html(content).text();
        content = content.replace(/<[^>]+>/g, '');
        var result = '<p>' + content + '</p>';
        $("#"+editorId).html(result);
    }

    function get_text_from_text_editor( editorId ){
        $("#editor div").each(function () {
            $(this).replaceWith("<p>" + $(this).html() + "</p>");
        });
        let textContent = document.getElementById( editorId ).innerHTML;
        let cleanedText = textContent.replace(/<p style="([^"]*color:[^";]*)|([^"]*text-align:[^";]*)[^"]*"[^>]*>/g, '<p style="$1$2">');

        return cleanedText;
    }

    $(".submitaa").click(function() {
        let cleanedText = get_text_from_text_editor( 'editor' )
        console.log( cleanedText );
    });
</script>

</body>
</html>
