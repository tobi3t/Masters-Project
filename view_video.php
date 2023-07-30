<?php
include("attachtop.php");
include("connection.php");
include("functions.php");

if (!isset($_SESSION['user_id'])) {

    header("Location: index.php");
    exit();
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $video_id = $_GET['id'];

    $user_id = $_SESSION['user_id'];
    $has_viewed = hasUserViewedVideo($conn, $user_id, $video_id);

    if (!$has_viewed) {
        $points_to_award = 10;
        $query = "UPDATE user_points SET points = points + ? WHERE user_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $points_to_award, $user_id);
        $stmt->execute();

        $query = "INSERT INTO video_views (user_id, video_id) VALUES (?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $user_id, $video_id);
        $stmt->execute();
    }

} else {
    header("Location: resources.php");
    exit();
}

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