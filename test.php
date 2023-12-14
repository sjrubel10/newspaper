
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comment and Reply UI</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        .comment-container {
            max-width: 600px;
            margin: 20px auto;
        }

        .paragraph {
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .comment, .reply {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .user-avatar {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .user {
            font-weight: bold;
            color: #333;
        }

        .timestamp {
            font-size: 0.8em;
            color: #777;
            margin-right: 10px;
        }

        .content {
            color: #555;
        }

        .reply-form textarea {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            resize: vertical;
        }

        .reply-form button {
            background-color: #4caf50;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .reply-form button:hover {
            background-color: #45a049;
        }
    </style>
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            // Handle comment button click event
            $('#comment-btn').on('click', function() {
                var commentText = $('#comment-textarea').val().trim();
                if (commentText !== '') {
                    var commentElement = `
            <div class="comment">
              <img class="user-avatar" src="uploads/1697774990_tecknews1.jpeg" alt="User Avatar">
              <div class="user">John Doe</div>
              <div class="timestamp">Just now</div>
              <div class="content">${commentText}</div>
            </div>
            <div class="reply-form">
              <textarea placeholder="Write a reply..."></textarea>
              <button class="reply-btn">Reply</button>
            </div>`;
                    $('#comment-container').append(commentElement);
                    $('#comment-textarea').val('');
                }
            });

            // Handle reply button click event
            $('#comment-container').on('click', '.reply-btn', function() {
                var replyText = $(this).siblings('textarea').val().trim();
                if (replyText !== '') {
                    var replyElement = `
            <div class="reply">
              <img class="user-avatar" src="uploads/1697774990_tecknews1.jpeg" alt="User Avatar">
              <div class="user">Jane Smith</div>
              <div class="timestamp">Just now</div>
              <div class="content">${replyText}</div>
            </div>`;
                    $(this).parent().before(replyElement);
                    $(this).siblings('textarea').val('');
                }
            });
        });
    </script>
</head>
<body>

<div class="comment-container" id="comment-container">
    <div class="paragraph">
        <p>This is a sample paragraph.</p>
    </div>

    <div class="reply-form">
        <textarea id="comment-textarea" placeholder="Write a comment..."></textarea>
        <button id="comment-btn">Comment</button>
    </div>
</div>

</body>
</html>




<?php
die();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Upload</title>
<!--    <link rel="stylesheet" href="style.css">-->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        h1 {
            margin: 0;
            padding: 10px 0;
        }

        /*input[type="file"] {
            display: none;
        }*/

        .image-preview {
            margin: 20px 0;
        }

        img {
            max-width: 100%;
            max-height: 200px;
            display: none;
        }

    </style>
</head>
<body>
<div class="container">
    <h1>Image Upload</h1>
<!--    <input type="file" id="fileInput" accept="image/*">-->
    <input type="file" id="fileInput" name="img" accept="image/*">
    <div class="image-preview">
        <img id="imagePreview" src="" alt="Image Preview">
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!--<script src="script.js"></script>-->
</body>
</html>

<script>
    $(document).ready(function() {
        /*$('#fileInput').change(function() {
            readURL(this);
        });*/

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#imagePreview').attr('src', e.target.result);
                    $('#imagePreview').show();
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
    });

</script>

    Here's a list of common HTML meta tags, including various types of meta tags that you might use in the <head> section of your HTML document. Note that while some meta tags are widely supported, others might be specific to certain platforms or purposes.

    Viewport Meta Tag:
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    Charset Meta Tag:
    <meta charset="UTF-8">
    Description Meta Tag:
    <meta name="description" content="A concise description of your page content">
    Keywords Meta Tag (Not widely used by search engines):
    <meta name="keywords" content="keyword1, keyword2, keyword3">
    Author Meta Tag:
    <meta name="author" content="Author Name">
    Viewport Meta Tag for Responsive Design:
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    Robots Meta Tag (Controlling search engine indexing):
    <meta name="robots" content="index, follow">

    OGP (Open Graph Protocol) Meta Tags for Social Media:
    <meta property="og:title" content="Your Open Graph Title">
    <meta property="og:description" content="Your Open Graph Description">
    <meta property="og:image" content="URL to Your Open Graph Image">
    <meta property="og:url" content="URL of the Page">
    <meta property="og:type" content="website">
    Twitter Meta Tags (Twitter Card):
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@YourTwitterHandle">
    <meta name="twitter:title" content="Your Twitter Card Title">
    <meta name="twitter:description" content="Your Twitter Card Description">
    <meta name="twitter:image" content="URL to Your Twitter Card Image">

    Canonical Link Tag (Specifying the preferred version of a page):
    <link rel="canonical" href="https://www.example.com/canonical-page">
    Favicon Link Tag (Specifying the favicon):
    <link rel="icon" href="/path/to/favicon.ico" type="image/x-icon">
    Apple Touch Icon Link Tag (for iOS devices):
    <link rel="apple-touch-icon" href="/path/to/apple-touch-icon.png">
    These are just some examples, and the choice of meta tags depends on your specific requirements, such as SEO, social media sharing, or mobile responsiveness. Always ensure that the meta tags you use comply with the latest web standards and best practices.