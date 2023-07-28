<div class="card mb-4">
  <div class="card-header justify-content-center">Streak History</div>
    <div class="card-body">
    <div class="row justify-content-center">
        <div class="col-md-6">
          <div class="mb-4 text-center border rounded p-4 bg-light">
            <h5 class="card-title">Highest Streak Achieved</h5>
            <p class="display-6 card-text">
              <?php
              $userId = $_SESSION['user_id'];
              $query = "SELECT MAX(streak_duration) AS highest_streak FROM streak_history WHERE user_id = ?";
              $stmt = $conn->prepare($query);
              $stmt->bind_param('i', $userId);
              $stmt->execute();
              $result = $stmt->get_result();

              if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $highestStreak = $row['highest_streak'];
                echo htmlspecialchars($highestStreak) . " days";
              } else {
                echo "0 day";
              }
              ?>
            </p>
          </div>
        </div>
      </div>

      <div class="row justify-content-center">
        <div class="col-md-4">
          <div class="mb-4 text-center">
            <h5 class="card-title">Highest Badges Obtained</h5>
            <p class="display-4 font-weight-bold">
              <?php
        
              if ($highestStreak < 7) {
                echo '<i class="bi bi-exclamation-triangle-fill" style="color: red;"></i>';
              }
      
              if ($highestStreak >= 30) {
                echo '<i class="bi bi-award-fill" style="color: gold;"></i>';
              }
        
              if ($highestStreak >= 60) {
                echo '<i class="bi bi-award-fill" style="color: gold;"></i>';
              }
      
              if ($highestStreak >= 90) {
                echo '<i class="bi bi-award-fill" style="color: gold;"></i>';
              }
            
              if ($highestStreak >= 365) {
                echo '<i class="bi bi-trophy-fill" style="color: gold;"></i>';
              }
            
              if ($highestStreak >= 1095) {
                echo '<i class="bi bi-gem" style="color: #00FF00;"></i>';
              }
      
              if ($highestStreak >= 1825) {
                echo '<i class="bi bi-gem" style="color: #00FF00;"></i>';
              }
      
              if ($highestStreak > 6 && $highestStreak < 30) {
                echo '<i class="bi bi-award-fill" style="color: silver;"></i>';
              }
              ?>
            </p>
          </div>
        </div>
      </div>

  </div>
</div>




