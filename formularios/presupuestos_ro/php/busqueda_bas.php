<?php
include('conexiones/conexion.php');
global $conexion;
$respuesta = '';
$respuestacol8="";
$respuestacol4="";



//variables de asignacion por el metodo post desde html
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

if(empty($_POST['anio'])or $_POST['anio']=='' ){
  $anio='';
}
else{
  $anio= $_POST['anio'];
}



if(empty($_POST['categoria'])or $_POST['categoria']=='' ){
  $categoria='';
}
else{

  if($_POST['categoria'] !== "%"){
    $categoria="=".$_POST['categoria'];
  }
  else{
    $categoria="like  '%' ";
  }


}
if(empty($_POST['modelos'])or $_POST['modelos']=='' ){
  $modelo='';
}
else{
  if(strpos($_POST['modelos'], "%") !== 1){

    $modelo="in (".$_POST['modelos'].")";
  }
  else{
    $modelo="like  '%' ";
  }
}
if(empty($_POST['colores'])or $_POST['colores']=='' ){
  $color='';
}
else{
  if(strpos($_POST['colores'], "%") !== 1){

    $color="in (".$_POST['colores'].")";
  }
  else{
    $color="like  '%' ";
  }
}

$consulta = "SELECT *,año as Anio FROM sop_bas
                  WHERE Familia  $familia
                    AND Marca   $marca
                    AND Año = '$anio'
                    and Modelo  $modelo
                    and Color  $color
                    ORDER BY Año,MES,modelo,color";

$presupuestos = sqlsrv_query( $conexion, utf8_decode($consulta));
$rows=sqlsrv_has_rows($presupuestos);

$id = 0;
if ($rows==true){
  $respuesta .= "<form >              
                       <div class='form-inline '>";
  $respuestacol8.="
                            <div class='col-sm-6 col-md-6 col-lg-6 col-xl-6 '>
                                <div class='row'>
                                    <label class='col control-label  text-center'   >Venta</label>
                                </div>
                                <div class='row'>
                                <label >Modelo</label>
                                <label >Color</label>
                                <label >Talla</label>
                                <label >Año</label>
                                <label >Mes</label>
                                <label >Venta Ppto</label>
                                </div>
                            ";

  $respuestacol4.="
                            <div class='col-sm-6 col-md-6 col-lg-6 col-xl-6 '>
                                <div class='row'>
                                    <label class='col control-label text-center'>Compra</label>
                                </div>
                                <div class='row'>

                                <label >Modelo</label>
                                <label >Color</label>
                                <label >Talla</label>
                                <label >Año</label>
                                <label>Mes</label>
                                <label>Compra Ppto</label>
                                </div>
                            
                  
                      ";

  while( $dato = sqlsrv_fetch_array ($presupuestos ,SQLSRV_FETCH_ASSOC )){
    $id++;

    switch ($dato['mes']) {
      case '1':
        $mesL = 'Enero';
        break;

      case '2':
        $mesL = 'Febrero';
        break;

      case '3':
        $mesL = 'Marzo';
        break;

      case '4':
        $mesL = 'Abril';
        break;

      case '5':
        $mesL = 'Mayo';
        break;

      case '6':
        $mesL = 'Junio';
        break;

      case '7':
        $mesL = 'Julio';
        break;

      case '8':
        $mesL = 'Agosto';
        break;

      case '9':
        $mesL = 'Septiembre';
        break;

      case '10':
        $mesL = 'Octubre';
        break;

      case '11':
        $mesL = 'Noviembre';
        break;

      case '12':
        $mesL = 'Diciembre';
        break;

      default:
        // code...
        break;
    }

    // $respuesta .= '<div class="form-inline">';
    //$respuesta .= '<div class="col-8 form-group" style="margin-right: 2.5%">';
    $respuestacol8 .= '<div class="row">';
    $respuestacol8 .= '<input class='.'inputi '.' id='.'modeloL'.$id.' name='.'modeloL[]'.' value='.$dato['modelo'].' readonly>';
    $respuestacol8 .= '<input class='.'inputi '.' id='.'colorL'.$id.' name='.'colorL[]'.' value='.$dato['color'].' readonly>';
    $respuestacol8 .= '<input class='.'inputi '.' id='.'tallaL'.$id.' name='.'tallaL[]'.' value='.$dato['talla'].' readonly>';
    $respuestacol8 .= '<input class='.'inputi '.' id='.'anioL'.$id.' name='.'anioL[]'.' value='.$dato['Anio'].' readonly>';
    $respuestacol8 .= '<input class='.'hidden'.' id='.'mes'.$id.' name='.'mes[]'.'  value='.$dato['mes'].' readonly>';
    $respuestacol8 .= '<input class='.'inputi '.' id='.'mesL'.$id.' name='.'mesL[]'.' value='.$mesL.' readonly>';
    $respuestacol8 .= '<input class='.'inputi'.' id='.'ajustevta'.$id.' name='.'ajustevta[]'.' value='.$dato['venta'].'>';
    $respuestacol8 .= '</div>';
    //$respuesta .= '</div>';
    //$respuesta .= '<div class="col-4 form-group">';
    $respuestacol4 .= '<div class="row">';
    $respuestacol4 .= '<input class='.'inputd '.' id='.'modeloL2'.$id.' name='.'modeloL2[]'.' value='.$dato['modelo'].' readonly>';
    $respuestacol4 .= '<input class='.'inputd '.' id='.'colorL2'.$id.' name='.'colorL2[]'.' value='.$dato['color'].' readonly>';
    $respuestacol4 .= '<input class='.'inputd '.' id='.'tallaL2'.$id.' name='.'tallaL2[]'.' value='.$dato['talla'].' readonly>';
    $respuestacol4 .= '<input class='.'inputd '.' id='.'anioL2'.$id.' name='.'anioL2[]'.' value='.$dato['Anio'].' readonly>';
    $respuestacol4 .= '<input class='.'inputd '.' id='.'mesL2'.$id.' name='.'mesL2[]'.' value='.$mesL.' readonly>';
    $respuestacol4 .= '<input class='.'inputd'.' id='.'ajustecompra'.$id.' name='.'ajustecompra[]'.' value='.$dato['compra'].'>';
    $respuestacol4 .= '</div>';
    //$respuesta .= '</div>';
    //$respuesta .= '</div>';
  }


  $respuestacol8.='</div>';
  $respuestacol4.='</div>';
  $respuesta .=$respuestacol8.$respuestacol4."</div>";
  $respuesta .= "<span class='actualizar'  style='  display: block;
        margin-left: 80%;
        color: #245374;
        cursor: pointer;' > <i class='fa fa-edit'></i> Editar</span>  </form>";

  session_start();
  $_SESSION['familia'] = $_POST['familia'];
  $_SESSION['marca'] = $_POST['marca'];
  $_SESSION['anio'] = $_POST['anio'];
  $_SESSION['modelo'] = $_POST['modelos'];
  $_SESSION['color'] = $_POST['colores'];

  echo $respuesta;
  sqlsrv_close( $conexion );
}else{
  echo '';
  sqlsrv_close( $conexion );
}

?>
