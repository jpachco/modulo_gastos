<?php
require_once ('../conect.php');
require('../../pdf/vendor/autoload.php');
require_once('../../class.smtp.php');
require_once('../../class.phpmailer.php');
global $conexionhl;
$css=file_get_contents('../../css/estilo.css');
ini_set('memory_limit', '1024M');

$aact=date('Y');
$aant=date('Y')-1;
$aaant=date('Y')-2;
$mes_Act=/*date("m")-1*/2;



$meses_acum=array();

for ($i=0;$i<$mes_Act;$i++){


array_push($meses_acum,$i+1);

}
/*
$Path='C:/xampp/htdocs/Gastos/Queries/HL/csv-gastosrep_hl.csv';
*/

function execonsultasqlsrv($query,$conect,$res){
    $i=0;
    if(!$result =sqlsrv_query($conect, $query)) {
        die();
        //echo "Error al registrarse";
    }
//Resultado de consulta
    while($row = sqlsrv_fetch_array($result))

    {
        $res[$i]=$row;
        $i++;
    }
    return $res;
}

$sql_gastos=utf8_decode(
"
    select mes,año,cod_almacen,g.tienda,monto,gpo_financiero,detalle,tipo_ceco,
REGIONAL,isnull( t.Correo,'na')as correo_tienda ,isnull( c.correo ,'na') as correo_manager from (gastos_hl as g left join Tienda as t on g.cod_almacen=t.Tienda )left join 
ZONA as z on t.Tienda=z.Tienda
left join catzo1 as c on z.ZONA= c.IDZONA 

where  año>=2019
"
);






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
function emailsend($emisor,$n_emisor,$psw_emisor,$destinatario,$name_des,$subject,$message,$pathattachment,$copia,$manager){

    $mail = new PHPMailer(true); // Declaramos un nuevo correo, el parametro true significa que mostrara excepciones y errores.
    $mail->IsSMTP(); // Se especifica a la clase que se utilizará SMTP


    try {
//----------------------------------------------------------------------------------------------------------------------
        $correo_emisor=$emisor;     //Correo a utilizar para autenticarse
        //con Gmail o en caso de GoogleApps utilizar con @tudominio.com
        $nombre_emisor=$n_emisor;               //Nombre de quien envía el correo
        $contrasena=$psw_emisor;          //contraseña de tu cuenta en Gmail
        $correo_destino=$destinatario;      //Correo de quien recibe
        $nombre_destino=$name_des;                //Nombre de quien recibe
        $correo_copia=$copia;
        $nombre_copia=$manager;
//----------------------------------------------------------------------------------------------------------------------
        $mail->SMTPDebug  = 2;                     // Habilita información SMTP (opcional para pruebas)
        // 1 = errores y mensajes
        // 2 = solo mensajes
        $mail->SMTPAuth   = true;                  // Habilita la autenticación SMTP
        $mail->SMTPSecure = "tls";                 // Establece el tipo de seguridad SMTP
        $mail->Host       = "smtp-mail.outlook.com";      // Establece Gmail como el servidor SMTP
        $mail->Port       = 587;                   // Establece el puerto del servidor SMTP de Gmail
        $mail->Username   = $correo_emisor;         // Usuario Gmail
        $mail->Password   = $contrasena;           // Contraseña Gmail
        //A que dirección se puede responder el correo
        $mail->AddReplyTo($correo_emisor, $nombre_emisor);
        //La direccion a donde mandamos el correo
        $mail->AddAddress($correo_destino, $nombre_destino);
        //De parte de quien es el correo
        $mail->SetFrom($correo_emisor, $nombre_emisor);
        //Copia del correo
        $mail->addCC($correo_copia,$nombre_copia);
        //Asunto del correo
        $mail->Subject = $subject;
        //Mensaje alternativo en caso que el destinatario no pueda abrir correos HTML
        $mail->AltBody = 'para ver el mensaje necesita un cliente de correo compatible con HTML.';
        //El cuerpo del mensaje, puede ser con etiquetas HTML
        $mail->MsgHTML($message);

        $mail->addAttachment($pathattachment);


        //Enviamos el correo
        $mail->Send();

    }
    catch (phpmailerException $e) {
        echo $e->errorMessage(); //Errores de PhpMailer
        //----------------------------------------------------------------------------------------------------------------------
        $correo_emisor=$emisor;     //Correo a utilizar para autenticarse
        //con Gmail o en caso de GoogleApps utilizar con @tudominio.com
        $nombre_emisor=$n_emisor;               //Nombre de quien envía el correo
        $contrasena=$psw_emisor;          //contraseña de tu cuenta en Gmai
        $correo_destino="magil@h-h.com.mx";      //Correo de quien recibe
        $nombre_destino="Marco Gil";                //Nombre de quien recibe
//----------------------------------------------------------------------------------------------------------------------
        $mail->SMTPDebug  = 2;                     // Habilita información SMTP (opcional para pruebas)
        // 1 = errores y mensajes
        // 2 = solo mensajes
        $mail->SMTPAuth   = true;                  // Habilita la autenticación SMTP
        $mail->SMTPSecure = "tls";                 // Establece el tipo de seguridad SMTP
        $mail->Host       = "smtp-mail.outlook.com";      // Establece Gmail como el servidor SMTP
        $mail->Port       = 587;                   // Establece el puerto del servidor SMTP de Gmail
        $mail->Username   = $correo_emisor;         // Usuario Gmail
        $mail->Password   = $contrasena;           // Contraseña Gmail
        //A que dirección se puede responder el correo
        $mail->AddReplyTo($correo_emisor, $nombre_emisor);
        //La direccion a donde mandamos el correo
        $mail->AddAddress($correo_destino, $nombre_destino);
        //De parte de quien es el correo
        $mail->SetFrom($correo_emisor, $nombre_emisor);
        //Asunto del correo
        $mail->Subject = "Error PHPMAILER";
        //Mensaje alternativo en caso que el destinatario no pueda abrir correos HTML
        $mail->AltBody = 'para ver el mensaje necesita un cliente de correo compatible con HTML.';
        //El cuerpo del mensaje, puede ser con etiquetas HTML
        $mail->MsgHTML($e);
        //Enviamos el correo
        $mail->Send();
        echo "El mensaje se ha enviado correctamente";
    }
    catch (Exception $e) {
        echo $e->getMessage(); //Errores de cualquier otra cosa.

//----------------------------------------------------------------------------------------------------------------------
        $correo_emisor=$emisor;     //Correo a utilizar para autenticarse
        //con Gmail o en caso de GoogleApps utilizar con @tudominio.com
        $nombre_emisor=$n_emisor;               //Nombre de quien envía el correo
        $contrasena=$psw_emisor;          //contraseña de tu cuenta en Gmai
        $correo_destino="magil@h-h.com.mx";     //Correo de quien recibe
        $nombre_destino="Marco Gil";                //Nombre de quien recibe
//----------------------------------------------------------------------------------------------------------------------
        $mail->SMTPDebug  = 2;                     // Habilita información SMTP (opcional para pruebas)
        // 1 = errores y mensajes
        // 2 = solo mensajes
        $mail->SMTPAuth   = true;                  // Habilita la autenticación SMTP
        $mail->SMTPSecure = "tls";                 // ssl Establece el tipo de seguridad SMTP
        $mail->Host       = "smtp-mail.outlook.com";      //smtp.gmail.com Establece Gmail como el servidor SMTP
        $mail->Port       = 587;                   // 465 Establece el puerto del servidor SMTP de Gmail
        $mail->Username   = $correo_emisor;         // Usuario Gmail
        $mail->Password   = $contrasena;           // Contraseña Gmail
        //A que dirección se puede responder el correo
        $mail->AddReplyTo($correo_emisor, $nombre_emisor);
        //La direccion a donde mandamos el correo
        $mail->AddAddress($correo_destino, $nombre_destino);
        //De parte de quien es el correo
        $mail->SetFrom($correo_emisor, $nombre_emisor);
        //Asunto del correo
        $mail->Subject = "Error al Enviar correo";
        //Mensaje alternativo en caso que el destinatario no pueda abrir correos HTML
        $mail->AltBody = 'para ver el mensaje necesita un cliente de correo compatible con HTML.';
        //El cuerpo del mensaje, puede ser con etiquetas HTML
        $mail->MsgHTML($e);
        //Enviamos el correo
        $mail->Send();
        echo "El mensaje se ha enviado correctamente";





    }

}



