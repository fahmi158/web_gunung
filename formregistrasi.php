<?php 
require 'server/config.php';

// Ambil data kewarganegaraan untuk dropdown
$kewarganegaraanQuery = "SELECT `idKewarganegaraan`, `jenis`, `harga` FROM `kewarganegaraan`";
$kewarganegaraanResult = $conn->query($kewarganegaraanQuery);
$kewarganegaraanList = mysqli_fetch_all($kewarganegaraanResult, MYSQLI_ASSOC);

// Handle form submission
$bookingId = null;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Data jadwal
    $idJadwal = $_POST['idJadwal'];
    $tglPendakian = $_POST['tanggal'];

    // Data ketua pendakian
    $idKewarganegaraanKetua = $_POST['kewarganegaraan_ketua'];
    $noIdentitas = $_POST['no_identitas_ketua'];
    $namaKetua = $_POST['nama_ketua'];
    $jenisKelaminKetua = $_POST['jenis_kelamin_ketua'];
    $alamatKetua = $_POST['alamat_ketua'];
    $noTlpKetua = $_POST['no_tlp_ketua'];
    $emailKetua = $_POST['email_ketua'];
    $namaKontakDarurat = $_POST['nama_kontak_darurat'];
    $kontakDarurat = $_POST['kontak_darurat'];

    // Insert ketua pendakian
    $sqlKetua = "INSERT INTO `ketua_pendakian` (`idKewarganegaraan`, `noIdentitas`, `nama`, `jenisKelamin`, `Alamat`, `no_tlp`, `email`, `nama_kontak_darurat`, `kontak_darurat`) 
                 VALUES ('$idKewarganegaraanKetua', '$noIdentitas', '$namaKetua', '$jenisKelaminKetua', '$alamatKetua', '$noTlpKetua', '$emailKetua', '$namaKontakDarurat', '$kontakDarurat')";
    $conn->query($sqlKetua);
    $idKetua = $conn->insert_id;

    // Data anggota
    $anggotaCount = count($_POST['nama_anggota']);
    $totalPembayaran = 0;

    for ($i = 0; $i < $anggotaCount; $i++) {
        $namaAnggota = $_POST['nama_anggota'][$i];
        $idKewarganegaraanAnggota = $_POST['kewarganegaraan_anggota'][$i];
        $jenisKelaminAnggota = $_POST['jenis_kelamin_anggota'][$i];
        $noTlpAnggota = $_POST['no_tlp_anggota'][$i];
        
        // Insert anggota
        $sqlAnggota = "INSERT INTO `anggota` (`idKetua`, `idKewarganegaraan`, `nama`, `jenisKelamin`, `no_tlp`) 
                       VALUES ('$idKetua', '$idKewarganegaraanAnggota', '$namaAnggota', '$jenisKelaminAnggota', '$noTlpAnggota')";
        $conn->query($sqlAnggota);
    }

    // Jumlah anggota + ketua
    $jumlahAnggota = $anggotaCount + 1;
    
    // Total pembayaran
    foreach ($_POST['kewarganegaraan_anggota'] as $idKewarganegaraan) {
        $hargaQuery = "SELECT `harga` FROM `kewarganegaraan` WHERE `idKewarganegaraan` = '$idKewarganegaraan'";
        $hargaResult = $conn->query($hargaQuery);
        $harga = $hargaResult->fetch_assoc()['harga'];
        $totalPembayaran += $harga;
    }
    
    // Harga untuk ketua
    $hargaKetuaQuery = "SELECT `harga` FROM `kewarganegaraan` WHERE `idKewarganegaraan` = '$idKewarganegaraanKetua'";
    $hargaKetuaResult = $conn->query($hargaKetuaQuery);
    $totalPembayaran += $hargaKetuaResult->fetch_assoc()['harga'];

    // Insert booking
    $sqlBooking = "INSERT INTO `booking` (`idKetua`, `idJadwal`, `tgl_pendakian`, `jumlah_anggota`, `total_pembayaran`) 
                   VALUES ('$idKetua', '$idJadwal', '$tglPendakian', '$jumlahAnggota', '$totalPembayaran')";
    $conn->query($sqlBooking);
    $bookingId = $conn->insert_id; // Get the booking ID
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
    <title>Form Registrasi Pendakian</title>
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
    <h2 class="mt-5">Form Registrasi Pendakian</h2>
    <?php if ($bookingId): ?>
        <div class="alert alert-success">
            Registrasi berhasil! <br>
            <a href="konfirmasibooking.php?bookingId=<?php echo $bookingId; ?>" class="btn btn-success">Konfirmasi Booking</a>
        </div>
    <?php else: ?>
        <form action="" method="post">
        <form action="" method="post">
        <input type="hidden" name="idJadwal" value="<?php echo $_GET['jadwalId']; ?>">
        <input type="hidden" name="tanggal" value="<?php echo $_GET['tanggal_mendaki']; ?>">

        <!-- Data Ketua Pendakian -->
        <h4 style="color: white;">Data Ketua Pendakian</h4>
        <div class="form-group">
            <label style="color: white;">Nama</label>
            <input type="text" name="nama_ketua" class="form-control" required>
        </div>
        <div class="form-group">
            <label style="color: white;">No Identitas</label>
            <input type="text" name="no_identitas_ketua" class="form-control" required>
        </div>
        <div class="form-group">
            <label style="color: white;">Kewarganegaraan</label>
            <select name="kewarganegaraan_ketua" class="form-control">
                <?php foreach ($kewarganegaraanList as $kw) { ?>
                    <option value="<?php echo $kw['idKewarganegaraan']; ?>">
                        <?php echo $kw['jenis']; ?> (Rp <?php echo $kw['harga']; ?>)
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <label style="color: white;">Jenis Kelamin</label>
            <select name="jenis_kelamin_ketua" class="form-control" required>
                <option value="Laki-laki">Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
            </select>
        </div>
        <div class="form-group">
            <label style="color: white;">Alamat</label>
            <textarea name="alamat_ketua" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <label style="color: white;">No Telepon</label>
            <input type="text" name="no_tlp_ketua" class="form-control" required>
        </div>
        <div class="form-group">
            <label style="color: white;">Email</label>
            <input type="email" name="email_ketua" class="form-control" required>
        </div>
        <div class="form-group">
            <label style="color: white;">Nama Kontak Darurat</label>
            <input type="text" name="nama_kontak_darurat" class="form-control" required>
        </div>
        <div class="form-group">
            <label style="color: white;">Kontak Darurat</label>
            <input type="text" name="kontak_darurat" class="form-control" required>
        </div>

        <!-- Data Anggota -->
        <h4 style="color: white;">Data Anggota</h4>
        <div id="anggota-section">
            <div class="anggota-group">
                <div class="form-group">
                    <label style="color: white;">Nama</label>
                    <input type="text" name="nama_anggota[]" class="form-control" required>
                </div>
                <div class="form-group">
                    <label style="color: white;">No Identitas</label>
                    <input type="text" name="no_identitas_anggota[]" class="form-control" required>
                </div>
                <div class="form-group">
                    <label style="color: white;">Kewarganegaraan</label>
                    <select name="kewarganegaraan_anggota[]" class="form-control" required>
                        <?php foreach ($kewarganegaraanList as $kw) { ?>
                            <option value="<?php echo $kw['idKewarganegaraan']; ?>">
                                <?php echo $kw['jenis']; ?> (Rp <?php echo $kw['harga']; ?>)
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label style="color: white;">Jenis Kelamin</label>
                    <select name="jenis_kelamin_anggota[]" class="form-control" required>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label style="color: white;">No Telepon</label>
                    <input type="text" name="no_tlp_anggota[]" class="form-control" required>
                </div>
            </div>
        </div>
        <button type="button" id="add-anggota" class="btn btn-info mb-3">Tambah Anggota</button>
        <br>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</section>
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
</div>

<script>
    document.getElementById('add-anggota').addEventListener('click', function () {
        let anggotaSection = document.getElementById('anggota-section');
        let newAnggota = document.querySelector('.anggota-group').cloneNode(true);
        // Clear inputs in the cloned form
        newAnggota.querySelectorAll('input').forEach(input => input.value = '');
        anggotaSection.appendChild(newAnggota);
    });
</script>
        </form>
    <?php endif; ?>
</div>
</body>
</html>
