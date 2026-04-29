<?php
  include('conexiones/conexion.php');

  $respuesta = '';

  $familia = $_POST['familia'];
  $marca = $_POST['marca'];
  $categoria = $_POST['categoria'];
  $anio = $_POST['anio'];

  $consulta = "SELECT * FROM presupuesto_ro
                  WHERE Familia = '$familia'
                    AND Marca = '$marca'
                    AND Categoria = '$categoria'
                    AND Anio = '$anio'
                    ORDER BY MES";

  $presupuestos = mysqli_query( $conexion, $consulta);
  $presupuesto = mysqli_num_rows( $presupuestos );
$id = 0;
  if ($presupuesto > 0){
    $respuesta .= "<form>
                      <div>
                        <label id='venta'>VENTA</label>
                        <label id='compra'>COMPRA</label>
                      </div>
                      <div>
                        <label>MES</label>
                        <label>PRESUPUESTO</label>
                        <label>AJUSTE</label>
                        <label>PLAN</label>
                        <label>AJUSTE</label>
                      </div>";

      while( $dato = mysqli_fetch_assoc($presupuestos)){
        $id++;

        switch ($dato['MES']) {
          case '1':
            $mesL = 'Enero';
            break;

          case '2':
            $mesL = 'Febrero';
            break;

          case '3':
            $mesL = 'Marzo';
            break;

          case '4':
            $mesL = 'Abril';
            break;

            case '5':
              $mesL = 'Mayo';
              break;

            case '6':
              $mesL = 'Junio';
              break;

            case '7':
              $mesL = 'Julio';
              break;

            case '8':
              $mesL = 'Agosto';
              break;

            case '9':
              $mesL = 'Septiembre';
              break;

            case '10':
              $mesL = 'Octubre';
              break;

            case '11':
              $mesL = 'Noviembre';
              break;

            case '12':
              $mesL = 'Diciembre';
              break;

          default:
            // code...
            break;
        }

        $respuesta .= '<div>';
        $respuesta .= '<input class='.'oculto'.' id='.'mes'.$id.' name='.'mes[]'.'  value='.$dato['MES'].' readonly>';
        $respuesta .= '<input class='.'inputi'.' id='.'mesL'.$id.' name='.'mesL[]'.' value='.$mesL.' readonly>';
        $respuesta .= '<input class='.'inputd'.' id='.'pptovta'.$id.' name='.'pptovta[]'.' value='.$dato['PPTO DE VTA'].'>';
        $respuesta .= '<input class='.'inputm'.' id='.'ajustevta'.$id.' name='.'ajustevta[]'.' value='.$dato['VTA AJUSTADO'].'>';
        $respuesta .= '<input class='.'inputd'.' id='.'plancompra'.$id.' name='.'plancompra[]'.' value='.$dato['PLAN COMPRA'].' readonly>';
        $respuesta .= '<input class='.'inputd'.' id='.'ajustecompra'.$id.' name='.'ajustecompra[]'.' value='.$dato['COMPRA AJUSTADO'].'>';
        $respuesta .= '</div>';
      }
      $respuesta .= "<span class='actualizar'> <i class='fas fa-edit'></i> Editar</span></form>";

      session_start();
      $_SESSION['familia'] = $familia;
      $_SESSION['marca'] = $marca;
      $_SESSION['categoria'] = $categoria;
      $_SESSION['anio'] = $anio;

      echo $respuesta;
      mysqli_close( $conexion );
    }else{
      echo '';
      mysqli_close( $conexion );
    }

?>
