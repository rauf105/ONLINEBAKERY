<?php include '../Model/db.php'; ?>
<!DOCTYPE html>
<html>
<head><title>All Orders</title></head>
<body style="font-family: sans-serif; padding: 20px;">
    <h2>Customer Order History</h2>
    <table border="1" width="100%" cellpadding="10" style="border-collapse: collapse;">
        <tr style="background: #2c3e50; color: white;">
            <th>Order ID</th>
            <th>Customer Name</th>
            <th>Bill Amount</th>
            <th>Status</th>
        </tr>
        <?php
        $res = mysqli_query($conn, "SELECT * FROM orders ORDER BY id DESC");
        while($row = mysqli_fetch_assoc($res)) {
            echo "<tr>
                    <td>#{$row['id']}</td>
                    <td>{$row['customer_name']}</td>
                    <td>৳ {$row['total_amount']}</td>
                    <td>{$row['status']}</td>
                  </tr>";
        }
        ?>
    </table>
</body>
</html>