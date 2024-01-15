function toggleBold( event  ) {
    // event.preventDefault()
    document.execCommand('bold', false, null);
}
function toggleItalic() {
    event.preventDefault()
    document.execCommand('italic', false, null);
}

function toggleUnderline() {
    event.preventDefault()
    document.execCommand('underline', false, null);
}

function insertParagraph() {
    event.preventDefault()
    document.execCommand('formatBlock', false, 'p');
}

function insertHeading(level) {
    event.preventDefault()
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