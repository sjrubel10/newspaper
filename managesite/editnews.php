<?php
require "../main/init.php";
if( isset( $_SESSION['logged_in'] ) && isset( $_SESSION['logged_in_user_data'] ) && $_SESSION['logged_in'] === true && $_SESSION['logged_in_user_data']['admin'] ===1 &&  $_SESSION['logged_in_user_data']['recorded'] ===1){
    $categorys = news_category();
    if( isset(  $_GET['key'] ) && !empty(  $_GET['key'] )) {
        $conn = Db_connect();
        $key = $_GET['key'];
//        var_test_die( $key );
        //$newData = getsingleNews( $key,$conn );
//        $newData = getNewsByKey( $key );
        $folder_path = 'assets/uploads/';
        $newData = fetchNewsData( $key, $folder_path );
        if( count( $newData ) > 0 ){
//            $edit_news_data = $newData;
            $data_vailable = true;
        }else{
            $data_vailable = false;
            header('Location:index.php');
        }
    }else{
        $data_vailable = false;
        header('Location:index.php');
    }

//    var_test_die( $newData );
    if( $data_vailable ){
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $newData['title']?></title>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <link rel="stylesheet" href="../assets/css/header.css">
        <link rel="stylesheet" href="../assets/css/common.css">
        <link rel="stylesheet" href="../assets/css/createnew.css">
        <link rel="stylesheet" href="../assets/css/texteditor.css">
        <link rel="stylesheet" href="../assets/css/mediafile.css">
        <link rel="stylesheet" href="../assets/css/product.css">

    </head>
    <body>
    <?php include_once "../views/header.php"?>
    <h1 class="createNewsTitle">Edit News</h1>
    <div class="formHolder">
        <div class="form-container">
            <form id="news-form" enctype="multipart/form-data">

                <input type="text" id="newskey" name="newskey" value="<?php echo $newData['newskey']?>" style="display: none"><br>

                <label for="title">Title:</label>
                <input type="text" id="title" name="title" value="<?php echo $newData['title']?>" required><br>

                <div class="editor-container" id="editor-container">
                    <span class="editorText" id="editorText">Description</span>
                    <div contenteditable="true" class="editor" id="editor">
                        <?php echo $newData['description']?>
                    </div>
                </div>

                <!--<label for="images">Image:</label>
                <input type="file" id="images" name="images" accept="image/*"><br>-->

                <label for="images">Main Image:</label>
                <!--<div class="additional-images">
                    <img class="small-img focused" src="../<?php /*echo $newData['main_image_link'];*/?>">
                </div>-->
                <button class="openPopup" id="openPopup">Add Or Select Image</button>
                <input type="text" id="postImage" name="postImage" value="<?php echo $newData['image']?>" required><br>

                <label for="images">gallery Image:</label>
                <button class="openPopup" id="openPopupForGallery">Add Or Select Gallery Image </button>
                <input type="text" id="postGalleryImage" name="postGalleryImage" value="<?php echo $newData['additional_images']?>" required><br>


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

                <button type="submit">Update</button>
            </form>
            <div id="error-message"></div>
        </div>
    </div>



    </body>
    </html>

    <script src="../assets/js/common.js"></script>
    <script src="../assets/js/texteditor.js"></script>
    <script src="../assets/js/editnews.js"></script>
    <script src="../assets/js/addmedia.js"></script>
<?php }

    } else {
    header('Location:index.php');
}?>


