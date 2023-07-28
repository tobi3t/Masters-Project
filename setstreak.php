<?php
session_start();

include("connection.php");
include("functions.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $userId = $_SESSION['user_id'];
  $startDate = $_POST['startDate'];

  $query = "SELECT * FROM streaks WHERE user_id = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param('i', $userId);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $currentStreak = getCurrentStreak($conn, $userId);

    $query = "INSERT INTO streak_history (streak_duration, user_id) VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('si', $currentStreak, $userId);
    $stmt->execute();

    $query = "UPDATE streaks SET streak_start_date = ? WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('si', $startDate, $userId);
    $stmt->execute();
  } else {
    $query = "INSERT INTO streaks (user_id, streak_start_date) VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('is', $userId, $startDate);
    $stmt->execute();
  }

  header('Location: dashboard.php');
  exit();
}
?>