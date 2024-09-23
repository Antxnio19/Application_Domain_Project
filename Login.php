<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Create connection
$conn = mysqli_connect("localhost", "root", "root", "accounting_db");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Start a session to store error messages
session_start();

// Get user input from POST request
$username = $_POST['username'];
$password = $_POST['password'];

// Check if the user exists and is locked out
$sql = "SELECT Password, FailedAttempts, LockoutUntil FROM Table1 WHERE Username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $hashedPassword = $user['Password'];
    $failedAttempts = $user['FailedAttempts'];
    $lockoutUntil = $user['LockoutUntil'];

    // Check if the account is locked
    if ($failedAttempts >= 3 && strtotime($lockoutUntil) > time()) {
        $_SESSION['error'] = "Account is locked. Try again after " . date('Y-m-d H:i:s', strtotime($lockoutUntil));
        header('Location: login.php'); // Redirect back to login page
        exit();
    }

    // Verify password
    if (password_verify($password, $hashedPassword)) {
        // Reset failed attempts after a successful login
        $sql = "UPDATE Table1 SET FailedAttempts = 0, LockoutUntil = NULL WHERE Username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $username);
        $stmt->execute();

        // Redirect to the administrator home page
        header('Location: administrator_home.html');
        exit();
    } else {
        // Increment failed attempts
        $failedAttempts++;
        $lockoutUntil = ($failedAttempts >= 3) ? date('Y-m-d H:i:s', strtotime('+1 day')) : NULL;

        $sql = "UPDATE Table1 SET FailedAttempts = ?, LockoutUntil = ? WHERE Username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('iss', $failedAttempts, $lockoutUntil, $username);
        $stmt->execute();

        $_SESSION['error'] = "Invalid username or password."; // Set error message
        header('Location: login.php'); // Redirect back to login page
        exit();
    }
} else {
    $_SESSION['error'] = "Invalid username or password."; // Set error message for no user found
    header('Location: login.php'); // Redirect back to login page
    exit();
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>