$data_colect=array();
$dicc_anio=array();
$rawdata_colect=array();
//$data_colect=csvreader($Path);
$rawdata_colect=execonsultasqlsrv($sql_gastos,$conexionhl,$rawdata_colect);
$data_colect=array();
$dicc_tiendas=array();
$dicc_detalles=array();

$estructura=array();
$estructuravta=array();
$ventas=array();
$vtamf=array();
$vtarb=array();
$vtahl=array();
$almacen="";
$mf=0;
$ro=0;
$hl=0;
$bg=0;


for ($i=0;$i<count($rawdata_colect);$i++){

    foreach ($rawdata_colect[$i] as $key=> $clave){
        if(is_numeric($key)   ){


            if($clave=="") {

                $data_colect[$i][]=0;
            }
            else{
                $data_colect[$i][]=utf8_encode($clave);

            }
        }
    }

}








$mft=0;
$rot=0;
$hlt=0;
$bgt=0;
$tiendas_no=array(
    'BM001','F0G1','F0G2','F0G3','F0G5','F0G6','F0G7','F901',
    'F902',
    'F903',
    'F166',
    'R901,',
    'R902',
    'R903',
    'R060',
    'H901',
    'H902',
    'H903',
    'H027',
    'BMPH001',
    'BMPH002',
    'BMPH003',
    'BMPH004',
    'BMPH005',
    'BMPH930',
    'BMPH006',
    'BMPH007',
    'BMPH008',
    'BMPH931',
    'S001',
    'S002',
    'F099',
    'F206',
    'F183',
    'F205',
    'F175',
    'F185',
    'F003',
    'F009',
    'F011',
    'F014',
    'F015',
    'F016',
    'F017',
    'F018',
    'F020',
    'F022',
    'F024',
    'F026',
    'F027',
    'F028',
    'F030',
    'F031',
    'F033',
    'F034',
    'F037',
    'F040',
    'F042',
    'F046',
    'F049',
    'F051',
    'F052',
    'F053',
    'F055',
    'F058',
    'F059',
    'F060',
    'F062',
    'F063',
    'F066',
    'F068',
    'F069',
    'F070',
    'F071',
    'F072',
    'F075',
    'F077',
    'F078',
    'F083',
    'F085',
    'F087',
    'F088',
    'F093',
    'F094',
    'F096',
    'F098',
    'F099',
    'F100',
    'F102',
    'F104',
    'F106',
    'F107',
    'F108',
    'F114',
    'F115',
    'F116',
    'F117',
    'F118',
    'F119',
    'F122',
    'F124',
    'F125',
    'F130',
    'F135',
    'F136',
    'F140',
    'F151',
    'F158',
    'F159',
    'F165',
    'F178',
    'F180',
    'F190',
    'F192',
    'F197',
    'F201',
    'F203',
    'F204',
    'F777',
    'FPTSN',
    'L001',
    'L002',
    'H009',
    'H017',
    'H019',
    'R013',
    'R051',
    'R058',
    'R038',
    'R057'

);

for ($i=0;$i<count($data_colect);$i++ ){



    if ( !in_array( $data_colect[$i][2],$tiendas_no  ) ){

    for ($j=0;$j<count($data_colect[0]);$j++ ) {



            if (in_array($data_colect[$i][6], array("Visual","Comision por Uso de Tarjeta", "Agua", "Articulos de Escritorio", "Combustibles y Lubricantes", "Energia Electrica", "Gastos de Viaje", "Gastos no Deducibles I.S.R.", "Mantenimiento", "Mensajeria", "Telefono"))) {

                if ($j == 6) {

                    $estructura[$i][$j] = trim(utf8_decode($data_colect[$i][$j]));


                } else {


                    $estructura[$i][$j] = utf8_decode($data_colect[$i][$j]);


                }

            } elseif (in_array($data_colect[$i][5], array("Renta de Inmueble","Ventas Netas"))) {


                if ($j == 6) {

                    $estructura[$i][$j] = trim(utf8_decode($data_colect[$i][$j]));

                } else {

                    $estructura[$i][$j] = utf8_decode($data_colect[$i][$j]);

                }


            }

            /*
            elseif (in_array($data_colect[$i][5],array("Renta de Inmueble")))
            {
                if($j==6){
                    $estructura[$i][$j] =trim(utf8_decode($data_colect[$i][$j]));

                }
                else{
                    $estructura[$i][$j] = utf8_decode($data_colect[$i][$j]);

                }
            }*/


            $dicc_tiendas[$i] = utf8_decode($data_colect[$i][2]);
            $dicc_anio[$i] = $data_colect[$i][1];
            switch (trim($data_colect[$i][6])) {

                case trim($data_colect[$i][6]) <> " " or trim($data_colect[$i][6]) <> ""  :

                    $dicc_detalles[$i] = trim(utf8_decode($data_colect[$i][6]));

            }

        }






    }






}



$dicc_anio=array_values(array_unique($dicc_anio));
$dicc_tiendas=array_values(array_unique($dicc_tiendas));




$dicc_detalles=array_values(array_unique($dicc_detalles));
$estructura=array_values($estructura);


$detalles=array("Ventas Netas",
    "Renta de Inmueble",
    "Comision por Uso de Tarjeta",
    "Agua",
    "Articulos de Escritorio",
    "Combustibles y Lubricantes",
    "Energia Electrica",
    "Visual",
    "Gastos de Viaje",
    "Gastos no Deducibles I.S.R.",
    "Mantenimiento",
    "Mensajeria",
    "Telefono");

$table_show=array();
$table_cadena=array();
$year=array();
$table="";
$nalmacen="";
$regional="";

$sumatm_mes_act=0;
$sumatm_mes_act_vn=0;
$sumatm_mes_act_ri=0;
$sumatm_mes_act_cut=0;
$sumatm_mes_act_a=0;
$sumatm_mes_act_ae=0;
$sumatm_mes_act_cl=0;
$sumatm_mes_act_ee=0;
$sumatm_mes_act_v=0;
$sumatm_mes_act_gv=0;
$sumatm_mes_act_gnd=0;
$sumatm_mes_act_man=0;
$sumatm_mes_act_msg=0;
$sumatm_mes_act_tel=0;

$sumatm_mes_acu_vn=0;
$sumatm_mes_acu_ri=0;
$sumatm_mes_acu_cut=0;
$sumatm_mes_acu_a=0;
$sumatm_mes_acu_ae=0;
$sumatm_mes_acu_cl=0;
$sumatm_mes_acu_ee=0;
$sumatm_mes_acu_v=0;
$sumatm_mes_acu_gv=0;
$sumatm_mes_acu_gnd=0;
$sumatm_mes_acu_man=0;
$sumatm_mes_acu_msg=0;
$sumatm_mes_acu_tel=0;




$sumatr_mes_act=0;
$sumatr_mes_act_vn=0;
$sumatr_mes_act_ri=0;
$sumatr_mes_act_cut=0;
$sumatr_mes_act_a=0;
$sumatr_mes_act_ae=0;
$sumatr_mes_act_cl=0;
$sumatr_mes_act_ee=0;
$sumatr_mes_act_v=0;
$sumatr_mes_act_gv=0;
$sumatr_mes_act_gnd=0;
$sumatr_mes_act_man=0;
$sumatr_mes_act_msg=0;
$sumatr_mes_act_tel=0;

$sumatr_mes_acu_vn=0;
$sumatr_mes_acu_ri=0;
$sumatr_mes_acu_cut=0;
$sumatr_mes_acu_a=0;
$sumatr_mes_acu_ae=0;
$sumatr_mes_acu_cl=0;
$sumatr_mes_acu_ee=0;
$sumatr_mes_acu_v=0;
$sumatr_mes_acu_gv=0;
$sumatr_mes_acu_gnd=0;
$sumatr_mes_acu_man=0;
$sumatr_mes_acu_msg=0;
$sumatr_mes_acu_tel=0;

