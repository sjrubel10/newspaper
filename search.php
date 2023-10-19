<?php
require  "main/init.php";
$conn = Db_connect();
$display_limit = 20;

if( isset( $_GET['searchkey'] ) && !empty( $_GET['searchkey'] ) ){
    $search = $_GET['searchkey'];
    $news = getNews_search( $conn, $display_limit, $search );
}else{
    $news = [];
}
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<?php include_once "views/header.php"?>
<div class="newCardHolder">
    <div class="leftnavbarHolder" id="leftnavbarHolder">
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

