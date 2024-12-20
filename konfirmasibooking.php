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
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>

    <!-- Custom styles for this template -->
    <link href="css/agency1.css" rel="stylesheet">
    <title>Konfirmasi Booking</title>
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
        <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="#page-top"><img src="img/logoyellow.png" width="150px"></a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          Menu
          <i class="fa fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav text-uppercase ml-auto">
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="index.php#service">Melayani</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="index.php">Gunung</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="index.php#about">Registrasi</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#">Persyaratan</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="index.php#team">Team</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="index.php#contact">Hubungi</a>
            </li>
          </ul>
        </div>
        </div>
    </nav>

    <section id="contact">
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
    </section >

<footer>
      <div class="container">
        <div class="row">
          <div class="col-md-4">
            <span class="copyright">Copyright &copy; Mountain 2024</span>
          </div>
          <div class="col-md-4">
            <ul class="list-inline social-buttons">
              <li class="list-inline-item">
                <a href="#">
                  <i class="fa fa-twitter"></i>
                </a>
              </li>
              <li class="list-inline-item">
                <a href="#">
                  <i class="fa fa-facebook"></i>
                </a>
              </li>
              <li class="list-inline-item">
                <a href="#">
                  <i class="fa fa-instagram"></i>
                </a>
              </li>
            </ul>
          </div>
          <div class="col-md-4">
            <ul class="list-inline quicklinks">
              <li class="list-inline-item">
                <a href="#">Privacy Policy</a>
              </li>
              <li class="list-inline-item">
                <a href="#">Terms of Use</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </footer>

</body>
</html>
