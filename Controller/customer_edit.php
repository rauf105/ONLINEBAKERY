<?php 
include '../Model/db.php';
session_start();


if(!isset($_SESSION['email'])) { 
    header("Location: ../View/login.php"); 
    exit(); 
}

$email = $_SESSION['email'];
$res = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
$user = mysqli_fetch_assoc($res);

if(isset($_POST['update'])) {
    $new_email = mysqli_real_escape_string($conn, $_POST['email']);
    $new_pass = mysqli_real_escape_string($conn, $_POST['password']);
    
    
    $sql = "UPDATE users SET email='$new_email', password='$new_pass' WHERE id='{$user['id']}'";
    if(mysqli_query($conn, $sql)) {
        $_SESSION['email'] = $new_email; 
        echo "<script>alert('Profile Updated!'); window.location.href='../index.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Profile | Baking Valley</title>
    <link rel="stylesheet" href="../shop_style.css"> <style>
        .edit-form { max-width: 400px; margin: 100px auto; background: white; padding: 30px; border-radius: 15px; box-shadow: 0 0 15px rgba(0,0,0,0.1); text-align: center; }
        .edit-form input { width: 100%; padding: 12px; margin: 10px 0; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box; }
        .update-btn { background: #5d4037; color: white; border: none; padding: 12px; width: 100%; border-radius: 8px; cursor: pointer; font-weight: bold; }
    </style>
</head>
<body>
    <div class="edit-form">
        <h2 style="color:#5d4037;">Update Profile</h2>
        <form method="POST">
            <input type="email" name="email" value="<?php echo $user['email']; ?>" required placeholder="Email Address">
            <input type="password" name="password" value="<?php echo $user['password']; ?>" required placeholder="New Password">
            <button type="submit" name="update" class="update-btn">Save Changes</button>
        </form>
        <br>
        <a href="../index.php" style="color: #888; text-decoration: none; font-size: 14px;">Back to Home</a>
    </div>
</body>
</html>