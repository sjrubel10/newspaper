<?php
function display_news_card( $news ){
    $new_card = "";
    foreach ($news as $article) {
        $lowercaseString = strtolower( trim($article['title'] ) );
        $slug = str_replace(' ', '-', $lowercaseString);

        if($article['images']){
            $imageLink = '<img src="assets/uploads/' . $article['images'] . '" alt="' . $article['title'] . '">';
        }else{
            $imageLink = '<img src="assets/uploads/fallbackImage/fallbackImage.webp" alt="' . $article['title'] . '">';
        }

        $new_card .= '<a class="newLinka" href="/newspaper/news.php?key='.$article['newskey'].'&title='.$slug.'"><div class="card"> ';
        $new_card .=   $imageLink;
        $new_card .=  '<div class="card-content">';
        $new_card .=  '<h4>' . $article['title'] . '</h4>';
        $new_card .=  '<div class="category">Category: ' . $article['category'] . '</div>';
        $new_card .=  '<p>' . $article['description'] . '</p>';
        $new_card .=  '</div>';
        $new_card .=  '</div> </a>';
    }

    return $new_card;
}