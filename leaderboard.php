<?php
include("admintop.php");
include("connection.php");
?>

<div class="card-header">
  <h4 class="card-title">Leaderboard</h4>
</div>

<div class="card-body">



<?php

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
   
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

$query = "SELECT u.username, up.points FROM users u
          INNER JOIN user_points up ON u.id = up.user_id
          ORDER BY up.points DESC";
$stmt = $conn->prepare($query);
$stmt->execute();
$leaderboardData = $stmt->fetchAll(PDO::FETCH_ASSOC);

$conn = null;
?>
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
