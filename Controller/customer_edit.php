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
    $confirm_pass = mysqli_real_escape_string($conn, $_POST['confirm_password']);
    
    if(empty($new_email) || empty($new_pass)) {
        echo "<script>alert('Error: All fields are required!');</script>";
    } elseif($new_pass !== $confirm_pass) {
        echo "<script>alert('Error: Passwords do not match!');</script>";
    } else {
        $sql = "UPDATE users SET email='$new_email', password='$new_pass' WHERE id='{$user['id']}'";
        
        if(mysqli_query($conn, $sql)) {
            $_SESSION['email'] = $new_email; 
            echo "<script>alert('Profile Updated Successfully!'); window.location.href='../index.php';</script>";
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile | Baking Valley</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f8f1e9; margin: 0; display: flex; align-items: center; justify-content: center; height: 100vh; }
        .edit-form { max-width: 400px; width: 90%; background: white; padding: 40px; border-radius: 20px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); text-align: center; }
        .edit-form h2 { color: #5d4037; margin-bottom: 25px; }
        .input-group { text-align: left; margin-bottom: 15px; }
        .input-group label { display: block; font-size: 13px; color: #8d6e63; margin-bottom: 5px; margin-left: 5px; }
        .edit-form input { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 10px; box-sizing: border-box; font-size: 14px; outline: none; transition: 0.3s; }
        .edit-form input:focus { border-color: #5d4037; box-shadow: 0 0 5px rgba(93, 64, 55, 0.2); }
        .update-btn { background: #5d4037; color: white; border: none; padding: 14px; width: 100%; border-radius: 10px; cursor: pointer; font-weight: 600; font-size: 16px; margin-top: 15px; transition: 0.3s; }
        .update-btn:hover { background: #4b342d; transform: translateY(-2px); }
        .back-link { display: block; margin-top: 20px; color: #888; text-decoration: none; font-size: 14px; }
        .back-link:hover { color: #5d4037; }
    </style>
</head>
<body>

    <div class="edit-form">
        <h2>Update Profile</h2>
        <form method="POST" onsubmit="return validateForm()" novalidate>
            <div class="input-group">
                <label>Email Address</label>
                <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>">
            </div>
            
            <div class="input-group">
                <label>New Password</label>
                <input type="password" id="password" name="password" placeholder="Min 6 characters">
            </div>
            
            <div class="input-group">
                <label>Confirm New Password</label>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Repeat new password">
            </div>
            
            <button type="submit" name="update" class="update-btn">Save Changes</button>
        </form>
        <a href="../index.php" class="back-link">← Back to Shop</a>
    </div>

    <script>
    function validateForm() {
        const email = document.getElementById('email').value.trim();
        const pass = document.getElementById('password').value;
        const confirmPass = document.getElementById('confirm_password').value;

        if (email === "") {
            alert("Error: Email is required.");
            return false;
        }

        if (pass === "") {
            alert("Error: Password is required.");
            return false;
        }

        if (pass.length < 6) {
            alert("Security Alert: Password must be at least 6 characters long!");
            return false;
        }

        if (pass !== confirmPass) {
            alert("Validation Error: Passwords do not match!");
            return false;
        }

        return true; 
    }
    </script>

</body>
</html>