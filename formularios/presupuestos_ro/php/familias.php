<?php

  include('conexiones/conexion.php');

  $consulta_familias = "SELECT DISTINCT FAMILIA FROM presupuesto_ro ORDER BY FAMILIA";

  $familias = mysqli_query($conexion, $consulta_familias);
  $familia = mysqli_num_rows( $familias );

  $respuesta = '';
  $respuesta .="<span><i class='fas fa-users'></i></span>
                <select id='familia' name='familia'>
                  <option value=''>Familias</option>";

  if ($familia > 0) {
    while ($filas = mysqli_fetch_assoc($familias)) {
      $respuesta .= "<option value='".$filas['FAMILIA']."'>".$filas['FAMILIA']."</option>";
    }
    $respuesta .= '</select>';
    echo $respuesta;
    mysqli_close( $conexion );
  }else{
    echo '';
    mysqli_close( $conexion );
  }

?>
