<?php include "connsqlsrv.php";

error_reporting(E_ERROR);


global $conexion;


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
    $year=$_POST['year'];
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
$familia='TRAJE';
$marca='LMENTAL';
$year='2019';
*/
//variables
$pptoventa=array();
$beforeyear=$year-1;
$namecolumn1='';
$cero=0;
$max=0;
$data3='';
$compra=array();
$columncr=array();
$inv=array();
$data3compra ='';
$inventarios='';
$invfinal='';
$data8=array();
$vta=array();
$i=0;
//queries

IF( $tempo!=="in ('BASICO')"){
$sqlpptovta= utf8_decode( " SELECT
 sum(case when mes =1 then [PPTO DE VTA] END ) ENERO,
	  sum(case when mes =2 then [PPTO DE VTA] END ) FEBRERO,
	  sum(case when mes =3 then [PPTO DE VTA] END ) MARZO,
	  sum(case when mes =4 then [PPTO DE VTA] END ) ABRIL,
	  sum(case when mes =5 then [PPTO DE VTA] END ) MAYO,
	  sum(case when mes =6 then [PPTO DE VTA] END ) JUNIO,
	  sum(case when mes =7 then [PPTO DE VTA] END ) JULIO,
	  sum(case when mes =8 then [PPTO DE VTA] END ) AGOSTO,
	  sum(case when mes =9 then [PPTO DE VTA] END ) SEPTIEMBRE,
	  sum(case when mes =10 then [PPTO DE VTA] END ) OCTUBRE,
	  sum(case when mes =11 then [PPTO DE VTA] END ) NOVIEMBRE,
	  sum(case when mes =12 then [PPTO DE VTA] END ) DICIEMBRE
FROM
  presupuesto_ro
WHERE
  ANIO='$year' AND familia $familia and Marca   $marca 
GROUP BY
  ANIO;");
$sqlpptocompra= utf8_decode( " SELECT
  
    sum(case when mes =1 then [PLAN COMPRA] END ) ENERO,
	  sum(case when mes =2 then [PLAN COMPRA] END ) FEBRERO,
	  sum(case when mes =3 then [PLAN COMPRA] END ) MARZO,
	  sum(case when mes =4 then [PLAN COMPRA] END ) ABRIL,
	  sum(case when mes =5 then [PLAN COMPRA] END ) MAYO,
	  sum(case when mes =6 then [PLAN COMPRA] END ) JUNIO,
	  sum(case when mes =7 then [PLAN COMPRA] END ) JULIO,
	  sum(case when mes =8 then [PLAN COMPRA] END ) AGOSTO,
	  sum(case when mes =9 then [PLAN COMPRA] END ) SEPTIEMBRE,
	  sum(case when mes =10 then [PLAN COMPRA] END ) OCTUBRE,
	  sum(case when mes =11 then [PLAN COMPRA] END ) NOVIEMBRE,
	  sum(case when mes =12 then [PLAN COMPRA] END ) DICIEMBRE
FROM
 presupuesto_ro
WHERE
  ANIO='$year' AND familia $familia and Marca   $marca 
GROUP BY
  ANIO;");
$sqlinvinicial= utf8_decode( " 
select SUM(EXISTENCIA)EXISTENCIA FROM [ExisFamMes]

  where  familia $familia and Colección  $marca and AÑO ='$beforeyear' and MES =12  
   ");
}
else{
    $sqlpptovta= utf8_decode( " SELECT
  
sum(case when mes =1 then [venta] END ) ENERO,
	  sum(case when mes =2 then [venta] END ) FEBRERO,
	  sum(case when mes =3 then [venta] END ) MARZO,
	  sum(case when mes =4 then [venta] END ) ABRIL,
	  sum(case when mes =5 then [venta] END ) MAYO,
	  sum(case when mes =6 then [venta] END ) JUNIO,
	  sum(case when mes =7 then [venta] END ) JULIO,
	  sum(case when mes =8 then [venta] END ) AGOSTO,
	  sum(case when mes =9 then [venta] END ) SEPTIEMBRE,
	  sum(case when mes =10 then [venta] END ) OCTUBRE,
	  sum(case when mes =11 then [venta] END ) NOVIEMBRE,
	  sum(case when mes =12 then [venta] END ) DICIEMBRE
FROM
sop_bas
WHERE
  año= $year AND Familia $familia and Marca  $marca  and modelo $modelo and color $color
 GROUP BY año;");
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
  año= $year AND Familia $familia and Marca  $marca  and modelo $modelo and color $color
 GROUP BY año;");
$sqlinvinicial= utf8_decode( " 

select SUM(EXISTENCIA)EXISTENCIA 
FROM [ExisFamMesTdaMod]
where  Familia $familia and Colección $marca and AÑO ='$beforeyear' and MES =12  
and categoria $tempo and (modelo $modelo OR modelo_haber $modelo) and color $color and color $color

  ");
}
//funciones

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
function execonsultasqlsrvinf($query,$conect,$res){
    $i=0;
    if(!$result =sqlsrv_query($conect, $query)) {
        die();
        //echo "Error al registrarse";

    }


//Resultado de consulta
    while($row = sqlsrv_fetch_array($result))

    {





        $res.=intval($row[0]);

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


//ejecucion y obtencion de resultados postqueries
$vta=execonsultasqlsrv($sqlpptovta,$conexion,$vta);
$compra=execonsultasqlsrv($sqlpptocompra,$conexion,$compra);
$invfinal=execonsultasqlsrvinf($sqlinvinicial,$conexion,$invfinal);
//asignacion de columnas y filas
$total=0;
$columnas = count($vta[0])/2;///2;
$filas = count($vta);
for($i=1;$i<count($vta[0]);$i=$i+2){
    $columncr[$i]='';
    if($i<>count($vta[0])-1){

        next($vta[0]);
        $namecolumn1.=$columncr[$i]=$columncr[$i]."'".utf8_encode( key($vta[0]))."',";
        next($vta[0]);

    }


    else{
        next($vta[0]);
        $namecolumn1.=$columncr[$i]=$columncr[$i]."'".utf8_encode( key($vta[0]))."'";
        next($vta[0]);
    }


}
$columnname="["."' '".",".$namecolumn1.",'TOTAL'],";
for($i=0;$i<$filas;$i++){
    //echo "<tr>";
    $pptoventa[$i]="";
    $total=0;
    for($j=0;$j<$columnas;$j++){
        //echo "'";



        if($j==0)
        {




            $pptoventa[$i] = $pptoventa[$i] ."'Ppto. Venta'".",".$vta[$i][$j].",";
            $total+=$vta[$i][$j];





        }

        else if($j==($columnas)-1)
        {




            if($vta[$i][$j]=="" or is_null($vta[$i][$j]))
            {
                $pptoventa[$i] = $pptoventa[$i] .  0 ;

            }

            else {

                $pptoventa[$i] = $pptoventa[$i] .$vta[$i][$j];
                $total+=$vta[$i][$j];
            }






        }

        else
        {
            if($vta[$i][$j]=="" or is_null($vta[$i][$j]))
            {
                $pptoventa[$i] = $pptoventa[$i] .  0 .",";

            }

            else {

                $pptoventa[$i] = $pptoventa[$i] .$vta[$i][$j].",";
                $total+=$vta[$i][$j];
            }






        }





    }




}
$cuentapptoventa=count($pptoventa);
for($k=0;$k<$cuentapptoventa ;$k++ ) {

    if($k==$cuentapptoventa-1)



    {


        $data3 =$data3.'['.$pptoventa[$k].",".$total.']';




    }

    else{

        $data3 =$data3.'['.$pptoventa[$k].'],' ;
    }


}
$columnas = count($compra[0])/2;///2;
$filas = count($compra);
$cero=0;
$max=0;
for($i=0;$i<$filas;$i++){
    //echo "<tr>";
    $inv[$i]="";
    $totalc=0;
    for($j=0;$j<$columnas;$j++){
        //echo "'";



        if($j==0)
        {



            $totalc+=$compra[$i][$j];
            $inv[$i] = $inv[$i] ."'Ppto. Compra'".",".$compra[$i][$j].",";





        }

        else if($j==($columnas)-1)
        {




            if($compra[$i][$j]=="" or is_null($compra[$i][$j]))
            {
                $inv[$i] = $inv[$i] .  0 ;
                $totalc+=$compra[$i][$j];

            }

            else {

                $inv[$i] = $inv[$i] .$compra[$i][$j];
                $totalc+=$compra[$i][$j];
            }





        }

        else
        {
            if($compra[$i][$j]=="" or is_null($compra[$i][$j]))
            {
                $inv[$i] = $inv[$i] .  0 .",";
                $totalc+=$compra[$i][$j];

            }

            else {

                $inv[$i] = $inv[$i] .$compra[$i][$j].",";
                $totalc+=$compra[$i][$j];
            }






        }





    }




}
$cuentainv=count($inv);
for($k=0;$k<$cuentainv ;$k++ ) {

    if($k==$cuentainv-1)



    {


        $data3compra =$data3compra.'['.$inv[$k].",".$totalc.']';




    }

    else{

        $data3compra =$data3compra.'['.$inv[$k].'],' ;
    }


}
for($i=0;$i<$filas;$i++) {
//echo "<tr>";
    $data1[$i] = "";
    $data8[$i] = "";
    $total = 0;
    for ($j = 0; $j < $columnas; $j++) {
        //echo "'";


        if ($j == 0) {


            $data1[$i] = $data1[$i] . "'Inv.Final'".",".(($compra[$i][$j] + $invfinal) - $vta[$i][$j]) . ",";

            $data8[$i] = $data8[$i] . "'Inv.Inicial'".",".$invfinal . "," . (($compra[$i][$j] + $invfinal) - $vta[$i][$j]) . ",";

            $inventarios = (($compra[$i][$j] + $invfinal) - $vta[$i][$j]);


        } else if ($j == ($columnas - 1)) {

            $inventarios = $inventarios - $vta[$i][$j];


            $data1[$i] = $data1[$i] . $inventarios;
            $data8[$i] = $data8[$i];


        } else if ($j == ($columnas - 2)) {

            $inventarios = ($inventarios+$compra[$i][$j]) - $vta[$i][$j];


            $data1[$i] = $data1[$i] . $inventarios . ",";
            $data8[$i] = $data8[$i] . $inventarios;


        } else {

            $inventarios = ($inventarios+$compra[$i][$j]) - $vta[$i][$j];


            $data1[$i] = $data1[$i] . $inventarios . ",";
            $data8[$i] = $data8[$i] . $inventarios . ",";


        }


    }

}
$total5=0;
$total6=0;
$d1=count($data1);
$d2=count($data8);
$data6='';
$data4='';
for($k=0;$k<$d1 ;$k++ ) {

    if($k==$d1-1)



    {


        $data6 =$data6.'['.$data1[$k].",".$total5.']';
        $data4 =$data4.'['.$data8[$k].",".$total6.']';






    }

    else{

        $data6 =$data6.'['.$data1[$k].'],' ;
        $data4 =$data4.'['.$data8[$k].'],';


    }


}

?>



<script type="text/javascript">
    google.charts.load('current', {'packages':['table']});

    google.charts.setOnLoadCallback(drawCharts2);

    /* función que carga cada uno de los gráficos */
    function drawCharts2() {
        var dataTable = google.visualization.arrayToDataTable([<?PHP  echo $union=$columnname.$data3.",".$data4.",".$data3compra.",".$data6  ?>]);

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


        var chart   = new google.visualization.Table(document.getElementById('table-ppto'));





        // Apply formatter to second c

        chart.draw(dataTable,options,{allowHtml: true});
google.visualization.events.addListener(chart, 'sort',
            function(event) {

                /*dataTable.sort([{column: event.column, desc: !event.ascending}]);*/
                chart.draw(dataTable,options,{allowHtml: true});

            }
        );


    }

</script>
