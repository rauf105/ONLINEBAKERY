<?php 
include '../Model/db.php';
session_start();

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'Admin') { 
    header("Location: login.php"); 
    exit(); 
}

if(isset($_POST['add_product'])) {
    $name = mysqli_real_escape_string($conn, $_POST['p_name']);
    $cat = mysqli_real_escape_string($conn, $_POST['category']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $stock = mysqli_real_escape_string($conn, $_POST['stock']);
    
    $img = $_FILES['p_image']['name'];
    $temp_img = $_FILES['p_image']['tmp_name'];
    $final_img_name = time() . "_" . $img;

    if(!empty($name) && !empty($price) && !empty($stock) && !empty($img)) {
        $sql = "INSERT INTO products (name, category, price, stock, image) VALUES ('$name', '$cat', '$price', '$stock', '$final_img_name')";
        
        if(mysqli_query($conn, $sql)) {
            move_uploaded_file($temp_img, "../uploads/" . $final_img_name);
            echo "<script>alert('Product Added Successfully!'); window.location.href='manage_inventory.php';</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "<script>alert('Error: Please fill all fields!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Inventory | Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { display: flex; margin: 0; font-family: 'Poppins', sans-serif; background: #fffcf5; }
        .sidebar { width: 260px; background: #5d4037; color: white; min-height: 100vh; padding: 30px 20px; position: fixed; }
        .sidebar a { display: block; color: #dcd0c0; padding: 12px 15px; text-decoration: none; border-radius: 8px; margin-bottom: 5px; }
        .sidebar a:hover, .active { background: rgba(255,255,255,0.1); color: white; }
        .main { margin-left: 290px; padding: 40px; width: calc(100% - 290px); }
        .card { background: white; padding: 25px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.03); margin-bottom: 30px; }
        .btn { border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; color: white; transition: 0.3s; }
        .btn-add { background: #5d4037; }
        .btn-edit { background: #2196F3; text-decoration: none; font-size: 12px; margin-right: 5px; }
        .btn-del { background: #f44336; text-decoration: none; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background: #f8f1e9; color: #5d4037; text-align: left; padding: 15px; }
        td { padding: 12px; border-bottom: 1px solid #eee; }
        input, select { padding: 10px; border: 1px solid #ddd; border-radius: 5px; }
    </style>
</head>
<body>

    <div class="sidebar">
        <h3>BAKING VALLEY</h3>
        <p style="font-size: 12px; color: #bc8f8f;">Admin Panel</p>
        <hr style="opacity: 0.1;">
        <a href="admin.php">Dashboard</a>
        <a href="customer_orders.php">Customer Orders</a>
        <a href="manage_inventory.php" class="active">Manage Inventory</a>
        <a href="manage_users.php">Manage Users</a> 
        <a href="../Controller/logout.php" style="color: #ffab91; margin-top: 20px; display: block;">Logout</a>
    </div>

    <div class="main">
        <div class="card">
            <h3 style="color: #5d4037; border-bottom: 2px solid #5d4037; padding-bottom: 10px;">Add New Bakery Item</h3>
            <form method="POST" enctype="multipart/form-data" onsubmit="return validateInventory()" novalidate style="margin-top: 20px;">
                <div style="display: flex; gap: 15px; margin-bottom: 15px;">
                    <input type="text" id="p_name" name="p_name" placeholder="Item Name" style="flex: 2;">
                    <select name="category" id="category" style="flex: 1;">
                        <option value="Cake">Cake</option>
                        <option value="Cream">Cream</option>
                        <option value="Tools">Tools</option>
                    </select>
                </div>
                <div style="display: flex; gap: 15px;">
                    <input type="number" step="0.01" id="price" name="price" placeholder="Price (৳)" style="flex: 1;">
                    <input type="number" id="stock" name="stock" placeholder="Initial Stock" style="flex: 1;">
                    <input type="file" id="p_image" name="p_image" style="flex: 1; padding-top: 8px;">
                </div>
                <button type="submit" name="add_product" class="btn btn-add" style="margin-top: 20px; width: 100%;">Add Product to Shop</button>
            </form>
        </div>

        <div class="card">
            <h3 style="color: #5d4037; border-bottom: 2px solid #5d4037; padding-bottom: 10px;">Current Inventory List</h3>
            <table>
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Item Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result = mysqli_query($conn, "SELECT * FROM products ORDER BY id DESC");
                    while($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr>
                        <td><img src="../uploads/<?php echo $row['image']; ?>" width="50" height="50" style="border-radius: 5px; object-fit: cover;"></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['category']; ?></td>
                        <td>৳ <?php echo $row['price']; ?></td>
                        <td><?php echo $row['stock']; ?></td>
                        <td>
                            <a href="../Controller/edit_product.php?id=<?php echo $row['id']; ?>" class="btn btn-edit">Edit</a>
                            <a href="../Controller/delete_product.php?id=<?php echo $row['id']; ?>" class="btn btn-del" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
    function validateInventory() {
        const name = document.getElementById('p_name').value.trim();
        const price = document.getElementById('price').value;
        const stock = document.getElementById('stock').value;
        const image = document.getElementById('p_image').value;

        if (name === "") {
            alert("Please enter the item name.");
            return false;
        }
        if (price === "" || price <= 0) {
            alert("Please enter a valid price.");
            return false;
        }
        if (stock === "" || stock < 0) {
            alert("Please enter a valid stock quantity.");
            return false;
        }
        if (image === "") {
            alert("Please upload a product image.");
            return false;
        }
        return true;
    }
    </script>
</body>
</html>