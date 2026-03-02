<?php
session_start();

// 1. Database Connection (Update these details!)
$conn = mysqli_connect("localhost", "root", "", "your_database_name");

if (isset($_POST['login_btn'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // 2. Query to find the user
    $query = "SELECT * FROM users WHERE email='$email' AND password='$password' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $user_data = mysqli_fetch_assoc($result);

        // 3. Set Session Variables
        $_SESSION['id'] = $user_data['id'];
        $_SESSION['fullname'] = $user_data['fullname'];

        // 4. REDIRECT TO WELCOME PAGE
        header("Location: welcome.php");
        exit();
    } else {
        header("Location: login.php?error=Invalid Credentials");
        exit();
    }
}
?>