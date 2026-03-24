<?php

include_once 'connsqlsrv.php';
global $conexion;
global $conn;
$actuallyear=date("Y");
$actmes=date("m");
$lastyear=$actuallyear-1;
$fecha_actual = date("d-m-Y",time());
$name_file="S&OPRB Telas General ".$fecha_actual.".xls";
$local_path=$name_file;
$datos=array();
$data_process=array();
$sqlpedido= utf8_decode( "


select  [No.Pedido]
      ,[Sku]
      ,[Familia]
      ,[Marca]
      ,[Temporada]
      ,[Cód. producto proveedor]
      ,[Codigo]
      ,[Color]
      ,[Proveedor]
      ,[Pedido]
      ,[Facturado]
      ,[Pendientes]
      ,[Año]
      ,[Mes]
	  ,CONVERT (varchar,[Primera Entrega],105)[Primera Entrega]
	  ,CONVERT (varchar,[Ultima Entrega],105)[Ultima Entrega]
	  ,CONVERT (varchar,[FechaEsperada],105)[FechaEsperada]
      ,[Categoria]
      ,[PrecioCosto]
      ,[Grupo Serie]
      ,[PLModel]
      ,[UnidadMedida]
      ,[Po]
      ,[Moneda]
	  
	  from (
select * from dbVestimagen.dbo.ped_compr
union all 
select * from dbHabers.dbo.ped_compr)as lvl1





"
);

ob_clean();



function csv_export_anyway($conn1srv,$path,$sql1srv){
  $ressql=array();
  $csv_content="";
  $resultadosql="";
  $csv_filename =$path;
  $actualy=date("Y");
  $actualm=date("m");
  $contador=0;
    if(!$ressql=sqlsrv_query($conn1srv,$sql1srv) ) {
        die();
        echo "Lo sentimos no se ah obtenido ningun dato"."\n\n";
        $alerta=0;
    }
    else {

        $i = 0;
        while ($datasql = sqlsrv_fetch_array($ressql)) {
            $datosql[$i] = $datasql;
            $i++;
        }

        foreach ($datosql[0] as $key => $clave) {
            if ($key != '0' and $key != is_int($key)) {
                $csv_content .= utf8_encode($key) ."\t";
            }
        }
        $csv_content = $csv_content . "\n";



$filas=count($datosql);

$columnas=count($datosql[0])/2;


      for($i=0;$i<$filas;$i++){
        for($j=0;$j<$columnas;$j++){
          $datosql[$i][$j] = preg_replace("/[\r\n|\n|\r]+/", "", $datosql[$i][$j]);

        if($datosql[$i][$j]=="" or is_null($datosql[$i][$j]) ) { $resultadosql.= "" ."\t";}

         else{ $resultadosql.= $datosql[$i][$j] ."\t"; }

        }
$resultadosql .= "\n";

      }



/*

        $i = 0;
        while ($i<count($datosql)) {
            foreach ($datosql[$i] as $key => $clave) {
               switch ($key){
                    case $key == ctype_digit ($key) or  $key == 0  :
                    if($clave=="" or is_null($clave) ) { $resultadosql.= 0 ."\t";}
                    else{$resultadosql.=  $clave."\t";}
                  break;
            }
        }


        $resultadosql .=  "\n";*/

      //  $i++;

    //}




        $csv_content.=$resultadosql;


        $alerta=1;

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Type: application/octet-stream');
        header("Content-Transfer-Encoding: Binary");
        header("Content-disposition: attachment; filename=".$csv_filename);
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private", false);

        $outputBuffer = fopen("php://output",'w');
        fputs($outputBuffer,$csv_content);
        fclose($outputBuffer);
}
          return $alerta;
}

csv_export_anyway($conexion,$local_path,$sqlpedido);



 ?>
