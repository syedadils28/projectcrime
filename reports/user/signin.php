<?php
require_once '../includes/config.php';
if(isset($_SESSION['userid'])){ header("Location: dashboard.php"); exit(); }

$msg='';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $email = mysqli_real_escape_string($con,trim($_POST['email']));
    $pass  = md5(trim($_POST['password']));
    $q     = mysqli_query($con,"SELECT * FROM tbl_user WHERE Email='$email' AND Password='$pass' AND Status=1");
    if(mysqli_num_rows($q)===1){
        $row=mysqli_fetch_assoc($q);
        $_SESSION['userid']=$row['id'];
        $_SESSION['user_name']=$row['FullName'];
        $_SESSION['user_email']=$row['Email'];
        header("Location: dashboard.php");
        exit();
    } else {
        $msg="<div class='alert alert-danger'><i class='fas fa-times-circle'></i> Invalid email or password!</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Sign In | Crime Record Management System</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="auth-page" style="background:#f0f2f5;">
  <a href="../index.php" style="position:absolute;top:15px;left:15px;color:#2196F3;font-size:22px;"><i class="fas fa-home"></i></a>

  <div class="auth-card" style="width:380px;">
    <div class="auth-title-bar" style="background:#2196F3;">
      <span></span>
      <button class="tab-btn">&#9650; SIGN IN</button>
    </div>
    <div class="auth-body">
      <div class="auth-site-name">Crime Record Management System</div>
      <div style="border-bottom:3px solid #2196F3;margin-bottom:20px;"></div>
      <?php echo $msg; ?>
      <form method="POST">
        <div style="margin-bottom:12px;">
          <label class="auth-label">Email</label>
          <div class="auth-input-wrap">
            <input type="email" name="email" class="auth-input" placeholder="Email" required value="<?php echo isset($_POST['email'])?htmlspecialchars($_POST['email']):''; ?>">
            <i class="fas fa-user auth-icon"></i>
          </div>
        </div>
        <div style="margin-bottom:16px;">
          <label class="auth-label">Password <a href="forgot-password.php" class="lost-pwd">Lost Password?</a></label>
          <div class="auth-input-wrap">
            <input type="password" name="password" class="auth-input" placeholder="Password" required>
            <i class="fas fa-lock auth-icon"></i>
          </div>
        </div>
        <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;padding:9px;">Sign In</button>
      </form>
    </div>
    <div class="auth-divider">OR</div>
    <div class="auth-footer">
      Not Registered Yet? <a href="signup.php">Sign up!</a>
    </div>
  </div>
</div>
</body>
</html>
