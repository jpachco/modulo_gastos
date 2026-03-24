<?php
include "connsqlsrv.php";
global $conexion;
$i=0;

//se genera la consulta
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

if(empty($_POST['year'])or $_POST['year']=='' ){
    $year='';
}
else{
    $year= $_POST['year'];
}

if(empty($_POST['mes'])or $_POST['mes']=='' ){
    $mes='';
}
else{
    $mes= $_POST['mes'];
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


if(empty($_POST['colores'])or $_POST['colores']=='' ){
    $colores='';
}
else{
    if(strpos($_POST['colores'], "%") !== 1){

        $colores="in (".$_POST['colores'].")";
    }
    else{
        $colores="like  '%' ";
    }
}



if(empty($_POST['modelos'])or $_POST['modelos']=='' ){
    $modelos='';
}
else{
    if(strpos($_POST['modelos'], "%") !== 1){

        $modelos="in (".$_POST['modelos'].")";
    }
    else{
        $modelos="like  '%' ";
    }
}




/*
$familia='traje';
$marca='LMENTAL';
$year='2019';
$mes='7';
*/

//variables*************************************************************************************************************
$rawpedidos=array();
$pedidos=array();
$namecolumn1='';
$i=0;
$nombremeses="";
$matrizpedido="";
$matrizentrada="";
$matrizdif="";
$diferencia=array();
$pd=0;
$mese="";
//funciones(executan los queries y se acumulan en arreglos)*************************************************************
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

IF( $tempo!="in ('BASICO')"){
    
//queries***************************************************************************************************************
$sql=utf8_decode( "
select
H.[Nº pedido],
Pr.Familia,
CASE WHEN Pr.Colección IN ('AQUAVIVA', 'ANDREA NER', 'ARGENTO', 'BORGO 28', 'BUGATTI', 'C.1881', 'CUSERI', 'DEWIN', 'DONNAKARAN', 'HL LIBERTY', 'ENGLISH L', 'EXIGO', 'FACIS', 'FACONNABLE', 
                         'FLORSHEIM', 'FUENTECAPA', 'G. BEENE', 'G.ARMANI','HL SARTORI', 'HL SUMISUR', 'JDEMUCHA', 'JOSEPH ABB', 'LA TORRE', 'LAMBERTI', 'LUBIAM', 'M.PIQUERA', 'MARCELLO M', 'MICHAELKOR', 
                         'MOSCHINO', 'NATURA B', 'NAUTICA', 'NORTH POLE', 'OFFSET', 'OM', 'PAL ZILERI', 'PATRICIA P', 'PATRIZIA P', 'R. GRAHAM', 'RCAVALLI', 'SAFETY SHI', 'SAN REMO', 'SIDI EXECU', 'SIDIBASICO', 'SIDIOSW', 'TORRAS', 
                         'TRAPPER', 'VALENTINO', 'VERSACE') THEN 'OM' WHEN Pr.Colección IN ('SIDI ORIZZ', 'HL SLIM FI') THEN 'HL SLIM FI' WHEN Pr.Colección IN ('H.LIFE') THEN 'HLIFE' ELSE pr.Colección END AS Colección,
pr.Subfamilia,
pr.[No Modelo Habers],
pr.[Cód. producto proveedor],
CASE WHEN C.COLOR IS NULL OR C.COLOR = '' THEN Pr.Color ELSE C.COLOR COLLATE Latin1_General_CI_AS END as Color,
pv.Name as Proveedor,
convert(int,Sum( case when  H.[Cantidad facturada] is null  or   H.[Cantidad facturada] =0 then [Cantidad recibida no facturada] else [Cantidad facturada] end    )) as Cantidad,
year([Fecha Registro])Año,
MONTH([Fecha Registro])Mes,
convert(varchar, convert(date,h.[Fecha recepción esperada],3))as [Fecha recepción esperada]



from [Recepciones de Compra] H join Producto Pr on H.[Nº referencia cruzada] collate Latin1_General_100_CI_AS =Pr.Nº 
left join Proveedor as pv on pr.[Nº proveedor]=pv.[No.]  collate Latin1_General_100_CI_AS  
 LEFT  JOIN
                        COLORES AS C ON Pr.Color = C.Codigo COLLATE Latin1_General_CI_AS   
                  


		  where month([Fecha Registro])='$mes' and year([Fecha Registro])='$year' 
and Pr.familia $familia  and PR.Colección   $marca

                        and Pr.[Cód. producto proveedor] $modelos and C.color $colores
and H.[Cód. almacén] not in ('SM','212','PV25P') 
and H.Temporada not in     ('R053','','R098')   
                        



group by 

H.[Nº pedido],
Pr.Familia,
CASE WHEN Pr.Colección IN ('AQUAVIVA', 'ANDREA NER', 'ARGENTO', 'BORGO 28', 'BUGATTI', 'C.1881', 'CUSERI', 'DEWIN', 'DONNAKARAN', 'HL LIBERTY', 'ENGLISH L', 'EXIGO', 'FACIS', 'FACONNABLE', 
                         'FLORSHEIM', 'FUENTECAPA', 'G. BEENE', 'G.ARMANI','HL SARTORI', 'HL SUMISUR', 'JDEMUCHA', 'JOSEPH ABB', 'LA TORRE', 'LAMBERTI', 'LUBIAM', 'M.PIQUERA', 'MARCELLO M', 'MICHAELKOR', 
                         'MOSCHINO', 'NATURA B', 'NAUTICA', 'NORTH POLE', 'OFFSET', 'OM', 'PAL ZILERI', 'PATRICIA P', 'PATRIZIA P', 'R. GRAHAM', 'RCAVALLI', 'SAFETY SHI', 'SAN REMO', 'SIDI EXECU', 'SIDIBASICO', 'SIDIOSW', 'TORRAS', 
                         'TRAPPER', 'VALENTINO', 'VERSACE') THEN 'OM' WHEN Pr.Colección IN ('SIDI ORIZZ', 'HL SLIM FI') THEN 'HL SLIM FI' WHEN Pr.Colección IN ('H.LIFE') THEN 'HLIFE' ELSE pr.Colección END ,
pr.Subfamilia,
pr.[No Modelo Habers],
pr.[Cód. producto proveedor],
CASE WHEN C.COLOR IS NULL OR C.COLOR = '' THEN Pr.Color ELSE C.COLOR COLLATE Latin1_General_CI_AS END ,
pv.Name,
year([Fecha Registro]),
MONTH([Fecha Registro]),
convert(varchar, convert(date,h.[Fecha recepción esperada],3))

order by [Fecha recepción esperada] 


 ");
}else{

    
//queries***************************************************************************************************************
$sql=utf8_decode( "
select

Pr.Familia,
Pr.Colección,
pr.Subfamilia,
pr.[No Modelo Habers],
pr.[Cód. producto proveedor],
 pr.Color as Color,
 pr.CodCol,
 pr.CATEGORIA,
pv.Name as Proveedor,
convert(int,Sum(H.Cantidad)) as Cantidad,
year([Fecha Registro])Año,
MONTH([Fecha Registro])Mes,
convert(varchar, convert(date,h.[Fecha registro],3))as [Fecha Registro]



from [Mov. producto] H join PRODUCTO_LOGISTICA Pr on H.[Nº producto] collate Latin1_General_100_CI_AS =Pr.Nº 
left join Proveedor as pv on pr.[Nº proveedor]=pv.[No.]  collate Latin1_General_100_CI_AS  

                  
where month([Fecha Registro])=$mes and year([Fecha Registro])=$year 
and PR.Familia $familia and PR.Colección $marca AND [Tipo movimiento]='COMPRA'and  (H.[Cód. almacén]  NOT LIKE'%G%' and H.[Cód. almacén]  NOT LIKE'S%') 
and Pr.Categoria $tempo and (pr.[No Modelo Habers] $modelo OR pr.[Cód. producto proveedor] $modelo) and pr.Color $color

group by 


Pr.Familia,
Pr.Colección,
pr.Subfamilia,
pr.[No Modelo Habers],
pr.[Cód. producto proveedor],
 pr.Color ,
 pr.CodCol,
  pr.CATEGORIA,
pv.Name,
year([Fecha Registro]),
MONTH([Fecha Registro]),
convert(varchar, convert(date,h.[Fecha registro],3))


 ");

}

//ejecucion y obtencion de resultados postqueries***********************************************************************
$rawpedidos=execonsultasqlsrv($sql,$conexion,$rawpedidos);
//asignacion de filas y columnas****************************************************************************************
$columnaspedido=count($rawpedidos[0])/2;
$filaspedido=count($rawpedidos);

for($i=0;$i<$columnaspedido;$i++){


        next($rawpedidos[0]);
     $nombremeses=$nombremeses."'".utf8_encode( key($rawpedidos[0]))."',";


        next($rawpedidos[0]);



}
$nombremeses=substr(  $nombremeses,0,strlen($nombremeses)-1   );
for ($i=0;$i<$filaspedido;$i++){
    array_push($pedidos,"[");

    for($j=0;$j<$columnaspedido;$j++) {

        if ($j <> ($columnaspedido - 1) ) {
            if ($rawpedidos[$i][$j] == "" or is_null($rawpedidos[$i][$j])) {

                array_push($pedidos, "'" . 0 . "',");

            } else {
                array_push($pedidos, "'" . utf8_encode( str_replace(array("\r", "\n","'"),"",$rawpedidos[$i][$j]))."',");
            }



        }


    else    {
        if ($rawpedidos[$i][$j] == "" or is_null($rawpedidos[$i][$j])) {

            array_push($pedidos, "'" . 0 . "'");

        } else {
            array_push($pedidos, "'" . utf8_encode( str_replace(array("\r", "\n","'"),"",$rawpedidos[$i][$j]))."'");
        }
    }



    }
        array_push($pedidos, "],");

}
$largopedido=count($pedidos);
for($i=0;$i<$largopedido;$i++) {

        $matrizpedido = $matrizpedido .$pedidos[$i] ;




}
$matrizpedido=substr(  $matrizpedido,0,strlen($matrizpedido)-1   );




?>


<script>
    google.charts.load('current', {'packages':['table']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        var data = google.visualization.arrayToDataTable([

            <?php echo "[".$nombremeses."],".$matrizpedido?>

           ]);

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

        var chart = new google.visualization.Table(document.getElementById('tablaconsulta'));

       /* var formatter= new google.visualization.ColorFormat();
        formatter.addRange(1,null,'red','white');
        formatter.format(data,9);*/




        chart.draw(data,{allowHtml: true});





    }

</script>
