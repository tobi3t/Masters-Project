<?php
include("attachtop.php");
include("connection.php");
include("functions.php");
include("categoriesnav.php");
# checking if a specific category is selected via GET
if (isset($_GET['category_id'])) {
    $selected_category_id = $_GET['category_id'];
} else {
    # If no category is selected, redirect to the selectcategory.php page
    header("Location: selectcategory.php");
    exit;
}
?>

</div>
<div class="col-lg-8">
    <div class="card">

        <div class="card-header">
            <h4 class="card-title"><?php echo getCategoryName($conn, $selected_category_id); ?></h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div>
                    <!-- Form to post a Chat -->
                    <form method="post" action="post_chat.php" enctype="multipart/form-data">

                        <div class="mb-3">
                            <input type="hidden" name="category_id" value="<?php echo $selected_category_id; ?>">
                            <label for="content" class="form-label">Your Message:</label>
                            <textarea class="form-control" id="content" name="content" rows="1" required></textarea>
                        </div>

                        
                        <div class="mb-3">
                            <label for="chat_image" class="form-label">Attach Image (Optional):</label>
                            <input type="file" class="form-control" id="chat_image" name="chat_image">
                        </div>

                        <button type="submit" class="btn btn-primary">Post Chat</button>
                    </form><br>

                    <?php
                    # retrieving chat messages for the selected category
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
                            $chat_image = htmlspecialchars($row['chat_image']); 
                            # getting user information
                            $user = get_user_by_id($conn, $user_id);
                            $username = htmlspecialchars($user['username']);
                            # retrieving comments for the current chat message
                            $comments_sql = "SELECT * FROM comments WHERE message_id = ? ORDER BY creation_date";
                            $stmt = $conn->prepare($comments_sql);
                            $stmt->bind_param('i', $message_id);
                            $stmt->execute();
                            $comments_result = $stmt->get_result();
                            ?>
                            <!-- displaying the chat message and its comments -->
                            <div class="card mb-3">
                                <div class="card-header">
                                    <strong><?php echo $username; ?></strong>
                                    <span class="text-muted"><em class="white-text"><?php echo $creation_date; ?></em></span>
                                </div>
                                <div class="card-body">
                                    <?php echo $content; ?>
                                    <?php
                                    # displaying attached chat image (if previously uploaded)
                                    if (!empty($chat_image)) {
                                        echo '<br><img src="' . $chat_image . '" alt="Chat Image" class="img-fluid" style="max-width: 300px; max-height: 300px;">';
                                    }
                                    ?>
                                </div>
                                <div class="card-footer">
                                    <h6>Comments:</h6>
                                    <?php
                                    # displaying comments for the current chat message
                                    if ($comments_result->num_rows > 0) {
                                        while ($comment = $comments_result->fetch_assoc()) {
                                            $comment_content = $comment['content'];
                                            $comment_user_id = $comment['user_id'];
                                            $comment_creation_date = $comment['creation_date'];
                                            $comment_image = htmlspecialchars($comment['comment_image']); 
                                            # getting user information for the comment
                                            $comment_user = get_user_by_id($conn, $comment_user_id);
                                            $comment_username = $comment_user['username'];
                                            ?>
                                            <!-- displaying each comment and its attached image (if previously uploaded) -->
                                            <div class="mb-2">
                                                <strong><?php echo $comment_username; ?></strong>
                                                <span class="text-muted"><?php echo $comment_creation_date; ?></span>
                                                <p><?php echo $comment_content; ?></p>

                                                <?php
                                               
                                                if (!empty($comment_image)) {
                                                    echo '<img src="' . $comment_image . '" alt="Comment Image" class="img-fluid" style="max-width: 300px; max-height: 300px;">';
                                                }
                                                ?>
                                            </div>
                                            <?php
                                        }
                                    } else {
                                        echo "<p>No comments yet.</p>";
                                    }
                                    ?>
                                    <!-- Form to post a comment for the current chat message -->
                                    <form method="post" action="post_comment.php" enctype="multipart/form-data">
                                        <input type="hidden" name="category_id" value="<?php echo $selected_category_id; ?>">
                                        <input type="hidden" name="message_id" value="<?php echo $message_id; ?>">
                                        <div class="mb-3">
                                            <label for="comment_content" class="form-label">Your Comment:</label>
                                            <textarea class="form-control" id="comment_content" name="comment_content" rows="1" required></textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label for="comment_image" class="form-label">Attach Image (Optional):</label>
                                            <input type="file" class="form-control" id="comment_image" name="comment_image">
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
    </div>
</div>

<?php
include("attachbottom.php");
?>