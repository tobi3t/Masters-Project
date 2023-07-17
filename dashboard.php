<?php
include("attachtop.php");
?>

<div class="card-header">
  <h4 class="card-title">Dashboard</h4>
</div>
<div class="card-body">
  <div class="row">
  <?php
  
  include("connection.php");

  function getCurrentStreak($conn, $userId) {
  $query = "SELECT streak_start_date FROM streaks WHERE user_id = ? ORDER BY streak_start_date DESC LIMIT 1";
  $stmt = $conn->prepare($query);
  $stmt->bind_param('i', $userId);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $streakStartDate = $row['streak_start_date'];

    $presentDate = date("Y-m-d");
    $dateDiff = abs(strtotime($presentDate) - strtotime($streakStartDate));
    $currentStreak = floor($dateDiff / (60 * 60 * 24)); // Convert seconds to days

    return $currentStreak;
  }

  return 0;
}
?>
  <div class="col-md-6">
  <div class="mb-4">
    <h5 class="card-title">Streak</h5>
    <p class="card-text">
      Current streak: <h1><span id="currentStreak"><?php echo getCurrentStreak($conn, $_SESSION['user_id']); ?></span> days
      </h1></p>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#streakModal">Set Streak</button>
    <form action="resetstreak.php" method="POST" class="d-inline">
      <button type="submit" class="btn btn-danger">Reset Streak</button>
    </form>
  </div>
</div>
    <div class="col-md-6">
      <div class="mb-4">
        <h5 class="card-title">Progress</h5>
        <div class="progress">
          <div class="progress-bar bg-success" role="progressbar" style="width: 70%;" aria-valuenow="70"
            aria-valuemin="0" aria-valuemax="100">70%</div>
        </div>
      </div>
    </div>
  </div>
  <div class="row justify-content-center">
    <div class="col-md-4">
      <div class="mb-4 text-center">
        <h5 class="card-title">Points Earned</h5>
        <p class="display-1 font-weight-bold">1000</p>
      </div>
    </div>
  </div>
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="mb-4 d-flex flex-column align-items-center">
        <h5 class="card-title">Badges Earned</h5>
        <div class="h1 mb-3">
          <i class="bi bi-laptop"></i>
          <small class="text-center">WK</small>
        </div>
        <div class="h1 mb-3">
          <i class="bi bi-person-square"></i>
          <small class="text-center">MT</small>
        </div>
        <div class="h1 mb-3">
          <i class="bi bi-people"></i>
          <small class="text-center">YR</small>
        </div>
      </div>
    </div>

  </div>
  <div class="row">
    <div class="col-md-12">
    <div>
        <h5 class="card-title">Goals</h5>
        <ul class="list-group">
          <?php
          include ("connection.php");

          $userId = $_SESSION['user_id'];
          $query = "SELECT * FROM goals WHERE user_id = $userId";
          $result = mysqli_query($conn, $query);

          if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
              $goalId = $row['id'];
              $title = $row['title'];
          ?>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <?php echo $title; ?>
                <form action="deletegoal.php" method="POST" class="d-inline">
                  <input type="hidden" name="goal_id" value="<?php echo $goalId; ?>">
                  <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
              </li>
          <?php
            }
          } else {
            echo '<li class="list-group-item">No goals found.</li>';
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


<div class="modal fade" id="streakModal" tabindex="-1" aria-labelledby="streakModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="streakModalLabel">Set Streak Start Date</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="setstreak.php" method="POST">
          <div class="mb-3">
            <label for="startDateInput" class="form-label">Start Date</label>
            <input type="date" class="form-control" id="startDateInput" name="startDate" required>
          </div>
          <button type="submit" class="btn btn-primary">Save</button>
        </form>
      </div>
    </div>
  </div>
</div>