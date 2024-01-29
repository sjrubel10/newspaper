<?php
require "main/init.php";

if( isset(  $_GET['key'] ) && !empty(  $_GET['key'] )){
    $conn = Db_connect();
    $key = $_GET['key'];
    //$newData = getsingleNews( $key,$conn );
    $newData = getNewsByKey($conn, $key);

    $data = fetchNewsData( $conn, $key );
    var_test_die( $data );

    if( count($newData) > 0 ){
    if($newData['images']){
        $imageLink = '<img src="assets/uploads/' . $newData['images'] . '" alt="' . $newData['title'] . '">';
    }else{
        $imageLink = '<img src="assets/uploads/fallbackImage/fallbackImage.webp" alt="' . $newData['title'] . '">';
    }
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $newData['title']?></title>
        <link rel="stylesheet" href="assets/css/header.css">
        <link rel="stylesheet" href="assets/css/news.css">
        <link rel="stylesheet" href="assets/css/common.css">
        <link rel="stylesheet" href="assets/css/product.css">

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </head>
    <body>
    <?php include_once "views/header.php"?>
    <div class="news-container">
        <div class="news-details">
            <h1 class="news-title"><?php echo $newData['title']?></h1>
            <div class="news-info">
                <span class="category"><?php echo $newData['category']?></span>
                <span class="author">Rubel</span>
                <span class="publish-time">Published on October 20, 2023 <?php /*echo $newData['createddate']*/?></span>
            </div>
            <div class="news-image">
<!--                --><?php //echo $imageLink?>
                <div class="main-image-container">
                    <div class="main-image">
                        <img id="mainImg" src="assets/uploads/h410m-a-pro-500x500.jpg" alt="Main Image">
                        <div class="nav-arrows" id="nav-arrows" style="display: none">
                            <button class="prev-btn" id="prevBtn">&lt;</button>
                            <button class="next-btn" id="nextBtn">&gt;</button>
                        </div>
                        <span class="close-btn" id="fullScreen">Full</span>
                    </div>
                </div>
                <div class="additional-images">
                    <img class="small-img focused" src="assets/uploads/h410m-a-pro-500x500.jpg" alt="Main Image">
                    <img class="small-img" src="assets/uploads/img_lights_wide.jpg" alt="Additional Image 1">
                    <img class="small-img" src="assets/uploads/img_mountains_wide.jpg" alt="Additional Image 2">
                    <img class="small-img" src="assets/uploads/img_nature_wide.jpg" alt="Additional Image 3">
                    <img class="small-img" src="assets/uploads/img_snow_wide.jpg" alt="Additional Image 4">
                    <img class="small-img" src="assets/uploads/googluck.jpg" alt="Additional Image 5">
                </div>

            </div>



<!--            <p class="news-description">-->
                <?php echo $newData['description']?>
<!--            </p>-->
        </div>

        <div class="comment-box">
            <h2>Comments</h2>
            <!-- Comment form -->
            <form method="post">
                <label for="comment">Leave a Comment:</label>
                <textarea id="comment" name="comment" rows="4" cols="50"></textarea>
                <button type="submit">Submit</button>
            </form>
            <!-- Comments -->
            <div class="comments">
                <div class="comment">
                    <span class="comment-author">John Doe:</span>
                    <p>This is a great article!</p>
                </div>
                <!-- More comments go here -->
            </div>
        </div>

    </div>
    </body>
    </html>

<?php } else {
        header("Location: index.php");
    }
} else {
    header("Location: index.php");
}?>

<script src="assets/js/product.js"></script>

