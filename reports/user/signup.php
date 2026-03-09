<?php
require_once '../includes/config.php';
if(isset($_SESSION['userid'])){ header("Location: dashboard.php"); exit(); }

$msg='';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $name   = mysqli_real_escape_string($con,trim($_POST['name']));
    $email  = mysqli_real_escape_string($con,trim($_POST['email']));
    $mobile = mysqli_real_escape_string($con,trim($_POST['mobile']));
    $pass   = md5(trim($_POST['password']));

    if(empty($name)||empty($email)||empty($mobile)||empty($_POST['password'])){
        $msg="<div class='alert alert-danger'><i class='fas fa-times-circle'></i> All fields are required!</div>";
    } else {
        $chk=mysqli_fetch_row(mysqli_query($con,"SELECT id FROM tbl_user WHERE Email='$email'"));
        if($chk){
            $msg="<div class='alert alert-danger'><i class='fas fa-times-circle'></i> Email already registered!</div>";
        } else {
            mysqli_query($con,"INSERT INTO tbl_user (FullName,Email,MobileNumber,Password,Status) VALUES('$name','$email','$mobile','$pass',1)");
            $uid=mysqli_insert_id($con);
            $_SESSION['userid']=$uid;
            $_SESSION['user_name']=$name;
            $_SESSION['user_email']=$email;
            header("Location: dashboard.php");
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Sign Up | Crime Record Management System</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="auth-page" style="background:#f0f2f5;">
  <a href="../index.php" style="position:absolute;top:15px;left:15px;color:#2196F3;font-size:22px;"><i class="fas fa-home"></i></a>

  <div class="auth-card" style="width:680px;height:900px;max-width:60%;">
    <div class="auth-title-bar" style="background:#2196F3;">
      <span></span>
      <button class="tab-btn">&#9650; SIGN UP</button>
    </div>
    <div class="auth-body">
      <div class="auth-site-name">Crime Record Management System</div>
      <div style="border-bottom:3px solid #2196F3;margin-bottom:20px;"></div>
      <?php echo $msg; ?>
      <form method="POST">
        <div style="margin-bottom:12px;">
          <label class="auth-label">Full Name</label>
          <input type="text" name="name" class="auth-input" placeholder="Full Name" required value="<?php echo isset($_POST['name'])?htmlspecialchars($_POST['name']):''; ?>">
        </div>
        <div style="margin-bottom:12px;">
          <label class="auth-label">E-mail Address</label>
          <input type="email" name="email" class="auth-input" placeholder="Email" required value="<?php echo isset($_POST['email'])?htmlspecialchars($_POST['email']):''; ?>">
        </div>
        <div style="margin-bottom:12px;">
          <label class="auth-label">Mobile Number</label>
          <input type="text" name="mobile" class="auth-input" placeholder="Mobile" required maxlength="15">
        </div>
        <div style="margin-bottom:16px;">
          <label class="auth-label">Mobile Number</label>
          <input type="password" name="password" class="auth-input" placeholder="Password" required>
        </div>
        <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;padding:9px;">Sign Up</button>
      </form>
    </div>
    <div class="auth-divider">OR</div>
    <div class="auth-footer">
      Already have an account? <a href="signin.php">Sign In!</a>
    </div>
  </div>
</div>
</body>
</html>
