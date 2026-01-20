<?php 
include '../Model/db.php';
session_start();

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'Admin') { header("Location: ../View/login.php"); exit(); }

$id = mysqli_real_escape_string($conn, $_GET['id']);
$res = mysqli_query($conn, "SELECT * FROM products WHERE id='$id'");
$data = mysqli_fetch_assoc($res);

if(isset($_POST['update_product'])) {
    $name = mysqli_real_escape_string($conn, $_POST['p_name']);
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    
    if(!empty($_FILES['p_image']['name'])) {
        $img_name = time() . "_" . $_FILES['p_image']['name'];
        move_uploaded_file($_FILES['p_image']['tmp_name'], "uploads/" . $img_name);
    } else {
        $img_name = $data['image'];
    }

    $sql = "UPDATE products SET name='$name', price='$price', stock='$stock', image='$img_name' WHERE id='$id'";
    if(mysqli_query($conn, $sql)) {
        echo "<script>alert('Product Updated!'); window.location.href='../View/manage_inventory.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Product | Admin</title>
    <link rel="stylesheet" href="../admin_style.css">
    <style>
        .edit-container { max-width: 500px; margin: 50px auto; }
        .current-img { width: 100px; border-radius: 10px; margin: 10px 0; border: 1px solid #ddd; }
    </style>
</head>
<body>
    <div class="edit-container">
        <div class="card">
            <h2 style="text-align:center; color:#5d4037;">Edit Product</h2>
            <form method="POST" enctype="multipart/form-data">
                <label>Product Name</label>
                <input type="text" name="p_name" value="<?php echo $data['name']; ?>" required>
                
                <label>Price (৳)</label>
                <input type="number" step="0.01" name="price" value="<?php echo $data['price']; ?>" required>
                
                <label>Stock Quantity</label>
                <input type="number" name="stock" value="<?php echo $data['stock']; ?>" required>
                
                <label>Current Image:</label><br>
                <img src="uploads/<?php echo $data['image']; ?>" class="current-img"><br>
                
                <label>Upload New Image</label>
                <input type="file" name="p_image">
                
                <button type="submit" name="update_product" class="btn" style="width:100%;">Save Changes</button>
            </form>
            <br>
            <a href="../View/manage_inventory.php" style="display:block; text-align:center; color:#8d6e63; text-decoration:none;">← Back to Inventory</a>
        </div>
    </div>
</body>
</html>