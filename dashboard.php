<?php
include("attachtop.php");
include("functions.php");
include("connection.php");
?>

<div class="card-header">
  <h4 class="card-title">Dashboard</h4>
</div>
<div class="card-body">
  <div class="row justify-content-center">
    <div class="col-md-4">
      <div class="mb-4 text-center">
        <h5 class="card-title">Points Earned</h5>
        <p class="display-1 font-weight-bold">
          <?php

          $userId = $_SESSION['user_id'];
            $query = "SELECT points FROM user_points WHERE user_id = $userId";
            $result = mysqli_query($conn, $query);
            
            if ($result && mysqli_num_rows($result) > 0) {
              $row = mysqli_fetch_assoc($result);
              $points = $row['points'];
              echo $points;
            } else {
              echo '0'; 
            }
          ?>
        </p>
      </div>
    </div>
  </div>
</div>
<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="mb-4 text-center border rounded p-4">
      <h5 class="card-title">Streak Counter and Setter</h5>
      <p class="card-text">Current streak:</p>
      <h1>
        <span id="currentStreak">
          <?php echo getCurrentStreak($conn, $_SESSION['user_id']); ?>
        </span> days
      </h1>
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#streakModal">Pick a Date</button>
      <form action="resetstreak.php" method="POST" class="d-inline">
        <button type="submit" class="btn btn-danger">Reset to Today</button>
      </form>
    </div>
  </div>
</div>


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


<div class="row justify-content-center">
  <div class="col-md-4">
    <div class="mb-4 text-center">
      <h5 class="card-title">Badges</h5>
      <p class="display-4 font-weight-bold">
        <?php
        $userId = $_SESSION['user_id'];
        $currentStreak = getCurrentStreak($conn, $userId);



        if ($currentStreak < 7) {
          echo '<i class="bi bi-exclamation-triangle-fill" style="color: red;"></i>';
        }

        if ($currentStreak >= 30) {
          echo '<i class="bi bi-award-fill" style="color: gold;"></i>';
        }
  
        if ($currentStreak >= 60) {
          echo '<i class="bi bi-award-fill" style="color: gold;"></i>';
        }

        if ($currentStreak >= 90) {
          echo '<i class="bi bi-award-fill" style="color: gold;"></i>';
        }
      
        if ($currentStreak >= 365) {
          echo '<i class="bi bi-trophy-fill" style="color: gold;"></i>';
        }
      
        if ($currentStreak >= 1095) {
          echo '<i class="bi bi-gem" style="color: #00FF00;"></i>';
        }

        if ($currentStreak >= 1825) {
          echo '<i class="bi bi-gem" style="color: #00FF00;"></i>';
        }

        if ($currentStreak > 6 && $currentStreak < 30) {
          echo '<i class="bi bi-award-fill" style="color: silver;"></i>';
        }

        ?>
      </p>
    </div>
  </div>
</div>
<div class="border rounded p-4">
  <div class="row justify-content-center">
    <div class="col-md-4">
      <div class="mb-4 text-center">
        <h5 class="card-title">Target Streak</h5>
        <?php
            $userId = $_SESSION['user_id'];

            $query = "SELECT target_streak FROM target_streaks WHERE user_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('i', $userId);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $targetStreak = $row['target_streak'];
                echo "<p class='display-4 font-weight-bold text-success'>$targetStreak days</p>";
            } else {
                echo "<p class='display-4 font-weight-bold'>0 day</p>";
            }
            ?>
      </div>
    </div>
  </div>

  <div class="row justify-content-center">

    <div class="col-md-6">
      <div class="mb-4 text-center">
        <h5 class="card-title">Progress Towards Target Streak</h5>
        <?php

       
        $userId = $_SESSION['user_id'];

        
        $query = "SELECT streak_start_date FROM streaks WHERE user_id = ? ORDER BY streak_start_date DESC LIMIT 1";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $streakStartDate = new DateTime($row['streak_start_date']);
            $presentDate = new DateTime();
            $actualStreak = $presentDate->diff($streakStartDate)->days;

            $query = "SELECT target_streak FROM target_streaks WHERE user_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('i', $userId);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $targetStreak = (int)$row['target_streak'];
                $progressPercentage = ($actualStreak / $targetStreak) * 100;
                $progressPercentage = min($progressPercentage, 100);

                echo '
                <div class="progress">
                    <div class="progress-bar bg-success" role="progressbar" style="width: '.$progressPercentage.'%;" 
                    aria-valuenow="'.$progressPercentage.'" aria-valuemin="0" aria-valuemax="100">'.$progressPercentage.'%</div>
                </div>';
            } else {
                echo "<p>No target streak set</p>";
            }
        } else {
            echo "<p>No streak recorded</p>";
        }
        ?>
      </div>
    </div>

  </div>
</div>
<div class="mt-5">
  <div class="row">
    <div class="col-md-12">
      <div>
        <h2 class="card-title text-center">Goals</h2>
        <ul class="list-group">
          <?php

          $userId = $_SESSION['user_id'];
          $query = "SELECT * FROM goals WHERE user_id = $userId";
          $result = mysqli_query($conn, $query);

          if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
              $goalId = $row['id'];
              $title = $row['title'];
          ?>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <div>
              <?php echo $title; ?>
            </div>
            <div>
              <form action="deletegoal.php" method="POST" class="d-inline">
                <input type="hidden" name="goal_id" value="<?php echo $goalId; ?>">
                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
              </form>
              <form action="completed.php" method="POST" class="d-inline">
                <input type="hidden" name="goal_id" value="<?php echo $goalId; ?>">
                <button type="submit" class="btn btn-success btn-sm">Completed</button>
              </form>
            </div>
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
</div>
<?php
include("attachbottom.php");
?>