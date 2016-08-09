<?php
$f = date('Y-m-d');
//insertamos los headers que van a generar el archivo excel
header("Content-type: application/vnd.ms-excel");
//en filename vamos a colocar el nombre con el que el archivo xls sera generado
header("Content-Disposition: attachment; filename=programacion_auditorias_$f.xls");
header("Pragma: no-cache");
header("Expires: 0");

include("../Clase/conectar.php");
$connection = conectar($bd_host, $bd_usuario, $bd_pwd);
//realizamos la consulta
?>
<!DOCTYPE html PUBLIC “-//W3C//DTD XHTML 1.0 Transitional//EN” “http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd”>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Reporte Centros</title>
    </head>

    <body><!–Vamos a crear una tabla que será impresa en el archivo excel –>
        <table width="600" border="0">
            <tr>
                <th colspan="15">
                    <!–Imprimimos un titulo –>
                    <div style="color:#003; text-align:center; text-shadow:#666; " style="font-size: 20px">
                        Reporte Programación de Auditorias y Planes de acción de Mejora - Proyectos año 2016 <br> Corte <?php echo $f ?> 
                    </div>
                </th>
            </tr>
        </table>
        <br/><br/>
        <table width="641" border="1">
            <tr style="background-color:#006; text-align:center; color:#FFF">
                <th><strong>Código Regional</strong></th>
                <th><strong>Nombre Regional</strong></th>
                <th><strong>Código Centro</strong></th>
                <th><strong>Nombre Centro</strong></th>
                <th><strong>Código Mesa</strong></th>
                <th><strong>Nombre Mesa</strong></th>
                <th><strong>Código Norma</strong></th>
                <th><strong>Titulo Norma</strong></th>
                <th><strong>Código Proyecto</strong></th>
                <th><strong>Consecutivo Grupo</strong></th>
                <th><strong>Inscritos</strong></th>
                <th><strong>Emisión de juicio (Fecha Inicio)</strong></th>
                <th><strong>Emisión de juicio (Fecha Fin)</strong></th>
                <th><strong>Auditoria de proceso (Fecha Inicio)</strong></th>
                <th><strong>Auditoria de proceso (Fecha Fin)</strong></th>
                <th><strong>Plan de acción de Mejora(Fecha Inicio)</strong></th>
                <th><strong>Plan de acción de Mejora(Fecha Fin)</strong></th>
                <th><strong>Certificacion (Fecha Inicio)</strong></th>
                <th><strong>Certificacion (Fecha Fin)</strong></th>
            </tr>
            <?php
            $query2 = "SELECT REG.CODIGO_REGIONAL, REG.NOMBRE_REGIONAL, CEN.CODIGO_CENTRO, CEN.NOMBRE_CENTRO, ME.CODIGO_MESA, ME.NOMBRE_MESA, NOR.CODIGO_NORMA, NOR.ID_NORMA, NOR.TITULO_NORMA, PY.ID_PROYECTO, PG.N_GRUPO, COUNT(*) INSCRITOS FROM PROYECTO_GRUPO PG
