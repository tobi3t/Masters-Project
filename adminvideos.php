<?php
include("admintop.php");
include("managevideos.php");
?>

<div class="card-header">
    <h4 class="card-title">Manage Videos</h4>
</div>
<div class="card-body">
    <div class="row">

        <div class="container">
            <!-- Add Video Form -->
            <h2>Add Video</h2>
            <?php if (isset($errorMessage)): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $errorMessage; ?>
                </div>
            <?php endif; ?>
            <form method="post">
                <div class="mb-3">
                    <label for="video_title" class="form-label">Video Title</label>
                    <input type="text" class="form-control" id="video_title" name="video_title" required>
                </div>
                <div class="mb-3">
                    <label for="video_embed_code" class="form-label">Video Embed Code</label>
                    <textarea class="form-control" id="video_embed_code" name="video_embed_code" rows="5" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary" name="add_video">Add Video</button>
            </form>
        </div>

        <div class="container mt-5">
            <!-- Video List Table -->
            <h2>Video List</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Video Title</th>
                        <th>Video Embed Code</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    # Looping through each video result and display it
                    while ($row = $result->fetch_assoc()) {
                        $videoId = $row['id'];
                        $videoTitle = sanitize($row['video_title']);
                        $videoEmbedCode = $row['video_embed_code'];
                        ?>
                        <tr>
                            <td><?php echo $videoTitle; ?></td>
                            <td><?php echo $videoEmbedCode; ?></td>
                            <td>
                                <!-- Delete Video Button and Modal -->
                                <form method="post" action="adminvideos.php">
                                    <input type="hidden" name="video_id" value="<?php echo $videoId; ?>">
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo $videoId; ?>">
                                        Delete
                                    </button>
                                    <!-- Delete Video Modal -->
                                    <div class="modal fade" id="deleteModal<?php echo $videoId; ?>" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to delete the video '<?php echo $videoTitle; ?>'?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" name="delete_video" class="btn btn-danger">Confirm</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
include("attachbottom.php");
?>
