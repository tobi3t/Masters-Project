<?php
include("admintop.php");
?>

<div class="card-header">
    <h4 class="card-title">Quiz Questions</h4>
</div>
<div class="card-body">
    <div class="row">

<div class="container mt-4">
        <div id="quiz">
        <?php

        include("connection.php");

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM quiz";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo '<table class="table table-bordered">';
            echo '<tr><th>Question Text</th><th>Option 1</th><th>Option 2</th><th>Option 3</th><th>Option 4</th><th>Correct Option</th><th>Action</th></tr>';
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $row["question_text"] . '</td>';
                echo '<td>' . $row["option1"] . '</td>';
                echo '<td>' . $row["option2"] . '</td>';
                echo '<td>' . $row["option3"] . '</td>';
                echo '<td>' . $row["option4"] . '</td>';
                echo '<td>' . $row["correct_option"] . '</td>';
                echo '<td><form action="deletequiz.php" method="post">';
                echo '<input type="hidden" name="question_id" value="' . $row["question_id"] . '">';
                echo '<button type="submit" class="btn btn-danger btn-sm">Delete</button>';
                echo '</form></td>';
                echo '</tr>';
                }
                echo '</table>';
            } else {
            echo '<div class="alert alert-warning" role="alert">No quiz questions found.</div>';
            }

        $conn->close();
        ?>

            
        </div>

        <h4 class="mt-3">Add New Quiz Question</h4>
        <form action="addquiz.php" method="post">
            <div class="form-group">
                <label for="question_text">Question Text:</label>
                <input type="text" class="form-control" name="question_text" required>
            </div>
            <div class="form-group">
                <label for="option1">Option 1:</label>
                <input type="text" class="form-control" name="option1" required>
            </div>
            <div class="form-group">
                <label for="option2">Option 2:</label>
                <input type="text" class="form-control" name="option2" required>
            </div>
            <div class="form-group">
                <label for="option3">Option 3:</label>
                <input type="text" class="form-control" name="option3" required>
            </div>
            <div class="form-group">
                <label for="option4">Option 4:</label>
                <input type="text" class="form-control" name="option4" required>
            </div>
            <div class="form-group">
                <label for="correct_option">Select Correct Option:</label>
                <select class="form-control" name="correct_option" required>
                    <option value="option1">Option 1</option>
                    <option value="option2">Option 2</option>
                    <option value="option3">Option 3</option>
                    <option value="option4">Option 4</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>


    


    </div>
</div>

<?php
include("attachbottom.php");
?>