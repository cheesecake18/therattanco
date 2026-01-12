<?php
require 'db.php';
session_start();
$logged_in = isset($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meet Our Founders - The Rattan Co.</title>
    <!-- Google Fonts: Montserrat -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Vina+Sans&display=swap" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <!-- Main Header -->
    <header class="main-header" id="home">
        <div class="logo">
            <img src="images/logo.png" alt="Rattan Co. Logo">
        </div>
        <nav class="primary-nav">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="catalog.php">Products</a></li>
                <li><a href="#about">Our Story</a></li>
                <li><a href="#artisans">Artisans</a></li>
                <li><a href="#community">Community</a></li>
                <li><a href="#faqs">FAQs</a></li>
            </ul>
        </nav>
        <i class="fas fa-shopping-bag cart-icon"></i>
        <div class="user-menu">
            <button class="user-btn" onclick="toggleDropdown()"><i class="fas fa-user"></i></button>
            <div class="dropdown-menu" id="dropdown-menu">
                <?php if ($logged_in): ?>
                    <div class="dropdown-item">Welcome, <?= isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'User' ?>!</div>
                    <a href="#" class="dropdown-item">Profile</a>
                    <a href="logout.php" class="dropdown-item">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="dropdown-item">Login</a>
                    <a href="register.php" class="dropdown-item">Register</a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <!-- Founders Section -->
    <section class="founders-section">
        <h2>Meet Our Founders</h2>
        <div class="founders-grid">
            <div class="founder-card">
                <img src="images/founder1.jpg" alt="Founder 1">
                <h3>John Doe</h3>
                <p>Co-Founder & CEO</p>
                <p>John has over 20 years of experience in sustainable crafts and has dedicated his career to promoting ethical sourcing and traditional craftsmanship.</p>
            </div>
            <div class="founder-card">
                <img src="images/founder2.jpg" alt="Founder 2">
                <h3>Jane Smith</h3>
                <p>Co-Founder & Creative Director</p>
                <p>Jane is passionate about design and sustainability. She leads our design team in creating beautiful, functional pieces that honor traditional techniques.</p>
            </div>
        </div>
    </section>

    <?php include 'footer.php'; ?>

    <button class="floating-back-to-top" onclick="window.scrollTo({top: 0, behavior: 'smooth'});">
        <i class="fas fa-arrow-up"></i>
    </button>

    <script>
        // Cart functionality
        let cart = JSON.parse(localStorage.getItem('cart')) || [];

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

        // Make cart icon clickable
        document.querySelector('.cart-icon').addEventListener('click', showCart);

        function toggleDropdown() {
            const menu = document.getElementById('dropdown-menu');
            menu.classList.toggle('show');
        }

        // Close dropdown when clicking outside
        window.addEventListener('click', function(e) {
            const menu = document.getElementById('dropdown-menu');
            const btn = document.querySelector('.user-btn');
            if (!btn.contains(e.target) && !menu.contains(e.target)) {
                menu.classList.remove('show');
            }
        });
    </script>

</body>
</html>