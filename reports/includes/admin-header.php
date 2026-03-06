<?php
if(!isset($_SESSION['adminid'])){
    header("Location: ../index.php");
    exit();
}
$admin_name = $_SESSION['admin_name'] ?? 'Admin';
$admin_email = $_SESSION['admin_email'] ?? 'admin@gmail.com';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title><?php echo isset($page_title)?$page_title.' | ':''; ?>Crime Record Mgmt System | Admin Panel</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="<?php echo $base_url??'../';?>css/style.css">
<style>
/* Fix top header for admin */
.top-header .brand{ font-size:15px; font-weight:500; }
</style>
</head>
<body>

<!-- TOP HEADER -->
<header class="top-header">
  <div class="brand">Crime Record Management System | <span>Admin Panel</span></div>
  <div style="display:flex;align-items:center;gap:18px;">
    <div class="user-info" onclick="toggleDropdown()">
      <img src="<?php echo $base_url??'../';?>images/admin.png" onerror="this.src='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 40 40%22><circle cx=%2220%22 cy=%2220%22 r=%2220%22 fill=%22%232196F3%22/><text x=%2250%25%22 y=%2255%25%22 dominant-baseline=%22middle%22 text-anchor=%22middle%22 fill=%22white%22 font-size=%2218%22><?php echo strtoupper(substr($admin_name,0,1)); ?></text></svg>'">
      <div>
        <div class="uname"><?php echo htmlspecialchars($admin_name); ?></div>
        <div class="uemail"><?php echo htmlspecialchars($admin_email); ?></div>
      </div>
      <i class="fas fa-chevron-down" style="font-size:11px;color:#aaa;"></i>
    </div>
    <div class="user-dropdown" id="adminDropdown">
      <a href="<?php echo $base_url??'../';?>admin/change-password.php"><i class="fas fa-key" style="width:16px;"></i> Change Password</a>
      <a href="<?php echo $base_url??'../';?>logout.php"><i class="fas fa-sign-out-alt" style="width:16px;"></i> Logout</a>
    </div>
  </div>
</header>

