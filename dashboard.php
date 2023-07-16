<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <!--BOOTSTRAP 5 CSS STYLESHEET-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <!--BOOTSTRAP 5 Icons STYLESHEET => https://blog.getbootstrap.com/2021/01/07/bootstrap-icons-1-3-0/ -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
  <link rel="stylesheet" href="style.css">
</head>

<body>
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
              <li class="list-group-item">Dashboard</li>
              <li class="list-group-item">Forum</li>
              <li class="list-group-item">Resources</li>
              <li class="list-group-item">Quiz</li>
              <li class="list-group-item">Logout</li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-lg-8">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Dashboard</h4>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="mb-4">
                  <h5 class="card-title">Streak</h5>
                  <p class="card-text">Current streak: <span id="currentStreak">7</span> days</p>
                  <button class="btn btn-primary" onclick="setStreak()">Set Streak</button>
                  <button class="btn btn-danger" onclick="resetStreak()">Reset Streak</button>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-4">
                  <h5 class="card-title">Progress</h5>
                  <div class="progress">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 70%;" aria-valuenow="70"
                      aria-valuemin="0" aria-valuemax="100">70%</div>
                  </div>
                </div>
              </div>
            </div>

            <div class="row justify-content-center">
              <div class="col-md-4">
                <div class="mb-4 text-center">
                  <h5 class="card-title">Points Earned</h5>
                  <p class="display-4 font-weight-bold">1000</p>
                </div>
              </div>
            </div>
            <div class="row justify-content-center">
              <div class="col-md-12">
                <div class="mb-4 d-flex flex-column align-items-center">
                  <h5 class="card-title">Badges Earned</h5>
                  <div class="h1 mb-3">
                    <i class="bi bi-laptop"></i>
                    <small class="text-center">WK</small>
                  </div>
                  <div class="h1 mb-3">
                    <i class="bi bi-person-square"></i>
                    <small class="text-center">MT</small>
                  </div>
                  <div class="h1 mb-3">
                    <i class="bi bi-people"></i>
                    <small class="text-center">YR</small>
                  </div>
                </div>
              </div>

            </div>
            <div class="row">
              <div class="col-md-12">
                <div>
                  <h5 class="card-title">Goals</h5>
                  <ul class="list-group">
                    <li class="list-group-item">Goal 1</li>
                    <li class="list-group-item">Goal 2</li>
                    <li class="list-group-item">Goal 3</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

</body>
<footer class="footer bg-dark text-white py-4">
  <div class="container">
    <div class="text-center">
      <p class="mb-0">&copy; 2023 MeasureRecovery. All rights reserved.</p>
    </div>
  </div>
</footer>
<!--BOOTSTRAP 5 JS SCRIPT-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>