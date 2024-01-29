<?php
require_once "database/connect.php";
require_once "functions/allfunctions.php";
session_start();

$domainName = $_SERVER['HTTP_HOST'];

define( 'domainName', $domainName );

//var_test_die( $_SERVER );