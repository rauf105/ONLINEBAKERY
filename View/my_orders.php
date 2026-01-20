<?php 
include '../Model/db.php';
session_start();


if(!isset($_SESSION['email'])) { 
    header("Location: login.php"); 
    exit(); 
}

$u_email = $_SESSION['email'];

$u_res = mysqli_query($conn, "SELECT id FROM users WHERE email='$u_email'");
$u_id = mysqli_fetch_assoc($u_res)['id'];


$res = mysqli_query($conn, "SELECT * FROM orders WHERE user_id = '$u_id' ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Orders | Baking Valley</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap');
        
        body { background: #fffcf5; font-family: 'Poppins', sans-serif; margin: 0; padding: 20px; }
        .order-container { max-width: 950px; margin: 40px auto; background: white; padding: 35px; border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.05); }
        .header { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #5d4037; padding-bottom: 15px; margin-bottom: 30px; }
        .header h2 { color: #5d4037; margin: 0; }
        
        table { width: 100%; border-collapse: collapse; }
        th { background: #f8f1e9; color: #5d4037; padding: 15px; text-align: left; font-size: 14px; }
        td { padding: 15px; border-bottom: 1px solid #eee; font-size: 14px; color: #444; }
        
        
        .status { padding: 5px 12px; border-radius: 15px; font-size: 11px; font-weight: 600; text-transform: uppercase; }
        .status-Pending { background: #fff3cd; color: #856404; }
        .status-Delivered { background: #d4edda; color: #155724; }
        .status-Cancelled { background: #f8d7da; color: #721c24; }
        
        .view-btn { background: #5d4037; color: white; padding: 8px 15px; border-radius: 6px; text-decoration: none; font-size: 12px; transition: 0.3s; }
        .view-btn:hover { background: #4a332c; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        .back-link { display: inline-block; margin-top: 25px; color: #5d4037; text-decoration: none; font-weight: 500; }
    </style>
</head>
<body>

<div class="order-container">
    <div class="header">
        <h2>My Order History</h2>
        <div style="font-size: 13px; color: #888;">Logged in as: <b><?php echo $_SESSION['email']; ?></b></div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Date</th>
                <th>Total Amount</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if(mysqli_num_rows($res) > 0) {
                while($row = mysqli_fetch_assoc($res)) { ?>
                <tr>
                    <td><b>#<?php echo $row['id']; ?></b></td>
                    <td><?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>
                    <td style="font-weight: 600;">৳ <?php echo number_format($row['total_amount'], 2); ?></td>
                    <td>
                        <span class="status status-<?php echo $row['status']; ?>">
                            <?php echo $row['status']; ?>
                        </span>
                    </td>
                    <td>
                        <a href="order_details.php?id=<?php echo $row['id']; ?>" class="view-btn">View Details</a>
                    </td>
                </tr>
            <?php } 
            } else { ?>
                <tr>
                    <td colspan="5" style="text-align: center; padding: 50px; color: #999;">You haven't placed any orders yet.</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <a href="../index.php" class="back-link">← Back to Shopping</a>
</div>

</body>
</html>