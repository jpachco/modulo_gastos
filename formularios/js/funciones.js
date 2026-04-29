$(document).ready(function(){

  $('#ingresar').click(function(){
    if ($('#usuario').val().trim() == '') {
      alertify.error('Por favor, Ingresa tu usuario');
      $('#usuario').focus();
      return false;
    }
    else if ($('#clave').val().trim() == '') {
      alertify.error('Por favor, Ingresa tu contraseña');
      $('#clave').focus();
      return false;
    }

    datos = 'usuario=' + $('#usuario').val().trim() +
            '&clave=' + $('#clave').val().trim();

            $.ajax({
              type: 'POST',
              url: 'php/login.php',
              data: datos,
              success: function(r){
                if(r != ''){
                  $('#form_login')[0].reset();
                  window.location = ('php/index.php');
                }
                else {
                  alertify.alert('Datos incorrectos');
                  $('#form_login')[0].reset();
                }
              },
              error: function(){
                alertify.error(':\'(<br>Houston tenemos un problema');
              }
            });
  });


  $('#correo').keyup(function(e) {
    if(e.keyCode == 13) {

      var email = document.getElementById('correo');
      var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;


        if (!filter.test(email.value)) {
          alertify.error('Debes ingresar un correo valido');
          email.focus;
          return false;
        }

      datos = 'correo=' + $('#correo').val().trim();

      $.ajax({
        url : 'clientes_contactos.php',
        data : datos,
        type : 'POST',
        success : function(response) {
          if (response != '') {
            var cliente = JSON.parse(response);
            $('#nombre').val(cliente.nombre);
            $('#apellidom').val(cliente.apellido_materno);
            $('#apellidop').val(cliente.apellido_paterno);
            $('#celular').val(cliente.celular);
            $('#cp').val(cliente.cp);
            $('#datepicker').val(cliente.nacimiento);
            $('#rfc').val(cliente.rfc);
            $('#ticket').focus();

            $('#nombre').attr("readonly","readonly");
            $('#apellidom').attr("readonly","readonly");
            $('#apellidop').attr("readonly","readonly");
            $('#cp').attr("readonly","readonly");
            $("#datepicker").datepicker("option", "disabled", true);
            $('#rfc').attr("readonly","readonly");

            $('#nombre').addClass("no_editar");
            $('#apellidom').addClass("no_editar");
            $('#apellidop').addClass("no_editar");
            $('#cp').addClass("no_editar");
            $('#rfc').addClass("no_editar");
            $('#datepicker').addClass("no_editar");

          }else{
            alertify.alert('No existen usuarios con ese correo<br>Intenta con su telefono');
            $('#celular').focus();
          }
        },
        error : function() {
            alertify.alert('Disculpe, existió un problema');
        }
      });
    }
  });


  $("#correo").one('blur',function(){

    datos = 'correo=' + $('#correo').val().trim();

    $.ajax({
      url : 'clientes_contactos.php',
      data : datos,
      type : 'POST',
      success : function(response) {
        if (response != '') {
          var cliente = JSON.parse(response);
          $('#nombre').val(cliente.nombre);
          $('#apellidom').val(cliente.apellido_materno);
          $('#apellidop').val(cliente.apellido_paterno);
          $('#celular').val(cliente.celular);
          $('#cp').val(cliente.cp);
          $('#datepicker').val(cliente.nacimiento);
          $('#rfc').val(cliente.rfc);
          $('#ticket').focus();

          $('#nombre').attr("readonly","readonly");
          $('#apellidom').attr("readonly","readonly");
          $('#apellidop').attr("readonly","readonly");
          $('#cp').attr("readonly","readonly");
          $("#datepicker").datepicker("option", "disabled", true);
          $('#rfc').attr("readonly","readonly");

          $('#nombre').addClass("no_editar");
          $('#apellidom').addClass("no_editar");
          $('#apellidop').addClass("no_editar");
          $('#cp').addClass("no_editar");
          $('#rfc').addClass("no_editar");
          $('#datepicker').addClass("no_editar");
        }
      },
      error : function() {
          alertify.alert('Disculpe, existió un problema');
      }
  });

  });


  $('#celular').keyup(function(e) {
    if(e.keyCode == 13) {
      datos = 'celular=' + $('#celular').val().trim();

      $.ajax({
        url : 'clientes_contactos.php',
        data : datos,
        type : 'POST',
        success : function(response) {
          if (response != '') {
            var cliente = JSON.parse(response);
            $('#correo').val(cliente.correo);
            $('#nombre').val(cliente.nombre);
            $('#apellidom').val(cliente.apellido_materno);
            $('#apellidop').val(cliente.apellido_paterno);
            $('#celular').val(cliente.celular);
            $('#cp').val(cliente.cp);
            $('#datepicker').val(cliente.nacimiento);
            $('#rfc').val(cliente.rfc);
            $('#ticket').focus();

            $('#nombre').attr("readonly","readonly");
            $('#apellidom').attr("readonly","readonly");
            $('#apellidop').attr("readonly","readonly");
            $('#cp').attr("readonly","readonly");
            $("#datepicker").datepicker("option", "disabled", true);
            $('#rfc').attr("readonly","readonly");

            $('#nombre').addClass("no_editar");
            $('#apellidom').addClass("no_editar");
            $('#apellidop').addClass("no_editar");
            $('#cp').addClass("no_editar");
            $('#rfc').addClass("no_editar");
            $('#datepicker').addClass("no_editar");
          }else{
            alertify.alert('No existen usuarios con ese celular<br>Captura los datos');
            $('#nombre').focus();
          }
        },
        error : function() {
            alertify.alert('Disculpe, existió un problema');
        }
      });
    }
  });


  $('#registrar').click(function(){
    if($('#nombre').val().trim() == ''){
      alertify.alert('Debes ingresar un nombre');
      return false;
    }else if($('#apellidop').val().trim() == ''){
      alertify.alert('Debes ingresar un apellido paterno');
      return false;
    }else if($('#ticket').val().trim() != ''){
      var largo = $('#ticket').val().length;
      var valor = $('#ticket').val().trim();
      if (largo < 9) {
        alertify.alert('Para completar correctamente tu ticket, debes ingresar 9 digitos<br>Tu solo ingresaste ('+largo+') digitos -->'+valor);
        return false;
      }
    }
    if($('#celular').val().trim() != ''){
      var largo = $('#celular').val().length;
      var valor = $('#celular').val().trim();
      if (largo < 10) {
        alertify.alert('Para completar correctamente tu celular, debes ingresar 10 digitos<br>Tu solo ingresaste ('+largo+') digitos -->'+valor);
        return false;
      }
    }

    if ($('#correo').val().trim() == '' && $('#celular').val().trim() == '') {
      alertify.alert('Disculpa, para continuar<br>Debes ingresar el correo o el celular del cliente');
      return false;
    }

    if ($('#correo').val().trim() != '') {
      var email = document.getElementById('correo');
      var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

      if (!filter.test(email.value)) {
        alertify.error('Debes ingresar un correo valido');
        email.focus;
        return false;
      }
    }

    datos = 'correo=' + $('#correo').val().trim() +
            '&nombre=' + $('#nombre').val().trim() +
            '&apellidom=' + $('#apellidom').val().trim() +
            '&apellidop=' + $('#apellidop').val().trim() +
            '&celular=' + $('#celular').val().trim() +
            '&cp=' + $('#cp').val().trim() +
            '&datepicker=' + $('#datepicker').val().trim() +
            '&rfc=' + $('#rfc').val().trim() +
            '&ticket=' + $('#ticket').val().trim();

    $.ajax({
      url : 'insertar.php',
      data : datos,
      type : 'POST',
      success : function(response) {
        if (response != '') {
          alertify.confirm('Datos ingresados correctamente',function(){
            $('#form_insertar')[0].reset();
            //window.location = ('index.php');
          });
          //$('body').append(response);
        }else{
          console.log('Error');
          console.log(response);
        }
      },
      error : function() {
          alertify.alert('Disculpe, existió un problema');
      }
  });

  });

  $('#nuevo').click(function(){
    window.location = ('index.php');
  });

  $('#editar').click(function(){
    $('#nombre').removeAttr("readonly");
    $('#apellidop').removeAttr("readonly");
    $('#apellidom').removeAttr("readonly");
    $("#datepicker").datepicker("option", "disabled", false);
    $('#cp').removeAttr("readonly");
    $('#rfc').removeAttr("readonly");

    $('#nombre').removeClass("no_editar");
    $('#apellidom').removeClass("no_editar");
    $('#apellidop').removeClass("no_editar");
    $('#cp').removeClass("no_editar");
    $('#datepicker').removeClass("no_editar");
    $('#rfc').removeClass("no_editar");
  });

  $('#salir').click(function(){
    window.location = ('logout.php');
  });


});
