<?php
include('connsqlsrv.php');
global $conexion;

// Ejecutar la consulta principal
$sql = "SELECT DISTINCT PLM.marca, PR.familia, PR.CATEGORIA, PR.codigo, PR.[COMPRA AJUSTADO], PR.saldo, PLM.fecha_registro, PLM.estatus
FROM [dbRoberts].[dbo].plm_sop PLM
RIGHT JOIN [dbRoberts].[dbo].presupuesto_ro PR ON PLM.codigo_presupuesto = PR.codigo
WHERE PR.[COMPRA AJUSTADO] <> 0
AND fecha_registro > '20240820' 
ORDER BY fecha_registro;";

$result = sqlsrv_query($conexion, $sql);

if ($result === false) {
    die(print_r(sqlsrv_errors(), true));
}

echo '<table border="1" cellpadding="5" cellspacing="0" style="width: 100%;">
        <thead>
            <tr>
                <th>Marca</th>
                <th>Familia</th>
                <th>Categoría</th>
                <th>Código</th>
                <th>Compra Ajustado</th>
                <th>Saldo</th>
                <th>Fecha Registro</th>
                <th>Estatus</th>
            </tr>
        </thead>
        <tbody>';

if (sqlsrv_has_rows($result)) {
    while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
        echo '<tr>
                <td>' . htmlspecialchars($row['marca']) . '</td>
                <td>' . htmlspecialchars($row['familia']) . '</td>
                <td>' . htmlspecialchars($row['CATEGORIA']) . '</td>
                <td>' . htmlspecialchars($row['codigo']) . '</td>
                <td>' . htmlspecialchars($row['COMPRA AJUSTADO']) . '</td>
                <td>' . htmlspecialchars($row['saldo']) . '</td>
                 <td>' . $row['fecha_registro']->format('Y-m-d H:i:s') . '</td>
                <td>' . htmlspecialchars($row['estatus']) . '</td>
              </tr>';
    }
} else {
    echo '<tr><td colspan="8">No se encontraron resultados.</td></tr>';
}

echo '</tbody></table>';

sqlsrv_close($conexion);
?>
