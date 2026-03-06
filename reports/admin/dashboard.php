<?php
require_once '../includes/config.php';
$page_title = 'Dashboard';
$base_url = '../';

$total_criminals = mysqli_fetch_row(mysqli_query($con,"SELECT COUNT(*) FROM tbl_criminal"))[0];
$total_police    = mysqli_fetch_row(mysqli_query($con,"SELECT COUNT(*) FROM tbl_police"))[0];
$total_category  = mysqli_fetch_row(mysqli_query($con,"SELECT COUNT(*) FROM tbl_crimecategory"))[0];
$total_stations  = mysqli_fetch_row(mysqli_query($con,"SELECT COUNT(*) FROM tbl_policestation"))[0];
$total_fir       = mysqli_fetch_row(mysqli_query($con,"SELECT COUNT(*) FROM tbl_fir"))[0];

include '../includes/admin-header.php';
?>

<div class="dash-grid">
  <!-- Total Criminals -->
  <div class="card" style="margin-bottom:0;">
    <div class="stat-card">
      <div class="stat-icon teal"><i class="fas fa-users"></i></div>
      <div class="stat-info">
        <p>Total Criminals</p>
        <h3><?php echo $total_criminals; ?></h3>
      </div>
    </div>
    <a href="view-criminals.php" class="stat-link">(view all)</a>
  </div>

  <!-- Total Police -->
  <div class="card" style="margin-bottom:0;">
    <div class="stat-card">
      <div class="stat-icon red"><i class="fas fa-user-shield"></i></div>
      <div class="stat-info">
        <p>Total Police</p>
        <h3><?php echo $total_police; ?></h3>
      </div>
    </div>
    <a href="manage-police.php" class="stat-link">(View All)</a>
  </div>

  <!-- Total Crime Categories -->
  <div class="card" style="margin-bottom:0;">
    <div class="stat-card">
      <div class="stat-icon green"><i class="fas fa-file-alt"></i></div>
      <div class="stat-info">
        <p>Total Crime Categories</p>
        <h3><?php echo $total_category; ?></h3>
      </div>
    </div>
    <a href="manage-crime-categories.php" class="stat-link">(View All)</a>
  </div>

  <!-- Total Police Stations -->
  <div class="card" style="margin-bottom:0;">
    <div class="stat-card">
      <div class="stat-icon purple"><i class="fas fa-building"></i></div>
      <div class="stat-info">
        <p>Total Police Stations</p>
        <h3><?php echo $total_stations; ?></h3>
      </div>
    </div>
    <a href="manage-police-stations.php" class="stat-link">(view all)</a>
  </div>
</div>

<div style="margin-top:20px;">
  <div class="card" style="max-width:400px;">
    <div class="stat-card">
      <div class="stat-icon purple"><i class="fas fa-file-alt"></i></div>
      <div class="stat-info">
        <p>Total FIRS</p>
        <h3><?php echo $total_fir; ?></h3>
      </div>
    </div>
    <a href="view-fir.php" class="stat-link">(View All)</a>
  </div>
</div>

<?php include '../includes/admin-footer.php'; ?>
