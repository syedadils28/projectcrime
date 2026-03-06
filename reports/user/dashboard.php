<?php
require_once '../includes/config.php';
$page_title = 'Dashboard';
$base_url = '../';
$uid = $_SESSION['userid'];

$total_fir   = mysqli_fetch_row(mysqli_query($con,"SELECT COUNT(*) FROM tbl_fir WHERE UserID=$uid"))[0];
$pending_fir = mysqli_fetch_row(mysqli_query($con,"SELECT COUNT(*) FROM tbl_fir WHERE UserID=$uid AND FIRStatus='Pending'"))[0];
$solved_fir  = mysqli_fetch_row(mysqli_query($con,"SELECT COUNT(*) FROM tbl_fir WHERE UserID=$uid AND FIRStatus='Solved'"))[0];

include '../includes/user-header.php';
?>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">
  <div class="card" style="margin-bottom:0;">
    <div class="stat-card">
      <div class="stat-icon fir"><i class="fas fa-file-alt"></i></div>
      <div class="stat-info">
        <p>Total FIRs Filed</p>
        <h3><?php echo $total_fir; ?></h3>
      </div>
    </div>
    <a href="fir-history.php" class="stat-link">(View All)</a>
  </div>

  <div class="card" style="margin-bottom:0;">
    <div class="stat-card">
      <div class="stat-icon history"><i class="fas fa-clock"></i></div>
      <div class="stat-info">
        <p>Pending FIRs</p>
        <h3><?php echo $pending_fir; ?></h3>
      </div>
    </div>
    <a href="fir-history.php" class="stat-link">(View All)</a>
  </div>

  <div class="card" style="margin-bottom:0;">
    <div class="stat-card">
      <div class="stat-icon" style="background:#4CAF50;"><i class="fas fa-check-circle"></i></div>
      <div class="stat-info">
        <p>Solved FIRs</p>
        <h3><?php echo $solved_fir; ?></h3>
      </div>
    </div>
    <a href="fir-history.php" class="stat-link">(View All)</a>
  </div>

  <div class="card" style="margin-bottom:0;">
    <div class="stat-card">
      <div class="stat-icon cs"><i class="fas fa-file-invoice"></i></div>
      <div class="stat-info">
        <p>File New FIR</p>
        <h3><span style="font-size:14px;font-weight:400;">Click to file</span></h3>
      </div>
    </div>
    <a href="fir-form.php" class="stat-link">(File FIR)</a>
  </div>
</div>

<?php include '../includes/user-footer.php'; ?>
