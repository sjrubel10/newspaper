<?php
function news_category(){
    $categorys = array( 'Government','Sport', 'War', 'Politics', 'Education', 'Health', 'The environment',
        'Economy', 'Business', 'Fashion', 'Entertainment', 'Banking & Finance', 'Computers & IT','Art & Culture',
        'Books & Literature',
        'Celebrity Gossip & Social',
        'Movies',
        'Music',
        'Performing Arts',
        'Photography');
    return $categorys;
}

function right_side_news_display( $sight_side_news, $title ){

    $right_side_news = "";
    $right_side_news .= "<h2>$title</h2>";
    foreach ( $sight_side_news as $key=>$sight_side_new ){
//        $imageLink = '<img src="assets/uploads/fallbackImage/fallbackImage.webp" alt="' . $sight_side_new['title'] . ' " class="right-panel-card-image">';

        if($sight_side_new['images']){
            $imageLink = '<img src="assets/uploads/' . $sight_side_new['images'] . '" alt="' . $sight_side_new['title'] . '" class="right-panel-card-image">';
        }else{
            $imageLink = '<img src="assets/uploads/fallbackImage/fallbackImage.webp" alt="' . $sight_side_new['title'] . '" class="right-panel-card-image">';
        }

        $right_side_news .= '<div class="right-panel-card">';
        $right_side_news .= $imageLink;
        $right_side_news .= '<div class="right-panel-card-details">';
        $right_side_news .= '<h3 class="right-panel-card-title">' . $sight_side_new['title'] . '</h3>';
        $right_side_news .= '</div>';
        $right_side_news .= '</div>';
    }
    // Generate the card dynamically using PHP
    return $right_side_news ;
}