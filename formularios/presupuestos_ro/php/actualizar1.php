<?php

  include('conexiones/conexion.php');
  session_start();

  $familia = $_SESSION['familia'];
  $marca = $_SESSION['marca'];
  $categoria = $_SESSION['categoria'];
  $anio = $_SESSION['anio'];

  $nomes = $_POST['mes'];
  $nomes = count($nomes);

  $mes = $_POST['mes'];
  $pptovta = $_POST['pptovta'];
  $ajustevta = $_POST['ajustevta'];
  $plancompra = $_POST['plancompra'];
  $ajustecompra = $_POST['ajustecompra'];

  $actualizar = '';

  for ($i=0; $i < $nomes ; $i++) {
    if(mysqli_query( $conexion,"UPDATE presupuesto_ro
                     SET  `PPTO DE VTA`      =".$pptovta[$i]
                      .', `VTA AJUSTADO`     ='.$ajustevta[$i]
                      .', `PLAN COMPRA`      ='.$plancompra[$i]
                      .', `COMPRA AJUSTADO`  ='.$ajustecompra[$i]
                  .' WHERE FAMILIA    ='."'".$familia."'"
                     .' AND MARCA     ='."'".$marca."'"
                     .' AND CATEGORIA ='."'".$categoria."'"
                     .' AND ANIO      ='.$anio
                     .' AND MES       ='.$mes[$i]."")){
                       $actualizar .= 'Exito';
                     }else{
                       echo "Error: " . mysqli_error($conexion);
                       die;
                     }
  }
  echo $actualizar
?>
