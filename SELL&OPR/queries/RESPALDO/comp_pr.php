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
$sqlcompra= utf8_decode( " 
Select ANIO,
    Categoria,
'CompraPPTO'AS BASE,
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

  GROUP BY ANIO,
           
    Categoria,
	   Familia,
	   MARCA

union all 


Select ANIO,
       
    Categoria,
'VentaPPTO'AS BASE,
	   Familia,
	   Marca,
  sum(case when mes =1 then [VTA AJUSTADO] END ) ENERO,
	  sum(case when mes =2 then [VTA AJUSTADO] END ) FEBRERO,
	  sum(case when mes =3 then [VTA AJUSTADO] END ) MARZO,
	  sum(case when mes =4 then [VTA AJUSTADO] END ) ABRIL,
	  sum(case when mes =5 then [VTA AJUSTADO] END ) MAYO,
	  sum(case when mes =6 then [VTA AJUSTADO] END ) JUNIO,
	  sum(case when mes =7 then [VTA AJUSTADO] END ) JULIO,
	  sum(case when mes =8 then [VTA AJUSTADO] END ) AGOSTO,
	  sum(case when mes =9 then [VTA AJUSTADO] END ) SEPTIEMBRE,
	  sum(case when mes =10 then [VTA AJUSTADO] END ) OCTUBRE,
	  sum(case when mes =11 then [VTA AJUSTADO] END ) NOVIEMBRE,
	  sum(case when mes =12 then [VTA AJUSTADO] END ) DICIEMBRE

  FROM presupuesto_ro

  GROUP BY ANIO,
           
    Categoria,
	   Familia,
	   MARCA "  );
$sqlcomprareal= utf8_decode(" 
  
declare @actaño as int , @lstaño as int, @fecha as date
declare @mes int
declare @meses  nvarchar(max)=''
declare @sql  nvarchar(max)=''

set @mes=1
SET @fecha=dateadd(DD,-DAY(GETDATE()),GETDATE())
SELECT  @meses+=  QUOTENAME(d.MES)+',' FROM

(

SELECT distinct case when MES =1 then 'ENERO'
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
		MES AS MESES FROM ped_compr
)AS D
order by D.MESES



SET @meses=LEFT(@meses,LEN(@meses)-1)



SET @SQL='
SELECT *FROM (

select YEAR([Fecha recepción esperada]) Año ,
    pl.tipo Categoria,''COMPRA'' collate Modern_Spanish_CI_AS as BASE,pl.familia collate Modern_Spanish_CI_AS familia,pl.Colección collate Modern_Spanish_CI_AS as Marca,
 case when Month([Fecha recepción esperada]) =1 then ''ENERO''
			when Month([Fecha recepción esperada]) =2 then ''FEBRERO''
			when Month([Fecha recepción esperada]) =3 then ''MARZO''
			when Month([Fecha recepción esperada]) =4 then ''ABRIL''
			when Month([Fecha recepción esperada]) =5 then ''MAYO''
			when Month([Fecha recepción esperada]) =6 then ''JUNIO''
			when Month([Fecha recepción esperada]) =7 then ''JULIO''
			when Month([Fecha recepción esperada]) =8 then ''AGOSTO''
			when Month([Fecha recepción esperada]) =9 then ''SEPTIEMBRE''
			when Month([Fecha recepción esperada]) =10 then ''OCTUBRE''
			when Month([Fecha recepción esperada]) =11 then ''NOVIEMBRE''
			when Month([Fecha recepción esperada]) =12 then ''DICIEMBRE''
		END collate Modern_Spanish_CI_AS MES,
SUM(case when rc.[Cantidad facturada] is null or rc.[Cantidad facturada] =0 
				then [Cantidad recibida no facturada] 
				else rc.[Cantidad facturada] end) as facturado
FROM [Recepciones de Compra] as rc LEFT JOIN PRODUCTO_LOGISTICA  as pl
on rc.[Nº referencia cruzada]collate Modern_Spanish_CI_AS =pl.Nº 
where [Fecha recepción esperada]>=''20180101''
  AND [Cód. almacén] NOT IN(''R098'')
				  and Familia NOT IN ('''', ''ACCESORIOS'', ''BERMUDA'', ''BLAZER D'', ''BLUSA'', ''BOLSA'', ''BORDADO'', ''CAMISA'', ''CHALECOD'', ''CINTA'', ''CONJUNTO'', ''COOR/PANTS'', ''CORB&MAN'', ''CORBATERO'', ''EMPAQUE'', ''EQUIPAJE'', 
                         ''FAJA&MONO'', ''FALDA'', ''FALDA DAMA'', ''GORRA'', ''HABILITACION'', ''KITSMOKREN'', ''MAQUILA'', ''PANTALON'', ''PANTALON D'', ''PANTALON DAMA'', ''PANTALOND'', ''PAQUETE'', ''PIJAMA'', ''ROPA INT'', ''SACO'', ''SACO DAMA'', ''SLACK'', 
                         ''SUDADERA'', ''TELA'', ''TELAS'', ''VARIOS'')
group by YEAR([Fecha recepción esperada]) ,
    pl.Tipo,pl.familia,pl.Colección,
case when Month([Fecha recepción esperada]) =1 then ''ENERO''
			when Month([Fecha recepción esperada]) =2 then ''FEBRERO''
			when Month([Fecha recepción esperada]) =3 then ''MARZO''
			when Month([Fecha recepción esperada]) =4 then ''ABRIL''
			when Month([Fecha recepción esperada]) =5 then ''MAYO''
			when Month([Fecha recepción esperada]) =6 then ''JUNIO''
			when Month([Fecha recepción esperada]) =7 then ''JULIO''
			when Month([Fecha recepción esperada]) =8 then ''AGOSTO''
			when Month([Fecha recepción esperada]) =9 then ''SEPTIEMBRE''
			when Month([Fecha recepción esperada]) =10 then ''OCTUBRE''
			when Month([Fecha recepción esperada]) =11 then ''NOVIEMBRE''
			when Month([Fecha recepción esperada]) =12 then ''DICIEMBRE''
		END
		union all
select Año as Año, Categoria,''Venta''AS BASE,Familia,Colección as Marca,
	    case when MES =1 then ''ENERO''when MES =2 then ''FEBRERO''when MES =3 then ''MARZO''when MES =4 then ''ABRIL''when MES =5 then ''MAYO''
			when MES =6 then ''JUNIO''when MES =7 then ''JULIO''when MES =8 then ''AGOSTO''when MES =9 then ''SEPTIEMBRE''when MES =10 then ''OCTUBRE''
			when MES =11 then ''NOVIEMBRE''when MES =12 then ''DICIEMBRE''END MES,SUM(Venta)Ventas
  FROM VtaFamMesSOP
  where año>=2018
  GROUP BY Año,Categoria,Familia,Colección,
	   case when MES =1 then ''ENERO''when MES =2 then ''FEBRERO''when MES =3 then ''MARZO''when MES =4 then ''ABRIL''when MES =5 then ''MAYO''
			when MES =6 then ''JUNIO''when MES =7 then ''JULIO''when MES =8 then ''AGOSTO''when MES =9 then ''SEPTIEMBRE''when MES =10 then ''OCTUBRE''
			when MES =11 then ''NOVIEMBRE''when MES =12 then ''DICIEMBRE''end

)AS BD
PIVOT (SUM(facturado) FOR [MES] IN ('+@meses+') )AS PVTABLE
order by Año'


execute sp_sqlexec @sql

--print @sql
  
  "
);
$sqlpedidosreal= utf8_decode(" 
  
declare @actaño as int , @lstaño as int, @fecha as date
declare @mes int
declare @meses  nvarchar(max)=''
declare @sql  nvarchar(max)=''

set @mes=1
SET @fecha=dateadd(DD,-DAY(GETDATE()),GETDATE())
SELECT  @meses+=  QUOTENAME(d.MES)+',' FROM

(

SELECT distinct case when MES =1 then 'ENERO'
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
		MES AS MESES FROM ped_compr
)AS D
order by D.MESES



SET @meses=LEFT(@meses,LEN(@meses)-1)



SET @SQL='
SELECT *FROM (
select Año as Año,
    Categoria,''PEDIDO''AS BASE,Familia,Marca,
	    case when MES =1 then ''ENERO''when MES =2 then ''FEBRERO''when MES =3 then ''MARZO''when MES =4 then ''ABRIL''when MES =5 then ''MAYO''when MES =6 then ''JUNIO''when MES =7 then ''JULIO''when MES =8 then ''AGOSTO''
		when MES =9 then ''SEPTIEMBRE''when MES =10 then ''OCTUBRE''when MES =11 then ''NOVIEMBRE''when MES =12 then ''DICIEMBRE''
		END MES,SUM(Cantidad)Pedido
  FROM [ped_compr] where   Familia NOT IN ( '''', ''ACCESORIOS'', ''BERMUDA'', ''BLAZER D'', ''BLUSA'', ''BOLSA'', ''BORDADO'', ''CAMISA'', ''CHALECOD'', ''CINTA'', ''CONJUNTO'', ''COOR/PANTS'', ''CORB&MAN'', ''CORBATERO'', ''EMPAQUE'', ''EQUIPAJE'', 
                         ''FAJA&MONO'', ''FALDA'', ''FALDA DAMA'', ''GORRA'', ''HABILITACION'', ''KITSMOKREN'', ''MAQUILA'', ''PANTALON'', ''PANTALON D'', ''PANTALON DAMA'', ''PANTALOND'', ''PAQUETE'', ''PIJAMA'', ''ROPA INT'', ''SACO'', ''SACO DAMA'', ''SLACK'', 
                         ''SUDADERA'', ''TELA'', ''TELAS'', ''VARIOS'')
  GROUP BY Año,
    Categoria,Familia,Marca,
	    case when MES =1 then ''ENERO''when MES =2 then ''FEBRERO''when MES =3 then ''MARZO''when MES =4 then ''ABRIL''when MES =5 then ''MAYO''when MES =6 then ''JUNIO''when MES =7 then ''JULIO''
			when MES =8 then ''AGOSTO''when MES =9 then ''SEPTIEMBRE''when MES =10 then ''OCTUBRE''when MES =11 then ''NOVIEMBRE''when MES =12 then ''DICIEMBRE''
		end
		

)AS BD
PIVOT (SUM(Pedido) FOR [MES] IN ('+@meses+') )AS PVTABLE
order by Año'


execute sp_sqlexec @sql

--print @sql
  
  "
);
$sqlcomprareal2= utf8_decode(" 
  
declare @actaño as int , @lstaño as int, @fecha as date
declare @mes int
declare @meses  nvarchar(max)=''
declare @sql  nvarchar(max)=''

set @mes=1
SET @fecha=dateadd(DD,-DAY(GETDATE()),GETDATE())
SELECT  @meses+=  QUOTENAME(d.MES)+',' FROM

(

SELECT distinct case when MES =1 then 'ENERO'
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
		MES AS MESES FROM ped_compr
)AS D
order by D.MESES



SET @meses=LEFT(@meses,LEN(@meses)-1)



SET @SQL='
SELECT *FROM (

select YEAR([Fecha registro]) Año ,pl.Tipo as Categoria,''RECEPCION'' collate Modern_Spanish_CI_AS as BASE,pl.familia collate Modern_Spanish_CI_AS familia,pl.Colección collate Modern_Spanish_CI_AS as Marca,
 case       when Month([Fecha registro]) =1 then ''ENERO''
			when Month([Fecha registro]) =2 then ''FEBRERO''
			when Month([Fecha registro]) =3 then ''MARZO''
			when Month([Fecha registro]) =4 then ''ABRIL''
			when Month([Fecha registro]) =5 then ''MAYO''
			when Month([Fecha registro]) =6 then ''JUNIO''
			when Month([Fecha registro]) =7 then ''JULIO''
			when Month([Fecha registro]) =8 then ''AGOSTO''
			when Month([Fecha registro]) =9 then ''SEPTIEMBRE''
			when Month([Fecha registro]) =10 then ''OCTUBRE''
			when Month([Fecha registro]) =11 then ''NOVIEMBRE''
			when Month([Fecha registro]) =12 then ''DICIEMBRE''
		END collate Modern_Spanish_CI_AS MES,
SUM(case when rc.[Cantidad facturada] is null or rc.[Cantidad facturada] =0 
				then [Cantidad recibida no facturada] 
				else rc.[Cantidad facturada] end) as facturado
FROM [Recepciones de Compra] as rc LEFT JOIN PRODUCTO_LOGISTICA  as pl
on rc.[Nº referencia cruzada]collate Modern_Spanish_CI_AS =pl.Nº 
where [Fecha registro]>=''20180101'' and  [Cód. almacén] not like ''RPH%''
and  [Cód. almacén] <> ''R098'' and pl.subfamilia not in(''SM'')  
and Familia NOT IN ('''', ''ACCESORIOS'', ''BERMUDA'', ''BLAZER D'', ''BLUSA'', ''BOLSA'', ''BORDADO'', ''CAMISA'', ''CHALECOD'', ''CINTA'', ''CONJUNTO'', ''COOR/PANTS'', ''CORB&MAN'', ''CORBATERO'', ''EMPAQUE'', ''EQUIPAJE'', 
                         ''FAJA&MONO'', ''FALDA'', ''FALDA DAMA'', ''GORRA'', ''HABILITACION'', ''KITSMOKREN'', ''MAQUILA'', ''PANTALON'', ''PANTALON D'', ''PANTALON DAMA'', ''PANTALOND'', ''PAQUETE'', ''PIJAMA'', ''ROPA INT'', ''SACO'', ''SACO DAMA'', ''SLACK'', 
                         ''SUDADERA'', ''TELA'', ''TELAS'', ''VARIOS'')
group by YEAR([Fecha registro]) ,pl.Tipo,pl.familia,pl.Colección,
case when Month([Fecha registro]) =1 then ''ENERO''
			when Month([Fecha registro]) =2 then ''FEBRERO''
			when Month([Fecha registro]) =3 then ''MARZO''
			when Month([Fecha registro]) =4 then ''ABRIL''
			when Month([Fecha registro]) =5 then ''MAYO''
			when Month([Fecha registro]) =6 then ''JUNIO''
			when Month([Fecha registro]) =7 then ''JULIO''
			when Month([Fecha registro]) =8 then ''AGOSTO''
			when Month([Fecha registro]) =9 then ''SEPTIEMBRE''
			when Month([Fecha registro]) =10 then ''OCTUBRE''
			when Month([Fecha registro]) =11 then ''NOVIEMBRE''
			when Month([Fecha registro]) =12 then ''DICIEMBRE''
		END
union all
select Año as Año,categoria,''Importe''AS BASE,Familia,Colección as Marca,
	    case when MES =1 then ''ENERO''when MES =2 then ''FEBRERO''when MES =3 then ''MARZO''when MES =4 then ''ABRIL''when MES =5 then ''MAYO''
			when MES =6 then ''JUNIO''when MES =7 then ''JULIO''when MES =8 then ''AGOSTO''when MES =9 then ''SEPTIEMBRE''when MES =10 then ''OCTUBRE''
			when MES =11 then ''NOVIEMBRE''when MES =12 then ''DICIEMBRE''END MES,SUM(Importe)Importe
  FROM VtaFamMesSOP
  where año>=2018
  GROUP BY Año,Categoria,Familia,Colección,
	   case when MES =1 then ''ENERO''when MES =2 then ''FEBRERO''when MES =3 then ''MARZO''when MES =4 then ''ABRIL''when MES =5 then ''MAYO''
			when MES =6 then ''JUNIO''when MES =7 then ''JULIO''when MES =8 then ''AGOSTO''when MES =9 then ''SEPTIEMBRE''when MES =10 then ''OCTUBRE''
			when MES =11 then ''NOVIEMBRE''when MES =12 then ''DICIEMBRE''end
	

)AS BD
PIVOT (SUM(facturado) FOR [MES] IN ('+@meses+') )AS PVTABLE
order by Año'


execute sp_sqlexec @sql

--print @sql
  
  "
);

function csv_export_anyway($conn1srv,$conn2mysql,$conn3srv,$path,$sql1srv,$sql2mysq,$sql2srvl,$sql3srvl){
  $ressql=array();
  $ressql2=array();
  $ressql3=array();
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
        $ressql2=sqlsrv_query($conn1srv,$sql2srvl);
        $resmysql=sqlsrv_query($conn2mysql,$sql2mysq);
        $ressql3=sqlsrv_query($conn3srv,$sql3srvl);
        $i = 0;
        while ($datasql = sqlsrv_fetch_array($ressql)) {
            $datosql[$i] = $datasql;
            $i++;
        }
        $i = 0;
        while ($datasql2 = sqlsrv_fetch_array($ressql2)) {
            $datosql2[$i] = $datasql2;
            $i++;
        }
        $i = 0;
        while ($datamysql = sqlsrv_fetch_array($resmysql)) {
            $datosmysql[$i] = $datamysql;
            $i++;
        }
        $i = 0;
        while ($datasql3 = sqlsrv_fetch_array($ressql3)) {
            $datosql3[$i] = $datasql3;
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
        $i = 0;
        while ($i<count($datosql2)) {


            foreach ($datosql2[$i] as $key => $clave) {


                switch ($key){


                    case $key == ctype_digit ($key) or  $key == 0  :



                        if($clave=="" or is_null($clave) ) {$resultadosql2.= 0 ."\t";}

                        else{$resultadosql2.=  $clave."\t";}
                        break;






                }


            }

            $resultadosql2 = substr($resultadosql2, 0, strlen($resultadosql2) - 1) . "\r\n";

            $i++;
        }
        $i = 0;
        while ($i<count($datosql3)) {




            foreach ($datosql3[$i] as $key => $clave) {


                switch ($key){


                    case $key == ctype_digit ($key) or  $key == 0  :



                        if($clave=="" or is_null($clave) ) {$resultadosql3.= 0 ."\t";}

                        else{$resultadosql3.=  $clave."\t";}
                        break;


                }


            }

            $resultadosql3 = substr($resultadosql3, 0, strlen($resultadosql3) - 1) . "\r\n";

            $i++;
        }
        $csv_content.=$resultadosql;
        $csv_content.=$resultadosql2;
        $csv_content.=$resultadosql3;

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
        ob_clean();
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
csv_export_anyway($conexion,$conexion,$conexion,$local_path,$sqlcomprareal,$sqlcompra,$sqlcomprareal2,$sqlpedidosreal);


 ?>
