<?php 
// databse credentials 
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'root');
define('DB_NAME', 'php_blog');

// attempt to connect 
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// check connection 
if ($link === false) {
    die("ERROR: Could not connect" . mysqli_connect_error());
}
?>