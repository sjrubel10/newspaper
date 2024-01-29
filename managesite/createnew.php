<?php
require "../main/init.php";
 if( isset( $_SESSION['logged_in'] ) && isset( $_SESSION['logged_in_user_data'] ) && $_SESSION['logged_in'] === true && $_SESSION['logged_in_user_data']['admin'] ===1 &&  $_SESSION['logged_in_user_data']['recorded'] ===1){
$categorys = news_category();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News Form</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/header.css">
    <link rel="stylesheet" href="../assets/css/common.css">
    <link rel="stylesheet" href="../assets/css/createnew.css">
    <link rel="stylesheet" href="../assets/css/texteditor.css">

    <link rel="stylesheet" href="../assets/css/mediafile.css">


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../assets/js/common.js"></script>
    <script src="../assets/js/texteditor.js"></script>
    <script src="../assets/js/createnew.js"></script>
</head>
<body>
<?php include_once "../views/header.php"?>
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
                <div contenteditable="true" class="editor" id="editor">
                    <p>Write Something Here </p>
                </div>
            </div>
            <label for="images">Main Image:</label>
            <button class="openPopup" id="openPopup">Add Or Select Image</button>
            <input type="text" id="postImage" name="postImage" required><br>

            <label for="images">gallery Image:</label>
            <button class="openPopup" id="openPopupForGallery">Add Or Select Gallery Image </button>
            <input type="text" id="postGalleryImage" name="postGalleryImage" required><br>

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

<script src="../assets/js/addmedia.js"></script>
</body>
</html>
<?php } else {
     header('Location:index.php');
 }?>

