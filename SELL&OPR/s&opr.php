<?php
date_default_timezone_set('America/Mexico_City');
$dtz =new DateTimeZone("America/Mexico_City");
$dt = new DateTime("now", $dtz);

session_start();

setlocale(LC_ALL,"es_MX");
header("Cache-control: private");
header("Cache-control: no-cache, must-revalidate");
header("Pragma: no-cache");


if(isset( $_SESSION['userid'])  )

{
if (strpos( $_SESSION['userid'], 'soprb') !== false || strpos( $_SESSION['userid'], '%') !== false &&  strpos( $_SESSION['userid'], '1') !== false ) {


?>
<!DOCTYPE html>
<html lang="es-MX">

<head>
  <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=3.0, minimum-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="Dashboard">
  <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <meta http-equiv="Expires" content="0">
    <meta http-equiv="Last-Modified" content="0">
    <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">

  <title>AdminDash Haber Holding</title>
  <!-- Favicons -->
  <link href="img/hh.png" rel="icon">
  <link href="img/hh.png" rel="apple-touch-icon">
  <!-- Bootstrap core CSS -->
   <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!--external css-->
  <link href="lib/font-awesome/css/font-awesome.css" rel="stylesheet" />
  <!-- Custom styles for this template -->

  <link href="css/style.css?20230531_1" rel="stylesheet">
   <link href="css/style-responsive.css" rel="stylesheet">
    <link href="lib/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <script src='js/jquery-3.3.1.min.js' charset='utf-8'></script>
    <link href="https://www.google.com/jsapi" >
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="formularios/presupuestos_ro/js/funciones.js"></script>
    <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js' type='text/javascript'></script>
    <script src="https://cdn.rawgit.com/crlcu/multiselect/v2.5.1/dist/js/multiselect.min.js"></script>


</head>
<style>

/*
        span{
            display: inline-block;
            width: 5em;
            text-align: right;
        }*/
/*
        #venta{
            margin-top: 2%;
            display: inline-block;
            width: 40%;
            margin-left: 10%;
            margin-right: 5px;
            text-align: center;
            font-weight: bold;
        }

        #compra{
            margin-top: 2%;
            display: inline-block;
            width: 40%;
            text-align: center;
            font-weight: bold;
        }

*/

        .inputd{
            border: none;
            width: 10%;
            text-align: right;
            margin-right: 10px;
            margin-bottom: 10px;
            outline: none;
            border-bottom: solid #C8C8C8 .2rem;
            transition: all .5s;
        }

        .inputd:focus{
            border-bottom: solid #245374 .2rem;
        }

        .inputm{
            border: none;
            width: 10%;
            text-align: right;
            margin-right: 10px;
            margin-bottom: 10px;
            outline: none;
            border-bottom: solid #C8C8C8 .2rem;
            transition: all .5s;
        }

        .inputm:focus{
            border-bottom: solid #245374 .2rem;
        }

        .inputi{
            border: none;
            width: 10%;
            text-align: left;
            margin-right: 10px;
            margin-bottom: 10px;
            outline: none;
            border-bottom: solid #C8C8C8 .2rem;
            transition: all .5s;
        }

        .inputi:focus{
            border-bottom: solid #245374 .2rem;
        }
            /* Estilos para el modal */
#miniPage {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    width: 800px; /* Ancho del modal aumentado */
    max-height: 80vh; /* Altura máxima del modal como porcentaje del viewport */
    background-color: white;
    border: 1px solid #ccc;
    border-radius: 8px; /* Bordes redondeados */
    padding: 20px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2); /* Sombra más suave */
    overflow: hidden; /* Oculta cualquier desbordamiento */
}


/* Estilo para el botón de cerrar */
#closeModal {
    cursor: pointer;
    float: right;
    font-size: 24px; /* Tamaño de fuente aumentado */
    color: #333; /* Color del texto */
    transition: color 0.3s ease; /* Transición suave para el color */
    
}

