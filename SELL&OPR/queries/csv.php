<?php

include_once 'connsqlsrv.php';
global $conexion;
global $conn;
$actuallyear=date("Y");
$actmes=date("m");
$lastyear=$actuallyear-2;
$fecha_actual = date("d-m-Y",time());
$name_file="S&OPRB Compra General ".$fecha_actual.".xls";
$local_path=/*"C:/Users/Marco Gil/Desktop/ftp/"*/$name_file;
$datos=array();
$data_process=array();
$sqlcompra= utf8_decode( ' Select ANIO,
	   Familia,
	   Marca,
  sum(case when mes =1 then [COMPRA AJUSTADO] END ) ENERO,
	  sum(case when mes =2 then [COMPRA AJUSTADO] END ) FEBRERO,
	  sum(case when mes =3 then [COMPRA AJUSTADO] END ) MARZO,
	  sum(case when mes =4 then [COMPRA AJUSTADO] END ) ABRIL,
	  sum(case when mes =5 then [COMPRA AJUSTADO] END ) MAYO,
	  sum(case when mes =6 then [COMPRA AJUSTADO] END ) JUNIO,
	  sum(case when mes =7 then [COMPRA AJUSTADO] END ) JULIO,
	  sum(case when mes =8 then [COMPRA AJUSTADO] END ) AGOSTO,
	  sum(case when mes =9 then [COMPRA AJUSTADO] END ) SEPTIEMBRE,
	  sum(case when mes =10 then [COMPRA AJUSTADO] END ) OCTUBRE,
	  sum(case when mes =11 then [COMPRA AJUSTADO] END ) NOVIEMBRE,
	  sum(case when mes =12 then [COMPRA AJUSTADO] END ) DICIEMBRE

  FROM presupuesto_ro
  where MAKEDATE(ANIO,DAYOFYEAR(cast(CONCAT(ANIO,"'.'-'.'",MES,"'.'-'.'",01) AS DATE)))>DATE_ADD(CURDATE(), INTERVAL -DAY(CURDATE()) DAY)
  GROUP BY ANIO,
	   Familia,
	   MARCA '
);
$sqlcomprareal= utf8_decode(" declare @actaño as int , @lstaño as int, @fecha as date
declare @mes int
declare @meses  nvarchar(max)=''
declare @sql  nvarchar(max)=''
set @actaño= $actuallyear
set @lstaño= $lastyear

SET @fecha=dateadd(DD,-DAY(GETDATE()),GETDATE())
SELECT  @meses+=  QUOTENAME(d.MES)+',' FROM

(SELECT distinct case when MES =1 then 'ENERO'
			when MES =2 then 'FEBRERO'
			when MES =3 then 'MARZO'
			when MES =4 then 'ABRIL'
			when MES =5 then 'MAYO'
			when MES =6 then 'JUNIO'
			when MES =7 then 'JULIO'
			when MES =8 then 'AGOSTO'
			when MES =9 then 'SEPTIEMBRE'
			when MES =10 then 'OCTUBRE'
			when MES =11 then 'NOVIEMBRE'
			when MES =12 then 'DICIEMBRE'
		END MES,
		MES AS MESES FROM ExisFamMes
)AS D
order by D.MESES



SET @meses=LEFT(@meses,LEN(@meses)-1)



SET @SQL='


SELECT *FROM (

select
year([Fecha Registro])Anio,
Pr.Familia,
Pr.Colección,
case when MONTH([Fecha Registro]) =1 then ''ENERO''
			when MONTH([Fecha Registro]) =2 then ''FEBRERO''
			when MONTH([Fecha Registro]) =3 then ''MARZO''
			when MONTH([Fecha Registro]) =4 then ''ABRIL''
			when MONTH([Fecha Registro]) =5 then ''MAYO''
			when MONTH([Fecha Registro]) =6 then ''JUNIO''
			when MONTH([Fecha Registro]) =7 then ''JULIO''
			when MONTH([Fecha Registro]) =8 then ''AGOSTO''
			when MONTH([Fecha Registro]) =9 then ''SEPTIEMBRE''
			when MONTH([Fecha Registro]) =10 then ''OCTUBRE''
			when MONTH([Fecha Registro]) =11 then ''NOVIEMBRE''
			when MONTH([Fecha Registro]) =12 then ''DICIEMBRE''
		END MES,
convert(int,Sum(H.Cantidad)) as Compra




from [Historico factura compra] H join Producto Pr on H.[Nº referencia cruzada] collate Latin1_General_100_CI_AS =Pr.Nº
left join Proveedor as pv on pr.[Nº proveedor]=pv.[No.]  collate Latin1_General_100_CI_AS
 LEFT  JOIN
                        COLORES AS C ON Pr.Color = C.Codigo COLLATE Latin1_General_CI_AS



				  where year([Fecha Registro])>=$lastyear and  [Fecha Registro]<=dateadd(DD,-DAY(GETDATE()),GETDATE())


group by
year([Fecha Registro]),
Pr.Familia,
Pr.Colección,
case when MONTH([Fecha Registro]) =1 then ''ENERO''
			when MONTH([Fecha Registro]) =2 then ''FEBRERO''
			when MONTH([Fecha Registro]) =3 then ''MARZO''
			when MONTH([Fecha Registro]) =4 then ''ABRIL''
			when MONTH([Fecha Registro]) =5 then ''MAYO''
			when MONTH([Fecha Registro]) =6 then ''JUNIO''
			when MONTH([Fecha Registro]) =7 then ''JULIO''
			when MONTH([Fecha Registro]) =8 then ''AGOSTO''
			when MONTH([Fecha Registro]) =9 then ''SEPTIEMBRE''
			when MONTH([Fecha Registro]) =10 then ''OCTUBRE''
			when MONTH([Fecha Registro]) =11 then ''NOVIEMBRE''
			when MONTH([Fecha Registro]) =12 then ''DICIEMBRE''
		END






)AS BD


PIVOT (SUM(Compra) FOR [MES] IN ('+@meses+') )AS PVTABLE


order by ANIO'


execute sp_sqlexec @sql

--print @sql"
);
ob_clean();
function csv_export_anyway($conn1srv,$conn2mysql,$path,$sql1srv,$sql2mysql){
  $ressql=array();
  $resmysql=array();
  $csv_content="";
  $resultadosql="";
  $resultadomysql="";
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
        $resmysql=sqlsrv_query($conn2mysql,$sql2mysql);
        $i = 0;
        while ($datasql = sqlsrv_fetch_array($ressql)) {
            $datosql[$i] = $datasql;
            $i++;
        }
        $i = 0;
        while ($datamysql = sqlsrv_fetch_array($resmysql)) {
            $datosmysql[$i] = $datamysql;
            $i++;
        }
        foreach ($datosql[0] as $key => $clave) {
            if ($key != '0' and $key != is_int($key)) {
                $csv_content .= utf8_encode($key) ."\t";
            }
        }
        $csv_content = substr($csv_content, 0, strlen($csv_content) - 1) . "\r\n";
        $i = 0;
        while ($i<count($datosql)) {




            foreach ($datosql[$i] as $key => $clave) {


                switch ($key){


            case $key == ctype_digit ($key) or  $key == 0  :



                    if($clave=="" or is_null($clave) ) {$resultadosql.= 0 ."\t";}

                    else{$resultadosql.=  $clave."\t";}
                    break;






            }


        }

        $resultadosql = substr($resultadosql, 0, strlen($resultadosql) - 1) . "\r\n";

        $i++;
}




        $csv_content.=$resultadosql;


        $i = 0;
        while ($i<count($datosmysql)) {
          foreach ($datosmysql[$i] as $key => $clave) {
            switch ($key){
                case $key == 0 :
                    $resultadomysql.=  $clave."\t";
                    break;
                case $key == ctype_digit ($key)  :
                    $resultadomysql.=  $clave."\t";
                    break;
            }
        }
          $resultadomysql = substr($resultadomysql, 0, strlen($resultadomysql) - 1) . "\r\n";
          $i++;
        }
        $csv_content.=$resultadomysql;
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
csv_export_anyway($conexion,$conexion,$local_path,$sqlcomprareal,$sqlcompra);



 ?>
