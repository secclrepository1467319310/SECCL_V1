<?php
//insertamos los headers que van a generar el archivo excel
header("Content-type: application/vnd.ms-excel");
//en filename vamos a colocar el nombre con el que el archivo xls sera generado
header("Content-Disposition: attachment; filename=Reportes Mesas.xls");
header("Pragma: no-cache");
header("Expires: 0");

include("../Clase/conectar.php");
$connection = conectar($bd_host, $bd_usuario, $bd_pwd);
$f = date('d/m/Y');
$mesa = $_POST['mesa'];
$tipo_reporte = $_POST['tipo_reporte'];
$query = "SELECT * FROM MESA WHERE CODIGO_MESA = $mesa";
$statement = oci_parse($connection, $query);
oci_execute($statement);
$numMesas = oci_fetch_all($statement, $mesas);
//realizamos la consulta
?>
<!DOCTYPE html PUBLIC “-//W3C//DTD XHTML 1.0 Transitional//EN” “http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd”>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Reporte Mesas</title>
    </head>

    <body>
        <table>
            <tr>
                <th  colspan="14">
                    <!–Imprimimos un titulo –>
                    <div style="color:#003; text-align:center; text-shadow:#666; font-size: 20px">Reporte mesa <?php echo $mesas['CODIGO_MESA'][0] . " - " . utf8_encode($mesas['NOMBRE_MESA'][0]) ?> año 2016 - Corte <?php echo $f ?> <br /></div></th>
            </tr>
        </table>
        <br><br>
                <table border="1">
                    <tr style="background-color:#006; text-align:center; color:#FFF">
                        <th><strong>Código Regional</strong></th>
                        <th><strong>Regional</strong></th>
                        <th><strong>Código Centro</strong></th>
                        <th><strong>Centro</strong></th>
                        <th><strong>Programaciones Registradas Demanda Social</strong></th>
                        <th><strong>Programaciones Registradas Alianza</strong></th>
                        <th><strong>Total Programaciones Registradas</strong></th>
                        <th><strong>Proyectos Registrados Demanda Social</strong></th>
                        <th><strong>Proyectos Registrados Alianza</strong></th>
                        <th><strong>Total Proyectos Registrados</strong></th>
                        <th><strong>Inscritos Proyectos..</strong></th>
                    </tr>
                    <?php
                    $query2 = "SELECT