/* Efecto de hover para el botón de cerrar */
#closeModal:hover {
    color: #f00; /* Color rojo al pasar el mouse */
}

/* Estilo para el encabezado del modal */
#miniPage h2 {
    margin-top: 0; /* Elimina el margen superior */
    font-size: 24px; /* Tamaño de fuente del encabezado */
    color: #333; /* Color del texto */
    text-align: center;
}

/* Estilo para el contenido del modal */
#miniPage .content {
    max-height: 60vh; /* Altura máxima del contenido dentro del modal */
    overflow-y: auto; /* Permite el desplazamiento vertical */
    padding-right: 15px; /* Espacio adicional para la barra de desplazamiento */
}



.contorno {
    position: relative;
}

.contador {
    position: absolute;
    top: -2px;
    left: 420px;
    background-color: #fff;
    padding: 1px 4px;
    border-radius: 40%;
    border: 1px solid #000;
    font-weight: bold;
    font-size: 10px;
}

    <!--/*
        #respuesta{
            display: block;
            width: 50%;
            margin: auto;
            text-align: center;
            min-width: 500px;
        }*/
-->




</style>


<div class="modal fade" id="loading" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

    <div id="loadFacebookG">
        <div id="blockG_1" class="facebook_blockG"></div>
        <div id="blockG_2" class="facebook_blockG"></div>
        <div id="blockG_3" class="facebook_blockG"></div>
    </div>
