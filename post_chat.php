<?php
session_start();
require_once 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        $content = $_POST['content'];

        $content = htmlspecialchars(trim($content));

        $sql = "INSERT INTO chat_messages (content, user_id) VALUES ('$content', $user_id)";
        if ($conn->query($sql) === TRUE) {
            $update_points_sql = "UPDATE user_points SET points = points + 2 WHERE user_id = $user_id";
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
