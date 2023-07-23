<?php
include("connection.php");

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$article_id = $_POST["article_id"];

$stmt = $conn->prepare("DELETE FROM articles WHERE id = ?");
$stmt->bind_param("i", $article_id);

if ($stmt->execute()) {
    header('Location: adminarticles.php');
} else {
    echo '<div class="alert alert-danger" role="alert">Error deleting the article: ' . $stmt->error . '</div>';
}

$stmt->close();
$conn->close();
?>