INNER JOIN PROYECTO PY 
ON PG.ID_PROYECTO = PY.ID_PROYECTO
INNER JOIN CENTRO CEN
ON PY.ID_CENTRO = CEN.CODIGO_CENTRO
INNER JOIN REGIONAL REG
ON CEN.CODIGO_REGIONAL = REG.CODIGO_REGIONAL
INNER JOIN NORMA NOR
ON PG.ID_NORMA = NOR.ID_NORMA
INNER JOIN MESA ME
ON NOR.CODIGO_MESA = ME.CODIGO_MESA
WHERE SUBSTR(PY.FECHA_ELABORACION, 7,4) = 2016
GROUP BY REG.CODIGO_REGIONAL, REG.NOMBRE_REGIONAL, CEN.CODIGO_CENTRO, CEN.NOMBRE_CENTRO, ME.CODIGO_MESA, ME.NOMBRE_MESA, NOR.CODIGO_NORMA, NOR.ID_NORMA, NOR.TITULO_NORMA, PY.ID_PROYECTO, PG.N_GRUPO
ORDER BY REG.NOMBRE_REGIONAL ASC, CEN.NOMBRE_CENTRO ASC";
            $statement2 = oci_parse($connection, $query2);
            oci_execute($statement2);
            $fondo = '#D9E1F2';
            while ($row2 = oci_fetch_array($statement2, OCI_BOTH))
            {
                if ($fondo == '#D9E1F2')
                {
                    $fondo = '#B4C6E7';
                }
                else
                {
                    $fondo = '#D9E1F2';
                }


                $queryEmision = "SELECT FECHA_INICIO, FECHA_FIN FROM "
                        . "CRONOGRAMA_GRUPO WHERE "
                        . "ID_PROYECTO = $row2[ID_PROYECTO] AND ID_NORMA = $row2[ID_NORMA] AND N_GRUPO = $row2[N_GRUPO] AND ID_ACTIVIDAD = 11  AND ESTADO='1'";
                $statementEmision = oci_parse($connection, $queryEmision);
                oci_execute($statementEmision);
                $rowEmision = oci_fetch_array($statementEmision, OCI_BOTH);
                
                $queryAudPro = "SELECT FECHA_INICIO, FECHA_FIN FROM "
                        . "CRONOGRAMA_GRUPO WHERE "
                        . "ID_PROYECTO = $row2[ID_PROYECTO] AND ID_NORMA = $row2[ID_NORMA] AND N_GRUPO = $row2[N_GRUPO] AND ID_ACTIVIDAD = 15  AND ESTADO='1'";
                $statementAudPro = oci_parse($connection, $queryAudPro);
                oci_execute($statementAudPro);
                $rowAudPro = oci_fetch_array($statementAudPro, OCI_BOTH);
                
                $queryPlan = "SELECT FECHA_INICIO, FECHA_FIN FROM "
                        . "CRONOGRAMA_GRUPO WHERE "
                        . "ID_PROYECTO = $row2[ID_PROYECTO] AND ID_NORMA = $row2[ID_NORMA] AND N_GRUPO = $row2[N_GRUPO] AND ID_ACTIVIDAD = 16  AND ESTADO='1'";
                $statementPlan = oci_parse($connection, $queryPlan);
                oci_execute($statementPlan);
                $rowPlan = oci_fetch_array($statementPlan, OCI_BOTH);
                        
                $queryCertificacion = "SELECT FECHA_INICIO, FECHA_FIN FROM "
                        . "CRONOGRAMA_GRUPO WHERE "
                        . "ID_PROYECTO = $row2[ID_PROYECTO] AND ID_NORMA = $row2[ID_NORMA] AND N_GRUPO = $row2[N_GRUPO] AND ID_ACTIVIDAD = 18  AND ESTADO='1'";
                $statementCertificacion = oci_parse($connection, $queryCertificacion);
                oci_execute($statementCertificacion);
                $rowCertificacion = oci_fetch_array($statementCertificacion, OCI_BOTH)
                        
                        
                ?>
                <tr style="background-color:<?php echo $fondo ?>">
                    <td>
                        <?php echo $row2['CODIGO_REGIONAL'] ?>
                    </td>
                    <td>
                        <?php echo utf8_encode($row2['NOMBRE_REGIONAL']) ?>
                    </td>
                    <td>
                        <?php echo $row2['CODIGO_CENTRO'] ?>
                    </td>
                    <td>
                        <?php echo utf8_encode($row2['NOMBRE_CENTRO']) ?>
                    </td>
                    <td>
                        <?php echo $row2['CODIGO_MESA'] ?>
                    </td>
                    <td>
                        <?php echo utf8_encode($row2['NOMBRE_MESA']) ?>
                    </td>
                    <td>
                        <?php echo $row2['CODIGO_NORMA'] ?>
                    </td>
                    <td>
                        <?php echo utf8_encode($row2['TITULO_NORMA']) ?>
                    </td>
                    <td>
                        <?php echo $row2['ID_PROYECTO'] ?>
                    </td>
                    <td>
                        <?php echo "Grupo " . $row2['N_GRUPO'] ?>
                    </td>
                    <td>
                        <?php echo $row2['INSCRITOS'] ?>
                    </td>
                    <td>
                        <?php echo $rowEmision['FECHA_INICIO'] ?>
                    </td>
                    <td>
                        <?php echo $rowEmision['FECHA_FIN'] ?>
                    </td>
                    <td>
                        <?php echo $rowAudPro['FECHA_INICIO'] ?>
                    </td>
                    <td>
                        <?php echo $rowAudPro['FECHA_FIN'] ?>
                    </td>
                    <td>
                        <?php echo $rowPlan['FECHA_INICIO'] ?>
                    </td>
                    <td>
                        <?php echo $rowPlan['FECHA_FIN'] ?>
                    </td>
                    <td>
                        <?php echo $rowCertificacion['FECHA_INICIO'] ?>
                    </td>
                    <td>
                        <?php echo $rowCertificacion['FECHA_FIN'] ?>
                    </td>
                </tr>
                <?php
            }
            oci_close($connection);
            ?>
        </table>
    </body>
</html>