<?php 
	$host = "localhost";
	$user = "root";
	$pass = "";
	$db = "pendakian";


	$conn = mysqli_connect($host,$user,$pass,$db);

	$GLOBALS['conn'];

	if (!$conn) {
		 echo 'tidak terkoneksi ke database';
	}

 ?>