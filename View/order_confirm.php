<?php 
include '../Model/db.php';
session_start();


if(!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id']; 
$email = $_SESSION['email'];


$user_res = mysqli_query($conn, "SELECT username FROM users WHERE email='$email'");
$user_data = mysqli_fetch_assoc($user_res);
$customer_name = $user_data['username'];


$p_res = mysqli_query($conn, "SELECT * FROM products WHERE id='$id'");
$p_data = mysqli_fetch_assoc($p_res);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Confirm Your Order | Baking Valley</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #fffcf5; 
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .confirm-card {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.05);
            max-width: 400px;
            width: 90%;
            text-align: center;
            border: 1px solid #f1e9db;
        }
        .confirm-card h2 {
            font-family: 'Playfair Display', serif;
            color: #5d4037; 
            font-size: 28px;
            margin-bottom: 25px;
        }
        .order-details {
            background: #faf7f2;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 25px;
            text-align: left;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            border-bottom: 1px dashed #dcd0c0;
            padding-bottom: 8px;
        }
        .detail-row:last-child { border-bottom: none; }
        .label { color: #8d6e63; font-size: 14px; }
        .value { color: #3e2723; font-weight: 600; }

        .btn-confirm {
            background: #5d4037;
            color: white;
            border: none;
            padding: 15px 30px;
            width: 100%;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
            box-shadow: 0 5px 15px rgba(93, 64, 55, 0.2);
        }
        .btn-confirm:hover {
            background: #3e2723;
            transform: translateY(-2px);
        }
        .btn-cancel {
            display: inline-block;
            margin-top: 15px;
            color: #a1887f;
            text-decoration: none;
            font-size: 14px;
            transition: 0.3s;
        }
        .btn-cancel:hover { color: #5d4037; }
    </style>
</head>
<body>

<div class="confirm-card">
    <h2>Confirm Order</h2>
    
    <div class="order-details">
        <div class="detail-row">
            <span class="label">Product Name:</span>
            <span class="value"><?php echo $p_data['name']; ?></span>
        </div>
        <div class="detail-row">
            <span class="label">Product ID:</span>
            <span class="value">#<?php echo $id; ?></span>
        </div>
        <div class="detail-row">
            <span class="label">Customer:</span>
            <span class="value"><?php echo $customer_name; ?></span>
        </div>
        <div class="detail-row">
            <span class="label">Price:</span>
            <span class="value">৳ <?php echo number_format($p_data['price'], 2); ?></span>
        </div>
    </div>

    <form action="../Controller/place_order_action.php" method="POST">
        <input type="hidden" name="p_id" value="<?php echo $id; ?>">
        <input type="hidden" name="customer_name" value="<?php echo $customer_name; ?>">
        
        <button type="submit" name="confirm" class="btn-confirm">
            Place Order Now
        </button>
    </form>
    
    <a href="../index.php" class="btn-cancel">Cancel and Return</a>
</div>

</body>
</html>