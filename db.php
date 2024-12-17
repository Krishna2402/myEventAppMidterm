<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "myevent_db";  // Ensure your database is named 'myevent_db'

$conn = new mysqli($servername, $username, $password, $dbname);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
