<?php

$servername = "localhost";
$username = "root";
$password = "";
$db = "library_system";

$conn = mysqli_connect($servername, $username, $password, $db, 3306);
if(!$conn){
    die("db connection failed. Error No:". mysqli_connect_errno()." Error:".mysqli_connect_error());
}