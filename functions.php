<?php
function getCurrentStreak($conn, $userId) {
    # retrieving the most recent streak start date
    $query = "SELECT streak_start_date FROM streaks WHERE user_id = ? ORDER BY streak_start_date DESC LIMIT 1";

    # preparing the SQL query and bind
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    # checking if there are any rows returned from the query
    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc(); 
      $streakStartDate = $row['streak_start_date']; 
      # getting the current date in "Y-m-d" format
      $presentDate = date("Y-m-d"); 

      # calculating the difference between the present date and the streak start date in seconds
      $dateDiff = abs(strtotime($presentDate) - strtotime($streakStartDate));
      # converting the difference from seconds to days and rounding it down to get the current streak duration
      $currentStreak = floor($dateDiff / (60 * 60 * 24)); 

      return $currentStreak;
    }
    # if no streaks were found for the user, return 0 indicating no current streak
    return 0;
   }

function getArticles($conn) {
    $stmt = $conn->prepare("SELECT * FROM articles");
    $stmt->execute();
    $result = $stmt->get_result();
    $articles = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $articles;
}


function sanitize_input($data) {
    $data = trim($data);
    $data = htmlspecialchars($data);
    return $data;
}

function scanPdfFiles($pdf_folder) {
    $pdf_files = scandir($pdf_folder);
    foreach ($pdf_files as $pdf_file) {
        if ($pdf_file === '.' || $pdf_file === '..') {
            continue;
        }
        $file_extension = strtolower(pathinfo($pdf_folder . $pdf_file, PATHINFO_EXTENSION));
        if ($file_extension === 'pdf') {
            echo '<li class="list-group-item">';
            echo '<a href="download_pdf.php?pdf=' . urlencode($pdf_file) . '">' . htmlspecialchars($pdf_file) . '</a>';
            echo '</li>';
        }
    }
}


function getVideos($conn) {
    $videos = array();
    $sql = "SELECT * FROM videos";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $videos[] = $row;
        }
    }

    return $videos;
}


function getCategoryName($conn, $category_id) {
    $sql = "SELECT name FROM categories WHERE category_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $category_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return htmlspecialchars($row['name']);
    } else {
        return "Unknown Category";
    }
}

function hasUserViewedVideo($conn, $user_id, $video_id) {
    $query = "SELECT COUNT(*) AS count FROM video_views WHERE user_id = ? AND video_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $user_id, $video_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return ($row['count'] > 0);
}

function getUserGoals($conn, $userId) {
    $query = "SELECT * FROM goals WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    return $stmt->get_result();
}


function get_user_by_id($conn, $user_id) {
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    return ($result->num_rows > 0) ? $result->fetch_assoc() : null;
}
?>