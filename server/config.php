<?php 
	$host = "localhost";
	$user = "root";
	$pass = "";
	$db = "pendakian";


	$conn = mysqli_connect($host,$user,$pass,$db);

	if (!$conn) {
		 echo 'tidak terkoneksi ke database';
	}

 ?>