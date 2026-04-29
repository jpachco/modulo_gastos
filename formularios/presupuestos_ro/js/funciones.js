// AL INICIO DEL ARCHIVO (fuera del document.ready)
import { taju } from '../../../SELL&OPR/javascript/table_ajustado.js';
import { all_fam, all_mar } from '../../../SELL&OPR/javascript/load_filters.js';

// Variables globales
let funcionesCargadas = true;

$(document).ready(function() {

  $('body').on('keypress', '.inputd', function(e) {
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla == 8) {
      return true;
    }
    patron = /[0-9]/;
    tecla_final = String.fromCharCode(tecla);
    return patron.test(tecla_final);
  });

  $('body').on('click', '.actualizar', function(e) {
    // CORREGIDO: Paréntesis para la URL
    var urlBase = 'formularios/presupuestos_ro/php/';
    var tipoCat = $('#type').val().trim();
    var urlActualizar = urlBase + (tipoCat === "'BASICO'" ? 'actualizar_bas.php' : 'actualizar.php');
    
    var presupuestos = $('form').serialize();
   
    $.ajax({
      type: 'POST',
      url: urlActualizar,
      data: presupuestos,
      success: function(respuesta) {
        if (respuesta != '') {
          // Las funciones ya están disponibles globalmente
          
          //$('body').on('click', '#broswer', function() {
            // Tu código existente aquí...
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
            
            // Usar las variables importadas
            const familiaArray = familia.replace(/'/g, '').split(',').map(f => f.trim());
            const marcaArray = marca.replace(/'/g, '').split(',').map(f => f.trim());
            
            if (familiaArray.length > 1 && marcaArray.length > 1) {
              $('#presupuesto_O').hide();
              console.log("Se ocultó la pestaña Presupuesto");
            } else if (familiaArray.length > 1) {
              $('#presupuesto_O').hide();
              console.log("Se ocultó la pestaña Presupuesto");
            } else if (marcaArray.length > 1) {
              $('#presupuesto_O').hide();
              console.log("Se ocultó la pestaña Presupuesto");
            } else {
              $('#presupuesto_O').show();
              console.log("Se mostró la pestaña Presupuesto");
            }
            
            // Modelos y colores
            var modelos = '';
            var colores = '';
            var val_mod = document.getElementById('modelos');
            if (val_mod) {
              for (let i = 0; i < val_mod.length; i++) {
                if (val_mod[i].selected) {
                  let explode = val_mod[i].value.split("|");
                  modelos += "'" + explode[0] + "',";
                  colores += "'" + explode[1] + "',";
                }
              }
              modelos = modelos.slice(0, modelos.length - 1);
              colores = colores.slice(0, colores.length - 1);
            }
            
            // Validaciones
            let hasError = false;
            if (!$('#year').val()) {
              $('#modal-footer').append('<div class="alert alert-danger">El campo año esta vacio.</div>');
              hasError = true;
            }
            if (!marca) {
              $('#modal-footer').append('<div class="alert alert-danger">El campo Marca esta vacio.</div>');
              hasError = true;
            }
            if (!familia) {
              $('#modal-footer').append('<div class="alert alert-danger">El campo Familia esta vacio.</div>');
              hasError = true;
            }
            
            if (!hasError) {
              $('#table, #table-ppto, #table-ajustado, #table-ajustado1, #table-pedido, #table-pedido1, #table-porcentaje').empty();
              $('#item1, #item2, #item3').empty();
              
              setTimeout(function() {
                var pedido = 'marca=' + marca.trim() + '&year=' + $('#year').val().trim() + '&familia=' + familia + '&temp=' + $('#type').val().trim() + '&modelos=' + modelos + '&colores=' + colores;
                
                $('#title-angle').empty();
                $('#title-date').empty();
                const fecha = new Date();
                const hoy = fecha.getDate() + "/" + (fecha.getMonth() + 1) + "/" + fecha.getFullYear();
                $('#title-date').append("Fecha de Consulta: " + hoy);
                
                // Usar all_fam y all_mar importadas
                if (all_mar === 1 && all_fam === 1) {
                  $('#title-angle').append("Familias*" + "-" + "Marcas*" + "-" + $('#year').val().trim());
                } else if (all_fam === 1 && all_mar === 0) {
                  $('#title-angle').append("Familias*" + "-" + marca.trim() + "-" + $('#year').val().trim());
                } else if (all_mar === 1 && all_fam === 0) {
                  $('#title-angle').append(familia + "-" + "Marcas*" + "-" + $('#year').val().trim());
                } else {
                  $('#title-angle').append(familia + "-" + marca.trim() + "-" + $('#year').val().trim());
                }
                
                // Resto de tu código AJAX...
                var filtro = 'familia=' + familia + '&marca=' + marca + '&categoria=' + $('#type').val().trim() + '&anio=' + $('#year').val().trim();
                
                if ($('#type').val().trim() === "'BASICO'") {
                  $.ajax({
                    type: 'POST',
                    url: 'formularios/presupuestos_ro/php/busqueda_bas.php',
                    data: filtro + '&modelos=' + modelos + '&colores=' + colores,
                    success: function(respuesta) {
                      if (respuesta != '') {
                        $('#respuesta').empty().append(respuesta);
                      } else {
                        alert('No se encontro Presupuesto , valida los filtros seleccionados');
                      }
                    },
                    error: function() {
                      alert('No se encontro Presupuesto , valida los filtros seleccionados');
                    }
                  });
                } else {
                  $.ajax({
                    type: 'POST',
                    url: 'formularios/presupuestos_ro/php/busqueda.php',
                    data: filtro,
                    success: function(respuesta) {
                      if (respuesta != '') {
                        $('#respuesta').empty().append(respuesta);
                      } else {
                        alert('No se encontro Presupuesto , valida los filtros seleccionados');
                      }
                    },
                    error: function() {
                      alert('No se encontro Presupuesto , valida los filtros seleccionados');
                    }
                  });
                }
                
                // Petición pedidos
                $.ajax({
                  type: 'POST',
                  url: 'SELL&OPR/queries/pedidos.php',
                  data: pedido,
                  beforeSend: function() {
                    $('#loading').modal('show');
                  },
                  success: function(respuesta) {
                    if (respuesta != '') {
                      $('#table-porcentaje, #table-pedido, #item3').empty();
                      $('#tp').append(respuesta);
                    } else {
                      alert('Valores vacios');
                    }
                  },
                  error: function() {
                    alert('Error en la peticion ajax');
                  }
                });
                
                // Histórico
                var historico = 'marca=' + marca.trim() + '&year=' + $('#year').val().trim() + '&familia=' + familia + '&temp=' + $('#type').val().trim() + '&modelos=' + modelos + '&colores=' + colores;
                $.ajax({
                  type: 'POST',
                  url: 'SELL&OPR/queries/historico_ventas.php',
                  data: historico,
                  success: function(respuesta) {
                    console.log(historico);
                    if (respuesta != '') {
                      $('#table, #item2').empty();
                      $('#ph').append(respuesta);
                    } else {
                      alert('Valores vacios');
                    }
                  },
                  error: function() {
                    alert('Error en la peticion ajax');
                  }
                });
                
                // Tabla ajustada
                var ajustado = 'marca=' + marca.trim() + '&year=' + $('#year').val().trim() + '&familia=' + familia + '&temp=' + $('#type').val().trim() + '&modelos=' + modelos + '&colores=' + colores;
                $.ajax({
                  type: 'POST',
                  url: 'SELL&OPR/queries/table_ajustado_new.php',
                  data: ajustado,
                  success: function(respuesta) {
                    $('#table-ajustado, #table-ajustado1, #item1').empty();
                    $('#pc').append(respuesta);
                    
                    setTimeout(function() {
                      $('#loading').modal('hide');
                      taju(); // Función importada
                    }, 2000);
                    
                    setTimeout(function() {
                      $('.venta_on, .inv_on, .comp_on, .comp_rp, .invf_on').hide();
                    }, 2500);
                  },
                  error: function() {
                    alert('Error en la peticion ajax');
                  }
                });
                
                // Detalle pedidos
                var detalle_pedidos_data = 'marca=' + marca.trim() + '&year=' + $('#year').val().trim() + '&familia=' + familia + '&temp=' + $('#type').val().trim() + '&modelos=' + modelos + '&colores=' + colores;
                $.ajax({
                  type: 'POST',
                  url: 'SELL&OPR/queries/detalle_pedidos.php',
                  data: detalle_pedidos_data,
                  success: function(respuesta) {
                    $('#table-detail_ped').empty().append(respuesta);
                  },
                  error: function() {
                    $('#table-detail_ped').html('<div style="padding: 20px; text-align: center; color: #f00;">Error al cargar detalle de pedidos</div>');
                  }
                });
                
                // Resetear variables si es necesario
                // Nota: all_fam y all_mar son importadas, no puedes reasignarlas si son const
                // Si necesitas modificarlas, deben ser exportadas como let
                
              }, 1000);
            }
          //});
        } else {
          alert('Valida los presupuestos ingresados.');
        }
      }
    });
  });
});