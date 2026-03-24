<?php
error_reporting(E_ERROR);


if(empty($_POST['marca'])or $_POST['marca']=='' ){
    $marca='';
}
else{
    if(strpos($_POST['marca'], "%") !== 1){
        
        $marca="in (".$_POST['marca'].")";
    }
    else{
        $marca="like  '%' ";
    }
}

if(empty($_POST['familia'])or $_POST['familia']=='' ){
    $familia='';
}
else{
    if(strpos($_POST['familia'], "%") !== 1){
        
        $familia="in (".$_POST['familia'].")";
    }
    else{
        $familia="like  '%' ";
    }
}

if(empty($_POST['temp'])or $_POST['temp']=='' ){
    $tempo='';
}
else{
    if($_POST['temp'] !== "%"){
        
        $tempo="in (".$_POST['temp'].")";
    }
    else{
        $tempo="like  '%' ";
    }
    
}

include('connsqlsrv.php');
global $conexion;




  $consulta_modelos =utf8_decode( "

select Distinct  modelo+'|'+color as Modelos from sop_bas
where FAMILIA $familia and [marca] $marca
");


 
  $modelos = sqlsrv_query($conexion, $consulta_modelos, array(), array( "Scrollable" => 'static' ));
  $modelo = sqlsrv_num_rows($modelos);

  $respuesta = '';/*
  $respuesta .=  "
                <select id='familia'  class='form-control'  name='familia[]' multiple>
                   <option value='%'>Familias*</option>";*/


  if ($modelo > 0) {
      while ($filas = sqlsrv_fetch_array($modelos)) {
          
      $respuesta .= utf8_encode ("<option value='".$filas['Modelos']."'>".$filas['Modelos']."</option>");
     
    }
   // $respuesta .= '</select>';
    echo $respuesta;
    sqlsrv_free_stmt( $modelos );
    sqlsrv_close( $conexion );
  }
  else{
      echo "error";
    sqlsrv_free_stmt( $modelos );
    sqlsrv_close( $conexion );
  }

?>
