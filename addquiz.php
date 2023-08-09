<?php

include("connection.php");

# getting data from the form using POST method
$question_text = $_POST["question_text"];
$option1 = $_POST["option1"];
$option2 = $_POST["option2"];
$option3 = $_POST["option3"];
$option4 = $_POST["option4"];
$correct_option = $_POST["correct_option"];

# starting a session to access user data
session_start();
$user_id = $_SESSION['user_id'];

# preparing a SQL statement for inserting data into the "quiz" table
$stmt = $conn->prepare("INSERT INTO quiz (question_text, option1, option2, option3, option4, correct_option, admin_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
# binding the values to the prepared statement parameters
$stmt->bind_param("ssssssi", $question_text, $option1, $option2, $option3, $option4, $correct_option, $user_id);

# executing the prepared statement
if ($stmt->execute()) {
    # If insertion is successful, redirect to "adminquiz.php"
    header('Location: adminquiz.php');
} else {
    # If there's an error, display an error message
    echo '<div class="alert alert-danger" role="alert">Error adding the quiz question: ' . $stmt->error . '</div>';
}
# closing the prepared statement
$stmt->close();
# closing the database connection
$conn->close();
?>



