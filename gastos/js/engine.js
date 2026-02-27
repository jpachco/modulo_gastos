
$(document).ready(function() {

    tabla();


    function tabla(){
        var data = '';
        $.ajax({
            type: 'POST',
            url: 'Queries/data_colect.php',
            data: data,
            success: function(respuesta){
                if (respuesta != '') {
                    $('#container').append(respuesta);


                }else {
                    swal('Ooops!!!', 'Presiona F5 para continuar', 'warning');
                }
            },
            error:function(){
                swal('Ooops!!!', 'Contacta a tu administrador', 'error');
            }
        });
    }






});
