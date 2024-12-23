<?php 
require '../server/config.php';
session_start();
if($_SESSION['akses'] != 'admin'){
  echo "<script> window.location.href='../admin/login.php'</script>";
}
$id=$_GET['iDkwn'];

function updateHarga($id,$harga){
$query="UPDATE kewarganegaraan
SET harga ='$harga'
WHERE idkewarganegaraan ='$id'
";
global $conn;
mysqli_query($conn,$query);
}

function getAllKwnbyId($id){
    $query="SELECT * FROM kewarganegaraan WHERE idKewarganegaraan = '$id'";
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
    <meta name="author" content=`"">

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
        
    </nav>
    <section id="contact">
        <div class="container">
        <form action="" method="POST"> 
                
            <?php 
            $idkwn=$_GET['iDkwn'];
            $tabel=getAllKwnbyId($idkwn);
            ?> 
                <div class="form-group">
                  <label for="formGroupExampleInput2">kewarganegaraan</label>
                  <input type="text" class="form-control" name="kwn" id="formGroupExampleInput2" placeholder="Masukkan kuota" value="<?= $tabel[0]['jenis']?>" disabled>
                </div>
                <div class="form-group">
                  <label for="formGroupExampleInput2">Harga</label>
                  <input type="number" class="form-control" name="harga" id="formGroupExampleInput2" placeholder="Masukkan kuota" value="<?= $tabel[0]['harga']?>">
                </div>
                <a href="harga.php" class="btn btn-primary">kembali</a>
                <button type="submit" class="btn btn-success">update</button>
              </form>
        </div>
    </section>
    <?php 
    if($_SERVER['REQUEST_METHOD']=="POST"){
        $id=$_GET['iDkwn'];
;
        $harga=$_POST['harga'];
        if(updateHarga($id,$harga)){
           
            echo "<script>alert('jadwal berhsil di update');</script>";
        }else{
            echo "<script>alert('jadwal berhsil di update');</script>";
            echo "<script> window.location.href='harga.php'</script>";
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
