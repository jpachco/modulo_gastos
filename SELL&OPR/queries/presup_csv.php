<?php
ob_start(); // Inicia el buffer de salida

include_once 'connsqlsrv.php'; // Incluir las conexiones

global $conexion;


// Eliminar cualquier contenido previo
ob_clean();

try {
    // Consulta SQL
    $sql = "SELECT pr.MARCA, pr.FAMILIA, pr.CATEGORIA, pr.ANIO, pr.MES, pr.[COMPRA AJUSTADO], plm.compra AS 'COMPRA PLM', pr.saldo 
            FROM presupuesto_ro pr
            LEFT JOIN plm_sop plm ON pr.codigo = plm.codigo_presupuesto
            WHERE ANIO >= 2024
            ORDER BY pr.ANIO, pr.mes, pr.familia, pr.categoria, pr.marca";

    // Preparar y ejecutar la consulta
    $stmt = sqlsrv_query($conexion, $sql);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    // Nombre del archivo CSV
    $filename = "S&OPR Presupuestos " . date('Y-m-d') . ".csv";

    // Configuración para la descarga del archivo
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=' . $filename);

    // Abre la salida para escribir
    $output = fopen('php://output', 'w');

    // Escribe los encabezados
    fputcsv($output, array('MARCA', 'FAMILIA', 'CATEGORIA', 'ANIO', 'MES', 'COMPRA AJUSTADO', 'COMPRA PLM', 'SALDO'));

    // Escribe los datos en el CSV fila por fila
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        fputcsv($output, $row);
    }

    // Cierra el archivo
    fclose($output);
    sqlsrv_free_stmt($stmt);
    ob_end_flush(); // Envía el contenido del buffer
    exit;

} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
?>
