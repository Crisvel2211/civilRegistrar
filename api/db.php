<?php
$servername = "localhost";
$username = "root"; // Your database username
$password = "L@ndom@y132001"; // Your database password
$dbname = "Capstone"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