$sumath_mes_act=0;
$sumath_mes_act_vn=0;
$sumath_mes_act_ri=0;
$sumath_mes_act_cut=0;
$sumath_mes_act_a=0;
$sumath_mes_act_ae=0;
$sumath_mes_act_cl=0;
$sumath_mes_act_ee=0;
$sumath_mes_act_v=0;
$sumath_mes_act_gv=0;
$sumath_mes_act_gnd=0;
$sumath_mes_act_man=0;
$sumath_mes_act_msg=0;
$sumath_mes_act_tel=0;

$sumath_mes_acu_vn=0;
$sumath_mes_acu_ri=0;
$sumath_mes_acu_cut=0;
$sumath_mes_acu_a=0;
$sumath_mes_acu_ae=0;
$sumath_mes_acu_cl=0;
$sumath_mes_acu_ee=0;
$sumath_mes_acu_v=0;
$sumath_mes_acu_gv=0;
$sumath_mes_acu_gnd=0;
$sumath_mes_acu_man=0;
$sumath_mes_acu_msg=0;
$sumath_mes_acu_tel=0;

$sumatb_mes_act=0;
$sumatb_mes_act_vn=0;
$sumatb_mes_act_ri=0;
$sumatb_mes_act_cut=0;
$sumatb_mes_act_a=0;
$sumatb_mes_act_ae=0;
$sumatb_mes_act_cl=0;
$sumatb_mes_act_ee=0;
$sumatb_mes_act_v=0;
$sumatb_mes_act_gv=0;
$sumatb_mes_act_gnd=0;
$sumatb_mes_act_man=0;
$sumatb_mes_act_msg=0;
$sumatb_mes_act_tel=0;

$sumatb_mes_acu_vn=0;
$sumatb_mes_acu_cut=0;
$sumatb_mes_acu_ri=0;
$sumatb_mes_acu_a=0;
$sumatb_mes_acu_ae=0;
$sumatb_mes_acu_cl=0;
$sumatb_mes_acu_ee=0;
$sumatb_mes_acu_v=0;
$sumatb_mes_acu_gv=0;
$sumatb_mes_acu_gnd=0;
$sumatb_mes_acu_man=0;
$sumatb_mes_acu_msg=0;
$sumatb_mes_acu_tel=0;


