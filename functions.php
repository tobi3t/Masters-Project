<?php
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
      $currentStreak = floor($dateDiff / (60 * 60 * 24)); 

      return $currentStreak;
    }

    return 0;
   }
function get_user_by_id($conn, $user_id) {
    $sql = "SELECT * FROM users WHERE id = $user_id";
    $result = $conn->query($sql);
    return ($result->num_rows > 0) ? $result->fetch_assoc() : null;
}