<!-- SIDEBAR -->
<nav class="sidebar">
  <div class="sidebar-brand">Navigation</div>
  <ul>
    <li>
      <a href="<?php echo $base_url??'../';?>admin/dashboard.php" class="<?php echo (basename($_SERVER['PHP_SELF'])=='dashboard.php')?'active':''; ?>">
        <i class="fas fa-tachometer-alt"></i> Dashboard
      </a>
    </li>
    <li class="has-sub <?php echo in_array(basename($_SERVER['PHP_SELF']),['add-police-station.php','manage-police-stations.php'])?'open':''; ?>">
      <a href="#"><i class="fas fa-building"></i> Police Station</a>
      <ul class="submenu">
        <li><a href="<?php echo $base_url??'../';?>admin/add-police-station.php" class="<?php echo (basename($_SERVER['PHP_SELF'])=='add-police-station.php')?'active':''; ?>">Add Police Station</a></li>
        <li><a href="<?php echo $base_url??'../';?>admin/manage-police-stations.php" class="<?php echo (basename($_SERVER['PHP_SELF'])=='manage-police-stations.php')?'active':''; ?>">Manage Police Station</a></li>
      </ul>
    </li>
    <li class="has-sub <?php echo in_array(basename($_SERVER['PHP_SELF']),['add-police.php','manage-police.php'])?'open':''; ?>">
      <a href="#"><i class="fas fa-user-shield"></i> Police</a>
      <ul class="submenu">
        <li><a href="<?php echo $base_url??'../';?>admin/add-police.php" class="<?php echo (basename($_SERVER['PHP_SELF'])=='add-police.php')?'active':''; ?>">Add Police</a></li>
        <li><a href="<?php echo $base_url??'../';?>admin/manage-police.php" class="<?php echo (basename($_SERVER['PHP_SELF'])=='manage-police.php')?'active':''; ?>">Manage Police</a></li>
      </ul>
    </li>
    <li class="has-sub <?php echo in_array(basename($_SERVER['PHP_SELF']),['add-crime-category.php','manage-crime-categories.php'])?'open':''; ?>">
      <a href="#"><i class="fas fa-tags"></i> Crime Category</a>
      <ul class="submenu">
        <li><a href="<?php echo $base_url??'../';?>admin/add-crime-category.php" class="<?php echo (basename($_SERVER['PHP_SELF'])=='add-crime-category.php')?'active':''; ?>">Add Crime Category</a></li>
        <li><a href="<?php echo $base_url??'../';?>admin/manage-crime-categories.php" class="<?php echo (basename($_SERVER['PHP_SELF'])=='manage-crime-categories.php')?'active':''; ?>">Manage Crime Category</a></li>
      </ul>
    </li>
    <li>
      <a href="<?php echo $base_url??'../';?>admin/view-criminals.php" class="<?php echo (basename($_SERVER['PHP_SELF'])=='view-criminals.php'||basename($_SERVER['PHP_SELF'])=='add-criminal.php')?'active':''; ?>">
        <i class="fas fa-user-slash"></i> View Criminals
      </a>
    </li>
    <li>
      <a href="<?php echo $base_url??'../';?>admin/view-fir.php" class="<?php echo (basename($_SERVER['PHP_SELF'])=='view-fir.php'||basename($_SERVER['PHP_SELF'])=='view-fir-detail.php')?'active':''; ?>">
        <i class="fas fa-file-alt"></i> View FIR
      </a>
    </li>
    <li class="has-sub <?php echo in_array(basename($_SERVER['PHP_SELF']),['report-criminals.php','report-fir.php'])?'open':''; ?>">
      <a href="#"><i class="fas fa-chart-bar"></i> Reports</a>
      <ul class="submenu">
        <li><a href="<?php echo $base_url??'../';?>admin/report-criminals.php" class="<?php echo (basename($_SERVER['PHP_SELF'])=='report-criminals.php')?'active':''; ?>">Criminal Report</a></li>
        <li><a href="<?php echo $base_url??'../';?>admin/report-fir.php" class="<?php echo (basename($_SERVER['PHP_SELF'])=='report-fir.php')?'active':''; ?>">FIR Report</a></li>
      </ul>
    </li>
    <li class="has-sub <?php echo in_array(basename($_SERVER['PHP_SELF']),['search-criminal.php','search-fir.php'])?'open':''; ?>">
      <a href="#"><i class="fas fa-search"></i> Search</a>
      <ul class="submenu">
        <li><a href="<?php echo $base_url??'../';?>admin/search-criminal.php" class="<?php echo (basename($_SERVER['PHP_SELF'])=='search-criminal.php')?'active':''; ?>">Search Criminal</a></li>
        <li><a href="<?php echo $base_url??'../';?>admin/search-fir.php" class="<?php echo (basename($_SERVER['PHP_SELF'])=='search-fir.php')?'active':''; ?>">Search FIR</a></li>
      </ul>
    </li>
  </ul>
</nav>

<!-- MAIN CONTENT WRAPPER -->
<div class="main-content">
  <!-- PAGE HEADER BAR -->
  <div class="page-header-bar">
    <h4><?php echo isset($page_title)?htmlspecialchars($page_title):'Dashboard'; ?></h4>
    <div class="breadcrumb-bar">
      <a href="<?php echo $base_url??'../';?>admin/dashboard.php"><i class="fas fa-home"></i></a>
      <?php if(isset($breadcrumb)): ?>
        <?php foreach($breadcrumb as $b): ?>
          <span>/</span>
          <?php if(isset($b['url'])): ?>
            <a href="<?php echo $b['url']; ?>"><?php echo $b['label']; ?></a>
          <?php else: ?>
            <span><?php echo $b['label']; ?></span>
          <?php endif; ?>
        <?php endforeach; ?>
      <?php else: ?>
        <span>/</span><span><?php echo isset($page_title)?htmlspecialchars($page_title):'Dashboard'; ?></span>
      <?php endif; ?>
      <button class="back-btn" onclick="history.back()"><i class="fas fa-arrow-left"></i></button>
    </div>
  </div>
  <!-- PAGE BODY -->
  <div class="page-body">
