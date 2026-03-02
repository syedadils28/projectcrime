<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - Digital Crime System</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>New Officer Registration</h1>
        <div class="tagline">JOIN THE FORCE</div>

        <?php if (isset($_GET['error'])) { ?>
            <div class="error"><?php echo htmlspecialchars($_GET['error']); ?></div>
        <?php } ?>

        <form action="auth.php" method="POST">
            <input type="text" name="fullname" placeholder="Full Legal Name" required>
            <input type="email" name="email" placeholder="Email Address" required>
            <input type="password" name="password" placeholder="Create Password" required>
            <button type="submit" name="register_btn" class="btn">Register Now</button>
        </form>

        <div class="message">
            Already have an account? <a href="login.php">Login Here</a>
        </div>
    </div>
</body>
</html>