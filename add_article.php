<?php
include("connection.php");

# getting data from the form using POST method
$title = $_POST["title"];
$body = $_POST["body"];
$user_id = $_POST["user_id"];

# preparing a SQL statement for inserting data into the "articles" table
$stmt = $conn->prepare("INSERT INTO articles (article_title, article_body, user_id) VALUES (?, ?, ?)");
$stmt->bind_param("ssi", $title, $body, $user_id);

# executing the prepared statement
if ($stmt->execute()) {
    # If insertion is successful, redirect to "adminarticles.php"
    header('Location: adminarticles.php');
} else {
    # If there's an error, display an error message
    echo '<div class="alert alert-danger" role="alert">Error adding the article: ' . $stmt->error . '</div>';
}
# closing the prepared statement
$stmt->close();
# closing the database connection
$conn->close();
?>
