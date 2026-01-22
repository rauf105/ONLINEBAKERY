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

        if (isset($_POST['remember'])) {
            setcookie('user_email', $email, time() + (86400 * 30), "/");
        }
        
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

        <form method="POST" onsubmit="return validateLogin()" novalidate>
            <input type="email" name="email" id="login-email" placeholder="Email Address">
            <input type="password" name="password" id="login-pass" placeholder="Password">
            
            <div style="text-align: left; margin: 10px 0; font-size: 14px;">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember">Remember Me</label>
            </div>

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
        errorDisplay.style.display = 'none';

        if (email === "" || pass === "") {
            errorDisplay.innerText = "All fields are required!";
            errorDisplay.style.display = 'block';
            return false;
        }
        return true;
    }
    </script>
</body>
</html>