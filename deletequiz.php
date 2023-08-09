<?php
include("connection.php");

# retrieving the question ID from the POST data
$question_id = $_POST["question_id"];

# preparing a DELETE SQL query to remove the quiz question with the given question ID
$stmt = $conn->prepare("DELETE FROM quiz WHERE question_id = ?");
$stmt->bind_param("i", $question_id);

# executing the prepared statement
if ($stmt->execute()) {
    # redirecting to the admin quiz page after successful deletion
    header("Location: adminquiz.php");
} else {
    # displaying an error message if there's an issue executing the SQL statement
    echo '<div class="alert alert-danger" role="alert">Error deleting the quiz question: ' . $stmt->error . '</div>';
}

$stmt->close();
$conn->close();
?>
