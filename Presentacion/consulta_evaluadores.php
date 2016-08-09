<?php
//insertamos los headers que van a generar el archivo excel
header("Content-type: application/vnd.ms-excel");
//en filename vamos a colocar el nombre con el que el archivo xls sera generado
header("Content-Disposition: attachment; filename=ReporteEvaluadoresCurso.xls");
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
        <title>Reporte General de Evaluadores - Curso</title>
    </head>

    <body><!–Vamos a crear una tabla que será impresa en el archivo excel –>
        <table width="600" border="0">
            <tr>
                <th width="600">
                    <!–Imprimimos un titulo –>
                    <div style="color:#003; text-align:center; text-shadow:#666;"><font size="+2">Reporte de Cruce Evaluadores-Curso Corte <?php echo $f ?> <br /></font></div></th>
            </tr>
        </table>
        <!–creamos la tabla de el reporte con border 1 y los títulos–>
        <table width="641" border="1">
            <tr>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>ID Regional</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Nombre Regional</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>ID Centro</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Nombre Centro</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Documento</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Nombre</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>IP</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Celular</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Email</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Email 2</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Certificado Evaluador</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>N° Certificado</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Fecha Certificación</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Activo</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Tipo Evaluador</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Empresa (EXTERNO)</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Fecha de Registro en el Staff</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Registrado en el Curso</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Fecha de Registro en el Curso</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Con Proyectos</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Estado</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Rol Evaluador Externo</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Reales</strong></th>

            </tr>
            <?php
// Un proceso repetitivo para imprimir cada uno de los registros.
            $query2 = "select 
