<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login/Signup Form</title>
    <link
      href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
      rel="stylesheet"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="assets/css/style.css" />
  </head>
  <body>
    <div class="page-wrapper">
      <!-- ── Left selector panel ── -->
      <div class="login-selector">
        <!-- return to home page -->
        <button
          class="selector-btn"
          id="btn-home"
          onclick="window.location.href = '../index.php'"
        >
          <i class="bx bxs-home"></i>
          Home
        </button>
        <button
          class="selector-btn active"
          id="btn-user"
          onclick="window.location.href = 'index.php'"
        >
          <i class="bx bxs-user-circle"></i>
          User Login
        </button>
        <button class="selector-btn" id="btn-other"
          onclick="window.location.href = 'police_login.php'"
        >
          <i class="bx bxs-building-house"></i>
          police Login
        </button>
        <button class="selector-btn" id="btn-other"
          onclick="window.location.href = 'admin_login.php'"
        >
          <i class="bx bxs-building-house"></i>
          admin Login
        </button>
      </div>

      <!-- ── Main login / register container ── -->
      <div class="container" id="mainContainer">
        <!-- Login form -->
        <div class="form-box login">
          <form action="#">
            <span class="login-type-badge" id="loginBadge">User Login</span>
            <h1>Login</h1>
            <div class="input-box">
              <input type="text" placeholder="Username" required />
              <i class="bx bxs-user"></i>
            </div>
            <div class="input-box">
              <input type="password" placeholder="Password" required />
              <i class="bx bxs-lock-alt"></i>
            </div>
            <div class="forgot-link">
              <a href="#">Forgot Password?</a>
            </div>
            <button type="submit" class="btn">Login</button>
            <!-- <p>or login with social platforms</p>
            <div class="social-icons">
              <a href="#"><i class="bx bxl-google"></i></a>
              <a href="#"><i class="bx bxl-facebook"></i></a>
              <a href="#"><i class="bx bxl-github"></i></a>
              <a href="#"><i class="bx bxl-linkedin"></i></a>
            </div> -->
          </form>
        </div>

        <!-- Register form -->
        <div class="form-box register">
          <form action="#">
            <span class="login-type-badge" id="registerBadge"
              >User Registration</span
            >
            <h1>Registration</h1>
            <div class="input-box">
              <input type="text" placeholder="Username" required />
              <i class="bx bxs-user"></i>
            </div>
            <div class="input-box">
              <input type="email" placeholder="Email" required />
              <i class="bx bxs-envelope"></i>
            </div>
            
            <div class="input-box">
              <input type="text" placeholder="Phone Number" required />
              <i class="bx bxs-phone"></i>
            </div>
            <div class="input-box">
              <input type="text" placeholder="Aadhaar Number" required />
              <i class="bx bxs-id-card"></i>
            </div>
            <div class="input-box">
              <input type="password" placeholder="Password" required />
              <i class="bx bxs-lock-alt"></i>
            </div>
            <div class="input-box">
              <input type="password" placeholder="Confirm Password" required />
              <i class="bx bxs-lock-alt"></i>
            </div>
            <button type="submit" class="btn">Register</button>
            <!-- <p>or register with social platforms</p>
            <div class="social-icons">
              <a href="#"><i class="bx bxl-google"></i></a>
              <a href="#"><i class="bx bxl-facebook"></i></a>
              <a href="#"><i class="bx bxl-github"></i></a>
              <a href="#"><i class="bx bxl-linkedin"></i></a>
            </div> -->
          </form>
        </div>

        <!-- Toggle overlay -->
        <div class="toggle-box">
          <div class="toggle-panel toggle-left">
            <h1>Hello, Welcome!</h1>
            <p>Don't have an account?</p>
            <button class="btn register-btn">Register</button>
            <!-- <button
              class="btn home-btn"
              style="margin-top: 8px"
              onclick="window.location.href = '../index.php'"
            >
              Home
            </button> -->
          </div>
          <div class="toggle-panel toggle-right">
            <h1>Welcome Back!</h1>
            <p>Already have an account?</p>
            <button class="btn login-btn">Login</button>
            <!-- <button
              class="btn home-btn"
              style="margin-top: 8px"
              onclick="window.location.href = '../index.php'"
            >
              Home
            </button> -->
          </div>
        </div>
      </div>
      <!-- /.container -->
    </div>
    <!-- /.page-wrapper -->

    <script src="assets/jss/script.js"></script>
  </body>
</html>
