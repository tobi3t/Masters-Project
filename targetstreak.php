<?php
session_start();

include("connection.php");

# checking if the HTTP request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  # getting the user ID from the session
  $userId = $_SESSION['user_id'];
  # getting the target streak from the POST data
  $targetStreak = $_POST['targetStreak'];
  # getting the current date
  $recordDate = date("Y-m-d");

  # checking if the user already has a target streak record
  $query = "SELECT * FROM target_streaks WHERE user_id = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param('i', $userId);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    # if a record exists, update the target streak
    $query = "UPDATE target_streaks SET target_streak = ?, record_date = ? WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('isi', $targetStreak, $recordDate, $userId);
    $stmt->execute();
  } else {
    # if no record exists, insert a new record with the target streak
    $query = "INSERT INTO target_streaks (user_id, target_streak, record_date) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('iis', $userId, $targetStreak, $recordDate);
    $stmt->execute();
  }
  # redirecting to the user dashboard after updating the target streak
  header('Location: dashboard.php');
  exit();
}
?>
