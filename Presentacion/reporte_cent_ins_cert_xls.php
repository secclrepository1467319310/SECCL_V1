<?php
//insertamos los headers que van a generar el archivo excel
header("Content-type: application/vnd.ms-excel");
//en filename vamos a colocar el nombre con el que el archivo xls sera generado
header("Content-Disposition: attachment; filename=ReporteCandidatosProyecto.xls");
header("Pragma: no-cache");
header("Expires: 0");

include("../Clase/conectar.php");
$connection = conectar($bd_host, $bd_usuario, $bd_pwd);
extract($_GET);
//realizamos la consulta

$query = "SELECT * FROM REGIONAL "
        . "WHERE CODIGO_REGIONAL = $regional";
$statement = oci_parse($connection, $query);
oci_execute($statement);
$rowRegional = oci_fetch_array($statement, OCI_BOTH);
?>


?>
<!DOCTYPE html PUBLIC “-//W3C//DTD XHTML 1.0 Transitional//EN” “http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd”>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Reporte General de Evaluadores - Curso</title>
    </head>

    <body>
        <table width="600" border="0" border="2">
            <tr>
                <th width="600">
                    <!–Imprimimos un titulo –>
                    <div style="color:#003; text-align:center; text-shadow:#666;"><font size="+2">REPORTE DE PERSONAS INSCRITAS Y CERTIFICADAS POR CENTROS DE LA REGIONAL <?php echo utf8_encode($rowRegional['NOMBRE_REGIONAL']) ?></font></div></th>
            </tr>
        </table>
        <table width="641" border="1">
            <tr>
                <th style="background-color:#006; text-align:center; color:#FFF">Código de Centro</th>
                <th style="background-color:#006; text-align:center; color:#FFF">Nombre Centro</th>
                <th style="background-color:#006; text-align:center; color:#FFF">Numero Inscritos</th>
                <th style="background-color:#006; text-align:center; color:#FFF">Numero Certificados</th>
                <th style="background-color:#006; text-align:center; color:#FFF">Meta Certificados 2015</th>
            </tr>
            <?php
            //Consulta de los centros asociados a una regional en especifico
            $query = "SELECT CENTRO.NOMBRE_CENTRO, CENTRO.CODIGO_CENTRO, CENTRO.ID_CENTRO, "
                    . "REGIONAL.NOMBRE_REGIONAL FROM REGIONAL "
                    . "INNER JOIN CENTRO ON REGIONAL.CODIGO_REGIONAL = CENTRO.CODIGO_REGIONAL "
                    . "WHERE REGIONAL.CODIGO_REGIONAL = $regional ORDER BY REGIONAL.NOMBRE_REGIONAL ASC";
            $statement = oci_parse($connection, $query);
            $resp = oci_execute($statement);

            while ($centros = oci_fetch_array($statement, OCI_BOTH)) {
                /* Consulta para contar el numero de personas 
                  certificadas en los proyectos de un centro */
                $queryCandidatosCertificados = ("SELECT COUNT(*) AS CERTIFICADOS FROM CE_FIRMA_CERTIFICADOS "
                        . "WHERE CENTRO_ID_CENTRO = $centros[CODIGO_CENTRO] || '00'");
                $statementCandidatosCertificados = oci_parse($connection, $queryCandidatosCertificados);
                oci_execute($statementCandidatosCertificados);
                $certificados = oci_fetch_array($statementCandidatosCertificados, OCI_BOTH);

                $queryCandidatosCertificadosGC = ("SELECT NUMERO_CERTIFICACIONES FROM T_CERTIFICACIONES_2014 "
                        . "WHERE CODIGO_CENTRO = $centros[CODIGO_CENTRO]");
                $statementCandidatosCertificadosGC = oci_parse($connection, $queryCandidatosCertificadosGC);
                oci_execute($statementCandidatosCertificadosGC);
                $candidatosCertificadosGC = oci_fetch_array($statementCandidatosCertificadosGC, OCI_BOTH);
                $candidatosCertificados = $certificados['CERTIFICADOS'] + $candidatosCertificadosGC['NUMERO_CERTIFICACIONES'];


                /* Consulta para contar el numero de personas 
                  inscritas en los proyectos de un centro */
                $queryCandidatosInscritos = "SELECT COUNT(*) AS INSCRITOS FROM PROYECTO PY "
                        . "INNER JOIN INSCRIPCION INS ON PY.ID_PROYECTO = INS.ID_PROYECTO "
                        . "WHERE PY.ID_CENTRO = $centros[CODIGO_CENTRO]";

                $statementCandidatosInscritos = oci_parse($connection, $queryCandidatosInscritos);
                oci_execute($statementCandidatosInscritos);
                $candidatosInscritos = oci_fetch_array($statementCandidatosInscritos, OCI_BOTH);

                $queryMetaCentro = "SELECT META_CERTIFICADOS FROM INDICADORES "
                        . "WHERE CODIGO_CENTRO = $centros[CODIGO_CENTRO]";

                $statementMetaCentro = oci_parse($connection, $queryMetaCentro);
                oci_execute($statementMetaCentro);
                $metaCentro = oci_fetch_array($statementMetaCentro, OCI_BOTH);
                ?>
                <tr>
                    <td><?php echo $centros['CODIGO_CENTRO'] ?></td>
                    <td><?php echo utf8_encode($centros['NOMBRE_CENTRO']) ?></td>
                    <td><?php echo $candidatosInscritos['INSCRITOS'] ?></td>
                    <td><?php echo $candidatosCertificados ?></td>
                    <td><?php echo $metaCentro['META_CERTIFICADOS'] ?></td>
                </tr>
                <?php
            }
            oci_close($connection);
            ?>
        </table>
    </body>
</html>