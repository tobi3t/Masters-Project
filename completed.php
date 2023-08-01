<?php
session_start();
include("connection.php");
# checking if the HTTP request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    # getting the user_id from the session
    $userId = $_SESSION['user_id'];
    # getting the goal id from the POST request to identify the specific goal
    $goalId = $_POST['goal_id'];
    # preparing an UPDATE statement to increase the point of the user by 8 for completing the goal
    $updateStmt = $conn->prepare('UPDATE user_points SET points = points + 8 WHERE user_id = ?');
    $updateStmt->bind_param('i', $userId);
    # preparing a DELETE statement to remove the goal from the goals table
    $deleteStmt = $conn->prepare('DELETE FROM goals WHERE id = ? AND user_id = ?');
    $deleteStmt->bind_param('ii', $goalId, $userId);
    # executing both the UPDATE and DELETE statements together
    if ($updateStmt->execute() && $deleteStmt->execute()) {
        $updateStmt->close();
        $deleteStmt->close();

        header('Location: dashboard.php');
        exit();
    } else {
        echo 'Error updating points or deleting goal: ' . $updateStmt->error . ' ' . $deleteStmt->error;
    }
}

$conn->close();
?>