</div>
<div class="modal fade"   id="filters" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom-0 text-center">
                <h5 class="modal-title" id="exampleModalLabel"> Filtros Sales & Operation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
                <div class="modal-body">
                    <div class="form-row" >
                        <div class="form-group">
                            <div class="input-group input-group input-group-sm">
                                <span class="input-group-addon"> <b> Temporada</b></span>
                                <select  name="type" id="type"  class="form-control input-sm" aria-label="small"  required >
                                    <option value="%">TODAS</option>
                                    <option value="'BASICO'">Basico</option>
                                    <option value="'MAYOREO'">Mayoreo</option>
                                    <option value="'MODA'">Moda</option>
                                </select>
                                <span class="input-group-addon"><b> Año</b></span>
                                <select  name="year" id="year"  class="form-control input-sm" required aria-label="small"   >
                                    <!--<option value="2023">2023</option>
                                    <option value="2022">2022</option>
                                    <option value="2021">2021</option>
                                    <option value="2020">2020</option>
                                    <option value="2019">2019</option>
                                    <option value="2023">2023</option>-->
 				    ss<option value="2025">2025</option>
                                    <option value="2026">2026</option>
                                   <!-- <option value="2025">NY+</option>-->
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-header border-bottom-0 text-center">
                        <h5 class="modal-title" id="exampleModalLabel"> <b> Bloque Familias</b></h5>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <div class="input-group input-group input-group-sm">
                                <div class="form-row">
                                    <div class="col-xs-4">
                                        <select name="from[]" id="multiselect" size="10" class='form-control input-sm' aria-label='small'  multiple="multiple"  ></select>
                                    </div>
                                    <div class="col-xs-3 text-center" style="padding-top: 6rem ">
                                        <button type="button" id="fam_rightAll" class="btn btn-block" style="font-size: 9px"><b>Add All</b><!--<i class="glyphicon glyphicon-forward"></i>--></button>
                                        <button type="button" id="fam_rightSelected" class="btn btn-block" style="font-size: 9px"><b>Add<i class="glyphicon glyphicon-menu-right"></i></b></button>
                                        <button type="button" id="fam_leftSelected" class="btn btn-block" style="font-size: 9px"><b><i class="glyphicon glyphicon-menu-left"></i>Remove</b></button>
                                        <button type="button" id="fam_leftAll" class="btn btn-block" style="font-size: 9px"><b>Remove All</b><!--<i class="glyphicon glyphicon-backward"></i>--></button>
                                    </div>
                                    <div class="col-xs-5">
                                        <select name="familia[]" size="10" id="familia" class='form-control input-sm' aria-label='small'  required  multiple="multiple"  ></select>
                                    </div>
                                    </div>
                            </div>
                            </div>
                            </div>
                    <div class="modal-header border-bottom-0 text-center" style="background: #FCB322">
                        <h5 class="modal-title " id="exampleModalLabel" style="color:black" >  <b> Bloque Marcas</b></h5>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <div class="input-group input-group input-group-sm ">
                                <div class="form-row">

                                    <div class="col-xs-4">
                                        <select name="from[]" id="multiselect2" size="10" class='form-control input-sm' aria-label='small'  multiple="multiple"></select>
                                    </div>
                                    <div class="col-xs-3 text-center" style="padding-top: 6rem ">
                                        <button type="button" id="mar_rightAll" class="btn btn-block" style="font-size: 9px"><b>Add All</b><!--<i class="glyphicon glyphicon-forward"></i>--></button>
                                        <button type="button" id="mar_rightSelected" class="btn btn-block" style="font-size: 9px"><b>Add<i class="glyphicon glyphicon-menu-right"></i></b></button>
                                        <button type="button" id="mar_leftSelected" class="btn btn-block" style="font-size: 9px"><b><i class="glyphicon glyphicon-menu-left"></i>Remove</b></button>
                                        <button type="button" id="mar_leftAll" class="btn btn-block" style="font-size: 9px"><b>Remove All</b><!--<i class="glyphicon glyphicon-backward"></i>--></button>
                                    </div>
                                    <div class="col-xs-5">
                                        <select name="marca[]" size="10" id="marca" class='form-control input-sm' aria-label='small'   multiple="multiple" required ></select>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="modelo-section">
                    <div class="modal-header border-bottom-0 text-center" style="background: #FCB322">
                        <h5 class="modal-title" id="exampleModalLabel" style="color:black"><b>Bloque Modelo</b></h5>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <div class="input-group input-group-sm">
                                <div class="form-row">
                                    <div class="col-xs-4">
                                        <select name="from[]" id="multiselect3" size="10" class="form-control input-sm" multiple="multiple"></select>
                                    </div>
                                    <div class="col-xs-3 text-center" style="padding-top: 6rem">
                                        <button type="button" id="mod_rightAll" class="btn btn-block" style="font-size: 9px"><b>Add All</b></button>
                                        <button type="button" id="mod_rightSelected" class="btn btn-block" style="font-size: 9px"><b>Add<i class="glyphicon glyphicon-menu-right"></i></b></button>
                                        <button type="button" id="mod_leftSelected" class="btn btn-block" style="font-size: 9px"><b><i class="glyphicon glyphicon-menu-left"></i>Remove</b></button>
                                        <button type="button" id="mod_leftAll" class="btn btn-block" style="font-size: 9px"><b>Remove All</b></button>
                                    </div>
                                    <div class="col-xs-5">
                                        <select name="modelos[]" id="modelos" size="10" class="form-control input-sm" multiple="multiple" required></select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Fin del bloque de Modelo -->
            </div>

            <div class="modal-footer" id="modal-footer">
                <button type="button" class="btn btn-success" aria-hidden="true" id="broswer">Consultar</button>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript para mostrar/ocultar el bloque "Modelo" -->
<script>
    document.getElementById('type').addEventListener('change', function() {
        var temporada = this.value;
        var modeloSection = document.getElementById('modelo-section');

        if (temporada === "'BASICO'") {
            modeloSection.style.display = 'block';  // Muestra el bloque si se selecciona "BASICO"
        } else {
            modeloSection.style.display = 'none';  // Oculta el bloque para cualquier otra opción
        }
    });

    // Inicialmente ocultar el bloque de modelo
    document.getElementById('modelo-section').style.display = 'none';
</script>

