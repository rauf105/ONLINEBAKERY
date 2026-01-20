<?php include '../Model/db.php'; session_start();
if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $result = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' AND password='$password'");
    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $user['id']; $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email']; $_SESSION['role'] = $user['role'];
        header("Location: " . ($user['role'] == 'Admin' ? "admin.php" : "../index.php"));
    } else { $error = "Invalid Email or Password!"; }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login | Baking Valley</title>
    <link rel="stylesheet" href="../auth_style.css">
</head>
<body>
    <div class="auth-card">
        <h2>Welcome Back</h2>
        <?php if (isset($error)) { echo "<p style='color:red'>$error</p>"; } ?>
        <form method="POST">
            <input type="email" name="email" placeholder="Email Address" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login">Login</button>
        </form>
        <div style="margin-top:20px; font-size:14px;">Don't have an account? <a href="register.php" style="color:#5d4037; font-weight:600;">Register Now</a></div>
    </div>
</body>
</html>