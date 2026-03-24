<?php
include "connsqlsrv.php";
global $conexion;
error_reporting(E_ERROR);

$i=0;

//se genera la consulta



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

if(empty($_POST['year'])or $_POST['year']=='' ){
    $year='';
}
else{
    $year= $_POST['year'];
}


if(empty($_POST['temp'])or $_POST['temp']=='' ){
    $tempo='';
}
else{
    if($_POST['temp'] !== "%"){

        $tempo="in (".$_POST['temp'].")";
        
        
        //IF($tempo=="in('BASICO')"){
            $modelo="in(".$_POST['modelos'].")";
            $color="in(".$_POST['colores'].")";
      //  }
        
    }
    else{
        $tempo="like  '%' ";
    }

}


/*
$familia='ABRIGO';
$marca='ROBERTS RE';
$year='2019';
*/
//variables

$rawentradas=array();
$rawentradaspd=array();
$rawentradasly=array();
$rawpedidosay=array();
$rawpedidosly=array();
$rawpedidosny=array();
$rawpendientes=array();
$pedidosay=array();
$pedidosly=array();
$pedidosny=array();
$entradas=array();
$entradaspd=array();
$pendientes=array();
$namecolumn='';
$nombresmeses=array();

$matrizpedidoay="";
$matrizpedidony="";
$matrizpedidoly="";
$matrizpendiente="";
$matrizentrada="";
$matrizdif="";

$totalay="";
$totally="";
$totalny="";
$totalpen="";
$totalen="";
$totaldif=0;

$nextyear=($year+1);
$añoanterior=($year-1);
$actuallyear=date("Y");
$mes=date("n");
if ($year<$actuallyear){
    $mes=12;
}
else{
    $mes=date("n");
}

//funciones(executan los queries y se acumulan en arreglos)
function execonsultasqlsrv($query,$conect,$res){
    $i=0;
    if(!$result =sqlsrv_query($conect, $query)) {
        die();
        //echo "Error al registrarse";

    }


//Resultado de consulta
    while($row = sqlsrv_fetch_array($result))

    {





        $res[$i]=$row;

        $i++;







    }



    return $res;
}
function execonsultamysql($query,$conect,$res){
    $i=0;

    if(!$resultv =mysqli_query( $conect , $query)) {
        die();
        echo "Error al registrarse";

    }
//Resultado de consulta



    while($rowv = mysqli_fetch_array($resultv))
    {
        $res[$i] = $rowv ;

        $i++;

    }


    return $res;
}
function grafica($largo,$input1,$input2,$input3,$pivotinvf,$output) {


    for($i=0 ;$i<$largo;$i++){
        $pivotinvf[$i][0]=$input1[$i];
        $pivotinvf[$i][1]=$input2[$i];
        $pivotinvf[$i][2]=$input3[$i];

    }

    for($i=0;$i<$largo;$i++){


        $output.="[";

        for($j=0;$j<3;$j++){

            if($j==2)
            {
                $output=$output. $pivotinvf[$i][$j]."],";

            }
            else{

                $output=$output.$pivotinvf[$i][$j].",";

            }





        }






    }
    return $output;
}



