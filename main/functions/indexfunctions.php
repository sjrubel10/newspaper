<?php
function display_news_card( $news ){
    $new_card = "";
    if( count( $news )> 0 ) {

        foreach ($news as $article) {
            $description = strip_html_css( $article['description'] );
            $lowercaseString = strtolower(trim($article['title']));
            $slug = str_replace(' ', '-', $lowercaseString);

            if ($article['images']) {
                $imageLink = '<img src="assets/uploads/' . $article['images'] . '" alt="' . $article['title'] . '" loading="lazy">';
            } else {
                $imageLink = '<img src="assets/uploads/fallbackImage/fallbackImage.webp" alt="' . $article['title'] . '" loading="lazy">';
            }

            $new_card .= '<a class="newLinka" href="/newspaper/news.php?key=' . $article['newskey'] . '&title=' . $slug . '"><div class="card"> ';
            $new_card .= $imageLink;
            $new_card .= '<div class="card-content">';
            $new_card .= '<h2>' . $article['title'] . '</h2>';
            $new_card .= '<div class="category">Category: ' . $article['category'] . '</div>';
            $new_card .= '<p>' . $description . '</p>';
            $new_card .= '</div>';
            $new_card .= '</div> </a>';
        }
    }else{
        $new_card .= '<div class="emptyResult">No Data Found </div>';
    }

    return $new_card;
}