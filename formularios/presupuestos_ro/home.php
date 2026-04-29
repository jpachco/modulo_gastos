<?php

    error_reporting(0);
    session_start();
    if ($_SESSION['usuario'] == null || $_SESSION['usuario'] == ''){
      header('Location: index.html');
      die();
    }

?>
<!DOCTYPE html>
<html lang='es' dir='ltr'>
  <head>
    <meta charset='utf-8'>
    <title>Presupuestos</title>
    <link rel='stylesheet' href='css/bootstrap.css'>
    <link rel='stylesheet' href='css/sweetalert.css'>
    <link rel='stylesheet' href='css/styles.css'>
    <script src='js\jquery-3.3.1.min.js' charset='utf-8'></script>
    <script src='js\live.js' charset='utf-8'></script>
    <script src='js/bootstrap.js' charset='utf-8'></script>
    <script src='js/fontawesome-all.js' charset='utf-8'></script>
    <script src='js/sweetalert.min.js' charset='utf-8'></script>
    <script type="module" src='js/funciones.js' charset='utf-8'></script>
  </head>
  <body>
    <article class='container'>
      <div id='familias'>

      </div>
      <div id='marcas'>

      </div>
      <div id='categorias'>

      </div>
      <div id='anios'>

      </div>
    </article>
    <section id='respuesta'>

    </section>
    
     <button class='btn btn-danger btn-xs' type='button' id='logout' style="position: absolute; top: 10px; right: 10px;" onclick="$(location).attr('href','php/logout.php');">Salir</button>
    
  </body>
</html>
