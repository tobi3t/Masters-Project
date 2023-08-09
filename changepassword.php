<?php
include("attachtop.php"); #  attaching the header and nav bars
include("connection.php"); # establishing connection to database

if (!isset($_SESSION['user_id'])) {
    header('Location: signin.html');
    exit();
}
# confirming if the HTTP request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    # getting the new password and confirm password from the POST request
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];
    # checking if the new password and the confirm password are a perfect match
    if ($newPassword === $confirmPassword) {
        # getting the user_id from the session 
        $user_id = $_SESSION['user_id'];
        # hashing the new password before storing it in the database
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        # preparing an update query to change the old password to the new one
        $stmt = $conn->prepare('UPDATE users SET password = ? WHERE id = ?');
        $stmt->bind_param('si', $hashedPassword, $user_id);
        # execute the query
        if ($stmt->execute()) {
            # display a success message
            echo '<div class="h4 alert alert-success" role="alert">Password changed successfully!</div>';
        } else {
            # display an error message
            echo '<div class="alert alert-danger" role="alert">Error: ' . $stmt->error . '</div>';
        }

        $stmt->close();
    } else {
        # error message for when password does not match
        echo '<div class="alert alert-danger" role="alert">Passwords do not match. Please try again.</div>';
    }
}
?>


</div>
<div class="col-lg-8">
<div class="card">

<div class="card-header">
  <h4 class="card-title">Change Password</h4>
</div>




<div class="container mt-4">
        <h2>Change Password</h2>
        <!-- New password form -->
        <form method="post" action="changepassword.php">
            <div class="mb-3">
                <label for="new_password" class="form-label">New Password:</label>
                <input type="password" id="new_password" name="new_password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Change Password</button>
        </form>
    </div>
    <br>
</div>






</div>
</div>

<?php
include("attachbottom.php");
?>
