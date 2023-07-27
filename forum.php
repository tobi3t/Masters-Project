<?php
include("attachtop.php");
include("connection.php");
include("functions.php");
include("categoriesnav.php");

if (isset($_GET['category_id'])) {
    $selected_category_id = $_GET['category_id'];
} else {
    header("Location: selectcategory.php");
    exit;
}
?>

</div>
<div class="col-lg-8">
<div class="card">

<div class="card-header">
  <h4 class="card-title"><?php echo getCategoryName($conn, $selected_category_id); ?> Chat Room</h4>
</div>
<div class="card-body">
  <div class="row">
        <div>
        <form method="post" action="post_chat.php">
            
            <div class="mb-3">
                <input type="hidden" name="category_id" value="<?php echo $selected_category_id; ?>">
                <label for="content" class="form-label">Your Message:</label>
                <textarea class="form-control" id="content" name="content" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Post Chat</button>
        </form><br>

        <?php
        $sql = "SELECT * FROM chat_messages WHERE category_id = ? ORDER BY creation_date DESC";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $selected_category_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $message_id = htmlspecialchars($row['message_id']);
                $content = htmlspecialchars($row['content']);
                $user_id = htmlspecialchars($row['user_id']);
                $creation_date = htmlspecialchars($row['creation_date']);

                $user = get_user_by_id($conn, $user_id);
                $username = htmlspecialchars($user['username']);

                $comments_sql = "SELECT * FROM comments WHERE message_id = ? ORDER BY creation_date";
                $stmt = $conn->prepare($comments_sql);
                $stmt->bind_param('i', $message_id);
                $stmt->execute();
                $comments_result = $stmt->get_result();
                ?>

                <div class="card mb-3">
                    <div class="card-header">
                        <strong><?php echo $username; ?></strong>
                        <span class="text-muted"><em class="white-text"><?php echo $creation_date; ?></em></span>
                    </div>
                    <div class="card-body">
                        <?php echo $content; ?>
                    </div>
                    <div class="card-footer">
                        <h6>Comments:</h6>
                        <?php
                        if ($comments_result->num_rows > 0) {
                            while ($comment = $comments_result->fetch_assoc()) {
                                $comment_content = $comment['content'];
                                $comment_user_id = $comment['user_id'];
                                $comment_creation_date = $comment['creation_date'];

                                $comment_user = get_user_by_id($conn, $comment_user_id);
                                $comment_username = $comment_user['username'];
                                ?>
                                <div class="mb-2">
                                    <strong><?php echo $comment_username; ?></strong>
                                    <span class="text-muted"><?php echo $comment_creation_date; ?></span>
                                    <p><?php echo $comment_content; ?></p>
                                </div>
                                <?php
                            }
                        } else {
                            echo "<p>No comments yet.</p>";
                        }
                        ?>

                       
                        <form method="post" action="post_comment.php">
                            <input type="hidden" name="category_id" value="<?php echo $selected_category_id; ?>">
                            <input type="hidden" name="message_id" value="<?php echo $message_id; ?>">
                            <div class="mb-3">
                                <label for="comment_content" class="form-label">Your Comment:</label>
                                <textarea class="form-control" id="comment_content" name="comment_content" rows="2" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-secondary">Post Comment</button>
                        </form>
                    </div>
                </div>

                <?php
            }
        } else {
            echo "<p>No chat messages yet.</p>";
        }

        $conn->close();
        ?>
    </div>


  
  </div>
</div>

<?php
include("attachbottom.php");
?>