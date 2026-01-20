<?php 
include '../Model/db.php';
session_start();

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'Admin') { 
    header("Location: login.php"); 
    exit(); 
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Customer Orders | Admin</title>
    <link rel="stylesheet" href="../admin_style.css">
</head>
<body>
    <div class="sidebar">
        <h2>BAKING VALLEY</h2>
        <a href="admin.php">Dashboard</a>
        <a href="manage_users.php">Users</a>
        <a href="customer_orders.php" class="active">Orders</a>
        <a href="manage_inventory.php">Inventory</a>
        <a href="../Controller/logout.php" style="color:#ff7043">Logout</a>
    </div>

    <div class="main">
        <div class="card">
            <h2>Customer Orders</h2>
            <table class="order-table">
                <tr>
                    <th>ID</th>
                    <th>Customer</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Update</th>
                </tr>
                <?php
                $res = mysqli_query($conn, "SELECT * FROM orders ORDER BY id DESC");
                while($row = mysqli_fetch_assoc($res)) { ?>
                    <tr>
                        <td>#<?php echo $row['id']; ?></td>
                        <td><?php echo $row['customer_name']; ?></td>
                        <td>৳ <?php echo $row['total_amount']; ?></td>
                        <td><b><?php echo $row['status']; ?></b></td>
                        <td>
                            <form action="../Controller/update_status.php" method="POST" style="display:flex; gap:5px;">
                                <input type="hidden" name="order_id" value="<?php echo $row['id']; ?>">
                                <select name="status" class="status-select">
                                    <option value="Pending" <?php if($row['status']=='Pending') echo 'selected'; ?>>Pending</option>
                                    <option value="Delivered" <?php if($row['status']=='Delivered') echo 'selected'; ?>>Delivered</option>
                                    <option value="Cancelled" <?php if($row['status']=='Cancelled') echo 'selected'; ?>>Cancelled</option>
                                </select>
                                <button type="submit" name="update" class="btn">OK</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</body>
</html>