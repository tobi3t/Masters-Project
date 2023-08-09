<?php
include("attachtop.php");
include("connection.php");

# checking if the 'id' parameter is set in the URL
if (!isset($_GET['id'])) {
    header("Location: resources.php");
    exit();
}

$articleId = $_GET['id'];

# retrieving the article information based on the 'id'
$stmt = $conn->prepare("SELECT * FROM articles WHERE id = ?");
$stmt->bind_param("i", $articleId);
$stmt->execute();
$result = $stmt->get_result();

$article = $result->fetch_assoc();
$stmt->close();

# if no article found, redirect to resources page
if (!$article) {
    header("Location: resources.php");
    exit();
}

$userId = $_SESSION['user_id'];

# checking if the user has already interacted with the article
$stmt = $conn->prepare("SELECT * FROM resources WHERE user_id = ? AND article_id = ?");
$stmt->bind_param("ii", $userId, $articleId);
$stmt->execute();
$result = $stmt->get_result();

# if the user hasn't interacted with the article
if ($result->num_rows === 0) {
    # inserting a new resource interaction and update user points
    $stmt = $conn->prepare("INSERT INTO resources (user_id, article_id, point_earned) VALUES (?, ?, ?)");
    $stmt->bind_param("iii", $userId, $articleId, $pointsEarned);
    
    $pointsEarned = 10;
    
    $stmt->execute();
    $stmt->close();
    # updating user points in user_points table
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
    <h4 class="card-title">Article</h4>
</div>
<div class="card-body">
    <div class="row">
        <div class="container">
            <!-- Display the article title and body -->
            <h1><?php echo $article['article_title']; ?></h1>
            <p><?php echo $article['article_body']; ?></p>
            <a href="resources.php">Back to Resources</a>
        </div>
    </div>
</div>

<?php
include("attachbottom.php");
?>
