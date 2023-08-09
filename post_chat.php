<?php
session_start();
include("connection.php");
include("functions.php"); 

# checking if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    # checking if user is logged in and necessary POST data is set
    if (isset($_SESSION['user_id']) && isset($_POST['content']) && isset($_POST['category_id'])) {
        # extracting data from POST
        $user_id = $_SESSION['user_id'];
        $content = htmlspecialchars(trim($_POST['content']));
        $category_id = $_POST['category_id'];

        # checking if an image file was uploaded
        if (isset($_FILES['chat_image']) && $_FILES['chat_image']['error'] === UPLOAD_ERR_OK) {
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES['chat_image']['name']);

            # defining allowed image types
            $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
            $file_extension = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            # checking if uploaded file's extension is in allowed types
            if (!in_array($file_extension, $allowed_types)) {
               # handle invalid file types if needed
            }

            # moving the uploaded image to the target directory
            if (move_uploaded_file($_FILES['chat_image']['tmp_name'], $target_file)) {
                $chat_image_path = $target_file;
            } else {
                # handling image upload failure if needed
                $chat_image_path = null;
            }
        } else {
            $chat_image_path = null;
        }
        # inserting message data into the database
        $sql = "INSERT INTO chat_messages (content, user_id, category_id, chat_image) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('siis', $content, $user_id, $category_id, $chat_image_path);

        if ($stmt->execute()) {
            # updating user's points after successful message insertion
            $update_points_sql = "UPDATE user_points SET points = points + 2 WHERE user_id = $user_id";
            if ($conn->query($update_points_sql) === TRUE) {
                # redirecting to the forum page with the updated category
                header("Location: forum.php?category_id=$category_id");
                exit;
            } else {
                echo "Error updating points: " . $conn->error;
            }
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        # redirecting to category selection page if necessary data is missing
        header('Location: selectcategory.php');
        exit;
    }
}

$conn->close();
?>
