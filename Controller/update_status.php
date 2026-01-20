<?php
include '../Model/db.php';
session_start();


if(!isset($_SESSION['email'])) {
    header("Location: ../View/login.php");
    exit();
}

if(isset($_POST['order_id']) && isset($_POST['status'])) {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];

    
    $sql = "UPDATE orders SET status = '$status' WHERE id = '$order_id'";
    
    if(mysqli_query($conn, $sql)) {
        
        header("Location: ../View/customer_orders.php?msg=updated");
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
} else {
    header("Location: ../View/customer_orders.php");
}
?>