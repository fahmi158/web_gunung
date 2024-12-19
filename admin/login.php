<?php 
require '../server/config.php';
session_start();
if((isset($_SESSION['akses'])) AND ($_SESSION['akses']=='admin')){
  echo "<script> window.location.href='../admin/index.php'</script>";
}

$show='none';

function loginverify($username,$password){

  $sql = "SELECT * FROM admin WHERE username = '$username' ";
  global $conn;
  $result = mysqli_query($conn,$sql);
  $data=mysqli_fetch_array($result,MYSQLI_ASSOC);
  //var_dump($data);

  if($username==$data['username'] and $data['password']==MD5($password) ){
    //header("location:http://localhost:80/web_gunung/admin/index.php");
   

    $ver['status']=true;
    $ver['message']='';
    return $ver;
  }else{
    $ver['status']=false;
    $ver['message']='Password atau Username salah, silahkan masukkan ya benar.';
    return $ver;
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

    <title>Login Admin</title>

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
        <!-- <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          Menu
          <i class="fa fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav text-uppercase ml-auto">
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#service">Melayani</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#portfolio">Gunung</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#about">Registrasi</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#">Persyaratan</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#team">Team</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#contact">Hubungi</a>
            </li>
          </ul>
        </div> -->
        </div>
    </nav>

    <!-- Header -->
    <!-- <header class="masthead">
      <div class="container">
        <div class="intro-text">
          <div class="intro-lead-in">Welcome To Our Mountain !</div>
          <div class="intro-heading text-uppercase">It's Nice To Meet You</div>
          <a class="btn btn-primary btn-xl text-uppercase js-scroll-trigger" href="#services">Tell Me More</a>
        </div>
      </div>
    </header> -->

    <?php 
    if($_SERVER['REQUEST_METHOD']=='POST'){
      //$_SESSION['akses']=$_POST['username'];
      if(loginverify($_POST['username'],$_POST['password'])['status']){
        $_SESSION['akses']=$_POST['username'];
        //header('location:http://localhost:80/web_gunung/admin/index.php');
        echo "<script> window.location.href='../admin/index.php'</script>";
      }else{
        $message=loginverify($_POST['username'],$_POST['password'])['message'];
        //echo $message;
        $show='block';
      }
    }
    //var_dump($_SESSION);
    ?>  

    <!-- form login -->
    <section id="login">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 text-center">
            <h2 class="section-heading text-uppercase">Login Admin</h2>
            <!-- <h3 class="section-subheading text-muted" style="color: #fff;">Hubungi kami atau kritik dan saran jika anda mendapatkan masalah seputar pelayanan.</h3> -->
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <form   action="" method="POST">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <input class="form-control" type="text" placeholder="Username*"  name="username" id="username">
                    <p class="help-block text-danger"></p>
                  </div>
                  <div class="form-group">
                    <input class="form-control"  type="text" placeholder="Password *"  name="password" id="username">
                    <p class="help-block text-danger"></p>
                  </div>
                  <div class="form-group col-sm-6 text-center">
                    <div class="alert alert-danger" role="alert" style="display: <?= $show?>;">
                      <?php 
                      if(isset($message)){ 
                        echo $message;
                        
                        }?>
                    </div>
                  </div>
                </div>
                
                <div class="col-lg-12 text-center">
                  <button  class="btn btn-primary btn-xl text-uppercase" type="submit">Login</button>
                </div>
                
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
