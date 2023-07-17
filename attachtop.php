<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Personal Profile</title>
  <!--BOOTSTRAP 5 CSS STYLESHEET-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <!--BOOTSTRAP 5 Icons STYLESHEET => https://blog.getbootstrap.com/2021/01/07/bootstrap-icons-1-3-0/ -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <div class="content">
    <nav class="navbar navbar-expand-md navbar-dark py-4 bg-dark">
      <div class="container-fluid">
        <a class="navbar-brand" href="index.html">MeasureRecovery</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menunav">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="menunav">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="dashboard.php">Dashboard</a>
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
            <div class="card-header">Navigator</div>
            <div class="card-body">
              <ul class="list-group">
                <li class="list-group-item"><a href="dashboard.php">Dashboard</a></li>
                <li class="list-group-item"><a href="goals.php">Manage Goals</a></li>
                <li class="list-group-item"><a href="forum.php">Forum</a></li>
                <li class="list-group-item"><a href="quiz.php">Quiz</a></li>
                <li class="list-group-item"><a href="resources.php">Resources</a></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-lg-8">
          <div class="card">
            