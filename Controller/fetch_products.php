<?php 

include '../Model/db.php';

$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$cat = isset($_GET['cat']) ? mysqli_real_escape_string($conn, $_GET['cat']) : '';

$sql = "SELECT * FROM products WHERE 1=1";

if($search != '') {
    $sql .= " AND (name LIKE '%$search%' OR category LIKE '%$search%')";
}
if($cat != '') {
    $sql .= " AND category = '$cat'";
}

$sql .= " ORDER BY id DESC"; 

$res = mysqli_query($conn, $sql);

if(mysqli_num_rows($res) > 0) {
    while($row = mysqli_fetch_assoc($res)) { ?>
        <div class="product-card">
            <img src="uploads/<?php echo !empty($row['image']) ? $row['image'] : 'default.png'; ?>" alt="<?php echo $row['name']; ?>">
            
            <div class="product-info" style="padding: 10px 0;">
                <h3 style="margin: 5px 0; font-size: 16px;"><?php echo $row['name']; ?></h3>
                <p style="font-size: 12px; color: #888; margin-bottom: 8px;"><?php echo $row['category']; ?></p>
                
                <span class="price" style="display: block; font-weight: bold; color: #5d4037; font-size: 18px; margin-bottom: 15px;">
                    ৳ <?php echo number_format($row['price'], 2); ?>
                </span>
                
                <button class="add-btn" onclick="addToCart(<?php echo $row['id']; ?>)" style="width: 100%; cursor: pointer;">
                    <i class="fas fa-cart-plus"></i> Add to Cart
                </button>
            </div>
        </div>
    <?php }
} else {
    echo "<div style='grid-column: 1/-1; text-align: center; padding: 50px; color: #888; font-family: Poppins;'>
            <i class='fas fa-search' style='font-size: 40px; margin-bottom: 10px;'></i><br>
            No products found matching your criteria!
          </div>";
}
?>