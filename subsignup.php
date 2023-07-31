<?php
session_start();

include("connection.php");
# checking if the HTTP request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    # getting user input from the POST request
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    # triming and sanitizing the user input
    $firstName = htmlspecialchars(trim($firstname));
    $lastName = htmlspecialchars(trim($lastname));
    $username = htmlspecialchars(trim($username));
    $email = htmlspecialchars(trim($email));
    # preparing and executing a database query to check if the email already exists
    $stmt = $conn->prepare('SELECT id FROM users WHERE email = ?');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    # redirecting the user to the signin page and exiting if the email already exists
    if ($result->num_rows > 0) {
        header('Location: signin.html');
        exit();
    }
    # hashing the user's password for secure storage
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    # preparing and executing a database query to insert the user's information into the users table
    $stmt = $conn->prepare('INSERT INTO users (first_name, last_name, username, email, password) VALUES (?, ?, ?, ?, ?)');
    $stmt->bind_param('sssss', $firstname, $lastname, $username, $email, $hashedPassword);
    
    if ($stmt->execute()) {
        $user_id = $stmt->insert_id;
    # setting default points for the new user to 100 in the user_points table
        $points = 100;
        $stmt = $conn->prepare('INSERT INTO user_points (user_id, points) VALUES (?, ?)');
        $stmt->bind_param('ii', $user_id, $points);
        $stmt->execute();
    # redirecting the user to the signin page after successful registration and exiting
        header('Location: signin.html');
        exit();
    } else {
        echo 'Error: ' . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
