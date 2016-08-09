<?php


require_once("../Clase/conectar.php");
$conexion = conectar($bd_host, $bd_usuario, $bd_pwd);
$sqlSab = 'SELECT '
        . ' SUM(personas_certificadas) AS cnt '
        . 'FROM ( '
        . ' SELECT '
        . ' centro_regional_id_regional AS codigo_regional, '
        . ' substr(centro_id_centro,0,4) AS codigo_centro, '
        . ' CASE '
        . '   WHEN substr(centro_id_centro,0,4) = 9540 '
        . '   THEN count(DISTINCT nroident) + ( '
        . '    SELECT '
        . '     count(DISTINCT documento) '
        . '    FROM t_nccer '
        . "    WHERE certificado = 'SI' "
        . "     AND fecha_corte >= '01/01/2016') "
        . '   ELSE count(DISTINCT nroident) END AS personas_certificadas '
        . ' FROM t_historico '
        . " WHERE tipo_certificado = 'NC' "
        . "  AND tipo_estado = 'CERTIFICA' "
        . "  AND to_char(fecha_registro,'yyyy') = 2016 "
        . ' GROUP BY '
        . '  centro_regional_id_regional, '
        . '  centro_id_centro '
        . ' )';

$objSab = oci_parse($conexion, $sqlSab);
oci_execute($objSab);
$numRowsSab = oci_fetch_all($objSab, $rowSab);

if ($numRowsSab = 1) {
    $archivo = 'contadorCertificaciones.txt';

    $fp = fopen($archivo, 'w');
    $linea = $rowSab['CNT'][0];
    fwrite($fp, $linea);
    fclose($fp);
}
