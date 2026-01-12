<?php
require_once 'classes/User.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$userObj = new User();
$user = $userObj->getUserById($user_id);
$default = [
    'default_province' => $user['default_province'],
    'default_city' => $user['default_city'],
    'default_barangay' => $user['default_barangay'],
    'default_street' => $user['default_street'],
    'last_payment' => $user['last_payment'],
    'contact' => $user['contact']
];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cart = json_decode($_POST['cart'], true);
    $user_id = $_SESSION['user_id'];
    $name = $_POST['name'];
    $province = $_POST['province'];
    $city = $_POST['city'];
    $barangay = $_POST['barangay'];
    $street = $_POST['street'];
    $address = $street . ', ' . $barangay . ', ' . $city . ', ' . $province;
    $contact = $_POST['contact'];
    $payment = $_POST['payment'];

    $total = 0;
    if (is_array($cart)) {
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
    }

    $online_payments = ['gcash', 'maya', 'grabpay', 'coins', 'qrph', 'credit'];

    // Save last payment method and contact
    $userObj->updateContact($user_id, $contact);
    $userObj->updateLastPayment($user_id, $payment);
    if ($payment == 'cod') {
        header("Location: payment.php?method=cod&total=$total");
        exit;
    } elseif (in_array($payment, $online_payments)) {
        // Redirect to other payment gateways
        header("Location: payment.php?method=$payment&total=$total");
        exit;
    } else {
        echo "Order placed successfully! Total: ₱$total<br>";
        echo "Name: $name<br>";
        echo "Address: $address<br>";
        echo "Contact: $contact<br>";
        echo "Payment: $payment<br>";

        if (isset($_POST['save_default'])) {
            $userObj->updateAddress($user_id, $province, $city, $barangay, $street, 'default');
            echo "Default shipping address saved.<br>";
        }

        echo "<a href='index.php'>Back to Home</a><br>";
        echo "<script>localStorage.removeItem('cart');</script>";
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Checkout - The Rattan Co.</title>
<link rel="stylesheet" href="styles.css">
<link rel="stylesheet" href="checkout.css">
</head>
<body>
<section class="checkout-section">
<h2>Checkout</h2>
<div id="checkout-items"></div>
<form method="POST" id="checkout-form">
    <input type="hidden" name="cart" id="cart-data">
    <label for="name">Full Name:</label>
    <input type="text" name="name" value="<?php echo htmlspecialchars($_SESSION['username'] ?? ''); ?>" required>

    <label for="province">Province:</label>
    <input type="text" name="province" value="<?php echo htmlspecialchars($default['default_province'] ?? ''); ?>" required>

    <label for="city">City/Municipality:</label>
    <input type="text" name="city" value="<?php echo htmlspecialchars($default['default_city'] ?? ''); ?>" required>

    <label for="barangay">Barangay:</label>
    <input type="text" name="barangay" value="<?php echo htmlspecialchars($default['default_barangay'] ?? ''); ?>" required>

    <label for="street">Street Address:</label>
    <input type="text" name="street" value="<?php echo htmlspecialchars($default['default_street'] ?? ''); ?>" required>

    <label><input type="checkbox" name="save_default"> Save as default shipping address</label>

    <label for="contact">Contact Number:</label>
    <input type="tel" name="contact" value="<?php echo htmlspecialchars($default['contact'] ?? ''); ?>" required>

    <label><input type="checkbox" id="use_last_payment" <?php if ($default['last_payment']) echo 'checked'; ?>> Use last payment method</label>
    <label for="payment">Payment Method:</label>
    <select name="payment" id="payment" required>
        <option value="cod">Cash on Delivery</option>
        <option value="gcash">GCash</option>
        <option value="maya">Maya</option>
        <option value="grabpay">GrabPay</option>
        <option value="coins">Coins.ph</option>
        <option value="qrph">QR PH</option>
        <option value="credit">Credit/Debit Card</option>
    </select>

    <div style="display: flex; justify-content: space-between; margin-top: 20px;">
        <button type="button" onclick="window.location.href='index.php'">Back to Home</button>
        <button type="submit">Place Order</button>
    </div>
</form>
</section>

<script>
const cart = JSON.parse(localStorage.getItem('cart')) || [];
const checkoutItems = document.getElementById('checkout-items');
const cartData = document.getElementById('cart-data');

if (cart.length === 0) {
    checkoutItems.innerHTML = '<p>Your cart is empty.</p>';
} else {
    let html = '<div class="checkout-items">';
    let total = 0;
    cart.forEach(item => {
        const itemTotal = item.price * item.quantity;
        total += itemTotal;
        html += `<div class="checkout-item"><img src="${item.image}" alt="${item.name}" class="checkout-item-image"><div class="checkout-item-details"><h4>${item.name}</h4><p>₱${item.price} x ${item.quantity} = ₱${itemTotal}</p></div></div>`;
    });
    html += `<div class="checkout-total"><h3>Total: ₱${total}</h3></div></div>`;
    checkoutItems.innerHTML = html;
    cartData.value = JSON.stringify(cart);
}

// Handle use last payment checkbox
const useLastPaymentCheckbox = document.getElementById('use_last_payment');
const paymentSelect = document.getElementById('payment');
const lastPayment = '<?php echo $default['last_payment'] ?? ''; ?>';

function updatePaymentSelect() {
    if (useLastPaymentCheckbox.checked && lastPayment) {
        paymentSelect.value = lastPayment;
    } else {
        paymentSelect.value = 'cash'; // default
    }
}

useLastPaymentCheckbox.addEventListener('change', updatePaymentSelect);

// Initial set
updatePaymentSelect();
</script>
</body>
</html>
