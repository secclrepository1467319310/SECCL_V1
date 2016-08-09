<?php
//insertamos los headers que van a generar el archivo excel
header("Content-type: application/vnd.ms-excel");
//en filename vamos a colocar el nombre con el que el archivo xls sera generado
header("Content-Disposition: attachment; filename=ReporteCandidatosProyecto.xls");
header("Pragma: no-cache");
header("Expires: 0");

include("../Clase/conectar.php");
$connection = conectar($bd_host, $bd_usuario, $bd_pwd);
$f = date('d/m/Y');
$proyecto = $_GET['proyecto']
//realizamos la consulta
?>
<!DOCTYPE html PUBLIC “-//W3C//DTD XHTML 1.0 Transitional//EN” “http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd”>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Reporte General de Evaluadores - Curso</title>
    </head>

    <body><!–Vamos a crear una tabla que será impresa en el archivo excel –>
        <table width="600" border="0" border="2">
            <tr>
                <th width="600">
                    <!–Imprimimos un titulo –>
                    <div style="color:#003; text-align:center; text-shadow:#666;"><font size="+2">Reporte Candidatos Proyecto <?php echo $proyecto ?> <br /> <?php echo date('d/m/Y') ?></font></div></th>
            </tr>
        </table>
        <!–creamos la tabla de el reporte con border 1 y los títulos–>
        <table width="641" border="1">
            <tr>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>DOCUMENTO</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>NOMBRE</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>PRIMER APELLIDO</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>SEGUNDO APELLIDO</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>CODIGO NORMA</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>TITULO NORMA</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>INSCRIPCIÓN FORMALIZADA</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>EMISIÓN DE JUICIO</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>CONOCIMIENTO</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>DESEMPEÑO</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>PRODUCTO</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>NIVEL</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>CERTIFICADO</strong></th>
            </tr>
            <?php
            $queryCandidatosProyecto = ("SELECT USR.USUARIO_ID,USR.NOMBRE,USR.PRIMER_APELLIDO,USR.SEGUNDO_APELLIDO,USR.DOCUMENTO, NR.CODIGO_NORMA, NR.TITULO_NORMA, NR.ID_NORMA
                                FROM PROYECTO PRY
                                INNER JOIN CANDIDATOS_PROYECTO CNP ON PRY.ID_PROYECTO = CNP.ID_PROYECTO
                                INNER JOIN NORMA NR ON CNP.ID_NORMA = NR.ID_NORMA
                                INNER JOIN USUARIO USR ON USR.USUARIO_ID = CNP.ID_CANDIDATO
                                WHERE PRY.ID_PROYECTO = $proyecto ORDER BY NR.CODIGO_NORMA");
            $statementCandidatosProyecto = oci_parse($connection, $queryCandidatosProyecto);
            oci_execute($statementCandidatosProyecto);
            $color = '#DDEBF7';
            while ($candidatosProyecto = oci_fetch_array($statementCandidatosProyecto, OCI_BOTH)) {

                $queryInscrito = ("SELECT count(*) AS INSCRITO FROM INSCRIPCION "
                        . "WHERE CHEK_APOYO = 1 AND CHEK_EVALUADOR = 1 "
                        . "AND CHEK_LIDER = 1 AND ID_CANDIDATO = $candidatosProyecto[USUARIO_ID]"
                        . "AND ID_NORMA = $candidatosProyecto[ID_NORMA] AND ID_PROYECTO = $proyecto");
                $statementInscrito = oci_parse($connection, $queryInscrito);
                oci_execute($statementInscrito);
                $candidatosInscrito = oci_fetch_array($statementInscrito, OCI_BOTH);
                if ($candidatosInscrito['INSCRITO'] == 1) {
                    $inscrito = 'SI';
                } else {
                    $inscrito = 'NO';
                }
                
                $queryInscrito2 = ("SELECT count(*) AS CERTIFICADO FROM CERTIFICACION "
                        . "WHERE ID_CANDIDATO= $candidatosProyecto[USUARIO_ID]"
                        . "AND ID_NORMA = $candidatosProyecto[ID_NORMA] AND ID_PROYECTO = $proyecto");
                $statementInscrito2 = oci_parse($connection, $queryInscrito2);
                oci_execute($statementInscrito2);
                $candidatosInscrito2 = oci_fetch_array($statementInscrito2, OCI_BOTH);
                if ($candidatosInscrito2['CERTIFICADO'] == 1) {
                    $certificado = 'SI';
                } else {
                    $certificado = 'NO';
                }

                $queryEvidencias = ("SELECT EC.EC, EC.OPEC, EC.ED, EC.OPED, EC.EP, EC.OPEP, EC.ESTADO "
                        . "FROM PLAN_EVIDENCIAS PE "
                        . "INNER JOIN EVIDENCIAS_CANDIDATO EC ON PE.ID_PLAN = EC.ID_PLAN "
                        . "WHERE EC.ID_CANDIDATO = $candidatosProyecto[USUARIO_ID] "
                        . "AND EC.ID_NORMA = $candidatosProyecto[ID_NORMA] "
                        . "AND PE.ID_PROYECTO = $proyecto");
                $statementEvidencias = oci_parse($connection, $queryEvidencias);
                oci_execute($statementEvidencias);
                $candidatosEvidencia = oci_fetch_array($statementEvidencias, OCI_BOTH);
                $conocimiento = $candidatosEvidencia['EC'] + $candidatosEvidencia['OPEC'];
                $desempeno = $candidatosEvidencia['ED'] + $candidatosEvidencia['OPED'];
                $producto = $candidatosEvidencia['EP'] + $candidatosEvidencia['OPEP'];
                if ($candidatosEvidencia['ESTADO'] == 0 || !$candidatosEvidencia['ESTADO'] || $candidatosEvidencia['ESTADO'] == NULL) {
                    $estado = 'NO';
                } else {
                    $estado = 'SI';
                }
                
                

                if ($candidatosEvidencia['ESTADO'] == 1) {
                    $nivelCertificacion = 'Nivel Avanzado';
                } else if ($candidatosEvidencia['ESTADO'] == 2) {
                    $nivelCertificacion = 'Aun no competente';
                } else if ($candidatosEvidencia['ESTADO'] == 3) {
                    $nivelCertificacion = 'Nivel Intermedio';
                } else if ($candidatosEvidencia['ESTADO'] == 4) {
                    $nivelCertificacion = 'Nivel Básico';
                }else{
                    $nivelCertificacion = '';
                }

                if ($color == '#BDD7EE') {
                    $color = '#DDEBF7';
                } else {
                    $color = '#BDD7EE';
                }
                #BDD7EE
                ?>
                <tr style="background: <?php echo $color ?>">
                    <td><?php echo $candidatosProyecto['DOCUMENTO'] ?></td>
                    <td><?php echo utf8_encode($candidatosProyecto['NOMBRE']) ?></td>
                    <td><?php echo utf8_encode($candidatosProyecto['PRIMER_APELLIDO']) ?></td>
                    <td><?php echo utf8_encode($candidatosProyecto['SEGUNDO_APELLIDO']) ?></td>
                    <td><?php echo $candidatosProyecto['CODIGO_NORMA'] ?></td>
                    <td><?php echo utf8_encode($candidatosProyecto['TITULO_NORMA']) ?></td>
                    <td><?php echo $inscrito ?></td>
                    <td><?php echo $estado ?></td>
                    <td>
                        <?php
                        if ($estado == 'SI') {
                            echo $conocimiento;
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        if ($estado == 'SI') {
                            echo $desempeno;
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        if ($estado == 'SI') {
                            echo $producto;
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        echo $nivelCertificacion;
                        ?>
                    </td>
                    <td><?php echo $certificado ?></td>
                </tr>
                <?php
            }
            ?>

        </table>
        <?php
        oci_close($connection);
        ?>
        </table>
    </body>
</html>