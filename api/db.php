<?php
$servername = "Localhost";
$username = "civi_group69"; 
$password = "dH7tlg@9xlp%1iCm"; 
$dbname = "civi_civilRegistrar"; 
$socket = '/run/mysqld/mysqld.sock';

$conn = new mysqli($servername, $username, $password,$dbname, null, $socket);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
