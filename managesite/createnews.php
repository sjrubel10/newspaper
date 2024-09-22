<?php
require "../main/init.php";
if( isset( $_SESSION['logged_in'] ) && isset( $_SESSION['logged_in_user_data'] ) && $_SESSION['logged_in'] === true && $_SESSION['logged_in_user_data']['admin'] ===1 &&  $_SESSION['logged_in_user_data']['recorded'] ===1){
$categorys = news_category();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News Form</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/header.css">
    <link rel="stylesheet" href="../assets/css/common.css">
    <link rel="stylesheet" href="adminassets/css/createnews.css">
    <link rel="stylesheet" href="../assets/css/texteditor.css">
    <link rel="stylesheet" href="../assets/css/mediafile.css">


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>
<body>
<?php include_once "../views/header.php"?>
    <h1 class="createNewsTitleText">Create Products</h1>
    <div class="news-form-container ">
        <form id="news-form" enctype="multipart/form-data">
            <div class="formHolder">
            <div class='container'>
                <div class='left-side'>

                    <div class='section input-section'>
                        <h3 class='section-title'>Title</h3>
                        <input class='text-input' type='text' name='title' placeholder='Product Title' />
                    </div>

                    <div class="editor-container" id="editor-container">
                        <span class="editorText" id="editorText">Description</span>
                        <div contenteditable="true" class="editor" id="editor">
                            <p>Write Something Here </p>
                        </div>
                    </div>

                    <div class='section input-section'>
                        <h3 class='section-title'>Short Description</h3>
                        <textarea class='text-input' rows='5' type='text' name='short_description' placeholder='Product Short Description'></textarea>
                    </div>

                    <div class='section input-section'>
                        <h3 class='section-title'>Product Type</h3>
                        <div class='input-group'>
                            <input class='radio-input' name='product-type' type='radio' />
                            <label class='radio-label'>
                                Simple
                            </label>
                        </div>

                        <div class='input-group'>
                            <input class='radio-input' name='product-type' type='radio' />
                            <label class='radio-label'>
                                Variable
                            </label>
                        </div>

                        <div class='input-group'>
                            <input class='radio-input' name='product-type' type='radio' />
                            <label class='radio-label'>
                                Complex
                            </label>
                        </div>
                    </div>

                    <div class='section input-section'>
                        <h3 class='section-title'>Product Category</h3>
                        <select id="category" name="category" required>
                            <?php
                            foreach ($categorys as $category) {
                                $key = str_replace(' ', '', strtolower($category));
                                echo '<option value="' . $key . '">' . $category . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                </div>
                <div class='right-side'>
                <div class='section'>
                    <h3 class='section-title'>Cover Image</h3>
                    <img class='cover-image' id="productMainImage" src="https://images.pexels.com/photos/335257/pexels-photo-335257.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2" alt="cover image">
                    <div class='image-name-placeholder openPopup' id="openPopup">
                        Add Or Select Image
                    </div>
                    <input class="image-name-placeholder" type="text" id="postImage" name="metadata[postImage]" style="visibility: hidden; display: none"><br>
                </div>

                <div class='section'>
                    <h3 class='section-title'>Gallery Images</h3>
                    <div class='gallery' id="productAdditionlImage">
                        <img class='gallery-image' src="https://images.pexels.com/photos/335257/pexels-photo-335257.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2" alt="cover image">
                        <img class='gallery-image' src="https://images.pexels.com/photos/335257/pexels-photo-335257.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2" alt="cover image">
                        <img class='gallery-image' src="https://images.pexels.com/photos/335257/pexels-photo-335257.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2" alt="cover image">
                    </div>
                    <div class='image-name-placeholder openPopup' id="openPopupForGallery">
                        Add Or Select Gallery Image
                    </div>
        <!--            <button class="openPopup" id="openPopupForGallery">Add Or Select Gallery Image </button>-->
                    <input type="text" id="postGalleryImage" name="metadata[postGalleryImage]" style="visibility: hidden; display: none"><br>
                </div>

                <div class='section input-section'>
                    <h3 class='section-title'>Sku</h3>
                    <input class='text-input' type='text' name="metadata[sku]" placeholder='Product Sku' />
                </div>

                <div class='section input-section'>
                    <h3 class='section-title'>Price</h3>
                    <div class='input-group'>
                        <label class='price-label'>
                            Regular
                        </label>
                        <input class='text-input' type='text' name="metadata[regular_price]" placeholder='Regular Price' />
                    </div>
                    <div class='input-group'>
                        <label class='price-label'>
                            Discount
                        </label>
                        <input class='text-input' type='text' name="metadata[sale_price]" placeholder='Discount Price' />
                    </div>
                </div>

                <div class='section input-section'>
                    <h3 class='section-title'>Stock Status</h3>
                    <div class='input-group'>
                        <input class='radio-input' type='radio' name="metadata[stock_status]" placeholder='Stock Status' />
                        <label class='radio-label'>
                            In Stock
                        </label>
                    </div>

                    <div class='input-group'>
                        <input class='radio-input' type='radio' name="metadata[stock_status]" placeholder='Stock Status' />
                        <label class='radio-label'>
                            Out Of Stock
                        </label>
                    </div>

                    <div class='input-group'>
                        <input class='radio-input' type='radio' name="metadata[stock_status]" placeholder='Stock Status' />
                        <label class='radio-label'>
                            On Backorder
                        </label>
                    </div>
                </div>

                <div class='section input-section'>
                    <h3 class='section-title'>Quantity</h3>
                    <input class='text-input' type='number' name="metadata[quantity]" placeholder='Product Quantity' />
                </div>

                <div class='section input-section'>
                    <h3 class='section-title'>Stock</h3>
                    <input class='text-input' type='number' name="metadata[stock]" placeholder='Product Stock' />
                </div>
            </div>
            </div>
        </div>
            <button type="submit">Create Post</button>
        </form>
    </div>
</body>
</html>

<script src="../assets/js/common.js"></script>
<script src="../assets/js/texteditor.js"></script>
<script src="../assets/js/createnew.js"></script>
<script src="../assets/js/addmedia.js"></script>
<?php } else {
    header('Location:index.php');
}?>