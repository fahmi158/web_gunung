<?php 
require '../server/config.php';
session_start();
if($_SESSION['akses'] != 'admin'){
  echo "<script> window.location.href='../admin/login.php'</script>";
}

function getAllPembayaran(){
  $query="SELECT * FROM pembayaran";
  global $conn;
  $result =mysqli_query($conn,$query);
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

    <title>Admin | Pembayaran</title>

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
              <a class="nav-link js-scroll-trigger"  href="index.php">Jadwal</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="harga.php">Harga</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger active" href="pembayaran.php">Pembayaran</a>
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



  <div class="container">
    <section id="contact">
    <table class="table table-hover" style="color: white; text-align: center;">
          <thead>
            <tr>
              <th scope="col" style="background-color: cadetblue; color: black;">Kod. Pembayaran</th>
              <th scope="col" style="background-color: cadetblue; color: black;">id Admin</th>
              <th scope="col" style="background-color: cadetblue; color: black;">NO. pes</th>
              <th scope="col" style="background-color: cadetblue; color: black;">tgl. pembayaran</th>
              <th scope="col" style="background-color: cadetblue; color: black;">status pembayaran</th>
              <th scope="col" style="background-color: cadetblue; color: black;">metode pembayaran</th>
              <th scope="col" style="background-color: cadetblue; color: black;">bukti pembayaran</th>
              <th scope="col" style="background-color: cadetblue; color: black;">verifikasi</th>
            </tr>
          </thead>
          <tbody>
          <?php     $tabelpembayaran=getAllPembayaran();
                    // Menampilkan data dari tabel jadwal
                    if (count($tabelpembayaran) > 0) {
                        foreach ($tabelpembayaran as $row) {?>
                            <tr>
                                <td><?= $row["kodePembayaran"]?></td>
                                <td><?=$row["idAdmin"] ?></td>
                                <td><?=$row["noPesanan"] ?></td>
                                <td><?=$row["tgl_pembayaran"] ?></td>
                                <td><?=$row["status_pembayaran"] ?></td>
                                <td><?=$row["metode_pembayaran"] ?></td>
                                <td>
                                <?php 
                                if($row['status_pembayaran']=='sudah' and $row["metode_pembayaran"] != 'cash' ){
                                  ?>
                                  <a href="../<?=$row["buktiPembayaran"] ?>">
                                    <img src="../<?=$row["buktiPembayaran"] ?>" alt="bukti pembayaran" width="100px">
                                  </a>
                                <?php 
                                }else{
                                  echo '';
                                }?>
                                </td>

                          <?php 
                          if($row['status_pembayaran']=='belum'){
                            ?>
                            <td>
                              <form action="" method="POST" onsubmit="return confirm('verifikasi pembayaran?');">
                                  <input type="hidden" value="sudah" name="status_pembayaran"> 
                                  <input type="hidden" value="<?= $row["kodePembayaran"]?>" name="IDpembayaran">
                                  <input type="hidden" value="verifikasi" name="action">
                                  <button type="submit" class="btn btn-warning" >verifikasi</button>
                              </form>
                            </td>

                          <?php         
                            }else{
                              echo "<td style='color:green;'><i>verified!</i></td>";
                            }
                                
                           echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='2'>Tidak ada data yang ditemukan</td></tr>";
                    }

                    // Menutup koneksi
                    //$conn->close();
                    ?>
          </tbody>
        </table>
    </section>
  </div>

  <?php 
  if($_SERVER['REQUEST_METHOD']=="POST"){
    if($_POST['action']=='verifikasi'){
      echo 'on POST';
      $id=$_POST['IDpembayaran'];
      $status=$_POST['status_pembayaran'];
  
      $queryupdate=" UPDATE pembayaran
      SET status_pembayaran = '$status'
      WHERE kodePembayaran = $id ";
  
      if(mysqli_query($conn,$queryupdate)){
        echo "<script>alert('verivikasi berhasil!')</script>";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
      }else{
        echo "<script>alert('verivikasi berhasil!')</script>";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
      }
    }
  }
  ?>

<?php
// if($_SERVER['REQUEST_METHOD'] == "POST"){
//     echo 'on POST';
//     $id = $_POST['IDpembayaran'];
//     $status = $_POST['status_pembayaran'];

//     // Prepare and bind statement
//     $queryupdate = "UPDATE pembayaran
//                     SET status_pembayaran = ?
//                     WHERE kodePembayaran = ?";
//     $stmt = $conn->prepare($queryupdate);
//     $stmt->bind_param('si', $status, $id);

//     // Execute and check results
//     if ($stmt->execute()) {
//         if ($stmt->affected_rows > 0) {
//             echo "<script>alert('Verifikasi berhasil!')</script>";
//         } else {
//             echo "<script>alert('Tidak ada perubahan data!')</script>";
//         }
//     } else {
//         echo "<script>alert('Verifikasi gagal! Error: {$stmt->error}')</script>";
//     }
//     $stmt->close();
// }
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
