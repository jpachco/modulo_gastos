<?php
  session_start();
  if ($_SESSION['usuario'] == null || $_SESSION['usuario'] == ''){
    header('Location: ../index.html');
    die();
  }

  include('conexiones/local.php');
  $consulta = "LOAD DATA LOCAL INFILE 'C:/CORPORATIVO/catalogo_cp.csv' INTO TABLE catalogo_cp
  FIELDS TERMINATED BY ','
  LINES TERMINATED BY '\r\n'
  IGNORE 1 LINES ";
  $query = mysqli_query( $conexion_lcl, $consulta);

  if (!$query) {
    echo ('Error al insertar: '.mysqli_error($conexion_lcl));
  }else {
    echo "Exito";
  }
  ?>
  </body>
</html>
