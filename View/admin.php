<?php 
include '../Model/db.php';
session_start();


if(!isset($_SESSION['role']) || $_SESSION['role'] != 'Admin') { 
    header("Location: login.php"); 
    exit(); 
}

$total_products = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM products"));
$total_orders = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM orders"));
$total_revenue = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(total_amount) as sum FROM orders"))['sum'] ?? 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | Admin</title>
    <link rel="stylesheet" href="../admin_style.css">
</head>
<body>
    <div class="sidebar">
        <h2>BAKING VALLEY</h2>
        <a href="admin.php" class="active">Dashboard</a>
        <a href="manage_users.php">Users</a>
        <a href="customer_orders.php">Orders</a>
        <a href="manage_inventory.php">Inventory</a>
        
        <div style="margin-top: auto; padding-bottom: 20px;">
            <a href="../Controller/admin_edit.php" style="color: #dcd0c0; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 15px;">
                <i class="fa fa-cog"></i> Edit Profile
            </a>
            <a href="../Controller/logout.php" style="color:#ff7043">Logout</a>
        </div>
    </div>

    <div class="main">
        <h1>Welcome, <?php echo $_SESSION['username']; ?></h1>
        
        <div style="display:grid; grid-template-columns: repeat(3, 1fr); gap:20px;">
            <div class="card">
                <h3>Revenue</h3>
                <p>৳ <?php echo number_format($total_revenue, 2); ?></p>
            </div>
            <div class="card">
                <h3>Products</h3>
                <p><?php echo $total_products; ?></p>
            </div>
            <div class="card">
                <h3>Orders</h3>
                <p><?php echo $total_orders; ?></p>
            </div>
        </div>
    </div>
</body>
</html>