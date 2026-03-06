<?php
if(!isset($_SESSION['userid'])){
    header("Location: ../user/signin.php");
    exit();
}
$user_name  = $_SESSION['user_name']  ?? 'User';
$user_email = $_SESSION['user_email'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title><?php echo isset($page_title)?$page_title.' | ':''; ?>Crime Record Management System | User Panel</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="<?php echo $base_url??'../';?>css/style.css">
</head>
<body class="user-panel">

<!-- TOP HEADER -->
<header class="top-header">
  <div class="brand">Crime Record Management System | <span>User Panel</span></div>
  <div style="display:flex;align-items:center;gap:18px;">
    <!-- Notification bell -->
    <div class="notif-bell">
      <i class="fas fa-bell"></i>
      <?php
      $uid=$_SESSION['userid'];
      $notif_count = mysqli_fetch_row(mysqli_query($con,"SELECT COUNT(*) FROM tbl_fir WHERE UserID=$uid AND FIRStatus IN ('Inprogress','Solved')"))[0];
      if($notif_count>0): ?>
        <span class="badge-notif"><?php echo $notif_count; ?></span>
      <?php endif; ?>
    </div>
    <div class="user-info" onclick="toggleUserDropdown()">
      <img src="<?php echo $base_url??'../';?>images/user.png" onerror="this.src='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 40 40%22><circle cx=%2220%22 cy=%2220%22 r=%2220%22 fill=%22%232196F3%22/><text x=%2250%25%22 y=%2255%25%22 dominant-baseline=%22middle%22 text-anchor=%22middle%22 fill=%22white%22 font-size=%2218%22><?php echo strtoupper(substr($user_name,0,1)); ?></text></svg>'">
      <div>
        <div class="uname"><?php echo htmlspecialchars($user_name); ?></div>
        <div class="uemail"><?php echo htmlspecialchars($user_email); ?></div>
      </div>
      <i class="fas fa-chevron-down" style="font-size:11px;color:#aaa;"></i>
    </div>
    <div class="user-dropdown" id="userDropdown">
      <a href="<?php echo $base_url??'../';?>user/profile.php"><i class="fas fa-user" style="width:16px;"></i> Profile</a>
      <a href="<?php echo $base_url??'../';?>user/change-password.php"><i class="fas fa-key" style="width:16px;"></i> Change Password</a>
      <a href="<?php echo $base_url??'../';?>logout.php"><i class="fas fa-sign-out-alt" style="width:16px;"></i> Logout</a>
    </div>
  </div>
</header>

<!-- SIDEBAR -->
<nav class="sidebar">
  <div class="sidebar-brand">Navigation</div>
  <ul>
    <li>
      <a href="<?php echo $base_url??'../';?>user/dashboard.php" class="<?php echo basename($_SERVER['PHP_SELF'])=='dashboard.php'?'active':''; ?>">
        <i class="fas fa-tachometer-alt"></i> Dashboard
      </a>
    </li>
    <li>
      <a href="<?php echo $base_url??'../';?>user/fir-form.php" class="<?php echo basename($_SERVER['PHP_SELF'])=='fir-form.php'?'active':''; ?>">
        <i class="fas fa-file-alt"></i> FIR Form
      </a>
    </li>
    <li>
      <a href="<?php echo $base_url??'../';?>user/fir-history.php" class="<?php echo basename($_SERVER['PHP_SELF'])=='fir-history.php'?'active':''; ?>">
        <i class="fas fa-history"></i> FIR History
      </a>
    </li>
    <li>
      <a href="<?php echo $base_url??'../';?>user/charge-sheet.php" class="<?php echo basename($_SERVER['PHP_SELF'])=='charge-sheet.php'?'active':''; ?>">
        <i class="fas fa-file-invoice"></i> Charge Sheet
      </a>
    </li>
    <li>
      <a href="<?php echo $base_url??'../';?>user/search.php" class="<?php echo basename($_SERVER['PHP_SELF'])=='search.php'?'active':''; ?>">
        <i class="fas fa-search"></i> Search
      </a>
    </li>
  </ul>
</nav>

<div class="main-content">
  <div class="page-header-bar">
    <h4><?php echo isset($page_title)?htmlspecialchars($page_title):'Dashboard'; ?></h4>
    <div class="breadcrumb-bar">
      <a href="<?php echo $base_url??'../';?>user/dashboard.php"><i class="fas fa-home"></i></a>
      <span>/</span>
      <span>User</span>
      <?php if(isset($page_title)): ?>
        <span>/</span>
        <span><?php echo htmlspecialchars($page_title); ?></span>
      <?php endif; ?>
      <button class="back-btn" onclick="history.back()"><i class="fas fa-arrow-left"></i></button>
    </div>
  </div>
  <div class="page-body">
