<?php
include '../Model/db.php';
session_start();


if(!isset($_SESSION['role']) || $_SESSION['role'] != 'Admin') {
    exit("Unauthorized Access! Only Admin can delete products.");
}

if(isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    
    
    $sql = "DELETE FROM products WHERE id = '$id'";
    
    if(mysqli_query($conn, $sql)) {
        header("Location: ../View/manage_inventory.php");
        exit();
    } else {
        echo "Error deleting product: " . mysqli_error($conn);
    }
}
?>