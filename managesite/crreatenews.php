<?php ?>
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
    <script src="../assets/js/common.js"></script>
    <script src="../assets/js/texteditor.js"></script>
    <script src="../assets/js/createnew.js"></script>
</head>
<body>
<?php include_once "../views/header.php"?>
<h1 class="createNewsTitle">Create Products</h1>
<div class="formHolder">
    <div class='container'>
    <div class='left-side'>

        <div class='section input-section'>
            <h3 class='section-title'>Title</h3>
            <input class='text-input' type='text' name='title' placeholder='Product Title' />
        </div>

        <div class='section input-section'>
            <h3 class='section-title'>Description</h3>
            <textarea class='text-input' rows='8' type='text' name='description' placeholder='Product Description'></textarea>
        </div>

        <div class='section input-section'>
            <h3 class='section-title'>Short Description</h3>
            <textarea class='text-input' rows='5' type='text' name='description' placeholder='Product Short Description'></textarea>
        </div>

        <div class='section input-section'>
            <h3 class='section-title'>Product Type</h3>
            <div class='input-group'>
                <input class='radio-input' name='product-type' type='radio' placeholder='Product Sku'/>
                <label class='radio-label'>
                    Simple
                </label>
            </div>

            <div class='input-group'>
                <input class='radio-input' name='product-type' type='radio' placeholder='Product Sku'/>
                <label class='radio-label'>
                    Variable
                </label>
            </div>

            <div class='input-group'>
                <input class='radio-input' name='product-type' type='radio' placeholder='Product Sku'/>
                <label class='radio-label'>
                    Complex
                </label>
            </div>
        </div>

    </div>
    <div class='right-side'>
        <div class='section'>
            <h3 class='section-title'>Cover Image</h3>
            <img class='cover-image' src="https://images.pexels.com/photos/335257/pexels-photo-335257.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2" alt="cover image">
            <div class='image-name-placeholder'>
                image.jpg
            </div>
        </div>

        <div class='section'>
            <h3 class='section-title'>Gallery Images</h3>
            <div class='gallery'>
                <img class='gallery-image' src="https://images.pexels.com/photos/335257/pexels-photo-335257.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2" alt="cover image">
                <img class='gallery-image' src="https://images.pexels.com/photos/335257/pexels-photo-335257.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2" alt="cover image">
                <img class='gallery-image' src="https://images.pexels.com/photos/335257/pexels-photo-335257.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2" alt="cover image">
            </div>
            <div class='image-name-placeholder'>
                image.jpg, image2.jpg, image3.jpg
            </div>
        </div>

        <div class='section input-section'>
            <h3 class='section-title'>Sku</h3>
            <input class='text-input' type='text' placeholder='Product Sku' />
        </div>

        <div class='section input-section'>
            <h3 class='section-title'>Price</h3>
            <div class='input-group'>
                <label class='price-label'>
                    Regular
                </label>
                <input class='text-input' type='text' placeholder='Regular Price' />
            </div>
            <div class='input-group'>
                <label class='price-label'>
                    Discount
                </label>
                <input class='text-input' type='text' placeholder='Discount Price' />
            </div>
        </div>

        <div class='section input-section'>
            <h3 class='section-title'>Stock Status</h3>
            <div class='input-group'>
                <input class='radio-input' type='radio' placeholder='Product Sku' />
                <label class='radio-label'>
                    In Stock
                </label>
            </div>

            <div class='input-group'>
                <input class='radio-input' type='radio' placeholder='Product Sku' />
                <label class='radio-label'>
                    Out Of Stock
                </label>
            </div>

            <div class='input-group'>
                <input class='radio-input' type='radio' placeholder='Product Sku' />
                <label class='radio-label'>
                    On Backorder
                </label>
            </div>
        </div>

        <div class='section input-section'>
            <h3 class='section-title'>Quantity</h3>
            <input class='text-input' type='text' placeholder='Product Quantity' />
        </div>

        <div class='section input-section'>
            <h3 class='section-title'>Stock</h3>
            <input class='text-input' type='text' placeholder='Product Stock' />
        </div>
    </div>
</div>
</div>
</body>
</html>
