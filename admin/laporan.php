<?php 
require '../server/config.php';
session_start();
if($_SESSION['akses'] != 'admin'){
  echo "<script> window.location.href='../admin/login.php'</script>";
}
$show='none';

function bindingarr($arr){
  $result=[];
  foreach($arr as $data){
      $result[$data['waktu_transaksi']]=$data['subtotal'];
  }
  return $result;
}

function totalByDay($array){
  $result=[];
  foreach($array as $datkey => $data){
      if(! array_key_exists($datkey,$result)){
          $result[$datkey]=$data;
      }else{
          $result[$datkey]+=$data;
      }
  }
  return $result;

}

function ambiltangal($array){
  $result=[];
  foreach($array as $key=> $data){
      $result[]=$key;
  }
  return $result;
}
function ambiltotal($array){
  $result=[];
  foreach($array as $key => $data){
      $result[]=$data;
  }
  return $result;
}
?>

<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin | Laporan</title>

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
              <a class="nav-link js-scroll-trigger "  href="index.php">Jadwal</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="harga.php">Harga</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="pembayaran.php">Pembayaran</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger active" href="laporan.php">Laporan Pemasukan</a>
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

    <section>
    <div class="container">
    <br><br>
       <div class="page-header">
           <h2> Laporan Keuangan </h2>
       </div>
       <div class="container">
           <form action="" method="POST">
          <div class="row">
              <div class="col-lg-3">
              <label for="tglawal" class="form-lable">tanggal awal</label>
              <input type="date" class="form-control" placeholder="tanggal awal" name="tanggalawal" value="<?php if(isset($_POST['tanggalawal'])){ echo $_POST['tanggalawal'];}?>">
          </div>
          <div class="col-lg-3">
            <label for="tglakhir" class="form-lable">tanggal akhir</label>
              <input type="date" class="form-control" id="tglakhir" placeholder="tanggal akhir" name="tanggalakhir" value="<?php if(isset($_POST['tanggalakhir'])){ echo $_POST['tanggalakhir'];}?>">
          </div>
                  <button type="submit" class="btn btn-primary mt-4 m-2">lihat laporan Transaksi</button>
              </div>
          </div>
          </form>
       </div>
    </div>
<?php 
if($_SERVER['REQUEST_METHOD']=='POST'){
    $tglawal=$_POST['tanggalawal'];
    $tglakhir=$_POST['tanggalakhir'];
    $query="SELECT tgl_pendakian,total-pembayaran FROM booking WHERE tgl_pendakian BETWEEN '$tglawal' AND '$tglakhir'";
    $result=mysqli_query($connect,$query);
    $data=mysqli_fetch_all($result,MYSQLI_ASSOC);
    //var_dump($data);
    $tabeldata=totalByDay( bindingarr($result));
    $show='block';
}
?>
    <div class="container">
      
<div style="display: <?= $show?>">
    
    <div class="d-flex justify-content-center">
    
    <div class="w-65 p-3 ">
        
        <div>
        <canvas id="myChart"></canvas>
        </div>
    
        <script>
        const ctx = document.getElementById('myChart');
    
        new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?= json_encode( ambiltangal($tabeldata))?>,
            datasets: [{
            label: '# of Votes',
            data: <?= json_encode( ambiltotal($tabeldata))?>,
            borderWidth: 1
            }]
        },
        options: {
            scales: {
            y: {
                beginAtZero: true
            }
            }
        }
        });
    </script>
    
    </div>
    </div>

       <table id="tables" class="table table-responsive table-bordered table-striped">
           <thead>
               <tr>
                   <th style="text-align: center;"> Tanggal  </th>
                   <th style="text-align: center;"> total perhari </th>
               </tr>
           </thead>
           <?php foreach($tabeldata as $key =>$dat):?>
                   <tr>
                       <td style="text-align: center;"><?= $key ?></td>
                       <td style="text-align: center;"><?= $dat ?></td>
                   </tr>
            <?php endforeach;?>
       </table>
    </div>
</div>

   
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
