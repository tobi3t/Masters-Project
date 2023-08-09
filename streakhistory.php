<!-- Card for Streak History -->
<div class="card mb-4">
  <div class="card-header justify-content-center">Streak History</div>
    <div class="card-body">
      <!-- Row for Highest Streak Achieved -->
    <div class="row justify-content-center">
        <div class="col-md-6">
          <div class="mb-4 text-center border rounded p-4 bg-light">
            <h5 class="card-title">Highest Streak Achieved</h5>
            <p class="display-6 card-text">
              <?php
              # getting the user ID from the session
              $userId = $_SESSION['user_id'];
              
              # SQL query to retrieve the highest streak achieved by the user
              $query = "SELECT MAX(streak_duration) AS highest_streak FROM streak_history WHERE user_id = ?";
              $stmt = $conn->prepare($query);

              # binding the user ID parameter to the prepared statement
              $stmt->bind_param('i', $userId);
              # executing the prepared statement
              $stmt->execute();
              # getting the result set
              $result = $stmt->get_result();
              # checking if there are rows in the result set
              if ($result && $result->num_rows > 0) {
                # fetching the row as an associative array
                $row = $result->fetch_assoc();
                # getting the highest streak value from the associative array
                $highestStreak = $row['highest_streak'];
                # displaying the highest streak with proper HTML escaping
                echo htmlspecialchars($highestStreak) . " days";
              } else {
                # if no rows are found, display a default message
                echo "0 day";
              }
              ?>
            </p>
          </div>
        </div>
      </div>
      <!-- Row for Highest Badges Obtained -->
      <div class="row justify-content-center">
        <div class="col-md-4">
          <div class="mb-4 text-center">
            <h5 class="card-title">Highest Badges Obtained</h5>
            <p class="display-4 font-weight-bold">
              <?php
              # determine which badges to display based on the highest streak achieved
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




