<?php
if(!isset($_SESSION['policeid'])){
    header("Location: ../police/login.php");
    exit();
}
$police_name    = $_SESSION['police_name']    ?? 'Officer';
$police_station = $_SESSION['police_station'] ?? 0;
$police_id_num  = $_SESSION['policeid']       ?? 0;

$st = mysqli_fetch_assoc(mysqli_query($con,"SELECT PoliceStationName FROM tbl_policestation WHERE id=$police_station"));
$station_name = $st ? $st['PoliceStationName'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title><?php echo isset($page_title) ? htmlspecialchars($page_title).' | ' : ''; ?>CRMS | Police Panel</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="<?php echo $base_url ?? '../'; ?>css/style.css">
</head>
<body>

<header class="top-header">
  <div class="brand">Crime Record Management System | <span>Police Panel</span></div>
  <div style="display:flex;align-items:center;gap:18px;">
    <div class="user-info" onclick="togglePoliceDropdown()">
      <img src="<?php echo $base_url ?? '../'; ?>images/admin.png"
           onerror="this.src='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 40 40%22><circle cx=%2220%22 cy=%2220%22 r=%2220%22 fill=%22%2337474f%22/><text x=%2250%25%22 y=%2255%25%22 dominant-baseline=%22middle%22 text-anchor=%22middle%22 fill=%22white%22 font-size=%2218%22><?php echo strtoupper(substr($police_name,0,1)); ?></text></svg>'">
      <div>
        <div class="uname"><?php echo htmlspecialchars($police_name); ?></div>
        <div class="uemail"><?php echo htmlspecialchars($station_name); ?></div>
      </div>
      <i class="fas fa-chevron-down" style="font-size:11px;color:#aaa;"></i>
    </div>
    <div class="user-dropdown" id="policeDropdown">
      <a href="<?php echo $base_url ?? '../'; ?>police/my-profile.php"><i class="fas fa-user" style="width:16px;"></i> My Profile</a>
      <a href="<?php echo $base_url ?? '../'; ?>police/change-password.php"><i class="fas fa-key" style="width:16px;"></i> Change Password</a>
      <a href="<?php echo $base_url ?? '../'; ?>logout.php"><i class="fas fa-sign-out-alt" style="width:16px;"></i> Logout</a>
    </div>
  </div>
</header>

<nav class="sidebar">
  <div class="sidebar-brand">Navigation</div>
  <ul>

    <!-- Dashboard -->
    <li>
      <a href="<?php echo $base_url ?? '../'; ?>police/dashboard.php"
         class="<?php echo basename($_SERVER['PHP_SELF']) === 'dashboard.php' ? 'active' : ''; ?>">
        <i class="fas fa-tachometer-alt"></i> Dashboard
      </a>
    </li>

    <!-- FIR -->
    <li class="has-sub <?php echo in_array(basename($_SERVER['PHP_SELF']),['view-fir.php','view-fir-detail.php']) ? 'open' : ''; ?>">
      <a href="#"><i class="fas fa-file-alt"></i> FIR <i class="fas fa-chevron-down sub-arrow"></i></a>
      <ul class="submenu">
        <li>
          <a href="<?php echo $base_url ?? '../'; ?>police/view-fir.php"
             class="<?php echo in_array(basename($_SERVER['PHP_SELF']),['view-fir.php','view-fir-detail.php']) ? 'active' : ''; ?>">
            View FIR
          </a>
        </li>
      </ul>
    </li>

    <!-- Criminals -->
    <li class="has-sub <?php echo in_array(basename($_SERVER['PHP_SELF']),['add-criminal.php','view-criminals.php','edit-criminal.php']) ? 'open' : ''; ?>">
      <a href="#"><i class="fas fa-user-slash"></i> Criminals <i class="fas fa-chevron-down sub-arrow"></i></a>
      <ul class="submenu">
        <li>
          <a href="<?php echo $base_url ?? '../'; ?>police/add-criminal.php"
             class="<?php echo basename($_SERVER['PHP_SELF']) === 'add-criminal.php' ? 'active' : ''; ?>">
            Add Criminal
          </a>
        </li>
        <li>
          <a href="<?php echo $base_url ?? '../'; ?>police/view-criminals.php"
             class="<?php echo in_array(basename($_SERVER['PHP_SELF']),['view-criminals.php','edit-criminal.php']) ? 'active' : ''; ?>">
            View Criminals
          </a>
        </li>
      </ul>
    </li>

    <!-- Charge Sheet -->
    <li class="has-sub <?php echo in_array(basename($_SERVER['PHP_SELF']),['add-charge-sheet.php','view-charge-sheet.php']) ? 'open' : ''; ?>">
      <a href="#"><i class="fas fa-file-invoice"></i> Charge Sheet <i class="fas fa-chevron-down sub-arrow"></i></a>
      <ul class="submenu">
        <li>
          <a href="<?php echo $base_url ?? '../'; ?>police/add-charge-sheet.php"
             class="<?php echo basename($_SERVER['PHP_SELF']) === 'add-charge-sheet.php' ? 'active' : ''; ?>">
            Add Charge Sheet
          </a>
        </li>
        <li>
          <a href="<?php echo $base_url ?? '../'; ?>police/view-charge-sheet.php"
             class="<?php echo basename($_SERVER['PHP_SELF']) === 'view-charge-sheet.php' ? 'active' : ''; ?>">
            View Charge Sheet
          </a>
        </li>
      </ul>
    </li>

    <!-- Daily News -->
    <li class="has-sub <?php echo in_array(basename($_SERVER['PHP_SELF']),['manage_news.php','edit_news.php']) ? 'open' : ''; ?>">
      <a href="#"><i class="fas fa-newspaper"></i> Daily News <i class="fas fa-chevron-down sub-arrow"></i></a>
      <ul class="submenu">
        <li>
          <a href="<?php echo $base_url ?? '../'; ?>police/manage_news.php"
             class="<?php echo in_array(basename($_SERVER['PHP_SELF']),['manage_news.php','edit_news.php']) ? 'active' : ''; ?>">
            Manage News
          </a>
        </li>
      </ul>
    </li>

    <!-- Search -->
    <li class="has-sub <?php echo in_array(basename($_SERVER['PHP_SELF']),['search-criminal.php','search-fir.php']) ? 'open' : ''; ?>">
      <a href="#"><i class="fas fa-search"></i> Search <i class="fas fa-chevron-down sub-arrow"></i></a>
      <ul class="submenu">
        <li>
          <a href="<?php echo $base_url ?? '../'; ?>police/search-criminal.php"
             class="<?php echo basename($_SERVER['PHP_SELF']) === 'search-criminal.php' ? 'active' : ''; ?>">
            Search Criminal
          </a>
        </li>
        <li>
          <a href="<?php echo $base_url ?? '../'; ?>police/search-fir.php"
             class="<?php echo basename($_SERVER['PHP_SELF']) === 'search-fir.php' ? 'active' : ''; ?>">
            Search FIR
          </a>
        </li>
      </ul>
    </li>

    <!-- My Profile -->
    <li>
      <a href="<?php echo $base_url ?? '../'; ?>police/my-profile.php"
         class="<?php echo basename($_SERVER['PHP_SELF']) === 'my-profile.php' ? 'active' : ''; ?>">
        <i class="fas fa-user-circle"></i> My Profile
      </a>
    </li>

    <!-- Logout -->
    <li>
      <a href="<?php echo $base_url ?? '../'; ?>logout.php">
        <i class="fas fa-sign-out-alt"></i> Logout
      </a>
    </li>

  </ul>
</nav>

<div class="main-content">
  <div class="page-header-bar">
    <h4><?php echo isset($page_title) ? htmlspecialchars($page_title) : 'Dashboard'; ?></h4>
    <div class="breadcrumb-bar">
      <a href="<?php echo $base_url ?? '../'; ?>police/dashboard.php"><i class="fas fa-home"></i></a>
      <?php if(isset($breadcrumb)): foreach($breadcrumb as $b): ?>
        <span>/</span>
        <?php if(isset($b['url'])): ?>
          <a href="<?php echo $b['url']; ?>"><?php echo htmlspecialchars($b['label']); ?></a>
        <?php else: ?>
          <span><?php echo htmlspecialchars($b['label']); ?></span>
        <?php endif; ?>
      <?php endforeach; else: ?>
        <span>/</span>
        <span><?php echo isset($page_title) ? htmlspecialchars($page_title) : 'Dashboard'; ?></span>
      <?php endif; ?>
      <button class="back-btn" onclick="history.back()"><i class="fas fa-arrow-left"></i></button>
    </div>
  </div>
  <div class="page-body">