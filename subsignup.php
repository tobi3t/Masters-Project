<?php
session_start();

include("connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $firstName = htmlspecialchars(trim($firstname));
    $lastName = htmlspecialchars(trim($lastname));
    $username = htmlspecialchars(trim($username));
    $email = htmlspecialchars(trim($email));

    $stmt = $conn->prepare('SELECT id FROM users WHERE email = ?');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    if ($result->num_rows > 0) {
        header('Location: signin.html');
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare('INSERT INTO users (first_name, last_name, username, email, password) VALUES (?, ?, ?, ?, ?)');
    $stmt->bind_param('sssss', $firstname, $lastname, $username, $email, $hashedPassword);

    if ($stmt->execute()) {
        header('Location: signin.html');
        exit();
    } else {
        echo 'Error: ' . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
