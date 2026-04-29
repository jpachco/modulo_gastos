<?php
session_start();


date_default_timezone_set('America/Mexico_City');
$dtz =new DateTimeZone("America/Mexico_City");
$dt = new DateTime("now", $dtz);
setlocale(LC_ALL,"es_MX");


header("Cache-control: private");
header("Cache-control: no-cache, must-revalidate");
header("Pragma: no-cache");




if(isset( $_SESSION['userid'])  )

{

    if ( (
           // strpos( $_SESSION['userid'], 'jmasri') !== false ||
            //strpos( $_SESSION['userid'], 'nmartin') !== false ||
            strpos( $_SESSION['userid'], '%') !== false  ||
            strpos( $_SESSION['userid'], 'omartinezp') !== false
            //strpos( $_SESSION['userid'], 'dmondragon') !== false
        )
        && strpos( $_SESSION['userid'], '1') !== false ) {


include('conexiones/conexion.php');

  function execonsultamsqlsrv($query, $conect){
    $i = 0;
    $res = array();
    $output = array();

    if (!$result = sqlsrv_query($conect, $query)) {
        die();
        //echo "Error al registrarse";


    }


//Resultado de consulta
    while ($row = sqlsrv_fetch_array($result)) {


        $res[$i] = $row;

        $i++;


    }

    foreach ($res as $key) {


        foreach ($key as $llave => $value) {


            if (!is_int($llave) and !ctype_digit($llave) and $llave != '0') {


                $ciclo[$llave] = str_replace("\r\n", "", utf8_encode($value));


            }


        }


        array_push($output, $ciclo);


    }


    return $output;
}

$user_ignition=explode("/",$_SESSION['userid']);

$nusuario=$user_ignition[0];
$user= $nusuario;
$familia=$_SESSION['familia'] ;
$marca=$_SESSION['marca'] ;

    if(empty($_SESSION['categoria'])or $_SESSION['categoria']=='' ){
       die();
    }
    else{

        if($_SESSION['categoria'] !== "%"){
           $categoria="=".$_SESSION['categoria'];
        }
        else{
            $categoria="like  '%' ";
        }


    }

$anio=$_SESSION['anio'] ;

$nomes = $_POST['mes'];
  $nomes = count($nomes);

  $mes = $_POST['mes'];
  $ye = $_POST['anioL'];
  $pptovta = $_POST['pptovta'];
  $ajustevta = $_POST['ajustevta'];
  $plancompra = $_POST['plancompra'];
  $ajustecompra = $_POST['ajustecompra'];
  $pvp = $_POST['pvp'];
  $pcp = $_POST['pcp'];
  $cat= $_POST['cat'];




  $actualizar = '';
  $insercion = '';

  $data_ppto=execonsultamsqlsrv(utf8_decode("
  select 
      Anio,
         mes,
[PPTO DE VTA],
    [VTA AJUSTADO],
    [PLAN COMPRA],
    [COMPRA AJUSTADO],
    [PRECIO VTA],
    [COSTO COMPRA]


from presupuesto_ro
where familia = $familia
		and marca  = $marca
        and anio >= '$anio'
        and categoria  $categoria
      --  and Anio <> 2026
order by ANIO,mes
  "),$conexion);




   for ($i=0; $i < $nomes ; $i++) {



    if(sqlsrv_query( $conexion,"
    UPDATE presupuesto_ro
                     SET  [PPTO DE VTA]      =".$pptovta[$i]
                      .', [VTA AJUSTADO]     ='.$ajustevta[$i]
                      .', [PLAN COMPRA]      ='.$plancompra[$i]
                      .', [COMPRA AJUSTADO]  ='.$ajustecompra[$i]
                      .', [PRECIO VTA]  ='.$pvp[$i]
                      .', [COSTO COMPRA]  ='.$pcp[$i]
                        .' WHERE FAMILIA   ='.$familia
                     .' AND MARCA  ='.$marca
                     .' AND CATEGORIA ='."'".$cat[$i]."'"
                     .' AND ANIO       ='.$ye[$i]
                     .' AND MES       ='.$mes[$i].  ""   )){
                       $actualizar .= 'Exito';


                     }else{
                       echo '';
                       die;
                     }               
                     
  }
   for ($i=0; $i < count($data_ppto) ; $i++) {
    for ($j = 0; $j < $nomes; $j++) {


        if ($data_ppto[$i]['mes'] == $mes[$j] and $data_ppto[$i]['Anio']==$ye[$j]  ) {
            if($data_ppto[$i]['VTA AJUSTADO']<>$ajustevta[$j] || $data_ppto[$j]['COMPRA AJUSTADO']<>$ajustecompra[$j] ){
                if ( sqlsrv_query($conexion, "INSERT INTO presupuesto_ro_log
                        (
                         FAMILIA,
                        MARCA,
                        CATEGORIA,
                        ANIO,
                        MES,
                        [PPTO DE VTA],
                        [VTA AJUSTADO],
                        [PLAN COMPRA],
                        [COMPRA AJUSTADO],
                        [PRECIO VTA],
                        [COSTO COMPRA],
                        [USER],
                        [DATE]
                        )
                        VALUES" .
                    "(" . $familia . "," . $marca . ",'" . $cat[$j] . "'," . $ye[$j] . "," . $mes[$j] . "," . $pptovta[$j] . "," . $ajustevta[$j] . "," . $plancompra[$j] . "," . $ajustecompra[$j] . "," . $pvp[$j] . "," . $pcp[$j] . ",'" . $user . "',getdate() )")) {

                    $insercion .= 'Exito';
                } else {



                    die;
                }

            }


        }




    }
}
   echo "Los Presupuestos se han actualizado exitosamente.";


?>

    <?php

}




else{

    echo "No tienes permisos para actualizar el portal , verifica que tu usuario sea asignado correctamente.";
    ?>





    <?php

}


}

else{


   echo "No tienes permisos para actualizar el portal , verifica que tu usuario sea asignado correctamente.";

}