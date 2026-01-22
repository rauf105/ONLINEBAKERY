<?php
include '../Model/db.php';
session_start();
header('Content-Type: application/json');

$response = ['logged_in' => false, 'items' => [], 'total' => 0];

if(isset($_SESSION['email'])) {
    $response['logged_in'] = true;
    $email = $_SESSION['email'];
    $user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id FROM users WHERE email='$email'"));
    $u_id = $user['id'];

    $res = mysqli_query($conn, "SELECT p.*, c.quantity FROM cart c JOIN products p ON c.product_id = p.id WHERE c.user_id = '$u_id'");
    while($row = mysqli_fetch_assoc($res)) {
        $row['subtotal'] = $row['price'] * $row['quantity'];
        $response['total'] += $row['subtotal'];
        $response['items'][] = $row;
    }
}
echo json_encode($response);
?>