<?php
//insertamos los headers que van a generar el archivo excel
header("Content-type: application/vnd.ms-excel");
//en filename vamos a colocar el nombre con el que el archivo xls sera generado
header("Content-Disposition: attachment; filename=indicadores.xls");
header("Pragma: no-cache");
header("Expires: 0");

include("../Clase/conectar.php");
$connection = conectar($bd_host, $bd_usuario, $bd_pwd);
$f = date('d/m/Y');
//realizamos la consulta
?>
<!DOCTYPE html PUBLIC “-//W3C//DTD XHTML 1.0 Transitional//EN�? “http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd�?>
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
                    <div style="color:#003; text-align:center; text-shadow:#666; font-size: 20px">Indicadores 2016 - Corte <?php echo $f ?> <br /></div></th>
            </tr>
        </table>
        <br><br>
                <table border="1">
                    <tr style="background-color:#006; text-align:center; color:#FFF">
                        <th><strong>Código Regional</strong></th>
                        <th><strong>Regional</strong></th>
                        <th><strong>Código Centro</strong></th>
                        <th><strong>Centro</strong></th>
                        <th><strong>Meta Número de Evaluaciones </strong></th>
                        <th><strong>Total Evaluaciones </strong></th>
                        <th><strong>Meta Personas certificadas </strong></th>
                        <th><strong>Total Personas Evaluadas</strong></th>
                        <th><strong>Total Personas Certificadas</strong></th>
                        <th><strong>Total Certificados Generados</strong></th>
                        <th><strong>Meta personas certificadas Colocados APE</strong></th>
                        <!--<th><strong>(%) de Cumplimiento</strong></th>-->
                    </tr>
                    <?php
                    $query2 = "SELECT
                    r.CODIGO_REGIONAL, r.NOMBRE_REGIONAL, ce.CODIGO_CENTRO, ce.NOMBRE_CENTRO, i.META_CERTIFICADOS, i.META_PERSONAS,i.CONDICION_LABORAL_APE
                    from indicadores i
                    inner join Centro ce
                    on ce.codigo_centro=i.codigo_centro
                    inner join regional r
                    on r.codigo_regional=ce.codigo_regional 
                    WHERE I.ANYO ='2016'
                    ORDER BY r.NOMBRE_REGIONAL ASC";
                    $statement2 = oci_parse($connection, $query2);
                    oci_execute($statement2);

                    $numero = 0;
                    $metaNE = 0;
                    $tEva = 0;
                    $metaPEva = 0;
                    $tPEva = 0;
                    $tPCer = 0;
                    $tCerGen = 0;
                    $metaColocados = 0;
                    while ($row2 = oci_fetch_array($statement2, OCI_BOTH)) {

                        if ($fondo == '#D9E1F2') {
                            $fondo = '#B4C6E7';
                        } else {
                            $fondo = '#D9E1F2';
                        }

//                        $queryCandidatosCertificados = ("SELECT COUNT(*) AS CERTIFICADOS, COUNT(UNIQUE(NRO_IDENT)) AS PERSONAS FROM CE_FIRMA_CERTIFICADOS WHERE CENTRO_ID_CENTRO = "
//                                . " $row2[CODIGO_CENTRO]00 AND PERIODO = 2015 ");
                        $queryCandidatosCertificados = ("SELECT COUNT(*) AS CERTIFICACIONES, COUNT(DISTINCT NROIDENT) AS PERSONAS_CERTIFICADAS FROM T_HISTORICO HIS
                                WHERE HIS.CENTRO_ID_CENTRO = $row2[CODIGO_CENTRO]||'00' AND to_char(HIS.fecha_registro,'yyyy') = 2016 AND TIPO_CERTIFICADO = 'NC' AND TIPO_ESTADO = 'CERTIFICA'");
                        $statementCandidatosCertificados = oci_parse($connection, $queryCandidatosCertificados);
                        oci_execute($statementCandidatosCertificados);
                        $certificados = oci_fetch_array($statementCandidatosCertificados, OCI_BOTH);


                        $queryPersonasEvaluadas = ("SELECT COUNT(UNIQUE(EC.ID_CANDIDATO)) AS PERSONAS_EVALUADAS, COUNT(*) EVALUACIONES FROM PROYECTO PY 
                                INNER JOIN PLAN_EVIDENCIAS PE ON PE.ID_PROYECTO = PY.ID_PROYECTO
                                INNER JOIN EVIDENCIAS_CANDIDATO EC ON  PE.ID_PLAN = EC.ID_PLAN 
                            WHERE PY.ID_CENTRO = $row2[CODIGO_CENTRO] AND EC.ESTADO != 0 AND SUBSTR(EC.FECHA_REGISTRO, 7,2) = 16 AND SUBSTR(PY.FECHA_ELABORACION, 7,4) = 2016");
                        $statementPersonasEvaluadas = oci_parse($connection, $queryPersonasEvaluadas);
                        oci_execute($statementPersonasEvaluadas);
                        $candidatosPersonasEvaluadas = oci_fetch_array($statementPersonasEvaluadas, OCI_BOTH);

//                        $porcentajeEvaluaciones = ($candidatosPersonasEvaluadas['EVALUACIONES'] / $row2["META_CERTIFICADOS"]) * 100;
//                        $porcentajePersonasEvaluadas = ($candidatosPersonasEvaluadas['PERSONAS_EVALUADAS'] / $row2["META_PERSONAS"]) * 100;

                        if ($row2['CODIGO_CENTRO'] == 9540) {
                            $query3 = " SELECT 
                                            COUNT(*) AS TOTAL_EVALUADOS, 
                                            COUNT(DISTINCT DOCUMENTO) AS PERSONAS_EVALUADAS 
                                        FROM T_NCCER
                                        WHERE EVALUADO = 'SI' AND  EXTRACT (YEAR FROM FECHA_CORTE)='2016' ";
                            $objquery3 = oci_parse($connection, $query3);
                            oci_execute($objquery3);
                            $numregistros3 = oci_fetch_all($objquery3, $datos3);

                            $query4 = " SELECT 
                                            COUNT(*) AS TOTAL_CERTIFICADOS, 
                                            COUNT(DISTINCT DOCUMENTO) AS PERSONAS_CERTIFICADAS 
                                        FROM T_NCCER
                                        WHERE CERTIFICADO = 'SI' AND  EXTRACT (YEAR FROM FECHA_CORTE)='2016' ";
                            $objquery4 = oci_parse($connection, $query4);
                            oci_execute($objquery4);
                            $numregistros4 = oci_fetch_all($objquery4, $datos4);
                        } else {
                            $datos3['TOTAL_EVALUADOS'][0] = 0;
                            $datos4['TOTAL_CERTIFICADOS'][0] = 0;
                            $datos3['PERSONAS_EVALUADAS'][0] = 0;
                            $datos4['PERSONAS_CERTIFICADAS'][0] = 0;
                        }
                        ?>
                        <tr style="background-color:<?php echo $fondo ?>;">
                            <td><?php echo $row2["CODIGO_REGIONAL"] ?></td>
                            <td><?php echo utf8_encode($row2["NOMBRE_REGIONAL"]) ?></td>
                            <td><?php echo $row2["CODIGO_CENTRO"] ?></td>
                            <td><?php echo utf8_encode($row2["NOMBRE_CENTRO"]) ?></td>
                            <td style="width: 30px"><?php echo $row2["META_CERTIFICADOS"] ?></td>
                            <td style="width: 30px"><?php echo ($candidatosPersonasEvaluadas['EVALUACIONES'] + $datos3['TOTAL_EVALUADOS'][0]) ?></td>
                            <!--<td style="width: 30px"><?php // echo  number_format($porcentajeEvaluaciones)   ?></td>-->
                            <td style="width: 30px"><?php echo $row2["META_PERSONAS"] ?></td>
                            <td style="width: 30px"><?php echo ($candidatosPersonasEvaluadas['PERSONAS_EVALUADAS'] + $datos3['PERSONAS_EVALUADAS'][0]) ?></td>
                            <td style="width: 30px"><?php echo ($certificados['PERSONAS_CERTIFICADAS'] + $datos4['PERSONAS_CERTIFICADAS'][0]) ?></td>
                            <td style="width: 30px"><?php echo ($certificados['CERTIFICACIONES'] + $datos4['TOTAL_CERTIFICADOS'][0]) ?></td>
                            <td style="width: 30px"><?php echo $row2["CONDICION_LABORAL_APE"] ?></td>
                            <!--<td style="width: 30px"><?php //  number_format(echo  number_format($porcentajePersonasEvaluadas)   ?></td>-->
                        </tr>


    <?php
    $metaNE+=$row2["META_CERTIFICADOS"];
    $tEva+=($candidatosPersonasEvaluadas['EVALUACIONES'] + $datos3['TOTAL_EVALUADOS'][0]);
    $metaPEva+=$row2["META_PERSONAS"];
    $tPEva+=($candidatosPersonasEvaluadas['PERSONAS_EVALUADAS'] + $datos3['PERSONAS_EVALUADAS'][0]);
    $tPCer+=($certificados['PERSONAS_CERTIFICADAS'] + $datos4['PERSONAS_CERTIFICADAS'][0]);
    $tCerGen +=($certificados['CERTIFICACIONES'] + $datos4['TOTAL_CERTIFICADOS'][0]);
    $metaColocados+=$row2["CONDICION_LABORAL_APE"];
}
oci_close($connection);
?>
                    <tr>
                        <td colspan="4"><center><b> TOTAL GENERAL</b></center></td>
                        <td><b><?= $metaNE ?></b></td>
                        <td><b><?= $tEva ?></b></td>
                        <td><b><?= $metaPEva ?></b></td>
                        <td><b><?= $tPEva ?></b></td>
                        <td><b><?= $tPCer ?></b ></td>
                        <td><b><?= $tCerGen ?></b></td>
                        <td><b><?= $metaColocados ?></b></td>

                    </tr>
                </table>
                </body>
                </html>
