<div class="card mb-4">
  <div class="card-header">Chat Rooms</div>
    <div class="card-body">
        <ul class="list-group">
        <?php
        # SQL query to retrieve categories from the database
        $category_sql = "SELECT * FROM categories";
        $category_result = $conn->query($category_sql);
        # checking if there are categories in the result
        if ($category_result->num_rows > 0) {
            # looping through each category and display it as a list item
            while ($category_row = $category_result->fetch_assoc()) {
            $category_name = htmlspecialchars($category_row['name']);
            # displaying the category name as a link to the corresponding forum page
            echo '<li class="list-group-item"><a href="forum.php?category_id=' . $category_row['category_id'] . '">' . $category_name . '</a></li>';
            }
        }
        ?>
        </ul>
  </div>
</div>
