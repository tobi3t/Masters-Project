<?php
session_start();

include("connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $email = $_POST['email'];
    $password = $_POST['password'];

    $email = htmlspecialchars(trim($email));

    $stmt = $conn->prepare('SELECT * FROM users WHERE email = ?');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        $hashedPassword = $user['password'];
        if (password_verify($password, $hashedPassword)) {

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $email;

            $adminEmails = array('admin1@measurerecovery.com', 'admin2@measurerecovery.com', 'admin3@measurerecovery.com');
            if (in_array($email, $adminEmails)) {
                header('Location: adminarticles.php');
                exit();
            } else {
                $userId = $_SESSION['user_id']; 
                $updateStmt = $conn->prepare('UPDATE user_points SET points = points + 10 WHERE user_id = ?');
                $updateStmt->bind_param('i', $userId);
                $updateStmt->execute(); 
                header('Location: dashboard.php');
                exit();
            }
        } else {
            header('Location: signin.html');
            exit();
        }
    } else {
        header('Location: signin.html');
        exit();
    }

    $stmt->close();
}

$conn->close();
?>
