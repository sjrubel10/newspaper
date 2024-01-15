
<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        body {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }

        .draggable {
            width: 100px;
            height: 50px;
            background-color: #3498db;
            color: #fff;
            text-align: center;
            line-height: 50px;
            margin: 10px;
            cursor: move;
        }

        .droppable {
            width: 150px;
            height: 100px;
            background-color: #2ecc71;
            color: #fff;
            text-align: center;
            line-height: 100px;
            margin: 10px;
        }

    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="script.js"></script>
    <title>Drag and Drop Elements</title>
</head>
<body>

<div class="draggable" draggable="true" id="element1">Element 1</div>
<div class="draggable" draggable="true" id="element2">Element 2</div>
<div class="draggable" draggable="true" id="element3">Element 3</div>
<div class="draggable" draggable="true" id="element4">Element 4</div>
<div class="draggable" draggable="true" id="element5">Element 5</div>

<div class="droppable" id="dropzone">Drop Zone</div>

</body>
</html>


<script>

    $(document).ready(function() {
        $(".draggable").on("dragstart", function(event) {
            // alert('Ok')
            event.originalEvent.dataTransfer.setData("text/plain", event.target.id);
        });

        $(".droppable").on("dragover", function(event) {
            event.preventDefault();
        });

        $(".droppable").on("drop", function(event) {
            event.preventDefault();
            var data = event.originalEvent.dataTransfer.getData("text/plain");
            console.log( data );
            var draggedElement = $("#" + data);
            $(this).append(draggedElement);
        });
    });

</script>
