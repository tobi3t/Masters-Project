<?php
include("attachtop.php");
include("connection.php");
include("functions.php");
# retrieving user ID from the session
$userId = $_SESSION['user_id'];
# calling the function to get user goals and store output in a session variable
$result = getUserGoals($conn, $userId);
?>

</div>
<div class="col-lg-8">
<div class="card">

<div class="card-header">
  <h4 class="card-title">Set Goals</h4>
</div>

<div class="card-body">
  <!-- Accordion for displaying goals -->
  <div id="accordion">

    <?php
    # looping through each goal fetched from the database
    while ($row = mysqli_fetch_assoc($result)) {
      $goalId = $row['id'];
      $title = $row['title'];
      $details = $row['details'];
    ?>

    <div class="accordion-item">
      <h2 class="accordion-header" id="heading<?php echo $goalId; ?>">
        <!-- Accordion button that toggles the goal details -->
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
          data-bs-target="#collapse<?php echo $goalId; ?>" aria-expanded="false"
          aria-controls="collapse<?php echo $goalId; ?>">
          <?php echo $title; ?>
        </button>
      </h2>
      <div id="collapse<?php echo $goalId; ?>" class="accordion-collapse collapse"
        aria-labelledby="heading<?php echo $goalId; ?>" data-bs-parent="#accordion">
        <div class="accordion-body">
          <!-- Display goal details inside the accordion body -->
          <?php echo $details; ?>
        </div>
      </div>
    </div>

    <?php
    }
    ?>

  </div>
  <div class="row">
    <div class="col-md-9">
      <div class="mt-4">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Add New Goal</h4>
          </div>
          <div class="card-body">
            <!-- Form to add a new goal -->
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
      </div>
    </div>
    <div class="col-md-3">
      <div class="card mt-4">
        <div class="card-header">
          <h4 class="card-title">Target Streak Setter</h4>
        </div>
        <div class="card-body">
          <!-- Form to set target streak for user -->
          <form action="targetstreak.php" method="POST">
            <div class="mb-3">
              <label for="targetStreak" class="form-label">Target Streak (in days)</label>
              <input type="number" class="form-control" id="targetStreak" name="targetStreak" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Set Target Streak</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</div>

<?php
include("attachbottom.php");
?>
