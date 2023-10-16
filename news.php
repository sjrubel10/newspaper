<?php
require  "main/init.php";
$conn = Db_connect();
$key = $_GET['key'];

//$newData = getsingleNews( $key,$conn );
$newData = getNewsByKey($conn, $key);
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
    <link rel="stylesheet" href="assets/css/news.css">
</head>
<body>
<div class="news-container">
    <div class="news-details">
        <h1 class="news-title"><?php echo $newData['title']?></h1>
        <div class="news-info">
            <span class="category"><?php echo $newData['category']?></span>
            <span class="author">Rubel</span>
            <span class="publish-time">Published on October 20, 2023 <?php /*echo $newData['createddate']*/?></span>
        </div>
        <div class="news-image">
            <?php echo $imageLink?>
        </div>
        <p class="news-description">
            <?php echo $newData['description']?>
        </p>
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

