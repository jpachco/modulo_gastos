/**
 * 
 */
import {taju} from './table_ajustado.js';
import {all_fam,all_mar} from './load_filters.js';
 
  $('body').on('click','#broswer', function(){
              var familia = '';
              var val_fam = document.getElementById('familia');
              for (let i = 0; i < val_fam.length; i++) {
                  if (val_fam[i].selected) {
                      familia += "'" + val_fam[i].value + "',";
                  }
              }
              var familia = familia.slice(0, familia.length - 1);
              var marca = '';
              var val_mar = document.getElementById('marca');
              for (let i = 0; i < val_mar.length; i++) {
                  if (val_mar[i].selected) {
					  
                      marca += "'" + val_mar[i].value + "',";
                  }
              }
              var marca = marca.slice(0, marca.length - 1);
      
      
    
    //-------------------------FILTRO PARA OCULTAR PESTAÑA PRESUPUESTO-----------------------------------------//
   
            const familiaArray = familia.replace(/'/g, '').split(',').map(f => f.trim());
            const marcaArray = marca.replace(/'/g, '').split(',').map(f => f.trim());

        
            if (familiaArray.length > 1 && marcaArray.length >1) {   
                 $('#presupuesto_O').hide();
                console.log("Se ocultó la pestaña Presupuesto porque tanto la marca como la familia son mayores a 1");
            }else if (familiaArray.length > 1 ) {
                $('#presupuesto_O').hide();
                console.log("Se ocultó la pestaña Presupuesto porque tanto la marca como la familia son mayores a 1");
            }else if (marcaArray.length > 1 ) {
                $('#presupuesto_O').hide();
                console.log("Se ocultó la pestaña Presupuesto porque tanto la marca como la familia son mayores a 1");
            }else {
            $('#presupuesto_O').show();
            console.log("Se mostró la pestaña Presupuesto porque no se cumplen todas las condiciones");
            }
    //-------------------------------------------------------------------------------------------------------// 
              
                 var modelos = '';
                 var colores = '';
              var val_mod = document.getElementById('modelos');
              for (let i = 0; i < val_mod.length; i++) {
                  if (val_mod[i].selected) {
					  
					  let explode= val_mod[i].value;
					  	  explode=explode.split("|");
					  
                      modelos += "'" + explode[0]+ "',";
                      colores += "'" + explode[1]+ "',";
                  }
              }
              var modelos = modelos.slice(0, modelos.length - 1);
              var colores = colores.slice(0, colores.length - 1);
               if ($('#year').val() === null) {
                   $('#modal-footer').append(
                       '       <div class="alert alert-danger alert-dismissable fade in">' +
                       '<button type="button" data-dismiss="alert" aria-label="close" class="close">' +
                       '<span aria-hidden="true">×</span></button><strong>Error: ' +
                       '</strong>El campo año esta vacio.</div>'
                   )
               }
              if (marca === null  ||marca === '' ) {
                  $('#modal-footer').append(
                      '       <div class="alert alert-danger alert-dismissable fade in">' +
                      '<button type="button" data-dismiss="alert" aria-label="close" class="close">' +
                      '<span aria-hidden="true">×</span></button><strong>Error: ' +
                      '</strong>El campo Marca esta vacio.</div>'
                  )
              }
              if (familia === null  ||familia === '' ) {
                  $('#modal-footer').append(
                      '       <div class="alert alert-danger alert-dismissable fade in">' +
                      '<button type="button" data-dismiss="alert" aria-label="close" class="close">' +
                      '<span aria-hidden="true">×</span></button><strong>Error: ' +
                      '</strong>El campo Familia esta vacio.</div>'
                  )
              }
               else {

                   $('#table').empty();
                   $('#table-ppto').empty();
                   $('#table-ajustado').empty();
                   $('#table-ajustado1').empty();
                   $('#table-pedido').empty();
                   $('#table-pedido1').empty();
                   $('#table-porcentaje').empty();
                   $('#item1').empty();
                   $('#item2').empty();
                   $('#item3').empty();
                   setTimeout(function () {
                                       var pedido = 'marca=' + marca.trim() + '&year=' + $('#year').val().trim() + '&familia=' + familia + '&temp=' + $('#type').val().trim() +'&modelos='+modelos+'&colores='+colores;

                       $('#title-angle').empty();
                       $('#title-date').empty();
                       const fecha = new Date();
                       const hoy = fecha.getDate() + "/" + (fecha.getMonth() + 1) + "/" + fecha.getFullYear();
                       $('#title-date').append("Fecha de Consulta: " + hoy);
                      

                       if (all_mar === 1 && all_fam === 1) {
                           $('#title-angle').append("Familias*" + "-" + "Marcas*" + "-" + $('#year').val().trim());
                       } else if (all_fam === 1 && all_mar === 0) {
                           $('#title-angle').append("Familias*" + "-" + marca.trim() + "-" + $('#year').val().trim());
                       } else if (all_mar === 1 && all_fam === 0) {
                           $('#title-angle').append(familia + "-" + "Marcas*" + "-" + $('#year').val().trim());
                       } else {
                           $('#title-angle').append(familia + "-" + marca.trim() + "-" + $('#year').val().trim());

                       }
                       var filtro = 'familia=' + familia +
                           '&marca=' + marca +
                           '&categoria=' + $('#type').val().trim() +
                           '&anio=' + $('#year').val().trim();
                       $.ajax({
                           type: 'POST',
                           url: 'formularios/presupuestos_ro/php/busqueda.php',
                           data: filtro,
                           success: function (respuesta) {
                               if (respuesta != '') {
                                   $('#respuesta').empty();
                                   $('#respuesta').append(respuesta);
                               } else {
                                   alert('No se encontro Presupuesto , valida los filtros seleccionados');
                               }
                           },
                           error: function () {
                               alert('No se encontro Presupuesto , valida los filtros seleccionados');
                           }
                       });43
                       $.ajax({
                           type: 'POST',
                           url: 'SELL&OPR/queries/pedidos.php',
                           data: pedido, 
                           beforeSend: function () {
                               $('#loading').modal('show');
                               //$('body').addClass('loading'); //Agregamos la clase loading al body
                           },
                           success: function (respuesta) {
                               if (respuesta != '') {
                                   $('#table-porcentaje').empty();
                                   $('#table-pedido').empty();
                                   $('#item3').empty();
                                   $('#tp').append(respuesta);


                               } else {
                                   alert('Valores vacios')
                               }
                           },
                           error: function () {
                               alert('Error en la peticion ajax');


                           }
                       });
                       /*var ppto = 'marca=' + marca.trim() + '&year=' + $('#year').val().trim() + '&familia=' + familia + '&temp=' + $('#type').val().trim();
                       $.ajax({
                           type: 'POST',
                           url: 'SELL&OPM/queries/ventas_ppto.php',
                           data: ppto,
                           success: function (respuesta) {
                               if (respuesta != '') {

                                   $('#table-ppto').empty();
                                   $('#table-ppto').append(respuesta);


                               } else {
                                   alert('Valores vacios')
                               }
                           },
                           error: function () {
                               alert('Error en la peticion ajax');

                           }
                       });*/
                       var historico = 'marca=' + marca.trim() + '&year=' + $('#year').val().trim() + '&familia=' + familia + '&temp=' + $('#type').val().trim()+'&modelos='+modelos+'&colores='+colores;
                       $.ajax({
                           type: 'POST',
                           url: 'SELL&OPR/queries/historico_ventas.php',
                           data: historico,
                           success: function (respuesta) {
                           
                           console.log(historico);
                               if (respuesta != '') {

                                   $('#table').empty();
                                   $('#item2').empty();

                                   $('#ph').append(respuesta);


                               } else {
                                   alert('Valores vacios')
                               }
                           },
                           error: function () {
                               alert('Error en la peticion ajax');

                           }
                       });
                       var ajustado = 'marca=' + marca.trim() + '&year=' + $('#year').val().trim() + '&familia=' + familia + '&temp=' + $('#type').val().trim()+'&modelos='+modelos+'&colores='+colores;
					
                
          					 $.ajax({
                           type: 'POST',
                           url: 'SELL&OPR/queries/table_ajustado_new.php',
                           data: ajustado,
                           success: function (respuesta) {


                               $('#table-ajustado').empty();
                               $('#table-ajustado1').empty();
                               $('#item1').empty();

                               $('#pc').append(respuesta);


                               setTimeout(function () {
                                   // $('body').removeClass('loading');
                                   $('#loading').modal('hide');
                                   taju();
                                   
                                   
                                          }, 2000);
                               setTimeout(function () {
                                  // $('.cubrimiento_on').hide();
                                   $('.venta_on').hide();
                                   $('.inv_on').hide();
                                   $('.comp_on').hide();
                                   $('.comp_rp').hide();
                                   $('.invf_on').hide();
                               }, 2500);


                           },
                           error: function () {
                               alert('Error en la peticion ajax');

                           }
                       });
          
          
          
                       all_fam = 0;
                       all_mar = 0;

                   }, 1000);


               }
            });