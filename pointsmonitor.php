<?php
include("admintop.php");
include("connection.php");
?>

<div class="card-header">
  <h4 class="card-title">Points Table</h4>
</div>

<div class="card-body">



<?php
# try connecting to the database using PDO (PHP Data Objects)
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    
    # set PDO attributes to handle errors and exceptions
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

# SQL query to retrieve usernames and points from users and user_points tables
$query = "SELECT u.username, up.points FROM users u # SELECT username from the users table and points from the user_points tabel
          INNER JOIN user_points up ON u.id = up.user_id # inner join on users.id = user_points.user_id
          ORDER BY up.points DESC"; # ORDER BY points in the user_points table in descending order
$stmt = $conn->prepare($query);
$stmt->execute();
# fetching all leaderboard data as an associative array
$leaderboardData = $stmt->fetchAll(PDO::FETCH_ASSOC);


# closing the database connection
$conn = null;
?>
    <!-- HTML container for displaying the leaderboard table (For Points Monitoring) -->
    <div class="container">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Points</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($leaderboardData as $data): ?>
                    <tr>
                        <td><?php echo $data['username']; ?></td>
                        <td><?php echo $data['points']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
                </div>
    <?php
include("attachbottom.php");
?>
