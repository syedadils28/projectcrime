<?php
require_once '../includes/config.php';
$page_title = 'Profile';
$base_url   = '../';
$breadcrumb = [['label'=>'Profile']];

if(!isset($_SESSION['policeid'])){ header("Location: login.php"); exit(); }
$pid  = $_SESSION['policeid'];
$officer = mysqli_fetch_assoc(mysqli_query($con,"SELECT p.*,ps.PoliceStationName FROM tbl_police p LEFT JOIN tbl_policestation ps ON p.PoliceStationID=ps.id WHERE p.id=$pid"));

$msg = '';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $name   = mysqli_real_escape_string($con, trim($_POST['name']));
    $email  = mysqli_real_escape_string($con, trim($_POST['email']));
    $mobile = mysqli_real_escape_string($con, trim($_POST['mobile']));
    $addr   = mysqli_real_escape_string($con, trim($_POST['address']));
    mysqli_query($con,"UPDATE tbl_police SET Name='$name',Email='$email',MobileNumber='$mobile',Address='$addr' WHERE id=$pid");
    $_SESSION['police_name'] = $name;
    $_SESSION['police_email'] = $email;
    $msg = "<div class='alert alert-success'><i class='fas fa-check-circle'></i> Profile updated successfully!</div>";
    $officer = mysqli_fetch_assoc(mysqli_query($con,"SELECT p.*,ps.PoliceStationName FROM tbl_police p LEFT JOIN tbl_policestation ps ON p.PoliceStationID=ps.id WHERE p.id=$pid"));
}

include '../includes/police-header.php';
?>

<div class="card" style="max-width:700px;">
  <div class="card-title-bar">
    Officer Profile
    <div class="card-controls">
      <button><i class="fas fa-minus"></i></button>
      <button><i class="fas fa-times"></i></button>
    </div>
  </div>
  <div class="card-body">
    <?php echo $msg; ?>
    <form method="POST">
      <table style="width:100%;border-collapse:collapse;">
        <tr>
          <td style="padding:9px 0;width:220px;font-size:13px;color:#555;">Police ID</td>
          <td style="padding:9px 0;"><input type="text" class="form-control" value="<?php echo htmlspecialchars($officer['PoliceID']); ?>" readonly style="background:#f5f5f5;"></td>
        </tr>
        <tr>
          <td style="padding:9px 0;font-size:13px;color:#555;">Police Station</td>
          <td style="padding:9px 0;"><input type="text" class="form-control" value="<?php echo htmlspecialchars($officer['PoliceStationName']??''); ?>" readonly style="background:#f5f5f5;"></td>
        </tr>
        <tr>
          <td style="padding:9px 0;font-size:13px;color:#555;">Name <span class="req">*</span></td>
          <td style="padding:9px 0;"><input type="text" name="name" class="form-control" required value="<?php echo htmlspecialchars($officer['Name']); ?>"></td>
        </tr>
        <tr>
          <td style="padding:9px 0;font-size:13px;color:#555;">Email</td>
          <td style="padding:9px 0;"><input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($officer['Email']); ?>"></td>
        </tr>
        <tr>
          <td style="padding:9px 0;font-size:13px;color:#555;">Mobile Number <span class="req">*</span></td>
          <td style="padding:9px 0;"><input type="text" name="mobile" class="form-control" required value="<?php echo htmlspecialchars($officer['MobileNumber']); ?>"></td>
        </tr>
        <tr>
          <td style="padding:9px 0;font-size:13px;color:#555;vertical-align:top;padding-top:13px;">Address <span class="req">*</span></td>
          <td style="padding:9px 0;"><textarea name="address" class="form-control" rows="3" required><?php echo htmlspecialchars($officer['Address']); ?></textarea></td>
        </tr>
        <tr>
          <td></td>
          <td style="padding-top:12px;"><button type="submit" class="btn btn-primary">Update Profile</button></td>
        </tr>
      </table>
    </form>
  </div>
</div>

<?php include '../includes/police-footer.php'; ?>
