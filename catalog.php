<?php
require_once 'classes/Product.php';
session_start();
$productObj = new Product();
$categories = $productObj->getCategories();
$products = $productObj->getAllProducts();
$logged_in = isset($_SESSION['user_id']);

// Filter by category if set
$selectedCategory = isset($_GET['category']) ? $_GET['category'] : '';
if ($selectedCategory && in_array($selectedCategory, $categories)) {
    $products = $productObj->getProductsByCategory($selectedCategory);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalog - The Rattan Co.</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="catalog.css">
</head>
<body>
    <div class="catalog-header">
        <button class="back-btn" onclick="window.location.href='index.php'">Back</button>
        <div class="filter-container">
            <label for="category-filter">Filter by Category:</label>
            <select id="category-filter" onchange="filterProducts()">
                <option value="">All Categories</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= htmlspecialchars($category) ?>" <?= $selectedCategory === $category ? 'selected' : '' ?>><?= htmlspecialchars($category) ?></option>
                <?php endforeach; ?>
            </select>
            <i class="fas fa-shopping-bag cart-icon" onclick="showCart()"></i>
        </div>
    </div>
    <div class="products-grid">
        <?php if (empty($products)): ?>
            <p class="empty-message">No products found in this category.</p>
        <?php else: ?>
            <?php foreach ($products as $product): ?>
                <div class="product-card">
                    <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['item']) ?>">
                    <h3><?= htmlspecialchars($product['item']) ?></h3>
                    <p><?= htmlspecialchars(substr($product['description'], 0, 50)) ?></p>
                    <span class="price">₱<?= number_format($product['price']) ?></span>
                    <div class="button-group">
                        <button class="product-btn add-to-cart" onclick="addToCart('<?= htmlspecialchars($product['item']) ?>', <?= $product['price'] ?>, '<?= htmlspecialchars($product['image']) ?>')">Add to Cart</button>
                        <button class="product-btn buy-now" onclick="buyNow('<?= htmlspecialchars($product['item']) ?>', <?= $product['price'] ?>, '<?= htmlspecialchars($product['image']) ?>')">Buy Now</button>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    </div>

    <script>
        function filterProducts() {
            const category = document.getElementById('category-filter').value;
            const url = new URL(window.location);
            url.searchParams.set('category', category);
            window.location.href = url.toString();
        }

        // Cart functionality
        let cart = JSON.parse(localStorage.getItem('cart')) || [];

        function addToCart(itemName, price, image) {
            const item = cart.find(i => i.name === itemName);
            if (item) {
                item.quantity += 1;
            } else {
                cart.push({ name: itemName, price: price, quantity: 1, image: image });
            }
            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartIcon();
            alert(itemName + ' added to cart!');
        }

        function buyNow(itemName, price, image) {
            addToCart(itemName, price, image);
            window.location.href = 'checkout.php';
        }

        function updateCartIcon() {
            const cartCount = cart.reduce((sum, item) => sum + item.quantity, 0);
            const cartIcon = document.querySelector('.cart-icon');
            cartIcon.setAttribute('data-count', cartCount);
        }

        function showCart() {
            window.location.href = 'cart.php';
        }

        // Initialize cart icon
        updateCartIcon();
    </script>
</body>
</html>