<?php
include('db.php');

$username = $_POST['username'];
$password = $_POST['password'];

// Check if the user is locked out
$sql = "SELECT Password, FailedAttempts, LockoutUntil FROM Table1 WHERE Username = :username";
$stmt = $conn->prepare($sql);
$stmt->bind_param(':username', $username);
$stmt->execute();
$user = $stmt->fetch();

if ($user) {
    $hashedPassword = $user['Password'];
    $failedAttempts = $user['FailedAttempts'];
    $lockoutUntil = $user['LockoutUntil'];

    if ($failedAttempts >= 3 && strtotime($lockoutUntil) > time()) {
        echo "Account is locked. Try again after " . $lockoutUntil;
        exit();
    }

    if (password_verify($password, $hashedPassword)) {
        // Reset failed attempts after a successful login
        $sql = "UPDATE Table1 SET FailedAttempts = 0, LockoutUntil = NULL WHERE Username = :username";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param(':username', $username);
        $stmt->execute();

        // Redirect to the home page
        header('Location: Accountant_home.html');
        exit();
    } else {
        // Increment failed attempts
        $failedAttempts++;
        $lockoutUntil = ($failedAttempts >= 3) ? date('Y-m-d H:i:s', strtotime('+15 minutes')) : NULL;

        $sql = "UPDATE Table1 SET FailedAttempts = :failedAttempts, LockoutUntil = :lockoutUntil WHERE Username = :username";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param(':failedAttempts', $failedAttempts);
        $stmt->bind_param(':lockoutUntil', $lockoutUntil);
        $stmt->bind_param(':username', $username);
        $stmt->execute();

        echo "Invalid username or password.";
    }
} else {
    echo "Invalid username or password.";
}
?>
