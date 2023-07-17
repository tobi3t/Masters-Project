<?php
include("attachtop.php");
?>

<div class="card-header">
  <h4 class="card-title">Manage Goals</h4>
</div>

<?php
include("connection.php");

$userId = $_SESSION['user_id'];
$query = "SELECT * FROM goals WHERE user_id = $userId";
$result = mysqli_query($conn, $query);

?>

<div class="card-body">
  <div id="accordion">

    <?php
  
    while ($row = mysqli_fetch_assoc($result)) {
      $goalId = $row['id'];
      $title = $row['title'];
      $details = $row['details'];
    ?>

      <div class="accordion-item">
        <h2 class="accordion-header" id="heading<?php echo $goalId; ?>">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#collapse<?php echo $goalId; ?>" aria-expanded="false"
            aria-controls="collapse<?php echo $goalId; ?>">
            <?php echo $title; ?>
          </button>
        </h2>
        <div id="collapse<?php echo $goalId; ?>" class="accordion-collapse collapse"
          aria-labelledby="heading<?php echo $goalId; ?>" data-bs-parent="#accordion">
          <div class="accordion-body">
            <?php echo $details; ?>
          </div>
        </div>
      </div>

    <?php
    }
    ?>

  </div>
  <div class="mt-4">
      <h5>Add New Goal</h5>
      <form action="addgoals.php" method="POST">
        <div class="mb-3">
          <label for="title" class="form-label">Title</label>
          <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="mb-3">
          <label for="details" class="form-label">Details</label>
          <textarea class="form-control" id="details" name="details"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Add Goal</button>
      </form>
    </div>
</div>

<?php
include("attachbottom.php");
?>