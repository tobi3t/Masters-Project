<?php
include("admintop.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
   
    $videoTitle = $_POST['video_title'];
    $safeVideoTitle = htmlspecialchars($videoTitle);
    
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

?>

<div class="card-header">
    <h4 class="card-title">Manage Articles</h4>
</div>
<div class="card-body">
    <div class="row">

        <div class="container mt-4">
            
        <h2>Add Video</h2>
        <?php if (isset($errorMessage)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $errorMessage; ?>
            </div>
        <?php endif; ?>
        <form method="post">
            <div class="mb-3">
                <label for="video_title" class="form-label">Video Title</label>
                <input type="text" class="form-control" id="video_title" name="video_title" required>
            </div>
            <div class="mb-3">
                <label for="video_embed_code" class="form-label">Video Embed Code</label>
                <textarea class="form-control" id="video_embed_code" name="video_embed_code" rows="5" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Add Video</button>
        </form>

        </div>
       

    </div>
</div>

<?php
include("attachbottom.php");
?>