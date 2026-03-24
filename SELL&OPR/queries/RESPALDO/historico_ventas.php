<?php include "connsqlsrv.php";
global $conexion;
//global $conn;
error_reporting(E_ERROR);

$modelo='';

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

$familia="like  '%' " ;
    $marca="like '%'";
    $year='2023';
    $tempo="like '%'";
*/






//variables*************************************************************************************************************
$historico=array();
$datahistorico=array();
$columnhistorico=array();
$nombremeses=array();
$namecolumn1='';
$estructurahistorico='';
$estructuramg='';
$estructuramgly='';
$ajustadov=array();
$datajustado=array();
$ajustadovtagraph=array();
$data3ppto='';
$pivotinvf=array();
$combinadovta=array();
$vtahistoricos=array();
$grafica="";
$lastm=1;//date("n");
$añopas=$year-1;
$añopas2=$year-2;
$añopas3=$year-3;
$añoanterior=($year-1);
$i=0;
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

//queries***************************************************************************************************************

IF( $temp!="in ('BASICO')"){

$sqlconsultautlly=utf8_decode("SELECT 'utilidad',
       sum(case when mes =1 then util END ) ENERO,
	  sum(case when mes =2 then util END ) FEBRERO,
	  sum(case when mes =3 then util END ) MARZO,
	  sum(case when mes =4 then util END ) ABRIL,
	  sum(case when mes =5 then util END ) MAYO,
	  sum(case when mes =6 then util END ) JUNIO,
	  sum(case when mes =7 then util END ) JULIO,
	  sum(case when mes =8 then util END ) AGOSTO,
	  sum(case when mes =9 then util END ) SEPTIEMBRE,
	  sum(case when mes =10 then util END ) OCTUBRE,
	  sum(case when mes =11 then util END ) NOVIEMBRE,
	  sum(case when mes =12 then util END ) DICIEMBRE
  FROM [VtaFamMesSOP]where Familia $familia and [Colección]   $marca  and año ='$añoanterior'
  
  and categoria $tempo
  ");
$sqlconsultaimply=utf8_decode("SELECT '%MG $añoanterior',
       sum(case when mes =1 then Importe END ) ENERO,
	  sum(case when mes =2 then Importe END ) FEBRERO,
	  sum(case when mes =3 then Importe END ) MARZO,
	  sum(case when mes =4 then Importe END ) ABRIL,
	  sum(case when mes =5 then Importe END ) MAYO,
	  sum(case when mes =6 then Importe END ) JUNIO,
	  sum(case when mes =7 then Importe END ) JULIO,
	  sum(case when mes =8 then Importe END ) AGOSTO,
	  sum(case when mes =9 then Importe END ) SEPTIEMBRE,
	  sum(case when mes =10 then Importe END ) OCTUBRE,
	  sum(case when mes =11 then Importe END ) NOVIEMBRE,
	  sum(case when mes =12 then Importe END ) DICIEMBRE
  FROM [VtaFamMesSOP] where Familia $familia and [Colección]   $marca  and año ='$añoanterior' 
  and categoria $tempo
  ");
$sqlconsultautl=utf8_decode("	  SELECT 'utilidad',
       sum(case when mes =1 then util END ) ENERO,
	  sum(case when mes =2 then util END ) FEBRERO,
	  sum(case when mes =3 then util END ) MARZO,
	  sum(case when mes =4 then util END ) ABRIL,
	  sum(case when mes =5 then util END ) MAYO,
	  sum(case when mes =6 then util END ) JUNIO,
	  sum(case when mes =7 then util END ) JULIO,
	  sum(case when mes =8 then util END ) AGOSTO,
	  sum(case when mes =9 then util END ) SEPTIEMBRE,
	  sum(case when mes =10 then util END ) OCTUBRE,
	  sum(case when mes =11 then util END ) NOVIEMBRE,
	  sum(case when mes =12 then util END ) DICIEMBRE
  FROM [VtaFamMesSOP]where Familia $familia and [Colección]   $marca  and año ='$year'
  and categoria $tempo
  ");
$sqlconsultaimp=utf8_decode("SELECT '%MG',
       sum(case when mes =1 then Importe END ) ENERO,
	  sum(case when mes =2 then Importe END ) FEBRERO,
	  sum(case when mes =3 then Importe END ) MARZO,
	  sum(case when mes =4 then Importe END ) ABRIL,
	  sum(case when mes =5 then Importe END ) MAYO,
	  sum(case when mes =6 then Importe END ) JUNIO,
	  sum(case when mes =7 then Importe END ) JULIO,
	  sum(case when mes =8 then Importe END ) AGOSTO,
	  sum(case when mes =9 then Importe END ) SEPTIEMBRE,
	  sum(case when mes =10 then Importe END ) OCTUBRE,
	  sum(case when mes =11 then Importe END ) NOVIEMBRE,
	  sum(case when mes =12 then Importe END ) DICIEMBRE
  FROM [VtaFamMesSOP] where Familia $familia and [Colección]   $marca  and año ='$year ' 
    and categoria $tempo
  ");
$sqlhistorico=utf8_decode( " SELECT
      [AÑO]

      , sum(case when mes =1 then [Venta] END ) ENERO,
	  sum(case when mes =2 then [Venta] END ) FEBRERO,
	  sum(case when mes =3 then [Venta] END ) MARZO,
	  sum(case when mes =4 then [Venta] END ) ABRIL,
	  sum(case when mes =5 then [Venta] END ) MAYO,
	  sum(case when mes =6 then [Venta] END ) JUNIO,
	  sum(case when mes =7 then [Venta] END ) JULIO,
	  sum(case when mes =8 then [Venta] END ) AGOSTO,
	  sum(case when mes =9 then [Venta] END ) SEPTIEMBRE,
	  sum(case when mes =10 then [Venta] END ) OCTUBRE,
	  sum(case when mes =11 then [Venta] END ) NOVIEMBRE,
	  sum(case when mes =12 then [Venta] END ) DICIEMBRE
  FROM [VtaFamMesSOP]


  where Familia $familia and [Colección]   $marca  and año in('$year','$añopas','$añopas2','$añopas3')
   and categoria $tempo

  GROUP BY AÑO
  ORDER BY  AÑO");
$sqlajustado= utf8_decode( "SELECT
  'VENTA AJUSTADO',
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
FROM
  presupuesto_ro
WHERE
  ANIO='$year' AND Familia $familia and Marca   $marca    and categoria $tempo
 GROUP BY ANIO



   ORDER BY  ANIO");


}

else{
    
    $sqlconsultautlly=utf8_decode("	  SELECT 'utilidad',
       sum(case when mes =1 then util END ) ENERO,
	  sum(case when mes =2 then util END ) FEBRERO,
	  sum(case when mes =3 then util END ) MARZO,
	  sum(case when mes =4 then util END ) ABRIL,
	  sum(case when mes =5 then util END ) MAYO,
	  sum(case when mes =6 then util END ) JUNIO,
	  sum(case when mes =7 then util END ) JULIO,
	  sum(case when mes =8 then util END ) AGOSTO,
	  sum(case when mes =9 then util END ) SEPTIEMBRE,
	  sum(case when mes =10 then util END ) OCTUBRE,
	  sum(case when mes =11 then util END ) NOVIEMBRE,
	  sum(case when mes =12 then util END ) DICIEMBRE
  FROM [VtaFamMesTdaSOPMod]
where Familia $familia and [Colección]   $marca  and año ='$añoanterior'
        
  and categoria $tempo and [No Modelo Habers] $modelo and [Color] $color
  ");
    $sqlconsultaimply=utf8_decode("SELECT '%MG $añoanterior',
       sum(case when mes =1 then Importe END ) ENERO,
	  sum(case when mes =2 then Importe END ) FEBRERO,
	  sum(case when mes =3 then Importe END ) MARZO,
	  sum(case when mes =4 then Importe END ) ABRIL,
	  sum(case when mes =5 then Importe END ) MAYO,
	  sum(case when mes =6 then Importe END ) JUNIO,
	  sum(case when mes =7 then Importe END ) JULIO,
	  sum(case when mes =8 then Importe END ) AGOSTO,
	  sum(case when mes =9 then Importe END ) SEPTIEMBRE,
	  sum(case when mes =10 then Importe END ) OCTUBRE,
	  sum(case when mes =11 then Importe END ) NOVIEMBRE,
	  sum(case when mes =12 then Importe END ) DICIEMBRE
  FROM [VtaFamMesTdaSOPMod]
 where Familia $familia and [Colección]   $marca  and año ='$añoanterior'
  and categoria $tempo and [No Modelo Habers] $modelo and [Color] $color
  ");
    $sqlconsultautl=utf8_decode("	  SELECT 'utilidad',
       sum(case when mes =1 then util END ) ENERO,
	  sum(case when mes =2 then util END ) FEBRERO,
	  sum(case when mes =3 then util END ) MARZO,
	  sum(case when mes =4 then util END ) ABRIL,
	  sum(case when mes =5 then util END ) MAYO,
	  sum(case when mes =6 then util END ) JUNIO,
	  sum(case when mes =7 then util END ) JULIO,
	  sum(case when mes =8 then util END ) AGOSTO,
	  sum(case when mes =9 then util END ) SEPTIEMBRE,
	  sum(case when mes =10 then util END ) OCTUBRE,
	  sum(case when mes =11 then util END ) NOVIEMBRE,
	  sum(case when mes =12 then util END ) DICIEMBRE
  FROM [VtaFamMesTdaSOPMod]
where Familia $familia and [Colección]   $marca  and año ='$year'
  and categoria $tempo and [No Modelo Habers] $modelo and [Color] $color
  ");
    $sqlconsultaimp=utf8_decode("SELECT '%MG',
       sum(case when mes =1 then Importe END ) ENERO,
	  sum(case when mes =2 then Importe END ) FEBRERO,
	  sum(case when mes =3 then Importe END ) MARZO,
	  sum(case when mes =4 then Importe END ) ABRIL,
	  sum(case when mes =5 then Importe END ) MAYO,
	  sum(case when mes =6 then Importe END ) JUNIO,
	  sum(case when mes =7 then Importe END ) JULIO,
	  sum(case when mes =8 then Importe END ) AGOSTO,
	  sum(case when mes =9 then Importe END ) SEPTIEMBRE,
	  sum(case when mes =10 then Importe END ) OCTUBRE,
	  sum(case when mes =11 then Importe END ) NOVIEMBRE,
	  sum(case when mes =12 then Importe END ) DICIEMBRE
  FROM [VtaFamMesTdaSOPMod] 
where Familia $familia and [Colección]   $marca  and año ='$year '
    and categoria $tempo and [No Modelo Habers] $modelo and [Color] $color
  ");
    $sqlhistorico=utf8_decode( " SELECT
      [AÑO]
        
      , sum(case when mes =1 then [Venta] END ) ENERO,
	  sum(case when mes =2 then [Venta] END ) FEBRERO,
	  sum(case when mes =3 then [Venta] END ) MARZO,
	  sum(case when mes =4 then [Venta] END ) ABRIL,
	  sum(case when mes =5 then [Venta] END ) MAYO,
	  sum(case when mes =6 then [Venta] END ) JUNIO,
	  sum(case when mes =7 then [Venta] END ) JULIO,
	  sum(case when mes =8 then [Venta] END ) AGOSTO,
	  sum(case when mes =9 then [Venta] END ) SEPTIEMBRE,
	  sum(case when mes =10 then [Venta] END ) OCTUBRE,
	  sum(case when mes =11 then [Venta] END ) NOVIEMBRE,
	  sum(case when mes =12 then [Venta] END ) DICIEMBRE
  FROM [VtaFamMesTdaSOPMod]
        
        
  where Familia $familia and [Colección]   $marca  and año in('$year','$añopas','$añopas2','$añopas3')
   and categoria $tempo and [No Modelo Habers] $modelo and [Color] $color
        
  GROUP BY AÑO
  ORDER BY  AÑO");
    $sqlajustado= utf8_decode( "SELECT
  'VENTA AJUSTADO',
  sum(case when mes =1 then venta END ) ENERO,
	  sum(case when mes =2 then venta END ) FEBRERO,
	  sum(case when mes =3 then venta END ) MARZO,
	  sum(case when mes =4 then venta END ) ABRIL,
	  sum(case when mes =5 then venta END ) MAYO,
	  sum(case when mes =6 then venta END ) JUNIO,
	  sum(case when mes =7 then venta END ) JULIO,
	  sum(case when mes =8 then venta END ) AGOSTO,
	  sum(case when mes =9 then venta END ) SEPTIEMBRE,
	  sum(case when mes =10 then venta END ) OCTUBRE,
	  sum(case when mes =11 then venta END ) NOVIEMBRE,
	  sum(case when mes =12 then venta END ) DICIEMBRE
FROM
  sop_bas
WHERE
  año= $year AND Familia $familia and Marca  $marca  and modelo $modelo and color $color
 GROUP BY año
        
        
        
   ORDER BY  año
");
    
    
}

//ejecucion y obtencion de resultados postqueries***********************************************************************
$historico=execonsultasqlsrv($sqlhistorico,$conexion,$historico);
$ajustadov=execonsultasqlsrv($sqlajustado,$conexion,$ajustadov);
$utilidad=execonsultasqlsrv($sqlconsultautl,$conexion,$utilidad);
$importe=execonsultasqlsrv($sqlconsultaimp,$conexion,$importe);
$utilidadly=execonsultasqlsrv($sqlconsultautlly,$conexion,$utilidadly);
$importely=execonsultasqlsrv($sqlconsultaimply,$conexion,$importely);
//asignacion de filas y columnas****************************************************************************************

$columnas = count($historico[0])/2;///2;
$filas = count($historico);
for($i=1;$i<count($historico[0]);$i=$i+2){
    $columnhistorico[$i]='';
    if($i<>count($historico[0])-1){

        next($historico[0]);
        array_push($nombremeses,"'".utf8_encode( key($historico[0]))."'");
        $namecolumn1.=$columnhistorico[$i]=$columnhistorico[$i]."'".utf8_encode( key($historico[0]))."',";
        next($historico[0]);

    }


    else{
        next($historico[0]);
        array_push($nombremeses,"'".utf8_encode( key($historico[0]))."'");
        $namecolumn1.=$columnhistorico[$i]=$columnhistorico[$i]."'".utf8_encode( key($historico[0]))."','TOTAL'";
        next($historico[0]);
    }


}
$columnname="[".$namecolumn1."],";
$cero=0;
$max=0;
for($i=0;$i<$filas;$i++){
    //echo "<tr>";
    $datahistorico[$i]="";
    $total=0;
    for($j=0;$j<$columnas;$j++){
        //echo "'";



        if ($j==0 ){




            $datahistorico[$i]=$datahistorico[$i]."'".$historico[$i][$j]."',";





        }

        else if($j==($columnas)-1)
        {


            if($historico[$i][$j]=="" or is_null($historico[$i][$j]))
            {
                $datahistorico[$i] = $datahistorico[$i] . 0 .",".$total;


            }

            else {
                $total+=intval( $historico[$i][$j]);
                $datahistorico[$i] = $datahistorico[$i] .intval( $historico[$i][$j]).",".$total;

            }






        }


        else
        {


            if($historico[$i][$j]=="" or is_null($historico[$i][$j]))
            {
                $datahistorico[$i] =$datahistorico[$i] . 0 .",";

            }

            else {
                $total+=intval( $historico[$i][$j]);
                $datahistorico[$i] =$datahistorico[$i] .intval( $historico[$i][$j]).",";

            }





        }





    }




}
for ($i=0;$i<$filas;$i++)
{
    for ($j=0;$j<$columnas;$j++){

        $vtahistoricos[$j][$i].=  $vtahistoricos[$j][$i].intval( $historico[$i][$j]);


    }



}
$cuentahistorico=count($datahistorico);
for($k=0;$k<$cuentahistorico ;$k++ ) {

    if($k==$cuentahistorico-1)



    {


        $estructurahistorico =$estructurahistorico.'['.$datahistorico[$k].']';




    }

    else{

        $estructurahistorico =$estructurahistorico.'['.$datahistorico[$k].'],' ;
    }


}
$columnas = count($ajustadov[0])/2;///2;
$filas = count($ajustadov);
$cero=0;
$max=0;
for($i=0;$i<$filas;$i++){
    //echo "<tr>";
    $datajustado[$i]="";
    $total=0;
    for($j=0;$j<$columnas;$j++){
        //echo "'";
        if($j==0)
        {
            $datajustado[$i] = $datajustado[$i] ."'".$ajustadov[$i][$j]."',";
        }
        else if($j==($columnas)-1)
        {
            if($ajustadov[$i][$j]=="" or is_null($ajustadov[$i][$j]))
            {
                $datajustado[$i] =$datajustado[$i] .  0 .",".$total;
            }
            else {
                $total +=$ajustadov[$i][$j];
                $datajustado[$i] =$datajustado[$i] .$ajustadov[$i][$j].",".$total;
            }
        }
        else
        {
            if($ajustadov[$i][$j]=="" or is_null($ajustadov[$i][$j]))
            {
                $datajustado[$i] = $datajustado[$i] .  0 .",";
            }
            else {
                $total +=$ajustadov[$i][$j];
                $datajustado[$i] = $datajustado[$i] .$ajustadov[$i][$j].",";
            }
        }
    }
}
for ($i=0;$i<$filas;$i++)
{
    for ($j=0;$j<$columnas;$j++){
        $ajustadovtagraph[$j][$i].= $ajustadovtagraph[$j][$i].intval( $ajustadov[$i][$j]);
    }
}
$cuentajustado=count($datajustado);
for($k=0;$k<$cuentajustado ;$k++ ) {
    if($k==$cuentajustado-1)
    {
        $data3ppto =$data3ppto.'['.$datajustado[$k].']';
    }
    else{
        $data3ppto =$data3ppto.'['.$datajustado[$k].'],' ;
    }
}
$columnas = count($importe[0])/2;///2;
$filas = count($importe);
$cero=0;
$max=0;
for($i=0;$i<1;$i++){
    //echo "<tr>";
    $datamg[$i]="";

    for($j=0;$j<$columnas;$j++){
        //echo "'";
        if($j==0)
        {
            $datamg[$i] = $datamg[$i] ."'".$importe[$j][$i]."',";
        }
        else if( $j== ($columnas-1) )
        {
            if($importe[$i][$j]=="" or is_null($importe[$i][$j]) or $importe[$i][$j]==0 )
            {
                $datamg[$i] =$datamg[$i] .  0 .",". 0;
            }
            else {

                $datamg[$i] =$datamg[$i] . round(($utilidad[$i][$j]/$importe[$i][$j]),2,PHP_ROUND_HALF_UP)*100 .",". 0;
            }
        }
        else
        {
            if($importe[$i][$j]=="" or is_null($importe[$i][$j])or $importe[$i][$j]==0)
            {
                $datamg[$i] = $datamg[$i] .  0 .",";
            }
            else {

                $datamg[$i] = $datamg[$i] .  round(($utilidad[$i][$j]/$importe[$i][$j]),2,PHP_ROUND_HALF_UP) * 100 . ",";
            }
        }
    }
}
$cuentamg=count($datamg);
for($k=0;$k<$cuentamg ;$k++ ) {
    if($k==$cuentamg-1)
    {
        $estructuramg =$estructuramg.'['.$datamg[$k].']';
    }
    else{
        $estructuramg =$estructuramg.'['.$datamg[$k].'],' ;
    }
}
$columnas = count($importely[0])/2;///2;
$filas = count($importely);
$cero=0;
$max=0;
for($i=0;$i<1;$i++){
    //echo "<tr>";
    $datamgly[$i]="";

    for($j=0;$j<$columnas;$j++){
        //echo "'";
        if($j==0)
        {
            $datamgly[$i] = $datamgly[$i] ."'".$importely[$j][$i]."',";
        }
        else if( $j== ($columnas-1) )
        {
            if($importely[$i][$j]=="" or is_null($importely[$i][$j]) or $importely[$i][$j]==0 )
            {
                $datamgly[$i] =$datamgly[$i] .  0 .",". 0;
            }
            else {

                $datamgly[$i] =$datamgly[$i] . round(($utilidadly[$i][$j]/$importely[$i][$j]),2,PHP_ROUND_HALF_UP)*100 .",". 0;
            }
        }
        else
        {
            if($importely[$i][$j]=="" or is_null($importely[$i][$j])or $importely[$i][$j]==0)
            {
                $datamgly[$i] = $datamgly[$i] .  0 .",";
            }
            else {

                $datamgly[$i] = $datamgly[$i] .  round(($utilidadly[$i][$j]/$importely[$i][$j]),2,PHP_ROUND_HALF_UP) * 100 . ",";
            }
        }
    }
}
$cuentamgly=count($datamgly);
for($k=0;$k<$cuentamgly ;$k++ ) {
    if($k==$cuentamgly-1)
    {
        $estructuramgly =$estructuramgly.'['.$datamgly[$k].']';
    }
    else{
        $estructuramgly =$estructuramgly.'['.$datamgly[$k].'],' ;
    }
}

$position=count($vtahistoricos[0])-1;
$columnas=count($vtahistoricos);

for($i=0 ;$i<$columnas;$i++){
    if($i<$lastm){
        if($vtahistoricos[$i][$position]==0 or is_null($vtahistoricos[$i][$position]) or  $vtahistoricos[$i][$position]=="" ){

            array_push( $combinadovta,0);
        }
        else{
            array_push( $combinadovta,$vtahistoricos[$i][$position]);
        }

    }
    else{
        array_push( $combinadovta,$ajustadovtagraph[$i][0]);
    }
}
for($i=0 ;$i<$columnas;$i++){
    $pivotinvf[$i][0] = $nombremeses[$i];
for($j=0 ;$j<count($vtahistoricos[0]);$j++) {
if($j==(count($vtahistoricos[0])-1)){
    $pivotinvf[$i][$j+1] = $vtahistoricos[$i][$j];
    $pivotinvf[$i][$j+1] = $combinadovta [$i];

}
else{
    $pivotinvf[$i][$j+1] = $vtahistoricos[$i][$j];
}
}

}
$graphcl=count( $pivotinvf[0]);
for($i=0;$i<1;$i++){
    $grafica.="[";

    for($j=0;$j<$graphcl;$j++){
         if($j==0)
        {
            $grafica=$grafica."'MES',";

        }
/*
       ELSE if($j==($graphcl-1) )
        {
            $grafica=$grafica."'COMBINADO-".$pivotinvf[$i][$j]."'";

        }*/
        else{

            if($pivotinvf[$i][$j]==$year){
                $grafica=$grafica."'COMBINADO-".$pivotinvf[$i][$j]."'";
            }
            else{

                $grafica=$grafica."'".$pivotinvf[$i][$j]."',";
            }



        }





    }
    $grafica.="],";





}
for($i=1;$i<count($pivotinvf);$i++){
    $grafica.="[";

    for($j=0;$j<count( $pivotinvf[0]);$j++){

        if($j==count($pivotinvf[0])-1)
        {
          switch ($pivotinvf[$i][$j]) {
            case '' :
                $grafica=$grafica. 0;// code...
              break;

            default:
              $grafica=$grafica. $pivotinvf[$i][$j];  // code...
              break;
          }


        }
        else{

          
            switch ($pivotinvf[$i][$j]) {
              case '' :
                  $grafica=$grafica. 0 .",";// code...
                break;

              default:
                $grafica=$grafica. $pivotinvf[$i][$j].",";  // code...
                break;
            }
        }





    }
    $grafica.="],";





}
$grafica=substr($grafica,0,strlen($grafica)-1 );



?>
<script type="text/javascript">
    google.charts.load('current', {'packages':['table']});

    google.charts.setOnLoadCallback(drawCharts2);

    /* función que carga cada uno de los gráficos */
    function drawCharts2() {
        var dataTable = google.visualization.arrayToDataTable([<?PHP echo $union=$columnname.$estructurahistorico.",".$estructuramg.",".$estructuramgly.",".$data3ppto  ?>]);

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


        var chart   = new google.visualization.Table(document.getElementById('table'));





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
<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawVisualization1);

    function drawVisualization1() {
        // Some raw data (not necessarily accurate)
        var data = google.visualization.arrayToDataTable([
            <?PHP



            echo $grafica ?>
        ]);

        var options = {
            title:'VENTAS',

            titleTextStyle: {


                fontSize: 20
            },
            fontSize:10,
            width:'50%',
            legend: { position: 'top', maxLines: 1 },
            <?PHP
            IF(count($vtahistoricos[0])==4){
                echo"colors: ['blue','red', 'orange','black'],";
            }
            else IF(count($vtahistoricos[0])==3){
                echo"colors: ['blue', 'orange','black'],";
            }
            else IF(count($vtahistoricos[0])==2){
                echo"colors: ['orange','black'],";
            }
            else IF(count($vtahistoricos[0])==1){
                echo"colors: ['black'],";
            }
            ?>

            pointShape: 'diamond',
            pointsVisible: true






        };

        var chart = new google.visualization.LineChart(document.getElementById('item2'));
        chart.draw(data, options);
google.visualization.events.addListener(chart, 'sort',
            function(event) {

                /*dataTable.sort([{column: event.column, desc: !event.ascending}]);*/
                chart.draw(data,options,{allowHtml: true});

            }
        );
    }

    $(window).resize(function(){
        drawVisualization1();
    });


</script>
