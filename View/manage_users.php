<?php include '../Model/db.php'; session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'Admin') { header("Location: login.php"); exit(); }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Users | Admin</title>
    <link rel="stylesheet" href="../admin_style.css">
</head>
<body>
    <div class="sidebar">
        <h2>BAKING VALLEY</h2>
        <a href="admin.php">Dashboard </a>
        <a href="manage_users.php" class="active">Manage Users</a>
        <a href="customer_orders.php">Customer Orders</a>
        <a href="manage_inventory.php">Manage Inventory</a>
        <a href="../Controller/logout.php" style="color:#ff7043">Logout</a>
    </div>
    <div class="main">
        <div class="card">
            <h2>User Management</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
                <?php
                $res = mysqli_query($conn, "SELECT * FROM users WHERE role != 'Admin'");
                while($row = mysqli_fetch_assoc($res)) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['username']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><b><?php echo $row['role']; ?></b></td>
                     <td>
    <a href="../Controller/remove_user.php?id=<?php echo $row['id']; ?>" 
       onclick="return confirm('Are you sure you want to remove this user?')" 
       style="color: red; text-decoration: none; font-weight: bold;">
       Remove
    </a>
</td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</body>
</html>