<?php

include("connection.php");

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$question_text = $_POST["question_text"];
$option1 = $_POST["option1"];
$option2 = $_POST["option2"];
$option3 = $_POST["option3"];
$option4 = $_POST["option4"];
$correct_option = $_POST["correct_option"];

session_start();
$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("INSERT INTO quiz (question_text, option1, option2, option3, option4, correct_option, admin_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssi", $question_text, $option1, $option2, $option3, $option4, $correct_option, $user_id);

if ($stmt->execute()) {
    header('Location: adminquiz.php');
} else {
    echo '<div class="alert alert-danger" role="alert">Error adding the quiz question: ' . $stmt->error . '</div>';
}

$stmt->close();
$conn->close();
?>



