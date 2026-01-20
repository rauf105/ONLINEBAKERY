<?php
include 'db.php';
session_start();

if(isset($_GET['id']) && isset($_SESSION['email'])) {
    $p_id = $_GET['id'];
    $u_email = $_SESSION['email'];

    $u_data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id FROM users WHERE email='$u_email'"));
    $u_id = $u_data['id'];

    mysqli_query($conn, "DELETE FROM cart WHERE user_id = '$u_id' AND product_id = '$p_id'");
}
?>