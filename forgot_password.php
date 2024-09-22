<?php
include('db.php');

$username = $_POST['username'];
$email = $_POST['email'];
$security_question = $_POST['security_question'];
$security_answer = $_POST['security_answer'];

// Check if the user exists and matches the security question and answer
$sql = "SELECT * FROM Table1 WHERE Username = :username AND EmailAddress = :email AND SecurityQuestions = :security_question AND SecurityAnswers = :security_answer";
$stmt = $conn->prepare($sql);
$stmt->bind_param(':username', $username);
$stmt->bind_param(':email', $email);
$stmt->bind_param(':security_question', $security_question);
$stmt->bind_param(':security_answer', $security_answer);
$stmt->execute();

if ($stmt->bind_param() == 1) {
    echo "Password reset instructions sent to your email.";
    // Redirect to login for now
    header('Location: login.html');
} else {
    echo "Invalid credentials.";
}
?>
