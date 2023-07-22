<?php
include("attachtop.php");
include("connection.php");
include("functions.php");
?>

<div class="card-header">
  <h4 class="card-title">Forum</h4>
</div>
<div class="card-body">
  <div class="row">
        <div>
        <form method="post" action="post_chat.php">
            <div class="mb-3">
                <label for="content" class="form-label">Your Message:</label>
                <textarea class="form-control" id="content" name="content" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Post Chat</button>
        </form><br>

        <?php
        $sql = "SELECT * FROM chat_messages ORDER BY creation_date DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $message_id = $row['message_id'];
                $content = $row['content'];
                $user_id = $row['user_id'];
                $creation_date = $row['creation_date'];

                $user = get_user_by_id($conn, $user_id);
                $username = $user['username'];

                $comments_sql = "SELECT * FROM comments WHERE message_id = $message_id ORDER BY creation_date";
                $comments_result = $conn->query($comments_sql);
                ?>

                <div class="card mb-3">
                    <div class="card-header">
                        <strong><?php echo $username; ?></strong>
                        <span class="text-muted"><?php echo $creation_date; ?></span>
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