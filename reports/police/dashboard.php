<?php
require_once '../includes/config.php';
$page_title = 'Dashboard';
$base_url   = '../';

if(!isset($_SESSION['policeid'])){ header("Location: login.php"); exit(); }

$pid        = (int)$_SESSION['policeid'];
$station_id = (int)$_SESSION['police_station'];

$total_fir   = mysqli_fetch_row(mysqli_query($con,"SELECT COUNT(*) FROM tbl_fir WHERE PoliceStationID=$station_id"))[0];
$pending_fir = mysqli_fetch_row(mysqli_query($con,"SELECT COUNT(*) FROM tbl_fir WHERE PoliceStationID=$station_id AND FIRStatus='Pending'"))[0];
$inprog_fir  = mysqli_fetch_row(mysqli_query($con,"SELECT COUNT(*) FROM tbl_fir WHERE PoliceStationID=$station_id AND FIRStatus='Inprogress'"))[0];
$solved_fir  = mysqli_fetch_row(mysqli_query($con,"SELECT COUNT(*) FROM tbl_fir WHERE PoliceStationID=$station_id AND FIRStatus='Solved'"))[0];
$my_fir      = mysqli_fetch_row(mysqli_query($con,"SELECT COUNT(*) FROM tbl_fir WHERE PoliceID=$pid"))[0];
$total_crim  = mysqli_fetch_row(mysqli_query($con,"SELECT COUNT(*) FROM tbl_criminal WHERE PoliceStationID=$station_id"))[0];
// News posted by this officer
$my_news     = mysqli_fetch_row(mysqli_query($con,"SELECT COUNT(*) FROM news WHERE posted_by=$pid AND posted_by_role='police'"))[0];

include '../includes/police-header.php';
?>

<div class="dash-grid">

  <div class="card" style="margin-bottom:0;">
    <div class="stat-card">
      <div class="stat-icon teal"><i class="fas fa-file-alt"></i></div>
      <div class="stat-info"><p>Total FIRs at Station</p><h3><?php echo $total_fir; ?></h3></div>
    </div>
    <a href="view-fir.php" class="stat-link">(View All)</a>
  </div>

  <div class="card" style="margin-bottom:0;">
    <div class="stat-card">
      <div class="stat-icon red"><i class="fas fa-clock"></i></div>
      <div class="stat-info"><p>Pending FIRs</p><h3><?php echo $pending_fir; ?></h3></div>
    </div>
    <a href="view-fir.php?status=Pending" class="stat-link">(View All)</a>
  </div>

  <div class="card" style="margin-bottom:0;">
    <div class="stat-card">
      <div class="stat-icon" style="background:#FF9800;"><i class="fas fa-spinner"></i></div>
      <div class="stat-info"><p>In-Progress FIRs</p><h3><?php echo $inprog_fir; ?></h3></div>
    </div>
    <a href="view-fir.php?status=Inprogress" class="stat-link">(View All)</a>
  </div>

  <div class="card" style="margin-bottom:0;">
    <div class="stat-card">
      <div class="stat-icon green"><i class="fas fa-check-circle"></i></div>
      <div class="stat-info"><p>Solved FIRs</p><h3><?php echo $solved_fir; ?></h3></div>
    </div>
    <a href="view-fir.php?status=Solved" class="stat-link">(View All)</a>
  </div>

  <div class="card" style="margin-bottom:0;">
    <div class="stat-card">
      <div class="stat-icon purple"><i class="fas fa-user-tie"></i></div>
      <div class="stat-info"><p>My Assigned FIRs</p><h3><?php echo $my_fir; ?></h3></div>
    </div>
    <a href="view-fir.php?mine=1" class="stat-link">(View Mine)</a>
  </div>

  <div class="card" style="margin-bottom:0;">
    <div class="stat-card">
      <div class="stat-icon" style="background:#e53935;"><i class="fas fa-users"></i></div>
      <div class="stat-info"><p>Criminals at Station</p><h3><?php echo $total_crim; ?></h3></div>
    </div>
    <a href="view-criminals.php" class="stat-link">(View All)</a>
  </div>

  <!-- Daily News card -->
  <div class="card" style="margin-bottom:0;">
    <div class="stat-card">
      <div class="stat-icon" style="background:#0288d1;"><i class="fas fa-newspaper"></i></div>
      <div class="stat-info"><p>My News Posts</p><h3><?php echo $my_news; ?></h3></div>
    </div>
    <a href="manage_news.php" class="stat-link">(Manage News)</a>
  </div>

</div>

<?php include '../includes/police-footer.php'; ?>