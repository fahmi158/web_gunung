<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pendakian";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data dari form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Data ketua
    $namaKetua = $_POST['nama_ketua'];
    $idKewarganegaraanKetua = $_POST['id_kewarganegaraan'];
    $noIdentitasKetua = $_POST['no_identitas'];
    $jenisKelaminKetua = $_POST['jenis_kelamin'];
    $alamatKetua = $_POST['alamat'];
    $noTlpKetua = $_POST['no_tlp'];
    $emailKetua = $_POST['email'];
    $namaKontakDaruratKetua = $_POST['nama_kontak_darurat'];
    $kontakDaruratKetua = $_POST['kontak_darurat'];

    // Data anggota
    $namaAnggota = $_POST['nama_anggota'];
    $idKewarganegaraanAnggota = $_POST['id_kewarganegaraan_anggota'];
    $noTlpAnggota = $_POST['no_tlp_anggota'];

    // Data lainnya
    $tanggalMendaki = $_POST['tanggal_mendaki'];
    $tanggalTurun = $_POST['tanggal_turun'];
    $idJadwal = $_POST['idJadwal'];

    // Cek jika tanggal dan idJadwal ada
    if (empty($tanggalMendaki) || empty($idJadwal)) {
        die('Tanggal dan ID Jadwal harus diisi');
    }

    // Hitung jumlah anggota
    $jumlahAnggota = count($namaAnggota) + 1; // Ketua + anggota

    // Hitung total pembayaran (harga berdasarkan kewarganegaraan)
    $totalPembayaran = 0;

    // Hitung biaya untuk ketua
    $queryKetua = "SELECT harga FROM kewarganegaraan WHERE idKewarganegaraan = '$idKewarganegaraanKetua'";
    $resultKetua = $conn->query($queryKetua);
    if ($resultKetua->num_rows > 0) {
        $rowKetua = $resultKetua->fetch_assoc();
        $totalPembayaran += $rowKetua['harga'];
    }

    // Hitung biaya untuk anggota
    foreach ($idKewarganegaraanAnggota as $idKewarganegaraan) {
        $queryAnggota = "SELECT harga FROM kewarganegaraan WHERE idKewarganegaraan = '$idKewarganegaraan'";
        $resultAnggota = $conn->query($queryAnggota);
        if ($resultAnggota->num_rows > 0) {
            $rowAnggota = $resultAnggota->fetch_assoc();
            $totalPembayaran += $rowAnggota['harga'];
        }
    }

    // Insert data ke tabel booking
    $sql = "INSERT INTO booking (idKetua, idJadwal, tgl_pendakian, jumlah_anggota, total_pembayaran) 
            VALUES ('$idKetua', '$idJadwal', '$tanggalMendaki', '$jumlahAnggota', '$totalPembayaran')";

    if ($conn->query($sql) === TRUE) {
        $noPesanan = $conn->insert_id; // Mendapatkan ID pesanan terakhir

        // Insert anggota data
        foreach ($namaAnggota as $index => $anggota) {
            $queryAnggota = "INSERT INTO anggota (idKetua, nama, idKewarganegaraan, no_tlp) 
                             VALUES ('$idKetua', '$anggota', '{$idKewarganegaraanAnggota[$index]}', '{$noTlpAnggota[$index]}')";
            $conn->query($queryAnggota);
        }

        // Ambil data untuk ditampilkan kembali
        $query = "SELECT * FROM booking WHERE noPesanan = $noPesanan";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
        } else {
            echo "Tidak ada data ditemukan.";
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!-- Tampilkan konfirmasi -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proses Booking</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Konfirmasi Booking</h2>

        <?php if (isset($data)): ?>
            <table class="table table-bordered">
                <tr>
                    <th>No Pesanan</th>
                    <td><?= $data['noPesanan']; ?></td>
                </tr>
                <tr>
                    <th>ID Ketua</th>
                    <td><?= $data['idKetua']; ?></td>
                </tr>
                <tr>
                    <th>ID Jadwal</th>
                    <td><?= $data['idJadwal']; ?></td>
                </tr>
                <tr>
                    <th>Tanggal Pendakian</th>
                    <td><?= $data['tgl_pendakian']; ?></td>
                </tr>
                <tr>
                    <th>Jumlah Anggota</th>
                    <td><?= $data['jumlah_anggota']; ?></td>
                </tr>
                <tr>
                    <th>Total Pembayaran</th>
                    <td>Rp <?= number_format($data['total_pembayaran'], 2, ',', '.'); ?></td>
                </tr>
            </table>
            <div class="text-center">
                <a href="pembayaran.php?noPesanan=<?= $data['noPesanan']; ?>" class="btn btn-primary">Lanjutkan ke Pembayaran</a>
            </div>
        <?php else: ?>
            <p class="text-danger text-center">Terjadi kesalahan dalam proses booking.</p>
        <?php endif; ?>

    </div>
</body>
</html>
