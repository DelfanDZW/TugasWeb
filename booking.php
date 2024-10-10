<?php
session_start();
require 'db.php';

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$stmt = $pdo->query("SELECT * FROM bis");
$bis = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_bis = $_POST['nama_bis'];
    $lokasi_jemput = $_POST['lokasi_jemput'];
    $destinasi = $_POST['destinasi'];
    $banyak_tiket = $_POST['banyak_tiket'];

    $stmt = $pdo->prepare("SELECT harga_tiket,id FROM bis WHERE nama_bis = ?");
    $stmt->execute([$nama_bis]);
    $bus = $stmt->fetch();

    $total_harga = $bus['harga_tiket'] * $banyak_tiket;

    $stmt = $pdo->prepare("SELECT * FROM pengguna WHERE username = ?");
    $stmt->execute([$_SESSION['username']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt = $pdo->prepare("INSERT INTO orders (user_id, bus_id, lokasi_jemput, destinasi, banyak_tiket, total_harga) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute ([$user['id'], $bus['id'], $lokasi_jemput, $destinasi, $banyak_tiket, $total_harga]);

    echo "<script>alert('Pemesanan Berhasil!');</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pemesanan Tiket</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Pemesanan Tiket</h2>
        <form method="POST" action="booking.php">
            <label>Pilih Bis:</label>
            <select name="nama_bis" required>
                <?php foreach ($bis as $bus): ?>
                    <option value="<?= $bus['nama_bis'] ?>"><?= $bus['nama_bis'] ?> (Rp.<?= $bus['harga_tiket'] ?>)</option>
                <?php endforeach; ?>
            </select>

            <label>Tempat Penjemputan:</label>
            <input type="text" name="lokasi_jemput" required>

            <label>Tempat Tujuan:</label>
            <input type="text" name="destinasi" required>

            <label>Jumlah Tiket:</label>
            <input type="number" name="banyak_tiket" required>

            <button type="submit">Pesan</button>
        </form>

        <p>Cek Tiket Kamu <a href="cek_tiket.php">Cek Tiket</a></p>

        <a href="logout.php">Logout</a>
    </div>
</body>
</html>