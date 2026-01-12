<?php
require 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    if ($stmt->execute([$username, $email, $password])) {
        $_SESSION['user_id'] = $pdo->lastInsertId();
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