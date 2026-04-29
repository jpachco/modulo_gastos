<?php

  include('conexiones/local.php');

  session_start();
  if ($_SESSION['usuario'] == null || $_SESSION['usuario'] == ''){
    header('Location: ../index.html');
    die();
  }

  error_reporting(0);
  mysqli_set_charset($conexion_lcl,"utf8");

  date_default_timezone_set('America/Mexico_City');
  $fecha = date("d/m/Y");

  $correo = htmlspecialchars(strtolower($_POST['correo']));
  $nombre = htmlspecialchars(html_entity_decode($_POST['nombre'], ENT_QUOTES | ENT_HTML401, "UTF-8"));
  $apellidom = htmlspecialchars(html_entity_decode($_POST['apellidom'], ENT_QUOTES | ENT_HTML401, "UTF-8"));
  $apellidop = htmlspecialchars(html_entity_decode($_POST['apellidop'], ENT_QUOTES | ENT_HTML401, "UTF-8"));
  $celular = htmlspecialchars($_POST['celular']);
  $cp = htmlspecialchars($_POST['cp']);
  $datepicker = htmlspecialchars($_POST['datepicker']);
  $rfc = htmlspecialchars(strtoupper($_POST['rfc']));
  $ticket = htmlspecialchars($_POST['ticket']);
  $sucursal = htmlspecialchars($_SESSION['usuario']);

//$respuesta = '';

  if ($_SESSION['id'] != '' && $_SESSION['tipo_id'] != '') {
      $mi_id = $_SESSION['id'];
      $tipo_id = $_SESSION['tipo_id'];
  }else {
    if ($correo != '') {
      $mi_id  = $correo;
      $tipo_id = 'correo';
    }elseif ($celular != '') {
      $mi_id  = $celular;
      $tipo_id = 'celular';
    }
  }


//////
//codigo para los prefijos
/////
$largo = strlen($_SESSION['usuario']);
  $usuario = $_SESSION['usuario'];
  $usuario = $usuario[0]; 

  $prefijo = '5';


  if ($largo == 5) {
    $prefijo = '4';
  }

  if ($usuario == 'B') {
    $prefijo = '6';
  }
   

  switch ($prefijo) {
    case '4':
      $prefijo = '0000P';
      break;

    case '5':
      $prefijo = '00000P';
      break;

    case '6':
      $prefijo = '000000';
      break;
    
    default:
      # code...
      break;
  }









////////


//$respuesta .= 'miId --> '.$mi_id.'<br>';
//$respuesta .= 'tipoId --> '.$tipo_id.'<br>';

  $sql = "SELECT * FROM clientes_contactos where id = '$mi_id'";
  $query = mysqli_query( $conexion_lcl, $sql);
  $resultado = mysqli_num_rows($query);

//$respuesta .= 'Cliente igual --> '.$resultado.'<br>';

