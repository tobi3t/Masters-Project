<?php
include("attachtop.php");
include("connection.php");
?>

</div>
<div class="col-lg-8">
    <div class="card h-100">
        <div class="card-header">
            <h4 class="card-title">View Video</h4>
        </div>
        <div class="card-body d-flex flex-column justify-content-center align-items-center">
            <?php
        
            include("connection.php");
            
            $videoId = $_GET['id'];
            $safeVideoId = $conn->real_escape_string($videoId);
            
            $sql = "SELECT * FROM videos WHERE id = '$safeVideoId'";
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
                $video = $result->fetch_assoc();
                $videoTitle = htmlspecialchars($video['video_title']);
                $videoEmbedCode = $video['video_embed_code'];
                
                echo '<h3 class="mb-4">' . $videoTitle . '</h3>';
                echo '<div class="embed-responsive embed-responsive-16by9">';
                echo $videoEmbedCode; 
                echo '</div>';
            } else {
                echo '<p class="text-danger">Video not found.</p>';
            }
            
            $conn->close();
            ?>
            <br>
            <a href="resources.php" class="btn btn-primary">Back to Resources</a>
        </div>
    </div>
</div>

<?php
include("attachbottom.php");
?>