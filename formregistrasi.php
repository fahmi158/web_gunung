<?php 
require 'server/config.php';
$idjadwal=$_GET['jadwalId'];
$query="SELECT * FROM jadwal WHERE idJadwal = $idjadwal";
$result= mysqli_fetch_assoc(mysqli_query($conn,$query));
//var_dump($result);
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
                          <div class="col-md-12">
                <form class="form-horizontal" action="?" method="post">
                  <div class="form-group">
<<<<<<< HEAD:formregistrasi.html
                    <label for="nama" class="col-sm-1" "control-label">Nama</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="nama" placeholder="Masukkan Nama Lengkap Anda">
=======
                    <div class="col-sm-9">
                    <label for="exampleFormControlSelect1" class="col-sm-3 col-form-label text-light left-0" >Gunung Pilihan</label>
                    <select class="form-control" id="exampleFormControlSelect1" name="namagunung" disabled>
                        <option value="<?= $_GET['namagunung']?>" ><?= $_GET['namagunung']?></option>
                   </select>
                    </div>
                  <div class="form-group">
                    <div class="col-sm-9 ">
                      <label for="nama" class="col-form-label text-light">Nama</label>
                      <input type="text" class="form-control"id="nama" name="nama" placeholder="Masukkan Nama Lengkap Anda">
>>>>>>> 125d6027f97800de616899dff175dab32d9cdc75:formregistrasi.php
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-9">
                      <label for="nama" class="text-light" "control-label">Tanggal</label>
                        <input type="date" class="form-control" name="tanggal" placeholder="Masukkan Tanggal Pendakian" value="<?= $result['tanggal']?>" disabled>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-9">
                      <label for="nama" class="text-light" "control-label">Telp.</label>
                        <input type="text" class="form-control" name="telp" placeholder="Masukkan Nomor Telephone">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-9">
                      <label for="alamat" class="text-light" "control-label">Alamat</label>
                        <textarea name="alamat"class="form-control" placeholder="Masukkan Alamat Lengkap"></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-9">
                      <label for="nama" class="text-light" "control-label">Email</label>
                        <input type="text" class="form-control" name="email" placeholder="Masukkan Alamat email">
                    </div>
                  </div>
                  <div class="col-sm-offset-4 col-sm-10">
                      <button type="submit" class="btn btn-warning">Simpan</button>
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

    <!-- Plugin JavaScript -->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Contact form JavaScript -->
    <script src="js/jqBootstrapValidation.js"></script>
    <script src="js/contact_me.js"></script>

    <!-- Custom scripts for this template -->
    <script src="js/agency.min.js"></script>

  </body>

</html>
