<?php
require "main/init.php";
/**
 * Created by PhpStorm.
 * User: Sj
 * Date: 10/16/2023
 * Time: 12:36 AM
 */
//require "main/init.php";
//var_dump( $_SESSION );
if( isset( $_SESSION ) && $_SESSION['logged_in'] ){
    session_destroy();
    $_SESSION['logged_in'] = false;
    $_SESSION['user_data'] = [];
}

header('Location:index.php');