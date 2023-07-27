<?php
include("attachtop.php");
include("connection.php");
function get_user_by_id($conn, $user_id) {
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    return ($result->num_rows > 0) ? $result->fetch_assoc() : null;
}
?>



<div class="card mb-4">
            <div class="card-header">Welcome, <?php echo $firstname; ?></div>
            <div class="card-body">
              <ul class="list-group">
                <li class="list-group-item"><a href="welcome.php">Welcome</a></li>
                <li class="list-group-item"><a href="dashboard.php">Dashboard</a></li>
                <li class="list-group-item"><a href="goals.php">Goal Setting</a></li>
                <li class="list-group-item"><a href="forum.php">Forum</a></li>
                <li class="list-group-item"><a href="quiz.php">Quiz</a></li>
                <li class="list-group-item"><a href="resources.php">Resources</a></li>
                <li class="list-group-item"><a href="forumtwo.php">Forum 2.0</a></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-lg-8">
            <div class="card">

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