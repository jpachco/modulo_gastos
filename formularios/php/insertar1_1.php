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



  if ($_SESSION['correo'] != '') {
      $mi_correo = $_SESSION['correo'];
  }else {
    $mi_correo  = $correo;
  }


  $sql = "SELECT * FROM clientes_contactos where correo = '$mi_correo'";
  $query = mysqli_query( $conexion_lcl, $sql);
  $resultado = mysqli_num_rows($query);

  if ($resultado > 0){
    if ($mi_correo == $correo) {
      $modificar = "UPDATE clientes_contactos
                      SET  nombre = '$nombre'
                          ,apellido_materno = '$apellidom'
                          ,apellido_paterno = '$apellidop'
                          ,celular = '$celular'
                          ,cp = '$cp'
                          ,nacimiento = '$datepicker'
                          ,rfc = '$rfc'
                      WHERE correo = '$correo'
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
                          ,correo_anterior = '$mi_correo'
                          ,fecha_modificacion = '$fecha'
                      WHERE correo = '$mi_correo'
                      ";

       $modificar_tickets = "UPDATE transacciones
                                SET id = CONCAT('$correo',RIGHT(id,LENGTH(id)-LOCATE('|',id)+1))
                                   ,correo = '$correo'
                                WHERE correo ='$mi_correo'";
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
      $insertar = "INSERT INTO clientes_contactos (correo, nombre, apellido_materno, apellido_paterno,
                                                   celular, cp, nacimiento, rfc, sucursal, fecha_alta)
                     VALUES ('$correo'
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

      $id = $correo.'|'.$ticket;
      $valida_ticket = "SELECT * FROM transacciones where id = '$id'";
      $ticket_validado = mysqli_query( $conexion_lcl, $valida_ticket);
      $tickets = mysqli_num_rows($ticket_validado);

      if ($tickets <= 0) {
        $insertar_ticket = "INSERT INTO transacciones (correo, ticket, id, fecha_ticket)
                              VALUES ('$correo','$ticket','$id', '$fecha')";
        $ticket_insertado = mysqli_query($conexion_lcl, $insertar_ticket);

        if (!$ticket_insertado) {
          echo("Error description: " . mysqli_error($conexion_lcl));
        }
        else{
          echo 1;
        }
      }

    }

    unset($_SESSION['correo']);
?>
