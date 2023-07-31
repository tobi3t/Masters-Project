<?php
session_start();
# database connection file
include("connection.php");
# functions file containing the getCurrentStreak function and others
include("functions.php");
# checking if the HTTP request is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  # getting the user_id from the session
  $userId = $_SESSION['user_id'];
  # getting the start date from the POST request
  $startDate = $_POST['startDate'];
  # preparing to check if the user already has streak data in the database
  $query = "SELECT * FROM streaks WHERE user_id = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param('i', $userId);
  $stmt->execute();
  $result = $stmt->get_result();
  # if the user already has a streak data in the database
  if ($result->num_rows > 0) {
    # using the getCurrentStreak function to get the value of the current streak in days
    $currentStreak = getCurrentStreak($conn, $userId);
    # insert the current streak duration for this particular user into the streak_history table
    $query = "INSERT INTO streak_history (streak_duration, user_id) VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('si', $currentStreak, $userId);
    $stmt->execute();
    # updating the streak start date in the streak table
    $query = "UPDATE streaks SET streak_start_date = ? WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('si', $startDate, $userId);
    $stmt->execute();
  } else {
    # if it is a new user without any streak data, a new date will be inserted into the streak table
    $query = "INSERT INTO streaks (user_id, streak_start_date) VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('is', $userId, $startDate);
    $stmt->execute();
  }
  # the user is redirected to the dashboard
  header('Location: dashboard.php');
  exit();
}
?>