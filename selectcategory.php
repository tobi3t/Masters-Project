<?php
include("attachtop.php");
include("connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['category_name'])) {
      $category_name = htmlspecialchars(trim($_POST['category_name']));

      $insert_sql = "INSERT INTO categories (name) VALUES (?)";
      $stmt = $conn->prepare($insert_sql);
      $stmt->bind_param('s', $category_name);
      if ($stmt->execute()) {
    
          header("Location: forum.php");
          exit;
      } else {
        header("Location: selectcategory.php");
      }
  }
}
?>

        </div>
        <div class="col-lg-8">
            <div class="card">


<div class="card-header">
  <h4 class="card-title">Select Chat Room</h4>
</div>
<div class="card-body">
  <div class="row">


  <?php
$category_sql = "SELECT * FROM categories";
$stmt = $conn->prepare($category_sql);
$stmt->execute();
$category_result = $stmt->get_result();
?>

<div class="card mb-4">
  <div class="card-body">
    <h5>Select a Chat Room:</h5>
    <ul class="list-group">
      <?php
      if ($category_result->num_rows > 0) {
        while ($category_row = $category_result->fetch_assoc()) {
          $category_name = htmlspecialchars($category_row['name']);
          $category_id = $category_row['category_id'];
          echo '<li class="list-group-item"><a href="forum.php?category_id=' . $category_id . '">' . $category_name . '</a></li>';
        }
      }
      ?>
    </ul>
  </div>
</div>
        

      
      <div class="card">
                    <div class="card-header">
                        <h5>Add a New Chat Room:</h5>
                    </div>
                  <div class="card-body">
                        <form method="post" action="selectcategory.php">
                            <div class="mb-3">
                                <label for="category_name" class="form-label">Room Name:</label>
                                <input type="text" class="form-control" id="category_name" name="category_name" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Add</button>
                        </form>
                    </div>
                </div>
            


  
  </div>
</div>

<?php
include("attachbottom.php");
?>