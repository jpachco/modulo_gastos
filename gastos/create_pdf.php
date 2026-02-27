<?php

require('pdf/vendor/autoload.php');

$mpdf =new \Mpdf\Mpdf([
    'mode' => 'utf-8',
    'orientation' => 'L'
]);

$css=file_get_contents('css/estilo.css');

$mpdf->writeHTML($css,\Mpdf\HTMLParserMode::HEADER_CSS);


$mpdf->writeHTML("
<header >
    
    <div id='logo' ><img src='img/newlogo.png' alt=''>
    </div>
</header>
<table >
<tr><th colspan='12' class='encabezados-almacen'>F207</th></tr>
<tr><th colspan='5' class='encabezados' > Junio</th>
    <th rowspan='2' class='encabezados-medios' >Gastos Operativos</th>
    <th colspan='5' class='encabezados'>Acumulado Anual</th>
</tr>
<tr><th class='encabezados-years'>2018</th>
    <th class='encabezados-years' >2019</th>
    <th class='encabezados-years' >2020</th>
    <th class='encabezados-years' >2020vs2018</th>
    <th class='encabezados-years' >2020vs2019</th>
    <th class='encabezados-years'>2018</th>
    <th class='encabezados-years' >2019</th>
    <th class='encabezados-years' >2020</th>
    <th class='encabezados-years' >2020vs2018</th>
    <th class='encabezados-years'>2020vs2019</th>
</tr>



<tr>
    
<td >0</td>
    <td >0</td>
    <td >0</td>
    <td >0%</td>
    <td >0%</td>
    <td  class='medios' >Comision por Uso de Tarjeta</td>
    <td >0</td>
    <td >0</td>
    <td >300</td>
    <td >0%</td>
    <td >0%</td></tr>
<tr>
    
<td >0</td>
    <td >0</td>
    <td >0</td>
    <td >0%</td>
    <td >0%</td>
    <td  class='medios' >Agua</td>
    <td >0</td>
    <td >0</td>
    <td >0</td>
    <td >0%</td>
    <td >0%</td></tr>
<tr>
    
<td >0</td>
    <td >0</td>
    <td >0</td>
    <td >0%</td>
    <td >0%</td>
    <td  class='medios' >Articulos de Escritorio</td>
    <td >0</td>
    <td >0</td>
    <td >0</td>
    <td >0%</td>
    <td >0%</td></tr>
<tr>
    
<td >0</td>
    <td >0</td>
    <td >0</td>
    <td >0%</td>
    <td >0%</td>
    <td  class='medios' >Combustibles y Lubricantes</td>
    <td >0</td>
    <td >0</td>
    <td >0</td>
    <td >0%</td>
    <td >0%</td></tr>
<tr>
    
<td >0</td>
    <td >0</td>
    <td >0</td>
    <td >0%</td>
    <td >0%</td>
    <td  class='medios' >Energia Electrica</td>
    <td >0</td>
    <td >0</td>
    <td >0</td>
    <td >0%</td>
    <td >0%</td></tr>
<tr>
    
<td >0</td>
    <td >0</td>
    <td >900</td>
    <td >0%</td>
    <td >0%</td>
    <td  class='medios' >Gastos de Viaje</td>
    <td >0</td>
    <td >0</td>
    <td >900</td>
    <td >0%</td>
    <td >0%</td></tr>
<tr>
    
<td >0</td>
    <td >0</td>
    <td >0</td>
    <td >0%</td>
    <td >0%</td>
    <td  class='medios' >Gastos no Deducibles I.S.R.</td>
    <td >0</td>
    <td >0</td>
    <td >0</td>
    <td >0%</td>
    <td >0%</td></tr>
<tr>
    
<td >0</td>
    <td >0</td>
    <td >0</td>
    <td >0%</td>
    <td >0%</td>
    <td  class='medios' >Mantenimiento</td>
    <td >0</td>
    <td >0</td>
    <td >0</td>
    <td >0%</td>
    <td >0%</td></tr>
<tr>
    
<td >0</td>
    <td >0</td>
    <td >0</td>
    <td >0%</td>
    <td >0%</td>
    <td  class='medios' >Mensajeria</td>
    <td >0</td>
    <td >0</td>
    <td >0</td>
    <td >0%</td>
    <td >0%</td></tr>
<tr>
    
<td >0</td>
    <td >0</td>
    <td >0</td>
    <td >0%</td>
    <td >0%</td>
    <td  class='medios' >Telefono</td>
    <td >0</td>
    <td >0</td>
    <td >0</td>
    <td >0%</td>
    <td >0%</td></tr>
<tr >
    <td>0</td>
    <td>0</td>
    <td>900</td>
    <td>0%</td>
    <td>0%</td>
    <td>TOTAL</td>
    <td>0</td>
    <td>0</td>
    <td>1,200</td>
    <td>0%</td>
    <td>0%</td></tr></table>

",\Mpdf\HTMLParserMode::HTML_BODY);


$mpdf->output();



?>