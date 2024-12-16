<?php
require 'server/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Data from form
    $nama_ketua = $_POST['nama_ketua'];
    $id_kewarganegaraan_ketua = $_POST['id_kewarganegaraan_ketua'];
    $jenis_kelamin_ketua = $_POST['jenis_kelamin_ketua'];
    $alamat_ketua = $_POST['alamat_ketua'];
    $no_tlp_ketua = $_POST['no_tlp_ketua'];
    $email_ketua = $_POST['email_ketua'];
    $nama_kontak_darurat = $_POST['nama_kontak_darurat'];
    $kontak_darurat = $_POST['kontak_darurat'];

    $anggota = $_POST['nama_anggota']; // Array of anggota names
    $id_kewarganegaraan_anggota = $_POST['id_kewarganegaraan_anggota']; // Array of kewarganegaraan ids
    $jenis_kelamin_anggota = $_POST['jenis_kelamin_anggota']; // Array of jenis kelamin
    $no_tlp_anggota = $_POST['no_tlp_anggota']; // Array of phone numbers

    // Insert Ketua Pendakian
    $query_ketua = "INSERT INTO ketua_pendakian (nama, id_kewarganegaraan, jenis_kelamin, alamat, no_tlp, email, nama_kontak_darurat, kontak_darurat)
                    VALUES ('$nama_ketua', '$id_kewarganegaraan_ketua', '$jenis_kelamin_ketua', '$alamat_ketua', '$no_tlp_ketua', '$email_ketua', '$nama_kontak_darurat', '$kontak_darurat')";
    mysqli_query($conn, $query_ketua);
    $id_ketua = mysqli_insert_id($conn); // Get the id of the inserted Ketua Pendakian

    // Insert Anggota Pendakian
    $anggota_count = count($anggota);
    for ($i = 0; $i < $anggota_count; $i++) {
        $nama_anggota = $anggota[$i];
        $id_kewarganegaraan = $id_kewarganegaraan_anggota[$i];
        $jenis_kelamin = $jenis_kelamin_anggota[$i];
        $no_tlp = $no_tlp_anggota[$i];
        $query_anggota = "INSERT INTO anggota (nama, id_kewarganegaraan, jenis_kelamin, no_tlp, id_ketua_pendakian)
                          VALUES ('$nama_anggota', '$id_kewarganegaraan', '$jenis_kelamin', '$no_tlp', '$id_ketua')";
        mysqli_query($conn, $query_anggota);
    }

    // Insert Booking and get noPesanan
    $jumlah_anggota = $anggota_count + 1;  // Including Ketua
    $total_pembayaran = $jumlah_anggota * 50000;  // Example cost per person

    $query_booking = "INSERT INTO booking (idJadwal, tgl_pendakian, jumlah_anggota, total_pembayaran)
                      VALUES ('$idjadwal', '" . $result['tanggal'] . "', '$jumlah_anggota', '$total_pembayaran')";
    mysqli_query($conn, $query_booking);
    $noPesanan = mysqli_insert_id($conn);  // Get the auto-generated booking number

    // Redirect to booking confirmation page
    header("Location: booking.php?noPesanan=$noPesanan");
    exit;
}

$idjadwal = $_GET['jadwalId'];
$query = "SELECT * FROM jadwal WHERE idJadwal = $idjadwal";
$result = mysqli_fetch_assoc(mysqli_query($conn, $query));

