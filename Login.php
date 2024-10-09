<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $pdo->prepare("SELECT * FROM pengguna WHERE username = ?");
    $stmt->execute([$username]);

    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username'];
            header('Location: booking.php');
            exit();
        } else {
            echo "Username atau password salah!".$username;
        }
    } else {
        echo "Username tidak ada!";
    }
}
?>

<form method="POST" action="login.php">
    <label>Username:</label>
    <input type="text" name="username" required><br>
    <label>Password:</label>
    <input type="password" name="password" required><br>
    <button type="submit">Login</button>
</form>
<p>Belum punya akun? <a href="register.php">Register di sini</a></p>
<p><a href="admin_login.php">Admin Only</a></p>
