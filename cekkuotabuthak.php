<?php
require 'server/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $gunung = $_POST['gunung'];
    $tanggal_naik = $_POST['tanggal_naik'];
    $jumlah_pendaki = (int)$_POST['jumlah'];

    // Query untuk mendapatkan data kuota
    $query = "SELECT idJadwal, namaGunung, tanggal, kuota FROM jadwal WHERE namaGunung = ? AND tanggal = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ss', $gunung, $tanggal_naik);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        $kuota_tersedia = $data['kuota'];

        if ($jumlah_pendaki <= $kuota_tersedia) {
            $pesan = "Kuota tersedia: " . ($kuota_tersedia - $jumlah_pendaki) . " orang.";
        } else {
            $pesan = "Kuota tidak mencukupi. Kuota tersisa: " . $kuota_tersedia . " orang.";
        }
    } else {
        $pesan = "Tidak ada data jadwal untuk tanggal dan gunung yang dipilih.";
    }

    $stmt->close();
    $conn->close();
} else {
    $pesan = "Harap isi form terlebih dahulu.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Cek Kuota</title>
    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom fonts for this template -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Kaushan+Script" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css">
    <!-- Custom styles for this template -->
    <link href="css/agency1.css" rel="stylesheet">
</head>

<body id="page-top">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand js-scroll-trigger" href="#page-top"><img src="img/logoyellow.png" width="150px"></a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                Menu
                <i class="fa fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav text-uppercase ml-auto">
                    <li class="nav-item"><a class="nav-link js-scroll-trigger" href="index.php#service">Melayani</a></li>
                    <li class="nav-item"><a class="nav-link js-scroll-trigger" href="index.php#portfolio">Gunung</a></li>
                    <li class="nav-item"><a class="nav-link js-scroll-trigger" href="index.php#about">Registrasi</a></li>
                    <li class="nav-item"><a class="nav-link js-scroll-trigger" href="#">Persyaratan</a></li>
                    <li class="nav-item"><a class="nav-link js-scroll-trigger" href="index.php#team">Team</a></li>
                    <li class="nav-item"><a class="nav-link js-scroll-trigger" href="index.php#contact">Hubungi</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contact -->
    <section id="contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading text-uppercase">Cek Kuota Pendakian</h2>
                    <h3 class="section-subheading text-muted" style="color: #fff;">
                        <?php if (isset($pesan)) echo $pesan; ?>
                    </h3>
                </div>
            </div>
            <br />

            <!-- Form for checking mountain quota -->
            <form action="" method="POST" class="form-horizontal" style="color: white;">
                <div class="form-group">
                    <label for="gunung">Pilih Gunung</label>
                    <select class="form-control" id="gunung" name="gunung" required>
                        <option value="Gunung Butak">Gunung Butak</option>
                        <option value="Gunung Panderman">Gunung Panderman</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="jumlah">Jumlah Pendaki</label>
                    <input type="number" class="form-control" id="jumlah" name="jumlah" min="1" placeholder="Masukkan jumlah pendaki" required>
                </div>

                <div class="form-group">
                    <label for="tanggal_naik">Tanggal Naik</label>
                    <input type="date" class="form-control" id="tanggal_naik" name="tanggal_naik" required>
                </div>

                <div class="form-group">
                    <label for="tanggal_turun">Tanggal Turun</label>
                    <input type="date" class="form-control" id="tanggal_turun" name="tanggal_turun" required>
                </div>

                <button type="submit" class="btn btn-primary">Cek Kuota</button>
            </form>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <span class="copyright">Copyright &copy; Mountain 2024</span>
                </div>
                <div class="col-md-4">
                    <ul class="list-inline social-buttons">
                        <li class="list-inline-item">
                            <a href="#"><i class="fa fa-twitter"></i></a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#"><i class="fa fa-instagram"></i></a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <ul class="list-inline quicklinks">
                        <li class="list-inline-item"><a href="#">Privacy Policy</a></li>
                        <li class="list-inline-item"><a href="#">Terms of Use</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Plugin JavaScript -->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Contact form JavaScript -->
    <script src="js/jqBootstrapValidation.js"></script>
    <script src="js/contact_me.js"></script>
    <!-- Custom scripts for this template -->
    <script src="js/agency.min.js"></script>

</body>

</html>
