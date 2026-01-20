<?php 

include 'Model/db.php';
session_start(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Baking Valley | Shop</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="shop_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

<nav>
    <div class="logo"><a href="index.php">BAKING VALLEY</a></div>
    
    <div class="search-container">
        <input type="text" id="searchInput" placeholder="Search cakes, tools..." onkeyup="filterProducts()">
        <button><i class="fa fa-search"></i></button>
    </div>

    <div class="nav-links">
        <a href="index.php">Home</a>
        <a href="View/my_orders.php">My Orders</a>
        <a href="javascript:void(0)" onclick="toggleCart()" class="cart-link">
            <i class="fa fa-shopping-cart"></i> Cart
        </a>
        
        <?php if(isset($_SESSION['email'])): ?>
            <a href="Controller/customer_edit.php" style="color: #f8f1e9; font-weight: 500; margin-right: 10px;">
                <i class="fa fa-user-circle"></i> Edit Profile
            </a>
            <a href="Controller/logout.php" class="logout-btn">Logout</a>
        <?php else: ?>
            <a href="View/login.php" class="logout-btn">Login</a>
        <?php endif; ?>
    </div>
</nav>

<div class="hero-section">
    <h1>Premium Baking Tools</h1>
    <p>Find everything you need to bake like a pro</p>
    <a href="#products" class="btn" style="background: white; color: #5d4037; padding: 10px 25px; border-radius: 25px; text-decoration: none; font-weight: 600; margin-top: 15px; display: inline-block;">Explore Now</a>
</div>

<div class="category-bar" id="products">
    <button onclick="filterCat('')" class="cat-btn active">All Products</button>
    <button onclick="filterCat('Cake')" class="cat-btn">Cake</button>
    <button onclick="filterCat('Tools')" class="cat-btn">Tools</button>
    <button onclick="filterCat('Cream')" class="cat-btn">Cream</button>
</div>

<div class="product-grid" id="productDisplay" style="padding: 0 5%; margin-bottom: 50px;">
    </div>

<div id="cartSidebar" class="cart-sidebar">
    <div class="cart-header">
        <h3>Shopping Bag</h3>
        <button onclick="toggleCart()" class="close-btn">&times;</button>
    </div>
    
    <div id="cartItems" class="cart-body">
        </div>

    <div class="cart-footer">
        <div class="total-row" style="display: flex; justify-content: space-between; padding: 15px 0; border-top: 1px solid #eee;">
            <span style="font-weight: 600;">Total Amount:</span>
            <span id="sideBarTotal" style="color: #5d4037; font-weight: bold;">৳ 0.00</span>
        </div>

        <?php if(isset($_SESSION['email'])): ?>
            <a href="View/order_summary.php" class="checkout-btn" style="display: block; text-align: center; background: #5d4037; color: white; padding: 15px; border-radius: 10px; text-decoration: none;">Confirm Order</a>
        <?php else: ?>
            <a href="View/login.php" class="checkout-btn" style="display: block; text-align: center; background: #ff7043; color: white; padding: 15px; border-radius: 10px; text-decoration: none;">Login to Order</a>
        <?php endif; ?>
    </div>
</div>

<footer style="background: #5d4037; color: #dcd0c0; text-align: center; padding: 40px 0; margin-top: 50px;">
    <p>&copy; 2026 Baking Valley. All rights reserved.</p>
</footer>

<script>
  
    function loadProducts(search = '', cat = '') {
        fetch(`Controller/fetch_products.php?search=${encodeURIComponent(search)}&cat=${encodeURIComponent(cat)}`)
            .then(res => res.text())
            .then(data => { 
                document.getElementById('productDisplay').innerHTML = data; 
            })
            .catch(err => console.error("Error loading products:", err));
    }

    function filterProducts() {
        loadProducts(document.getElementById('searchInput').value, '');
    }

    function filterCat(cat) {
        loadProducts('', cat);
        document.querySelectorAll('.cat-btn').forEach(btn => btn.classList.remove('active'));
        event.target.classList.add('active');
    }

    function toggleCart() {
        document.getElementById('cartSidebar').classList.toggle('open');
        updateSidebarCart();
    }

    function updateSidebarCart() {
        fetch('Controller/get_cart.php')
            .then(res => res.text())
            .then(data => {
                document.getElementById('cartItems').innerHTML = data;
                let hiddenTotal = document.getElementById('hidden_total_val');
                if(hiddenTotal) {
                    document.getElementById('sideBarTotal').innerText = '৳ ' + parseFloat(hiddenTotal.value).toLocaleString();
                } else {
                    document.getElementById('sideBarTotal').innerText = '৳ 0.00';
                }
            });
    }

    function addToCart(p_id) {
        fetch(`Controller/add_to_cart_action.php?id=${p_id}`).then(() => {
            updateSidebarCart();
            document.getElementById('cartSidebar').classList.add('open');
        });
    }

    function updateQty(p_id, action) {
        fetch(`Controller/update_qty.php?id=${p_id}&action=${action}`).then(() => updateSidebarCart());
    }

    function removeItem(p_id) {
        if(confirm('Remove item?')) {
            fetch(`Controller/remove_item.php?id=${p_id}`).then(() => updateSidebarCart());
        }
    }

    window.onload = () => {
        loadProducts();
        updateSidebarCart(); 
    };
</script>

</body>
</html>