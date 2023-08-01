<?php
session_start();
include("connection.php");
# checking if the HTTP request is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    # getting the user_id from the session
    $userId = $_SESSION['user_id'];
    # getting the goal title and details from the POST request
    $title = $_POST['title'];
    $details = $_POST['details'];
    # preparing an INSERT statement to add the new goal
    $stmt = $conn->prepare('INSERT INTO goals (user_id, title, details) VALUES (?, ?, ?)');
    $stmt->bind_param('iss', $userId, $title, $details);
    # executing the INSERT statement to add the new goal
    if ($stmt->execute()) {
        $stmt->close();
        # preparing a SELECT statement to check if the user already has points in the user_points table
        $selectStmt = $conn->prepare('SELECT * FROM user_points WHERE user_id = ?');
        $selectStmt->bind_param('i', $userId);
        $selectStmt->execute();
        $result = $selectStmt->get_result();
        $selectStmt->close();
        # checking if the user has points in the user_points table
        if ($result->num_rows > 0) {
            # if the user has points, an UPDATE statement is prepared to add 2 points for goal setting
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
           # if the user has no points, an INSERT statement is prepare to add the user with the 2 points to the user_points table
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
