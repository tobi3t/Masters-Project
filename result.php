<?php
include("attachtop.php");
?>

<?php
include("connection.php");

# getting the current user's ID
$user_id = $_SESSION['user_id'];

$sql = "SELECT score FROM user_points WHERE user_id = '$user_id'";
# executing the query to get the user's quiz score
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    # fetching the result row
    $row = $result->fetch_assoc();
    # extracting the score from the row
    $score = $row['score'];
} else {
    # setting score to 0 if no rows were found (initial case)
    $score = 0;
}

$conn->close();
?>

</div>
<div class="col-lg-8">
<div class="card">
<div class="card-header">
    <h4 class="card-title">Quiz</h4>
</div>
<div class="card-body">
    <div class="row">
    <div class="container">
        <div class="card">
            <div class="card-body text-center">
                <?php if ($score > 2): ?>
                    <!-- if user score is greater than 2, show congratulations message -->
                    <h3 class="display-3">Congratulations!</h3>
                    <p>You scored <?php echo $score; ?> out of 5</p>
                    <p>Keep going back to the quiz to improve your knowledge about recovery.</p>
                    <a href="quiz.php" class="btn btn-primary">Go to Quiz</a>
                <?php else: ?>
                    <!-- if user score is 2 or lower, encourage them to try again -->
                    <h3>Try Again</h3>
                    <p>You scored <?php echo $score; ?> out of 5</p>
                    <p>Do you want to try again and improve your score?</p>
                    <a href="quiz.php" class="btn btn-primary">Back to Quiz</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    </div>
</div>
<?php
include("attachbottom.php");
?>