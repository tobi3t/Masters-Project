<?php
session_start();
include("connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $userId = $_SESSION['user_id'];
  $title = $_POST['title'];
  $details = $_POST['details'];

  $query = "INSERT INTO goals (user_id, title, details) VALUES (?, ?, ?)";
  $stmt = $conn->prepare($query);
  $stmt->bind_param('iss', $userId, $title, $details);

  if ($stmt->execute()) {
    
    header('Location: goals.php');
    exit();
  } else {
    header('Location: goals.php');
  }

  $stmt->close();
}

$connection->close();
?>