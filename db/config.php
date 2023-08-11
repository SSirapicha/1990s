<?php

$host = "localhost"; 
$user = "root"; 
$password = ""; 
$dbname = "db";

$conn = mysqli_connect($host, $user, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

/*
// Heroku config
$db_host = "us-cdbr-east-06.cleardb.net";
$db_user = "b8d92482bf5c18";
$db_pass = "b1bdb868";
$db_name = "heroku_31947c7094e0a85";

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name) or die("database connection error");
*/
?>