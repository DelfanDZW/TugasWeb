<?php
session_start();
require 'db.php'; 

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$username = $_SESSION['username'];

try {
    $stmt = $pdo->prepare("SELECT * FROM pengguna WHERE username = ?");
    $stmt->execute([$_SESSION['username']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $query = "SELECT orders.banyak_tiket, bis.nama_bis, orders.destinasi, orders.lokasi_jemput, pengguna.username
              FROM orders 
              JOIN bis ON orders.bus_id = bis.id 
              JOIN pengguna ON orders.user_id = pengguna.id
              WHERE pengguna.id = ?";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute([$user['id']]);
    
    $tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}
?>

<h2>Tiket yang Dipesan</h2>

<?php if (count($tickets) > 0): ?>
    <table>
        <tr>
            <th>Nama Bus</th>
            <th>Tujuan</th>
            <th>Tempat Penjemputan</th>
            <th>Jumlah Tiket</th>
            <th>Tanggal Pemesanan</th>
        </tr>
        <?php foreach ($tickets as $row): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['nama_bis']); ?></td>
                <td><?php echo htmlspecialchars($row['destinasi']); ?></td>
                <td><?php echo htmlspecialchars($row['lokasi_jemput']); ?></td>
                <td><?php echo htmlspecialchars($row['banyak_tiket']); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <p>Tidak ada tiket yang dipesan.</p>
<?php endif; ?>

<a href="logout.php">Logout</a>
