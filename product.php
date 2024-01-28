<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Page</title>
    <link rel="stylesheet" href="assets/css/product.css">

</head>
<body>

<!--<div class="product-page">
    <h1>Product Title</h1>
    <div class="main-image">
        <img id="mainImg" src="assets/uploads/1706380424_image-45.png" alt="Main Image">
        <span class="close-btn">&times;</span>
    </div>
    <div class="additional-images">
        <img class="small-img" src="assets/uploads/1706380424_image-45.png" alt="Additional Image 1">
        <img class="small-img" src="assets/uploads/1706120720_kobita1.png" alt="Additional Image 2">
        <img class="small-img" src="assets/uploads/1706380424_image-45.png" alt="Additional Image 3">
        <img class="small-img" src="assets/uploads/1706380424_image-45.png" alt="Additional Image 4">
        <img class="small-img" src="assets/uploads/1706380424_image-45.png" alt="Additional Image 5">
    </div>
    <div class="nav-arrows">
        <button id="prevBtn">&lt;</button>
        <button id="nextBtn">&gt;</button>
    </div>
</div>-->

<div class="product-page">
    <h1>Product Title</h1>
    <div class="main-image-container">
        <div class="main-image">
            <img id="mainImg" src="assets/uploads/1706380424_image-45.png" alt="Main Image">
            <div class="nav-arrows" id="nav-arrows" style="display: none">
                <button class="prev-btn" id="prevBtn">&lt;</button>
                <button class="next-btn" id="nextBtn">&gt;</button>
            </div>
            <span class="close-btn" id="fullScreen">Full</span>
<!--            <span class="close-btn" id="hideFullScreen" style="display: none">&times;</span>-->
        </div>
    </div>
    <div class="additional-images">
        <img class="small-img" src="assets/uploads/1706380424_image-45.png" alt="Additional Image 1">
        <img class="small-img" src="assets/uploads/1706120720_kobita1.png" alt="Additional Image 2">
        <img class="small-img" src="assets/uploads/1706380424_image-45.png" alt="Additional Image 3">
        <img class="small-img" src="assets/uploads/1706380424_image-45.png" alt="Additional Image 4">
        <img class="small-img" src="assets/uploads/1706380424_image-45.png" alt="Additional Image 5">
    </div>
</div>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="assets/js/product.js"></script>
</body>
</html>
