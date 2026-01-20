<?php 
include '../Model/db.php'; 
session_start();

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    $result = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' AND password='$password'");
    
    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $user['id']; 
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email']; 
        $_SESSION['role'] = $user['role'];
        
        header("Location: " . ($user['role'] == 'Admin' ? "admin.php" : "../index.php"));
        exit();
    } else { 
        $error = "Invalid Email or Password!"; 
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | Baking Valley</title>
    <link rel="stylesheet" href="../auth_style.css">
</head>
<body>
    <div class="auth-card">
        <h2>Welcome Back</h2>
        
        <?php if (isset($error)): ?>
            <p id="php-error" style="color:red; font-size:14px;"><?php echo $error; ?></p>
        <?php endif; ?>
        
        <p id="js-error" style="color:red; font-size:14px; display:none;"></p>

        <form method="POST" onsubmit="return validateLogin()">
            <input type="email" name="email" id="login-email" placeholder="Email Address" required>
            <input type="password" name="password" id="login-pass" placeholder="Password" required>
            <button type="submit" name="login">Login</button>
        </form>
        
        <div style="margin-top:20px; font-size:14px;">
            Don't have an account? <a href="register.php" style="color:#5d4037; font-weight:600;">Register Now</a>
        </div>
    </div>

    <script>
    function validateLogin() {
        const email = document.getElementById('login-email').value.trim();
        const pass = document.getElementById('login-pass').value;
        const errorDisplay = document.getElementById('js-error');
        const phpError = document.getElementById('php-error');

        if(phpError) phpError.style.display = 'none';

        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(email)) {
            errorDisplay.innerText = "Please enter a valid email address!";
            errorDisplay.style.display = 'block';
            return false;
        }

        if (pass.length < 1) {
            errorDisplay.innerText = "Password cannot be empty!";
            errorDisplay.style.display = 'block';
            return false;
        }

        return true;
    }
    </script>
</body>
</html>