<?php
include("admintop.php");
include("connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_category_id'])) {
    $delete_category_id = $_POST['delete_category_id'];

     $delete_sql = "DELETE FROM categories WHERE category_id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param('i', $delete_category_id);
    if ($stmt->execute()) {
                header("Location: adminforum.php");
        exit;
    } else {
        header("Location: adminforum.php");
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['category_name'])) {
    $category_name = htmlspecialchars(trim($_POST['category_name']));

    $insert_sql = "INSERT INTO categories (name) VALUES (?)";
    $stmt = $conn->prepare($insert_sql);
    $stmt->bind_param('s', $category_name);
    if ($stmt->execute()) {
        header("Location: adminforum.php");
        exit;
    } else {
        header("Location: adminforum.php");
    }
}
?>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Manage Chat Rooms</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="card mb-4">
                    <div class="card-body">
                        <div>
                            <h5>Add a New Chat Rooms:</h5>
                        </div>
                        <form method="post" action="adminforum.php">
                            <div class="mb-3">
                                <label for="category_name" class="form-label">Chat Room Name:</label>
                                <input type="text" class="form-control" id="category_name" name="category_name" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Chat Room</button>
                        </form>
                    </div>
                </div>
                <?php
                $category_sql = "SELECT * FROM categories";
                $stmt = $conn->prepare($category_sql);
                $stmt->execute();
                $category_result = $stmt->get_result();
                ?>

                <div class="card mb-4">
                    <div class="card-body">
                        <h5>Delete a Chat Room:</h5>
                        <ul class="list-group">
                            <?php
                            if ($category_result->num_rows > 0) {
                                while ($category_row = $category_result->fetch_assoc()) {
                                    $category_name = htmlspecialchars($category_row['name']);
                                    $category_id = $category_row['category_id'];
                                    echo '<li class="list-group-item d-flex justify-content-between align-items-center">';
                                    echo '<a href="adminchatroom.php?category_id=' . $category_row['category_id'] . '">' . $category_name . '</a>';
                                    echo '<form method="post" action="adminforum.php" class="d-inline">';
                                    echo '<input type="hidden" name="delete_category_id" value="' . $category_id . '">';
                                    echo '<button type="submit" class="btn btn-danger btn-sm">Delete</button>';
                                    echo '</form>';
                                    echo '</li>';
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </div>
             </div>
        </div>
    </div>
</div>

<?php
include("attachbottom.php");
?>
