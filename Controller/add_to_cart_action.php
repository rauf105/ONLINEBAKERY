<?php
session_start();
include '../Model/db.php';

if(isset($_GET['id']) && isset($_SESSION['email'])) {
    $p_id = mysqli_real_escape_string($conn, $_GET['id']); 
    $email = $_SESSION['email'];
    $user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id FROM users WHERE email='$email'"));
    $u_id = $user['id'];

    $check = mysqli_query($conn, "SELECT * FROM cart WHERE user_id = '$u_id' AND product_id = '$p_id'");
    if(mysqli_num_rows($check) > 0) {
        mysqli_query($conn, "UPDATE cart SET quantity = quantity + 1 WHERE user_id = '$u_id' AND product_id = '$p_id'");
    } else {
        mysqli_query($conn, "INSERT INTO cart (user_id, product_id, quantity) VALUES ('$u_id', '$p_id', 1)");
    }
}
?>