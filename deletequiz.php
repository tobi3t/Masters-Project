<?php
include("connection.php");

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$question_id = $_POST["question_id"];

$stmt = $conn->prepare("DELETE FROM quiz WHERE question_id = ?");
$stmt->bind_param("i", $question_id);

if ($stmt->execute()) {
    header("Location: adminquiz.php");
} else {
    echo '<div class="alert alert-danger" role="alert">Error deleting the quiz question: ' . $stmt->error . '</div>';
}

$stmt->close();
$conn->close();
?>