ev.codigo_regional,
r.nombre_regional,
ev.codigo_centro,
ce.nombre_centro,
ev.documento,
ev.nombre,
ev.ip,
ev.celular,
ev.email,
ev.email2,
ev.certificado,
ev.n_certi,
ev.fecha_certifica,
ev.activo,
ev.te,
ev.empresa,
ev.fecha_registro
from evaluador ev
inner join regional r
on r.codigo_regional=ev.codigo_regional
inner join centro ce
on ce.codigo_centro=ev.codigo_centro";
            $statement2 = oci_parse($connection, $query2);
            oci_execute($statement2);

            $numero = 0;
            while ($row2 = oci_fetch_array($statement2, OCI_BOTH)) {

                if ($row2["CERTIFICADO"] == 0) {
                    $c = "No";
                } else {
                    $c = "Si";
                }
                //-----
                if ($row2["ACTIVO"] == 0) {
                    $a = "No";
                } else {
                    $a = "Si";
                }
                //---
                if ($row2["TE"] == 1) {
                    $te = "Interno";
                } else {
                    $te = "Externo";
                }
                //-------
                if ($row2["ESTADO_EVALUADOR"] == 3) {
                    $ev = "Postulado";
                } else {
                    $ev = "Sin Estado";
                }
                //----proyecto
                $query7 = ("select count(*) from evaluador_proyecto where id_evaluador='$row2[DOCUMENTO]'");
                $statement7 = oci_parse($connection, $query7);
                $resp7 = oci_execute($statement7);
                $total = oci_fetch_array($statement7, OCI_BOTH);

                if ($total[0] > 0) {
                    $p = "Si";
                } else {
                    $p = "No";
                }
                //---curso
                $query8 = ("select count(*) from curso_ev where documento='$row2[DOCUMENTO]'");
                $statement8 = oci_parse($connection, $query8);
                $resp8 = oci_execute($statement8);
                $total2 = oci_fetch_array($statement8, OCI_BOTH);
                //----fecha
                $query9 = ("select fecha_registro from curso_ev where documento='$row2[DOCUMENTO]'");
                $statement9 = oci_parse($connection, $query9);
                $resp9 = oci_execute($statement9);
                $fcurso = oci_fetch_array($statement9, OCI_BOTH);

                if ($total2[0] > 0) {
                    $cev = "Si";
                } else {
                    $cev = "No";
                }
                //-----
                $query10 = ("select count(documento) from usuario where documento=CONCAT ($row2[DOCUMENTO], 1)");
                $statement10 = oci_parse($connection, $query10);
                $resp10 = oci_execute($statement10);
                $evex = oci_fetch_array($statement10, OCI_BOTH);
                
                
                $documento = substr($row2[DOCUMENTO], 0, -1);
                $query11 = ("SELECT documento FROM curso_ev cv where cv.documento=$documento");
                $statement11 = oci_parse($connection, $query11);
                $resp11 = oci_execute($statement11);
                $eva11 = oci_fetch_array($statement11, OCI_BOTH);
                
//                if($eva11[0] >0) {
//                    $evalReal = "No";
//                } else {
//                    $evalReal = "Si";
//                }
                
                

                echo "<tr><td><font face=\"verdana\"><center>" .
                $row2["CODIGO_REGIONAL"] . "</center></font></td>";
                echo "<td><font face=\"verdana\"><center>" .
                utf8_encode($row2["NOMBRE_REGIONAL"]) . "</center></font></td>";
                echo "<td><font face=\"verdana\"><center>" .
                $row2["CODIGO_CENTRO"] . "</center></font></td>";
                echo "<td><font face=\"verdana\"><center>" .
                utf8_encode($row2["NOMBRE_CENTRO"]) . "</center></font></td>";
                echo "<td><font face=\"verdana\"><center>" .
                $row2["DOCUMENTO"] . "</center></font></td>";
                echo "<td><font face=\"verdana\"><center>" .
                utf8_encode($row2["NOMBRE"]) . "</center></font></td>";
                echo "<td><font face=\"verdana\"><center>" .
                $row2["IP"] . "</center></font></td>";
                echo "<td><font face=\"verdana\"><center>" .
                $row2["CELULAR"] . "</center></font></td>";
                echo "<td><a href=\"mailto: $row2[EMAIL]\"><center>" .
                utf8_encode($row2["EMAIL"]) . "</center></a></td>";
                echo "<td><font face=\"verdana\"><center>" .
                $row2["EMAIL2"] . "</center></font></td>";
                echo "<td><font face=\"verdana\"><center>" .
                $c . "</center></font></td>";
                echo "<td><font face=\"verdana\"><center>" .
                $row2["N_CERTI"] . "</center></font></td>";
                echo "<td><font face=\"verdana\"><center>" .
                $row2["FECHA_CERTIFICA"] . "</center></font></td>";
                echo "<td><font face=\"verdana\"><center>" .
                $a . "</center></font></td>";
                echo "<td><font face=\"verdana\"><center>" .
                $te . "</center></font></td>";
                echo "<td><font face=\"verdana\"><center>" .
                utf8_encode($row2["EMPRESA"]) . "</center></font></td>";
                echo "<td><font face=\"verdana\"><center>" .
                $row2["FECHA_REGISTRO"] . "</center></font></td>";
                echo "<td><font face=\"verdana\"><center>" .
                $cev . "</center></font></td>";
                echo "<td><font face=\"verdana\"><center>" .
                $fcurso[0] . "</center></font></td>";
                echo "<td><font face=\"verdana\"><center>" .
                $p . "</center></font></td>";
                echo "<td><font face=\"verdana\"><center>" .
                $ev . "</center></font></td>";
                if ($evex[0]==1) {
                    echo "<td><font face=\"verdana\" style=\"color: red\"><center>" .
                Si . "</center></font></td>";
                }else{
                    echo "<td><font face=\"verdana\" style=\"color: #003\"><center>" .
                No . "</center></font></td>";
                }
                 echo "<td><font face=\"verdana\" style=\"color: red\"><center>" .
                $eva11[DOCUMENTO] . "</center></font></td></tr>";
                

                $numero++;
            }

            oci_close($connection);
            ?>
        </table>
    </body>
</html>