<?php
session_start();
// If not logged in, kick back to login page
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Access Granted - Cyber System</title>
    <meta http-equiv="refresh" content="3;url=index.php">
    <link rel="stylesheet" href="css/style.css"> 
</head>
<body>
    <div class="container success-card">
        <svg class="tick-mark" viewBox="0 0 52 52" style="width:100px; margin:auto; display:block;">
            <circle cx="26" cy="26" r="25" fill="none" stroke="#00ff88" stroke-width="2"/>
            <path fill="none" stroke="#00ff88" stroke-width="3" d="M14 27l7 7 16-16" />
        </svg>

        <div class="status-msg">Access Granted / Secure Session</div>

        <h1 class="welcome-name">Welcome, <?php echo htmlspecialchars($_SESSION['fullname']); ?></h1>
        
        <p style="color: #888;">Redirecting to the Digital Crime System...</p>
    </div>
</body>
</html>