<?php 
include '../Model/db.php';
session_start();

if(!isset($_SESSION['email']) || !isset($_GET['id'])) { header("Location: login.php"); exit(); }

$order_id = $_GET['id'];
$u_email = $_SESSION['email'];


$order_query = mysqli_query($conn, "SELECT * FROM orders WHERE id = '$order_id'");
$order_info = mysqli_fetch_assoc($order_query);


$items_res = mysqli_query($conn, "SELECT p.name, p.image, p.price, oi.quantity 
                                 FROM order_items oi 
                                 JOIN products p ON oi.product_id = p.id 
                                 WHERE oi.order_id = '$order_id'");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Order Details #<?php echo $order_id; ?></title>
    <style>
        body { background: #fffcf5; font-family: sans-serif; padding: 40px; }
        .details-card { max-width: 700px; margin: auto; background: white; padding: 30px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); }
        .item-row { display: flex; align-items: center; padding: 15px 0; border-bottom: 1px solid #eee; }
        .item-img { width: 70px; height: 70px; object-fit: cover; border-radius: 8px; margin-right: 20px; }
        .total-section { text-align: right; margin-top: 20px; font-size: 20px; font-weight: bold; color: #5d4037; }
    </style>
</head>
<body>
    <div class="details-card">
        <h2 style="color: #5d4037;">Order Details #<?php echo $order_id; ?></h2>
        <p>Status: <strong><?php echo $order_info['status']; ?></strong> | Date: <?php echo $order_info['created_at']; ?></p>
        <hr>

        <?php while($item = mysqli_fetch_assoc($items_res)) { ?>
            <div class="item-row">
                <img src="../uploads/<?php echo $item['image']; ?>" class="item-img">
                <div style="flex-grow: 1;">
                    <h4 style="margin: 0;"><?php echo $item['name']; ?></h4>
                    <p style="margin: 5px 0; color: #777;">Qty: <?php echo $item['quantity']; ?> x ৳<?php echo $item['price']; ?></p>
                </div>
                <div>৳ <?php echo number_format($item['quantity'] * $item['price'], 2); ?></div>
            </div>
        <?php } ?>

        <div class="total-section">
            Grand Total: ৳ <?php echo number_format($order_info['total_amount'], 2); ?>
        </div>

        <br>
        <a href="my_orders.php" style="color: #888; text-decoration: none;">← Back to My Orders</a>
    </div>
</body>
</html>