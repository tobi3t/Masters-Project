<?php
session_start();
require_once 'connection.php';
include("functions.php"); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        $comment_content = $_POST['comment_content'];
        $message_id = $_POST['message_id'];
        $comment_content = htmlspecialchars(trim($comment_content));

        $category_id = $_POST['category_id'];

        
        if (isset($_FILES['comment_image']) && $_FILES['comment_image']['error'] === UPLOAD_ERR_OK) {
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES['comment_image']['name']);

           
            $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
            $file_extension = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            if (!in_array($file_extension, $allowed_types)) {
               
            }

            
            if (move_uploaded_file($_FILES['comment_image']['tmp_name'], $target_file)) {
                $comment_image_path = $target_file;
            } else {
               
                $comment_image_path = null;
            }
        } else {
            $comment_image_path = null;
        }

        $sql = "INSERT INTO comments (content, user_id, message_id, comment_image) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('siis', $comment_content, $user_id, $message_id, $comment_image_path);

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
