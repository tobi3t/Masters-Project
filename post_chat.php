<?php
session_start();
include("connection.php");
include("functions.php"); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION['user_id']) && isset($_POST['content']) && isset($_POST['category_id'])) {
        $user_id = $_SESSION['user_id'];
        $content = htmlspecialchars(trim($_POST['content']));
        $category_id = $_POST['category_id'];

       
        if (isset($_FILES['chat_image']) && $_FILES['chat_image']['error'] === UPLOAD_ERR_OK) {
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES['chat_image']['name']);

        
            $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
            $file_extension = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            if (!in_array($file_extension, $allowed_types)) {
               
            }

            if (move_uploaded_file($_FILES['chat_image']['tmp_name'], $target_file)) {
                $chat_image_path = $target_file;
            } else {
               
                $chat_image_path = null;
            }
        } else {
            $chat_image_path = null;
        }

        $sql = "INSERT INTO chat_messages (content, user_id, category_id, chat_image) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('siis', $content, $user_id, $category_id, $chat_image_path);

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
