<?php 
$servername = "localhost";
$username ="root";
$password = "test123";
$db = "roozterdb";
//Create connection
$conn = mysqli_connect($servername,$username,$password,$db);

//check connection
if(!$conn){
    die("Connection failed: ".mysqli_connect_error());
}
?>