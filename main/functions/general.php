<?php
//$sql = "ALTER TABLE `users` ADD `admin_level` INT(2) NOT NULL DEFAULT '0' AFTER `admin`";
//$sql = "ALTER TABLE `news` ADD `post_status` TINYINT(1) NOT NULL DEFAULT '1' AFTER `recorded`";

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

function right_side_news_display( $right_side_news_data, $title, $divids='' ){
    $right_side_news = "";
    if( count( $right_side_news_data ) > 0 ){
        $right_side_news .= "<div class='rightSideNews' id=$divids>";
        $right_side_news .= "<h2 class='rightSideNewsTitleText'>$title</h2>";
        foreach ( $right_side_news_data as $key=>$sight_side_new ){
            if( isset( $sight_side_new['images'] )){
                if( $sight_side_new['images'] ){
                    $imageLink = '<img src="assets/uploads/' . $sight_side_new['images'] . '" alt="' . $sight_side_new['title'] . '" class="right-panel-card-image">';
                }else{
                    $imageLink = '<img src="assets/uploads/fallbackImage/fallbackImage.webp" alt="' . $sight_side_new['title'] . '" class="right-panel-card-image">';
                }
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
        $right_side_news .= '</div>';
        // Generate the card dynamically using PHP

    }else{
        $right_side_news .= '';
    }

    return $right_side_news ;

}

function sanitize($input) {
    // Remove leading and trailing whitespaces
    $input = trim($input);
    // Remove or encode potentially harmful characters
    $input = filter_var($input, FILTER_SANITIZE_STRING);
    return $input;
}

function get_type_of_post( $action ){
    if( $action === "delete" ){
        $recorded = 0;
        $post_status = 1;
    }else if( $action === "private" ){
        $recorded = 1;
        $post_status = -1;
    }else if( $action === "unpublish" ){
        $recorded = 1;
        $post_status = 0 ;
    }else if( $action === "publish" ){
        $recorded = 1;
        $post_status = 1;
    }else{
        $recorded = 1;
        $post_status = 1;
    }

    return $action =array( 'recorded' => $recorded, 'post_status' => $post_status );
}