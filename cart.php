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
    <title>Cart - The Rattan Co.</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <section class="cart-section">
        <h2>Your Cart</h2>
        <div id="cart-items"></div>
        <div class="cart-actions">
            <button onclick="goBack()">Back to Shopping</button>
            <?php if ($logged_in): ?>
                <button onclick="checkout()">Proceed to Checkout</button>
            <?php else: ?>
                <p>Please <a href="login.php">login</a> or <a href="register.php">register</a> to checkout.</p>
            <?php endif; ?>
        </div>
    </section>

    <script>
        function showCart() {
            window.location.href = 'cart.php';
        }

        function loadCart() {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            const cartContainer = document.getElementById('cart-items');
            if (cart.length === 0) {
                cartContainer.innerHTML = '<p>Your cart is empty.</p>';
            } else {
                let html = '<div class="cart-items">';
                let total = 0;
                cart.forEach((item, index) => {
                    const itemTotal = item.price * item.quantity;
                    total += itemTotal;
                    html += `
                        <div class="cart-item">
                            <img src="${item.image}" alt="${item.name}" class="cart-item-image">
                            <div class="cart-item-details">
                                <h4>${item.name}</h4>
                                <p>₱${item.price} x ${item.quantity} = ₱${itemTotal}</p>
                                <div class="cart-controls">
                                    <button onclick="updateQuantity(${index}, -1)">-</button>
                                    <span>${item.quantity}</span>
                                    <button onclick="updateQuantity(${index}, 1)">+</button>
                                    <button onclick="removeItem(${index})" class="remove-btn">Remove</button>
                                </div>
                            </div>
                        </div>
                    `;
                });
                html += `<div class="cart-total"><h3>Total: ₱${total}</h3></div>`;
                html += '</div>';
                cartContainer.innerHTML = html;
            }
        }

        function updateQuantity(index, change) {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            if (cart[index]) {
                cart[index].quantity += change;
                if (cart[index].quantity <= 0) {
                    cart.splice(index, 1);
                }
                localStorage.setItem('cart', JSON.stringify(cart));
                loadCart();
            }
        }

        function removeItem(index) {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            cart.splice(index, 1);
            localStorage.setItem('cart', JSON.stringify(cart));
            loadCart();
        }

        function checkout() {
            window.location.href = 'checkout.php';
        }

        function goBack() {
            window.location.href = 'index.php';
        }

        loadCart();
    </script>
</body>
</html>