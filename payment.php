<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$method = $_GET['method'] ?? 'unknown';
$total = $_GET['total'] ?? 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment - The Rattan Co.</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="payment.css">
</head>
<body>
    <section class="checkout-section">
        <h2>Payment Completed</h2>
        <p>Payment for <?php echo htmlspecialchars($method); ?> completed successfully! Total: ₱<?php echo htmlspecialchars($total); ?></p>
        <p>Order confirmed.</p>
        <a href="index.php">Back to Home</a>
    </section>
    <script>
        setTimeout(() => window.location.href='index.php', 10000);
    </script>
</body>
</html>