<?php
include("attachtop.php");
?>

<div class="card-header">
    <h4 class="card-title">Quiz</h4>
</div>
<div class="card-body">
    <div class="row">


        <?php
include("connection.php");

$sql = "SELECT * FROM quiz";
$result = $conn->query($sql);

$questions = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $questions[] = $row;
    }
}

shuffle($questions);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $score = 0;

    foreach ($questions as $question) {
        $question_id = $question['question_id'];
        $correct_option = $question['correct_option'];
        $selected_option = $_POST['question' . $question_id];

        if (strcasecmp($selected_option, $correct_option) == 0) {
            $score++;
        }
    }

    $user_id = $_SESSION['user_id'];

    $sql = "SELECT * FROM user_points WHERE user_id = '$user_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
       
        $row = $result->fetch_assoc();
        $points = $row['points'] + $score;
        $sql = "UPDATE user_points SET points = '$points', score = '$score' WHERE user_id = '$user_id'";
    } else {
        
        $sql = "INSERT INTO user_points (user_id, points, score) VALUES ('$user_id', '$score', '$score')";
    }
    
    if ($conn->query($sql) === TRUE) {
        
        header("Location: result.php");
        exit();
    } else {
        echo "Error updating user points: " . $conn->error;
    }
}

$conn->close();
?>

        <div class="container">
            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <?php $questionNumber = 1; ?>
                <?php foreach ($questions as $question) : ?>
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Question
                            <?php echo $questionNumber++; ?>
                        </h5>
                        <p class="card-text">
                            <?php echo $question['question_text']; ?>
                        </p>

                        <?php
                    $options = array($question['option1'], $question['option2'], $question['option3'], $question['option4']);
                    
                    shuffle($options);

                    foreach ($options as $option) {
                        echo '<div class="form-check">';
                        echo '<input class="form-check-input" type="radio" name="question' . $question['question_id'] . '" id="q' . $question['question_id'] . '-option' . $option . '" value="' . $option . '">';
                        echo '<label class="form-check-label" for="q' . $question['question_id'] . '-option' . $option . '">' . $option . '</label>';
                        echo '</div>';
                    }
                    ?>
                    </div>
                </div>
                <?php endforeach; ?>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
<?php
include("attachbottom.php");
?>