<?php

  include('conexiones/conexion.php');

  $familia = $_POST['familia'];

  $consulta_marcas = "SELECT DISTINCT MARCA FROM presupuesto_ro WHERE FAMILIA = '$familia' ORDER BY MARCA";

  $marcas = mysqli_query($conexion, $consulta_marcas);
  $marca = mysqli_num_rows( $marcas );

  $respuesta = '';
  $respuesta .="<span><i class='fas fa-user'></i></span>
                <select id='marca' name='marca'>
                  <option value=''>Marcas</option>";

  if ($marca > 0) {
    while ($filas = mysqli_fetch_assoc($marcas)) {
      $respuesta .= "<option value='".$filas['MARCA']."'>".$filas['MARCA']."</option>";
    }
    $respuesta .= '</select>';
    echo $respuesta;
    mysqli_close( $conexion );
  }else{
    echo '';
    mysqli_close( $conexion );
  }

?>
