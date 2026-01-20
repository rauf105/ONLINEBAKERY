<?php 
include 'db.php'; 
include 'sidebar.php'; 


$rev_res = mysqli_query($conn, "SELECT SUM(total_amount) AS total FROM orders WHERE status = 'Delivered'");
$rev_data = mysqli_fetch_assoc($rev_res);
$total_earned = $rev_data['total'] ?? 0;


$del_res = mysqli_query($conn, "SELECT COUNT(*) AS count FROM orders WHERE status = 'Delivered'");
$total_delivered = mysqli_fetch_assoc($del_res)['count'];
?>

<div class="main">
    <div class="card" id="printableArea">
        <h2 style="color: #5d4037; text-align: center;">Baking Valley - Sales Report</h2>
        <hr>
        <div style="margin: 30px 0;">
            <p style="font-size: 18px;"><strong>Report Date:</strong> <?php echo date("d-M-Y"); ?></p>
            <p style="font-size: 18px;"><strong>Total Successful Deliveries:</strong> <?php echo $total_delivered; ?></p>
            <h1 style="color: #8d6e63;">Total Revenue: ৳ <?php echo number_format($total_earned, 2); ?></h1>
        </div>
        <p style="color: #777;">* This report includes only orders with 'Delivered' status.</p>
    </div>
    
    <button onclick="window.print()" class="btn" style="width: 200px; font-weight: bold;">
        Print / Download Report
    </button>
</div>