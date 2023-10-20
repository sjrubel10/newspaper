<?php
    require "../main/init.php";
    $conn = Db_connect();
    $display_limit = 20;
    $usersData = getUsersData( $conn, $display_limit );
    $news = getNews( $conn, $display_limit );
//    var_test_die( $news );
?>
<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Panel</title>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <link rel="stylesheet" href="adminassets/css/admin.css">
        <link rel="stylesheet" href="../assets/css/header.css">
        <link rel="stylesheet" href="../assets/css/common.css">
    </head>
    <body>
         <?php if( isset( $_SESSION['logged_in'] ) && isset( $_SESSION['logged_in_user_data'] ) && $_SESSION['logged_in'] === true && $_SESSION['logged_in_user_data']['admin'] ===1 &&  $_SESSION['logged_in_user_data']['recorded'] ===1){?>
             <?php include_once "../views/header.php"?>
             <div class="container" id="adminContainer">
                <div class="sidebar">
                    <h1>Admin Panel</h1>
                    <ul>
                        <li class="manage-admins" id="manage-admins "><a href="createnew.php">Create News</a></li>
                        <li class="manage-admins adminTabChange" id="manage-admins">Manage Admins</li>
                        <li class="manage-posts adminTabChange" id="manage-posts">Manage Posts</li>
                        <li class="analytics adminTabChange" id="analytics">Analytics</li>
                    </ul>
                </div>
                <div class="admincontentholder">
                    <div id="manage-admins_holder" class="tab-content" style="display: block">
                        <h2>Manage Admin</h2>

                    </div>
                    <div id="manage-posts_holder" class="tab-content">
                        <div class="post-card_holde">
                            <h2>Post Title</h2>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam id felis et ipsum bibendum ultrices.</p>
                            <div class="actions">
                                <span class="action-btn managepost" id="edit"><i class="fas fa-edit"></i> Edit</span>
                                <span class="action-btn managepost" id="delete"><i class="fas fa-trash-alt"></i> Delete</span>
                                <span class="action-btn managepost" id="modify"><i class="fas fa-wrench"></i> Modify</span>
                                <span class="action-btn managepost" id="publish"><i class="fas fa-upload"></i> Publish</span>
                                <span class="action-btn managepost" id="private"><i class="fas fa-lock"></i> Make Private</span>
                            </div>
                        </div>
                    </div>
                    <div id="analytics_holder" class="tab-content">
                        <div class="">Content for analytics goes here</div>
                    </div>
                </div>
            </div>
        <?php } else{
             header('Location:index.php');
         }?>
    </body>
    <script src="adminassets/js/admin.js"></script>
</html>
