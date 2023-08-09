<?php

# checking if the form for deleting a video has been submitted
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["delete_video"])) {
    
    # getting the video ID to be deleted from the form submission
    $videoId = $_POST["video_id"];
    
    # SQL query to delete the video with the given ID
    $sql = "DELETE FROM videos WHERE id = $videoId";
    
    # checking if the deletion query executed successfully
    if ($conn->query($sql) === TRUE) {
        # redirecting to the admin videos page after successful deletion
        header("Location: adminvideos.php");
        exit();
    } else {
        # storing an error message if deletion was not successful
        $errorMessage = "Error deleting video: " . $conn->error;
    }
}

# function to sanitize input data to prevent XSS attacks
function sanitize($input)
{
    return htmlspecialchars($input);
}

# checking if the form for adding a video has been submitted
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["add_video"])) {
    # getting and sanitizing the video title from the form submission
    $videoTitle = $_POST['video_title'];
    $safeVideoTitle = sanitize($videoTitle);

    # getting and escaping the video embed code from the form submission
    $videoEmbedCode = $_POST['video_embed_code'];
    $safeVideoEmbedCode = $conn->real_escape_string($videoEmbedCode);

    # SQL query to insert a new video with sanitized values
    $sql = "INSERT INTO videos (video_title, video_embed_code) VALUES ('$safeVideoTitle', '$safeVideoEmbedCode')";

    # checking if the insertion query executed successfully
    if ($conn->query($sql) === TRUE) {
        # redirecting to the admin videos page after successful insertion
        header("Location: adminvideos.php");
        exit();
    } else {
        # storing an error message if insertion was not successful
        $errorMessage = "Error: " . $conn->error;
    }
}

# SQL query to retrieve all videos from the database
$sql = "SELECT * FROM videos";
$result = $conn->query($sql);
?>