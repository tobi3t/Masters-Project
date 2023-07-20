<?php
include("attachtop.php");
?>

<?php
include("connection.php");

$stmt = $conn->prepare("SELECT * FROM articles");
$stmt->execute();
$result = $stmt->get_result();

$articles = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$conn->close();
?>

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
                        <a href="article.php?id=<?php echo $article['id']; ?>&user_id=<?php echo $_SESSION['user_id']; ?>"><?php echo $article['article_title']; ?></a>
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
            <li class="list-group-item">
            
                <a href="download_pdf.php?pdf=sample1.pdf">Sample 1</a>
            </li>
            <li class="list-group-item">
            
                <a href="download_pdf.php?pdf=sample2.pdf">Sample 2</a>
            </li>
        </ul>
    </div>



    </div>
</div>

<?php
include("attachbottom.php");
?>
