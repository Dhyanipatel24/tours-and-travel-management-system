<?php
$host = "localhost:3307";  
$user = "root";
$pass = "";                
$db   = "tours_travels";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
