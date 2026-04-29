<?php

/*
  $servername = '190.92.178.246';
  $username = 'hholdn4_haberholding';
  $password = 'uGnHJEuoikRf6xYs';
  $dbname = 'hholdn4_haberholding_formularios';

  $conexion = mysqli_connect($servername, $username, $password, $dbname);

  if (!$conexion) {
    die("Fallo la conexion: " . mysqli_connect_error());
  }*/


$usuario= 'magil';
$pass = 'Marcoo0';
$servidor = '172.25.12.26\BI';
$basedatos = 'dbRoberts';

$info = array('Database'=>$basedatos, 'UID'=>$usuario, 'PWD'=>$pass);
$conexion =sqlsrv_connect($servidor, $info) or die("no se establecio conexion");

?>
