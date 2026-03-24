<?php
error_reporting(E_ERROR);

include('connsqlsrv.php');
global $conexion;

 /* $consulta_familias = "SELECT DISTINCT FAMILIA FROM [Producto R] where  Familia NOT IN 
('','ABRIGO D','BERMUDA D','BOLSA D','CAJA','BLUSAS','BOTONES','BRAZALETE','CALZADO D','CHAMARRAD','BERMUDA D','CUBREPOLVO',
'CINTUROND','ETIQADH','ETIQBORD','JEANS D','JOYERIA','MALETA','MALETIN','MASCADA','MEDALLON','PANTALONSD','PANTALONVD',
'PANTS DAMA','PARAGUAS','PLAYERA D','PORTAFOLIO','PORTATRAJE','PROTECTOR', 'POLOML', 'REGALOS','REGALOSD','ROPA INTD',
'SACO SPD','SOMBRERO','SUETER D','VESTIDO',
 'ACCESORIOS', 'BERMUDA', 'BLAZER D', 'BLUSA', 
                         'BOLSA', 'BORDADO', 'CAMISA',  'CHALECOD', 'CINTA', 'CONJUNTO', 'COOR/PANTS', 'CORB&MAN', 'CORBATERO', 'EMPAQUE', 'EQUIPAJE', 
                         'FAJA&MONO', 'FALDA', 'FALDA DAMA', 'GORRA', 'HABILITACION', 'KITSMOKREN', 'MAQUILA', 'PANTALON', 'PANTALON D', 'PANTALON DAMA', 'PANTALOND', 
                         'PAQUETE', 'PIJAMA', 'SACO', 'SACO DAMA', 'SLACK', 'TELA', 'TELAS', 'VARIOS') 
                        AND (Subfamilia like '1[789]_' OR Subfamilia like '2[0-9]_' 
  OR Subfamilia in ('BAS','CONSIG','co21')  OR Subfamilia LIKE 'CO%' OR Subfamilia	like 'st'  )  ORDER BY FAMILIA 
  ";*/

$consulta_familias =utf8_decode( "
SELECT DISTINCT [FAMILIA]
FROM [dbRoberts].[dbo].[presupuesto_ro] 
where  Familia NOT IN 
('','ABRIGO D','BERMUDA D','BOLSA D','CAJA','BLUSAS','BOTONES','BRAZALETE','CALZADO D','CHAMARRAD','BERMUDA D','CUBREPOLVO',
'CINTUROND','ETIQADH','ETIQBORD','JEANS D','JOYERIA','MALETA','MALETIN','MASCADA','MEDALLON','PANTALONSD','PANTALONVD',
'PANTS DAMA','PARAGUAS','PLAYERA D','PORTAFOLIO','PORTATRAJE','PROTECTOR','REGALOS','REGALOSD','ROPA INTD',
'SACO SPD','SOMBRERO','SUETER D','VESTIDO',
 'ACCESORIOS', 'BERMUDA', 'BLAZER D', 'BLUSA', 
                         'BOLSA', 'BORDADO', 'CAMISA',  'CHALECOD', 'CINTA', 'CONJUNTO', 'COOR/PANTS', 'CORB&MAN', 'CORBATERO', 'EMPAQUE', 'EQUIPAJE', 
                         'FAJA&MONO', 'FALDA', 'FALDA DAMA', 'GORRA', 'HABILITACION', 'KITSMOKREN', 'MAQUILA', 'PANTALON', 'PANTALON D', 'PANTALON DAMA', 'PANTALOND', 
                         'PAQUETE', 'PIJAMA', 'SACO', 'SACO DAMA', 'SLACK', 'TELA', 'TELAS', 'VARIOS') 

ORDER BY FAMILIA ");


$familias = sqlsrv_query($conexion, $consulta_familias, array(), array( "Scrollable" => 'static' ));
$familia = sqlsrv_num_rows($familias);

$respuesta = '';/*
  $respuesta .=  "
                <select id='familia'  class='form-control'  name='familia[]' multiple>
                   <option value='%'>Familias*</option>";*/

if ($familia > 0) {
  while ($filas = sqlsrv_fetch_array($familias)) {
    $respuesta .= utf8_encode ("<option value='".$filas['FAMILIA']."'>".$filas['FAMILIA']."</option>");
  }
  //$respuesta .= '</select>';
  echo $respuesta;
  sqlsrv_free_stmt( $familias );
  sqlsrv_close( $conexion );
}else{
  echo '';
  sqlsrv_free_stmt( $familias );
  sqlsrv_close( $conexion );
}

?>