r.CODIGO_REGIONAL, r.NOMBRE_REGIONAL, ce.CODIGO_CENTRO, ce.NOMBRE_CENTRO
from Centro ce
inner join regional r
on r.codigo_regional=ce.codigo_regional ORDER BY r.NOMBRE_REGIONAL ASC";
                    $statement2 = oci_parse($connection, $query2);
                    oci_execute($statement2);

                    $numero = 0;
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


                        $queryProgramacionesDemanda = "SELECT COUNT(*) AS TOTAL_DEMANDA FROM DETALLES_POA DP 
                                INNER JOIN PLAN_ANUAL PA 
                                ON DP.ID_PLAN = PA.ID_PLAN
                                INNER JOIN NORMA NOR 
                                ON DP.ID_NORMA = NOR.ID_NORMA
                                WHERE DP.NIT_EMPRESA IS NULL
                                AND SUBSTR(DP.FECHA_REGISTRO,7,4) = 2016
                                AND PA.ID_CENTRO = $row2[CODIGO_CENTRO] AND NOR.CODIGO_MESA = " . $mesas['CODIGO_MESA'][0];
                        $statementProgramacionesDemanda = oci_parse($connection, $queryProgramacionesDemanda);
                        oci_execute($statementProgramacionesDemanda);
                        $programacionesDemanda = oci_fetch_array($statementProgramacionesDemanda, OCI_BOTH);

                        $queryProgramacionesAlianza = "SELECT COUNT(*) AS TOTAL_ALIANZA FROM DETALLES_POA DP 
                                INNER JOIN PLAN_ANUAL PA 
                                ON DP.ID_PLAN = PA.ID_PLAN
                                INNER JOIN NORMA NOR 
                                ON DP.ID_NORMA = NOR.ID_NORMA
                                WHERE DP.NIT_EMPRESA IS NOT NULL
                                AND SUBSTR(DP.FECHA_REGISTRO,7,4) = 2016
                                AND PA.ID_CENTRO = $row2[CODIGO_CENTRO] AND NOR.CODIGO_MESA = " . $mesas['CODIGO_MESA'][0];
                        $statementProgramacionesAlianza = oci_parse($connection, $queryProgramacionesAlianza);
                        oci_execute($statementProgramacionesAlianza);
                        $programacionesAlianza = oci_fetch_array($statementProgramacionesAlianza, OCI_BOTH);

                        $queryProyectosAlianza = "SELECT COUNT(UNIQUE(PY.ID_PROYECTO)) AS PROYECTOS_ALIANZA
                                FROM PROYECTO PY
                                INNER JOIN DETALLES_POA DP
                                ON DP.ID_PROVISIONAL = PY.ID_PROVISIONAL
                                INNER JOIN NORMA NOR 
                                ON DP.ID_NORMA = NOR.ID_NORMA
                                WHERE SUBSTR(FECHA_ELABORACION, 7,4) = 2016 AND
                                PY.NIT_EMPRESA IS NOT NULL 
                                AND PY.ID_CENTRO = $row2[CODIGO_CENTRO] AND NOR.CODIGO_MESA = " . $mesas['CODIGO_MESA'][0];
                        $statementProyectosAlianza = oci_parse($connection, $queryProyectosAlianza);
                        oci_execute($statementProyectosAlianza);
                        $proyectosAlianza = oci_fetch_array($statementProyectosAlianza, OCI_BOTH);

                        $queryProyectosDemanda = "SELECT COUNT(UNIQUE(PY.ID_PROYECTO)) AS PROYECTOS_DEMANDA
                                FROM PROYECTO PY
                                INNER JOIN DETALLES_POA DP
                                ON DP.ID_PROVISIONAL = PY.ID_PROVISIONAL
                                INNER JOIN NORMA NOR 
                                ON DP.ID_NORMA = NOR.ID_NORMA
                                WHERE SUBSTR(FECHA_ELABORACION, 7,4) = 2016 AND
                                PY.NIT_EMPRESA IS NULL 
                                AND PY.ID_CENTRO = $row2[CODIGO_CENTRO] AND NOR.CODIGO_MESA = " . $mesas['CODIGO_MESA'][0];
                        $statementProyectosDemanda = oci_parse($connection, $queryProyectosDemanda);
                        oci_execute($statementProyectosDemanda);
                        $proyectosDemanda = oci_fetch_array($statementProyectosDemanda, OCI_BOTH);

                        $queryCandidatos = "SELECT COUNT(*) AS INSCRITOS FROM CANDIDATOS_PROYECTO INS
                                INNER JOIN PROYECTO PY 
                                ON INS.ID_PROYECTO = PY.ID_PROYECTO
                                INNER JOIN NORMA NOR 
                                ON INS.ID_NORMA = NOR.ID_NORMA
                                WHERE SUBSTR(PY.FECHA_ELABORACION, 7,4) = 2016
                                AND PY.ID_CENTRO = $row2[CODIGO_CENTRO] AND NOR.CODIGO_MESA = " . $mesas['CODIGO_MESA'][0];
                        $statementCandidatos = oci_parse($connection, $queryCandidatos);
                        oci_execute($statementCandidatos);
                        $candidatos = oci_fetch_array($statementCandidatos, OCI_BOTH);
                        ?>
                        <tr style="background-color:<?php echo $fondo ?>;">
                            <td><?php echo $row2["CODIGO_REGIONAL"] ?></td>
                            <td><?php echo utf8_encode($row2["NOMBRE_REGIONAL"]) ?></td>
                            <td><?php echo $row2["CODIGO_CENTRO"] ?></td>
                            <td><?php echo utf8_encode($row2["NOMBRE_CENTRO"]) ?></td>
                            <td><?php echo $programacionesDemanda['TOTAL_DEMANDA'] ?></td>
                            <td><?php echo $programacionesAlianza['TOTAL_ALIANZA'] ?></td>
                            <td><?php echo $programacionesDemanda['TOTAL_DEMANDA'] + $programacionesAlianza['TOTAL_ALIANZA'] ?></td>
                            <td><?php echo $proyectosDemanda['PROYECTOS_DEMANDA'] ?></td>
                            <td><?php echo $proyectosAlianza['PROYECTOS_ALIANZA'] ?></td>
                            <td><?php echo $proyectosDemanda['PROYECTOS_DEMANDA'] + $proyectosAlianza['PROYECTOS_ALIANZA'] ?></td>
                            <td style="width: 30px"><?php echo $candidatos['INSCRITOS'] ?></td>
                        </tr>

                        <?php
                    }
                    oci_close($connection);
                    ?>
                </table>
                </body>
                </html>