//queries
IF( $tempo!=="in ('BASICO')"){
  
$sql_pedidosay=utf8_decode( "

SELECT SUM(CASE WHEN MES=1 THEN CANTIDAD END)ENERO,
        SUM(CASE WHEN MES=2 THEN CANTIDAD END)FEBRERO,
        SUM(CASE WHEN MES=3 THEN CANTIDAD END)MARZO,
        SUM(CASE WHEN MES=4 THEN CANTIDAD END)ABRIL,
        SUM(CASE WHEN MES=5 THEN CANTIDAD END)MAYO,
        SUM(CASE WHEN MES=6 THEN CANTIDAD END)JUNIO,
        SUM(CASE WHEN MES=7 THEN CANTIDAD END)JULIO,
        SUM(CASE WHEN MES=8 THEN CANTIDAD END)AGOSTO,
        SUM(CASE WHEN MES=9 THEN CANTIDAD END)SEPTIEMBRE,
        SUM(CASE WHEN MES=10 THEN CANTIDAD END)OCTUBRE,
        SUM(CASE WHEN MES=11 THEN CANTIDAD END)NOVIEMBRE,
        SUM(CASE WHEN MES=12 THEN CANTIDAD END)DICIEMBRE



 from ped_compr left join (select distinct Nº,TIPO from PRODUCTO_LOGISTICA ) as cat on ped_compr.SKU=cat.Nº collate SQL_Latin1_General_CP1_CI_AS





WHERE Año ='$year' AND familia $familia  AND  CASE WHEN Marca IN ('AQUAVIVA', 'ANDREA NER', 'ARGENTO', 'BORGO 28', 'BUGATTI', 'C.1881', 'CUSERI', 'DEWIN', 'DONNAKARAN', 'HL LIBERTY', 'ENGLISH L', 'EXIGO', 'FACIS', 'FACONNABLE',
                         'FLORSHEIM', 'FUENTECAPA', 'G. BEENE', 'G.ARMANI', 'HL SARTORI', 'HL SUMISUR', 'JDEMUCHA', 'JOSEPH ABB', 'LA TORRE', 'LAMBERTI', 'LUBIAM', 'M.PIQUERA', 'MARCELLO M', 'MICHAELKOR',
                         'MOSCHINO', 'NATURA B', 'NAUTICA', 'NORTH POLE', 'OFFSET', 'OM', 'PAL ZILERI', 'PATRICIA P', 'PATRIZIA P', 'R. GRAHAM', 'RCAVALLI', 'SAFETY SHI', 'SAN REMO', 'SIDI EXECU', 'SIDIBASICO', 'SIDIOSW', 'TORRAS',
                         'TRAPPER', 'VALENTINO', 'VERSACE') THEN 'OM' WHEN Marca IN ('SIDI ORIZZ', 'HL SLIM FI') THEN 'HL SLIM FI' WHEN Marca IN ('H.LIFE') THEN 'HIGH LIFE' ELSE Marca END   $marca and Familia NOT IN ('', 'ACCESORIOS', 'BERMUDA', 'BLAZER D', 'BLUSA', 'BOLSA', 'BORDADO', 'CAMISA', 'CHALECOD', 'CINTA', 'CONJUNTO', 'COOR/PANTS', 'CORB&MAN', 'CORBATERO', 'EMPAQUE', 'EQUIPAJE', 
                         'FAJA&MONO', 'FALDA', 'FALDA DAMA', 'GORRA', 'HABILITACION', 'KITSMOKREN', 'MAQUILA', 'PANTALON', 'PANTALON D', 'PANTALON DAMA', 'PANTALOND', 'PAQUETE', 'PIJAMA', 'ROPA INT', 'SACO', 'SACO DAMA', 'SLACK', 
                         'SUDADERA', 'TELA', 'TELAS', 'VARIOS')


and cat.tipo $tempo
and ped_compr.Temporada not in ('SM','212','PV25P')
and ped_compr.Almacen not in ('R053','','R098')


");
$sql_pedidosly=utf8_decode( "
SELECT SUM(CASE WHEN MES=1 THEN CANTIDAD END)ENERO,
        SUM(CASE WHEN MES=2 THEN CANTIDAD END)FEBRERO,
        SUM(CASE WHEN MES=3 THEN CANTIDAD END)MARZO,
        SUM(CASE WHEN MES=4 THEN CANTIDAD END)ABRIL,
        SUM(CASE WHEN MES=5 THEN CANTIDAD END)MAYO,
        SUM(CASE WHEN MES=6 THEN CANTIDAD END)JUNIO,
        SUM(CASE WHEN MES=7 THEN CANTIDAD END)JULIO,
        SUM(CASE WHEN MES=8 THEN CANTIDAD END)AGOSTO,
        SUM(CASE WHEN MES=9 THEN CANTIDAD END)SEPTIEMBRE,
        SUM(CASE WHEN MES=10 THEN CANTIDAD END)OCTUBRE,
        SUM(CASE WHEN MES=11 THEN CANTIDAD END)NOVIEMBRE,
        SUM(CASE WHEN MES=12 THEN CANTIDAD END)DICIEMBRE



 from ped_compr left join (select distinct Nº,TIPO from PRODUCTO_LOGISTICA ) as cat on ped_compr.SKU=cat.Nº collate SQL_Latin1_General_CP1_CI_AS





WHERE Año ='$añoanterior' AND familia $familia AND CASE WHEN Marca IN ('AQUAVIVA', 'ANDREA NER', 'ARGENTO', 'BORGO 28', 'BUGATTI', 'C.1881', 'CUSERI', 'DEWIN', 'DONNAKARAN', 'HL LIBERTY', 'ENGLISH L', 'EXIGO', 'FACIS', 'FACONNABLE',
                         'FLORSHEIM', 'FUENTECAPA', 'G. BEENE', 'G.ARMANI', 'HL SARTORI', 'HL SUMISUR', 'JDEMUCHA', 'JOSEPH ABB', 'LA TORRE', 'LAMBERTI', 'LUBIAM', 'M.PIQUERA', 'MARCELLO M', 'MICHAELKOR',
                         'MOSCHINO', 'NATURA B', 'NAUTICA', 'NORTH POLE', 'OFFSET', 'OM', 'PAL ZILERI', 'PATRICIA P', 'PATRIZIA P', 'R. GRAHAM', 'RCAVALLI', 'SAFETY SHI', 'SAN REMO', 'SIDI EXECU', 'SIDIBASICO', 'SIDIOSW', 'TORRAS',
                         'TRAPPER', 'VALENTINO', 'VERSACE') THEN 'OM' WHEN Marca IN ('SIDI ORIZZ', 'HL SLIM FI') THEN 'HL SLIM FI' WHEN Marca IN ('H.LIFE') THEN 'HIGH LIFE' ELSE Marca END   $marca and Familia NOT IN ('', 'ACCESORIOS', 'BERMUDA', 'BLAZER D', 'BLUSA', 'BOLSA', 'BORDADO', 'CAMISA', 'CHALECOD', 'CINTA', 'CONJUNTO', 'COOR/PANTS', 'CORB&MAN', 'CORBATERO', 'EMPAQUE', 'EQUIPAJE', 
                         'FAJA&MONO', 'FALDA', 'FALDA DAMA', 'GORRA', 'HABILITACION', 'KITSMOKREN', 'MAQUILA', 'PANTALON', 'PANTALON D', 'PANTALON DAMA', 'PANTALOND', 'PAQUETE', 'PIJAMA', 'ROPA INT', 'SACO', 'SACO DAMA', 'SLACK', 
                         'SUDADERA', 'TELA', 'TELAS', 'VARIOS')

and cat.tipo $tempo
and ped_compr.Temporada not in ('SM','212','PV25P')
and ped_compr.Almacen not in ('R053','','R098')
");
$sql_pedidosny=utf8_decode( "
SELECT SUM(CASE WHEN MES=1 THEN CANTIDAD END)ENERO,
        SUM(CASE WHEN MES=2 THEN CANTIDAD END)FEBRERO,
        SUM(CASE WHEN MES=3 THEN CANTIDAD END)MARZO,
        SUM(CASE WHEN MES=4 THEN CANTIDAD END)ABRIL,
        SUM(CASE WHEN MES=5 THEN CANTIDAD END)MAYO,
        SUM(CASE WHEN MES=6 THEN CANTIDAD END)JUNIO,
        SUM(CASE WHEN MES=7 THEN CANTIDAD END)JULIO,
        SUM(CASE WHEN MES=8 THEN CANTIDAD END)AGOSTO,
        SUM(CASE WHEN MES=9 THEN CANTIDAD END)SEPTIEMBRE,
        SUM(CASE WHEN MES=10 THEN CANTIDAD END)OCTUBRE,
        SUM(CASE WHEN MES=11 THEN CANTIDAD END)NOVIEMBRE,
        SUM(CASE WHEN MES=12 THEN CANTIDAD END)DICIEMBRE



 from ped_compr left join (select distinct Nº,TIPO from PRODUCTO_LOGISTICA ) as cat on ped_compr.SKU=cat.Nº collate SQL_Latin1_General_CP1_CI_AS





WHERE Año ='$nextyear' AND familia $familia AND CASE WHEN Marca IN ('AQUAVIVA', 'ANDREA NER', 'ARGENTO', 'BORGO 28', 'BUGATTI', 'C.1881', 'CUSERI', 'DEWIN', 'DONNAKARAN', 'HL LIBERTY', 'ENGLISH L', 'EXIGO', 'FACIS', 'FACONNABLE',
                         'FLORSHEIM', 'FUENTECAPA', 'G. BEENE', 'G.ARMANI', 'HL SARTORI', 'HL SUMISUR', 'JDEMUCHA', 'JOSEPH ABB', 'LA TORRE', 'LAMBERTI', 'LUBIAM', 'M.PIQUERA', 'MARCELLO M', 'MICHAELKOR',
                         'MOSCHINO', 'NATURA B', 'NAUTICA', 'NORTH POLE', 'OFFSET', 'OM', 'PAL ZILERI', 'PATRICIA P', 'PATRIZIA P', 'R. GRAHAM', 'RCAVALLI', 'SAFETY SHI', 'SAN REMO', 'SIDI EXECU', 'SIDIBASICO', 'SIDIOSW', 'TORRAS',
                         'TRAPPER', 'VALENTINO', 'VERSACE') THEN 'OM' WHEN Marca IN ('SIDI ORIZZ', 'HL SLIM FI') THEN 'HL SLIM FI' WHEN Marca IN ('H.LIFE') THEN 'HIGH LIFE' ELSE Marca END   $marca and Familia NOT IN ('', 'ACCESORIOS', 'BERMUDA', 'BLAZER D', 'BLUSA', 'BOLSA', 'BORDADO', 'CAMISA', 'CHALECOD', 'CINTA', 'CONJUNTO', 'COOR/PANTS', 'CORB&MAN', 'CORBATERO', 'EMPAQUE', 'EQUIPAJE', 
                         'FAJA&MONO', 'FALDA', 'FALDA DAMA', 'GORRA', 'HABILITACION', 'KITSMOKREN', 'MAQUILA', 'PANTALON', 'PANTALON D', 'PANTALON DAMA', 'PANTALOND', 'PAQUETE', 'PIJAMA', 'ROPA INT', 'SACO', 'SACO DAMA', 'SLACK', 
                         'SUDADERA', 'TELA', 'TELAS', 'VARIOS')
                         AND Almacen NOT IN('R098')
and cat.tipo $tempo
and ped_compr.Temporada not in ('SM','212','PV25P')
and ped_compr.Almacen not in ('R053','','R098')

");
$sql_pendientes=utf8_decode( "



SELECT SUM(CASE WHEN MES=1 THEN Pendiente END)ENERO,
        SUM(CASE WHEN MES=2 THEN Pendiente END)FEBRERO,
        SUM(CASE WHEN MES=3 THEN Pendiente END)MARZO,
        SUM(CASE WHEN MES=4 THEN Pendiente END)ABRIL,
        SUM(CASE WHEN MES=5 THEN Pendiente END)MAYO,
        SUM(CASE WHEN MES=6 THEN Pendiente END)JUNIO,
        SUM(CASE WHEN MES=7 THEN Pendiente END)JULIO,
        SUM(CASE WHEN MES=8 THEN Pendiente END)AGOSTO,
        SUM(CASE WHEN MES=9 THEN Pendiente END)SEPTIEMBRE,
        SUM(CASE WHEN MES=10 THEN Pendiente END)OCTUBRE,
        SUM(CASE WHEN MES=11 THEN Pendiente END)NOVIEMBRE,
        SUM(CASE WHEN MES=12 THEN Pendiente END)DICIEMBRE



 from ped_compr left join (select distinct Nº,TIPO from PRODUCTO_LOGISTICA ) as cat on ped_compr.SKU=cat.Nº collate SQL_Latin1_General_CP1_CI_AS




WHERE Año ='$year' AND familia $familia AND CASE WHEN Marca IN ('AQUAVIVA', 'ANDREA NER', 'ARGENTO', 'BORGO 28', 'BUGATTI', 'C.1881', 'CUSERI', 'DEWIN', 'DONNAKARAN', 'HL LIBERTY', 'ENGLISH L', 'EXIGO', 'FACIS', 'FACONNABLE',
                         'FLORSHEIM', 'FUENTECAPA', 'G. BEENE', 'G.ARMANI', 'HL SARTORI', 'HL SUMISUR', 'JDEMUCHA', 'JOSEPH ABB', 'LA TORRE', 'LAMBERTI', 'LUBIAM', 'M.PIQUERA', 'MARCELLO M', 'MICHAELKOR',
                         'MOSCHINO', 'NATURA B', 'NAUTICA', 'NORTH POLE', 'OFFSET', 'OM', 'PAL ZILERI', 'PATRICIA P', 'PATRIZIA P', 'R. GRAHAM', 'RCAVALLI', 'SAFETY SHI', 'SAN REMO', 'SIDI EXECU', 'SIDIBASICO', 'SIDIOSW', 'TORRAS',
                         'TRAPPER', 'VALENTINO', 'VERSACE') THEN 'OM' WHEN Marca IN ('SIDI ORIZZ', 'HL SLIM FI') THEN 'HL SLIM FI' WHEN Marca IN ('H.LIFE') THEN 'HIGH LIFE' ELSE Marca END   $marca and Familia NOT IN ('', 'ACCESORIOS', 'BERMUDA', 'BLAZER D', 'BLUSA', 'BOLSA', 'BORDADO', 'CAMISA', 'CHALECOD', 'CINTA', 'CONJUNTO', 'COOR/PANTS', 'CORB&MAN', 'CORBATERO', 'EMPAQUE', 'EQUIPAJE', 
                         'FAJA&MONO', 'FALDA', 'FALDA DAMA', 'GORRA', 'HABILITACION', 'KITSMOKREN', 'MAQUILA', 'PANTALON', 'PANTALON D', 'PANTALON DAMA', 'PANTALOND', 'PAQUETE', 'PIJAMA', 'ROPA INT', 'SACO', 'SACO DAMA', 'SLACK', 
                         'SUDADERA', 'TELA', 'TELAS', 'VARIOS')

and  cat.tipo $tempo
and ped_compr.Temporada not in ('SM','212','PV25P')
and ped_compr.Almacen not in ('R053','','R098')

");
$sql_entradas= utf8_decode( "

select

convert(int,Sum(case when MONTH([Fecha Registro]) =1 then case when H.[Cantidad facturada] is null or  h.[Cantidad facturada]=0 then  H.[Cantidad recibida no facturada] else h.[Cantidad facturada] end END)) 'ENERO',
convert(int,Sum(case when MONTH([Fecha Registro]) =2 then case when H.[Cantidad facturada] is null or  h.[Cantidad facturada]=0 then  H.[Cantidad recibida no facturada] else h.[Cantidad facturada] end  END)) 'FEBRERO',
convert(int,Sum(case when MONTH([Fecha Registro]) =3 then  case when H.[Cantidad facturada] is null or  h.[Cantidad facturada]=0 then  H.[Cantidad recibida no facturada] else h.[Cantidad facturada] end  END)) 'MARZO',
convert(int,Sum(case    when MONTH([Fecha Registro]) =4 then  case when H.[Cantidad facturada] is null or  h.[Cantidad facturada]=0 then  H.[Cantidad recibida no facturada] else h.[Cantidad facturada] end  END))'ABRIL',
convert(int,Sum(case    when MONTH([Fecha Registro]) =5 then  case when H.[Cantidad facturada] is null or  h.[Cantidad facturada]=0 then  H.[Cantidad recibida no facturada] else h.[Cantidad facturada] end  END)) 'MAYO',
convert(int,Sum(case    when MONTH([Fecha Registro]) =6 then  case when H.[Cantidad facturada] is null or  h.[Cantidad facturada]=0 then  H.[Cantidad recibida no facturada] else h.[Cantidad facturada] end  END)) 'JUNIO',
convert(int,Sum(case    when MONTH([Fecha Registro]) =7 then case when H.[Cantidad facturada] is null or  h.[Cantidad facturada]=0 then  H.[Cantidad recibida no facturada] else h.[Cantidad facturada] end  END)) 'JULIO',
convert(int,Sum(case    when MONTH([Fecha Registro]) =8 then case when H.[Cantidad facturada] is null or  h.[Cantidad facturada]=0 then  H.[Cantidad recibida no facturada] else h.[Cantidad facturada] end  END)) 'AGOSTO',
convert(int,Sum(case    when MONTH([Fecha Registro]) =9 then  case when H.[Cantidad facturada] is null or  h.[Cantidad facturada]=0 then  H.[Cantidad recibida no facturada] else h.[Cantidad facturada] end  END)) 'SEPTIEMBRE',
convert(int,Sum(case    when MONTH([Fecha Registro]) =10 then case when H.[Cantidad facturada] is null or  h.[Cantidad facturada]=0 then  H.[Cantidad recibida no facturada] else h.[Cantidad facturada] end  END)) 'OCTUBRE',
convert(int,Sum(case    when MONTH([Fecha Registro]) =11 then  case when H.[Cantidad facturada] is null or  h.[Cantidad facturada]=0 then  H.[Cantidad recibida no facturada] else h.[Cantidad facturada] end  END)) 'NOVIEMBRE',
convert(int,Sum(case    when MONTH([Fecha Registro]) =12 then case when H.[Cantidad facturada] is null or  h.[Cantidad facturada]=0 then  H.[Cantidad recibida no facturada] else h.[Cantidad facturada] end  END)) 'DICIEMBRE'




from [Recepciones de Compra] H join [PRODUCTO_LOGISTICA] Pr on H.[Nº referencia cruzada] collate Latin1_General_100_CI_AS =Pr.Nº
left join Proveedor as pv on pr.[Nº proveedor]=pv.[No.]  collate Latin1_General_100_CI_AS




                  where year([Fecha Registro])='$year'
                  and familia $familia
                  and Familia NOT IN ('', 'ACCESORIOS', 'BERMUDA', 'BLAZER D', 'BLUSA', 'BOLSA', 'BORDADO', 'CAMISA', 'CHALECOD', 'CINTA', 'CONJUNTO', 'COOR/PANTS', 'CORB&MAN', 'CORBATERO', 'EMPAQUE', 'EQUIPAJE', 
                         'FAJA&MONO', 'FALDA', 'FALDA DAMA', 'GORRA', 'HABILITACION', 'KITSMOKREN', 'MAQUILA', 'PANTALON', 'PANTALON D', 'PANTALON DAMA', 'PANTALOND', 'PAQUETE', 'PIJAMA', 'ROPA INT', 'SACO', 'SACO DAMA', 'SLACK', 
                         'SUDADERA', 'TELA', 'TELAS', 'VARIOS')
                  AND  CASE WHEN Pr.Colección IN ('AQUAVIVA', 'ANDREA NER', 'ARGENTO', 'BORGO 28', 'BUGATTI', 'C.1881', 'CUSERI', 'DEWIN', 'DONNAKARAN', 'HL LIBERTY', 'ENGLISH L', 'EXIGO', 'FACIS', 'FACONNABLE',
                         'FLORSHEIM', 'FUENTECAPA', 'G. BEENE', 'G.ARMANI', 'HL SARTORI', 'HL SUMISUR', 'JDEMUCHA', 'JOSEPH ABB', 'LA TORRE', 'LAMBERTI', 'LUBIAM', 'M.PIQUERA', 'MARCELLO M', 'MICHAELKOR',
                         'MOSCHINO', 'NATURA B', 'NAUTICA', 'NORTH POLE', 'OFFSET', 'OM', 'PAL ZILERI', 'PATRICIA P', 'PATRIZIA P', 'R. GRAHAM', 'RCAVALLI', 'SAFETY SHI', 'SAN REMO', 'SIDI EXECU', 'SIDIBASICO', 'SIDIOSW', 'TORRAS',
                         'TRAPPER', 'VALENTINO', 'VERSACE') THEN 'OM' WHEN Pr.Colección IN ('SIDI ORIZZ', 'HL SLIM FI') THEN 'HL SLIM FI' WHEN Pr.Colección IN ('H.LIFE') THEN 'HIGH LIFE' ELSE Pr.Colección END   $marca
                         AND pr.tipo $tempo
                         AND H.[Temporada] not in ('SM','212','PV25P')
                         AND H.[Cód. almacén] not in ('R053','','R098')

  ");
$sql_entradasped= utf8_decode( "SELECT SUM(CASE WHEN MES=1 THEN Facturada END)ENERO,
        SUM(CASE WHEN MES=2 THEN Facturada END)FEBRERO,
        SUM(CASE WHEN MES=3 THEN Facturada END)MARZO,
        SUM(CASE WHEN MES=4 THEN Facturada END)ABRIL,
        SUM(CASE WHEN MES=5 THEN Facturada END)MAYO,
        SUM(CASE WHEN MES=6 THEN Facturada END)JUNIO,
        SUM(CASE WHEN MES=7 THEN Facturada END)JULIO,
        SUM(CASE WHEN MES=8 THEN Facturada END)AGOSTO,
        SUM(CASE WHEN MES=9 THEN Facturada END)SEPTIEMBRE,
        SUM(CASE WHEN MES=10 THEN Facturada END)OCTUBRE,
        SUM(CASE WHEN MES=11 THEN Facturada END)NOVIEMBRE,
        SUM(CASE WHEN MES=12 THEN Facturada END)DICIEMBRE



 from ped_compr left join (select distinct Nº,TIPO from PRODUCTO_LOGISTICA ) as cat on ped_compr.SKU=cat.Nº collate SQL_Latin1_General_CP1_CI_AS





WHERE Año ='$year' AND familia $familia AND cASE WHEN Marca IN ('AQUAVIVA', 'ANDREA NER', 'ARGENTO', 'BORGO 28', 'BUGATTI', 'C.1881', 'CUSERI', 'DEWIN', 'DONNAKARAN', 'HL LIBERTY', 'ENGLISH L', 'EXIGO', 'FACIS', 'FACONNABLE',
                         'FLORSHEIM', 'FUENTECAPA', 'G. BEENE', 'G.ARMANI', 'HL SARTORI', 'HL SUMISUR', 'JDEMUCHA', 'JOSEPH ABB', 'LA TORRE', 'LAMBERTI', 'LUBIAM', 'M.PIQUERA', 'MARCELLO M', 'MICHAELKOR',
                         'MOSCHINO', 'NATURA B', 'NAUTICA', 'NORTH POLE', 'OFFSET', 'OM', 'PAL ZILERI', 'PATRICIA P', 'PATRIZIA P', 'R. GRAHAM', 'RCAVALLI', 'SAFETY SHI', 'SAN REMO', 'SIDI EXECU', 'SIDIBASICO', 'SIDIOSW', 'TORRAS',
                         'TRAPPER', 'VALENTINO', 'VERSACE') THEN 'OM' WHEN Marca IN ('SIDI ORIZZ', 'HL SLIM FI') THEN 'HL SLIM FI' WHEN Marca IN ('H.LIFE') THEN 'HIGH LIFE' ELSE Marca END   $marca and Familia NOT IN ('', 'ACCESORIOS', 'BERMUDA', 'BLAZER D', 'BLUSA', 'BOLSA', 'BORDADO', 'CAMISA', 'CHALECOD', 'CINTA', 'CONJUNTO', 'COOR/PANTS', 'CORB&MAN', 'CORBATERO', 'EMPAQUE', 'EQUIPAJE', 
                         'FAJA&MONO', 'FALDA', 'FALDA DAMA', 'GORRA', 'HABILITACION', 'KITSMOKREN', 'MAQUILA', 'PANTALON', 'PANTALON D', 'PANTALON DAMA', 'PANTALOND', 'PAQUETE', 'PIJAMA', 'ROPA INT', 'SACO', 'SACO DAMA', 'SLACK', 
                         'SUDADERA', 'TELA', 'TELAS', 'VARIOS')


and  cat.tipo $tempo
and ped_compr.Temporada not in ('SM','212','PV25P')
and ped_compr.Almacen not in ('R053','','R098')


  ");
}
else{

    
$sql_pedidosay=utf8_decode( "

select SUM(CASE WHEN MES=1 THEN CANTIDAD END)ENERO,
		SUM(CASE WHEN MES=2 THEN CANTIDAD END)FEBRERO,
		SUM(CASE WHEN MES=3 THEN CANTIDAD END)MARZO,
		SUM(CASE WHEN MES=4 THEN CANTIDAD END)ABRIL,
		SUM(CASE WHEN MES=5 THEN CANTIDAD END)MAYO,
		SUM(CASE WHEN MES=6 THEN CANTIDAD END)JUNIO,
		SUM(CASE WHEN MES=7 THEN CANTIDAD END)JULIO,
		SUM(CASE WHEN MES=8 THEN CANTIDAD END)AGOSTO,
		SUM(CASE WHEN MES=9 THEN CANTIDAD END)SEPTIEMBRE,
		SUM(CASE WHEN MES=10 THEN CANTIDAD END)OCTUBRE,
		SUM(CASE WHEN MES=11 THEN CANTIDAD END)NOVIEMBRE,
		SUM(CASE WHEN MES=12 THEN CANTIDAD END)DICIEMBRE

 from ped_compr

WHERE Año =$year AND Familia  $familia AND Marca   $marca  AND Familia not in( 'BOLECOACC')
and categoria $tempo and ([No Modelo Habers] $modelo or [Cód. producto proveedor] $modelo) and color $color
and ped_compr.Temporada not in ('SM')
and ped_compr.Almacen not in ('')      


");
$sql_pedidosly=utf8_decode( "
select SUM(CASE WHEN MES=1 THEN CANTIDAD END)ENERO,
		SUM(CASE WHEN MES=2 THEN CANTIDAD END)FEBRERO,
		SUM(CASE WHEN MES=3 THEN CANTIDAD END)MARZO,
		SUM(CASE WHEN MES=4 THEN CANTIDAD END)ABRIL,
		SUM(CASE WHEN MES=5 THEN CANTIDAD END)MAYO,
		SUM(CASE WHEN MES=6 THEN CANTIDAD END)JUNIO,
		SUM(CASE WHEN MES=7 THEN CANTIDAD END)JULIO,
		SUM(CASE WHEN MES=8 THEN CANTIDAD END)AGOSTO,
		SUM(CASE WHEN MES=9 THEN CANTIDAD END)SEPTIEMBRE,
		SUM(CASE WHEN MES=10 THEN CANTIDAD END)OCTUBRE,
		SUM(CASE WHEN MES=11 THEN CANTIDAD END)NOVIEMBRE,
		SUM(CASE WHEN MES=12 THEN CANTIDAD END)DICIEMBRE

 from ped_compr

WHERE Año =$añoanterior AND Familia $familia AND Marca   $marca  AND Familia not in( 'BOLECOACC')
    and categoria $tempo and ([No Modelo Habers] $modelo or [Cód. producto proveedor] $modelo) and color $color
    and ped_compr.Temporada not in ('SM')
    and ped_compr.Almacen not in ('')


");
$sql_pedidosny=utf8_decode( "
select SUM(CASE WHEN MES=1 THEN CANTIDAD END)ENERO,
		SUM(CASE WHEN MES=2 THEN CANTIDAD END)FEBRERO,
		SUM(CASE WHEN MES=3 THEN CANTIDAD END)MARZO,
		SUM(CASE WHEN MES=4 THEN CANTIDAD END)ABRIL,
		SUM(CASE WHEN MES=5 THEN CANTIDAD END)MAYO,
		SUM(CASE WHEN MES=6 THEN CANTIDAD END)JUNIO,
		SUM(CASE WHEN MES=7 THEN CANTIDAD END)JULIO,
		SUM(CASE WHEN MES=8 THEN CANTIDAD END)AGOSTO,
		SUM(CASE WHEN MES=9 THEN CANTIDAD END)SEPTIEMBRE,
		SUM(CASE WHEN MES=10 THEN CANTIDAD END)OCTUBRE,
		SUM(CASE WHEN MES=11 THEN CANTIDAD END)NOVIEMBRE,
		SUM(CASE WHEN MES=12 THEN CANTIDAD END)DICIEMBRE

 from ped_compr

WHERE Año =$nextyear AND Familia $familia  AND Marca   $marca  AND Familia not in( 'BOLECOACC')
    and categoria $tempo and ([No Modelo Habers] $modelo or [Cód. producto proveedor] $modelo) and color $color
    and ped_compr.Temporada not in ('SM')
    and ped_compr.Almacen not in ('')

");
$sql_pendientes=utf8_decode( "


select SUM(CASE WHEN MES=1 THEN Pendiente END)ENERO,
		SUM(CASE WHEN MES=2 THEN Pendiente END)FEBRERO,
		SUM(CASE WHEN MES=3 THEN Pendiente END)MARZO,
		SUM(CASE WHEN MES=4 THEN Pendiente END)ABRIL,
		SUM(CASE WHEN MES=5 THEN Pendiente END)MAYO,
		SUM(CASE WHEN MES=6 THEN Pendiente END)JUNIO,
		SUM(CASE WHEN MES=7 THEN Pendiente END)JULIO,
		SUM(CASE WHEN MES=8 THEN Pendiente END)AGOSTO,
		SUM(CASE WHEN MES=9 THEN Pendiente END)SEPTIEMBRE,
		SUM(CASE WHEN MES=10 THEN Pendiente END)OCTUBRE,
		SUM(CASE WHEN MES=11 THEN Pendiente END)NOVIEMBRE,
		SUM(CASE WHEN MES=12 THEN Pendiente END)DICIEMBRE

 from ped_compr

WHERE Año =$year AND Familia $familia AND Marca   $marca  AND Familia not in( 'BOLECOACC')
    
and categoria $tempo and ([No Modelo Habers] $modelo or [Cód. producto proveedor] $modelo) and color $color
and ped_compr.Temporada not in ('SM')
and ped_compr.Almacen not in ('')

");
$sql_pendientesny=utf8_decode( "
select SUM(CASE WHEN MES=1 THEN Pendiente END)ENERO,
		SUM(CASE WHEN MES=2 THEN Pendiente END)FEBRERO,
		SUM(CASE WHEN MES=3 THEN Pendiente END)MARZO,
		SUM(CASE WHEN MES=4 THEN Pendiente END)ABRIL,
		SUM(CASE WHEN MES=5 THEN Pendiente END)MAYO,
		SUM(CASE WHEN MES=6 THEN Pendiente END)JUNIO,
		SUM(CASE WHEN MES=7 THEN Pendiente END)JULIO,
		SUM(CASE WHEN MES=8 THEN Pendiente END)AGOSTO,
		SUM(CASE WHEN MES=9 THEN Pendiente END)SEPTIEMBRE,
		SUM(CASE WHEN MES=10 THEN Pendiente END)OCTUBRE,
		SUM(CASE WHEN MES=11 THEN Pendiente END)NOVIEMBRE,
		SUM(CASE WHEN MES=12 THEN Pendiente END)DICIEMBRE

 from ped_compr

WHERE Año =$year AND Familia $familia AND Marca   $marca  AND Familia not in( 'BOLECOACC')
    and categoria $tempo and ([No Modelo Habers] $modelo or [Cód. producto proveedor] $modelo) and color $color
    and ped_compr.Temporada not in ('SM')
    and ped_compr.Almacen not in ('')

");
$sql_entradas= utf8_decode( " SELECT SUM(case when mes=1 then compra end) Enero,
SUM(case when mes=2 then compra end) Febrero,
SUM(case when mes=3 then compra end) Marzo,
SUM(case when mes=4 then compra end) Abril,
SUM(case when mes=5 then compra end) Mayo,
SUM(case when mes=6 then compra end) Junio,
SUM(case when mes=7 then compra end) Julio,
SUM(case when mes=8 then compra end) Agosto,
SUM(case when mes=9 then compra end) Septiembre,
SUM(case when mes=10 then compra end) Octubre,
SUM(case when mes=11 then compra end) Noviembre,
SUM(case when mes=12 then compra end) Diciembre


  FROM [dbRoberts].[dbo].[ExisFamMesTdaMod]

  where familia $familia and Colección   $marca  and año=$year AND Familia not in( 'BOLECOACC')

and categoria $tempo and (modelo $modelo OR modelo_haber $modelo) and color $color


  ");
$sql_entradasly= utf8_decode( " SELECT SUM(case when mes=1 then compra end) Enero,
SUM(case when mes=2 then compra end) Febrero,
SUM(case when mes=3 then compra end) Marzo,
SUM(case when mes=4 then compra end) Abril,
SUM(case when mes=5 then compra end) Mayo,
SUM(case when mes=6 then compra end) Junio,
SUM(case when mes=7 then compra end) Julio,
SUM(case when mes=8 then compra end) Agosto,
SUM(case when mes=9 then compra end) Septiembre,
SUM(case when mes=10 then compra end) Octubre,
SUM(case when mes=11 then compra end) Noviembre,
SUM(case when mes=12 then compra end) Diciembre


  FROM [dbRoberts].[dbo].[ExisFamMesTdaMod]

  where familia $familia and Colección   $marca  and año=$añoanterior AND Familia not in( 'BOLECOACC')


and categoria $tempo and (modelo $modelo OR modelo_haber $modelo) and color $color


  ");
$sqlcompra= utf8_decode( " SELECT

  sum(case when mes =1 then [COMPRA] END ) ENERO,
	  sum(case when mes =2 then [COMPRA] END ) FEBRERO,
	  sum(case when mes =3 then [COMPRA] END ) MARZO,
	  sum(case when mes =4 then [COMPRA] END ) ABRIL,
	  sum(case when mes =5 then [COMPRA] END ) MAYO,
	  sum(case when mes =6 then [COMPRA] END ) JUNIO,
	  sum(case when mes =7 then [COMPRA] END ) JULIO,
	  sum(case when mes =8 then [COMPRA] END ) AGOSTO,
	  sum(case when mes =9 then [COMPRA] END ) SEPTIEMBRE,
	  sum(case when mes =10 then [COMPRA] END ) OCTUBRE,
	  sum(case when mes =11 then [COMPRA] END ) NOVIEMBRE,
	  sum(case when mes =12 then [COMPRA] END ) DICIEMBRE
FROM
 sop_bas
WHERE
  año=$year AND Familia $familia and Marca   $marca  and modelo $modelo and color $color
GROUP BY
  año;");
$sqlpptocompra= utf8_decode( " SELECT

   sum(case when mes =1 then [COMPRA] END ) ENERO,
	  sum(case when mes =2 then [COMPRA] END ) FEBRERO,
	  sum(case when mes =3 then [COMPRA] END ) MARZO,
	  sum(case when mes =4 then [COMPRA] END ) ABRIL,
	  sum(case when mes =5 then [COMPRA] END ) MAYO,
	  sum(case when mes =6 then [COMPRA] END ) JUNIO,
	  sum(case when mes =7 then [COMPRA] END ) JULIO,
	  sum(case when mes =8 then [COMPRA] END ) AGOSTO,
	  sum(case when mes =9 then [COMPRA] END ) SEPTIEMBRE,
	  sum(case when mes =10 then [COMPRA] END ) OCTUBRE,
	  sum(case when mes =11 then [COMPRA] END ) NOVIEMBRE,
	  sum(case when mes =12 then [COMPRA] END ) DICIEMBRE
FROM
  sop_bas
WHERE
  año=$year AND Familia $familia and Marca   $marca  and modelo $modelo and color $color
GROUP BY
  año;");

}

  $rawpedidosay=execonsultasqlsrv($sql_pedidosay,$conexion,$rawpedidosay);
  

  
  
  $rawpedidosly=execonsultasqlsrv($sql_pedidosly,$conexion,$rawpedidosly);
  $rawpedidosny=execonsultasqlsrv($sql_pedidosny,$conexion,$rawpedidosny);
  $rawentradas=execonsultasqlsrv($sql_entradas,$conexion,$rawentradas);



  $rawentradaspd=execonsultasqlsrv($sql_entradasped,$conexion,$rawentradaspd);
  $rawpendientes=execonsultasqlsrv($sql_pendientes,$conexion,$rawpendientes);
  //asignacion de filas y columnas
$nombremeses= array(
    "'ENERO'",
    "'FEBRERO'",
    "'MARZO'",
    "'ABRIL'",
    "'MAYO'",
    "'JUNIO'",
    "'JULIO'",
    "'AGOSTO'",
    "'SEPTIEMBRE'",
    "'OCTUBRE'",
    "'NOVIEMBRE'",
    "'DICIEMBRE'"

);
$columnas = count($nombremeses);///2;
$filas = $filas=count($rawpedidosay[0]);;
$namecolumn.="'ENERO','FEBRERO','MARZO','ABRIL','MAYO','JUNIO','JULIO','AGOSTO','SEPTIEMBRE','OCTUBRE','NOVIEMBRE','DICIEMBRE'";



function process_data($input,$output){

      foreach ($input[0] as $key=> $clave){
          if(is_numeric($key)   ){
              if($clave=="") {
                  array_push($output, 0);
              }
              else{
                  array_push($output,$clave);
              }
          }
      }

      if(count($output)==0 or count($output)=="" )
      for($i=0;$i<12;$i++){
          $output[$i].=0;

      }

      return $output;

  }

  $pedidosay=process_data($rawpedidosay,$pedidosay);
  $pedidosly=process_data($rawpedidosly,$pedidosly);
  $pedidosny=process_data($rawpedidosny,$pedidosny);
  $entradas=process_data($rawentradas,$entradas);
  $entradaspd=process_data($rawentradaspd,$entradaspd);//$entradasly=process_data($rawentradasly,$entradasly);
  $pendientes=process_data($rawpendientes,$pendientes);
  $namecolumn="['',".$namecolumn.",'TOTAL'],";

  $process_columnas=count($pedidosay);


  for ($i=0;$i<$process_columnas;$i++){
          $totalay+=$pedidosay[$i];
          $totally+=$pedidosly[$i];
          $totalny+=$pedidosny[$i];
          $totalen+=$entradas[$i];
          $totalenpd+=$entradaspd[$i];
          $totalpen+=$pendientes[$i];

      $matrizpedidoay.=$pedidosay[$i].",";
      $matrizpedidony.=$pedidosny[$i].",";
      $matrizpedidoly.=$pedidosly[$i].",";
      $matrizpendiente.=$pendientes[$i].",";
      $matrizentrada.=intval($entradas[$i]).",";
      $matrizentradapd.=intval($entradaspd[$i]).",";





  }

  $matrizpedidoay=substr($matrizpedidoay,0,strlen($matrizpedidoay)-1);
  $matrizpedidoly=substr($matrizpedidoly,0,strlen($matrizpedidoly)-1);
  $matrizpedidony=substr($matrizpedidony,0,strlen($matrizpedidony)-1);
  $matrizpendiente=substr($matrizpendiente,0,strlen($matrizpendiente)-1);
  $matrizentrada=substr($matrizentrada,0,strlen($matrizentrada)-1);
  $matrizentradapd=substr($matrizentradapd,0,strlen($matrizentradapd)-1);




  $pivotinvf=array();
  for ( $i=0 ;$i<$process_columnas;$i++){
      $pivotinvf[$i][0]=$nombresmeses[$i];
      $pivotinvf[$i][1]=$pedidosay[$i];
      $pivotinvf[$i][2]=intval($entradas[$i]);

  }

  $grafica="";

  for($i=0;$i<$process_columnas;$i++){


      $grafica.="[";

      for($j=0;$j<3;$j++){

          if($j==2)
          {
              $grafica=$grafica. $pivotinvf[$i][$j]."],";

          }
          else{

              $grafica=$grafica.$pivotinvf[$i][$j].",";

          }





      }






  }

  $grafica=substr($grafica,0,strlen($grafica)-1 );

      ?>

  <script type="text/javascript">
      google.charts.load('current', {'packages':['table']});


      google.charts.setOnLoadCallback(drawCharts7);
      google.charts.setOnLoadCallback(drawCharts2);
      var familia='';
      var val_fam=document.getElementById('familia');
      for (i=0;i< val_fam.length;i++) {
          if(val_fam[i].selected){
              familia += "'"+val_fam[i].value + "',";
          }
      }
      var familia=familia.slice(0,familia.length -1);

      var marca='';
      var val_mar=document.getElementById('marca');
      for (i=0;i< val_mar.length;i++) {
          if(val_mar[i].selected){
              marca += "'"+val_mar[i].value + "',";
          }
      }
      var marca=marca.slice(0,marca.length -1);
      
       
    var modelos = '';
                 var colores = '';
              var val_mod = document.getElementById('modelos');
              for (let i = 0; i < val_mod.length; i++) {
                  if (val_mod[i].selected) {
                      
                      let explode= val_mod[i].value;
                          explode=explode.split("|");
                      
                      modelos += "'" + explode[0]+ "',";
                      colores += "'" + explode[1]+ "',";
                  }
              }
              var modelos = modelos.slice(0, modelos.length - 1);
              var colores = colores.slice(0, colores.length - 1);


      /* función que carga cada uno de los gráficos */
      function drawCharts2() {
            var dataTable = google.visualization.arrayToDataTable([<?PHP  echo $union=$namecolumn."["."'Pedidos $añoanterior'".",".$matrizpedidoly.",".$totally."]".","."["."'Pedidos $year'".",".$matrizpedidoay.",".$totalay."]".","."["."'Pedidos $nextyear'".",".$matrizpedidony.",".$totalny."]"; ?>]);
          // Create a formatter.
  // This example uses object literal notation to define the options.
          /*   var formatter = new google.visualization.NumberFormat({pattern:'#,###%'});
             var formatter1 = new google.visualization.NumberFormat({prefix: '$'});*/

  // Reformat our data.
          /*    formatter.format(dataTable, 4);
              formatter1.format(dataTable, 3);*/


          var cssClassNames = {
              'headerRow': 'cssHeaderRow',
              'tableRow': 'cssTableRow',
              'oddTableRow': 'cssOddTableRow',
              'selectedTableRow': 'cssSelectedTableRow',
              'hoverTableRow': 'cssHoverTableRow',
              'headerCell': 'cssHeaderCell',
              'tableCell': 'cssTableCell',
              'rowNumberCell': 'cssRowNumberCell'
          };

          var options = {

              cssClassNames: cssClassNames
          };


          var chart   = new google.visualization.Table(document.getElementById('table-pedido'));





          // Apply formatter to second c

          chart.draw(dataTable,options,{allowHtml: true});
          google.visualization.events.addListener(chart,'sort',
              function mes(event) {




                  var mes=event.column;

                  if(mes!=0 & mes!=13 ){
                      $('body').addClass('loadconsult');
                      $('#title').empty();
                      $('#tablaconsulta').empty();
                      $('#tablaconsulta').resize();
                      chart.draw(dataTable ,options,{allowHtml: true});

                      var consulta ='mes='+ mes+'&marca='+   marca +'&year=' + $('#year').val().trim()+'&familia=' +familia+'&temp=' + $('#type').val().trim() + '&colores=' + colores + '&modelos='+modelos;


                      $.ajax({
                          type: 'POST',
                          url: 'SELL&OPR/queries/pedidos_mes.php',
                          data: consulta,
                          success: function(respuesta){




                              $('#title').append("PEDIDOS DEL MES");
                              $('#tablaconsulta').append(respuesta);








                          },
                          error:function(){
                              alert('Error en la peticion ajax');

                          }
                      });}
                  else{
                      alert("No ah seleccionado mes");
                      chart.draw(dataTable ,options,{allowHtml: true});

                  }







              }

          );


      }
      function drawCharts7() {
          var dataTable = google.visualization.arrayToDataTable([<?PHP  echo $union="['$year','------','------','-----','-----','----','-----','-----','------','---------','-------','--------','---------','-----']".","."["."'Pendiente'".",".$matrizpendiente.",".$totalpen."]".","."["."'Entrada Pedido'".",".$matrizentradapd.",".$totalenpd."]".","."["."'Entrada Gral.'".",".$matrizentrada.",".$totalen."]" ; ?>]);

          // Create a formatter.
  // This example uses object literal notation to define the options.
          /*   var formatter = new google.visualization.NumberFormat({pattern:'#,###%'});
             var formatter1 = new google.visualization.NumberFormat({prefix: '$'});*/

  // Reformat our data.
          /*    formatter.format(dataTable, 4);
              formatter1.format(dataTable, 3);*/


          var cssClassNames = {
              'headerRow': 'cssHeaderRow1',
              'tableRow': 'cssTableRow1',
              'oddTableRow': 'cssOddTableRow1',
              'selectedTableRow': 'cssSelectedTableRow1',
              'hoverTableRow': 'cssHoverTableRow1',
              'headerCell': 'cssHeaderCell1',
              'tableCell': 'cssTableCell1',
              'rowNumberCell': 'cssRowNumberCell1'
          };

          var options = {

              cssClassNames: cssClassNames
          };


          var chart   = new google.visualization.Table(document.getElementById('table-pedido1'));





          // Apply formatter to second c

          chart.draw(dataTable,options,{allowHtml: true});
          google.visualization.events.addListener(chart,'sort',
              function mes(event) {




                  var mes=event.column;

                  if(mes!=0 & mes!=13 ){
                      $('body').addClass('loadconsult');
                      $('#title').empty();
                      $('#tablaconsulta').empty();
                      $('#tablaconsulta').resize();
                      chart.draw(dataTable ,options,{allowHtml: true});

                      var consulta ='mes='+ mes+'&marca='+   marca +'&year=' + $('#year').val().trim()+'&familia=' +familia+'&temp=' + $('#type').val().trim() + '&colores=' + colores + '&modelos='+modelos;


                      $.ajax({
                          type: 'POST',
                          url: 'SELL&OPR/queries/pedidos_atempo.php',
                          data: consulta,
                          success: function(respuesta){




                              $('#title').append("DETALLE DE ENTRADA");
                              $('#tablaconsulta').append(respuesta);








                          },
                          error:function(){
                              alert('Error en la peticion ajax');

                          }
                      });}
                  else{
                      alert("No ah seleccionado mes");
                      chart.draw(dataTable ,options,{allowHtml: true});

                  }







              }

          );



      }




  </script>
  <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawVisualization3);

      function drawVisualization3() {
          // Some raw data (not necessarily accurate)
          var data = google.visualization.arrayToDataTable([
              <?PHP  echo "['Mes','Pedidos','Entradas']".",".$grafica ?>
          ]);

          var options = {

              title:'PEDIDOS <?php  echo " ".$year;   ?>' ,

                  titleTextStyle: {


              fontSize: 20
      },




              orientation:'horizontal',
              fontSize:10,
              width:'50%',
              legend: { position: 'top', maxLines: 1 },




          };
          var view = new google.visualization.DataView(data);
          view.setColumns([0, 1,
              { calc: "stringify",
                  sourceColumn: 1,
                  type: "string" ,
                  role: "annotation" },
              2 ,

              { calc: "stringify",
                  sourceColumn: 2,
                  type: "string" ,
                  role: "annotation" }
          ]);

          var chart = new google.visualization.BarChart(document.getElementById('item3'));
          chart.draw(view, options);
          google.visualization.events.addListener(chart, 'select', function() {

              $('#tablaconsulta').empty();
              $('#tablaconsulta').resize();
              var row = chart.getSelection()[0].row;

              var mes=row+1;



              if(mes!=0 & mes!=13 ){
                  $('body').addClass('loadconsult');

                  chart.draw(data ,options,{allowHtml: true});

                  var consulta ='mes='+ mes+'&marca='+   marca+'&year=' + $('#year').val().trim()+'&familia=' + familia+ '&temp=' + $('#type').val().trim();


                  $.ajax({
                      type: 'POST',
                      url: 'SELL&OPR/queries/pedidos_mes.php',
                      data: consulta,
                      success: function(respuesta){





                          $('#tablaconsulta').append(respuesta);








                      },
                      error:function(){
                          alert('Error en la peticion ajax');

                      }
                  });}
              else{
                  alert("No ah seleccionado mes");
                  chart.draw(data ,options,{allowHtml: true});

              }




          });
      }

      $(window).resize(function(){
          drawVisualization3();
      });


  </script>
