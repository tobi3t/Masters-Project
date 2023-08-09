<?php
# starting a new session
session_start();

# including the connection to the database
include("connection.php");

# checking if the HTTP request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    # retrieving email and password from the form
    $email = $_POST['email'];
    $password = $_POST['password'];

    # sanitizing and trim the email input
    $email = htmlspecialchars(trim($email));

    # preparing a statement to retrieve user data based on email
    $stmt = $conn->prepare('SELECT * FROM users WHERE email = ?');
    $stmt->bind_param('s', $email);
    $stmt->execute();

    # getting the result of the statement
    $result = $stmt->get_result();

    # fetching user data
    $user = $result->fetch_assoc();

    if ($user) {
        # verifying the password using password_verify
        $hashedPassword = $user['password'];
        if (password_verify($password, $hashedPassword)) {
            # setting session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $email;

            # defining an array of admin emails
            $adminEmails = array('admin1@measurerecovery.com', 'admin2@measurerecovery.com', 'admin3@measurerecovery.com');

            # checking if the user's email is in the adminEmails array
            if (in_array($email, $adminEmails)) {
                # redirecting to the admin dashboard
                header('Location: adminarticles.php');
                exit();
            } else {
                # updating user points and redirect to the user dashboard
                $userId = $_SESSION['user_id'];
                $updateStmt = $conn->prepare('UPDATE user_points SET points = points + 10 WHERE user_id = ?');
                $updateStmt->bind_param('i', $userId);
                $updateStmt->execute();
                header('Location: dashboard.php');
                exit();
            }
        } else {
            # redirecting to the sign-in page if password is incorrect
            header('Location: signin.html');
            exit();
        }
    } else {
        # redirecting to the sign-in page if user is not found
        header('Location: signin.html');
        exit();
    }

    # closing the statement
    $stmt->close();
}

# closing the database connection
$conn->close();
?>