<div class="graphic">

    <div id="contenedor-grafica">

        <div class="button_cerrar">
            <a href="javascript:close_grafica()">X</a>
        </div>
        <div id="item2"></div>
        <div id="item1"></div>
        <div id="item3"></div>


    </div>



</div>
<div class="pedidosconsulta">



    <div id="cerrado">


        <div class="button_cerrar">
            <a href="javascript:close_consulta()">X</a>
        </div>
        <div class="border-head" id="title">
        </div>
        <div class="custom-bar-chart" id="tablaconsulta">
        </div>



    </div>





</div>
<body>
  <section id="container">
  <!-- **********************************************************************************************************************************************************
        TOP BAR CONTENT & NOTIFICATIONS
        *********************************************************************************************************************************************************** -->
    <!--header start-->
    <header class="header black-bg">

        <!--<div class="sidebar-toggle-box">-->

          <!--<div class="fa fa-bars tooltips" data-placement="right" data-original-title="Navegador"></div>-->
          <!--</div>-->
          <!--logo start-->
        <!--href="AdminDash.php"-->

      <a style="margin-right: 15px"  class="logo"><b>HABER<span>HOLDING</span></b></a >
        <div  class="top-menu">
            <ul class="nav pull-left top-menu">
            <li class="nav-item"  height="25" ><a  data-keyboard="false"  class="logout" id="filter" data-toggle="tooltip" data-placement="bottom" title="Filtros S&OP">Filtro <i class="fa fa-cog fa-fw" ></i></a></a></li>
            <li class="nav-item"  height="25" ><a class="logout" id="index"  href="AdminDash.php" data-toggle="tooltip" data-placement="bottom" title="Inicio">Principal <i class="fa fa-home fa-fw" ></i></a></a></li>
            <div id="txt" style="margin-top: 10px; display: flex; justify-content: flex-end; align-items: center;">
            <div style="display: inline-block; text-align: center;">
    <input id="exg" name="excelg" type="image" alt="submit" src="img/seguridad.png" height="30" value="Excelg">
    <div class="text" style="margin-top: 5px;">Saldo</div>
        </div>
                
            <span class="contador" id="contador"> </span>
    <!-- Modal (mini página) -->
<div id="miniPage">
    <span id="closeModal">&times;</span>
    <h2>Requisiciones</h2>
    <div class="content" id="content_requis">
    </div>
</div>

<script>
    // Abrir la mini página al hacer clic en la imagen
    document.getElementById("exg").addEventListener("click", function(event) {
        event.preventDefault();
        document.getElementById("miniPage").style.display = "block";
    });

    // Cerrar la mini página al hacer clic en la 'x'
    document.getElementById("closeModal").addEventListener("click", function() {
        document.getElementById("miniPage").style.display = "none";
    });
