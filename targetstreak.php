<?php
session_start();

include("connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $userId = $_SESSION['user_id'];
  $targetStreak = $_POST['targetStreak'];
  $recordDate = date("Y-m-d");

  $query = "SELECT * FROM target_streaks WHERE user_id = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param('i', $userId);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $query = "UPDATE target_streaks SET target_streak = ?, record_date = ? WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('isi', $targetStreak, $recordDate, $userId);
    $stmt->execute();
  } else {
    $query = "INSERT INTO target_streaks (user_id, target_streak, record_date) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('iis', $userId, $targetStreak, $recordDate);
    $stmt->execute();
  }

  header('Location: dashboard.php');
  exit();
}
?>
