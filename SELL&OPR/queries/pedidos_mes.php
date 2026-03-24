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
        
       
       // IF($tempo=="in('BASICO')"){
        $modelo="in(".$_POST['modelos'].")";
        $color="in(".$_POST['colores'].")";
     //   }
    }
    else{
        $tempo="like  '%' ";
    }

}
/*
$familia='camisa v';
$marca='calderoni';
$year='2019';
$mes='4';
*/
//variables
$rawpedidos=array();
$pedidos=array();
$namecolumn1='';
$nombremeses="";
$matrizpedido="";
$matrizentrada="";
$matrizdif="";
$diferencia=array();
$pd=0;
$mese="";
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
IF( $tempo!=="in ('BASICO')"){
    
//queries
$sql=utf8_decode( "
select [N-PEDIDO] as Documento,
Familia,
CASE WHEN Marca IN ('RCAVALLI','LOROPIANA','CONTE DI R','ROYALTON','','ARGENTO','BUGATTI','ANDREA SER', 'BARBERINO', 'BASILE', 'C. 1881', 'C.1881', 'C.INGLESA', 'CALD.SARTO', 'CALDERONIH', 'CALDERONIM', 'CALDERONIS', 'CALDERONST', 'CORNELIANI', 
                         'ENRICO COV', 'EXIGO', 'FERRE', 'FLORENTINO', 'G. BEENE', 'GALLERANI', 'GINO POMPE', 'GUYLAROCHE', 'H.LIFE', 'HABERS', 'HERITAGE', 'IVY OXFORD', 'J.H.', 'JACK NIKLA', 'JOSEPH ABB', 'KRIZIA', 'LORENZO M', 
                         'LUBIAM', 'LUBIAN', 'MADE ITALY', 'MARCELLO M', 'MICHAELKOR', 'N. MARINI', 'NAUTICA', 'NORTH POLE', 'NUOVA ACAD', 'OFFFSET', 'OTRAS', 'OM', 'PAOLO VERZ', 'PAOLOVERZI', 'REPORT', 'ROBERTS 50', 'ROBERTS AQ', 
                         'ROBERTS FA', 'ROBERTS FS', 'ROBERTS IM', 'ROBERTS PR', 'ROBERTS WO', 'ROBERTS BT', 'ROSSOFIORE', 'SAFETY SHY', 'SIDI', 'SKINY', 'TED LAPIDU', 'THINGS CON', 'TRUSSARDI', 'UNGARO', 'VALENTINO', 'EP_OMC','VERSACE') 
                         THEN 'OM' WHEN Marca IN ('CALDERONCL', 'CALDE UPPE') THEN 'CALDE UPPE' WHEN Marca IN ('CK C KLEIN', 'CK KLEIN', 'CK CLEIN', 'CKLEIN') THEN 'CK' WHEN Marca IN ('G.VALENTIN', 'GIORGIO VA') 
                         THEN 'G.VALENTIN' ELSE Marca END Marca,
Temporada,
[Cód. producto proveedor],
[No Modelo Habers],
Color,
Proveedor,
SUM([precio_costo])PrecioCosto,
sum(Cantidad) as Pedido,
sum(Facturada)as Facturada,
sum(Pendiente) as Pendiente,
Año,
Mes,

[Primera Entrega],
[Ultima Entrega]


from ped_compr 
 WHERE Año>='$year' AND familia $familia AND Marca $marca  and Mes='$mes' /*and Temporada not in('Mue')*/
and  Categoria $tempo
and Almacen not in ('R053')
and Temporada not in ('SM','212','PV25P')

 group by [N-PEDIDO] ,
Familia,
CASE WHEN Marca IN ('RCAVALLI','LOROPIANA','CONTE DI R','ROYALTON','','ARGENTO','BUGATTI','ANDREA SER', 'BARBERINO', 'BASILE', 'C. 1881', 'C.1881', 'C.INGLESA', 'CALD.SARTO', 'CALDERONIH', 'CALDERONIM', 'CALDERONIS', 'CALDERONST', 'CORNELIANI', 
                         'ENRICO COV', 'EXIGO', 'FERRE', 'FLORENTINO', 'G. BEENE', 'GALLERANI', 'GINO POMPE', 'GUYLAROCHE', 'H.LIFE', 'HABERS', 'HERITAGE', 'IVY OXFORD', 'J.H.', 'JACK NIKLA', 'JOSEPH ABB', 'KRIZIA', 'LORENZO M', 
                         'LUBIAM', 'LUBIAN', 'MADE ITALY', 'MARCELLO M', 'MICHAELKOR', 'N. MARINI', 'NAUTICA', 'NORTH POLE', 'NUOVA ACAD', 'OFFFSET', 'OTRAS', 'OM', 'PAOLO VERZ', 'PAOLOVERZI', 'REPORT', 'ROBERTS 50', 'ROBERTS AQ', 
                         'ROBERTS FA', 'ROBERTS FS', 'ROBERTS IM', 'ROBERTS PR', 'ROBERTS WO', 'ROBERTS BT', 'ROSSOFIORE', 'SAFETY SHY', 'SIDI', 'SKINY', 'TED LAPIDU', 'THINGS CON', 'TRUSSARDI', 'UNGARO', 'VALENTINO', 'EP_OMC','VERSACE') 
                         THEN 'OM' WHEN Marca IN ('CALDERONCL', 'CALDE UPPE') THEN 'CALDE UPPE' WHEN Marca IN ('CK C KLEIN', 'CK KLEIN', 'CK CLEIN', 'CKLEIN') THEN 'CK' WHEN Marca IN ('G.VALENTIN', 'GIORGIO VA') 
                         THEN 'G.VALENTIN' ELSE Marca END ,
Temporada,
[Cód. producto proveedor],
[No Modelo Habers],
Color,
Proveedor,
Año,
Mes,
[Primera Entrega],
[Ultima Entrega]

order by Año,Mes





 ");
}else{
    //queries
$sql=utf8_decode( "
select pd.[N-PEDIDO] as Documento,
pd.Familia,
pd.Marca,
pd.Temporada,
pd.[Cód. producto proveedor],
pd.Color,
pd.Proveedor,
sum(pd.Cantidad) as Pedido,
sum(pd.Facturada)as Facturada,
sum(pd.Pendiente) as Pendiente,
pd.Año,
pd.Mes,
pd.[Primera Entrega],
pd.[Ultima Entrega]
--p.[Codigo trafico] as [Codigo PO] 


from ped_compr pd
--LEFT JOIN [pedidos] p
--on pd.[N-PEDIDO]  collate Latin1_General_100_CI_AS = p.[Nº documento] collate Latin1_General_100_CI_AS
 WHERE Año>=$year AND pd.Familia $familia AND pd.Marca $marca  and pd.Mes=$mes /*and Temporada not in('Mue')*/
and pd.Categoria $tempo and ([No Modelo Habers] $modelo OR [Cód. producto proveedor] $modelo) and color $color
and Temporada not in ('SM')
and Almacen not in ('')

 group by pd.[N-PEDIDO] ,
pd.Familia,
 pd.Marca  ,
pd.Temporada,
pd.[Cód. producto proveedor],
pd.Color,
pd.Proveedor,
pd.Año,
pd.Mes,
pd.[Primera Entrega],
pd.[Ultima Entrega]
--p.[Codigo trafico]

order by Año,Mes

");
}


//ejecucion y obtencion de resultados postqueries

$rawpedidos=execonsultasqlsrv($sql,$conexion,$rawpedidos);

//asignacion de filas y columnas

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
            if ($rawpedidos[$i][$j] == " " or is_null($rawpedidos[$i][$j])) {

                array_push($pedidos, "'" . 0 . "',");

            } else {


                array_push($pedidos, "'" . utf8_encode( str_replace(array("\r", "\n","'"),"",$rawpedidos[$i][$j]))."',");
            }



        }


    else    {
        if ($rawpedidos[$i][$j] == " " or is_null($rawpedidos[$i][$j])) {

            array_push($pedidos, "'" . 0 . "'");

        } else {
            array_push($pedidos, "'" .utf8_encode( str_replace(array("\r", "\n","'"),"",$rawpedidos[$i][$j]))."'");
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

            <?php print_r( "[".$nombremeses."],".$matrizpedido)?>

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

        var formatter= new google.visualization.ColorFormat();
        formatter.addRange(1,null,'red','white');
        formatter.format(data,9);




        chart.draw(data,{allowHtml: true});





    }

</script>
