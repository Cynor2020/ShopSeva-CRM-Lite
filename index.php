<?php
include 'db.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

$message = '';

// Registration logic
if (isset($_POST['register'])) {
    $name = $_POST['reg_name'];
    $email = $_POST['reg_email'];
    $password = password_hash($_POST['reg_password'], PASSWORD_BCRYPT);
    $role = $_POST['reg_role'];

    $check = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $res = $check->get_result();

    if ($res->num_rows > 0) {
        $message = "Email already exists!";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $password, $role);
        if ($stmt->execute()) {
            $message = "Registration successful! Please login.";
        } else {
            $message = "Registration failed!";
        }
    }
}

// Login logic
if (isset($_POST['login'])) {
    $email = $_POST['log_email'];
    $password = $_POST['log_password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows > 0) {
        $user = $res->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user;
            if ($user['role'] === 'Admin') {
                header("Location: admin_dashboard.php");
            } else {
                header("Location: worker_dashboard.php");
            }
            exit();
        } else {
            $message = "Invalid password.";
        }
    } else {
        $message = "User not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ShopSeva Lite</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">
</head>
<body>
<div class="container <?= (isset($_POST['register']) && empty($message)) ? 'sign-up-mode' : '' ?>">
    <div class="signin-signup">
        <form method="POST" class="sign-in-form">
            <h2 class="title">Sign in</h2>
            <div class="input-field">
                <i class="fas fa-envelope"></i>
                <input type="email" name="log_email" placeholder="Email" required>
            </div>
            <div class="input-field">
                <i class="fas fa-lock"></i>
                <input type="password" name="log_password" placeholder="Password" required>
            </div>
            <input type="submit" value="Login" name="login" class="btn">
            <p class="social-text"><?= $message ?></p>
            <div class="social-media">
                <!-- Social Icons -->
            </div>
            <p class="account-text">Don't have an account? <a href="#" id="sign-up-btn2">Sign up</a></p>
        </form>

        <form method="POST" class="sign-up-form">
            <h2 class="title">Sign up</h2>
            <div class="input-field">
                <i class="fas fa-user"></i>
                <input type="text" name="reg_name" placeholder="Username" required>
            </div>
            <div class="input-field">
                <i class="fas fa-envelope"></i>
                <input type="email" name="reg_email" placeholder="Email" required>
            </div>
            <div class="input-field">
                <i class="fas fa-lock"></i>
                <input type="password" name="reg_password" placeholder="Password" required>
            </div>
            <div class="input-field">
                <i class="fas fa-user-tag"></i>
                <select name="reg_role" required style="width:100%; border: none; background: none; font-size: 16px; padding-left: 10px;">
                    <option value="">Select Role</option>
                    <option value="Admin">Admin</option>
                    <option value="Worker">Worker</option>
                </select>
            </div>
            <input type="submit" value="Sign up" name="register" class="btn">
            <p class="social-text"><?= $message ?></p>
            <div class="social-media">
                <!-- Social Icons -->
            </div>
            <p class="account-text">Already have an account? <a href="#" id="sign-in-btn2">Sign in</a></p>
        </form>
    </div>

    <div class="panels-container">
        <div class="panel left-panel">
            <div class="content">
                <h3>Member of Brand?</h3>
                <p>Welcome back! Please login to continue.</p>
                <button class="btn" id="sign-in-btn">Sign in</button>
            </div>
            <img src="signin.svg" class="image" alt="">
        </div>
        <div class="panel right-panel">
            <div class="content">
                <h3>New to Brand?</h3>
                <p>Join our platform by registering now.</p>
                <button class="btn" id="sign-up-btn">Sign up</button>
            </div>
            <img src="signup.svg" class="image" alt="">
        </div>
    </div>
</div>
<script src="app.js"></script>
</body>
</html>
