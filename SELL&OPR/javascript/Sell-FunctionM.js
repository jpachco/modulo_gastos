
$(document).ready(function() {

    familias();


    function familias(){
        var data = '';
        $.ajax({
            type: 'POST',
            url: 'queries/familias.php',
            data: data,
            success: function(respuesta){
                if (respuesta != '') {
                    $('#fam').append(respuesta);


                }else {
                    swal('Ooops!!!', 'Presiona F5 para continuar', 'warning');
                }
            },
            error:function(){
                swal('Ooops!!!', 'Contacta a tu administrador', 'error');
            }
        });
    }

    $('body').on('change','#familia', function(){
        var familia = 'familia=' + $('#familia').val().trim();

        $.ajax({
            type: 'POST',
            url: 'queries/marcas.php',
            data: familia,
            success: function(respuesta){
                if (respuesta != '') {

                    $('#mar').empty();
                    $('#mar').append(respuesta);

                }else {

                    swal('Por favor', 'Elige una familia', 'warning');
                }
            },
            error:function(){
                swal('Ooops!!!', 'Contacta a tu administrador', 'error');
            }
        });
    });

















});
