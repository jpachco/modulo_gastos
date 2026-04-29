<?php
  error_reporting(0);
  session_start();
  if ($_SESSION['usuario'] == null || $_SESSION['usuario'] == ''){
    header('Location: ../index.html');
    die();
  }

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

?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>

    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/alertify.css">
    <link rel="stylesheet" href="../css/styles.css">
    <script src="../js/fontawesome-all.js" charset="utf-8"></script>
    <script src="../js/jquery-3.3.1.min.js" charset="utf-8"></script>
    <script src="../js/alertify.js" charset="utf-8"></script>
    <script src="../js/funciones.js" charset="utf-8"></script>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  </head>
  <body>
    <header>
      <h1>Clientes y Contactos </h1>
    </header>
    <section id="formulario">
      <form id='form_insertar' onsubmit='return false;' method='post' autocomplete='off'>
        <label class='label' for='correo'> <i class='far fa-envelope'></i> Correo</label>
        <label class='label ' for='telefono'> <i class='fas fa-mobile-alt'></i> Celular</label>
        <label class='label menu' id='nuevo'> <i class="fas fa-user-plus"></i> Nuevo</label>
        <label class='label menu' id='editar'> <i class="far fa-edit"></i> Editar</label>
        <label class='label menu' id='salir'> <i class="fas fa-power-off"></i> Salir</label>

        <input class='input' type='text' id='correo' autofocus>
        <input class='input' type='text' id='celular' maxlength='10' onkeypress='return valida(event);'>
        <input class='input' type='text' id='oculto'>

        <label class='label' for='nombre'> <i class='fas fa-user'></i> Nombre(s)</label>
        <label class='label' for='apellido'> <i class='fas fa-user'></i> Apellido Paterno</label>
        <label class='label' for='apellido'> <i class='fas fa-user'></i> Apellido Materno</label>

        <input class='input' type='text' id='nombre'>
        <input class='input' type='text' id='apellidop'>
        <input class='input' type='text' id='apellidom'>

        <label class='label' for='nacimiento'> <i class='fas fa-birthday-cake'></i> Fecha de Nacimiento</label>
        <label class='label' for='telefono'> <i class='fas fa-map-marker-alt'></i> Codigo Postal</label>
        <label class='label' for='rfc'><i class='fas fa-address-card'></i> RFC</label>


        <input class='input' type='text' id='datepicker' readonly>
        <input class='input' type='text' id='cp' maxlength='5' onkeypress='return valida(event);'>
        <input class='input' type='text' id='rfc'>


        <label class='label' for='ticket'><i class='fas fa-ticket-alt'></i> Ticket</label>
        <label class='label' id='oculto'><i class='fas fa-ticket-alt'></i> </label>
        <label class='label' id='oculto'><i class='fas fa-ticket-alt'></i> </label>


        <article class="footer">
          <span><?php echo $prefijo.$_SESSION['usuario'] ?></span> <input class='input ticket_footer' type='text' id='ticket' onkeypress='return valida(event);' maxlength='9'>
          <input class='btn btn-primary boton_footer' type='button' id='registrar' value='Registrar'>
        </article>
      </form>
    </section>
  </body>

  <script>

  $.datepicker.regional['es'] = {
  closeText: 'Cerrar',
  prevText: '< Ant',
  nextText: 'Sig >',
  currentText: 'Hoy',
  monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
  monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
  dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
  dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
  dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
  weekHeader: 'Sm',
  dateFormat: 'dd/mm/yy',
  firstDay: 1,
  isRTL: false,
  showMonthAfterYear: false,
  yearSuffix: ''
  };
  $.datepicker.setDefaults($.datepicker.regional['es']);

  $( function() {
    $( "#datepicker" ).datepicker({
      changeMonth: true,
      changeYear: true,
      yearRange: "1900:2050"
    });
  } );

    function valida(e){
        tecla = (document.all) ? e.keyCode : e.which;
        if (tecla==8){
            return true;
        }
        patron =/[0-9]/;
        tecla_final = String.fromCharCode(tecla);
        return patron.test(tecla_final);
    }
    </script>

</html>
