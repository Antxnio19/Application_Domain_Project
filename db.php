<?php
$servername = "your_database_endpoint"; // Replace with your RDS endpoint
$username = "your_db_username"; // Replace with your DB username
$password = "your_db_password"; // Replace with your DB password
$dbname = "your_db_name"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
