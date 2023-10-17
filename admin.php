<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/addmin.css">
</head>

<body>
<div class="container">
    <aside class="sidebar">
        <h1>Admin Panel</h1>
        <ul>
            <li>Manage Admins</li>
            <li>Manage Posts</li>
            <li>Analytics</li>
        </ul>
    </aside>
    <main class="content">
        <div id="manage-admins_holder" class="tab-content">
            <!-- Content for managing admins goes here -->
            <h2>Manage Admin</h2>
        </div>
        <div id="manage-posts" class="tab-content">
            <!-- Content for managing posts goes here -->
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
        <div id="analytics_holde" class="tab-content">
            <!-- Content for analytics goes here -->
        </div>
    </main>
</div>
</body>

<script src="jquery.min.js"></script>
<script src="assets/js/addmin.js"></script>

</html>
