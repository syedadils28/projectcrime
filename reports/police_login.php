<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Signup Form</title>
    <link rel="stylesheet" href="assets/css/police_style.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class="page-wrapper">
        <!-- ── Left selector panel ── -->
        <div class="login-selector">
            <button class="selector-btn" id="btn-home" onclick="window.location.href = '../index.php'">
                <i class="bx bxs-home"></i>
                Home
            </button>
            <button class="selector-btn" id="btn-user" onclick="window.location.href = 'index.php'">
                <i class="bx bxs-user-circle"></i>
                User Login
            </button>
            <button class="selector-btn active" id="btn-other" onclick="window.location.href = 'police_login.php'">
                <i class="bx bxs-building-house"></i>
                Police Login
            </button>
             <button class="selector-btn" id="btn-other" onclick="window.location.href = 'admin_login.php'">
                <i class="bx bxs-building-house"></i>
                Admin Login
            </button>

        </div>

        <div class="auth-wrapper">
            
            <div class="credentials-panel signin">
                <h2 class="slide-element">police Login</h2>
                <form action="#">
                    <div class="field-wrapper slide-element">
                        <input type="text" required>
                        <label for="">Username</label>
                        <i class="fa-solid fa-user"></i>
                    </div>

                    <div class="field-wrapper slide-element">
                        <input type="password" required>
                        <label for="">Password</label>
                        <i class="fa-solid fa-lock"></i>
                    </div>
                    <div class="forgot-link">
                        <a href="#">Forgot Password?</a>
                    </div>
                    <div class="field-wrapper slide-element">
                        <button class="submit-button" type="submit">Login</button>
                    </div>


                </form>
            </div>

        </div>
    </div>

    <!-- <script src="assets/jss/script_official.js"></script> -->
</body>

</html>
