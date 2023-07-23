<?php
include("connection.php");

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$title = $_POST["title"];
$body = $_POST["body"];
$user_id = $_POST["user_id"];

$stmt = $conn->prepare("INSERT INTO articles (article_title, article_body, user_id) VALUES (?, ?, ?)");
$stmt->bind_param("ssi", $title, $body, $user_id);

if ($stmt->execute()) {
    header('Location: adminarticles.php');
} else {
    echo '<div class="alert alert-danger" role="alert">Error adding the article: ' . $stmt->error . '</div>';
}

$stmt->close();
$conn->close();
?>