for ($i=0;$i<count($dicc_tiendas);$i++ ) {

    $table_show[$i][]=$dicc_tiendas[$i];

    $tienda=$dicc_tiendas[$i];
    $year[$i][0]=$dicc_tiendas[$i];

    for ($j=0;$j<count($detalles);$j++) {

        $suma_acum1=0;
        $suma_acum2=0;
        $suma_acum3=0;
        $suma_mes_act=0;
        $suma_mes_aant=0;
        $suma_mes_aaant=0;


        for ($k=0; $k<count($estructura);$k++) {

            $detalle_load=$detalles[$j];


            if ($dicc_tiendas[$i]==$estructura[$k][2]
                and $detalles[$j]==$estructura[$k][6]
                and in_array( $estructura[$k][0],$meses_acum)
                and in_array( $estructura[$k][1],array($aaant,$aant,$aact))
                and !in_array($estructura[$k][2],$tiendas_no)
            ){



                $anio=$estructura[$k][1];
                $almacen=$estructura[$k][2];
                $nalmacen=$estructura[$k][3];
                $nalmacen=$estructura[$k][3];
                $etienda=$estructura[$k][9];
                $emanager=$estructura[$k][10];
                $regional=$estructura[$k][8];
                switch ($estructura[$k][1])
                {
                    case $aact:
                        $suma_acum1+=intval(trim(str_replace(",","",$estructura[$k][4]))) ;
                        if(substr($almacen,0,1) =="F" ){

                            switch ($detalle_load){



                                case $detalle_load=='Comision por Uso de Tarjeta':

                                    $sumatm_mes_acu_cut+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                                    break;
                                case $detalle_load=='Agua':

                                    $sumatm_mes_acu_a+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                                    break;
                                case $detalle_load=='Articulos de Escritorio':

                                    $sumatm_mes_acu_ae+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                                    break;
                                case $detalle_load=='Combustibles y Lubricantes':

                                    $sumatm_mes_acu_cl+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                                    break;
                                case $detalle_load=='Energia Electrica':

                                    $sumatm_mes_acu_ee+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                                    break;
                                case $detalle_load=='Visual':

                                    $sumatm_mes_acu_v+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                                    break;
                                case $detalle_load=='Gastos de Viaje':

                                    $sumatm_mes_acu_gv+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                                    break;
                                case $detalle_load=='Gastos no Deducibles I.S.R.':

                                    $sumatm_mes_acu_gnd+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                                    break;
                                case $detalle_load=='Mantenimiento':

                                    $sumatm_mes_acu_man+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                                    break;
                                case $detalle_load=='Mensajeria':

                                    $sumatm_mes_acu_msg+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                                    break;
                                case $detalle_load=='Telefono':

                                    $sumatm_mes_acu_tel+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                                    break;



                            }



                        }
                        else if(substr($almacen,0,1) =="R" ){

                            switch ($detalle_load){

                                case $detalle_load=='Comision por Uso de Tarjeta':

                                    $sumatr_mes_acu_cut+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                                    break;
                                case $detalle_load=='Agua':

                                    $sumatr_mes_acu_a+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                                    break;
                                case $detalle_load=='Articulos de Escritorio':

                                    $sumatr_mes_acu_ae+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                                    break;
                                case $detalle_load=='Combustibles y Lubricantes':

                                    $sumatr_mes_acu_cl+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                                    break;
                                case $detalle_load=='Energia Electrica':

                                    $sumatr_mes_acu_ee+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                                    break;
                                case $detalle_load=='Visual':

                                    $sumatr_mes_acu_v+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                                    break;
                                case $detalle_load=='Gastos de Viaje':

                                    $sumatr_mes_acu_gv+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                                    break;
                                case $detalle_load=='Gastos no Deducibles I.S.R.':

                                    $sumatr_mes_acu_gnd+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                                    break;
                                case $detalle_load=='Mantenimiento':

                                    $sumatr_mes_acu_man+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                                    break;
                                case $detalle_load=='Mensajeria':

                                    $sumatr_mes_acu_msg+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                                    break;
                                case $detalle_load=='Telefono':

                                    $sumatr_mes_acu_tel+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                                    break;



                            }



                        }
                        else if(substr($almacen,0,1) =="H" ){

                            switch ($detalle_load){

                                case $detalle_load=='Comision por Uso de Tarjeta':

                                    $sumath_mes_acu_cut+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                                    break;
                                case $detalle_load=='Agua':

                                    $sumath_mes_acu_a+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                                    break;
                                case $detalle_load=='Articulos de Escritorio':

                                    $sumath_mes_acu_ae+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                                    break;
                                case $detalle_load=='Combustibles y Lubricantes':

                                    $sumath_mes_acu_cl+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                                    break;
                                case $detalle_load=='Energia Electrica':

                                    $sumath_mes_acu_ee+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                                    break;
                                case $detalle_load=='Visual':

                                    $sumath_mes_acu_v+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                                    break;
                                case $detalle_load=='Gastos de Viaje':

                                    $sumath_mes_acu_gv+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                                    break;
                                case $detalle_load=='Gastos no Deducibles I.S.R.':

                                    $sumath_mes_acu_gnd+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                                    break;
                                case $detalle_load=='Mantenimiento':

                                    $sumath_mes_acu_man+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                                    break;
                                case $detalle_load=='Mensajeria':

                                    $sumath_mes_acu_msg+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                                    break;
                                case $detalle_load=='Telefono':

                                    $sumath_mes_acu_tel+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                                    break;



                            }



                        }
                        else if(substr($almacen,0,1) =="B" ){

                            switch ($detalle_load){

                                case $detalle_load=='Comision por Uso de Tarjeta':

                                    $sumatb_mes_acu_cut+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                                    break;
                                case $detalle_load=='Agua':

                                    $sumatb_mes_acu_a+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                                    break;
                                case $detalle_load=='Articulos de Escritorio':

                                    $sumatb_mes_acu_ae+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                                    break;
                                case $detalle_load=='Combustibles y Lubricantes':

                                    $sumatb_mes_acu_cl+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                                    break;
                                case $detalle_load=='Energia Electrica':

                                    $sumatb_mes_acu_ee+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                                    break;
                                case $detalle_load=='Visual':

                                    $sumatb_mes_acu_v+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                                    break;
                                case $detalle_load=='Gastos de Viaje':

                                    $sumatb_mes_acu_gv+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                                    break;
                                case $detalle_load=='Gastos no Deducibles I.S.R.':

                                    $sumatb_mes_acu_gnd+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                                    break;
                                case $detalle_load=='Mantenimiento':

                                    $sumatb_mes_acu_man+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                                    break;
                                case $detalle_load=='Mensajeria':

                                    $sumatb_mes_acu_msg+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                                    break;
                                case $detalle_load=='Telefono':

                                    $sumatb_mes_acu_tel+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                                    break;



                            }



                        }

                    break;
                    case $aant:

                        $suma_acum2+=intval(trim(str_replace(",","",$estructura[$k][4]))) ;
                        break;

                    case $aaant:

                        $suma_acum3+=intval(trim(str_replace(",","",$estructura[$k][4]))) ;
                        break;

                }
                if($estructura[$k][0]==$mes_Act and $estructura[$k][1]==$aact){

                    $suma_mes_act=intval(trim(str_replace(",","",$estructura[$k][4]))) ;


                    if(substr($almacen,0,1) =="F" ){

                        switch ($detalle_load){



                            case $detalle_load=='Comision por Uso de Tarjeta':

                                $sumatm_mes_act_cut+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                                break;
                            case $detalle_load=='Agua':

                                $sumatm_mes_act_a+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                                break;
                            case $detalle_load=='Articulos de Escritorio':

                                $sumatm_mes_act_ae+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                                break;
                            case $detalle_load=='Combustibles y Lubricantes':

                                $sumatm_mes_act_cl+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                                break;
                            case $detalle_load=='Energia Electrica':

                                $sumatm_mes_act_ee+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                                break;
                            case $detalle_load=='Visual':

                                $sumatm_mes_act_v+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                                break;
                            case $detalle_load=='Gastos de Viaje':

                                $sumatm_mes_act_gv+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                                break;
                            case $detalle_load=='Gastos no Deducibles I.S.R.':

                                $sumatm_mes_act_gnd+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                                break;
                            case $detalle_load=='Mantenimiento':

                                $sumatm_mes_act_man+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                                break;
                            case $detalle_load=='Mensajeria':

                                $sumatm_mes_act_msg+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                                break;
                            case $detalle_load=='Telefono':

                                $sumatm_mes_act_tel+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                                break;



                        }



                    }
                   else if(substr($almacen,0,1) =="R" ){

                        switch ($detalle_load){

                            case $detalle_load=='Comision por Uso de Tarjeta':

                                $sumatr_mes_act_cut+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                                break;
                            case $detalle_load=='Agua':

                                $sumatr_mes_act_a+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                                break;
                            case $detalle_load=='Articulos de Escritorio':

                                $sumatr_mes_act_ae+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                                break;
                            case $detalle_load=='Combustibles y Lubricantes':

                                $sumatr_mes_act_cl+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                                break;
                            case $detalle_load=='Energia Electrica':

                                $sumatr_mes_act_ee+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                                break;
                            case $detalle_load=='Visual':

                                $sumatr_mes_act_v+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                                break;
                            case $detalle_load=='Gastos de Viaje':

                                $sumatr_mes_act_gv+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                                break;
                            case $detalle_load=='Gastos no Deducibles I.S.R.':

                                $sumatr_mes_act_gnd+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                                break;
                            case $detalle_load=='Mantenimiento':

                                $sumatr_mes_act_man+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                                break;
                            case $detalle_load=='Mensajeria':

                                $sumatr_mes_act_msg+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                                break;
                            case $detalle_load=='Telefono':

                                $sumatr_mes_act_tel+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                                break;



                        }



                    }
                   else if(substr($almacen,0,1) =="H" ){

                       switch ($detalle_load){

                           case $detalle_load=='Comision por Uso de Tarjeta':

                               $sumath_mes_act_cut+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                               break;
                           case $detalle_load=='Agua':

                               $sumath_mes_act_a+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                               break;
                           case $detalle_load=='Articulos de Escritorio':

                               $sumath_mes_act_ae+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                               break;
                           case $detalle_load=='Combustibles y Lubricantes':

                               $sumath_mes_act_cl+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                               break;
                           case $detalle_load=='Energia Electrica':

                               $sumath_mes_act_ee+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                               break;
                           case $detalle_load=='Visual':

                               $sumath_mes_act_v+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                               break;
                           case $detalle_load=='Gastos de Viaje':

                               $sumath_mes_act_gv+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                               break;
                           case $detalle_load=='Gastos no Deducibles I.S.R.':

                               $sumath_mes_act_gnd+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                               break;
                           case $detalle_load=='Mantenimiento':

                               $sumath_mes_act_man+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                               break;
                           case $detalle_load=='Mensajeria':

                               $sumath_mes_act_msg+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                               break;
                           case $detalle_load=='Telefono':

                               $sumath_mes_act_tel+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                               break;



                       }



                   }
                   else if(substr($almacen,0,1) =="B" ){

                       switch ($detalle_load){

                           case $detalle_load=='Comision por Uso de Tarjeta':

                               $sumatb_mes_act_cut+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                               break;
                           case $detalle_load=='Agua':

                               $sumatb_mes_act_a+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                               break;
                           case $detalle_load=='Articulos de Escritorio':

                               $sumatb_mes_act_ae+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                               break;
                           case $detalle_load=='Combustibles y Lubricantes':

                               $sumatb_mes_act_cl+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                               break;
                           case $detalle_load=='Energia Electrica':

                               $sumatb_mes_act_ee+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                               break;
                           case $detalle_load=='Visual':

                               $sumatb_mes_act_v+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                               break;
                           case $detalle_load=='Gastos de Viaje':

                               $sumatb_mes_act_gv+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                               break;
                           case $detalle_load=='Gastos no Deducibles I.S.R.':

                               $sumatb_mes_act_gnd+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                               break;
                           case $detalle_load=='Mantenimiento':

                               $sumatb_mes_act_man+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                               break;
                           case $detalle_load=='Mensajeria':

                               $sumatb_mes_act_msg+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                               break;
                           case $detalle_load=='Telefono':

                               $sumatb_mes_act_tel+=floatval(trim(str_replace(",","",$estructura[$k][4])))*-1 ;

                               break;



                       }



                   }


                }
               else if($estructura[$k][0]==$mes_Act and $estructura[$k][1]==$aant){

                    $suma_mes_aant=intval(trim(str_replace(",","",$estructura[$k][4]))) ;

                }
               else if($estructura[$k][0]==$mes_Act and $estructura[$k][1]==$aaant){

                    $suma_mes_aaant=intval(trim(str_replace(",","",$estructura[$k][4]))) ;

                }


            }
           else  if ($dicc_tiendas[$i]==$estructura[$k][2]
               and $detalles[$j]==$estructura[$k][5]
               and in_array( $estructura[$k][0],$meses_acum)
               and in_array( $estructura[$k][1],array($aaant,$aant,$aact))
               and !in_array( $estructura[$k][2],$tiendas_no)
           ){
                $anio=$estructura[$k][1];
                $nalmacen=$estructura[$k][3];
               $etienda=$estructura[$k][9];
               $emanager=$estructura[$k][10];
               $almacen=$estructura[$k][2];
                switch ($estructura[$k][1])
                {
                    case $aact:
                        $suma_acum1+=intval(trim(str_replace(",","",$estructura[$k][4]))) ;

                        if(substr($almacen,0,1) =="F" and !in_array( $almacen,$tiendas_no) ){

                            switch ($detalle_load){


                                case $detalle_load=='Ventas Netas':

                                    $sumatm_mes_acu_vn+=floatval(trim(str_replace(",","",$estructura[$k][4]))) ;

                                    break;

                                case $detalle_load=='Renta de Inmueble':

                                    $sumatm_mes_acu_ri+=floatval(trim(str_replace(",","",$estructura[$k][4]*-1))) ;

                                    break;



                            }



                        }
                        else if(substr($almacen,0,1) =="R" and !in_array( $almacen,$tiendas_no) ){

                            switch ($detalle_load){


                                case $detalle_load=='Ventas Netas':

                                    $sumatr_mes_acu_vn+=floatval(trim(str_replace(",","",$estructura[$k][4]))) ;

                                    break;
                                case $detalle_load=='Renta de Inmueble':

                                    $sumatr_mes_acu_ri+=floatval(trim(str_replace(",","",$estructura[$k][4]*-1))) ;

                                    break;


                            }



                        }
                        else if(substr($almacen,0,1) =="H" and !in_array( $almacen,$tiendas_no) ){

                            switch ($detalle_load){


                                case $detalle_load=='Ventas Netas':

                                    $sumath_mes_acu_vn+=floatval(trim(str_replace(",","",$estructura[$k][4]))) ;

                                    break;
                                case $detalle_load=='Renta de Inmueble':

                                    $sumath_mes_acu_ri+=floatval(trim(str_replace(",","",$estructura[$k][4]*-1))) ;

                                    break;


                            }



                        }
                        else if(substr($almacen,0,1) =="B" and !in_array( $almacen,$tiendas_no) ){

                            switch ($detalle_load){


                                case $detalle_load=='Ventas Netas':

                                    $sumatb_mes_acu_vn+=floatval(trim(str_replace(",","",$estructura[$k][4]))) ;

                                    break;
                                case $detalle_load=='Renta de Inmueble':

                                    $sumatb_mes_acu_ri+=floatval(trim(str_replace(",","",$estructura[$k][4]*-1))) ;

                                    break;


                            }



                        }

                        break;
                    case $aant:

                        $suma_acum2+=intval(trim(str_replace(",","",$estructura[$k][4]))) ;
                        break;

                    case $aaant:

                        $suma_acum3+=intval(trim(str_replace(",","",$estructura[$k][4]))) ;
                        break;
                }


                if($estructura[$k][0]==$mes_Act and $estructura[$k][1]==$aact){

                    $suma_mes_act+=intval(trim(str_replace(",","",$estructura[$k][4]))) ;

                    if(substr($almacen,0,1) =="F" and !in_array( $almacen,$tiendas_no) ){

                        switch ($detalle_load){


                            case $detalle_load=='Ventas Netas':

                                $sumatm_mes_act_vn+=floatval(trim(str_replace(",","",$estructura[$k][4]))) ;

                                break;
                            case $detalle_load=='Renta de Inmueble':

                                $sumatm_mes_act_ri+=floatval(trim(str_replace(",","",$estructura[$k][4]*-1))) ;

                                break;


                        }



                    }
                    else if(substr($almacen,0,1) =="R" and !in_array( $almacen,$tiendas_no) ){

                        switch ($detalle_load){


                            case $detalle_load=='Ventas Netas':

                                $sumatr_mes_act_vn+=floatval(trim(str_replace(",","",$estructura[$k][4]))) ;

                                break;
                            case $detalle_load=='Renta de Inmueble':

                                $sumatr_mes_act_ri+=floatval(trim(str_replace(",","",$estructura[$k][4]*-1))) ;

                                break;


                        }



                    }
                    else if(substr($almacen,0,1) =="H" and !in_array( $almacen,$tiendas_no) ){

                        switch ($detalle_load){


                            case $detalle_load=='Ventas Netas':

                                $sumath_mes_act_vn+=floatval(trim(str_replace(",","",$estructura[$k][4]))) ;

                                break;
                            case $detalle_load=='Renta de Inmueble':

                                $sumath_mes_act_ri+=floatval(trim(str_replace(",","",$estructura[$k][4]*-1))) ;

                                break;


                        }



                    }
                    else if(substr($almacen,0,1) =="B" and !in_array( $almacen,$tiendas_no) ){

                        switch ($detalle_load){


                            case $detalle_load=='Ventas Netas':

                                $sumatb_mes_act_vn+=floatval(trim(str_replace(",","",$estructura[$k][4]))) ;

                                break;
                            case $detalle_load=='Renta de Inmueble':

                                $sumatb_mes_act_ri+=floatval(trim(str_replace(",","",$estructura[$k][4]*-1))) ;

                                break;


                        }



                    }


                }
                else if($estructura[$k][0]==$mes_Act and $estructura[$k][1]==$aant){

                    $suma_mes_aant+=intval(trim(str_replace(",","",$estructura[$k][4]))) ;

                }
                else if($estructura[$k][0]==$mes_Act and $estructura[$k][1]==$aaant){

                    $suma_mes_aaant+=intval(trim(str_replace(",","",$estructura[$k][4]))) ;

                }


    if($detalle_load='Ventas Netas'){
               switch ($estructura[$k]){

                   case  substr($estructura[$k][2],0,1)=="F"
                       and $estructura[$k][1]==$aact:

                       $mft+=$estructura[$k][4];


                       break;

                   case  substr($estructura[$k][2],0,1)=="R"
                       and $estructura[$k][1]==$aact:

                       $rot+=$estructura[$k][4];


                       break;

                   case  substr($estructura[$k][2],0,1)=="H"
                       and $estructura[$k][1]==$aact:

                       $hlt+=$estructura[$k][4];


                       break;


                   case  substr($estructura[$k][2],0,1)=="B"
                       and $estructura[$k][1]==$aact:

                       $bgt+=$estructura[$k][4];


                       break;

                   case  substr($estructura[$k][2],0,1)=="F"
                       and $estructura[$k][0]==$mes_Act
                       and $estructura[$k][1]==$aact:

                       $mf+=$estructura[$k][4];


                       break;

                   case  substr($estructura[$k][2],0,1)=="R"
                       and $estructura[$k][0]==$mes_Act
                       and $estructura[$k][1]==$aact:

                       $ro+=$estructura[$k][4];


                       break;

                   case  substr($estructura[$k][2],0,1)=="H"
                       and $estructura[$k][0]==$mes_Act
                       and $estructura[$k][1]==$aact:

                       $hl+=$estructura[$k][4];


                       break;


                   case  substr($estructura[$k][2],0,1)=="B"
                       and $estructura[$k][0]==$mes_Act
                       and $estructura[$k][1]==$aact:

                       $bg+=$estructura[$k][4];


                       break;


               }

}





            }





        }





if($detalles[$j]!='Ventas Netas'   ) {

    $table_show[$i][] = array/*=>array*/
    ($detalles[$j],
        $suma_mes_aaant * -1,
        $suma_mes_aant * -1,
        $suma_mes_act * -1,
        $suma_acum3 * -1,
        $suma_acum2 * -1,
        $suma_acum1 * -1


    );

}
Else{
    $table_show[$i][] = array/*=>array*/
    ($detalles[$j],
        $suma_mes_aaant ,
        $suma_mes_aant,
        $suma_mes_act ,
        $suma_acum3 ,
        $suma_acum2 ,
        $suma_acum1,

        );



}


}



    $table_show[$i][]=$nalmacen;
    $table_show[$i][]=$regional;
    $table_show[$i][]=$etienda;
    $table_show[$i][]=$emanager;



}
for ($i=0;$i<count($dicc_tiendas);$i++ ) {


    for ($j=0;$j<count($detalles);$j++) {

        for ($k=0; $k<count($estructura);$k++) {




            if ($dicc_tiendas[$i]==$estructura[$k][2]
                and $detalles[$j]==$estructura[$k][6]
                and in_array( $estructura[$k][0],$meses_acum)
                and in_array( $estructura[$k][1],array($aaant,$aant,$aact))
                    and !in_array($estructura[$k][2],$tiendas_no)

            ){
                $anio=$estructura[$k][1];
                $almacen=$estructura[$k][2];
                $nalmacen=$estructura[$k][3];
                $regional=$estructura[$k][8];

            }

            else  if ($dicc_tiendas[$i]==$estructura[$k][2]
                and $detalles[$j]==$estructura[$k][5]
                and in_array( $estructura[$k][0],$meses_acum)
                and in_array( $estructura[$k][1],array($aaant,$aant,$aact))
                and !in_array($estructura[$k][2],$tiendas_no)){
                $anio=$estructura[$k][1];
                $nalmacen=$estructura[$k][3];
                $regional=$estructura[$k][8];
                $almacen=$estructura[$k][2];

            }





        }



                    if(substr($almacen,0,1) =="F" and !in_array( $almacen,$tiendas_no) ){

                        switch ($detalles[$j]){


                            case $detalles[$j]=='Ventas Netas':


                                $table_show[$i][$j+1][]=$sumatm_mes_act_vn;
                                $table_show[$i][$j+1][]=$sumatm_mes_acu_vn;




                                break;


                            case $detalles[$j]=='Renta de Inmueble':


                                $table_show[$i][$j+1][]=$sumatm_mes_act_ri;
                                $table_show[$i][$j+1][]=$sumatm_mes_acu_ri;




                                break;
                            case $detalles[$j]=='Comision por Uso de Tarjeta':

                                $table_show[$i][$j+1][] =$sumatm_mes_act_cut;
                                $table_show[$i][$j+1][] =$sumatm_mes_acu_cut;

                                break;
                            case $detalles[$j]=='Agua':

                                $table_show[$i][$j+1][] =$sumatm_mes_act_a;
                                $table_show[$i][$j+1][] =$sumatm_mes_acu_a;

                                break;
                            case $detalles[$j]=='Articulos de Escritorio':

                                $table_show[$i][$j+1][] =$sumatm_mes_act_ae;
                                $table_show[$i][$j+1][] =$sumatm_mes_acu_ae;

                                break;
                            case $detalles[$j]=='Combustibles y Lubricantes':

                                $table_show[$i][$j+1][] =$sumatm_mes_act_cl;
                                $table_show[$i][$j+1][] =$sumatm_mes_acu_cl;

                                break;
                            case $detalles[$j]=='Energia Electrica':

                                $table_show[$i][$j+1][] =$sumatm_mes_act_ee;
                                $table_show[$i][$j+1][] =$sumatm_mes_acu_ee;

                                break;
                            case $detalles[$j]=='Visual':

                                $table_show[$i][$j+1][] =$sumatm_mes_act_v;
                                $table_show[$i][$j+1][] =$sumatm_mes_acu_v;

                                break;
                            case $detalles[$j]=='Gastos de Viaje':

                                $table_show[$i][$j+1][] =$sumatm_mes_act_gv;
                                $table_show[$i][$j+1][] =$sumatm_mes_acu_gv;

                                break;
                            case $detalles[$j]=='Gastos no Deducibles I.S.R.':

                                $table_show[$i][$j+1][] =$sumatm_mes_act_gnd;
                                $table_show[$i][$j+1][] =$sumatm_mes_acu_gnd;

                                break;
                            case $detalles[$j]=='Mantenimiento':

                                $table_show[$i][$j+1][] =$sumatm_mes_act_man;
                                $table_show[$i][$j+1][] =$sumatm_mes_acu_man;

                                break;
                            case $detalles[$j]=='Mensajeria':

                                $table_show[$i][$j+1][] =$sumatm_mes_act_msg;
                                $table_show[$i][$j+1][] =$sumatm_mes_acu_msg;

                                break;
                            case $detalles[$j]=='Telefono':

                                $table_show[$i][$j+1][] =$sumatm_mes_act_tel;
                                $table_show[$i][$j+1][] =$sumatm_mes_acu_tel;

                                break;



                        }



                    }
        ELSE    if(substr($almacen,0,1) =="R" and !in_array( $almacen,$tiendas_no) ){

            switch ($detalles[$j]){


                case $detalles[$j]=='Ventas Netas':


                    $table_show[$i][$j+1][]=$sumatr_mes_act_vn;
                    $table_show[$i][$j+1][]=$sumatr_mes_acu_vn;




                    break;
                case $detalles[$j]=='Renta de Inmueble':


                    $table_show[$i][$j+1][]=$sumatr_mes_act_ri;
                    $table_show[$i][$j+1][]=$sumatr_mes_acu_ri;




                    break;

                case $detalles[$j]=='Comision por Uso de Tarjeta':

                    $table_show[$i][$j+1][] =$sumatr_mes_act_cut;
                    $table_show[$i][$j+1][] =$sumatr_mes_acu_cut;

                    break;
                case $detalles[$j]=='Agua':

                    $table_show[$i][$j+1][] =$sumatr_mes_act_a;
                    $table_show[$i][$j+1][] =$sumatr_mes_acu_a;

                    break;
                case $detalles[$j]=='Articulos de Escritorio':

                    $table_show[$i][$j+1][] =$sumatr_mes_act_ae;
                    $table_show[$i][$j+1][] =$sumatr_mes_acu_ae;

                    break;
                case $detalles[$j]=='Combustibles y Lubricantes':

                    $table_show[$i][$j+1][] =$sumatr_mes_act_cl;
                    $table_show[$i][$j+1][] =$sumatr_mes_acu_cl;

                    break;
                case $detalles[$j]=='Energia Electrica':

                    $table_show[$i][$j+1][] =$sumatr_mes_act_ee;
                    $table_show[$i][$j+1][] =$sumatr_mes_acu_ee;

                    break;
                case $detalles[$j]=='Visual':

                    $table_show[$i][$j+1][] =$sumatr_mes_act_v;
                    $table_show[$i][$j+1][] =$sumatr_mes_acu_v;

                    break;
                case $detalles[$j]=='Gastos de Viaje':

                    $table_show[$i][$j+1][] =$sumatr_mes_act_gv;
                    $table_show[$i][$j+1][] =$sumatr_mes_acu_gv;

                    break;
                case $detalles[$j]=='Gastos no Deducibles I.S.R.':

                    $table_show[$i][$j+1][] =$sumatr_mes_act_gnd;
                    $table_show[$i][$j+1][] =$sumatr_mes_acu_gnd;

                    break;
                case $detalles[$j]=='Mantenimiento':

                    $table_show[$i][$j+1][] =$sumatr_mes_act_man;
                    $table_show[$i][$j+1][] =$sumatr_mes_acu_man;

                    break;
                case $detalles[$j]=='Mensajeria':

                    $table_show[$i][$j+1][] =$sumatr_mes_act_msg;
                    $table_show[$i][$j+1][] =$sumatr_mes_acu_msg;

                    break;
                case $detalles[$j]=='Telefono':

                    $table_show[$i][$j+1][] =$sumatr_mes_act_tel;
                    $table_show[$i][$j+1][] =$sumatr_mes_acu_tel;

                    break;



            }



        }
        else if(substr($almacen,0,1) =="H" and !in_array( $almacen,$tiendas_no) ){

            switch ($detalles[$j]){


                case $detalles[$j]=='Ventas Netas':


                    $table_show[$i][$j+1][]=$sumath_mes_act_vn;
                    $table_show[$i][$j+1][]=$sumath_mes_acu_vn;




                    break;


                case $detalles[$j]=='Renta de Inmueble':


                    $table_show[$i][$j+1][]=$sumath_mes_act_ri;
                    $table_show[$i][$j+1][]=$sumath_mes_acu_ri;




                    break;
                case $detalles[$j]=='Comision por Uso de Tarjeta':

                    $table_show[$i][$j+1][] =$sumath_mes_act_cut;
                    $table_show[$i][$j+1][] =$sumath_mes_acu_cut;

                    break;
                case $detalles[$j]=='Agua':

                    $table_show[$i][$j+1][] =$sumath_mes_act_a;
                    $table_show[$i][$j+1][] =$sumath_mes_acu_a;

                    break;
                case $detalles[$j]=='Articulos de Escritorio':

                    $table_show[$i][$j+1][] =$sumath_mes_act_ae;
                    $table_show[$i][$j+1][] =$sumath_mes_acu_ae;

                    break;
                case $detalles[$j]=='Combustibles y Lubricantes':

                    $table_show[$i][$j+1][] =$sumath_mes_act_cl;
                    $table_show[$i][$j+1][] =$sumath_mes_acu_cl;

                    break;
                case $detalles[$j]=='Energia Electrica':

                    $table_show[$i][$j+1][] =$sumath_mes_act_ee;
                    $table_show[$i][$j+1][] =$sumath_mes_acu_ee;

                    break;
                case $detalles[$j]=='Visual':

                    $table_show[$i][$j+1][] =$sumath_mes_act_v;
                    $table_show[$i][$j+1][] =$sumath_mes_acu_v;

                    break;
                case $detalles[$j]=='Gastos de Viaje':

                    $table_show[$i][$j+1][] =$sumath_mes_act_gv;
                    $table_show[$i][$j+1][] =$sumath_mes_acu_gv;

                    break;
                case $detalles[$j]=='Gastos no Deducibles I.S.R.':

                    $table_show[$i][$j+1][] =$sumatm_mes_act_gnd;
                    $table_show[$i][$j+1][] =$sumatm_mes_acu_gnd;

                    break;
                case $detalles[$j]=='Mantenimiento':

                    $table_show[$i][$j+1][] =$sumath_mes_act_man;
                    $table_show[$i][$j+1][] =$sumath_mes_acu_man;

                    break;
                case $detalles[$j]=='Mensajeria':

                    $table_show[$i][$j+1][] =$sumath_mes_act_msg;
                    $table_show[$i][$j+1][] =$sumath_mes_acu_msg;

                    break;
                case $detalles[$j]=='Telefono':

                    $table_show[$i][$j+1][] =$sumath_mes_act_tel;
                    $table_show[$i][$j+1][] =$sumath_mes_acu_tel;

                    break;



            }



        }
        else if(substr($almacen,0,1) =="B" and !in_array( $almacen,$tiendas_no) ){

            switch ($detalles[$j]){


                case $detalles[$j]=='Ventas Netas':


                    $table_show[$i][$j+1][]=$sumatb_mes_act_vn;
                    $table_show[$i][$j+1][]=$sumatb_mes_acu_vn;




                    break;
                case $detalles[$j]=='Renta de Inmueble':


                    $table_show[$i][$j+1][]=$sumatb_mes_act_ri;
                    $table_show[$i][$j+1][]=$sumatb_mes_acu_ri;




                    break;


                case $detalles[$j]=='Comision por Uso de Tarjeta':

                    $table_show[$i][$j+1][] =$sumatb_mes_act_cut;
                    $table_show[$i][$j+1][] =$sumatb_mes_acu_cut;

                    break;
                case $detalles[$j]=='Agua':

                    $table_show[$i][$j+1][] =$sumatb_mes_act_a;
                    $table_show[$i][$j+1][] =$sumatb_mes_acu_a;

                    break;
                case $detalles[$j]=='Articulos de Escritorio':

                    $table_show[$i][$j+1][] =$sumatb_mes_act_ae;
                    $table_show[$i][$j+1][] =$sumatb_mes_acu_ae;

                    break;
                case $detalles[$j]=='Combustibles y Lubricantes':

                    $table_show[$i][$j+1][] =$sumatb_mes_act_cl;
                    $table_show[$i][$j+1][] =$sumatb_mes_acu_cl;

                    break;
                case $detalles[$j]=='Energia Electrica':

                    $table_show[$i][$j+1][] =$sumatb_mes_act_ee;
                    $table_show[$i][$j+1][] =$sumatb_mes_acu_ee;

                    break;
                case $detalles[$j]=='Visual':

                    $table_show[$i][$j+1][] =$sumatb_mes_act_v;
                    $table_show[$i][$j+1][] =$sumatb_mes_acu_v;

                    break;
                case $detalles[$j]=='Gastos de Viaje':

                    $table_show[$i][$j+1][] =$sumatb_mes_act_gv;
                    $table_show[$i][$j+1][] =$sumatb_mes_acu_gv;

                    break;
                case $detalles[$j]=='Gastos no Deducibles I.S.R.':

                    $table_show[$i][$j+1][] =$sumatb_mes_act_gnd;
                    $table_show[$i][$j+1][] =$sumatb_mes_acu_gnd;

                    break;
                case $detalles[$j]=='Mantenimiento':

                    $table_show[$i][$j+1][] =$sumatb_mes_act_man;
                    $table_show[$i][$j+1][] =$sumatb_mes_acu_man;

                    break;
                case $detalles[$j]=='Mensajeria':

                    $table_show[$i][$j+1][] =$sumatb_mes_act_msg;
                    $table_show[$i][$j+1][] =$sumatb_mes_acu_msg;

                    break;
                case $detalles[$j]=='Telefono':

                    $table_show[$i][$j+1][] =$sumatb_mes_act_tel;
                    $table_show[$i][$j+1][] =$sumatb_mes_acu_tel;

                    break;



            }



        }









    }





}
$mes_letra="";
switch ($mes_Act){
    case 1: $mes_letra="Enero";
    break;
    case 2: $mes_letra="Febrero";
        break;
    case 3: $mes_letra="Marzo";
        break;
    case 4: $mes_letra="Abril";
        break;
    case 5: $mes_letra="Mayo";
        break;
    case 6: $mes_letra="Junio";
        break;
    case 7: $mes_letra="Julio";
        break;
    case 8: $mes_letra="Agosto";
        break;
    case 9: $mes_letra="Septiembre";
        break;
    case 10: $mes_letra="Octubre";
        break;
    case 11: $mes_letra="Noviembre";
        break;
    case 12: $mes_letra="Diciembre";
        break;

}
$tmes_2018=0;
$tmes_2019=0;
$tmes_2020=0;
$estructura="";
$tfamilia='font-family: "Teko",sans-serif;';


