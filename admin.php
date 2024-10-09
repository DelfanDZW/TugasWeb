<?php
session_start();
require 'db.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_bis = $_POST['nama_bis'];
    $harga_tiket = $_POST['harga_tiket'];
    $lokasi_jemput = $_POST['lokasi_jemput'];
    $destinasi = $_POST['destinasi'];

    $stmt = $pdo->prepare("INSERT INTO bis (nama_bis, harga_tiket) VALUES (?, ?)");
    $stmt->execute([$nama_bis, $harga_tiket]);

    echo "Data bus berhasil ditambahkan!";
}
?>

<h2>Tambah Data Bus</h2>
<form method="POST" action="admin.php">
    <label>Nama Bis:</label>
    <input type="text" name="nama_bis" required><br>

    <label>Harga Tiket:</label>
    <input type="number" name="harga_tiket" step="0.01" required><br>

    <label>Tempat Penjemputan (Pisahkan dengan koma):</label>
    <input type="text" name="lokasi_jemput" required><br>

    <label>Tempat Tujuan (Pisahkan dengan koma):</label>
    <input type="text" name="destinasi" required><br>

    <button type="submit">Tambah Bis</button>
</form>

<a href="admin_logout.php">Logout Admin</a>