if ($ticket != ''){
  $ticket = $prefijo.$sucursal.$ticket;

  $id = $mi_id.'|'.$ticket;
  $valida_ticket = "SELECT * FROM transacciones where ticket = '$ticket'";
  $ticket_validado = mysqli_query( $conexion_lcl, $valida_ticket);
  $tickets = mysqli_num_rows($ticket_validado);

  //$respuesta .= 'Tickets iguales -->'.$tickets.'<br>';
echo ''.$tickets.'<br>';
  if ($tickets == 0) {
    $insertar_ticket = "INSERT INTO transacciones (id_cc, ticket, id, fecha_ticket)
                          VALUES ('$mi_id','$ticket','$id', '$fecha')";
    /*if ($sucursal == ''){
      header('Location: ../index.html');
      die();
    }*/
    $ticket_insertado = mysqli_query($conexion_lcl, $insertar_ticket);

    if ($ticket_insertado) {
      echo 'Exito ticket';
      //$respuesta .= 'Exito';
    }
    else{
      echo '';
      die();
    }
  }

}


  if ($resultado > 0){
    while( $row = mysqli_fetch_array($query)){
      $idBase = $row['id'];
    }
    //$respuesta .= 'Id bdd --> '.$idBase.'<br>';
    if ($tipo_id == 'correo') {
      if ($mi_id == $correo) {
        $modificar = "UPDATE clientes_contactos
                      SET  nombre = '$nombre'
                          ,apellido_materno = '$apellidom'
                          ,apellido_paterno = '$apellidop'
                          ,celular = '$celular'
                          ,cp = '$cp'
                          ,nacimiento = '$datepicker'
                          ,rfc = '$rfc'
                      WHERE id = '$mi_id'
                      ";
        //$respuesta .='Mi id es -->  '.$mi_id.'   mi correo es -->  '.$correo.'<br>';
      }else {
        $modificar = "UPDATE clientes_contactos
                        SET  id = '$correo'
                            ,correo = '$correo'
                            ,nombre = '$nombre'
                            ,apellido_materno = '$apellidom'
                            ,apellido_paterno = '$apellidop'
                            ,celular = '$celular'
                            ,cp = '$cp'
                            ,nacimiento = '$datepicker'
                            ,rfc = '$rfc'
                        WHERE id = '$mi_id'
                        ";

        $modificar_tickets = "UPDATE transacciones
                                SET id = CONCAT('$correo',RIGHT(id,LENGTH(id)-LOCATE('|',id)+1))
                                   ,id_cc = '$correo'
                              WHERE id_cc ='$mi_id'";

        //$respuesta .= 'Mi id es --> '.$mi_id.'   mi correo es -->  '.$correo.'<br>';
      }
    }else{
      if ($mi_id == $celular) {
        $modificar = "UPDATE clientes_contactos
                        SET  correo = '$correo'
                            ,nombre = '$nombre'
                            ,apellido_materno = '$apellidom'
                            ,apellido_paterno = '$apellidop'
                            ,cp = '$cp'
                            ,nacimiento = '$datepicker'
                            ,rfc = '$rfc'
                        WHERE id = '$mi_id'
                        ";
        //$respuesta .='Mi id es -->  '.$mi_id.'   mi celular es -->  '.$celular.'<br>';
      }else {
        $modificar = "UPDATE clientes_contactos
                        SET  id = '$celular'
                            ,correo = '$correo'
                            ,nombre = '$nombre'
                            ,apellido_materno = '$apellidom'
                            ,apellido_paterno = '$apellidop'
                            ,celular = '$celular'
                            ,cp = '$cp'
                            ,nacimiento = '$datepicker'
                            ,rfc = '$rfc'
                        WHERE id = '$mi_id'
                        ";
          $modificar_tickets = "UPDATE transacciones
                                    SET id = CONCAT('$celular',RIGHT(id,LENGTH(id)-LOCATE('|',id)+1))
                                       ,id_cc = '$celular'
                                    WHERE id_cc ='$mi_id'";

        //$respuesta .='Mi id es -->  '.$mi_id.'   mi celular es --> '.$celular.'<br>';
      }
    }




    $resultado_modificar = mysqli_query($conexion_lcl,$modificar);
    if ($resultado_modificar) {
      echo 'Exito m';
      //$respuesta .= 'Respuesta (modificar cc) --> Exito<br>';
    }
    else{
      echo '';
      die();
    }

    $resultado_modificar_tickets = mysqli_query($conexion_lcl,$modificar_tickets);
    if ($resultado_modificar_tickets) {
      echo 'Exito mt';
      //$respuesta .= 'Respuesta (modificar trans) --> Exito<br>';
    }
    else{
      echo '';
      die();
    }


  }else{
    $insertar = "INSERT INTO clientes_contactos (id, correo, nombre, apellido_materno, apellido_paterno,
                                                 celular, cp, nacimiento, rfc, sucursal, fecha_alta)
                    VALUES ('$mi_id'
                           ,'$correo'
                           ,'$nombre'
                           ,'$apellidom'
                           ,'$apellidop'
                           ,'$celular'
                           ,'$cp'
                           ,'$datepicker'
                           ,'$rfc'
                           ,'$sucursal'
                           ,'$fecha'
                         )";
      if ($sucursal == ''){
        header('Location: ../index.html');
        die();
      }
      $resultado_insertar = mysqli_query ($conexion_lcl, $insertar);
      if ($resultado_insertar) {
        echo 'Exito cc';
        //$respuesta .= 'Respuesta (insertar cc) --> Exito<br>';
      }
      else{
        echo '';
        die();
      }
}


unset($_SESSION['id']);
unset($_SESSION['tipo_id']);

  //echo $respuesta;

