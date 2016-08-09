<?php
//insertamos los headers que van a generar el archivo excel
header("Content-type: application/vnd.ms-excel");
//en filename vamos a colocar el nombre con el que el archivo xls sera generado
header("Content-Disposition: attachment; filename=ReporteObservacionesAsesores-".date('d/m/Y').".xls");
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
        <title>Reporte observaciones a proyectos hechos desde los asesores</title>
    </head>

    <body><!–Vamos a crear una tabla que será impresa en el archivo excel –>
        <table width="600" border="0">
            <tr>
                <th width="600">
                    <!–Imprimimos un titulo –>
                    <div style="color:#003; text-align:center; text-shadow:#666;"><font size="+2">Reporte de Observaciones hechos por asesores para la fecha <?php echo $f ?> <br /></font></div></th>
            </tr>
        </table>
        <!–creamos la tabla de el reporte con border 1 y los títulos–>
        <table width="641" border="1">
            <tr>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>ID_PROYECTO</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>EMPRESA</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>CODIGO_REGIONAL</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>NOMBRE_REGIONAL</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>CODIGO_CENTRO</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>NOMBRE_CENTRO</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>OBSERVACION</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>FECHA_REGISTRO</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>HORA_REGISTRO</strong></th>                
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>USUARIO REGISTRO</strong></th>
                
            </tr>
            <?php
            $query2="SELECT "
                    . "P.ID_PROYECTO, "
                    ."CASE "
                        . "WHEN P.NIT_EMPRESA IS NULL THEN 'DEMANDA SOCIAL' "
                        . "WHEN P.NIT_EMPRESA IS NOT NULL THEN  ES.NOMBRE_EMPRESA  "
                    . "END AS \"EMPRESA\","
                    . "R.CODIGO_REGIONAL, "
                    . "R.NOMBRE_REGIONAL, "
                    . "C.CODIGO_CENTRO, "
                    . "C.NOMBRE_CENTRO, "
                    . "TOPA.DESCRIPCION AS \"OBSERVACION\", "
                    . "TOPA.FECHA_REGISTRO, "
                    . "TOPA.HORA_REGISTRO, "
                    . "U.NOMBRE ||' '||U.PRIMER_APELLIDO ||' '|| U.SEGUNDO_APELLIDO AS \"USUARIO REGISTRO\" "
                . "FROM T_OBSER_PROY_ASES TOPA "
                    . "JOIN PROYECTO P "
                    . "ON (TOPA.ID_PROYECTO=P.ID_PROYECTO) "
                    . "JOIN CENTRO C "
                    . "ON (C.CODIGO_CENTRO=P.ID_CENTRO) "
                    . "JOIN REGIONAL R "
                    . "ON (C.CODIGO_REGIONAL= R.CODIGO_REGIONAL) "
                    . "JOIN USUARIO U "
                    . "ON (TOPA.USU_REGISTRO=U.USUARIO_ID) "
                    . "LEFT JOIN EMPRESAS_SISTEMA ES "
                    . "ON (ES.NIT_EMPRESA=P.NIT_EMPRESA)"
                    . "WHERE  SUBSTR(P.FECHA_ELABORACION,7,4)='2016'"
                    . "ORDER BY ID_OBSER_PROY_ASES ASC";
            $statement2 = oci_parse($connection, $query2);
            oci_execute($statement2);

            
            while ($row2 = oci_fetch_array($statement2, OCI_BOTH)) {
                echo "<tr><td><font face=\"verdana\"><center>" .
                $row2["ID_PROYECTO"] . "</center></font></td>";
                echo "<td><font face=\"verdana\"><center>" .
                $row2["EMPRESA"] . "</center></font></td>";
                echo "<td><font face=\"verdana\"><center>" .
                $row2["CODIGO_REGIONAL"] . "</center></font></td>";
                echo "<td><font face=\"verdana\"><center>" .
                $row2["NOMBRE_REGIONAL"] . "</center></font></td>";
                echo "<td><font face=\"verdana\"><center>" .
                $row2["CODIGO_CENTRO"] . "</center></font></td>";
                echo "<td><font face=\"verdana\"><center>" .
                $row2["NOMBRE_CENTRO"] . "</center></font></td>";
                echo "<td><font face=\"verdana\"><center>" .
                $row2["OBSERVACION"] . "</center></font></td>";
                echo "<td><font face=\"verdana\"><center>" .
                $row2["FECHA_REGISTRO"] . "</center></font></td>";
                echo "<td><font face=\"verdana\"><center>" .
                $row2["HORA_REGISTRO"] . "</center></font></td>";
                echo "<td><font face=\"verdana\"><center>" .
                utf8_encode($row2["USUARIO REGISTRO"]) . "</center></font></td></tr>";                
            }
            oci_close($connection);
            ?>
        </table>
    </body>
</html>