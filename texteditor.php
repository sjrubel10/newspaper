<?php
require "main/init.php";
$categorys = news_category();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="assets/css/createnew.css">
        <link rel="stylesheet" href="assets/css/texteditor.css">


        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="assets/js/texteditor.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <title>Create News</title>
    </head>
    <body>
        <h1 class="createNewsTitle">Create News</h1>
        <div class="formHolder">
            <div class="form-container">
                <form id="news-form" enctype="multipart/form-data">
                    <label for="title">Title:</label>
                    <input type="text" id="title" name="title" required>
                    <span id="titleError" style="color: red;"></span>
                    <br>

                    <div class="editor-container" id="editor-container">
                        <span class="editorText" id="editorText">Description</span>
                <!--        --><?php //echo display_rich_text_editor_toolbar(); ?>
                        <div contenteditable="true" class="editor" id="editor">
                            <p>Write Something Here </p>
                        </div>
                    </div>
                    <label for="images">Image:</label>
                    <input type="file" id="images" name="images" accept="image/*" required><br>

                    <label for="category">Category:</label>
                    <select id="category" name="category" required>
                        <?php
                        foreach ($categorys as $category) {
                            $key = str_replace(' ', '', strtolower($category));
                            echo '<option value="' . $key . '">' . $category . '</option>';
                        }
                        ?>
                    </select>
                    <button type="submit">Submit</button>
                </form>
                <div id="error-message"></div>
            </div>
        </div>
    </body>
</html>
