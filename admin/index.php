<?php 
require '../server/config.php';
session_start();
if($_SESSION['akses'] != 'admin'){
  echo "<script> window.location.href='../admin/login.php'</script>";
}

function getAllJadwal(){
  $query="SELECT * FROM jadwal";
  global $conn;
  $result=mysqli_query($conn,$query);
  return mysqli_fetch_all($result,MYSQLI_ASSOC);
}

function addJadwal($tanggal,$namagunung,$kuota){
  $query="INSERT INTO jadwal (tanggal,namaGunung,kuota) VALUE ('$tanggal','$namagunung','$kuota')";
  global $conn;
  mysqli_query($conn,$query);
}

function deleteById($id){
  $query="DELETE FROM jadwal WHERE idJadwal = '$id'";
  global $conn;
  mysqli_query($conn,$query);
}
?>

<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content=`"">

    <title>Admin | jadwal</title>

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

  <body id="page-top" style="background-color:#212529">

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
              <a class="nav-link js-scroll-trigger active"  href="index.php">Jadwal</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="harga.php">Harga</a>
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
    <!-- <header class="masthead">
      <div class="container">
        <div class="intro-text">
          <div class="intro-lead-in">Selamat datang Admin!</div>
         
        </div>
      </div>
    </header> -->


    <div class="container">
         <!-- Button trigger modal -->
         <section id="contact" >
        <div class="m-3">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#staticBackdrop">
          Tambah Jadwal
        </button>
        </div>
      <table class="table table-hover" style="color: white; text-align: center;">
            <thead>
              <tr>
                <th scope="col" style="background-color: cadetblue; color: black;">Tanggal Mendaki</th>
                <th scope="col" style="background-color: cadetblue; color: black;">Gunung</th>
                <th scope="col" style="background-color: cadetblue; color: black;">Kuota pendaki</th>
                <th scope="col" style="background-color: cadetblue; color: black;"></th>
              </tr>
            </thead>
            <tbody>
            <?php
                      // Menampilkan data dari tabel jadwal
                      
                          foreach (getAllJadwal() as $row) {?>
                              <tr>
                                  <td><?= $row["tanggal"]?></td>
                                  <td><?=$row["namaGunung"] ?></td>
                                  <td><?=$row["kuota"] ?></td>
                            <?php if($row['kuota']>0){?>
                              <td>
                              <div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center ">
                                  <div class="text-center ">
                                    <div class="d-flex justify-content-center align-items-center flex-wrap ">
                                      <!-- Form Update -->
                                      <form action="update_jadwal.php" method="get" class="m-2">
                                        <input type="hidden" value="<?= $row['idJadwal'] ?>" name="id">
                                        <button type="submit" class="btn btn-warning">Update</button>
                                      </form>

                                      <!-- Form Hapus -->
                                      <form action="" method="POST" onsubmit="return confirm('Hapus data?');" class="m-2">
                                        <input type="hidden" value="<?= $row['idJadwal'] ?>" name="id">
                                        <input type="hidden" value="hapus" name="action">
                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                      </form>
                                    </div>
                                  </div>
                                </div>
                              </td>
  
          <?php 
                              }else{
                                echo "<td>kosong</td>";
                              }
                                  
                             echo "</tr>";
                          }
  
                      
                      ?>
            </tbody>
          </table>
      </section>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
          <form action="index.php" method="POST"> 
            <div class="form-group">
              <label for="formGroupExampleInput">Tanggal</label>
              <input type="date" class="form-control" name="tanggal" id="formGroupExampleInput" placeholder="Example input placeholder">
            </div>
            <div class="form-group">
              <label for="namagunung">Gunung</label>
              <select name="namagunung" id="namagunung" class="form-control" aria-placeholder="pilih Gunung">
                <option value="Buthak">Buthak</option>
                <option value="Panderman">Panderman</option>
              </select>
            <div class="form-group">
              <label for="formGroupExampleInput2">Kuota</label>
              <input type="number" class="form-control" name="kuota" id="formGroupExampleInput2" placeholder="Masukkan kuota">
            </div>
            <input type="hidden" name="action" value="tambah">
            <button type="submit" class="btn btn-success">Tambah</button>
          </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
            <!-- <button type="button" class="btn btn-primary">Understood</button> -->
          </div>
        </div>
      </div>
    </div>
    

    <?php 
    if($_SERVER['REQUEST_METHOD']=='POST'){
      if($_POST['action']=='tambah'){
        $tgl=$_POST['tanggal'];
        $gng=$_POST['namagunung'];
        $kuota=$_POST['kuota'];
        if(addJadwal($tgl,$gng,$kuota)){
        unset($_POST);
         echo "<script>alert('jadwal gagal di tambhakan');</script>";
        }else{
          echo "<script>alert('jadwal berhsil di tambhakan');</script>";
        }
      }else if($_POST['action']=='hapus'){
        if(deleteById($_POST['id'])){
          echo "<script>alert('jadwal gagal di hapus');</script>";
        }else{
          echo "<script>alert('jadwal berhsil di hapus');</script>";
        }
      }


    }
    ?>

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
