<?php
require_once '../includes/config.php';
$page_title = 'My Profile';
$base_url   = '../';
$breadcrumb = [['label'=>'My Profile']];

if(!isset($_SESSION['policeid'])){ header("Location: login.php"); exit(); }
$pid = $_SESSION['policeid'];

$officer = mysqli_fetch_assoc(mysqli_query($con,"SELECT p.*,ps.PoliceStationName FROM tbl_police p LEFT JOIN tbl_policestation ps ON p.PoliceStationID=ps.id WHERE p.id=$pid"));
if(!$officer){ header("Location: login.php"); exit(); }

$msg = '';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $name   = mysqli_real_escape_string($con, trim($_POST['name']));
    $email  = mysqli_real_escape_string($con, trim($_POST['email']));
    $mobile = mysqli_real_escape_string($con, trim($_POST['mobile']));
    $addr   = mysqli_real_escape_string($con, trim($_POST['address']));
    mysqli_query($con,"UPDATE tbl_police SET Name='$name',Email='$email',MobileNumber='$mobile',Address='$addr' WHERE id=$pid");
    $_SESSION['police_name'] = $name;
    $msg = "<div class='alert alert-success'><i class='fas fa-check-circle'></i> Profile updated successfully!</div>";
    $officer = mysqli_fetch_assoc(mysqli_query($con,"SELECT p.*,ps.PoliceStationName FROM tbl_police p LEFT JOIN tbl_policestation ps ON p.PoliceStationID=ps.id WHERE p.id=$pid"));
}

include '../includes/police-header.php';
?>

<div class="card" style="max-width:700px;">
  <div class="card-title-bar">
    <i class="fas fa-user-circle" style="color:#2196F3;"></i> Officer Profile
    <div class="card-controls"><button><i class="fas fa-minus"></i></button><button><i class="fas fa-times"></i></button></div>
  </div>
  <div class="card-body">
    <?php echo $msg; ?>

    <!-- Read-only info row -->
    <div style="background:#f8f9fa;border-radius:4px;padding:12px 16px;margin-bottom:20px;display:flex;gap:24px;flex-wrap:wrap;font-size:13px;">
      <div><span style="color:#777;">Police ID</span><br><strong><?php echo htmlspecialchars($officer['PoliceID']); ?></strong></div>
      <div><span style="color:#777;">Station</span><br><strong><?php echo htmlspecialchars($officer['PoliceStationName']); ?></strong></div>
      <div><span style="color:#777;">Status</span><br>
        <?php if($officer['Status']): ?>
          <span class="badge badge-active">Active</span>
        <?php else: ?>
          <span class="badge badge-inactive">Inactive</span>
        <?php endif; ?>
      </div>
      <div><span style="color:#777;">Joined</span><br><strong><?php echo date('d M Y',strtotime($officer['CreationDate'])); ?></strong></div>
    </div>

    <form method="POST">
      <table style="width:100%;border-collapse:collapse;">
        <tr>
          <td style="padding:9px 0;width:180px;font-size:13px;color:#555;">Name <span class="req">*</span></td>
          <td style="padding:9px 0;"><input type="text" name="name" class="form-control" required value="<?php echo htmlspecialchars($officer['Name']); ?>"></td>
        </tr>
        <tr>
          <td style="padding:9px 0;font-size:13px;color:#555;">Email</td>
          <td style="padding:9px 0;"><input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($officer['Email']); ?>"></td>
        </tr>
        <tr>
          <td style="padding:9px 0;font-size:13px;color:#555;">Mobile Number <span class="req">*</span></td>
          <td style="padding:9px 0;"><input type="text" name="mobile" class="form-control" required maxlength="15" value="<?php echo htmlspecialchars($officer['MobileNumber']); ?>"></td>
        </tr>
        <tr>
          <td style="padding:9px 0;font-size:13px;color:#555;vertical-align:top;">Address <span class="req">*</span></td>
          <td style="padding:9px 0;"><textarea name="address" class="form-control" required rows="3"><?php echo htmlspecialchars($officer['Address']); ?></textarea></td>
        </tr>
        <tr>
          <td></td>
          <td style="padding-top:14px;"><button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Profile</button></td>
        </tr>
      </table>
    </form>
  </div>
</div>

<?php include '../includes/police-footer.php'; ?>
