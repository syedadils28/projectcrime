<?php
require_once '../includes/config.php';
$page_title = 'FIR Form';
$base_url = '../';
$uid = $_SESSION['userid'];

$stations   = mysqli_query($con,"SELECT * FROM tbl_policestation ORDER BY PoliceStationName");
$categories = mysqli_query($con,"SELECT * FROM tbl_crimecategory ORDER BY CrimeCategory");

$msg='';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $station_id = (int)$_POST['station_id'];
    $cat_id     = (int)$_POST['category_id'];
    $subject    = mysqli_real_escape_string($con,trim($_POST['subject']));
    $detail     = mysqli_real_escape_string($con,trim($_POST['detail']));

    if(empty($subject)||empty($detail)||!$station_id||!$cat_id){
        $msg="<div class='alert alert-danger'><i class='fas fa-times-circle'></i> All fields are required!</div>";
    } else {
        mysqli_query($con,"INSERT INTO tbl_fir (UserID,PoliceStationID,CrimeCategoryID,FIRSubject,FIRDetail) VALUES($uid,$station_id,$cat_id,'$subject','$detail')");
        $msg="<div class='alert alert-success'><i class='fas fa-check-circle'></i> FIR filed successfully! We will process your request.</div>";
    }
}
include '../includes/user-header.php';
?>

<div class="card">
  <div class="card-title-bar">
    File FIR (First Information Report)
    <div class="card-controls">
      <button><i class="fas fa-minus"></i></button>
      <button><i class="fas fa-times"></i></button>
    </div>
  </div>
  <div class="card-body">
    <?php echo $msg; ?>
    <form method="POST">
      <table style="width:100%;max-width:750px;border-collapse:collapse;">
        <tr>
          <td style="padding:9px 0;width:220px;font-size:13px;color:#555;">Police Station <span class="req">*</span></td>
          <td style="padding:9px 0;">
            <select name="station_id" class="form-control" required>
              <option value="">-- Select Police Station --</option>
              <?php while($s=mysqli_fetch_assoc($stations)): ?>
              <option value="<?php echo $s['id']; ?>"><?php echo htmlspecialchars($s['PoliceStationName']); ?></option>
              <?php endwhile; ?>
            </select>
          </td>
        </tr>
        <tr>
          <td style="padding:9px 0;font-size:13px;color:#555;">Crime Category <span class="req">*</span></td>
          <td style="padding:9px 0;">
            <select name="category_id" class="form-control" required>
              <option value="">-- Select Category --</option>
              <?php while($c=mysqli_fetch_assoc($categories)): ?>
              <option value="<?php echo $c['id']; ?>"><?php echo htmlspecialchars($c['CrimeCategory']); ?></option>
              <?php endwhile; ?>
            </select>
          </td>
        </tr>
        <tr>
          <td style="padding:9px 0;font-size:13px;color:#555;">FIR Subject <span class="req">*</span></td>
          <td style="padding:9px 0;"><input type="text" name="subject" class="form-control" required placeholder="Brief subject of FIR"></td>
        </tr>
        <tr>
          <td style="padding:9px 0;font-size:13px;color:#555;">FIR Detail <span class="req">*</span></td>
          <td style="padding:9px 0;"><textarea name="detail" class="form-control" rows="5" required placeholder="Detailed description of the incident..."></textarea></td>
        </tr>
        <tr>
          <td></td>
          <td style="padding-top:12px;">
            <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Submit FIR</button>
          </td>
        </tr>
      </table>
    </form>
  </div>
</div>

<?php include '../includes/user-footer.php'; ?>
