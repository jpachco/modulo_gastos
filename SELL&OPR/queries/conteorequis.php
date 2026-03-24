<?php
include('connsqlsrv.php');
global $conexion;

// Ejecutar la consulta de conteo
$sqlcount = "SELECT COUNT(DISTINCT plm.id) AS total 
FROM [dbRoberts].[dbo].plm_sop plm 
RIGHT JOIN [dbRoberts].[dbo].presupuesto_RO pr ON plm.codigo_presupuesto = pr.codigo
WHERE pr.[COMPRA AJUSTADO] <> 0
AND plm.estatus = 'RECHAZADO'
AND fecha_registro > '20240820'";


$countResult = sqlsrv_query($conexion, $sqlcount);

if ($countResult === false) {
    die(print_r(sqlsrv_errors(), true));
}

$rowCount = sqlsrv_fetch_array($countResult, SQLSRV_FETCH_ASSOC);
$totalCount = $rowCount['total'];

// Ejecutar la segunda consulta, pero no imprimir los resultados
$sql = "SELECT PLM.marca, PR.familia, PR.CATEGORIA, PR.codigo, PR.[COMPRA AJUSTADO], PR.saldo, PLM.fecha_registro, PLM.estatus
        FROM [dbRoberts].[dbo].plm_sop PLM
       RIGHT JOIN [dbRoberts].[dbo].presupuesto_RO PR ON PLM.codigo_presupuesto = PR.codigo
        WHERE PR.[COMPRA AJUSTADO] <> 0
        AND fecha_registro > '20240820'";

$result = sqlsrv_query($conexion, $sql);

if ($result === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Puedes procesar los resultados de la segunda consulta aquí si necesitas
// Para este ejemplo, solo imprimimos el total

sqlsrv_close($conexion);

// Imprimir solo el número del conteo
echo htmlspecialchars($totalCount);
?>
