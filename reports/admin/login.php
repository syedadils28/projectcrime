<?php
require_once '../includes/config.php';
if(isset($_SESSION['adminid'])){
    header("Location: dashboard.php");
    exit();
}
$err='';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $user = mysqli_real_escape_string($con, trim($_POST['username']));
    $pass = md5(trim($_POST['password']));
    $q = mysqli_query($con,"SELECT * FROM tbl_admin WHERE UserName='$user' AND Password='$pass'");
    if(mysqli_num_rows($q)===1){
        $row=mysqli_fetch_assoc($q);
        $_SESSION['adminid']=$row['id'];
        $_SESSION['admin_name']=$row['FullName'];
        $_SESSION['admin_email']=$row['AdminEmail'];
        header("Location: dashboard.php");
        exit();
    } else {
        $err="Invalid username or password!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Admin Login | Crime Record Management System</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="auth-page">
  <a href="../index.php" style="position:absolute;top:15px;left:15px;color:#2196F3;font-size:22px;"><i class="fas fa-home"></i></a>
  <div class="auth-card">
    <div class="auth-title-bar">
      <span>Admin Login</span>
    </div>
    <div class="auth-body">
      <div class="auth-site-name">Crime Record Management System</div>
      <?php if($err): ?>
        <div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> <?php echo $err; ?></div>
      <?php endif; ?>
      <form method="POST" action="">
        <div style="margin-bottom:14px;">
          <label class="auth-label">Username <span class="req">*</span></label>
          <div class="auth-input-wrap">
            <input type="text" name="username" class="auth-input" placeholder="Username" required>
            <i class="fas fa-user auth-icon"></i>
          </div>
        </div>
        <div style="margin-bottom:16px;">
          <label class="auth-label">Password <span class="req">*</span></label>
          <div class="auth-input-wrap">
            <input type="password" name="password" class="auth-input" placeholder="Password" required>
            <i class="fas fa-lock auth-icon"></i>
          </div>
        </div>
        <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;padding:9px;">Login</button>
      </form>
    </div>
    <div class="auth-footer">
      Default: admin / Test@12345
    </div>
  </div>
</div>
</body>
</html>
