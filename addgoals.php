<?php
session_start();
include("connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $userId = $_SESSION['user_id'];
    $title = $_POST['title'];
    $details = $_POST['details'];

    $stmt = $conn->prepare('INSERT INTO goals (user_id, title, details) VALUES (?, ?, ?)');
    $stmt->bind_param('iss', $userId, $title, $details);

    if ($stmt->execute()) {
        $stmt->close();

        $selectStmt = $conn->prepare('SELECT * FROM user_points WHERE user_id = ?');
        $selectStmt->bind_param('i', $userId);
        $selectStmt->execute();
        $result = $selectStmt->get_result();
        $selectStmt->close();

        if ($result->num_rows > 0) {
            
            $updateStmt = $conn->prepare('UPDATE user_points SET points = points + 2 WHERE user_id = ?');
            $updateStmt->bind_param('i', $userId);
            if ($updateStmt->execute()) {
                $updateStmt->close();
                header('Location: goals.php'); 
                exit();
            } else {
                echo 'Error updating points: ' . $updateStmt->error;
            }
        } else {
           
            $insertStmt = $conn->prepare('INSERT INTO user_points (user_id, points) VALUES (?, 2)');
            $insertStmt->bind_param('i', $userId);
            if ($insertStmt->execute()) {
                $insertStmt->close();
                header('Location: goals.php');
                exit();
            } else {
                echo 'Error inserting points: ' . $insertStmt->error;
            }
        }
    } else {
        echo 'Error adding goal: ' . $stmt->error;
    }

    $stmt->close();
}

$connection->close();
?>
