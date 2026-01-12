<?php
require 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header('Location: checkout.php');
        exit;
    } else {
        $error = "Invalid credentials.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - The Rattan Co.</title>
    <link rel="stylesheet" href="auth.css">
</head>
<body>
    <section class="login-section">
        <h2>Login</h2>
        <?php if (isset($error)) echo "<p>$error</p>"; ?>
        <form method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <div class="form-footer">
                <button type="button" onclick="window.location.href='index.php'" class="back-btn">Back to Home</button>
                <button type="submit">Login</button>
            </div>
        </form>
        <p class="auth-prompt">Don't have an account? <a href="register.php" class="register-link">Register</a></p>
    </section>
</body>
</html>