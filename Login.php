<?php
session_start(); // Start the session at the very beginning
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Create connection
$conn = mysqli_connect("localhost", "root", "root", "accounting_db");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Only handle the POST request when the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get user input from POST request
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the user exists and is locked out
    $sql = "SELECT Password, FailedAttempts, LockoutUntil, UserTypeId FROM Table1 WHERE Username = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) { // Ensure $stmt was created successfully
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $hashedPassword = $user['Password'];
            $failedAttempts = $user['FailedAttempts'];
            $lockoutUntil = $user['LockoutUntil'];
            $userTypeId = $user['UserTypeId']; // Fetch the user type

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
                if ($stmt) { // Ensure $stmt was created successfully
                    $stmt->bind_param('s', $username);
                    $stmt->execute();
                }

                // Redirect to the specific home page based on user type
                switch ($userTypeId) {
                    case 'Accountant':
                        header('Location: Accountant_home.html');
                        break;
                    case 'Manager':
                        header('Location: manager_home.html');
                        break;
                    case 'Admin':
                        header('Location: Administrator_home.html');
                        break;
                    default:
                        $_SESSION['error'] = "Invalid user type."; // Set error message
                        header('Location: login.php'); // Redirect back to login page
                        break;
                }
                exit();
            } else {
                // Increment failed attempts
                $failedAttempts++;
                $lockoutUntil = ($failedAttempts >= 3) ? date('Y-m-d H:i:s', strtotime('+1 day')) : NULL;

                $sql = "UPDATE Table1 SET FailedAttempts = ?, LockoutUntil = ? WHERE Username = ?";
                $stmt = $conn->prepare($sql);
                if ($stmt) { // Ensure $stmt was created successfully
                    $stmt->bind_param('iss', $failedAttempts, $lockoutUntil, $username);
                    $stmt->execute();
                }

                $_SESSION['error'] = "Incorrect credentials."; // Set error message
                header('Location: login.php'); // Redirect back to login page
                exit();
            }
        } else {
            $_SESSION['error'] = "Incorrect credentials."; // Set error message for no user found
            header('Location: login.php'); // Redirect back to login page
            exit();
        }

        // Close the statement
        $stmt->close();
    } else {
        // Handle the case where statement preparation failed
        $_SESSION['error'] = "Database query error."; // Set error message
        header('Location: login.php'); // Redirect back to login page
        exit();
    }
}

// Close the connection
$conn->close();
?>
