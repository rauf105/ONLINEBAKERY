<?php 
include 'Model/db.php'; 
session_start(); 

if (!isset($_SESSION['email']) && isset($_COOKIE['user_email'])) {
    $c_email = $_COOKIE['user_email'];
    $c_res = mysqli_query($conn, "SELECT * FROM users WHERE email='$c_email'");
    if ($row = mysqli_fetch_assoc($c_res)) {
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['role'] = $row['role'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Baking Valley | Shop</title>
    <link rel="stylesheet" href="shop_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

<nav>
    <div class="logo"><a href="index.php">BAKING VALLEY</a></div>
    <div class="search-container">
        <input type="text" id="searchInput" placeholder="Search..." onkeyup="loadProducts(this.value)">
        <button><i class="fa fa-search"></i></button>
    </div>
    <div class="nav-links">
        <a href="index.php">Home</a>
        <a href="View/my_orders.php">Orders</a>
        <a href="javascript:void(0)" onclick="toggleCart()"><i class="fa fa-shopping-cart"></i> Cart</a>
        <?php if(isset($_SESSION['email'])): ?>
            <a href="Controller/customer_edit.php">Profile</a>
            <a href="Controller/logout.php" class="logout-btn">Logout</a>
        <?php else: ?>
            <a href="View/login.php" class="logout-btn">Login</a>
        <?php endif; ?>
    </div>
</nav>

<div class="hero-section">
    <h1>Premium Baking Tools</h1>
    <p>Find everything you need to bake like a pro</p>
    <a href="#products" class="hero-btn">Explore Now</a>
</div>

<div class="category-bar" id="products">
    <button onclick="filterCat('', this)" class="cat-btn active">All</button>
    <button onclick="filterCat('Cake', this)" class="cat-btn">Cake</button>
    <button onclick="filterCat('Tools', this)" class="cat-btn">Tools</button>
    <button onclick="filterCat('Cream', this)" class="cat-btn">Cream</button>
</div>

<div class="product-grid product-display-container" id="productDisplay"></div>

<div id="cartSidebar" class="cart-sidebar">
    <div class="cart-header">
        <h3>Shopping Bag</h3>
        <button onclick="toggleCart()" class="close-btn">&times;</button>
    </div>
    <div id="cartItems" class="cart-body"></div>
    <div class="cart-footer">
        <div class="sidebar-total-row">
            <b>Total:</b> <span id="sideBarTotal">৳ 0.00</span>
        </div>
        <a href="View/order_summary.php" class="checkout-btn">Confirm Order</a>
    </div>
</div>

<footer class="footer-main">
    <p>&copy; 2026 Baking Valley. All rights reserved.</p>
</footer>

<script>
    const fetchJSON = url => fetch(url).then(r => r.json());

    async function loadProducts(s = '', c = '') {
        const products = await fetchJSON(`Controller/fetch_products.php?search=${s}&cat=${c}`);
        const container = document.getElementById('productDisplay');
        
        if(!products.length) {
            container.innerHTML = "<p style='grid-column:1/-1; text-align:center;'>No products found!</p>";
            return;
        }

        container.innerHTML = products.map(p => `
            <div class="product-card">
                <img src="uploads/${p.image || 'default.png'}" alt="${p.name}">
                <div class="product-info">
                    <h3>${p.name}</h3>
                    <p>${p.category}</p>
                    <span class="price">৳ ${parseFloat(p.price).toFixed(2)}</span>
                    <button class="add-btn" onclick="addToCart(${p.id})">
                        <i class="fas fa-cart-plus"></i> Add to Cart
                    </button>
                </div>
            </div>
        `).join('');
    }

    function filterCat(c, btn) {
        loadProducts('', c);
        document.querySelectorAll('.cat-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
    }

    function toggleCart() {
        document.getElementById('cartSidebar').classList.toggle('open');
        updateCart();
    }

    async function updateCart() {
        const data = await fetchJSON('Controller/get_cart.php');
        const container = document.getElementById('cartItems');
        
        if(!data.logged_in) {
            container.innerHTML = "<p style='padding:20px;'>Please login.</p>";
            return;
        }

        container.innerHTML = data.items.length ? data.items.map(item => `
            <div class="cart-item" style="display:flex; align-items:center; border-bottom:1px solid #eee; padding:10px;">
                <img src="uploads/${item.image}" width="40" height="40" style="margin-right:10px;">
                <div style="flex:1;">
                    <h4 style="margin:0; font-size:13px;">${item.name}</h4>
                    <div style="display:flex; align-items:center; gap:10px;">
                        <button onclick="updateQty(${item.id}, 'minus')">-</button>
                        <span>${item.quantity}</span>
                        <button onclick="updateQty(${item.id}, 'plus')">+</button>
                        <button onclick="removeItem(${item.id})" style="margin-left:auto; color:red; border:none; background:none;">×</button>
                    </div>
                </div>
            </div>
        `).join('') : "<p style='padding:20px;'>Empty!</p>";

        document.getElementById('sideBarTotal').innerText = '৳ ' + data.total.toLocaleString();
    }

    const addToCart = id => fetch(`Controller/add_to_cart_action.php?id=${id}`).then(updateCart).then(() => { 
        if(!document.getElementById('cartSidebar').classList.contains('open')) toggleCart(); 
    });
    
    const updateQty = (id, a) => fetch(`Controller/update_qty.php?id=${id}&action=${a}`).then(updateCart);
    const removeItem = id => confirm('Remove?') && fetch(`Controller/remove_item.php?id=${id}`).then(updateCart);

    window.onload = () => { loadProducts(); updateCart(); };
</script>
</body>
</html>