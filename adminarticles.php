<?php
include("admintop.php");
?>

<div class="card-header">
    <h4 class="card-title">Manage Articles</h4>
</div>
<div class="card-body">
    <div class="row">

        <div class="container mt-4">
            <h1 class="mb-4">Articles</h1>
            <ul class="list-group">

            <?php
include("connection.php");

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, article_title FROM articles";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $article_id = $row["id"];
        $article_title = $row["article_title"];

        echo '<li class="list-group-item d-flex justify-content-between align-items-center">';
        echo $article_title;

        echo '<button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal' . $article_id . '">Delete</button>';

        echo '</li>';

        echo '<div class="modal fade" id="deleteModal' . $article_id . '" tabindex="-1" aria-labelledby="deleteModalLabel' . $article_id . '" aria-hidden="true">';
        echo '<div class="modal-dialog">';
        echo '<div class="modal-content">';
        echo '<div class="modal-header">';
        echo '<h5 class="modal-title" id="deleteModalLabel' . $article_id . '">Confirm Delete</h5>';
        echo '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
        echo '</div>';
        echo '<div class="modal-body">';
        echo 'Are you sure you want to delete the article "' . $article_title . '"?';
        echo '</div>';
        echo '<div class="modal-footer">';
        echo '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>';
        
        echo '<form action="delete_article.php" method="post">';
        echo '<input type="hidden" name="article_id" value="' . $article_id . '">';
        echo '<button type="submit" class="btn btn-danger">Confirm</button>';
        echo '</form>';
        
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo '<li class="list-group-item">No articles found.</li>';
}

$conn->close();
?>


            </ul>

            <h2 class="mt-4">Add New Article</h2>
            <form action="add_article.php" method="post">
                <div class="form-group">
                    <label for="title">Title:</label>
                    <input type="text" class="form-control" name="title" required>
                </div>
                <?php
                $user_id = $_SESSION['user_id'];
                echo '<input type="hidden" name="user_id" value="' . $user_id . '">';
            ?>
             <div class="form-group">
                <label for="body">Body:</label>
                <textarea class="form-control" name="body" required></textarea>
            </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
       

    </div>
</div>

<?php
include("attachbottom.php");
?>


