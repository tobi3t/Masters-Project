<?php
session_start();
include("connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user_id'];
    $goalId = $_POST['goal_id'];

    $updateStmt = $conn->prepare('UPDATE user_points SET points = points + 8 WHERE user_id = ?');
    $updateStmt->bind_param('i', $userId);

    $deleteStmt = $conn->prepare('DELETE FROM goals WHERE id = ? AND user_id = ?');
    $deleteStmt->bind_param('ii', $goalId, $userId);
    
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
