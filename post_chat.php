<?php
session_start();
include("connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION['user_id']) && isset($_POST['content']) && isset($_POST['category_id'])) {
        $user_id = $_SESSION['user_id'];
        $content = htmlspecialchars(trim($_POST['content']));
        $category_id = $_POST['category_id']; 

        $sql = "INSERT INTO chat_messages (content, user_id, category_id) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sii', $content, $user_id, $category_id);

        if ($stmt->execute()) {
            $update_points_sql = "UPDATE user_points SET points = points + 2 WHERE user_id = $user_id";
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
        header('Location: selectcategory.php');
        exit;
    }
}

$conn->close();
?>
