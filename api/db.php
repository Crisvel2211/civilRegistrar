<?php
$servername = "Localhost";
$username = "civi_civilRegistrar"; 
$password = "qq#^8rI3jHG6kKGp"; 
$dbname = "civi_civilRegistrar"; 
$socket = '/run/mysqld/mysqld.sock';

$conn = new mysqli($servername, $username, $password,$dbname, null, $socket);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