/*
      if ($tipo_id == 'correo') {
        if ($correo == $idBase) {
        $modificar = "UPDATE clientes_contactos
                        SET  nombre = '$nombre'
                            ,apellido_materno = '$apellidom'
                            ,apellido_paterno = '$apellidop'
                            ,celular = '$celular'
                            ,cp = '$cp'
                            ,nacimiento = '$datepicker'
                            ,rfc = '$rfc'
                        WHERE id = '$mi_id'
                        ";
      }else{
        $modificar = "UPDATE clientes_contactos
                        SET  correo = '$correo'
                            ,nombre = '$nombre'
                            ,apellido_materno = '$apellidom'
                            ,apellido_paterno = '$apellidop'
                            ,celular = '$celular'
                            ,cp = '$cp'
                            ,nacimiento = '$datepicker'
                            ,rfc = '$rfc'
                        WHERE id = '$mi_id'
                        ";
      }
    }else{
      if ($celular == $idBase) {
      $modificar = "UPDATE clientes_contactos
                      SET  correo = '$correo'
                          ,nombre = '$nombre'
                          ,apellido_materno = '$apellidom'
                          ,apellido_paterno = '$apellidop'
                          ,cp = '$cp'
                          ,nacimiento = '$datepicker'
                          ,rfc = '$rfc'
                      WHERE id = '$mi_id'
                      ";
    }else{
      $modificar = "UPDATE clientes_contactos
                      SET  correo = '$correo'
                          ,nombre = '$nombre'
                          ,apellido_materno = '$apellidom'
                          ,apellido_paterno = '$apellidop'
                          ,celular = '$celular'
                          ,cp = '$cp'
                          ,nacimiento = '$datepicker'
                          ,rfc = '$rfc'
                      WHERE id = '$mi_id'
                      ";
    }
    }else{
      if ($tipo_id == 'correo') {
        $modificar = "UPDATE clientes_contactos
                        SET  id = '$correo'
                            ,correo = '$correo'
                            ,nombre = '$nombre'
                            ,apellido_materno = '$apellidom'
                            ,apellido_paterno = '$apellidop'
                            ,celular = '$celular'
                            ,cp = '$cp'
                            ,nacimiento = '$datepicker'
                            ,rfc = '$rfc'
                            ,correo_anterior = '$mi_id'
                            ,fecha_modificacion = '$fecha'
                        WHERE id = '$idBase'
                        ";
      }else{
        $modificar = "UPDATE clientes_contactos
                        SET  id = '$celular'
                            ,correo = '$correo'
                            ,nombre = '$nombre'
                            ,apellido_materno = '$apellidom'
                            ,apellido_paterno = '$apellidop'
                            ,celular = '$celular'
                            ,cp = '$cp'
                            ,nacimiento = '$datepicker'
                            ,rfc = '$rfc'
                            ,correo_anterior = '$mi_id'
                            ,fecha_modificacion = '$fecha'
                        WHERE id = '$idBase'
                        ";
      }


       $modificar_tickets = "UPDATE transacciones
                                SET id = CONCAT('$id_cc',RIGHT(id,LENGTH(id)-LOCATE('|',id)+1))
                                   ,id_cc = '$id_cc'
                                WHERE id ='$idBase'";
    }

    $resultado_modificar = mysqli_query($conexion_lcl,$modificar);
    if (!$resultado_modificar) {
      echo("Error description: " . mysqli_error($conexion_lcl));
    }
    else{
      echo 1;
    }

    $resultado_modificar_tickets = mysqli_query($conexion_lcl,$modificar_tickets);
    if (!$resultado_modificar_tickets) {
      echo("Error description: " . mysqli_error($conexion_lcl));
    }
    else{
      echo 1;
    }

  }else{
      $insertar = "INSERT INTO clientes_contactos (id, correo, nombre, apellido_materno, apellido_paterno,
                                                   celular, cp, nacimiento, rfc, sucursal, fecha_alta)
                     VALUES ('$mi_id'
                             ,'$correo'
                             ,'$nombre'
                             ,'$apellidom'
                             ,'$apellidop'
                             ,'$celular'
                             ,'$cp'
                             ,'$datepicker'
                             ,'$rfc'
                             ,'$sucursal'
                             ,'$fecha'
                           )";
        if ($sucursal == ''){
          header('Location: ../index.html');
          die();
        }
        $resultado_insertar = mysqli_query ($conexion_lcl, $insertar);
        if (!$resultado_insertar) {
          echo("Error description: " . mysqli_error($conexion_lcl));
        }
        else{
          echo 1;
        }
  }

    if ($ticket != '') {
      $ticket = '00000P'.$sucursal.$ticket;

      $id = $mi_id.'|'.$ticket;
      $valida_ticket = "SELECT * FROM transacciones where ticket = '$ticket'";
      $ticket_validado = mysqli_query( $conexion_lcl, $valida_ticket);
      $tickets = mysqli_num_rows($ticket_validado);

      if ($tickets <= 0) {
        $insertar_ticket = "INSERT INTO transacciones (id_cc, ticket, id, fecha_ticket)
                              VALUES ('$mi_id','$ticket','$id', '$fecha')";
        if ($sucursal == ''){
          header('Location: ../index.html');
          die();
        }
        $ticket_insertado = mysqli_query($conexion_lcl, $insertar_ticket);

        if (!$ticket_insertado) {
          echo("Error description: " . mysqli_error($conexion_lcl));
        }
        else{
          echo 1;
        }
      }

    }
*/
?>
