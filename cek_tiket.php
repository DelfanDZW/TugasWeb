<?php
session_start();
require 'db.php'; // Pastikan file ini ada dan diakses

// Pastikan pengguna sudah login
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$username = $_SESSION['username'];

try {
    $query = "SELECT orders.banyak_tiket, bis.nama_bis, bis.destination, bis.pickup_location 
              FROM orders 
              JOIN bis ON orders.bus_id = bis.id 
              WHERE orders.username = :username";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    
    // Tampilkan daftar tiket yang dipesan
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
                <td><?php echo htmlspecialchars($row['bus_name']); ?></td>
                <td><?php echo htmlspecialchars($row['destination']); ?></td>
                <td><?php echo htmlspecialchars($row['pickup_location']); ?></td>
                <td><?php echo htmlspecialchars($row['ticket_quantity']); ?></td>
                <td><?php echo htmlspecialchars($row['booking_date']); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <p>Tidak ada tiket yang dipesan.</p>
<?php endif; ?>

<a href="logout.php">Logout</a>
