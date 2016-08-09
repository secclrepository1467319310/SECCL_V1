<?php
//insertamos los headers que van a generar el archivo excel
header("Content-type: application/vnd.ms-excel");
//en filename vamos a colocar el nombre con el que el archivo xls sera generado
header("Content-Disposition: attachment; filename=ReporteCurso.xls");
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
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Primer Apellido</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Segundo Apellido</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Nombre</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Email</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Contaseña Registrada</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Fecha Nacimiento</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Lugar Nacimiento</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Fecha Expedición CC</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Lugar Expedición</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Tipo Evaluador</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Fecha Registro Curso</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Con Proyecto?</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Registrado en el STAFF con el documento REAL?</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Registrado en el STAFF con el 1?</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Documento REAL</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>LÍDER ACTIVO? (DOCUMENTO REAL)</strong></th>
                <!--<th style="background-color:#006; text-align:center; color:#FFF"><strong>LÍDER ACTIVO? (DOCUMENTO +1)</strong></th>-->

            </tr>
            <?php
// Un proceso repetitivo para imprimir cada uno de los registros.
            $query2 = "select 
ce.codigo_regional,
r.nombre_regional,
cen.codigo_centro,
cen.nombre_centro,
ce.documento,
ce.priapellido,
ce.segapellido,
ce.nombre,
ce.email,
ce.pass,
ce.fecha_nacimiento,
ce.lugar_nacimiento,
ce.fecha_expedicion,
ce.lugar_expedicion,
ce.tipo_evaluador,
ce.fecha_registro
from curso_ev ce
inner join regional r
on r.codigo_regional=ce.codigo_regional
inner join centro cen
on ce.id_centro=cen.id_centro
";
            $statement2 = oci_parse($connection, $query2);
            oci_execute($statement2);

            $numero = 0;
            while ($row2 = oci_fetch_array($statement2, OCI_BOTH)) {

                //---
                if ($row2["TIPO_EVALUADOR"] == 1) {
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
                $query8 = ("SELECT DOCUMENTO FROM EVALUADOR WHERE DOCUMENTO = '$row2[DOCUMENTO]'");
                $statement8 = oci_parse($connection, $query8);
                $resp8 = oci_execute($statement8);
                $dreal = oci_fetch_array($statement8, OCI_BOTH);
                //----fecha
                $query9 = ("SELECT DOCUMENTO FROM EVALUADOR WHERE DOCUMENTO LIKE CONCAT ($row2[DOCUMENTO], 1)");
                $statement9 = oci_parse($connection, $query9);
                $resp9 = oci_execute($statement9);
                $dfic = oci_fetch_array($statement9, OCI_BOTH);
                //-------------
                $query91 = ("SELECT DOCUMENTO FROM USUARIO WHERE DOCUMENTO = '$row2[DOCUMENTO]' AND ROL_ID_ROL=4 AND ESTADO=1");
                $statement91 = oci_parse($connection, $query91);
                $resp91 = oci_execute($statement91);
                $drealu = oci_fetch_array($statement91, OCI_BOTH);
                //--
//                $query92 = ("SELECT DOCUMENTO FROM EVALUADOR WHERE DOCUMENTO LIKE 'CONCAT ($row2[DOCUMENTO], 1)' AND ROL_ID_ROL=4 AND ESTADO=1");
//                $statement92 = oci_parse($connection, $query92);
//                $resp92 = oci_execute($statement92);
//                $dficu = oci_fetch_array($statement92, OCI_BOTH);
                
                
                
                

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
                utf8_encode($row2["PRIAPELLIDO"]) . "</center></font></td>";
                echo "<td><font face=\"verdana\"><center>" .
                utf8_encode($row2["SEGAPELLIDO"]) . "</center></font></td>";
                echo "<td><font face=\"verdana\"><center>" .
                utf8_encode($row2["NOMBRE"]) . "</center></font></td>";
                echo "<td><a href=\"mailto: $row2[EMAIL]\"><center>" .
                utf8_encode($row2["EMAIL"]) . "</center></a></td>";
                echo "<td><font face=\"verdana\"><center>" .
                $row2["PASS"] . "</center></font></td>";
                echo "<td><font face=\"verdana\"><center>" .
                $row2["FECHA_NACIMIENTO"] . "</center></font></td>";
                echo "<td><font face=\"verdana\"><center>" .
                $row2["LUGAR_NACIMIENTO"] . "</center></font></td>";
                echo "<td><font face=\"verdana\"><center>" .
                $row2["FECHA_EXPEDICION"] . "</center></font></td>";
                echo "<td><font face=\"verdana\"><center>" .
                $row2["LUGAR_EXPEDICION"] . "</center></font></td>";
                echo "<td><font face=\"verdana\"><center>" .
                $te . "</center></font></td>";
                echo "<td><font face=\"verdana\"><center>" .
                $row2["FECHA_REGISTRO"] . "</center></font></td>";
                echo "<td><font face=\"verdana\"><center>" .
                $p . "</center></font></td>";
                if ($dreal[0]<>NULL) {
                    echo "<td><font face=\"verdana\" style=\"color: red\"><center>" .
                Si . "</center></font></td>";
                }else{
                    echo "<td><font face=\"verdana\" style=\"color: #003\"><center>" .
                No . "</center></font></td>";
                }
                if ($dfic[0]<>NULL) {
                    echo "<td><font face=\"verdana\" style=\"color: red\"><center>" .
                Si . "</center></font></td>";
                }else{
                    echo "<td><font face=\"verdana\" style=\"color: #003\"><center>" .
                No . "</center></font></td>";
                }
                echo "<td><font face=\"verdana\"><center>" .
                $row2["DOCUMENTO"] . "</center></font></td>";
                if ($drealu[0]<>NULL) {
                    echo "<td><font face=\"verdana\" style=\"color: red\"><center>" .
                Si . "</center></font></td></tr>";
                }else{
                    echo "<td><font face=\"verdana\" style=\"color: #003\"><center>" .
                No . "</center></font></td></tr>";
                }
//                if ($dficu[0]<>NULL) {
//                    echo "<td><font face=\"verdana\" style=\"color: red\"><center>" .
//                Si . "</center></font></td></tr>";
//                }else{
//                    echo "<td><font face=\"verdana\" style=\"color: #003\"><center>" .
//                No . "</center></font></td></tr>";
//                }
                

                $numero++;
            }

            oci_close($connection);
            ?>
        </table>
    </body>
</html>