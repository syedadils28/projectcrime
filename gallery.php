<?php
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['fullname'])) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Cyber Crime System</title>
    <link rel="stylesheet" href="css/style.css"> 
</head>
<body>
    <div class="container success-card">
        
        <svg class="tick-mark" viewBox="0 0 52 52" xmlns="http://www.w3.org/2000/svg">
            <circle cx="26" cy="26" r="25" fill="none" stroke="#00ff88" stroke-width="2"/>
            <path fill="none" stroke="#00ff88" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" d="M14 27l7 7 16-16" />
        </svg>

        <div class="status-msg">
            <?php 
                if(isset($_GET['status']) && $_GET['status'] == 'registered') {
                    echo "Identity Verified & Registered";
                } else {
                    echo "Access Granted / Secure Session";
                }
            ?>
        </div>

        <h1 class="welcome-name">Welcome, <?php echo htmlspecialchars($_SESSION['fullname']); ?></h1>
        
        <p style="color: #888; margin-bottom: 30px;">Digitalization of Crime Reporting System is now active.</p>
        
        <a href="logout.php" class="btn" style="background: transparent; border: 1px solid #ff4d4d; color: #ff4d4d;">Terminate Session (Logout)</a>
    </div>
</body>
</html>
<?php
} else {
    header("Location: login.php");
    exit();
}
?>