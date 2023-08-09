<?php
include("connection.php");

# checking if the HTTP request method is POST and if the 'delete_feedback' parameter is set in the POST data
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["delete_feedback"])) {
    # retrieving the feedback ID from the POST data
    $feedback_id = $_POST["delete_feedback"];
    # checking if there is a connection error to the database
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    # preparing a DELETE SQL query to remove the feedback with the given ID
    $sql = "DELETE FROM feedback WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $feedback_id);
    # executing the prepared statement
    if ($stmt->execute()) {
        # closing the statement and connection
        $stmt->close();
        $conn->close();

        # redirecting to the admin feedback page after successful deletion
        header("Location: adminfeedback.php");
        exit; # terminating script execution
    } else {
        # displaying an error message if there's an issue executing the SQL statement
        echo "Error deleting feedback: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    # if the conditions are not met, redirect to the admin feedback page
    header("Location: adminfeedback.php");
    exit;
}
?>
