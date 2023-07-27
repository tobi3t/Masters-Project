<?php
include("attachtop.php");
include("connection.php");
?>

        </div>
        <div class="col-lg-8">
            <div class="card">


<div class="card-header">
  <h4 class="card-title">Select Category</h4>
</div>
<div class="card-body">
  <div class="row">





  <?php
$category_sql = "SELECT * FROM categories";
$category_result = $conn->query($category_sql);
?>

<div class="card mb-4">
  <div class="card-body">
    <h5>Select a Category:</h5>
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
        

        


  
  </div>
</div>

<?php
include("attachbottom.php");
?>