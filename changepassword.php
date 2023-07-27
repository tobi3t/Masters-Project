<?php
include("attachtop.php");
include("connection.php");

if (!isset($_SESSION['user_id'])) {
    header('Location: signin.html');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    if ($newPassword === $confirmPassword) {
        $user_id = $_SESSION['user_id'];
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $stmt = $conn->prepare('UPDATE users SET password = ? WHERE id = ?');
        $stmt->bind_param('si', $hashedPassword, $user_id);

        if ($stmt->execute()) {
            echo '<div class="h4 alert alert-success" role="alert">Password changed successfully!</div>';
        } else {
            echo '<div class="alert alert-danger" role="alert">Error: ' . $stmt->error . '</div>';
        }

        $stmt->close();
    } else {
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
