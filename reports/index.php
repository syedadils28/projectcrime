<?php require_once 'includes/config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Crime Record Management System</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="css/style.css">
<style>
body{ margin:0; font-family:'Roboto',sans-serif; }
</style>
</head>
<body>

<!-- NAVIGATION -->
<div class="home-topbar">
  <div style="display:flex;align-items:center;gap:15px;">
    <img src="images/logo.png" onerror="this.style.display='none'" class="home-logo" alt="">
    <span style="color:#90caf9;font-size:18px;font-weight:600;">CRIMS</span>
  </div>
  <nav class="home-nav">
    <a href="../index.php"><i class="fas fa-home"></i> Home</a>
    <a href="user/signin.php"><i class="fas fa-user"></i> User</a>
    <a href="police/login.php"><i class="fas fa-shield-alt"></i> Police</a>
    <a href="admin/login.php"><i class="fas fa-lock"></i> Admin</a>
  </nav>
</div>

<!-- HERO -->
<div class="home-hero">
  <div class="home-hero-overlay"></div>
  <div class="home-hero-content">
    <h1>Crime Record Management System</h1>
    <p style="font-size:16px;opacity:0.85;">Developed Using PHP and MySQL</p>
  </div>
</div>

<!-- CONTENT -->
<div class="home-content">
  <div>
    <img src="images/police-group.jpg" onerror="this.src='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 600 400%22><rect fill=%22%232b3f5c%22 width=%22600%22 height=%22400%22/><text x=%2250%25%22 y=%2250%25%22 dominant-baseline=%22middle%22 text-anchor=%22middle%22 fill=%22white%22 font-size=%2230%22>Police Force</text></svg>'" alt="Police Group" style="width:100%;border-radius:6px;">
  </div>
  <div>
    <h2>Mission &amp; Vision</h2>
    <p>The unified mission of the Police Families Welfare Association, as obvious, is the WELFARE of POLICE FAMILIES. Every effort of PFWS team members is directed towards the welfare of the police community.</p>
    <p>To add specificity to our mission, we have directed our focus towards the specific aspects of welfare.</p>
    <p>The focus areas specified include economic &amp; financial betterment, education &amp; skill development and health &amp; Welbeing.</p>
    <p>To effectively support the families of Police staff economically, emotionally and extend the successful programs to general public wherever feasible.</p>
    <p>Our vision is to work for an equitable society and for holistic development of families of Police staff</p>
  </div>
</div>

<!-- FOOTER -->
<div class="home-footer">
  <h4>Quick Links</h4>
  <div style="display:flex;gap:20px;justify-content:center;margin:10px 0;">
    <a href="index.php">Home</a>
    <a href="admin/login.php">Admin</a>
    <a href="user/signin.php">User</a>
    <a href="police/login.php">Police</a>
  </div>
  <p style="margin-top:14px;font-size:12px;">&copy; <?php echo date('Y'); ?> Crime Record Management System | Developed by PHPGurukul</p>
</div>

</body>
</html>