</script>
            </ul>
        </div>
      <!--logo end-->
      <div class="top-menu">
        <ul class="nav pull-right top-menu">
            <li class="nav-item"  style="margin-right: 15px; margin-top: 10px" ><div id="txt"><input type="image" alt="submit" height="25" src="img/Logo_Roberts.png"  class="input-xs"  ></div></li>
           <!--<li class="nav-item"  ><a class="logout" id="filter" data-toggle="tooltip" data-placement="bottom" title="Filtros S&OP"><i class="fa fa-cog fa-fw" ></i></a></a></li>-->
            <li><div id="txt" style="margin-top: 10px"><input id="graficas"   type="image" alt="submit" src="img/bar-chart.png" height="30"  class="input-xs" onclick="hacer_click()"><div class="text">Graficas</div></div> </li>
            <li><div id="txt" style="margin-top: 10px"><input id="ex" name="excel" type="image" alt="submit" src="img/grap.png"  height="30" value="Excel"  class="input-xs" onclick="descargarExcel()"><div class="text">Exportar</div></div> </li>
            <li><div id="txt" style="margin-top: 10px"><input id="exg"   name="excelg"  type="image" alt="submit" src="img/sls.png" height="30" value="Excelg"  class="input-xs" onclick="location.href='SELL&OPR/queries/comp_pr.php'"  ><div class="text">Compra</div></div></li>
            <li><div id="txt" style="margin-top: 10px"><input id="exg"   name="excelg"  type="image" alt="submit" src="img/orden.png" height="30" value="Excelg"  class="input-xs" onclick="location.href='SELL&OPR/queries/presup_csv.php'"  ><div class="text">Saldo</div></div></li>
            <li><div id="txt"   style="margin-top: 10px"><input id="exg"   name="excelg"  type="image" alt="submit" src="img/pedidos.png"  height="30"value="Excelg"  class="input-xs" onclick="location.href='SELL&OPR/queries/csv-pedido.php'"  ><div class="text">Pedidos</div></div></li>
            <li style="margin-right: 15px"><div id="txt"   style="margin-top: 10px"><input id="exg"   name="excelg"  type="image" alt="submit" src="img/pedidos.png"  height="30"value="Excelg"  class="input-xs" onclick="location.href='SELL&OPR/queries/csv-telas.php'"  ><div class="text">Telas</div></div></li>
            <li class="nav-item"  height="25"  ><a class="logout" href="logout.php" data-toggle="tooltip" data-placement="bottom" title="Salir">Salir <i class="fa fa-power-off" ></i></a></a></li>
        </ul>
      </div>
    </header>
    <!--header end-->
    <!-- **********************************************************************************************************************************************************
        MAIN SIDEBAR MENU
        *********************************************************************************************************************************************************** -->
    <!--sidebar start
      <aside>
          <div id="sidebar" class="nav-collapse ">
              <ul class="sidebar-menu" id="nav-accordion">
                  <p class="centered"><a href="AdminDash.php"><img src="img/HH_medida.png" class="img-thumbnail" width="80"></a></p>
                  <h5 class="centered">HOME</h5>
                  <li class="mt">
                      <a href="AdminDash.php">
                          <i class="fa fa-dashboard"></i>
                          <span>Principal</span>
                      </a>
                  </li>
                  <li class="sub-menu">
                      <a id="filter" href="javascript:;">
                          <i class="fa fa-cog fa-fw"></i>
                          <span>Filtros S&OP</span>
                      </a>
                      <hr>

                  </li>
                       <li class="sub-menu">
                           <a href="javascript:;">
                               <i class="fa fa-list"></i>
                               <span>Desempeño</span>
                           </a>
                           <ul class="sub">
                               <li><a href="desempm.php">Mens Fashion</a></li>

                           </ul>
                       </li>

              </ul>
          </div>
      </aside>
    sidebar end-->
    <!-- **********************************************************************************************************************************************************
        MAIN CONTENT
        *********************************************************************************************************************************************************** -->
    <!--main content start-->
    <section id="main-content-sop">
      <section class="wrapper">
          <div class="row">
              <div class="col-md-12" >
                  <hr>
                  <h3 id="title-angle" ></h3>

                  <div role="tabpanel">
                      <ul class="nav nav-tabs" role="tablist">
                          <li role="presentation" class="active" ><a href="#sop_mf" aria-controls="" data-toggle="tab" role="tab">S&OP</a></li>
                            <li role="presentation" id="presupuesto_O" style="display: none;"><a href="#ppto_soprb" aria-controls="" data-toggle="tab" role="tab">Presupuesto</a></li>

                      </ul>
                      <div class="tab-content" id="datatabs">
                          <div role="tabpanel" class="tab-pane active"  id="sop_mf"  >
                                  <div class="col-lg-12 main-chart">
                                          <div class="row">
                                              <div class="border-head">
                                                  <h3>HISTORICO DE VENTAS</h3>
                                              </div>
                                              <div >
                                                  <h6 id="title-date" ></h6>
                                              </div>
                                              <div class="row"  id="ph">
                                                  <div  id="table"></div>
                                              </div>

                                          </div>
                                      <hr>
                                          <div class="row">
                                              <div class="border-head">
                                                  <h3>PRESUPUESTO</h3>
                                              </div>
                                              <div class="row" id="pc">
                                                  <div  id="table-ajustado"></div>

                                              </div>
                                          </div>
                                      <hr>
                                      <div class="row">
                                          <div class="border-head">
                                              <h3>REAL</h3>
                                          </div>
                                          <div class="row" id="pc">

                                              <div  id="table-ajustado1"></div>
                                          </div>
                                      </div>


                                          <!--<div class="row">
                                              <div class="border-head">
                                                  <h3>PLAN ORIGINAL</h3>
                                              </div>
                                              <div class="row" id="pp">
                                                  <div  id="table-ppto"></div>
                                              </div>
                                          </div>-->
                                      <hr>

                                          <div class="row">
                                              <div class="border-head">
                                                  <h3>PEDIDOS</h3>
                                              </div>
                                              <div class="row" id="tp">
                                                  <div  id="table-pedido"></div>
                                                  <div  id="table-pedido1"></div>
                                                  <div  id="table-porcentaje"></div>
                                              </div>
                                          </div>
                                    </div>
                          </div>
                          <div role="tabpanel" class="tab-pane"  id="ppto_soprb" >
                              <div  class="col-lg-12 main-chart">
                                        <div class="row">
                                                <div class="form-horizontal">
                                                <div class="list-group-horizontal">
                                                </div>
                                                <div class="list-group-horizontal" >
                                                </div>
                                                <div class="list-group-horizontal" >
                                                </div>
                                                <div class="list-group-horizontal"  >
                                                </div>
                                                </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                              <div class="row" id='respuesta'>
                                              </div>
                                            </div>
                                        </div>
                              </div>
                          </div>
                      </div>
                  </div>
        <!-- /row -->
              </div>
          </div>
      </section>
    </section>
    <!--main content end-->
    <!--footer start-->
    <footer class="site-footer">
      <div class="text-center">
        <p>
         <!-- &copy; Copyrights <strong>Dashio</strong>. All Rights Reserved-->
        </p>
        <div class="credits">
          <!--
            You are NOT allowed to delete the credit link to TemplateMag with free version.
            You can delete the credit link only if you bought the pro version.
            Buy the pro version with working PHP/AJAX contact form: https://templatemag.com/dashio-bootstrap-admin-template/
            Licensing information: https://templatemag.com/license/
          -->
          <!--Created with Dashio template by <a href="https://templatemag.com/">TemplateMag</a>-->
        </div>
        <a href="s&opm.php#" class="go-top">
          <i class="fa fa-angle-up"></i>
          </a>
      </div>
    </footer>
    <!--footer end-->
  </section>
  <!-- js placed at the end of the document so the pages load faster -->
  <script class="include" type="text/javascript" src="lib/jquery.dcjqaccordion.2.7.js"></script>
  <script src="lib/jquery.scrollTo.min.js"></script>
  <script src="lib/jquery.nicescroll.js" type="text/javascript"></script>
  <script src="lib/jquery.sparkline.js"></script>
 <!--common script for all pages-->
  <script src="lib/common-scripts.js"></script>
   <script type="module" src="SELL&OPR/javascript/load_filters.js"></script>
   <script type="module" src="SELL&OPR/javascript/browser.js"></script>
  <script type="module" src="SELL&OPR/javascript/table_ajustado.js" >

