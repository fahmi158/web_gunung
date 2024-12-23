<?php 
require '../server/config.php';
session_start();
if($_SESSION['akses'] != 'admin'){
  echo "<script> window.location.href='../admin/login.php'</script>";
}

function getAllKwn(){
  $query="SELECT * FROM kewarganegaraan";
  global $conn;
  $result = mysqli_query($conn,$query);
  return mysqli_fetch_all($result,MYSQLI_ASSOC);
}



?>

<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin | Harga</title>

    <!-- Bootstrap core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>

    <!-- Custom styles for this template -->
    <link href="../css/agency.css" rel="stylesheet">

    <!-- icon -->
    <link rel="icon" href="../img/logoyellow.png">
  </head>

  <body id="page-top">

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
        <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="#page-top"><img src="../img/logoyellow.png" width="150px"></a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          Menu
          <i class="fa fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav text-uppercase ml-auto">
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger "  href="index.php">Jadwal</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger active" href="harga.php">Harga</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="pembayaran.php">Pembayaran</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="laporan.php">Laporan Pemasukan</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="logout.php">Logout</a>
            </li>
          </ul>
        </div>
        </div>
    </nav>

    <!-- Header -->
    


    <div class="container">

      <section id="contact">
      <table class="table table-hover" style="color: white; text-align: center;">
            <thead>
              <tr>
                <th scope="col" style="background-color: cadetblue; color: black;">no</th>
                <th scope="col" style="background-color: cadetblue; color: black;">kewarganegaraan</th>
                <th scope="col" style="background-color: cadetblue; color: black;">Harga Tiket Pengunjung</th>
                <th scope="col" style="background-color: cadetblue; color: black;">pilih kuota</th>
              </tr>
            </thead>
            <tbody>
            <?php
            $tabel=getAllKwn();
                      // Menampilkan data dari tabel jadwal
                      if (count($tabel) > 0) {
                          foreach ($tabel as $row) {?>
                              <tr>
                                  <td><?= $row["idKewarganegaraan"]?></td>
                                  <td><?=$row["jenis"] ?></td>
                                  <td><?=$row["harga"] ?></td>
                            
                              <td>
                                <form action="update_harga.php" method="get">
                                    <input type="hidden" value="<?= $row["idKewarganegaraan"]?>" name="iDkwn">
                                    <div class="m-3">
                                      </div>
                                      <button type="submit" class="btn btn-primary" >
                                        update
                                      </button>
                                    </form>
                              </td>
  
          <?php 
                              
                                  
                             echo "</tr>";
                          }
                      } else {
                          echo "<tr><td colspan='2'>Tidak ada data yang ditemukan</td></tr>";
                      }
  
                      // Menutup koneksi
                     // $conn->close();
                      ?>
            </tbody>
          </table>
      </section>
    </div>


    
    

    

    <!-- Footer -->
    <footer>
      <div class="container">
        <div class="row">
          <div class="col-md-4">
            <span class="copyright"></span>
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

    <?php 
    
    ?>
 

    <!-- Bootstrap core JavaScript -->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Contact form JavaScript -->
    <script src="../js/jqBootstrapValidation.js"></script>
    <script src="../js/contact_me.js"></script>

    <!-- Custom scripts for this template -->
    <script src="../js/agency.min.js"></script>

  </body>

</html>
