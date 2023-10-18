<?php
require  "main/init.php";
$conn = Db_connect();
$news = getNews( $conn );
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News Page</title>
    <link rel="stylesheet" href="assets/css/index.css">
    <link rel="stylesheet" href="assets/css/header.css">
    <link rel="stylesheet" href="assets/css/common.css">
</head>
<body>
    <?php include_once "views/header.php"?>
    <div class="newCardHolder">
        <div class="leftnavbarHolder">
            <?php include "views/leftnavbar.php"?>
        </div>
        <div class="maincontentHolder">
            <?php include "views/indexcontent.php"?>
        </div>
        <div class="rightsideHolder">
            <?php include "views/rightsidebar.php"?>
        </div>

    </div>
</body>
</html>

