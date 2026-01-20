<?php 
include '../Model/db.php';
session_start();

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'Admin') { 
    header("Location: ../View/login.php"); 
    exit(); 
}

$email = $_SESSION['email'];
$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE email='$email'"));

if(isset($_POST['update_admin'])) {
    $new_email = mysqli_real_escape_string($conn, $_POST['email']);
    $new_pass = mysqli_real_escape_string($conn, $_POST['password']);
    
    
    $sql = "UPDATE users SET email='$new_email', password='$new_pass' WHERE id='{$user['id']}'";
    if(mysqli_query($conn, $sql)) {
        $_SESSION['email'] = $new_email; 
        echo "<script>alert('Admin Info Updated!'); window.location.href='../View/admin.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Profile Edit</title>
    <link rel="stylesheet" href="../admin_style.css">
    <style>
        .edit-box { background: white; padding: 40px; border-radius: 15px; max-width: 400px; margin: 50px auto; box-shadow: 0 5px 20px rgba(0,0,0,0.05); }
        input { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 5px; }
        .save-btn { background: #5d4037; color: white; border: none; padding: 12px; width: 100%; border-radius: 5px; cursor: pointer; }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>BAKING VALLEY</h2>
        <a href="../View/admin.php">Dashboard</a>
        <a href="admin_edit.php" class="active">Edit Profile</a>
        <a href="logout.php" style="color:#ff7043">Logout</a>
    </div>
    <div class="main">
        <div class="edit-box">
            <h2 style="color:#5d4037;">Edit Admin Profile</h2>
            <form method="POST">
                <label>Admin Email</label>
                <input type="email" name="email" value="<?php echo $user['email']; ?>" required>
                <label>New Password</label>
                <input type="password" name="password" value="<?php echo $user['password']; ?>" required>
                <button type="submit" name="update_admin" class="save-btn">Save Changes</button>
            </form>
            <br><a href="../View/admin.php" style="color:#888; text-decoration:none;">Cancel</a>
        </div>
    </div>
</body>
</html>