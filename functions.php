<?php
# Function to the current streak
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


# Function to fetch all articles from the database
function getArticles($conn) {
    # preparing an SQL statement to retrieve all rows from the "articles" table
    $stmt = $conn->prepare("SELECT * FROM articles");
    # preparing an SQL statement to retrieve all rows from the "articles" table
    $stmt->execute();
    # getting the result set from the executed statement
    $result = $stmt->get_result();
    # fetching all rows from the result set as associative arrays and storing them in the $articles array 
    $articles = $result->fetch_all(MYSQLI_ASSOC);
    # closing the prepared statement
    $stmt->close();
    # returning the array containing fetched articles
    return $articles;
}


# Function to sanitize input data to prevent XSS attacks
function sanitize_input($data) {
    $data = trim($data); # trimming any leading or trailing whitespace from the data
    $data = htmlspecialchars($data); # converting special characters to their HTML entities to prevent cross-site scripting (XSS) attacks
    return $data; # return the sanitized data
}

# Function to scan PDF files in a given folder and display download links
function scanPdfFiles($pdf_folder) {
    # getting the list of files in the specified folder
    $pdf_files = scandir($pdf_folder);

    # iterating through each file in the folder
    foreach ($pdf_files as $pdf_file) {
        # skip current directory '.' and parent directory '..'
        if ($pdf_file === '.' || $pdf_file === '..') {
            continue;
        }
        # getting the file extension in lowercase
        $file_extension = strtolower(pathinfo($pdf_folder . $pdf_file, PATHINFO_EXTENSION));
        # checking if the file extension is 'pdf'
        if ($file_extension === 'pdf') {
            # generating an HTML list item with a link to download the PDF file
            echo '<li class="list-group-item">';
            echo '<a href="download_pdf.php?pdf=' . urlencode($pdf_file) . '">' . htmlspecialchars($pdf_file) . '</a>';
            echo '</li>';
        }
    }
}

# Function to fetch all videos from the database
function getVideos($conn) {
    # initializing an empty array to store the fetched videos
    $videos = array();
    # SQL query to select all videos from the "videos" table
    $sql = "SELECT * FROM videos";
    # executing the SQL query
    $result = $conn->query($sql);

    # checking if there are rows returned from the query
    if ($result->num_rows > 0) {
        # iterating through each row in the result set
        while ($row = $result->fetch_assoc()) {
            # adding the current row (video) to the $videos array
            $videos[] = $row;
        }
    }
    # returning the array containing the fetched videos
    return $videos;
}

# Function to get the category name based on the category ID
function getCategoryName($conn, $category_id) {
    # SQL query to select the name of the category based on the category ID
    $sql = "SELECT name FROM categories WHERE category_id = ?";
    # preparing the SQL query using the provided database connection
    $stmt = $conn->prepare($sql);
    # binding the category ID as a parameter to the prepared statement
    $stmt->bind_param('i', $category_id);
    # executing the prepared statement
    $stmt->execute();
    # getting the result set from the executed statement
    $result = $stmt->get_result();
    # checking if there are rows returned from the query result
    if ($result->num_rows > 0) {
        # fetching the first row as an associative array
        $row = $result->fetch_assoc();
        # returning the category name after encoding it to prevent XSS attacks
        return htmlspecialchars($row['name']);
    } else {
        # returning a default "Unknown Category" if no matching category is found
        return "Unknown Category";
    }
}

# Function to check if a user has viewed a specific video
function hasUserViewedVideo($conn, $user_id, $video_id) {
    # SQL query to count the number of rows where the user_id and video_id match in the "video_views" table
    $query = "SELECT COUNT(*) AS count FROM video_views WHERE user_id = ? AND video_id = ?";
    # preparing the SQL query using the provided database connection
    $stmt = $conn->prepare($query);
    # binding the user ID and video ID as parameters to the prepared statement
    $stmt->bind_param("ii", $user_id, $video_id);
    # executing the prepared statement
    $stmt->execute();
    # getting the result set from the executed statement
    $result = $stmt->get_result();
    # fetching the first row of the result set as an associative array
    $row = $result->fetch_assoc();
    # returning true if the count of rows is greater than 0, indicating the user has viewed the video; otherwise, return false
    return ($row['count'] > 0);
}

# Function to fetch user goals from the database
function getUserGoals($conn, $userId) {
    # SQL query to retrieve all rows from the "goals" table where the user_id matches the provided user ID
    $query = "SELECT * FROM goals WHERE user_id = ?";
    # preparing the SQL query using the provided database connection
    $stmt = $conn->prepare($query);
    # binding the user ID as a parameter to the prepared statement
    $stmt->bind_param('i', $userId);
    # executing the prepared statement
    $stmt->execute();
    # returning the result set obtained from the executed statement
    return $stmt->get_result();
}

# Function to fetch user data by user ID
function get_user_by_id($conn, $user_id) {
    # SQL query to retrieve all columns from the "users" table where the ID matches the provided user ID
    $sql = "SELECT * FROM users WHERE id = ?";
    # preparing the SQL query using the provided database connection
    $stmt = $conn->prepare($sql);
    # binding the user ID as a parameter to the prepared statement
    $stmt->bind_param('i', $user_id);
    # executing the prepared statement
    $stmt->execute();
    # getting the result set obtained from the executed statement
    $result = $stmt->get_result();

    # checking if the result set contains any rows
    if ($result->num_rows > 0) {
        # fetching and returning the associative array representing the user data
        return $result->fetch_assoc();
    } else {
        # if no rows are found, return null
        return null;
    }
}
?>