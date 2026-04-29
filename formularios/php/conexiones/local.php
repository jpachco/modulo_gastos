<?php
  $servername = 'localhost';
  $username = 'hholdn4_haberholding';
  $password = 'uGnHJEuoikRf6xYs';
  $dbname = 'hholdn4_haberholding_formularios';

  // Create connection
  $conexion_lcl = mysqli_connect($servername, $username, $password, $dbname);
  // Check connection
  if (!$conexion_lcl) {
      die('Fallo la conexion: ' . mysqli_connect_error());
      echo 'error';
  }


?>
