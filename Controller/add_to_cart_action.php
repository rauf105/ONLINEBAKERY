<?php
session_start();
include '../Model/db.php';

if(isset($_GET['id'])) {
    $p_id = mysqli_real_escape_string($conn, $_GET['id']); 
    
    if(isset($_SESSION['email'])) {
        $u_email = $_SESSION['email'];
   
        $u_res = mysqli_query($conn, "SELECT id FROM users WHERE email='$u_email'");
        $u_row = mysqli_fetch_assoc($u_res);
        $u_id = $u_row['id'];


        $check = mysqli_query($conn, "SELECT * FROM cart WHERE user_id = '$u_id' AND product_id = '$p_id'");

        if(mysqli_num_rows($check) > 0) {
        
            mysqli_query($conn, "UPDATE cart SET quantity = quantity + 1 WHERE user_id = '$u_id' AND product_id = '$p_id'");
        } else {
          
            mysqli_query($conn, "INSERT INTO cart (user_id, product_id, quantity) VALUES ('$u_id', '$p_id', 1)");
        }
    }
    
  
    header("Location: ../index.php"); 
    exit();
}
?>