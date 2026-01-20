<?php
include 'db.php';
session_start();


if(isset($_SESSION['email'])) {
    $u_email = $_SESSION['email'];
    
    
    $u_res = mysqli_query($conn, "SELECT id FROM users WHERE email='$u_email'");
    $u_row = mysqli_fetch_assoc($u_res);
    $u_id = $u_row['id'];

    
    $query = "SELECT p.*, c.quantity FROM cart c JOIN products p ON c.product_id = p.id WHERE c.user_id = '$u_id'";
    $res = mysqli_query($conn, $query);
    
    $total = 0;
    
    if(mysqli_num_rows($res) > 0) {
        while($row = mysqli_fetch_assoc($res)) {
            $subtotal = $row['price'] * $row['quantity'];
            $total += $subtotal;
            ?>
            
            <div class="cart-item" style="display: flex; align-items: center; margin-bottom: 12px; border-bottom: 1px solid #eee; padding-bottom: 8px; padding-right: 10px;">
                
                <img src="uploads/<?php echo $row['image']; ?>" 
                     width="50" 
                     height="50" 
                     style="object-fit: cover; border-radius: 5px; margin-right: 12px;" 
                     alt="<?php echo $row['name']; ?>">
                
                <div style="flex-grow: 1;">
                    <h4 style="margin: 0; font-size: 13px; color: #333;"><?php echo $row['name']; ?></h4>
                    <p style="margin: 3px 0; font-size: 12px; color: #5d4037;">Tk <?php echo $row['price']; ?></p>
                    
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <button onclick="updateQty(<?php echo $row['id']; ?>, 'minus')" style="cursor:pointer; padding: 0 5px;">-</button>
                        <span style="font-weight: bold; font-size: 13px;"><?php echo $row['quantity']; ?></span>
                        <button onclick="updateQty(<?php echo $row['id']; ?>, 'plus')" style="cursor:pointer; padding: 0 5px;">+</button>
                        
                        <button onclick="removeItem(<?php echo $row['id']; ?>)" style="margin-left: auto; color: #ff5252; border: none; background: none; cursor: pointer; font-size: 11px;">Remove</button>
                    </div>
                </div>
            </div>

            <?php
        }
        
        echo "<input type='hidden' id='hidden_total_val' value='$total'>";
    } else {
        echo "<p style='text-align:center; padding:20px; color: #888;'>Your bag is empty!</p>";
    }
} else {
    echo "<p style='text-align:center; padding:20px;'>Please login to see your cart.</p>";
}
?>