<?php
//$sql = "ALTER TABLE `users` ADD `admin_level` INT(2) NOT NULL DEFAULT '0' AFTER `admin`";
//$sql = "ALTER TABLE `news` ADD `post_status` TINYINT(1) NOT NULL DEFAULT '1' AFTER `recorded`";
function get_already_created_table_sql( $table_name ){
    $conn = Db_connect();
    $query = "SHOW CREATE TABLE $table_name";
    $result = $conn->query($query);
    if ($result) {
        $row = $result->fetch_assoc();
        echo $row["Create Table"];
    } else {
        echo "Error: " . $conn->error;
    }
    $conn->close();
}
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

function sanitize_with_html( $input ) {
    return htmlentities( $input, ENT_QUOTES, 'UTF-8');
}
function sanitize($input) {
    // Remove leading and trailing whitespaces
    $input = trim($input);
    // Remove or encode potentially harmful characters

    return filter_var($input, FILTER_SANITIZE_STRING);
}

function sanitize_array( $array, $sanitizationFunction ) {
    // Check if the input is an array
    if ( !is_array($array ) ) {
        return $array; // Return the input unchanged if it's not an array
    }
    // Initialize an empty array to store the sanitized values
    $sanitizedArray = array();
    // Iterate through each element of the array
    foreach ( $array as $key => $value ) {
        // If the element is an array, recursively sanitize it
        if (is_array($value)) {
            $sanitizedArray[$key] = sanitizeArray( $value, $sanitizationFunction );
        } else {
            // If the element is not an array, sanitize it using the provided sanitization function
            $sanitizedArray[$key] = $sanitizationFunction( $value );
        }
    }

    // Return the sanitized array
    return $sanitizedArray;
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

function display_rich_text_editor_toolbar(){
    $toolbar = "<div id='editortoolbar' class='toolbar' style='display:none;'>
                <button id='bold-button' class='box_padding'><i class='fas fa-bold'></i></button>
                <button id='italic-button' class='box_padding'><i class='fas fa-italic'></i></button>
                <button id='underline-button' class='box_padding'><i class='fas fa-underline'></i></button>
                <button id='p-button' class='box_padding'><i class='fas fa-paragraph'></i></button>
                <button id='h1-button' class='box_padding'><i class='fas fa-heading'></i>1</button>
                <button id='h2-button' class='box_padding'><i class='fas fa-heading'></i>2</button>
                <input type='color' class='color_picker' id='text-color-picker'>
            
                <button id='multiply-button' class='box_padding'><i class='fas fa-superscript'></i>2</button>
                <button id='cube-button' class='box_padding'><i class='fas fa-superscript'></i>3</button>
                <button id='square-root-button' class='box_padding'><i class='fas fa-square-root-alt'></i></button>
            
                <button id='left-align-button' class='box_padding'><i class='fas fa-align-left'></i></button>
                <button id='center-align-button' class='box_padding'><i class='fas fa-align-center'></i></button>
                <button id='right-align-button' class='box_padding'><i class='fas fa-align-right'></i></button>
                <button id='ordered-list-button' class='box_padding'><i class='fas fa-list-ol'></i></button>
                <button id='link-button' class='box_padding'><i class='fas fa-link'></i></button>
                <button id='unlink-button' class='box_padding'><i class='fas fa-unlink'></i></button>
                <button id='insert_image'><i class='fas fa-image'></i></button>
                <button id='insert_table'><i class='fas fa-table'></i></button>
                <button id='clean-button' class='box_padding'><i class='fas fa-trash'></i></button>
            </div>";

    return $toolbar;
}

function strip_html_css( $htmlString ) {
    // Remove HTML tags
    $htmlString = strip_tags($htmlString);

    // Remove inline CSS styles
    $htmlString = preg_replace('/style=("|\').*?("|\')/', '', $htmlString);

    // Remove CSS blocks
    $htmlString = preg_replace('/<style[^>]*>.*?<\/style>/is', '', $htmlString);

    return $htmlString;
}

function request_check_from_page( $page_name ){
    $pages = array(
        'createnew.php', 'editnews.php'
    );
    return in_array($page_name, $pages);
}

function make_sql_table(){
    $post_table_sql= 'CREATE TABLE `newsportal`.`postmeta` ( `meta_id` INT(43) NOT NULL , `post_id` INT(11) NOT NULL , `mata_key` VARCHAR(512) NOT NULL , `meta_value` TEXT NOT NULL ) ENGINE = InnoDB;';
    $make_images_table = 'CREATE TABLE `images` ( `id` int(11) NOT NULL AUTO_INCREMENT, `image_name` varchar(256) NOT NULL, `image_description` text DEFAULT NULL, `image_ext` varchar(11) DEFAULT NULL, `recorded` tinyint(1) NOT NULL DEFAULT 1, `image_slug` varchar(256) DEFAULT NULL, `image_link` varchar(256) DEFAULT NULL, `image_alt_text` varchar(256) DEFAULT NULL, PRIMARY KEY (`id`) ) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8';
}