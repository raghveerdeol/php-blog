<?php 
// databse credentials 
$servername = 'localhost';
$username = 'root';
$password = 'root';
$databasename = 'php_blog';

// attempt to connect 
$link = new mysqli($servername, $username, $password, $databasename);

// check connection 
if ($link === false) {
    die("ERROR: Could not connect" . mysqli_connect_error());
}
?>