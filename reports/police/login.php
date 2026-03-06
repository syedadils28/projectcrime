<?php
require_once '../includes/config.php';
if(isset($_SESSION['policeid'])){ header("Location: dashboard.php"); exit(); }

$msg = '';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $police_id = mysqli_real_escape_string($con, trim($_POST['police_id']));
    $password  = md5(trim($_POST['password']));
    $q = mysqli_query($con,"SELECT * FROM tbl_police WHERE PoliceID='$police_id' AND Password='$password' AND Status=1");
    if(mysqli_num_rows($q)===1){
        $row = mysqli_fetch_assoc($q);
        $_SESSION['policeid']       = $row['id'];
        $_SESSION['police_name']    = $row['Name'];
        $_SESSION['police_email']   = $row['Email'];
        $_SESSION['police_station'] = $row['PoliceStationID'];
        header("Location: dashboard.php");
        exit();
    } else {
        $msg = "<div class='alert alert-danger'><i class='fas fa-times-circle'></i> Invalid Police ID or password!</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Police Login | Crime Record Management System</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="auth-page">
  <a href="../index.php" style="position:absolute;top:15px;left:15px;color:#2196F3;font-size:22px;"><i class="fas fa-home"></i></a>
  <div class="auth-card">
    <div class="auth-title-bar">
      <span>Police Login</span>
    </div>
    <div class="auth-body">
      <div class="auth-site-name">Crime Record Management System</div>
      <div style="border-bottom:3px solid #2196F3;margin-bottom:20px;"></div>
      <?php echo $msg; ?>
      <form method="POST" action="">
        <div style="margin-bottom:14px;">
          <label class="auth-label">Police ID <span class="req">*</span></label>
          <div class="auth-input-wrap">
            <input type="text" name="police_id" class="auth-input" placeholder="Enter Police ID" required
                   value="<?php echo isset($_POST['police_id'])?htmlspecialchars($_POST['police_id']):''; ?>">
            <i class="fas fa-id-badge auth-icon"></i>
          </div>
        </div>
        <div style="margin-bottom:16px;">
          <label class="auth-label">Password <span class="req">*</span></label>
          <div class="auth-input-wrap">
            <input type="password" name="password" class="auth-input" placeholder="Password" required>
            <i class="fas fa-lock auth-icon"></i>
          </div>
        </div>
        <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;padding:9px;">
          <i class="fas fa-shield-alt"></i> Login
        </button>
      </form>
    </div>
    <div class="auth-footer">
      Demo: Police ID <strong>CNTD01</strong> / Password <strong>Test@123</strong>
    </div>
  </div>
</div>
</body>
</html>
