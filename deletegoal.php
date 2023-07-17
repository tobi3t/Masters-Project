<?php
session_start();

include("connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 
  $goalId = $_POST['goal_id'];

  $query = "DELETE FROM goals WHERE id = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param('i', $goalId);

  if ($stmt->execute()) {
    
    header('Location: dashboard.php');
    exit();
  } else {
    header('Location: dashboard.php');
  }

  $stmt->close();
}

$connection->close();
?>