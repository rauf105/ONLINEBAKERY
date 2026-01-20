<?php
include '../Model/db.php';
session_start();

if(!isset($_SESSION['email'])) { header("Location: login.php"); exit(); }

$u_email = $_SESSION['email'];

$u_info = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id, username FROM users WHERE email='$u_email'"));
$u_id = $u_info['id'];


$res = mysqli_query($conn, "SELECT p.*, c.quantity FROM cart c JOIN products p ON c.product_id = p.id WHERE c.user_id = '$u_id'");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Review Your Order</title>
    <style>
        body { background: #fffcf5; font-family: sans-serif; }
        .container { max-width: 800px; margin: 40px auto; background: #fff; padding: 35px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background: #f8f1e9; color: #5d4037; padding: 12px; text-align: left; }
        td { padding: 12px; border-bottom: 1px solid #eee; }
        .btn-confirm { background: #5d4037; color: #fff; padding: 12px 30px; border-radius: 8px; text-decoration: none; font-weight: bold; float: right; }
    </style>
</head>
<body>
    <div class="container">
        <h2 style="color: #5d4037; border-bottom: 2px solid #5d4037; padding-bottom: 10px;">Review Your Order</h2>
        <p>Customer Name: <strong><?php echo $u_info['username']; ?></strong></p>

        <table>
            <tr>
                <th>Image</th>
                <th>Product</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Subtotal</th>
            </tr>
            <?php 
            $total = 0;
            while($row = mysqli_fetch_assoc($res)) {
                $sub = $row['price'] * $row['quantity'];
                $total += $sub;
                echo "<tr>
                        <td><img src='../uploads/{$row['image']}' width='55' style='border-radius:5px;'></td>
                        <td>{$row['name']}</td>
                        <td>৳ {$row['price']}</td>
                        <td>{$row['quantity']}</td>
                        <td style='font-weight:bold;'>৳ ".number_format($sub, 2)."</td>
                      </tr>";
            }
            ?>
        </table>

        <div style="text-align: right; margin-top: 25px; font-size: 22px; font-weight: bold; color: #5d4037;">
            Total: ৳ <?php echo number_format($total, 2); ?>
        </div>
        
        <div style="margin-top: 30px; overflow: hidden;">
            <a href="../index.php" style="color: #888; text-decoration: none;">← Go to Shop</a>
            <a href="../Controller/place_order_action.php" class="btn-confirm">Confirm Order Now</a>
        </div>
    </div>
</body>
</html>