$table_txt=array();
$cuenta_tableshow=count($table_show[0])-4;

  for ($i=0;$i<count($table_show);$i++) {

      if( !in_array( $table_show[$i][0],$tiendas_no) ){




      $table = "";
      $tmes_2018 = 0;
      $tmes_2019 = 0;
      $tmes_2020 = 0;
      $tmes_acun_2018 = 0;
      $tmes_acun_2019 = 0;
      $tmes_acun_2020 = 0;
      $table .= "<table >


<tr><th colspan='11' class='encabezados-almacen'>" . $table_show[$i][0] ." ". $table_show[$i][14] . "</th></tr>
<tr><th colspan='5' class='encabezados' > " . $mes_letra . "</th>
    <th rowspan='2' class='encabezados-medios' >Gastos Operativos</th>
    <th colspan='5' class='encabezados'>Acumulado Anual</th>
</tr>
<tr><th class='encabezados-years'>" . $aaant . "</th>
    <th class='encabezados-years' >" . $aant . "</th>
    <th class='encabezados-years' >" . $aact . "</th>
    <th class='encabezados-years' >Tienda%</th>"."
   <th class='encabezados-years' >" ."Cadena%". /*$aact. "vs" . $aaant . */"</th>"/*

    <th class='encabezados-years' >" . $aact . "vs" . $aant . "</th>*/."
    <th class='encabezados-years'>" . $aaant . "</th>
    <th class='encabezados-years' >" . $aant . "</th>
    <th class='encabezados-years' >" . $aact . "</th>".
   "<th class='encabezados-years' >Tienda%</th>".
    "<th class='encabezados-years' >"."Cadena%" . /*$aact . "vs" . $aaant . */"</th>".
    /*<th class='encabezados-years'>" . $aact . "vs" . $aant . "</th>*/
"</tr>


";
      $z = 0;

      for ($j = 1; $j < $cuenta_tableshow; $j++) {
/*
          $tmes_2018 += $table_show[$i][$j][1];
          $tmes_2019 += $table_show[$i][$j][2];
          $tmes_2020 += $table_show[$i][$j][3];
          $tmes_acun_2018 += $table_show[$i][$j][4];
          $tmes_acun_2019 += $table_show[$i][$j][5];
          $tmes_acun_2020 += $table_show[$i][$j][6];*/





          if ($z == $j) {
              $tr_color = "background-color:#ddd;";
          } else {
              $tr_color = "background-color:white;";
          }


          $table .= "
<tr>
    
    <td >$" . number_format($table_show[$i][$j][1], 0, '.', ',') . "</td>
    <td >$" . number_format($table_show[$i][$j][2], 0, '.', ',') . "</td>
    <td >$" . number_format($table_show[$i][$j][3], 0, '.', ',') . "</td>
    <td >";
          if ($table_show[$i][1][3] != 0/* and $table_show[$i][$j][1] != 0*/ ) {
              $table .= number_format((($table_show[$i][$j][3] /$table_show[$i][1][3])) * 100, 2, '.', ',');
          } else {
              $table .= 0;
          }
          $table .=  "%</td>
 <td >";
          if ($table_show[$i][$j][7] != 0 or !is_nan( $table_show[$i][$j][7] / $table_show[$i][1][7])  or !is_infinite( $table_show[$i][$j][7] / $table_show[$i][1][7]) or !is_null( $table_show[$i][$j][7] / $table_show[$i][1][7])   ) {

              $table .= number_format((($table_show[$i][$j][7] / $table_show[$i][1][7]) ) * 100, 2, '.', ',');
          }
          elseif ($table_show[$i][$j][7] = 0 or is_nan( $table_show[$i][$j][7] / $table_show[$i][1][7])  or is_infinite( $table_show[$i][$j][7] / $table_show[$i][1][7]) or is_null( $table_show[$i][$j][7] / $table_show[$i][1][7])   ) {

              $table .= 0;
          }
          else {
              $table .= 0;
          }
          $table .=  "%</td>
    <td  class='medios' >" . $table_show[$i][$j][0] . "</td>
    <td >$" . number_format($table_show[$i][$j][4], 0, '.', ',') . "</td>
    <td >$" . number_format($table_show[$i][$j][5], 0, '.', ',') . "</td>
    <td >$" . number_format($table_show[$i][$j][6], 0, '.', ',') . "</td>
    <td >";
          if ($table_show[$i][1][6] != 0 /*and $table_show[$i][$j][4] != 0]*/) {
              $table .= number_format((($table_show[$i][$j][6] / $table_show[$i][1][6]) ) * 100, 2, '.', ',');
          } else {
              $table .= 0;
          }
          $table .= "%</td>".
              "<td >";
           if ($table_show[$i][$j][8] != 0 or !is_nan( $table_show[$i][$j][8] / $table_show[$i][1][8])  or !is_infinite( $table_show[$i][$j][8] / $table_show[$i][1][8]) or !is_null( $table_show[$i][$j][8] / $table_show[$i][1][8])    ) {

              $table .= number_format((($table_show[$i][$j][8] / $table_show[$i][1][8]) ) * 100, 2, '.', ',');
          }
          elseif ($table_show[$i][$j][8] = 0 and is_nan( $table_show[$i][$j][8] / $table_show[$i][1][8])  and is_infinite( $table_show[$i][$j][8] / $table_show[$i][1][8]) or is_null( $table_show[$i][$j][8] / $table_show[$i][1][8])   ) {

              $table .=0;
           }
          else {
              $table .= 0;
          }
          $table .= "%</td>"./*
    <td >";
          if ($table_show[$i][$j][6] != 0 and $table_show[$i][$j][5] != 0) {
              $table .= number_format((($table_show[$i][$j][6] / $table_show[$i][$j][5]) - 1) * 100, 0, '.', ',');
          } else {
              $table .= 0;
          }
          $table .= "%</td>*/"</tr>";

          $z += 1;

      }
/*
      $table .= "
<tr >
    <td>$" . number_format($tmes_2018, 0, '.', ',') . "</td>
    <td>$" . number_format($tmes_2019, 0, '.', ',') . "</td>
    <td>$" . number_format($tmes_2020, 0, '.', ',') . "</td>
    <td>";
      if ($tmes_2020 != 0 and $tmes_2018 != 0) {
          $table .= number_format((($tmes_2020 / $tmes_2018) - 1) * 100, 0, '.', ',');
      } else {
          $table .= 0;
      }
      $table .= "%</td>
    <td>";
      if ($tmes_2020 != 0 and $tmes_2019 != 0) {
          $table .= number_format((($tmes_2020 / $tmes_2019) - 1) * 100, 0, '.', ',');
      } else {
          $table .= 0;
      }
      $table .= "%</td>
    <td>TOTAL</td>
    <td>$" . number_format($tmes_acun_2018, 0, '.', ',') . "</td>
    <td>$" . number_format($tmes_acun_2019, 0, '.', ',') . "</td>
    <td>$" . number_format($tmes_acun_2020, 0, '.', ',') . "</td>
    <td>";
      if ($tmes_acun_2020 != 0 and $tmes_acun_2018 != 0) {
          $table .= number_format((($tmes_acun_2020 / $tmes_acun_2018) - 1) * 100, 0, '.', ',');
      } else {
          $table .= 0;
      }
      $table .= "%</td>
    <td>";
      if ($tmes_acun_2020 != 0 and $tmes_acun_2019 != 0) {
          $table .=  number_format((($tmes_acun_2020 / $tmes_acun_2019) - 1) * 100, 0, '.', ',');
      } else {
          $table .= 0;
      }
      $table .= "%</td></tr>";*/
      $table .= '</table>';
        $table_txt[$i][0]=$table_show[$i][0];
        $table_txt[$i][1]=strval( $table );
          $table_txt[$i][2]=$table_show[$i][16];
          $table_txt[$i][3]=$table_show[$i][17];
          $table_txt[$i][4]=$table_show[$i][14];
          $table_txt[$i][5]=$mes_letra;
          $table_txt[$i][6]=$aact;
          $table_txt[$i][7]=$table_show[$i][15];



      }

  }
  function emitepdf($stilo,$datos,$namet){
      require('../../pdf/vendor/autoload.php');
      $mpdfConfig = array(
          'mode' => 'utf-8',
          'format' => 'A4',
          'orientation' => 'L',
          'autoMarginPadding' => 0
      );

      $mpdf = new \Mpdf\Mpdf($mpdfConfig);



      ob_start();

      $mpdf->setAutoTopMargin = 'pad';


      $mpdf->SetHTMLHeader (' <div style="overflow: hidden;
	width: 100%; height: 120px"> 
	
                    <div style="float: left; width:45% ;"> <img src="../../img/newlogo.png"  ></div> 
                    <div style="float: right; width:45% ; font-size: 12px; text-align:left  " >  <h1>Grupo Haber Holding</h1>
        <h1>Cedula de Gastos Operativos</h1>
        <h1>Resultados contables, cifras en pesos</h1></div>
                    
                    </div>');

      $mpdf->writeHTML($stilo, \Mpdf\HTMLParserMode::HEADER_CSS);

      $mpdf->writeHTML($datos, \Mpdf\HTMLParserMode::HTML_BODY);

      $mpdf->output($namet.".pdf");


      var_dump(ob_get_clean());

  }

$message_body=utf8_decode( "<br>Buenas tardes</br>"."
<br></br>
<br>Adjunto se envía el reporte de gastos mensual, al trabajar con él se debe recordar:</br>
<br></br>
<br>1.	El Objetivo del reporte es generar la cultura del cuidado en los gastos</br>
<br>2.	Son resultados contables y no incluyen IVA</br>
<br>3.	Los gastos que se presentan son los imputables a cada tienda, por ejemplo: si el área de visual viajó a visitar la tienda se carga ahí por lo cual están en derecho de exigir se realice el trabajo pertinente</br>
<br>4.	Para cualquier duda o aclaración en primer instancia se deberá revisar con el área manager responsable de la tienda y si el lo considera adecuado con gusto les respondo sus dudas: Carlos Navarro (cnavarro@h-h.com.mx)</br>


");





$email_emi="cnavarro@h-h.com.mx";
$nombre_emi="Carlos Alfonso Navarro Avila";
$psw_emi="c".chr(36)."Ee1@T6";


  for ($i=0;$i<count($table_txt);$i++){

     emitepdf($css,$table_txt[$i][1],$table_txt[$i][0]);

      if($table_txt[$i][3]=="na"){


          $correo_tienda=$table_txt[$i][2];
          $correo_manager="";
          $manager="";


      }
      else{

          $correo_tienda=$table_txt[$i][2];
          $correo_manager=$table_txt[$i][3];
          $manager=$table_txt[$i][7];
      }
        $path_file='C:/xampp/htdocs/Gastos/Queries/HL/'.$table_txt[$i][0].'.pdf';

/*
          emailsend($email_emi,
          $nombre_emi,
          $psw_emi,
          $correo_tienda,
                    $table_txt[$i][4],
         "Cedula Gastos ".$table_txt[$i][5]." ".$table_txt[$i][6],
          $message_body,
        $path_file,
      $correo_manager,
      utf8_decode($manager) ) ;*/




//print_r($correo_manager."-".$correo_tienda."\n" );


  }


