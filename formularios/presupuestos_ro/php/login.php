<?php
  require("conexiones/conexion.php");
  session_start();

  $xusuario = strtoupper($_POST['usuario']);
  $xclave = $_POST['clave'];

  $sql = "SELECT usuario, clave FROM usuarios
          WHERE usuario = '$xusuario'
              AND clave = '$xclave' 
              AND empresa = 'Roberts'";
  $consulta = mysqli_query($conexion,$sql);

  $filas = mysqli_fetch_array($consulta);
  if($filas){
    $_SESSION['usuario'] = $xusuario;
    mysqli_close( $conexion );
    header("Location: ../home.php");
    die();
  }else{
    mysqli_close( $conexion );
    header("Location: ../index.html");
    die();
  }

?>
