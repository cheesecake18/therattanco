<?php
require_once 'classes/User.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$userObj = new User();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update_personal'])) {
        $email = $_POST['email'];
        if ($userObj->updateEmail($user_id, $email)) {
            $message = "Personal info updated.";
        }
    } elseif (isset($_POST['update_password'])) {
        $password = $_POST['password'];
        if ($userObj->updatePassword($user_id, $password)) {
            $message = "Password updated.";
        }
    } elseif (isset($_POST['update_address'])) {
        $province = $_POST['province'];
        $city = $_POST['city'];
        $barangay = $_POST['barangay'];
        $street = $_POST['street'];
        if ($userObj->updateAddress($user_id, $province, $city, $barangay, $street, 'default')) {
            $message = "Default shipping address updated.";
        }
    } elseif (isset($_POST['update_alt_address'])) {
        $alt_province = $_POST['alt_province'];
        $alt_city = $_POST['alt_city'];
        $alt_barangay = $_POST['alt_barangay'];
        $alt_street = $_POST['alt_street'];
        if ($userObj->updateAddress($user_id, $alt_province, $alt_city, $alt_barangay, $alt_street, 'alt')) {
            $message = "Alternate shipping address updated.";
        }
    }
}

$user = $userObj->getUserById($user_id);

if (!$user) {
    echo "User not found.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - The Rattan Co.</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="profile.css">
</head>
<body>
    <section class="checkout-section">
        <h2>Your Profile</h2>
        <?php if (isset($message)) echo "<p>$message</p>"; ?>

        <h3>Personal Information</h3>
        <form method="POST">
            <label for="username">Username:</label>
            <input type="text" value="<?php echo htmlspecialchars($user['username']); ?>" disabled>
            <label for="email">Email:</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            <button type="submit" name="update_personal">Update Personal Info</button>
        </form>

        <h3>Change Password</h3>
        <form method="POST">
            <label for="password">New Password:</label>
            <input type="password" name="password" required>
            <button type="submit" name="update_password">Update Password</button>
        </form>

        <h3>Default Shipping Address</h3>
        <form method="POST">
            <label for="province">Province:</label>
            <input type="text" name="province" value="<?php echo htmlspecialchars($user['default_province'] ?? ''); ?>">
            <label for="city">City:</label>
            <input type="text" name="city" value="<?php echo htmlspecialchars($user['default_city'] ?? ''); ?>">
            <label for="barangay">Barangay:</label>
            <input type="text" name="barangay" value="<?php echo htmlspecialchars($user['default_barangay'] ?? ''); ?>">
            <label for="street">Street:</label>
            <input type="text" name="street" value="<?php echo htmlspecialchars($user['default_street'] ?? ''); ?>">
            <button type="submit" name="update_address">Update Default Address</button>
        </form>

        <h3>Alternate Shipping Address</h3>
        <form method="POST">
            <label for="alt_province">Province:</label>
            <input type="text" name="alt_province" value="<?php echo htmlspecialchars($user['alt_province'] ?? ''); ?>">
            <label for="alt_city">City:</label>
            <input type="text" name="alt_city" value="<?php echo htmlspecialchars($user['alt_city'] ?? ''); ?>">
            <label for="alt_barangay">Barangay:</label>
            <input type="text" name="alt_barangay" value="<?php echo htmlspecialchars($user['alt_barangay'] ?? ''); ?>">
            <label for="alt_street">Street:</label>
            <input type="text" name="alt_street" value="<?php echo htmlspecialchars($user['alt_street'] ?? ''); ?>">
            <button type="submit" name="update_alt_address">Update Alternate Address</button>
        </form>

        <h3>Payment Method</h3>
        <p>Last used: <?php echo htmlspecialchars($user['last_payment'] ?? 'None'); ?></p>

        <a href="index.php">Back to Home</a>
    </section>
</body>
</html>