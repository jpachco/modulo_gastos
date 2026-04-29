<?php

  include('conexiones/conexion.php');

  $familia = $_POST['familia'];
  $marca = $_POST['marca'];
  //$categoria = $_POST['categoria'];

  $consulta_anios = "SELECT DISTINCT ANIO FROM presupuesto_ro WHERE FAMILIA = '$familia' AND MARCA = '$marca' /*AND CATEGORIA = '$categoria'*/ ORDER BY ANIO";

  $anios = mysqli_query($conexion, $consulta_anios);
  $anio = mysqli_num_rows( $anios );

  $respuesta = '';
  $respuesta .="<span><i class='fas fa-calendar-alt'></i></span>
                <select id='anio' name='anio'>
                  <option value=''>Año</option>";

  if ($anio > 0) {
    while ($filas = mysqli_fetch_assoc($anios)) {
      $respuesta .= "<option value='".$filas['ANIO']."'>".$filas['ANIO']."</option>";
    }
    $respuesta .= "</select><span></span> <span id='buscar'><i class='fas fa-search'></i> Buscar</span>";
    echo $respuesta;
    mysqli_close( $conexion );
  }else{
    echo '';
    mysqli_close( $conexion );
  }

?>
