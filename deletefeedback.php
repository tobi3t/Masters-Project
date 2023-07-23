<?php
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["delete_feedback"])) {
    $feedback_id = $_POST["delete_feedback"];

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "DELETE FROM feedback WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $feedback_id);

    if ($stmt->execute()) {

        $stmt->close();
        $conn->close();
        header("Location: adminfeedback.php");
        exit;
    } else {
        echo "Error deleting feedback: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: adminfeedback.php");
    exit;
}
?>
