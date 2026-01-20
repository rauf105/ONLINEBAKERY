<?php include '../Model/db.php'; session_start();
if(!isset($_SESSION['email'])) { header("Location: login.php"); exit(); }
$email = $_SESSION['email'];
$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id FROM users WHERE email='$email'"));
$u_id = $user['id'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Cart | Baking Valley</title>
    <style>
        body { font-family: sans-serif; background: #fffcf5; padding: 50px; }
        .cart-box { max-width: 800px; margin: auto; background: white; padding: 30px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 15px; border-bottom: 1px solid #eee; text-align: center; }
        .btn-qty { background: #5d4037; color: white; padding: 5px 10px; text-decoration: none; border-radius: 3px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="cart-box">
        <h2>Your Cart</h2>
        <table>
            <tr><th>Product</th><th>Price</th><th>Quantity</th><th>Total</th><th>Action</th></tr>
            <?php
            $grand = 0;
            $res = mysqli_query($conn, "SELECT cart.*, products.name, products.price FROM cart JOIN products ON cart.product_id = products.id WHERE cart.user_id = '$u_id'");
            while($row = mysqli_fetch_assoc($res)) {
                $total = $row['price'] * $row['quantity'];
                $grand += $total;
                ?>
                <tr>
                    <td><?php echo $row['name']; ?></td>
                    <td>৳ <?php echo $row['price']; ?></td>
                    <td>
                        <a href="Controller/update_qty.php?id=<?php echo $row['product_id']; ?>&act=minus" class="btn-qty">-</a>
                        <span style="margin: 0 10px;"><?php echo $row['quantity']; ?></span>
                        <a href="Controller/update_qty.php?id=<?php echo $row['product_id']; ?>&act=plus" class="btn-qty">+</a>
                    </td>
                    <td>৳ <?php echo $total; ?></td>
                    <td><a href="../Controller/remove_item.php?id=<?php echo $row['product_id']; ?>" style="color:red;">Remove</a></td>
                </tr>
            <?php } ?>
        </table>
        <h3>Grand Total: ৳ <?php echo $grand; ?></h3>
        <a href="../Controller/place_order_action.php" style="background:#5d4037; color:white; padding:12px 25px; text-decoration:none; float:right; border-radius:5px;">Place Order</a>
    </div>
</body>
</html>