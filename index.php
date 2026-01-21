<?php include 'Model/db.php'; session_start(); ?>
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
        
        <?php 
            $isLoggedIn = isset($_SESSION['email']);
            $btnClass = $isLoggedIn ? "checkout-btn" : "checkout-btn guest";
            $btnText = $isLoggedIn ? "Confirm Order" : "Login to Order";
            $btnLink = $isLoggedIn ? "View/order_summary.php" : "View/login.php";
        ?>
        <a href="<?= $btnLink ?>" class="<?= $btnClass ?>"><?= $btnText ?></a>
    </div>
</div>

<footer class="footer-main">
    <p>&copy; 2026 Baking Valley. All rights reserved.</p>
</footer>

<script>
    const call = url => fetch(url).then(r => r.text());

    async function loadProducts(s = '', c = '') {
        document.getElementById('productDisplay').innerHTML = await call(`Controller/fetch_products.php?search=${s}&cat=${c}`);
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
        document.getElementById('cartItems').innerHTML = await call('Controller/get_cart.php');
        const total = document.getElementById('hidden_total_val')?.value || 0;
        document.getElementById('sideBarTotal').innerText = '৳ ' + parseFloat(total).toLocaleString();
    }

    const addToCart = id => call(`Controller/add_to_cart_action.php?id=${id}`).then(() => { toggleCart(); });
    const updateQty = (id, a) => call(`Controller/update_qty.php?id=${id}&action=${a}`).then(updateCart);
    const removeItem = id => confirm('Remove?') && call(`Controller/remove_item.php?id=${id}`).then(updateCart);

    window.onload = () => { loadProducts(); updateCart(); };
</script>

</body>
</html>