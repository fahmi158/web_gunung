<?php
require 'server/config.php';

// Ambil noPesanan dari parameter GET
$noPesanan = $_GET['bookingId'] ?? null;
if (!$noPesanan || !is_numeric($noPesanan)) {
    die("<div class='alert alert-danger text-center'>No Pesanan tidak valid.</div>");
}

// Ambil informasi total pembayaran dari tabel booking
$sql = "SELECT total_pembayaran 
        FROM booking 
        WHERE noPesanan = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("<div class='alert alert-danger text-center'>Error prepare: " . $conn->error . "</div>");
}

// Bind parameter dan eksekusi query
$stmt->bind_param('i', $noPesanan);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $booking = $result->fetch_assoc();
} else {
    die("<div class='alert alert-danger text-center'>Data booking tidak ditemukan.</div>");
}

// Proses jika metode pembayaran dipilih
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['metode_pembayaran'])) {
    $metodePembayaran = $_POST['metode_pembayaran'];

    // Tanggal pembayaran sesuai hari ini
    $tglPembayaran = date('Y-m-d');

    // Simpan data pembayaran ke dalam tabel pembayaran
    $insertSql = "INSERT INTO pembayaran (noPesanan, tgl_pembayaran, metode_pembayaran) 
                  VALUES (?, ?, ?)";
    $insertStmt = $conn->prepare($insertSql);

    if (!$insertStmt) {
        die("<div class='alert alert-danger text-center'>Error prepare insert: " . $conn->error . "</div>");
    }

    $insertStmt->bind_param('iss', $noPesanan, $tglPembayaran, $metodePembayaran);
    $insertStmt->execute();

    // Pesan konfirmasi berdasarkan metode pembayaran
    if ($metodePembayaran === 'transfer') {
        echo "<div class='alert alert-info text-center' style='padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);'>
                <p>Silakan transfer sesuai nominal yang tertera ke Bank BCA dengan nomor rekening <strong>186754326</strong>.</p>
                <h5>Unggah Bukti Pembayaran</h5>
                <form action='' method='post' enctype='multipart/form-data'>
                    <div class='form-group'>
                        <label for='bukti_pembayaran' class='font-weight-bold'>Unggah Bukti Pembayaran (Format: JPG, PNG):</label>
                        <input type='file' class='form-control' id='bukti_pembayaran' name='bukti_pembayaran' accept='image/*' required>
                    </div>
                    <button type='submit' class='btn btn-primary mt-3' style='font-size: 18px; padding: 10px 20px; border-radius: 12px; font-family: \"Segoe UI\", Tahoma, Geneva, Verdana, sans-serif; transition: all 0.3s ease;'>Unggah Bukti Pembayaran</button>
                </form>
              </div>";
    } elseif ($metodePembayaran === 'cash') {
        echo "<div class='alert alert-success text-center' style='padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);'>Silakan lakukan pembayaran di basecamp.</div>";
    } else {
        echo "<div class='alert alert-danger text-center' style='padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);'>Metode pembayaran tidak valid.</div>";
    }
    
    // Tutup form pertama
    $insertStmt->close();
    exit;
}

// Proses untuk unggah bukti pembayaran
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['bukti_pembayaran'])) {
    $uploadDir = 'uploads/';
    $uploadFile = $uploadDir . basename($_FILES['bukti_pembayaran']['name']);
    $fileType = pathinfo($uploadFile, PATHINFO_EXTENSION);

    // Validasi ekstensi file
    $allowedTypes = ['jpg', 'jpeg', 'png'];
    if (in_array(strtolower($fileType), $allowedTypes)) {
        // Cek apakah direktori uploads ada
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);  // Membuat direktori jika belum ada
        }

        // Pindahkan file ke folder uploads
        if (move_uploaded_file($_FILES['bukti_pembayaran']['tmp_name'], $uploadFile)) {
            // Simpan informasi bukti pembayaran ke dalam kolom buktiPembayaran
            $updateSql = "UPDATE pembayaran SET buktiPembayaran = ? WHERE noPesanan = ?";
            $updateStmt = $conn->prepare($updateSql);
            $updateStmt->bind_param('si', $uploadFile, $noPesanan);
            $updateStmt->execute();
            echo "<div class='alert alert-success text-center' style='padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);'>Pembayaran berhasil, bukti pembayaran telah diunggah.</div>";
        } else {
            echo "<div class='alert alert-danger text-center' style='padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);'>Gagal mengunggah bukti pembayaran.</div>";
        }
    } else {
        echo "<div class='alert alert-danger text-center' style='padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);'>Ekstensi file tidak valid. Harap unggah gambar (JPG, JPEG, PNG).</div>";
    }
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
    <title>Pembayaran</title>
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 50px;
        }

        .card {
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .alert {
            font-size: 16px;
        }

        .table {
            font-size: 18px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
    </style>
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
    <h2 class="text-center mb-4">Pembayaran</h2>
    <div class="card">
        <div class="card-body">
            <h5 class="text-center">Detail Pembayaran</h5>
            <table class="table table-bordered mx-auto" style="max-width: 500px;">
                <tr>
                    <td><strong>No Pesanan</strong></td>
                    <td><?php echo htmlspecialchars($noPesanan); ?></td>
                </tr>
                <tr>
                    <td><strong>Total Pembayaran</strong></td>
                    <td>Rp <?php echo number_format($booking['total_pembayaran'], 0, ',', '.'); ?></td>
                </tr>
            </table>

            <!-- Form pertama: Memilih metode pembayaran -->
            <form action="" method="post">
                <div class="form-group">
                    <label for="metode_pembayaran">Pilih Metode Pembayaran:</label>
                    <select class="form-control" id="metode_pembayaran" name="metode_pembayaran" required>
                        <option value="">-- Pilih --</option>
                        <option value="transfer">Transfer Bank</option>
                        <option value="cash">Cash</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Lanjutkan Pembayaran</button>
            </form>

        </div>
    </div>
</div>
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


</body>
</html>
