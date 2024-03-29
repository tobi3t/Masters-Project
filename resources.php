<?php
include("attachtop.php");
include("connection.php");
include("functions.php");

# getting articles and videos from the database
$articles = getArticles($conn);
$videos = getVideos($conn);
$conn->close();
?>

</div>
<div class="col-lg-8">
<div class="card">

<div class="card-header">
    <h4 class="card-title">Resources</h4>
</div>
<div class="card-body">
    <div class="row">
        <div class="container">
            <h4 class="mb-4">Articles</h4>
            <ul class="list-group">
                <?php if (!empty($articles)): ?>
                    <?php foreach ($articles as $article): ?>
                        <li class="list-group-item">
                            <!-- displaying article title with a link to the article page -->
                            <a href="article.php?id=<?php echo htmlspecialchars($article['id']); ?>&user_id=<?php echo htmlspecialchars($_SESSION['user_id']); ?>"><?php echo htmlspecialchars($article['article_title']); ?></a>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li class="list-group-item">No articles found.</li>
                <?php endif; ?>
            </ul>
        </div>
        <div class="container mt-4">
            <h4 class="mb-4">PDFs</h4>
            <ul class="list-group">
                <?php
                # scanning and displaying PDF files from the 'pdfs/' directory
                scanPdfFiles('pdfs/');
                ?>
            </ul>
        </div>


        <div class="container mt-4">
    <h4 class="mb-4">Videos</h4>
    <ul class="list-group">
        <?php if (!empty($videos)): ?>
            <?php foreach ($videos as $video): ?>
                <li class="list-group-item">
                    <!-- displaying video title with a link to the video page -->
                    <a href="view_video.php?id=<?php echo htmlspecialchars($video['id']); ?>"><?php echo htmlspecialchars($video['video_title']); ?></a>
                </li>
            <?php endforeach; ?>
        <?php else: ?>
            <li class="list-group-item">No videos found.</li>
        <?php endif; ?>
    </ul>
</div>


    </div>
</div>

<?php
include("attachbottom.php");
?>