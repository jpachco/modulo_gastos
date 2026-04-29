<?php include "connsqlsrv.php";
global $conn;


//se genera la consulta
$clientes=array();
$i=0;




$sql=utf8_decode( "select 
id_cc,
ticket,
case when position('P' in ticket) then substring(ticket,position('P' in ticket)+1,4)
     else substring(ticket,position('B' in ticket),4) end as sucursal,
id,
str_to_date(fecha_ticket, \"%d/%m/%Y\") as 'Fecha'

from  transacciones
where fecha_ticket is not null and fecha_ticket<>'' 


");

$clientesrow=array();




if(!$result =mysqli_query($conn, $sql)) {
    die();
    //echo "Error al registrarse";

}
//Resultado de consulta
while($row =  mysqli_fetch_array($result))
{
    $clientes[$i] = $row ;

    $i++;

}
mysqli_close($conn);

$columnas = count($clientes[0])/2;///2;
$filas = count($clientes);
$namecolumn=array();

for($i=1;$i<count($clientes[0]);$i=$i+2){


        next($clientes[0]);


        array_push($namecolumn,"<th>".key($clientes[0])."</th>");

        next($clientes[0]);






}









for($i=0;$i<$filas;$i++ ){

    array_push($clientesrow,"<tr>");
    for($j=0;$j<$columnas;$j++ ){




        array_push($clientesrow,"<td>".utf8_encode( $clientes[$i][$j])."</td>");








    }
    array_push($clientesrow,"</tr>");


}
$cuentadatos=count($clientesrow);

$rowclientes="";
$headerclientes="";


for ($i=0;$i<$cuentadatos;$i++){



    $rowclientes=$rowclientes.$clientesrow[$i];



}


for ($i=0;$i<$columnas;$i++){



    $headerclientes =$headerclientes.$namecolumn [$i];



}

echo"<tr>".$headerclientes."</tr>";
echo $rowclientes;





?>



