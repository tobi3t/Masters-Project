<?php
session_start();

include("connection.php");

# checking if the HTTP request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  # retrieving the goal ID from the POST data
  $goalId = $_POST['goal_id'];
  # preparing a DELETE SQL query to remove the goal with the given ID
  $query = "DELETE FROM goals WHERE id = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param('i', $goalId);
  # executing the prepared statement
  if ($stmt->execute()) {
    # redirecting to the dashboard page after successful deletion and exit the script
    header('Location: dashboard.php');
    exit();
  } else {
    # redirecting to the dashboard page if there's an issue executing the SQL statement
    header('Location: dashboard.php');
  }

  $stmt->close();
}

$connection->close();
?>