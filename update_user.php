<?php
// Database connection parameters
$servername = "localhost"; // Change if needed
$username = ""; // Replace with your database username
$password = "root"; // Replace with your database password
$dbname = "accounting_db"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve and sanitize input data
$user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
$first_name = isset($_POST['firstName']) ? $conn->real_escape_string($_POST['firstName']) : '';
$last_name = isset($_POST['lastName']) ? $conn->real_escape_string($_POST['lastName']) : '';
$address = isset($_POST['address']) ? $conn->real_escape_string($_POST['address']) : '';
$dob = isset($_POST['dob']) ? $conn->real_escape_string($_POST['dob']) : '';
$password = isset($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : '';
$position = isset($_POST['position']) ? $conn->real_escape_string($_POST['position']) : '';
$expiryPassword = isset($_POST['expiryPassword']) ? intval($_POST['expiryPassword']) : 0;

// Update user data
if ($user_id > 0) {
    $sql = "UPDATE UserTable SET first_name='$first_name', last_name='$last_name', address='$address', date_of_birth='$dob', password='$password', position='$position', password_expiry_duration='$expiryPassword' WHERE user_id=$user_id";

    if ($conn->query($sql) === TRUE) {
        echo "User updated successfully. <a href='user_roaster.php'>Go back to user list</a>";
    } else {
        echo "Error updating user: " . $conn->error;
    }
} else {
    echo "Invalid user ID.";
}

// Close the connection
$conn->close();
?>
