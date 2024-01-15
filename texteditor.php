<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Text Editor</title>
    <style>
        .editor-container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .toolbar {
            margin-bottom: 10px;
        }

        .editor {
            border: 1px solid #ccc;
            border-radius: 5px;
            min-height: 200px;
            padding: 10px;
        }
        .box_padding{
            /*padding: 5px 10px;*/
            margin: 5px 5px 0px 0px;
        }
        .color_picker{
            width: 25px;
            height: 20px;
        }
    </style>
</head>
<body>
<div class="editor-container">
    <div class="toolbar">
        <button id="bold-button" class="box_padding"><i class="fas fa-bold"></i></button>
        <button id="italic-button" class="box_padding"><i class="fas fa-italic"></i></button>
        <button id="underline-button" class="box_padding"><i class="fas fa-underline"></i></button>
        <button id="p-button" class="box_padding"><i class="fas fa-paragraph"></i></button>
        <button id="h1-button" class="box_padding"><i class="fas fa-heading"></i>1</button>
        <button id="h2-button" class="box_padding"><i class="fas fa-heading"></i>2</button>
        <input type="color" class="color_picker" id="text-color-picker">

        <button id="multiply-button" class="box_padding"><i class="fas fa-superscript"></i>2</button>
        <button id="cube-button" class="box_padding"><i class="fas fa-superscript"></i>3</button>
        <button id="square-root-button" class="box_padding"><i class="fas fa-square-root-alt"></i></button>

        <button id="left-align-button" class="box_padding"><i class="fas fa-align-left"></i></button>
        <button id="center-align-button" class="box_padding"><i class="fas fa-align-center"></i></button>
        <button id="right-align-button" class="box_padding"><i class="fas fa-align-right"></i></button>
        <button id="ordered-list-button" class="box_padding"><i class="fas fa-list-ol"></i></button>

        <button id="link-button" class="box_padding"><i class="fas fa-link"></i></button>
        <button id="unlink-button" class="box_padding"><i class="fas fa-unlink"></i></button>

        <button id="insert_image"><i class="fas fa-image"></i></button>
        <button id="insert_table"><i class="fas fa-table"></i></button>

        <button id="clean-button" class="box_padding"><i class="fas fa-trash"></i></button>


    </div>


    <div contenteditable="true" class="editor" id="editor">
        <p aria-placeholder="This is a sample text."></p>
    </div>
</div>

<div class="btnholder" id="btnholder">
    <div class="submitaa">Submit</div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {

        $("#editor").on("input", function() {
            /*var editorContent = $(this).html();
            var sanitizedContent = editorContent.replace(/<p>/g, "").replace(/<\/p>/g, "");
            $(this).html("<p>" + sanitizedContent + "</p>");*/
        });

        $("#clean-button").click(function() {
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

        $("#bold-button").click(function() {
            document.execCommand("bold", false, null);
        });

        $("#italic-button").click(function() {
            document.execCommand("italic", false, null);
        });

        $("#underline-button").click(function() {
            document.execCommand("underline", false, null);
        });

        $("#p-button").click(function() {
            document.execCommand("formatBlock", false, "<p>");
        });
        $("#h1-button").click(function() {
            document.execCommand("formatBlock", false, "<h1>");
        });

        $("#h2-button").click(function() {
            document.execCommand("formatBlock", false, "<h2>");
        });

        $("#text-color-picker").change(function() {
            var color = $("#text-color-picker").val();
            document.execCommand("foreColor", false, color);
        });

        $("#font-size-select").change(function() {
            var fontSize = $("#font-size-select").val();
            document.execCommand("fontSize", false, fontSize);
        });

        $("#square-root-button").click(function() {
            document.execCommand("insertHTML", false, "√");
        });

        $("#multiply-button").click(function() {
            // document.execCommand("insertHTML", false, "×");
            document.execCommand("insertHTML", false, "<sup>2</sup>");
        });

        $("#cube-button").click(function() {
            // document.execCommand("insertHTML", false, "×");
            document.execCommand("insertHTML", false, "<sup>3</sup>");
        });

        $("#left-align-button").click(function() {
            document.execCommand("justifyLeft", false, null);
        });

        $("#center-align-button").click(function() {
            document.execCommand("justifyCenter", false, null);
        });

        $("#right-align-button").click(function() {
            document.execCommand("justifyRight", false, null);
        });

        $("#ordered-list-button").click(function() {
            document.execCommand("insertOrderedList", false, null);
        });

        $("#link-button").click(function() {
            var url = prompt("Enter a URL:");
            if (url) {
                document.execCommand("createLink", false, url);
            }
        });

        $("#unlink-button").click(function() {
            document.execCommand("unlink", false, null);
        });

        $(".submitaa").click(function() {
            $("#editor div").each(function () {
                $(this).replaceWith("<p>" + $(this).html() + "</p>");
            });
            var textContent = document.getElementById("editor").innerHTML;
            // Use regular expressions to remove all styles except font color insert_image
            // var cleanedText = textContent.replace(/style="[^"]*"/g, '');
            var cleanedText = textContent.replace(/<p style="([^"]*color:[^";]*)|([^"]*text-align:[^";]*)[^"]*"[^>]*>/g, '<p style="$1$2">');

            console.log( cleanedText );
        });

        $("#insert_image").click(function() {
            insertImage();
        });
        $("#insert_table").click(function() {
            insertTable();
        });

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

    });
</script>
</body>
</html>
