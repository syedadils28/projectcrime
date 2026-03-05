<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Signup Form</title>
    <link rel="stylesheet" href="assets/css/style_official.css">
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
            <button class="selector-btn active" id="btn-other" onclick="window.location.href = 'official_login.php'">
                <i class="bx bxs-building-house"></i>
                Official Login
            </button>
        </div>

        <div class="auth-wrapper">
            <div class="background-shape"></div>
            <div class="secondary-shape"></div>
            <div class="credentials-panel signin">
                <span class="login-type-badge" id="loginBadge">Official Login</span>
                <h2 class="slide-element">Login</h2>
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

                    <div class="field-wrapper slide-element">
                        <button class="submit-button" type="submit">Login</button>
                    </div>

                    <div class="switch-link slide-element">
                        <p>Don't have an account? <br> <a href="#" class="register-trigger">Sign Up</a></p>
                    </div>
                </form>
            </div>

            <div class="welcome-section signin">
                <h2 class="slide-element">WELCOME BACK!</h2>
                <!-- <button class="slide-element submit-button" onclick="window.location.href = 'index.php'">Go to User Login</button> -->
            </div>

            <!-- The registration panel -->
            <div class="credentials-panel signup">
                <h2 class="slide-element">Register</h2>
                <form action="#">
                    <div class="field-wrapper slide-element">
                        <input type="text" required>
                        <label for="">Username</label>
                        <i class="fa-solid fa-user"></i>
                    </div>

                    <div class="field-wrapper slide-element">
                        <input type="email" required>
                        <label for="">Email</label>
                        <i class="fa-solid fa-envelope"></i>
                    </div>

                    <div class="field-wrapper slide-element">
                        <input type="password" required>
                        <label for="">Password</label>
                        <i class="fa-solid fa-lock"></i>
                    </div>

                    <div class="field-wrapper slide-element">
                        <button class="submit-button" type="submit">Register</button>
                    </div>

                    <div class="switch-link slide-element">
                        <p>Already have an account? <br> <a href="#" class="login-trigger">Sign In</a></p>
                    </div>
                </form>
            </div>

            <div class="welcome-section signup">
                <h2 class="slide-element">WELCOME!</h2>
                <!-- <button class="slide-element submit-button" onclick="window.location.href = 'index.php'">User Login</button> -->
            </div>

        </div>
    </div>

    <div class="footer">
        <p>Made with ❤️ by <a href="#" target="_blank">Sa_Coder_Dev</a></p>
    </div>

    <script src="assets/jss/script_official.js"></script>
</body>

</html>
