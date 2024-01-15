<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iconic Text Editor</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        #editor {
            border: 1px solid #ccc;
            min-height: 200px;
            padding: 10px;
        }

        button {
            margin: 5px;
        }
    </style>
</head>
<body>

<div id="editor" contenteditable="true">
    <!-- Initial content goes here -->
</div>

<button onclick="toggleBold()"><i class="fas fa-bold"></i></button>
<button onclick="toggleUnderline()"><i class="fas fa-underline"></i></button>
<button onclick="changeColor()"><i class="fas fa-paint-brush"></i></button>
<button onclick="changeFontSize()"><i class="fas fa-text-height"></i></button>
<button onclick="formatElement('p')"><i class="fas fa-paragraph"></i></button>
<button onclick="formatElement('h1')"><i class="fas fa-heading"></i></button>
<button onclick="formatElement('h2')"><i class="fas fa-heading"></i></button>
<button onclick="alignText('left')"><i class="fas fa-align-left"></i></button>
<button onclick="alignText('center')"><i class="fas fa-align-center"></i></button>
<button onclick="alignText('right')"><i class="fas fa-align-right"></i></button>
<button onclick="insertLink()"><i class="fas fa-link"></i></button>
<button onclick="unlinkText()"><i class="fas fa-unlink"></i></button>
<button onclick="insertOrderedList()"><i class="fas fa-list-ol"></i></button>
<button onclick="insertSquare()"><i class="fa fa-superscript" aria-hidden="true"></i></button>

<button onclick="insertSquareRoot()"><i class="fas fa-square-root-alt"></i></button>
<button onclick="insertPower3()"><i class="fas fa-superscript"></i></button>
<button onclick="cleanAll()"><i class="fas fa-trash"></i></button>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    function toggleBold() {
        document.execCommand('bold', false, null);
    }

    function toggleUnderline() {
        document.execCommand('underline', false, null);
    }

    function changeColor() {
        var color = prompt('Enter font color:');
        if (color) {
            document.execCommand('foreColor', false, color);
        }
    }

    function changeFontSize() {
        var fontSize = prompt('Enter font size (e.g., 12px):');
        if (fontSize) {
            document.execCommand('fontSize', false, fontSize);
        }
    }

    function formatElement(element) {
        document.execCommand('formatBlock', false, element);
    }

    function alignText(align) {
        document.execCommand('justify' + align.charAt(0).toUpperCase() + align.slice(1), false, null);
    }

    function insertLink() {
        var url = prompt('Enter a URL:');
        if (url) {
            document.execCommand('createLink', false, url);
        }
    }

    function unlinkText() {
        document.execCommand('unlink', false, null);
    }

    function insertOrderedList() {
        document.execCommand('insertOrderedList', false, null);
    }

    function insertSquare() {
        $('#editor').append("■");
    }

    function insertSquareRoot() {
        $('#editor').append("√");
    }

    function insertPower3() {
        $('#editor').append("<sup>3</sup>");
    }

    function cleanAll() {
        $('#editor').html('');
    }
</script>

</body>
</html>
