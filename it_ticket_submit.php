<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Create connection
$conn = mysqli_connect("localhost", "root", "root", "accounting_db");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get data from the form
$name = $_POST['name'];
$email = $_POST['email'];
$issue = $_POST['issue'];
$priority = $_POST['priority'];

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO ticketsTable (name, email, issue, priority) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $name, $email, $issue, $priority);

// Execute the statement
if ($stmt->execute()) {
    $message = "New ticket created successfully. Ticket ID: " . $stmt->insert_id; // Retrieve the last inserted ID
} else {
    $message = "Error: " . $stmt->error;
}

// Close connections
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redirecting...</title>
    <script>
        console.log("<?php echo addslashes($message); ?>"); // Log the message to the console
        window.location.href = './administrator_home.html'; // Redirect to home page
    </script>
</head>
<body>
    <p>Redirecting...</p>
</body>
</html>

