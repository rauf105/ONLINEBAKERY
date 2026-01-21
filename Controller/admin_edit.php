<?php 
include '../Model/db.php';
session_start();

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'Admin') { 
    header("Location: ../View/login.php"); 
    exit(); 
}

$email = $_SESSION['email'];
$user_query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
$user = mysqli_fetch_assoc($user_query);

if(isset($_POST['update_admin'])) {
    $new_email = mysqli_real_escape_string($conn, $_POST['email']);
    $new_pass = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_pass = mysqli_real_escape_string($conn, $_POST['confirm_password']);
    
    if(empty($new_email) || empty($new_pass)) {
        echo "<script>alert('Error: All fields are required!');</script>";
    } elseif($new_pass !== $confirm_pass) {
        echo "<script>alert('Error: Passwords do not match!');</script>";
    } else {
        $sql = "UPDATE users SET email='$new_email', password='$new_pass' WHERE id='{$user['id']}'";
        if(mysqli_query($conn, $sql)) {
            $_SESSION['email'] = $new_email; 
            echo "<script>alert('Admin Info Updated!'); window.location.href='../View/admin.php';</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Profile Edit</title>
    <link rel="stylesheet" href="../admin_style.css">
    <style>
        .edit-box { background: white; padding: 40px; border-radius: 15px; max-width: 400px; margin: 50px auto; box-shadow: 0 5px 20px rgba(0,0,0,0.05); }
        input { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; }
        label { font-size: 14px; color: #5d4037; font-weight: bold; display: block; margin-top: 10px; }
        .save-btn { background: #5d4037; color: white; border: none; padding: 12px; width: 100%; border-radius: 5px; cursor: pointer; font-weight: bold; margin-top: 20px; }
        .save-btn:hover { background: #4b342d; }
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
            <h2 style="color:#5d4037; text-align: center;">Edit Admin Profile</h2>
            
            <form method="POST" onsubmit="return validateAdminForm()" novalidate>
                <label>Admin Email</label>
                <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>">
                
                <label>New Password</label>
                <input type="password" id="password" name="password" placeholder="Enter new password">
                
                <label>Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Repeat new password">
                
                <button type="submit" name="update_admin" class="save-btn">Save Changes</button>
            </form>
            
            <div style="text-align: center; margin-top: 15px;">
                <a href="../View/admin.php" style="color:#888; text-decoration:none; font-size: 14px;">Cancel</a>
            </div>
        </div>
    </div>

    <script>
    function validateAdminForm() {
        const email = document.getElementById('email').value.trim();
        const pass = document.getElementById('password').value;
        const confirmPass = document.getElementById('confirm_password').value;

        if (email === "") {
            alert("Error: Admin email is required.");
            return false;
        }

        if (pass === "") {
            alert("Error: Password is required.");
            return false;
        }

        if (pass.length < 6) {
            alert("Password must be at least 6 characters long.");
            return false;
        }

        if (pass !== confirmPass) {
            alert("Passwords do not match!");
            return false;
        }

        return true;
    }
    </script>
</body>
</html>