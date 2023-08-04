<?php
include("attachtop.php");
include("connection.php");
?>
</div>
<div class="col-lg-8">
<div class="card">
<div class="card-header">
    <h4 class="card-title">Quiz</h4>
</div>
<div class="card-body">
    <div class="row">

    <?php
# retrieving all quiz questions from the database.
$sql = "SELECT * FROM quiz";
$result = $conn->query($sql);

$questions = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $questions[] = $row;
    }
}

# shuffling the array of questions to randomize their order
shuffle($questions);

# selecting the first 5 questions after shuffling
$selectedQuestions = array_slice($questions, 0, 5);

# processing the quiz form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $score = 0;
    # iterating through selected questions and calculate the score
    foreach ($selectedQuestions as $question) {
        $question_id = $question['question_id'];
        $correct_option = $question['correct_option'];
        $selected_option = $_POST['question' . $question_id];

        if (strcasecmp($selected_option, $correct_option) == 0) {
            $score++;
        }
    }
    # updating user's points and score based on the quiz result
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("SELECT * FROM user_points WHERE user_id = ?");
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    # updating user's points and score in the database.
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $points = $row['points'] + $score;

        $stmt = $conn->prepare("UPDATE user_points SET points = ?, score = ? WHERE user_id = ?");
        $stmt->bind_param('iii', $points, $score, $user_id);
    } else {
        $stmt = $conn->prepare("INSERT INTO user_points (user_id, points, score) VALUES (?, ?, ?)");
        $stmt->bind_param('iii', $user_id, $score, $score);
    }
    # redirecting to the result page after updating the database
    if ($stmt->execute()) {
        $stmt->close();

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
                <?php foreach ($selectedQuestions as $question) : ?>
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
                    # displaying radio options for each question
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