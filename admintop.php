<?php
session_start();

if (!isset($_SESSION['email'])) {
  header("Location: signin.html");
  exit();
}

include("connection.php");

$email = $_SESSION['email'];

$adminEmails = array('admin1@measurerecovery.com', 'admin2@measurerecovery.com', 'admin3@measurerecovery.com');

if (!in_array($email, $adminEmails)) {
  header("Location: dashboard.php");
  exit();
}

$stmt = $conn->prepare("SELECT first_name FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($firstname);
$stmt->fetch();
$stmt->close();

$_SESSION['firstname'] = $firstname;

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Profile</title>
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
        <a class="navbar-brand" href="adminarticles.php">MeasureRecovery</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menunav">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="menunav">
          <ul class="navbar-nav ms-auto">
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
                <li class="list-group-item"><a href="adminarticles.php">Manage Articles</a></li>
                <li class="list-group-item"><a href="adminpdfs.php">Manage PDFs</a></li> 
                <li class="list-group-item"><a href="adminquiz.php">Manage Quiz Questions</a></li>
                <li class="list-group-item"><a href="pointsmonitor.php">Points Monitor</a></li>
                <li class="list-group-item"><a href="adminforum.php">Manage Chat Rooms</a></li>
                <li class="list-group-item"><a href="adminfeedback.php">Manage Feedback</a></li>
                <li class="list-group-item"><a href="adminvideos.php">Manage Videos</a></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-lg-8">
          <div class="card">