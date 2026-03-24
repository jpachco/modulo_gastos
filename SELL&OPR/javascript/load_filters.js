/**
 * 
 */

      var all_fam=0;
      var all_mar=0;

      $(document).ready(function() {

          familias();
      
             document.getElementById("closeModal").addEventListener("click", function() {
        document.getElementById("miniPage").style.display = "none";
    });
  
        
          
          $('#multiselect').multiselect({
              showCheckbox: true,
              right: '#familia',
              left: '#multiselect',
              rightSelected: '#fam_rightSelected',
              leftSelected: '#fam_leftSelected',
              rightAll: '#fam_rightAll',
              leftAll: '#fam_leftAll',
              search: {
                  left: '<input type="text" name="q" class="form-control" placeholder="Search..." />',
                  right: '  <span class="input-group-addon text-center"><b>Seleccion Actual:</b></span>'
              },
              moveToRight: function (Multiselect, $options, event, silent, skipStack) {
                  var button = $(event.currentTarget).attr('id');
                  if (button === 'fam_rightSelected') {
                      var $left_options = Multiselect.$left.find('> option:selected');
                      Multiselect.$right.eq(0).append($left_options);
                      if (typeof Multiselect.callbacks.sort == 'function' && !silent) {
                          Multiselect.$right.eq(0).find('> option').sort(Multiselect.callbacks.sort).appendTo(Multiselect.$right.eq(0));
                      }
                  } 
                  else if (button === 'fam_rightAll') {
                      all_fam = 1;
                      /* var $left_options = Multiselect.$left.children(':visible');
                              //$left_options= "<option value='%' selected>Todas</option>";
                        $left_options.attr("selected",true);*/
                      /*for (let i = 0; i < $left_options.length; i++) {
                          console.log($left_options[i]);
                          $left_options[i].attr("selected",true);
                      }*/
                      /*Multiselect.$right.eq(0).append($left_options);
                      if ( typeof Multiselect.callbacks.sort == 'function' && !silent ) {
                          Multiselect.$right.eq(0).find('> option').sort(Multiselect.callbacks.sort).appendTo(Multiselect.$right.eq(0));
                      }*/
                      /*************/
                      //  var multiselect=Multiselect.$left.eq(0);
                      Multiselect.$right.eq(0).append($options);
                      //  $options.prop("visible")
                      $('#familia option').prop('selected', true);
                      if (typeof Multiselect.callbacks.sort == 'function' && !silent) {
                          Multiselect.$left.find('> option').sort(Multiselect.callbacks.sort).appendTo(Multiselect.$left);
                      }
                  }

                   var str = '';
                  var val = document.getElementById('familia');
                  for (let i = 0; i < val.length; i++) {
                      if (val[i].selected) {
                          str += "'" + val[i].value + "',";
                      }
                  }
                  var str = str.slice(0, str.length - 1);
                  var familia = 'familia=' + str;
                  $.ajax({
                      type: 'POST',
                      url: 'SELL&OPR/queries/marcas.php',
                      data: familia,
                      success: function (respuesta) {


                          $('#multiselect2').empty();
                          $('#marca').empty();
                          $('#multiselect2').append(respuesta);


                      },
                      error: function () {
                          swal('Ooops!!!', 'Contacta a tu administrador', 'error');
                      }
                  });


              },
              moveToLeft: function (Multiselect, $options, event, silent, skipStack) {
                  var button = $(event.currentTarget).attr('id');
                  if (button === 'fam_leftSelected') {
                      var $right_options = Multiselect.$right.eq(0).find('> option:selected');
                      Multiselect.$left.append($right_options.prop("selected", false));

                      $('#familia option').prop('selected', true);
                      if (typeof Multiselect.callbacks.sort == 'function' && !silent) {

                          Multiselect.$left.find('> option').sort(Multiselect.callbacks.sort).appendTo(Multiselect.$left);

                      }


                  } else if (button === 'fam_leftAll') {
                      all_fam = 0;
                      var $right_options = Multiselect.$right.eq(0).children(':visible');

                      $right_options.prop("selected", false);
                      Multiselect.$left.append($right_options);


                      if (typeof Multiselect.callbacks.sort == 'function' && !silent) {
                          Multiselect.$left.find('> option').sort(Multiselect.callbacks.sort).appendTo(Multiselect.$left);
                      }
                  }
                  var str = '';
                  var val = document.getElementById('familia');
                  for (let i = 0; i < val.length; i++) {
                      if (val[i].selected) {
                          str += "'" + val[i].value + "',";
                      }
                  }
                  var str = str.slice(0, str.length - 1);
                  var familia = 'familia=' + str;
                  $.ajax({
                      type: 'POST',
                      url: 'SELL&OPR/queries/marcas.php',
                      data: familia+ '&temp=' + $('#type').val().trim(),
                      success: function (respuesta) {


                          $('#multiselect2').empty();
                          $('#marca').empty();
                          $('#multiselect2').append(respuesta);


                      },
                      error: function () {
                          swal('Ooops!!!', 'Contacta a tu administrador', 'error');
                      }
                  });

              },
          });
          $('#multiselect2').multiselect({
              includeSelectAllOption: true,
              right: '#marca',
              left: '#multiselect2',
              rightSelected: '#mar_rightSelected',
              leftSelected: '#mar_leftSelected',
              rightAll: '#mar_rightAll',
              leftAll: '#mar_leftAll',
              search: {
                  left: '<input type="text" name="q" class="form-control" placeholder="Search..." />',
                  right: '  <span class="input-group-addon text-center"><b>Seleccion Actual:</b></span>'
              },
              moveToRight: function (Multiselect, $options, event, silent, skipStack) {
                  var button = $(event.currentTarget).attr('id');
                  if (button === 'mar_rightSelected') {
                      var $left_options = Multiselect.$left.find('> option:selected');
                      Multiselect.$right.eq(0).append($left_options);
                      if (typeof Multiselect.callbacks.sort == 'function' && !silent) {
                          Multiselect.$right.eq(0).find('> option').sort(Multiselect.callbacks.sort).appendTo(Multiselect.$right.eq(0));
                      }
                  } else if (button === 'mar_rightAll') {
                      all_mar = 1;
                      /* var $left_options = Multiselect.$left.children(':visible');
                              //$left_options= "<option value='%' selected>Todas</option>";
                        $left_options.attr("selected",true);*/
                      /*for (let i = 0; i < $left_options.length; i++) {
                          console.log($left_options[i]);
                          $left_options[i].attr("selected",true);
                      }*/
                      /*Multiselect.$right.eq(0).append($left_options);
                      if ( typeof Multiselect.callbacks.sort == 'function' && !silent ) {
                          Multiselect.$right.eq(0).find('> option').sort(Multiselect.callbacks.sort).appendTo(Multiselect.$right.eq(0));
                      }*/
                      /*************/
                      //  var multiselect=Multiselect.$left.eq(0);
                      Multiselect.$right.eq(0).append($options);
                      //  $options.prop("visible")
                      $('#marca option').prop('selected', true);
                      if (typeof Multiselect.callbacks.sort == 'function' && !silent) {
                          Multiselect.$left.find('> option').sort(Multiselect.callbacks.sort).appendTo(Multiselect.$left);
                      }
                  }
                  
                  
                  var strf = '';
                  var valf = document.getElementById('familia');
                  for (let i = 0; i < valf.length; i++) {
                      if (valf[i].selected) {
                          strf += "'" + valf[i].value + "',";
                      }
                  }
                  var strf = strf.slice(0, strf.length - 1);
               
                  
                     
                  var strm = '';
                  var valm = document.getElementById('marca');
                  for (let i = 0; i < valm.length; i++) {
                      if (valm[i].selected) {
                          strm += "'" + valm[i].value + "',";
                      }
                  }
                  var strm = strm.slice(0, strm.length - 1);
                  
                  
                  
                  var data = 'familia=' + strf +'&marca='+strm+ '&temp=' + $('#type').val().trim();
                        console.log(data);
                  $.ajax({
                      type: 'POST',
                      url: 'SELL&OPR/queries/Modelaje.php',
                      data: data,
                      success: function (respuesta) {
                     
					

                          $('#multiselect3').empty();
                          $('#modelos').empty();
                          $('#multiselect3').append(respuesta);


                      },
                      error: function () {
                          swal('Ooops!!!', 'Contacta a tu administrador', 'error');
                      }
                  });
                  
              },
              moveToLeft: function (Multiselect, $options, event, silent, skipStack) {
                  var button = $(event.currentTarget).attr('id');
                  if (button === 'mar_leftSelected') {
                      var $right_options = Multiselect.$right.eq(0).find('> option:selected');
                      Multiselect.$left.append($right_options.prop("selected", false));
                      $('#marca option').prop('selected', true);
                      if (typeof Multiselect.callbacks.sort == 'function' && !silent) {
                          Multiselect.$left.find('> option').sort(Multiselect.callbacks.sort).appendTo(Multiselect.$left);
                      }
                  } else if (button === 'mar_leftAll') {
                      all_mar = 0;
                      var $right_options = Multiselect.$right.eq(0).children(':visible');
                      $right_options.prop("selected", false);
                      Multiselect.$left.append($right_options);
                      if (typeof Multiselect.callbacks.sort == 'function' && !silent) {
                          Multiselect.$left.find('> option').sort(Multiselect.callbacks.sort).appendTo(Multiselect.$left);
                      }
                  }
                  
                  
                  
                  
                      var strf = '';
                  var valf = document.getElementById('familia');
                  for (let i = 0; i < valf.length; i++) {
                      if (valf[i].selected) {
                          strf += "'" + valf[i].value + "',";
                      }
                  }
                  var strf = strf.slice(0, strf.length - 1);
               
                  
                     
                  var strm = '';
                  var valm = document.getElementById('marca');
                  for (let i = 0; i < valm.length; i++) {
                      if (valm[i].selected) {
                          strm += "'" + valm[i].value + "',";
                      }
                  }
                  var strm = strm.slice(0, strm.length - 1);
                  
                  
                  
                  var data = 'familia=' + strf +'&marca='+strm+ '&temp=' + $('#type').val().trim();
                    
                  $.ajax({
                      type: 'POST',
                      url: 'SELL&OPR/queries/Modelaje.php',
                      data: data,
                      success: function (respuesta) {
							console.log(respuesta);

                          $('#multiselect3').empty();
                          $('#modelos').empty();
                          $('#multiselect3').append(respuesta);


                      },
                      error: function () {
                          swal('Ooops!!!', 'Contacta a tu administrador', 'error');
                      }
                  });
                  
              },
          });
          
             $('#multiselect3').multiselect({
              includeSelectAllOption: true,
              right: '#modelos',
              left: '#multiselect3',
              rightSelected: '#mod_rightSelected',
              leftSelected: '#mod_leftSelected',
              rightAll: '#mod_rightAll',
              leftAll: '#mod_leftAll',
              search: {
                  left: '<input type="text" name="q" class="form-control" placeholder="Search..." />',
                  right: '  <span class="input-group-addon text-center"><b>Seleccion Actual:</b></span>'
              },
              moveToRight: function (Multiselect, $options, event, silent, skipStack) {
                  var button = $(event.currentTarget).attr('id');
                  if (button === 'mod_rightSelected') {
                      var $left_options = Multiselect.$left.find('> option:selected');
                      Multiselect.$right.eq(0).append($left_options);
                      if (typeof Multiselect.callbacks.sort == 'function' && !silent) {
                          Multiselect.$right.eq(0).find('> option').sort(Multiselect.callbacks.sort).appendTo(Multiselect.$right.eq(0));
                      }
                  } else if (button === 'mod_rightAll') {
                      all_mar = 1;
                      /* var $left_options = Multiselect.$left.children(':visible');
                              //$left_options= "<option value='%' selected>Todas</option>";
                        $left_options.attr("selected",true);*/
                      /*for (let i = 0; i < $left_options.length; i++) {
                          console.log($left_options[i]);
                          $left_options[i].attr("selected",true);
                      }*/
                      /*Multiselect.$right.eq(0).append($left_options);
                      if ( typeof Multiselect.callbacks.sort == 'function' && !silent ) {
                          Multiselect.$right.eq(0).find('> option').sort(Multiselect.callbacks.sort).appendTo(Multiselect.$right.eq(0));
                      }*/
                      /*************/
                      //  var multiselect=Multiselect.$left.eq(0);
                      Multiselect.$right.eq(0).append($options);
                      //  $options.prop("visible")
                      $('#modelos option').prop('selected', true);
                      if (typeof Multiselect.callbacks.sort == 'function' && !silent) {
                          Multiselect.$left.find('> option').sort(Multiselect.callbacks.sort).appendTo(Multiselect.$left);
                      }
                  }
              },
              moveToLeft: function (Multiselect, $options, event, silent, skipStack) {
                  var button = $(event.currentTarget).attr('id');
                  if (button === 'mod_leftSelected') {
                      var $right_options = Multiselect.$right.eq(0).find('> option:selected');
                      Multiselect.$left.append($right_options.prop("selected", false));
                      $('#modelos option').prop('selected', true);
                      if (typeof Multiselect.callbacks.sort == 'function' && !silent) {
                          Multiselect.$left.find('> option').sort(Multiselect.callbacks.sort).appendTo(Multiselect.$left);
                      }
                  } else if (button === 'mod_leftAll') {
                      all_mar = 0;
                      var $right_options = Multiselect.$right.eq(0).children(':visible');
                      $right_options.prop("selected", false);
                      Multiselect.$left.append($right_options);
                      if (typeof Multiselect.callbacks.sort == 'function' && !silent) {
                          Multiselect.$left.find('> option').sort(Multiselect.callbacks.sort).appendTo(Multiselect.$left);
                      }
                  }
              },
          });
          
          $('#filter').click(function () {
              $('#filters').modal({show: true, keyboard: false});

          });
        
          function familias() {
              var data = '';
              $.ajax({
                  type: 'POST',
                  url: 'SELL&OPR/queries/familias.php',
                  data: data,
                  success: function (respuesta) {

                      $('#multiselect').append(respuesta);

                  },
                  error: function () {
                      swal('Ooops!!!', 'Contacta a tu administrador', 'error');
                  }
              });
              
               $.ajax({
                url: 'SELL&OPR/queries/conteorequis.php',
                method: 'GET',
                success: function(respuesta) {
                    console.log('Respuesta del servidor:', respuesta); 
                    $('#contador').append(respuesta);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Error en la solicitud AJAX:', textStatus, errorThrown);
                    swal('Ooops!!!', 'Contacta a tu administrador', 'error');
                }
                });

                $.ajax({
                    url: 'SELL&OPR/queries/rejectedrequis.php',
                    method: 'GET',
                    success: function(respuesta) {
                        console.log('Respuesta del servidor:', respuesta); 
                        $('#content_requis').append(respuesta);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('Error en la solicitud AJAX:', textStatus, errorThrown);
                        swal('Ooops!!!', 'Contacta a tu administrador', 'error');
                    }
                    });    

            
            }   
           
          
});

export {all_fam,all_mar};