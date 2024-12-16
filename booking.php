<?php
require 'server/config.php';

// Check if 'noPesanan' is passed in the URL
if (isset($_GET['noPesanan'])) {
    $noPesanan = $_GET['noPesanan'];  // Get 'noPesanan' from the query string

    // Query to fetch booking details
    $query = "SELECT * FROM booking WHERE noPesanan = $noPesanan";
    $result = mysqli_query($conn, $query); // Execute query

    // Check if query returns a result
    if ($result && mysqli_num_rows($result) > 0) {
        $booking = mysqli_fetch_assoc($result);

        // Query to fetch schedule details
        $query_jadwal = "SELECT * FROM jadwal WHERE idJadwal = " . $booking['idJadwal'];
        $jadwal = mysqli_fetch_assoc(mysqli_query($conn, $query_jadwal));
    } else {
        // If no booking found
        die('No booking found for this number.');
    }
} else {
    // If no 'noPesanan' is passed
    die('No booking number provided.');
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Include necessary meta tags and styles -->
</head>

<body>
    <!-- Your navigation and other page content here -->
    <section id="contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading text-uppercase">Booking Confirmation</h2>
                    <form class="form-horizontal" action="?" method="post">
                        <div class="form-group">
                            <div class="col-sm-9">
                                <label for="noPesanan" class="text-light">Nomor Pesanan</label>
                                <input type="text" class="form-control" name="noPesanan" value="<?= $booking['noPesanan'] ?>" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-9">
                                <label for="namagunung" class="text-light">Gunung Pilihan</label>
                                <input type="text" class="form-control" name="namagunung" value="<?= $jadwal['namaGunung'] ?>" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-9">
                                <label for="tgl_pendakian" class="text-light">Tanggal Pendakian</label>
                                <input type="date" class="form-control" name="tanggal" value="<?= $booking['tgl_pendakian'] ?>" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-9">
                                <label for="jumlah_anggota" class="text-light">Jumlah Anggota</label>
                                <input type="text" class="form-control" name="jumlah_anggota" value="<?= $booking['jumlah_anggota'] ?>" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-9">
                                <label for="total_pembayaran" class="text-light">Total Pembayaran</label>
                                <input type="text" class="form-control" name="total_pembayaran" value="<?= $booking['total_pembayaran'] ?>" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-9">
                                <button type="submit" class="btn btn-warning">Konfirmasi Booking</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
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

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>
