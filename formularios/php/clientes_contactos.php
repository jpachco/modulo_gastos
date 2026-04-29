<?php

  include('conexiones/local.php');

  session_start();
  if ($_SESSION['usuario'] == null || $_SESSION['usuario'] == ''){
    header('Location: ../index.html');
    die();
  }

  unset($_SESSION['id']);

  mysqli_set_charset($conexion_lcl, 'utf8');
  error_reporting(0);
  $correo = $_POST['correo'];
  $celular = $_POST['celular'];

  if ($correo != '') {
    $sql = "SELECT * FROM clientes_contactos where id = '$correo' OR correo = '$correo'";

    $query = mysqli_query( $conexion_lcl, $sql);
    $resultado = mysqli_num_rows($query);

    if ($resultado > 0){
      while( $row = mysqli_fetch_array($query)){
	$mID = $row['id'];
        $registro= $row;
      }
      $_SESSION['id'] = $mID;
      $_SESSION['tipo_id'] = 'correo';
      echo json_encode($registro);
    }else{
      $_SESSION['id'] = $correo;
    }
  }
  if ($celular != '') {
    $sql = "SELECT * FROM clientes_contactos where id = '$celular' OR celular = '$celular'";

    $query = mysqli_query( $conexion_lcl, $sql);
    $resultado = mysqli_num_rows($query);

    if ($resultado > 0){
      while( $row = mysqli_fetch_array($query)){
	$mID = $row['id'];
        $registro = $row;
      }
      $_SESSION['id'] = $mID;
      $_SESSION['tipo_id'] = 'celular';
      echo json_encode($registro);
    }else{
      $_SESSION['id'] = $celular;
    }
  }

?>