$(document).ready(function() {  
   $('body').on('click','#table-ajustado', function(){
    taju()
   });
   $('body').on('click','#table-ajustado1', function(){
    taju()
    });
 $(document).resize();
      });
  </script>
  <script>
      function hacer_click()
      {

          $('body').addClass('loadgraph');
          $('#item1').resize();
          $('#item2').resize();
          $('#item3').resize();


      }
      function close_grafica()
      {
          $('body').removeClass('loadgraph');


      }
      function close_consulta()
      {
          $('body').removeClass('loadconsult');
      }
      function descargarExcel() {
          var d=Date.now();
          var familia2='';
          var val_fam=document.getElementById('familia');
          for (i=0;i< val_fam.length;i++) {
              if(val_fam[i].selected){
                  familia2 += "'"+val_fam[i].value + "',";
              }
          }
          var familia2=familia2.slice(0,familia2.length -1);

          var marca2='';
          var val_mar2=document.getElementById('marca');
          for (i=0;i< val_mar2.length;i++) {
              if(val_mar2[i].selected){
                  marca2 += "'"+val_mar2[i].value + "',";
              }
          }
          var marca2=marca2.slice(0,marca2.length -1);

          //Creamos un Elemento Temporal en forma de enlace
          var tmpElemento = document.createElement('a');
          // obtenemos la información desde el div que lo contiene en el html
          // Obtenemos la información de la tabla
          var data_type = 'data:application/vnd.ms-excel;charset=UTF-8;';
          var tabla_div = document.getElementById('table');
          var tabla_div1 = document.getElementById('table-ajustado');
          var tabla_div2 = document.getElementById('table-ajustado1');
         // var tabla_div3 = document.getElementById('table-ppto');
          var tabla_div4 = document.getElementById('table-pedido');
          var tabla_html = tabla_div.outerHTML.replace(/ /g, '%20');
          var tabla_html1 = tabla_div1.outerHTML.replace(/ /g, '%20');
          var tabla_html2 = tabla_div2.outerHTML.replace(/ /g, '%20');
         // var tabla_html3 = tabla_div3.outerHTML.replace(/ /g, '%20');
          var tabla_html4 = tabla_div4.outerHTML.replace(/ /g, '%20');
          tmpElemento.href = data_type + ', ' + tabla_html+ ', ' + tabla_html1+ ', ' + tabla_html2+ ', ' + tabla_html4;
          //Asignamos el nombre a nuestro EXCEL
          tmpElemento.download = "SELL&OPR"+ " " +   marca2+'' + $('#year').val().trim()+''+familia2;
          // Simulamos el click al elemento creado para descargarlo
          tmpElemento.click();
          /*
          var tmpElemento2 = document.createElement('a');
          // obtenemos la información desde el div que lo contiene en el html
          // Obtenemos la información de la tabla
          var data_type2 = 'data:application/vnd.ms-excel;charset=UTF-8;';
          var tabla_div2 = document.getElementById('grapercent');
          var tabla_html2 = tabla_div2.outerHTML.replace(/ /g, '%20');
          tmpElemento2.href = data_type2 + ', ' + tabla_html2;
          //Asignamos el nombre a nuestro EXCEL
          tmpElemento2.download ="Tabla Porcentajes General"+" "+$('#meses').val().trim();
          // Simulamos el click al elemento creado para descargarlo
          tmpElemento2.click();

      }
  */
      }

  </script>
  <script type="text/javascript">
      var idleTime = 0;
      $(document).ready(function () {
          //Increment the idle time counter every minute.
          var idleInterval = setInterval(timerIncrement, 60000); // 1 minute

          //Zero the idle timer on mouse movement.
          $(this).mousemove(function (e) {
              idleTime = 0;
          });
          $(this).keypress(function (e) {
              idleTime = 0;
          });
      });

      function timerIncrement() {
          idleTime = idleTime + 1;
          if (idleTime > 29) { // 20 minutes
              $.ajax({
                  url: 'php/logout.php',
                  success: function(){
                      window.location = ('index.html');
                  },
                  error: function(){
                      Swal.fire({
                          position: 'center',
                          type: 'error',
                          title: 'Advertencia',
                          html: 'Comunicate a sistemas',
                          confirmButtonColor: '#d33',
                          confirmButtonText: 'Aceptar'
                      })
                  }
              });
          }
      }
  </script>
</body>

</html>
    <?php
}

else{


    header("location:AdminDash.php");
}

}

else{


    header("location:index.php");
}
?>