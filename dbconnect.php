<?php
$server="localhost";
$user="root";
$password="anktv09";
$db="my_db";

$conn=mysqli_connect($server,$user,$password,$db);
if(!$conn){
die("connection error".mysqli_connect_error());
}

?>