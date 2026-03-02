<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Digital Crime System</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Digitalization of Crime Reporting</h1>
        <div class="tagline">JUSTICE ON THE SPEED OF LIGHT</div>
        
        <?php if (isset($_GET['error'])) { ?>
            <div class="error"><?php echo htmlspecialchars($_GET['error']); ?></div>
        <?php } ?>

        <form action="auth.php" method="POST">
            <input type="email" name="email" placeholder="Enter Email Address" required>
            <input type="password" name="password" placeholder="Enter Password" required>
            <button type="submit" name="login_btn" class="btn">Secure Login</button>
        </form>

        <div class="message">
            New to the system? <a href="register.php">Register Here</a>
        </div>
    </div>
</body>
</html>