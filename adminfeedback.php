<?php
include("admintop.php");
include("connection.php");
?>

<div class="card-header">
    <h4 class="card-title">Manage Feedback</h4>
</div>
<div class="card-body">
    <div class="row">

    
    <div class="container">
        <?php
        # defining a function to sanitize input data to prevent XSS attacks
        function sanitize_input($data)
        {
            return htmlspecialchars($data);
        }
        # checking if the "delete_feedback" form has been submitted
        if (isset($_POST["delete_feedback"])) {
            $feedback_id = $_POST["delete_feedback"];

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            # deleting the feedback entry from the database
            $sql = "DELETE FROM feedback WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $feedback_id);
            $stmt->execute();
            $stmt->close();
            $conn->close();
            # redirecting to the admin feedback page after deletion
            header("Location: adminfeedback.php");
            exit;
        }

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        # query to select all feedback entries from the feedback table
        $sql = "SELECT * FROM feedback";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            # displaying feedback entries in a table
            echo '<table class="table table-striped">';
            echo '<thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Message</th><th>Actions</th></tr></thead><tbody>';

            while ($row = $result->fetch_assoc()) {
                $feedback_id = $row["id"];
                $name = sanitize_input($row["name"]);
                $email = sanitize_input($row["email"]);
                $message = sanitize_input($row["message"]);

                # displaying feedback data in table rows
                echo "<tr>";
                echo "<td>$feedback_id</td>";
                echo "<td>$name</td>";
                echo "<td>$email</td>";
                echo "<td>$message</td>";

                # button to trigger the delete confirmation modal
                echo '<td><button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal' . $feedback_id . '">Delete</button></td>';
                echo "</tr>";
                
                # deleting confirmation modal for each feedback entry
                echo '<div class="modal fade" id="deleteModal' . $feedback_id . '" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">';
                echo '<div class="modal-dialog">';
                echo '<div class="modal-content">';
                echo '<div class="modal-header">';
                echo '<h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>';
                echo '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
                echo '</div>';
                echo '<div class="modal-body">';
                echo "Are you sure you want to delete the feedback from $name?";
                echo '</div>';
                echo '<div class="modal-footer">';
                echo '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>';
                echo '<form method="POST" action="deletefeedback.php" style="display:inline;">'; 
                echo '<input type="hidden" name="delete_feedback" value="' . $feedback_id . '">';
                echo '<button type="submit" class="btn btn-danger">Confirm</button>';
                echo '</form>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }

            echo "</tbody></table>";
        } else {
            echo "No feedback found.";
        }

        $conn->close();
        ?>
    </div>

    </div>
</div>

<?php
include("attachbottom.php");
?>


