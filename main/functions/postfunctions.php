<?php
function make_images_path( $folder_path, $image_name, $title ){
    if( $image_name === null ){
        $imageLink =  $folder_path.$image_name;
    }else{
        $imageLink = $folder_path. $image_name ;
    }

    return $imageLink;
}
function make_addition_image_like( $folder_path, $string, $title ){
    $imageLinks = [];
    if( $string !== null ){
        $imagesArray = explode(', ', $string);
        $i = 1;
        foreach ($imagesArray as $imageName) {
            $title = $title." image ".$i ;
            $imageLinks[] = make_images_path( $folder_path, $imageName, $title );
            $i++;
        }
    }

    return $imageLinks;

}
function fetch_post_data( $key, $folder_path ): array
{
    $db = Db_connect();
    $newsData = array(); // Initialize $newsData as an array
    $id = $newskey = $title = $description = $images = $additional_images = $category = $recorded = $post_status = $userid = $createddate = $is_comment = $commentid = null;
    try {
        $query = "SELECT `id`, `newskey`, `title`, `description`, `images`, `additional_images`, `category`, `recorded`, `post_status`, `userid`, `createddate`, `is_comment`, `commentid` FROM `news` WHERE `recorded` = 1 AND `newskey` = ?";
        $st = $db->prepare($query);

        if ($st) {
            $st->bind_param("s", $key);
            $st->execute();
            $st->bind_result($id, $newskey, $title, $description, $images, $additional_images, $category, $recorded, $post_status, $userid, $createddate, $is_comment, $commentid);

            while ($st->fetch()) {
                $newsData = array(
                    'id' => $id,
                    'newskey' => $newskey,
                    'title' => $title,
                    'description' => $description,
                    'image' => $images,
                    'main_image_link' =>make_images_path( $folder_path, $images, $title ) ,
                    'additional_images' => $additional_images,
                    'additional_image_links' => make_addition_image_like( $folder_path, $additional_images, $title ),
                    'category' => $category,
                    'recorded' => $recorded,
                    'post_status' => $post_status,
                    'userid' => $userid,
                    'createddate' => $createddate,
                    'is_comment' => $is_comment,
                    'commentid' => $commentid
                );
            }
            $newsData['postmeta'] = get_post_meta_by_post_id( $id );

            $st->close();
        } else {
            throw new Exception("Error: Unable to prepare statement.");
        }
    } catch (Exception $e) {
        // Handle the exception
        error_log('Error fetching news data: ' . $e->getMessage());
        return $newsData; // or handle the error in a different way
    }

    return $newsData;
}

function get_post_meta_by_post_id( $postId ) {
    $conn = Db_connect();
    // Prepare SQL statement
    $sql = "SELECT meta_key, meta_value FROM postmeta WHERE post_id = ?";
    // Prepare the statement
    $stmt = $conn->prepare($sql);

    // Check if preparation succeeded
    if (!$stmt) {
        return array(
            'success' => false,
            'message' => "Database Error: " . $conn->error
        );
    }

    // Bind parameters and execute the statement
    $stmt->bind_param("i", $postId);
    $stmt->execute();

    // Get result
    $result = $stmt->get_result();

    // Check if there are any rows returned
    if ($result->num_rows === 0) {
        return array(
            'success' => false,
            'message' => "No data found for post_id: " . $postId
        );
    }

    // Initialize array to store meta data
    $metaArray = array();

    // Fetch rows and construct array
    while ($row = $result->fetch_assoc()) {
        $metaArray[$row['meta_key']] = $row['meta_value'];
    }
    // Close the statement
    $stmt->close();

    // Return the array
    return $metaArray;
}


function display_Additional_images_on_post( $main_image, $additional_images, $title ){
    $additional_images_html = '';
    $main_image = "<img class='small-img focused' src=$main_image alt=$title>";
    $additional_images_html = '
                                    <img class="small-img focused" src="assets/uploads/h410m-a-pro-500x500.jpg" alt="Main Image">
                                    <img class="small-img" src="assets/uploads/img_lights_wide.jpg" alt="Additional Image 1">
                                    <img class="small-img" src="assets/uploads/img_mountains_wide.jpg" alt="Additional Image 2">
                                    <img class="small-img" src="assets/uploads/img_nature_wide.jpg" alt="Additional Image 3">
                                    <img class="small-img" src="assets/uploads/img_snow_wide.jpg" alt="Additional Image 4">
                                    <img class="small-img" src="assets/uploads/googluck.jpg" alt="Additional Image 5">
                                </div>';

    return $additional_images_html;
}