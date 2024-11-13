<?php
$server = "localhost";
$uid = "root";
$pwd = "";
$dbname = "test";
$conn = new mysqli($server,$uid,$pwd,$dbname);

if($conn->connect_error)
{
    die("Data base connection error ".$conn->connect_error);
}

?>