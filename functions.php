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