<?php
require "main/init.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $selectedImage = $_POST['selectedImage'];
    $postContent = $_POST['postContent'];

    var_test_die( $_FILES );

    // Here, you can handle the selected image and post content as per your requirements
    // For example, you can save them to a database or process them further
    // Sample code to store in a file
    file_put_contents('post.txt', "Post Content: $postContent\nSelected Image: $selectedImage", FILE_APPEND);
    echo "Post created successfully!";
}

