<?php

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["delete_video"])) {
    
    $videoId = $_POST["video_id"];
    
    
    $sql = "DELETE FROM videos WHERE id = $videoId";
    if ($conn->query($sql) === TRUE) {
       
        header("Location: adminvideos.php");
        exit();
    } else {
       
        $errorMessage = "Error deleting video: " . $conn->error;
    }
}


function sanitize($input)
{
    return htmlspecialchars($input);
}


if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["add_video"])) {
    $videoTitle = $_POST['video_title'];
    $safeVideoTitle = sanitize($videoTitle);

    $videoEmbedCode = $_POST['video_embed_code'];
    $safeVideoEmbedCode = $conn->real_escape_string($videoEmbedCode);

    $sql = "INSERT INTO videos (video_title, video_embed_code) VALUES ('$safeVideoTitle', '$safeVideoEmbedCode')";

    if ($conn->query($sql) === TRUE) {
        header("Location: adminvideos.php");
        exit();
    } else {
        $errorMessage = "Error: " . $conn->error;
    }
}


$sql = "SELECT * FROM videos";
$result = $conn->query($sql);
?>