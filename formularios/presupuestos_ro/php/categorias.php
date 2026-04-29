<?php

  include('conexiones/conexion.php');

  $familia = $_POST['familia'];
  $marca = $_POST['marca'];

  $consulta_categorias = "SELECT DISTINCT CATEGORIA FROM presupuesto_ro WHERE FAMILIA = '$familia' AND  MARCA = '$marca' ORDER BY CATEGORIA";

  $categorias = mysqli_query($conexion, $consulta_categorias);
  $marca = mysqli_num_rows( $categorias );

  $respuesta = '';
  $respuesta .="<span><i class='fas fa-book'></i></span>
                <select id='categoria' name='categoria'>
                  <option value=''>Categorias</option>";

  if ($marca > 0) {
    while ($filas = mysqli_fetch_assoc($categorias)) {
      $respuesta .= "<option value='".$filas['CATEGORIA']."'>".$filas['CATEGORIA']."</option>";
    }
    $respuesta .= '</select>';
    echo $respuesta;
    mysqli_close( $conexion );
  }else{
    echo '';
    mysqli_close( $conexion );
  }

?>
