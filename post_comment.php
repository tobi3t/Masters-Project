<?php
session_start();
require_once 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        $comment_content = $_POST['comment_content'];
        $message_id = $_POST['message_id'];
        $comment_content = htmlspecialchars(trim($comment_content));

        $sql = "INSERT INTO comments (content, user_id, message_id) VALUES ('$comment_content', $user_id, $message_id)";
        if ($conn->query($sql) === TRUE) {
            $update_points_sql = "UPDATE user_points SET points = points + 3 WHERE user_id = $user_id";
            if ($conn->query($update_points_sql) === TRUE) {
                header("Location: forum.php");
                exit;
            } else {
                echo "Error updating points: " . $conn->error;
            }
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        header('Location: signin.html');
        exit;
    }
}

$conn->close();
?>
