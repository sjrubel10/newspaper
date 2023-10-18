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
    <link rel="stylesheet" href="../assets/css/header.css">
    <link rel="stylesheet" href="../assets/css/common.css">
    <link rel="stylesheet" href="../assets/css/createnew.css">
</head>
<body>
<?php include_once "../views/header.php"?>
<h1 class="createNewsTitle">Create News</h1>
<div class="formHolder">
    <div class="form-container">
        <form id="news-form" enctype="multipart/form-data">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required><br>

            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea><br>

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
<!--            <input type="text" id="category" name="category" required><br>-->

            <button type="submit">Submit</button>
        </form>
        <div id="error-message"></div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../assets/js/createnew.js"></script>
</body>
</html>
<?php } else {
     header('Location:index.php');
 }?>

