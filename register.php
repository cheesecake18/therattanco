<?php
require_once 'classes/User.php';
session_start();

$userObj = new User();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $userId = $userObj->register($username, $email, $password);
    if ($userId) {
        $_SESSION['user_id'] = $userId;
        $_SESSION['username'] = $username;
        header('Location: checkout.php');
        exit;
    } else {
        $error = "Registration failed.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - The Rattan Co.</title>
    <link rel="stylesheet" href="auth.css">
</head>
<body>
    <section class="register-section">
        <h2>Create Account</h2>
        <?php if (isset($error)) echo "<p>$error</p>"; ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <div class="form-footer">
                <button type="button" onclick="window.location.href='index.php'" class="back-btn">Back to Home</button>
                <button type="submit">Register</button>
            </div>
        </form>
        <p class="auth-prompt">Already have an account? <a href="login.php" class="login-link">Login</a></p>
    </section>
</body>
</html>