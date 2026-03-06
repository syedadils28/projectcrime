<?php
require_once '../includes/config.php';
if(isset($_SESSION['userid'])){ header("Location: dashboard.php"); exit(); }

$msg = '';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $email  = mysqli_real_escape_string($con, trim($_POST['email']));
    $mobile = mysqli_real_escape_string($con, trim($_POST['mobile']));

    $user = mysqli_fetch_assoc(mysqli_query($con,
        "SELECT * FROM tbl_user WHERE Email='$email' AND MobileNumber='$mobile'"
    ));

    if($user){
        // Generate a temporary password
        $tmp_pass = 'Crms@' . rand(1000,9999);
        mysqli_query($con,
            "UPDATE tbl_user SET Password='".md5($tmp_pass)."' WHERE id=".$user['id']
        );
        $msg = "<div class='alert alert-success'>
            <i class='fas fa-check-circle'></i>
            Your temporary password is: <strong>$tmp_pass</strong><br>
            <small>Please sign in and change your password immediately.</small>
          </div>";
    } else {
        $msg = "<div class='alert alert-danger'>
            <i class='fas fa-times-circle'></i>
            No account found with that email and mobile number.
          </div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Forgot Password | Crime Record Management System</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="auth-page" style="background:#f0f2f5;">
  <a href="../index.php" style="position:absolute;top:15px;left:15px;color:#2196F3;font-size:22px;">
    <i class="fas fa-home"></i>
  </a>

  <div class="auth-card" style="width:400px;">
    <div class="auth-title-bar" style="background:#FF9800;">
      <span>Forgot Password</span>
    </div>
    <div class="auth-body">
      <div class="auth-site-name">Crime Record Management System</div>
      <div style="border-bottom:3px solid #FF9800;margin-bottom:20px;"></div>

      <?php echo $msg; ?>

      <p style="font-size:13px;color:#777;margin-bottom:18px;">
        Enter your registered email address and mobile number to retrieve a temporary password.
      </p>

      <form method="POST">
        <div style="margin-bottom:14px;">
          <label class="auth-label">Registered Email <span class="req">*</span></label>
          <div class="auth-input-wrap">
            <input type="email" name="email" class="auth-input" placeholder="Email Address" required
              value="<?php echo isset($_POST['email'])?htmlspecialchars($_POST['email']):''; ?>">
            <i class="fas fa-envelope auth-icon"></i>
          </div>
        </div>
        <div style="margin-bottom:18px;">
          <label class="auth-label">Mobile Number <span class="req">*</span></label>
          <div class="auth-input-wrap">
            <input type="text" name="mobile" class="auth-input" placeholder="Registered Mobile Number" required>
            <i class="fas fa-phone auth-icon"></i>
          </div>
        </div>
        <button type="submit" class="btn btn-warning" style="width:100%;justify-content:center;padding:9px;color:#fff;">
          <i class="fas fa-key"></i> Get Temporary Password
        </button>
      </form>
    </div>
    <div class="auth-divider">OR</div>
    <div class="auth-footer">
      Remembered your password? <a href="signin.php">Sign In!</a>
    </div>
  </div>
</div>
</body>
</html>
