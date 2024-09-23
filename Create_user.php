<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Create connection
try {
    $conn = new PDO("sqlsrv:server=localhost;Database=your_db_name", "sa", "dcpomc21dcpomc21felka.");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$dob = $_POST['dob'];
$email = $_POST['email'];
$address = $_POST['address'];
$username = $_POST['username'];
$password = $_POST['password'];
$security_question = $_POST['security_question'];
$security_answer = $_POST['security_answer'];

// Hash the password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Insert user into the database
$sql = "INSERT INTO Table1 (FirstName, LastName, DateOfBirth, EmailAddress, Address, Username, Password, SecurityQuestions, SecurityAnswers)
        VALUES (:first_name, :last_name, :dob, :email, :address, :username, :password, :security_question, :security_answer)";

$stmt = $conn->prepare($sql);

$stmt->bindParam(':first_name', $first_name);
$stmt->bindParam(':last_name', $last_name);
$stmt->bindParam(':dob', $dob);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':address', $address);
$stmt->bindParam(':username', $username);
$stmt->bindParam(':password', $hashedPassword);
$stmt->bindParam(':security_question', $security_question);
$stmt->bindParam(':security_answer', $security_answer);

$stmt->execute();

header('Location: login.html');
?>
