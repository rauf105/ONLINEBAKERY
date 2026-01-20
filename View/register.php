<?php 

include '../Model/db.php';

if(isset($_POST['register'])) {
    $u = mysqli_real_escape_string($conn, $_POST['username']);
    $e = mysqli_real_escape_string($conn, $_POST['email']);
    $p = mysqli_real_escape_string($conn, $_POST['password']);
    
    $sql = "INSERT INTO users (username, email, password, role) VALUES ('$u', '$e', '$p', 'Customer')";
    
    if(mysqli_query($conn, $sql)) {
        echo "<script>alert('Registration Successful!'); window.location.href='login.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn); 
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register | Baking Valley</title>
    <link rel="stylesheet" href="../auth_style.css">
</head>
<body>
    <div class="auth-card">
        <h2>Join Baking Valley</h2>
        <form method="POST">
            <input type="text" name="username" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Email Address" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="register">Sign Up</button>
        </form>
        <p style="margin-top:20px; font-size:14px;">Already have an account? <a href="login.php" style="color:#5d4037; font-weight:bold; text-decoration:none;">Login</a></p>
    </div>
</body>
</html>