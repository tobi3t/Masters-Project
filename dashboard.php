<?php
include("attachtop.php");
include("functions.php");
include("connection.php");
include("streakhistory.php");
?>


</div>
<div class="col-lg-8">
<div class="card">
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
        # getting the user_id from the session and storing it in a variable
        $userId = $_SESSION['user_id'];
        # retrieving the points of the user from the user_points table
        $query = "SELECT points FROM user_points WHERE user_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        # retrieving result from the result
        $result = $stmt->get_result();
        # checking if there are any rows in the result
        if ($result && $result->num_rows > 0) {
          # fetching the row of the result as an associative array
          $row = $result->fetch_assoc();
          $points = $row['points'];

          # determining the user's level based on their points
          if ($points <= 300) {
            $level = "Seeker";
          } elseif ($points <= 1000) {
            $level = "Striver";
          } elseif ($points <= 5000) {
            $level = "Warrior";
          } else {
            $level = "Conqueror";
          }
          # outputing the points and preventing XSS attacks as well
          echo htmlspecialchars($points);
        } else {
          echo '0';
        }
        ?>
        <h3><span class="text-muted">Level: <?php echo htmlspecialchars($level); ?></span></h3>
        </p>
      </div>
    </div>
  </div>
</div>
<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="mb-4 text-center border rounded p-4 bg-light">
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
            <input type="date" class="form-control" id="startDateInput" name="startDate" required max="<?php echo date('Y-m-d');?>">
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
        # getting the user ID from the session
        $userId = $_SESSION['user_id'];
        # getting the current streak duration using function getCurrentStreak()
        $currentStreak = getCurrentStreak($conn, $userId);


        # checking the value of the current streak to determine the appropriate icon to display (Bootstrap Icons used as Badges)
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
<div class="border rounded p-4 bg-light">
  <div class="row justify-content-center">
    <div class="col-md-4">
      <div class="mb-4 text-center">
        <h5 class="card-title">Target Streak</h5>
        <?php
            # getting the user_id from the session
            $userId = $_SESSION['user_id'];
            # preparing database query
            $query = "SELECT target_streak FROM target_streaks WHERE user_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('i', $userId);
            $stmt->execute();
            $result = $stmt->get_result();
            # checking if the query returned any rows
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $targetStreak = $row['target_streak'];
                # displaying the target streak value
                echo "<p class='display-4 font-weight-bold text-success'>$targetStreak days</p>";
            } else {
                # displays '0 day' if no target streak value is found in the database
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

        # getting the user_id
        $userId = $_SESSION['user_id'];

        # preparing a database query to retrieve the user's most recent streak
        $query = "SELECT streak_start_date FROM streaks WHERE user_id = ? ORDER BY streak_start_date DESC LIMIT 1";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        # checking if the query returned any rows
        if ($result->num_rows > 0) {
            # fetching the start date from the query result
            $row = $result->fetch_assoc();
            $streakStartDate = new DateTime($row['streak_start_date']);
            $presentDate = new DateTime();
            # calculating the acutual streak duration in days using the DateTime objects
            $actualStreak = $presentDate->diff($streakStartDate)->days;
            # preparing query to retrieve user's target streak
            $query = "SELECT target_streak FROM target_streaks WHERE user_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('i', $userId);
            $stmt->execute();
            $result = $stmt->get_result();
            # checking if the query returned any rows
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $targetStreak = (int)$row['target_streak'];
                # calculating progress percentage towards the target streak and round it to two decimal places
                $progressPercentage = round((($actualStreak / $targetStreak) * 100),2);
                # ensuring that the progress percentage does not exceed 100%
                $progressPercentage = min($progressPercentage, 100);
                # displaying the progress bar with the calculated progress percentage
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
                    $query = "SELECT * FROM goals WHERE user_id = ?";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param('i', $userId);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $goalId = htmlspecialchars($row['id']);
                            $title = htmlspecialchars($row['title']);
                            ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <?php echo $title; ?>
                                </div>
                                <div>
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal<?php echo $goalId; ?>">Delete</button>
                                    <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#completedModal<?php echo $goalId; ?>">Completed</button>
                                </div>
                            </li>

                            <div class="modal fade" id="deleteModal<?php echo $goalId; ?>" tabindex="-1"
                                aria-labelledby="deleteModalLabel<?php echo $goalId; ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel<?php echo $goalId; ?>">Confirm
                                                Delete</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure you want to delete this goal?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cancel</button>
                                            <form action="deletegoal.php" method="POST" class="d-inline">
                                                <input type="hidden" name="goal_id" value="<?php echo $goalId; ?>">
                                                <button type="submit" class="btn btn-danger">Confirm</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="completedModal<?php echo $goalId; ?>" tabindex="-1"
                                aria-labelledby="completedModalLabel<?php echo $goalId; ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="completedModalLabel<?php echo $goalId; ?>">Confirm
                                                Completion</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure you want to mark this goal as completed?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cancel</button>
                                            <form action="completed.php" method="POST" class="d-inline">
                                                <input type="hidden" name="goal_id" value="<?php echo $goalId; ?>">
                                                <button type="submit" class="btn btn-success">Goal Achieved</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
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