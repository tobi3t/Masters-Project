<?php
include("connection.php");


# getting the article ID from the POST request
$article_id = $_POST["article_id"];

# preparing the DELETE query to remove the article with the given ID
$stmt = $conn->prepare("DELETE FROM articles WHERE id = ?");
$stmt->bind_param("i", $article_id);

# executing the DELETE query and check if it was successful
if ($stmt->execute()) {
    # if successful, redirect to the admin articles page
    header('Location: adminarticles.php');
} else {
    # if there was an error, display an error message
    echo '<div class="alert alert-danger" role="alert">Error deleting the article: ' . $stmt->error . '</div>';
}

$stmt->close();
$conn->close();
?>
