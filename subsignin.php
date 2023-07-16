<?php
session_start();

include("connection.php");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

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

            header('Location: dashboard.php');
            exit();
        } else {
           
            header('Location: signin.html');
        }
    } else {
      
        header('Location: signin.html');
    }

    $stmt->close();
}

$conn->close();
?>