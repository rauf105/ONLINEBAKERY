<?php
include 'db.php';
session_start();


if(!isset($_SESSION['role']) || $_SESSION['role'] != 'Admin') {
    header("Location: login.php");
    exit();
}

if(isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    
    
    $sql = "DELETE FROM users WHERE id = '$id'";
    
    if(mysqli_query($conn, $sql)) {
        
        header("Location: manage_users.php?msg=User Removed Successfully");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    header("Location: manage_users.php");
}
?>