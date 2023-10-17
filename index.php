<?php
require  "main/init.php";
$conn = Db_connect();
$news = getNews( $conn );
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News Page</title>
    <link rel="stylesheet" href="assets/css/index.css">
    <link rel="stylesheet" href="assets/css/header.css">
</head>
<body>
    <?php include_once "views/header.php"?>
    <h1>Latest News</h1>
    <div class="newCardHolder">
        <div class="newcontainer">
            <?php
            foreach ($news as $article) {
                $lowercaseString = strtolower( trim($article['title'] ) );
                $slug = str_replace(' ', '-', $lowercaseString);

                if($article['images']){
                    $imageLink = '<img src="assets/uploads/' . $article['images'] . '" alt="' . $article['title'] . '">';
                }else{
                    $imageLink = '<img src="assets/uploads/fallbackImage/fallbackImage.webp" alt="' . $article['title'] . '">';
                }

                echo '<a class="newLinka" href="/newspaper/news.php?key='.$article['newskey'].'title='.$slug.'"><div class="card"> ';
                echo  $imageLink;
                echo '<div class="card-content">';
                echo '<h4>' . $article['title'] . '</h4>';
                echo '<div class="category">Category: ' . $article['category'] . '</div>';
                echo '<p>' . $article['description'] . '</p>';
                echo '</div>';
                echo '</div> </a>';
            }
            ?>
        </div>
    </div>
</body>
</html>

