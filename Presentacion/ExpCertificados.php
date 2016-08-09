<?php
//insertamos los headers que van a generar el archivo excel
header("Content-type: application/vnd.ms-excel");
//en filename vamos a colocar el nombre con el que el archivo xls sera generado
header("Content-Disposition: attachment; filename=ReporteCertificados.xls");
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
        <title>Reporte Certificados - Proyecto,Norma,Grupo</title>
    </head>

    <body><!–Vamos a crear una tabla que será impresa en el archivo excel –>
        <table width="600" border="0">
            <tr>
                <th width="600">
                    <!–Imprimimos un titulo –>
                    <div style="color:#003; text-align:center; text-shadow:#666;"><font size="+2">Reporte de Certificados Fecha <?php echo $f ?> <br /></font></div></th>
            </tr>
        </table>
        <!–creamos la tabla de el reporte con border 1 y los títulos–>
        <table width="641" border="1">
            <tr>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Radicado Proyecto</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Código Norma</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Grupo</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Documento</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Primer Apellido</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Segundo Apellido</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Nombre</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Estado</strong></th>
            </tr>
            <?php
            $g = $_GET['grupo'];
            $p = $_GET['proyecto'];
            $n = $_GET['norma'];
// Un proceso repetitivo para imprimir cada uno de los registros.
            $query2 = "SELECT UNIQUE
U.USUARIO_ID,
U.PRIMER_APELLIDO,
U.SEGUNDO_APELLIDO,
U.NOMBRE,
U.DOCUMENTO
FROM USUARIO U
INNER JOIN PROYECTO_GRUPO PG
ON PG.ID_CANDIDATO=U.USUARIO_ID
WHERE PG.N_GRUPO='$g' AND
PG.ID_PROYECTO='$p' AND
PG.ID_NORMA='$n' 
ORDER BY U.PRIMER_APELLIDO ASC";
            $statement2 = oci_parse($connection, $query2);
            oci_execute($statement2);

            $numero = 0;
            while ($row2 = oci_fetch_array($statement2, OCI_BOTH)) {

                //*--------------
                $query3 = ("SELECT codigo_norma FROM norma where id_norma='$n'");
                $statement3 = oci_parse($connection, $query3);
                $resp3 = oci_execute($statement3);
                $codno = oci_fetch_array($statement3, OCI_BOTH);
                //--------------
                $query332 = ("select count(*) from certificacion where id_candidato='$row2[USUARIO_ID]' and id_norma='$n' and id_proyecto='$p'");
                $statement332 = oci_parse($connection, $query332);
                $resp332 = oci_execute($statement332);
                $certificado = oci_fetch_array($statement332, OCI_BOTH);
                //---------------
                if ($certificado[0] == 0) {
                    $c = "Sin Certificado Generado";
                } else {
                    $c = "Certificado";
                }

                echo "<tr><td><font face=\"verdana\"><center>" .
                $p . "</center></font></td>";
                echo "<td><font face=\"verdana\"><center>" .
                $codno[0] . "</center></font></td>";
                echo "<td><font face=\"verdana\"><center>" .
                $g . "</center></font></td>";
                echo "<td><font face=\"verdana\"><center>" .
                $row2["DOCUMENTO"] . "</center></font></td>";
                echo "<td><font face=\"verdana\"><center>" .
                utf8_encode($row2["PRIMER_APELLIDO"]) . "</center></font></td>";
                echo "<td><font face=\"verdana\"><center>" .
                utf8_encode($row2["SEGUNDO_APELLIDO"]) . "</center></font></td>";
                echo "<td><font face=\"verdana\"><center>" .
                utf8_encode($row2["NOMBRE"]) . "</center></font></td>";
                echo "<td><font face=\"verdana\"><center>" .
                $c . "</center></font></td></tr>";

                $numero++;
            }

            oci_close($connection);
            ?>
        </table>
    </body>
</html>