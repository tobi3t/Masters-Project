<?php
include("attachtop.php");
?>

<div class="card-header">
  <h4 class="card-title">Forum</h4>
</div>
<div class="card-body">
  <div class="row">
    <div class="col-md-6">
      <div class="mb-4">
        <h5 class="card-title">Streak</h5>
        <p class="card-text">Current streak: <span id="currentStreak">7</span> days</p>
        <button class="btn btn-primary">Set Streak</button>
        <button class="btn btn-danger">Reset Streak</button>
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
        <p class="display-1 font-weight-bold">1000</p>
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

<?php
include("attachbottom.php");
?>