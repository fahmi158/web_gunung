<?php
require 'server/config.php';

// Ambil noPesanan dari parameter GET
$noPesanan = $_GET['bookingId'] ?? null;
if (!$noPesanan || !is_numeric($noPesanan)) {
    die("<div class='alert alert-danger'>No Pesanan tidak valid.</div>");
}

// Query untuk mengambil informasi booking
$sql = "SELECT tgl_pendakian, jumlah_anggota, total_pembayaran 
        FROM booking 
        WHERE noPesanan = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("<div class='alert alert-danger'>Error prepare: " . $conn->error . "</div>");
}

// Bind parameter dan eksekusi query
$stmt->bind_param('i', $noPesanan);
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    die("<div class='alert alert-danger'>Error result: " . $stmt->error . "</div>");
}

if ($result->num_rows > 0) {
    $booking = $result->fetch_assoc();
} else {
    echo "<div class='alert alert-danger'>Data booking tidak ditemukan.</div>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Booking</title>
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h2 class="mt-5">Konfirmasi Booking</h2>
    <div class="card">
        <div class="card-body">
            <h5>Detail Booking</h5>
            <p><strong>Tanggal Pendakian:</strong> <?php echo htmlspecialchars($booking['tgl_pendakian']); ?></p>
            <p><strong>Jumlah Anggota:</strong> <?php echo htmlspecialchars($booking['jumlah_anggota']); ?></p>
            <p><strong>Total Pembayaran:</strong> Rp <?php echo number_format($booking['total_pembayaran'], 0, ',', '.'); ?></p>
            <a href="payment.php?bookingId=<?php echo urlencode($noPesanan); ?>" class="btn btn-primary">Lanjutkan ke Pembayaran</a>
        </div>
    </div>
</div>
</body>
</html>
