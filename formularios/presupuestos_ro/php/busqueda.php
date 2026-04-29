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



$consulta = "SELECT * FROM presupuesto_ro
                  WHERE Familia  $familia
                    AND Marca  $marca
                    AND Categoria $categoria
                    AND Anio >= '$anio'
                    --and Anio <>2026
                    ORDER BY ANIO,MES";
$presupuestos = sqlsrv_query( $conexion, $consulta);
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
                                <label >Año</label>
                                  <label >MES</label>
                                  <label >CATEGORIA</label>
                                  <label >PRESUPUESTO</label>
                                  <label  >AJUSTE</label>
                                  <label   >PPROM</label>
                                </div>
                            ";

  $respuestacol4.="
                            <div class='col-sm-6 col-md-6 col-lg-6 col-xl-6 '>
                                <div class='row'>
                                    <label class='col control-label text-center'>Compra</label>
                                </div>
                                <div class='row'>
                                <label >Año</label>
                                     <label>MES</label>
                                      <label >CATEGORIA</label>
                                      <label >PLAN</label>
                                      <label  >AJUSTE</label>
                                      <label>CPROM</label>
                                </div>
                            
                  
                      ";

  while( $dato = sqlsrv_fetch_array ($presupuestos ,SQLSRV_FETCH_ASSOC )){
    $id++;

    switch ($dato['MES']) {
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
    $respuestacol8 .= '<input class='.'inputi '.' id='.'anioL'.$id.' name='.'anioL[]'.' value='.$dato['ANIO'].' readonly>';
    $respuestacol8 .= '<input class='.'hidden'.' id='.'mes'.$id.' name='.'mes[]'.'  value='.$dato['MES'].' readonly>';
    $respuestacol8 .= '<input class='.'inputi '.' id='.'mesL'.$id.' name='.'mesL[]'.' value='.$mesL.' readonly>';
    $respuestacol8 .= '<input class='.'inputi'.' id='.'cat'.$id.' name='.'cat[]'.' value='.$dato['CATEGORIA'].' readonly>';
    $respuestacol8 .= '<input class='.'inputd'.' id='.'pptovta'.$id.' name='.'pptovta[]'.' value='.$dato['PPTO DE VTA'].' readonly>';
    $respuestacol8 .= '<input class='.'inputd'.' id='.'ajustevta'.$id.' name='.'ajustevta[]'.' value='.$dato['VTA AJUSTADO'].'>';
    $respuestacol8 .= '<input class='.'inputd'.' id='.'pvp'.$id.' name='.'pvp[]'.' value='.$dato['PRECIO VTA'].'>';
    $respuestacol8 .= '</div>';
    //$respuesta .= '</div>';
    //$respuesta .= '<div class="col-4 form-group">';
    $respuestacol4 .= '<div class="row">';
    $respuestacol4 .= '<input class='.'inputd '.' id='.'anioL2'.$id.' name='.'anioL2[]'.' value='.$dato['ANIO'].' readonly>';
    $respuestacol4 .= '<input class='.'inputd '.' id='.'mesL2'.$id.' name='.'mesL2[]'.' value='.$mesL.' readonly>';
    $respuestacol4 .= '<input class='.'inputd'.' id='.'cat2'.$id.' name='.'cat2[]'.' value='.$dato['CATEGORIA'].' readonly>';
    $respuestacol4 .= '<input class= '.'inputd'.' id='.'plancompra'.$id.' name='.'plancompra[]'.' value='.$dato['PLAN COMPRA'].' readonly>';
    $respuestacol4 .= '<input class='.'inputd'.' id='.'ajustecompra'.$id.' name='.'ajustecompra[]'.' value='.$dato['COMPRA AJUSTADO'].'>';
    $respuestacol4 .= '<input class='.'inputd'.' id='.'pcp'.$id.' name='.'pcp[]'.' value='.$dato['COSTO COMPRA'].'>';
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
  $_SESSION['categoria'] = $_POST['categoria'];
  $_SESSION['anio'] = $_POST['anio'];

  echo $respuesta;
  sqlsrv_close( $conexion );
}else{
  echo '';
  sqlsrv_close( $conexion );
}

?>
