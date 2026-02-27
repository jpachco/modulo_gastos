<?php

require_once('conect.php');

global $conexionrb;




$Path='C:/xampp/htdocs/Gastos/tiendas - copia.csv';

function csvreader($file)

{
    $registro = array();
# La longitud máxima de la línea del CSV. Si no la sabes,
# ponla en 0 pero la lectura será un poco más lenta
    $longitudDeLinea = 1000;
    $delimitador = ";"; # Separador de columnas
    $caracterCircundante = '"'; # A veces los valores son encerrados entre comillas
    $nombreArchivo =$file; #Ruta del archivo, en este caso está junto a este script
# Abrir el archivo
    $gestor = fopen($nombreArchivo, "r");
    if (!$gestor) {
        exit("No se puede abrir el archivo $nombreArchivo");
    }
#  Comenzar a leer, $numeroDeFila es para llevar un índice
    $numeroDeFila = 0;
    while (($fila = fgetcsv($gestor, $longitudDeLinea, $delimitador,$caracterCircundante)) !== false) {
        $registro[$numeroDeFila] =  $fila;
        $numeroDeFila++;
    }
# Al finar cerrar el gestor
    fclose($gestor);
    #retornamos registros
    return $registro;
}

$data_csv=csvreader($Path);


for($i=0;$i<count($data_csv);$i++){
    if(substr($data_csv[$i][1],0,1 )=="R" ){
        $sql_tiendas=utf8_decode("update tienda
set correo='".$data_csv[$i][4]."'
where tienda='".$data_csv[$i][1]."'


");

        $stm=sqlsrv_query($conexionrb, $sql_tiendas);

        if($stm==false){
            echo $sql_tiendas;
            die( print_r( sqlsrv_errors(), true));
            break;
        }


        print_r($sql_tiendas."\n" );
    }



}