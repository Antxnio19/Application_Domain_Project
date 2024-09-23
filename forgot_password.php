<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Create connection
$conn = mysqli_connect("localhost", "root", "root", "accounting_db");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get user input from POST request
$username = $_POST['username'];
$email = $_POST['email'];
$security_question = $_POST['securityQuestion']; // Ensure this matches the form input name
$security_answer = $_POST['securityAnswer']; // Ensure this matches the form input name

// Prepare the SQL statement to fetch user data
$sql = "SELECT Password, EmailAddress FROM Table1 WHERE Username = ? AND EmailAddress = ? AND SecurityQuestions = ? AND SecurityAnswers = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

// Bind parameters
$stmt->bind_param('ssss', $username, $email, $security_question, $security_answer);

// Debug output before executing
echo "Username: $username, Email: $email, Question: $security_question, Answer: $security_answer<br>";

// Execute the statement
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Fetch the password (it should be unhashed)
    $row = $result->fetch_assoc();
    $password = $row['Password'];

    // Send email
    $to = $email;
    $subject = "Your Password Recovery";
    $message = "Your password is: " . $password;
    $headers = "From: noreply@example.com";

    if (mail($to, $subject, $message, $headers)) {
        echo "Password has been sent to your email.";
        header('Location: login.html');
        exit();
    } else {
        echo "Error sending email.";
    }
} else {
    echo "No matching records found.";
}

// Close the statement and connection
$stmt->close();
$conn->close();

header("Location: forgot_password.html?error=" . urlencode($error_message));
exit();
?>