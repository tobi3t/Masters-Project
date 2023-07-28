<?php
include("attachtop.php");
include("connection.php");


if (!isset($_GET['id'])) {
    header("Location: resources.php");
    exit();
}

$articleId = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM articles WHERE id = ?");
$stmt->bind_param("i", $articleId);
$stmt->execute();
$result = $stmt->get_result();

$article = $result->fetch_assoc();
$stmt->close();

if (!$article) {
    header("Location: resources.php");
    exit();
}

$userId = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT * FROM resources WHERE user_id = ? AND article_id = ?");
$stmt->bind_param("ii", $userId, $articleId);
$stmt->execute();
$result = $stmt->get_result();


if ($result->num_rows === 0) {
    $stmt = $conn->prepare("INSERT INTO resources (user_id, article_id, point_earned) VALUES (?, ?, ?)");
    $stmt->bind_param("iii", $userId, $articleId, $pointsEarned);
    
    $pointsEarned = 10;
    
    $stmt->execute();
    $stmt->close();
    
    $stmt = $conn->prepare("UPDATE user_points SET points = points + ? WHERE user_id = ?");
    $stmt->bind_param("ii", $pointsEarned, $userId);
    $stmt->execute();
    $stmt->close();
}
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
            <h1><?php echo $article['article_title']; ?></h1>
            <p><?php echo $article['article_body']; ?></p>
            <a href="resources.php">Back to Resources</a>
        </div>
    </div>
</div>

<?php
include("attachbottom.php");
?>
