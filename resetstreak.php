<?php
session_start();

include("connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $userId = $_SESSION['user_id'];
  $currentDate = date("Y-m-d");

  $query = "SELECT * FROM streaks WHERE user_id = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param('i', $userId);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $query = "UPDATE streaks SET streak_start_date = ? WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('si', $currentDate, $userId);
    $stmt->execute();
  } else {
    $query = "INSERT INTO streaks (user_id, streak_start_date) VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('is', $userId, $currentDate);
    $stmt->execute();
  }

  header('Location: dashboard.php');
  exit();
}
?>
