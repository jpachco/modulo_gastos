<?php
  require("conexiones/local.php");
  session_start();

  $xusuario = strtoupper($_POST['usuario']);
  $xclave = $_POST['clave'];

  $sql = "SELECT usuario, clave FROM usuarios
          WHERE usuario = '$xusuario'
              AND clave = '$xclave' ";
  $consulta = mysqli_query($conexion_lcl,$sql);

  $filas = mysqli_fetch_array($consulta);
  if($filas != NULL){
    $_SESSION['usuario'] = $xusuario;
    echo $filas;
    mysqli_close( $conexion_lcl );

  }else{
    echo $filas;
    mysqli_close( $conexion_lcl );
  }

?>
