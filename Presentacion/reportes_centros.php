<?php
//insertamos los headers que van a generar el archivo excel
header("Content-type: application/vnd.ms-excel");
//en filename vamos a colocar el nombre con el que el archivo xls sera generado
header("Content-Disposition: attachment; filename=Reportes Centros.xls");
header("Pragma: no-cache");
header("Expires: 0");

include("../Clase/conectar.php");
$connection = conectar($bd_host, $bd_usuario, $bd_pwd);
$f = date('d/m/Y');
//realizamos la consulta
?>
<!DOCTYPE html PUBLIC “-//W3C//DTD XHTML 1.0 Transitional//EN” “http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd”>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Reporte Centros</title>
    </head>

    <body>
        <table>
            <tr>
                <th  colspan="14">
                    <!–Imprimimos un titulo –>
                    <div style="color:#003; text-align:center; text-shadow:#666; font-size: 20px">Reporte de Centros - Corte <?php echo $f ?> <br /></div></th>
            </tr>
        </table>
        <br><br>
        <table border="1">
            <tr style="background-color:#006; text-align:center; color:#FFF">

                <th><strong>Codigo Regional</strong></th>
                <th><strong>Regional</strong></th>
                <th><strong>Codigo centro</strong></th>
                <th><strong>Centro</strong></th>
                <th style="width: 50px"><strong>Programaciones Registradas Demanda Social</strong></th>
                <th><strong>Programaciones Registradas Alianza</strong></th>
                <th><strong>Total Programaciones Registradas</strong></th>
                <th><strong>Programaciones Avaladas Demanda Social</strong></th>
                <th><strong>Programaciones Avaladas Alianza</strong></th>
                <th><strong>Total Programaciones Avaladas</strong></th>
                <th><strong>Proyectos Registrados Demanda Social</strong></th>
                <th><strong>Proyectos Registrados Alianza</strong></th>
                <th><strong>Total Proyectos Registrados</strong></th>
                <th><strong>Candidatos Formalizados</strong></th>
                <th><strong>Aspirantes Inscritos</strong></th>


            </tr>
            <?php
            $queryCentros = "SELECT * FROM CENTRO CE "
                    . "INNER JOIN REGIONAL REG "
                    . "ON CE.CODIGO_REGIONAL=REG.CODIGO_REGIONAL "
                    . "WHERE CE.CODIGO_CENTRO != 17076"
                    . "ORDER BY REG.NOMBRE_REGIONAL ASC";
            $statementCentros = oci_parse($connection, $queryCentros);
            oci_execute($statementCentros);
            while ($centros = oci_fetch_array($statementCentros, OCI_BOTH))
            {

                $queryProgramacionesDemanda = "SELECT COUNT(*) AS TOTAL_DEMANDA FROM DETALLES_POA DP 
                                INNER JOIN PLAN_ANUAL PA 
                                ON DP.ID_PLAN = PA.ID_PLAN
                                WHERE DP.NIT_EMPRESA IS NULL
                                AND SUBSTR(DP.FECHA_REGISTRO,7,4) = 2016
                                AND PA.ID_CENTRO = $centros[CODIGO_CENTRO]";
                $statementProgramacionesDemanda = oci_parse($connection, $queryProgramacionesDemanda);
                oci_execute($statementProgramacionesDemanda);
                $programacionesDemanda = oci_fetch_array($statementProgramacionesDemanda, OCI_BOTH);

                $queryProgramacionesAlianza = "SELECT COUNT(*) AS TOTAL_ALIANZA FROM DETALLES_POA DP 
                                INNER JOIN PLAN_ANUAL PA 
                                ON DP.ID_PLAN = PA.ID_PLAN
                                WHERE DP.NIT_EMPRESA IS NOT NULL
                                AND SUBSTR(DP.FECHA_REGISTRO,7,4) = 2016
                                AND PA.ID_CENTRO = $centros[CODIGO_CENTRO]";
                $statementProgramacionesAlianza = oci_parse($connection, $queryProgramacionesAlianza);
                oci_execute($statementProgramacionesAlianza);
                $programacionesAlianza = oci_fetch_array($statementProgramacionesAlianza, OCI_BOTH);

                $queryProgramacionesDemandaFor = "SELECT COUNT(*) AS TOTAL_DEMANDA_FOR FROM DETALLES_POA DP 
                                INNER JOIN PLAN_ANUAL PA 
                                ON DP.ID_PLAN = PA.ID_PLAN
                                WHERE DP.NIT_EMPRESA IS NULL
                                AND SUBSTR(DP.FECHA_REGISTRO,7,4) = 2016
                                AND PA.ID_CENTRO = $centros[CODIGO_CENTRO] AND DP.VALIDACION = 1";
                $statementProgramacionesDemandaFor = oci_parse($connection, $queryProgramacionesDemandaFor);
                oci_execute($statementProgramacionesDemandaFor);
                $programacionesDemandaFor = oci_fetch_array($statementProgramacionesDemandaFor, OCI_BOTH);

                $queryProgramacionesAlianzaFor = "SELECT COUNT(*) AS TOTAL_ALIANZA_FOR FROM DETALLES_POA DP 
                                INNER JOIN PLAN_ANUAL PA 
                                ON DP.ID_PLAN = PA.ID_PLAN
                                WHERE DP.NIT_EMPRESA IS NOT NULL
                                AND SUBSTR(DP.FECHA_REGISTRO,7,4) = 2016
                                AND PA.ID_CENTRO = $centros[CODIGO_CENTRO] AND DP.VALIDACION = 1";
                $statementProgramacionesAlianzaFor = oci_parse($connection, $queryProgramacionesAlianzaFor);
                oci_execute($statementProgramacionesAlianzaFor);
                $programacionesAlianzaFor = oci_fetch_array($statementProgramacionesAlianzaFor, OCI_BOTH);

                $queryProyectosAlianza = "SELECT COUNT(UNIQUE(ID_PROYECTO)) AS PROYECTOS_ALIANZA FROM PROYECTO 
                                WHERE SUBSTR(FECHA_ELABORACION, 7,4) = 2016 AND
                                NIT_EMPRESA IS NOT NULL 
                                AND ID_CENTRO = $centros[CODIGO_CENTRO]";
                $statementProyectosAlianza = oci_parse($connection, $queryProyectosAlianza);
                oci_execute($statementProyectosAlianza);
                $proyectosAlianza = oci_fetch_array($statementProyectosAlianza, OCI_BOTH);

                $queryProyectosDemanda = "SELECT COUNT(UNIQUE(ID_PROYECTO)) AS PROYECTOS_DEMANDA FROM PROYECTO 
                                WHERE SUBSTR(FECHA_ELABORACION, 7,4) = 2016 AND
                                NIT_EMPRESA IS NULL
                                AND ID_CENTRO = $centros[CODIGO_CENTRO]";
                $statementProyectosDemanda = oci_parse($connection, $queryProyectosDemanda);
                oci_execute($statementProyectosDemanda);
                $proyectosDemanda = oci_fetch_array($statementProyectosDemanda, OCI_BOTH);

                $queryCandidatosIns = "SELECT COUNT(*) AS INSCRITOS_FORMALIZADOS FROM INSCRIPCION INS
                                INNER JOIN PROYECTO PY ON INS.ID_PROYECTO = PY.ID_PROYECTO
                                WHERE SUBSTR(PY.FECHA_ELABORACION, 7,4) = 2016
                                AND INS.ESTADO = 1
                                AND PY.ID_CENTRO = $centros[CODIGO_CENTRO]";
                $statementCandidatosIns = oci_parse($connection, $queryCandidatosIns);
                oci_execute($statementCandidatosIns);
                $candidatosIns = oci_fetch_array($statementCandidatosIns, OCI_BOTH);

                $queryCandidatos = "SELECT COUNT(*) AS INSCRITOS FROM CANDIDATOS_PROYECTO INS
                                INNER JOIN PROYECTO PY ON INS.ID_PROYECTO = PY.ID_PROYECTO
                                WHERE SUBSTR(PY.FECHA_ELABORACION, 7,4) = 2016
                                AND PY.ID_CENTRO = $centros[CODIGO_CENTRO]";
                $statementCandidatos = oci_parse($connection, $queryCandidatos);
                oci_execute($statementCandidatos);
                $candidatos = oci_fetch_array($statementCandidatos, OCI_BOTH);

                if ($fondo == '#D9E1F2')
                {
                    $fondo = '#B4C6E7';
                }
                else
                {
                    $fondo = '#D9E1F2';
                }
                ?>
                <tr style="background-color:<?php echo $fondo ?>;">
                    <td><?php echo $centros['CODIGO_REGIONAL'] ?></td>
                    <td><?php echo utf8_encode($centros['NOMBRE_REGIONAL']) ?></td>
                    <td><?php echo $centros['CODIGO_CENTRO'] ?></td>
                    <td><?php echo utf8_encode($centros['NOMBRE_CENTRO']) ?></td>
                    <td style="width: 30px"><?php echo $programacionesDemanda['TOTAL_DEMANDA'] ?></td>
                    <td style="width: 30px"><?php echo $programacionesAlianza['TOTAL_ALIANZA'] ?></td>
                    <td style="width: 30px"><?php echo $programacionesDemanda['TOTAL_DEMANDA'] + $programacionesAlianza['TOTAL_ALIANZA'] ?></td>
                    <td style="width: 30px"><?php echo $programacionesDemandaFor['TOTAL_DEMANDA_FOR'] ?></td>
                    <td style="width: 30px"><?php echo $programacionesAlianzaFor['TOTAL_ALIANZA_FOR'] ?></td>
                    <td style="width: 30px"><?php echo $programacionesDemandaFor['TOTAL_DEMANDA_FOR'] + $programacionesAlianzaFor['TOTAL_ALIANZA_FOR'] ?></td>
                    <td style="width: 30px"><?php echo $proyectosDemanda['PROYECTOS_DEMANDA'] ?></td>
                    <td style="width: 30px"><?php echo $proyectosAlianza['PROYECTOS_ALIANZA'] ?></td>
                    <td style="width: 30px"><?php echo $proyectosDemanda['PROYECTOS_DEMANDA'] + $proyectosAlianza['PROYECTOS_ALIANZA'] ?></td>
                    <td style="width: 30px"><?php echo $candidatosIns['INSCRITOS_FORMALIZADOS'] ?></td>
                    <td style="width: 30px"><?php echo $candidatos['INSCRITOS'] ?></td>
                </tr>

                <?php
            }
            oci_close($connection);
            ?>
        </table>
    </body>
</html>
