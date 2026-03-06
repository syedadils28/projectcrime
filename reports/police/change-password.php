<?php
require_once '../includes/config.php';
$page_title = 'Change Password';
$base_url   = '../';
$breadcrumb = [['label'=>'Change Password']];
if(!isset($_SESSION['policeid'])){ header("Location: login.php"); exit(); }
$pid = $_SESSION['policeid'];
$msg = '';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $cur=md5(trim($_POST['current'])); $new=trim($_POST['newpass']); $conf=trim($_POST['confirm']);
    $chk=mysqli_fetch_row(mysqli_query($con,"SELECT id FROM tbl_police WHERE id=$pid AND Password='$cur'"));
    if(!$chk)        $msg="<div class='alert alert-danger'><i class='fas fa-times-circle'></i> Current password is incorrect!</div>";
    elseif($new!==$conf) $msg="<div class='alert alert-danger'><i class='fas fa-times-circle'></i> New passwords do not match!</div>";
    elseif(strlen($new)<6) $msg="<div class='alert alert-danger'><i class='fas fa-times-circle'></i> Password must be at least 6 characters!</div>";
    else { mysqli_query($con,"UPDATE tbl_police SET Password='".md5($new)."' WHERE id=$pid"); $msg="<div class='alert alert-success'><i class='fas fa-check-circle'></i> Password changed successfully!</div>"; }
}
include '../includes/police-header.php';
?>
<div class="card" style="max-width:560px;">
  <div class="card-title-bar">Change Password
    <div class="card-controls"><button><i class="fas fa-minus"></i></button><button><i class="fas fa-times"></i></button></div>
  </div>
  <div class="card-body">
    <?php echo $msg; ?>
    <form method="POST">
      <table style="width:100%;border-collapse:collapse;">
        <tr><td style="padding:9px 0;width:200px;font-size:13px;color:#555;">Current Password <span class="req">*</span></td>
            <td><input type="password" name="current" class="form-control" required placeholder="Enter current password"></td></tr>
        <tr><td style="padding:9px 0;font-size:13px;color:#555;">New Password <span class="req">*</span></td>
            <td><input type="password" name="newpass" class="form-control" required minlength="6" placeholder="Min. 6 characters"></td></tr>
        <tr><td style="padding:9px 0;font-size:13px;color:#555;">Confirm Password <span class="req">*</span></td>
            <td><input type="password" name="confirm" class="form-control" required placeholder="Repeat new password"></td></tr>
        <tr><td></td><td style="padding-top:14px;"><button type="submit" class="btn btn-primary"><i class="fas fa-key"></i> Update Password</button></td></tr>
      </table>
    </form>
  </div>
</div>
<?php include '../includes/police-footer.php'; ?>
