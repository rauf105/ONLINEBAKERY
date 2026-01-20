<?php
include '../Model/db.php';
session_start();

if(isset($_GET['id']) && isset($_GET['action']) && isset($_SESSION['email'])) {
    $p_id = $_GET['id'];
    $action = $_GET['action'];
    $u_email = $_SESSION['email'];

    $u_data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id FROM users WHERE email='$u_email'"));
    $u_id = $u_data['id'];

    if($action == 'plus') {
        mysqli_query($conn, "UPDATE cart SET quantity = quantity + 1 WHERE user_id = '$u_id' AND product_id = '$p_id'");
    } else {
        mysqli_query($conn, "UPDATE cart SET quantity = quantity - 1 WHERE user_id = '$u_id' AND product_id = '$p_id' AND quantity > 1");
    }
}
?>