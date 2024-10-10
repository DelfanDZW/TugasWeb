<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO pengguna (username, password) VALUES (?, ?)");
    $stmt->execute([$username, $password]);

    echo "Registrasi berhasil! Silakan <a href='login.php'>login</a>.";
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="login.css">
</head>
<body>
    <div class="container">
        <h2>Registrasi</h2>
        <form method="POST" action="register.php">
            <label>Username:</label>
            <input type="text" name="username" required><br>

            <label>Password:</label>
            <input type="password" name="password" required><br>

            <button type="submit">Register</button>
        </form>
</div>
</body>
</html>