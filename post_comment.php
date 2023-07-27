<?php
session_start();
require_once 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        $comment_content = $_POST['comment_content'];
        $message_id = $_POST['message_id'];
        $comment_content = htmlspecialchars(trim($comment_content));

        $category_id = $_POST['category_id'];

        $sql = "INSERT INTO comments (content, user_id, message_id) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sii', $comment_content, $user_id, $message_id);

        if ($stmt->execute()) {
            $update_points_sql = "UPDATE user_points SET points = points + 3 WHERE user_id = $user_id";
            if ($conn->query($update_points_sql) === TRUE) {
                header("Location: forum.php?category_id=$category_id");
                exit;
            } else {
                echo "Error updating points: " . $conn->error;
            }
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        header('Location: signin.html');
        exit;
    }
}

$conn->close();
?>
