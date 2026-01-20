<?php
include '../Model/db.php';
session_start();

if(!isset($_SESSION['email'])) { header("Location: ../View/login.php"); exit(); }

$u_email = $_SESSION['email'];
$u_res = mysqli_query($conn, "SELECT id, username FROM users WHERE email='$u_email'");
$u_data = mysqli_fetch_assoc($u_res);
$u_id = $u_data['id'];
$u_name = $u_data['username'];


$cart_res = mysqli_query($conn, "SELECT p.*, c.quantity FROM cart c JOIN products p ON c.product_id = p.id WHERE c.user_id = '$u_id'");
$grand_total = 0;
$items = [];
while($row = mysqli_fetch_assoc($cart_res)) {
    $grand_total += ($row['price'] * $row['quantity']);
    $items[] = $row; 
}

if($grand_total > 0) {
    
    $order_sql = "INSERT INTO orders (user_id, customer_name, total_amount, status) VALUES ('$u_id', '$u_name', '$grand_total', 'Pending')";
    if(mysqli_query($conn, $order_sql)) {
        $new_order_id = mysqli_insert_id($conn); 

        
        foreach($items as $item) {
            $p_id = $item['id'];
            $qty = $item['quantity'];
            $price = $item['price'];
            mysqli_query($conn, "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES ('$new_order_id', '$p_id', '$qty', '$price')");
        }

        
        mysqli_query($conn, "DELETE FROM cart WHERE user_id = '$u_id'");

        header("Location: ../View/my_orders.php?order=success");
    }
} else {
    header("Location: ../index.php");
}
?>