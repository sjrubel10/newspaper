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
            <input type="text" id="postImage" name="metadata[postImage]" required><br>

            <label for="images">gallery Image:</label>
            <button class="openPopup" id="openPopupForGallery">Add Or Select Gallery Image </button>
            <input type="text" id="postGalleryImage" name="metadata[postGalleryImage]" required><br>

            <label for="category">Category:</label>
            <select id="category" name="category" required>
                <?php
                foreach ($categorys as $category) {
                    $key = str_replace(' ', '', strtolower($category));
                    echo '<option value="' . $key . '">' . $category . '</option>';
                }
                ?>
            </select>

            <label for="sku">SKU:</label><br>
            <input type="text" id="sku" name="metadata[sku]"><br><br>

            <label for="regular_price">Regular Price:</label><br>
            <input type="number" id="regular_price" name="metadata[regular_price]" step="0.01" min="0"><br><br>

            <label for="sale_price">Sale Price:</label><br>
            <input type="number" id="sale_price" name="metadata[sale_price]" step="0.01" min="0"><br><br>

            <label>Stock Management:</label><br>
            <input type="radio" id="in_stock" name="metadata[stock_status]" value="in_stock" checked>
            <label for="in_stock">In stock</label><br>
            <input type="radio" id="out_of_stock" name="metadata[stock_status]" value="out_of_stock">
            <label for="out_of_stock">Out of stock</label><br>
            <input type="radio" id="on_backorder" name="metadata[stock_status]" value="on_backorder">
            <label for="on_backorder">On backorder</label><br><br>

            <label for="quantity">Quantity:</label><br>
            <input type="number" id="quantity" name="metadata[quantity]" value="1" min="1"><br><br>

            <label for="stock">Stock:</label><br>
            <input type="number" id="stock" name="metadata[stock]" value="0" min="0"><br><br>

            <label for="backorders">Allow Backorders:</label><br>
            <input type="radio" id="no_backorders" name="metadata[backorders]" value="do_not_allow" checked>
            <label for="no_backorders">Do not allow</label><br>
            <input type="radio" id="notify_customer" name="metadata[backorders]" value="allow_notify">
            <label for="notify_customer">Allow, but notify customer</label><br>
            <input type="radio" id="allow_backorders" name="metadata[backorders]" value="allow">
            <label for="allow_backorders">Allow</label><br><br>

            <button type="submit">Create Post</button>
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

