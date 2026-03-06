<?php
require_once '../includes/config.php';
$page_title = 'Profile';
$base_url = '../';
$uid = $_SESSION['userid'];
$user = mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM tbl_user WHERE id=$uid"));

$msg='';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $name   = mysqli_real_escape_string($con,trim($_POST['name']));
    $email  = mysqli_real_escape_string($con,trim($_POST['email']));
    $mobile = mysqli_real_escape_string($con,trim($_POST['mobile']));
    mysqli_query($con,"UPDATE tbl_user SET FullName='$name',Email='$email',MobileNumber='$mobile' WHERE id=$uid");
    $_SESSION['user_name']=$name;
    $_SESSION['user_email']=$email;
    $msg="<div class='alert alert-success'><i class='fas fa-check-circle'></i> Profile updated successfully!</div>";
    $user = mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM tbl_user WHERE id=$uid"));
}
include '../includes/user-header.php';
?>

<div class="card" style="max-width:700px;">
  <div class="card-title-bar">
    User Profile
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
          <td style="padding:9px 0;width:220px;font-size:13px;color:#555;">Name <span class="req">*</span></td>
          <td style="padding:9px 0;"><input type="text" name="name" class="form-control" required value="<?php echo htmlspecialchars($user['FullName']); ?>"></td>
        </tr>
        <tr>
          <td style="padding:9px 0;font-size:13px;color:#555;">Email <span class="req">*</span></td>
          <td style="padding:9px 0;"><input type="email" name="email" class="form-control" required value="<?php echo htmlspecialchars($user['Email']); ?>"></td>
        </tr>
        <tr>
          <td style="padding:9px 0;font-size:13px;color:#555;">Contact Number</td>
          <td style="padding:9px 0;"><input type="text" name="mobile" class="form-control" value="<?php echo htmlspecialchars($user['MobileNumber']); ?>"></td>
        </tr>
        <tr>
          <td style="padding:9px 0;font-size:13px;color:#555;">Registration Date <span class="req">*</span></td>
          <td style="padding:9px 0;"><input type="text" class="form-control" value="<?php echo $user['RegistrationDate']; ?>" readonly></td>
        </tr>
        <tr>
          <td></td>
          <td style="padding-top:12px;"><button type="submit" class="btn btn-primary">Update</button></td>
        </tr>
      </table>
    </form>
  </div>
</div>

<?php include '../includes/user-footer.php'; ?>
