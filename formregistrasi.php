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
    <meta charset="UTF-8">
    <title>Form Registrasi Pendakian</title>
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
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
        <h4>Data Ketua Pendakian</h4>
        <div class="form-group">
            <label>Nama</label>
            <input type="text" name="nama_ketua" class="form-control" required>
        </div>
        <div class="form-group">
            <label>No Identitas</label>
            <input type="text" name="no_identitas_ketua" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Kewarganegaraan</label>
            <select name="kewarganegaraan_ketua" class="form-control">
                <?php foreach ($kewarganegaraanList as $kw) { ?>
                    <option value="<?php echo $kw['idKewarganegaraan']; ?>">
                        <?php echo $kw['jenis']; ?> (Rp <?php echo $kw['harga']; ?>)
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <label>Jenis Kelamin</label>
            <select name="jenis_kelamin_ketua" class="form-control" required>
                <option value="Laki-laki">Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
            </select>
        </div>
        <div class="form-group">
            <label>Alamat</label>
            <textarea name="alamat_ketua" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <label>No Telepon</label>
            <input type="text" name="no_tlp_ketua" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email_ketua" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Nama Kontak Darurat</label>
            <input type="text" name="nama_kontak_darurat" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Kontak Darurat</label>
            <input type="text" name="kontak_darurat" class="form-control" required>
        </div>

        <!-- Data Anggota -->
        <h4>Data Anggota</h4>
        <div id="anggota-section">
            <div class="anggota-group">
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="nama_anggota[]" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>No Identitas</label>
                    <input type="text" name="no_identitas_anggota[]" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Kewarganegaraan</label>
                    <select name="kewarganegaraan_anggota[]" class="form-control" required>
                        <?php foreach ($kewarganegaraanList as $kw) { ?>
                            <option value="<?php echo $kw['idKewarganegaraan']; ?>">
                                <?php echo $kw['jenis']; ?> (Rp <?php echo $kw['harga']; ?>)
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Jenis Kelamin</label>
                    <select name="jenis_kelamin_anggota[]" class="form-control" required>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>No Telepon</label>
                    <input type="text" name="no_tlp_anggota[]" class="form-control" required>
                </div>
            </div>
        </div>
        <button type="button" id="add-anggota" class="btn btn-info mb-3">Tambah Anggota</button>
        <br>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
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
