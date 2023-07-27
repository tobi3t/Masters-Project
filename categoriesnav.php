<div class="card mb-4">
  <div class="card-header">Chat Rooms</div>
    <div class="card-body">
        <ul class="list-group">
        <?php
        $category_sql = "SELECT * FROM categories";
        $category_result = $conn->query($category_sql);

        if ($category_result->num_rows > 0) {
            while ($category_row = $category_result->fetch_assoc()) {
            $category_name = htmlspecialchars($category_row['name']);
            echo '<li class="list-group-item"><a href="forum.php?category_id=' . $category_row['category_id'] . '">' . $category_name . '</a></li>';
            }
        }
        ?>
        </ul>
  </div>
</div>
