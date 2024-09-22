<?php
include('db.php');

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
$stmt->bind_param(':first_name', $first_name);
$stmt->bind_param(':last_name', $last_name);
$stmt->bind_param(':dob', $dob);
$stmt->bind_param(':email', $email);
$stmt->bind_param(':address', $address);
$stmt->bind_param(':username', $username);
$stmt->bind_param(':password', $hashedPassword);
$stmt->bind_param(':security_question', $security_question);
$stmt->bind_param(':security_answer', $security_answer);

if ($stmt->execute()) {
    // Redirect to the login page
    header('Location: login.html');
} else {
    echo "Failed to create user.";
}
?>
