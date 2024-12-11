<?php
require 'server/config.php';

// Mengambil data dari tabel jadwal
if($_SERVER['REQUEST_METHOD']=='POST'){
    $tglstart=$_POST['tanggalawal'];
    $tglend=$_POST['tanggalakhir'];
    //echo $tglstart;
  
    $sql = "SELECT * FROM `jadwal` 
     WHERE (tanggal BETWEEN '$tglstart' AND '$tglend')
     AND  ( namaGunung = 'Buthak')
    ";
  
    $result = $conn->query($sql);
    $res2=mysqli_fetch_all($result,MYSQLI_ASSOC);
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
                    <li class="nav-item"><a class="nav-link js-scroll-trigger" href="index.html#service">Melayani</a></li>
                    <li class="nav-item"><a class="nav-link js-scroll-trigger" href="index.html#portfolio">Gunung</a></li>
                    <li class="nav-item"><a class="nav-link js-scroll-trigger" href="index.html#about">Registrasi</a></li>
                    <li class="nav-item"><a class="nav-link js-scroll-trigger" href="#">Persyaratan</a></li>
                    <li class="nav-item"><a class="nav-link js-scroll-trigger" href="index.html#team">Team</a></li>
                    <li class="nav-item"><a class="nav-link js-scroll-trigger" href="index.html#contact">Hubungi</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contact -->
    <section id="contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading text-uppercase">Cek Kuota Pendakian Gunung Butak</h2>
                    <h3 class="section-subheading text-muted" style="color: #fff;">Pilih tanggal mendaki dan lihat apakah kuota sudah penuh.</h3>
                </div>
            </div>

            <form ation="" method="post">
            <div class="d-flex flex-row">
              <div class="m-2">
                  <label for="tanggalawal" class="form-label"></label>
                  <input type="date" class="form-control" placeholder="YYYY-MM-DD" id="tanggalawal" name="tanggalawal" aria-describedby="tanggalawalhelp" value="<?php if(isset($_POST['tanggalawal'])){echo $_POST['tanggalawal'];}?>">
                  <div id="tanggalawalhelp" class="form-text"></div>
              </div>
          
              <div class="m-2">
                  <label for="tanggalakhir" class="form-label"></label>
                  <input type="date" class="form-control" placeholder="YYYY-MM-DD" id="tanggalakhir" name="tanggalakhir" aria-describedby="tanggalakhirhelp" value="<?php if(isset($_POST['tanggalakhir'])){echo $_POST['tanggalakhir'];}?>">
                  <div id="tanggalakhirhelp" class="form-text"></div>
              </div>
              <div class="m-2">
                  <button type="submit" class="btn btn-primary mt-4 m-2">lihat kuota</button>
              </div>
          </div>
            </form>
            <br /><br />

            <!-- Table displaying the available schedules -->
            <table class="table table-hover" style="color: white; text-align: center;">
                <thead>
                    <tr>
                        <th scope="col" style="background-color: cadetblue; color: black;">Tanggal Mendaki</th>
                        <th scope="col" style="background-color: cadetblue; color: black;">gunung</th>
                        <th scope="col" style="background-color: cadetblue; color: black;">Kuota Pendaki</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Menampilkan data dari tabel jadwal
                    if(count($res2) > 0) {
                        foreach ($res2 as $row) {
                            echo "<tr>
                                <td>" . $row["tanggal"] . "</td>
                                <td>" . $row["namaGunung"] . "</td>
                                <td>" . $row["kuota"] . "</td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='2'>Tidak ada data yang ditemukan</td></tr>";
                    }

                    // Menutup koneksi
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <span class="copyright">Copyright &copy; Mountain 2018</span>
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