// Query for fetching kewarganegaraan data
$query_kewarganegaraan = "SELECT idKewarganegaraan, jenis FROM kewarganegaraan";
$result_kewarganegaraan = mysqli_query($conn, $query_kewarganegaraan);
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Form Registrasi</title>

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
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="index.php#service">Melayani</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="index.php#portfolio">Gunung</a>
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

    <!-- contact -->
    <section id="contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading text-uppercase">Form Registrasi Pendakian Gunung</h2>
                    <h3 class="section-subheading text-muted" style="color: #fff;">Silahkan Mengisi Semua Form untuk Registrasi Pendakian Gunung.</h3>

                    <form class="form-horizontal" action="booking.php" method="post">
                        <!-- Form Gunung Pilihan -->
                        <div class="form-group">
                            <div class="col-sm-9">
                                <label for="exampleFormControlSelect1" class="col-sm-3 col-form-label text-light left-0">Gunung Pilihan</label>
                                <select class="form-control" id="exampleFormControlSelect1" name="namagunung" disabled>
                                    <option value="<?= $_GET['namagunung'] ?>"><?= $_GET['namagunung'] ?></option>
                                </select>
                            </div>
                        </div>

                        <!-- Tanggal Pendakian -->
                        <div class="form-group">
                            <div class="col-sm-9">
                                <label for="nama" class="text-light">Tanggal</label>
                                <input type="date" class="form-control" name="tanggal" placeholder="Masukkan Tanggal Pendakian" value="<?= $result['tanggal'] ?>" disabled>
                            </div>
                        </div>

                        <!-- Form Ketua Pendakian -->
                        <center><label style="color: white;">Data Ketua Pendakian</label></center>
                        <hr style="background: white;">
                        <div class="form-group">
                            <label style="color: white;">Nama Ketua</label>
                            <input type="text" class="form-control" name="nama_ketua" placeholder="Nama Ketua Pendakian" required>
                        </div>

                        <div class="form-group">
                            <label style="color: white;">Kewarganegaraan</label>
                            <select class="form-control" name="id_kewarganegaraan_ketua" required>
                                <?php while ($row = mysqli_fetch_assoc($result_kewarganegaraan)) { ?>
                                    <option value="<?= $row['idKewarganegaraan'] ?>"><?= $row['jenis'] ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label style="color: white;">Jenis Kelamin</label>
                            <select class="form-control" name="jenis_kelamin_ketua" required>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label style="color: white;">Alamat</label>
                            <input type="text" class="form-control" name="alamat_ketua" placeholder="Alamat" required>
                        </div>

                        <div class="form-group">
                            <label style="color: white;">Nomor Telepon</label>
                            <input type="text" class="form-control" name="no_tlp_ketua" placeholder="Nomor Telepon" required>
                        </div>

                        <div class="form-group">
                            <label style="color: white;">Email</label>
                            <input type="email" class="form-control" name="email_ketua" placeholder="Email" required>
                        </div>

                        <div class="form-group">
                            <label style="color: white;">Nama Kontak Darurat</label>
                            <input type="text" class="form-control" name="nama_kontak_darurat" placeholder="Nama Kontak Darurat" required>
                        </div>

                        <div class="form-group">
                            <label style="color: white;">Kontak Darurat</label>
                            <input type="text" class="form-control" name="kontak_darurat" placeholder="Kontak Darurat" required>
                        </div>

                        <!-- Form Anggota -->
                        <center><label style="color: white;">Data Anggota</label></center>
                        <hr style="background: white;">
                        <div id="anggota-section">
                            <div class="anggota-form" id="anggota-1">
                                <label style="color: white;">Anggota 1</label>
                                <div class="form-group">
                                    <label style="color: white;">Nama Anggota</label>
                                    <input type="text" class="form-control" name="nama_anggota[]" placeholder="Nama Anggota">
                                </div>

                                <div class="form-group">
                                    <label style="color: white;">Kewarganegaraan</label>
                                    <select class="form-control" name="id_kewarganegaraan_anggota[]">
                                        <?php mysqli_data_seek($result_kewarganegaraan, 0); // Reset pointer
                                        while ($row = mysqli_fetch_assoc($result_kewarganegaraan)) { ?>
                                            <option value="<?= $row['idKewarganegaraan'] ?>"><?= $row['jenis'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label style="color: white;">Jenis Kelamin</label>
                                    <select class="form-control" name="jenis_kelamin_anggota[]">
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label style="color: white;">Nomor Telepon</label>
                                    <input type="text" class="form-control" name="no_tlp_anggota[]" placeholder="Nomor Telepon">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-offset-4 col-sm-10">
                            <button type="button" class="btn btn-warning" onclick="addAnggota()">Tambah Anggota</button>
                        </div>

                        <div class="col-sm-offset-4 col-sm-10">
                            <button type="submit" class="btn btn-warning">Booking</button>
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

    <script>
        let anggotaCount = 1;

        function addAnggota() {
            anggotaCount++;
            const anggotaSection = document.getElementById('anggota-section');
            const newAnggota = document.createElement('div');
            newAnggota.classList.add('anggota-form');
            newAnggota.setAttribute('id', 'anggota-' + anggotaCount);
            newAnggota.innerHTML = `
                <label style="color: white;">Anggota ${anggotaCount}</label>
                <div class="form-group">
                    <label style="color: white;">Nama Anggota</label>
                    <input type="text" class="form-control" name="nama_anggota[]" placeholder="Nama Anggota">
                </div>
                <div class="form-group">
                    <label style="color: white;">Kewarganegaraan</label>
                    <select class="form-control" name="id_kewarganegaraan_anggota[]">
                        <?php mysqli_data_seek($result_kewarganegaraan, 0); // Reset pointer
                        while ($row = mysqli_fetch_assoc($result_kewarganegaraan)) { ?>
                            <option value="<?= $row['idKewarganegaraan'] ?>"><?= $row['jenis'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label style="color: white;">Jenis Kelamin</label>
                    <select class="form-control" name="jenis_kelamin_anggota[]">
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label style="color: white;">Nomor Telepon</label>
                    <input type="text" class="form-control" name="no_tlp_anggota[]" placeholder="Nomor Telepon">
                </div>
            `;
            anggotaSection.appendChild(newAnggota);
        }
    </script>

</body>

</html>
