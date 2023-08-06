<?php
session_start();
# checking if the user is not authenticated
if (!isset($_SESSION['email'])) {
  header("Location: signin.html");
  exit();
}

include("connection.php");
# storing the email in a session variable
$email = $_SESSION['email'];
# define an array of all the admin email addresses present in the users table
$adminEmails = array('admin1@measurerecovery.com', 'admin2@measurerecovery.com', 'admin3@measurerecovery.com');
# checking if the user's email is in the array of admin emails
if (in_array($email, $adminEmails)) {
  header("Location: adminarticles.php");  # if the user is an admin, redirect them to admin page
  exit();
}
# preparing a database query to retrieve the first name of the user using their email
$stmt = $conn->prepare("SELECT first_name FROM users WHERE email = ?");

$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($firstname);
$stmt->fetch();
$stmt->close();
# storing the user's first name in a session variable
$_SESSION['firstname'] = $firstname;

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MeasureRecovery - Personal Profile</title>
  <!--BOOTSTRAP 5 CSS STYLESHEET-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <!--BOOTSTRAP 5 Icons STYLESHEET => https://blog.getbootstrap.com/2021/01/07/bootstrap-icons-1-3-0/ -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <div class="content">
    <nav class="navbar navbar-expand-md navbar-dark py-4 bg-primary">
      <div class="container-fluid">
        <a class="navbar-brand" href="dashboard.php">MeasureRecovery</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menunav">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="menunav">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="changepassword.php">Change Password</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="logout.php">Logout</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <div class="container mt-4">
      <div class="row">
        <div class="col-lg-4">
          <div class="card mb-4">
            <div class="card-header">Welcome, <?php echo $firstname; ?></div>
            <div class="card-body">
              <ul class="list-group">
                <li class="list-group-item"><a href="welcome.php">Welcome</a></li>
                <li class="list-group-item"><a href="dashboard.php">Dashboard</a></li>
                <li class="list-group-item"><a href="goals.php">Goal Setting</a></li>
                <li class="list-group-item"><a href="forum.php">Forum</a></li>
                <li class="list-group-item"><a href="quiz.php">Quiz</a></li>
                <li class="list-group-item"><a href="resources.php">Resources</a></li>
              </ul>
            </div>
          </div>

        
            