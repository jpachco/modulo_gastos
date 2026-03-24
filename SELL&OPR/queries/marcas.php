<?php
error_reporting(E_ERROR);

include('connsqlsrv.php');
global $conexion;
global $fam;


  if(empty($_POST['familia'])or $_POST['familia']=='' ){
  $fam='';
}
else{
  if(strpos($_POST['familia'], "%") !== 1){

    $fam="in (".$_POST['familia'].")";
  }
  else{
    $fam="like  '%' ";
  }
}



$sql= utf8_decode( "
      SELECT DISTINCT  [Colección]  
						 FROM [PRODUCTO_LOGISTICA]
						 WHERE familia $fam and 
          (Subfamilia like '1%[789]%' 
          OR Subfamilia like '2[0-9]_'
          OR Subfamilia in ('BAS','CONSIG') OR Subfamilia LIKE 'CO%' OR Subfamilia LIKE 'ST') 
          AND [Colección] IN('ROBERTS','ROBERTS RE','CALDERONI','CALDERONIC','HUGO BOSS','OM','GEOX') ORDER BY [Colección]

  ");






$marcas = sqlsrv_query($conexion, $sql, array(), array( "Scrollable" => 'static' ));
$marca = sqlsrv_num_rows($marcas);

$respuesta = '';/*
$respuesta .=  "
                <select id='marca'  class='form-control'  name='marca[]' multiple>
                   <option value='%'   >Marcas*</option>";*/


if ($marca > 0) {
  while ($filas = sqlsrv_fetch_array($marcas)) {
    $respuesta .= utf8_encode ("<option value='".$filas[0]."'>".$filas[0]."</option>");
  }
  //$respuesta .= '</select>';
  echo $respuesta;
  sqlsrv_free_stmt( $marcas );
  sqlsrv_close( $conexion );
}else{
  echo '';
  sqlsrv_free_stmt( $marcas );
  sqlsrv_close( $conexion );
}




?>
