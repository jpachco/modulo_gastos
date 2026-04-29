<?php

  include('conexiones/local.php');

  session_start();
  if ($_SESSION['usuario'] == null || $_SESSION['usuario'] == ''){
    header('Location: ../index.html');
    die();
  }

  mysqli_set_charset($conexion_lcl, 'utf8');
  error_reporting(0);
  $correo = $_POST['correo'];
  $celular = $_POST['celular'];

  if ($correo != '') {
    $sql = "SELECT * FROM clientes_contactos where correo = '$correo'";

    $query = mysqli_query( $conexion_lcl, $sql);
    $resultado = mysqli_num_rows($query);

    if ($resultado > 0){
      while( $row = mysqli_fetch_array($query)){
        $registro= $row;
      }
      $_SESSION['correo'] = $correo;
      echo json_encode($registro);
    }else{
      $_SESSION['correo'] = $correo;
    }
  }

  if ($celular != '') {
    $sql = "SELECT * FROM clientes_contactos where celular = '$celular'";

    $query = mysqli_query( $conexion_lcl, $sql);
    $resultado = mysqli_num_rows($query);

    if ($resultado > 0){
      while( $row = mysqli_fetch_array($query)){
        $registro = $row;
      }
      $_SESSION['correo'] = $correo;
      echo json_encode($registro);
    }else{
      $_SESSION['correo'] = $correo;
    }
  }

?>
