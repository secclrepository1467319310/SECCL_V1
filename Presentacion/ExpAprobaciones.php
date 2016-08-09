<?php
//insertamos los headers que van a generar el archivo excel
header("Content-type: application/vnd.ms-excel");
//en filename vamos a colocar el nombre con el que el archivo xls sera generado
header("Content-Disposition: attachment; filename=ExpAprobaciones-".date('d/m/Y').".xls");
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
        <title>Reporte Aprobaciones de asesores a las programaciones</title>
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
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>ID_DETALLES</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>EMPRESA</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>CODIGO_REGIONAL</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>NOMBRE_REGIONAL</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>CODIGO_CENTRO</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>NOMBRE_CENTRO</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>VALIDADO ASESOR</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>OBSERVACION ASESOR</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>FECHA REGISTRO</strong></th>                
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>HORA REGISTRO</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>ASESOR</strong></th>
                
            </tr>
            <?php
            $query2="SELECT 
                DP.ID_DETA AS \"ID_DETALLES\",
                CASE 
                    WHEN DP.NIT_EMPRESA IS NULL THEN 'DEMANDA SOCIAL'
                    ELSE ES.NOMBRE_EMPRESA
                END AS \"EMPRESA\",
                R.CODIGO_REGIONAL,
                R.NOMBRE_REGIONAL,
                C.CODIGO_CENTRO,
                C.NOMBRE_CENTRO,
                CASE 
                        WHEN VALIDACION = 0 THEN 'NO'
                        WHEN VALIDACION = 1 THEN 'SI'
                        ELSE 'Pendiente'
                END AS \"VALIDADO ASESOR\",
                DP.CONCEPTO_ASESOR AS \"OBSERVACION ASESOR\",
                TO_DATE(DP.FECHA_REGISTRO,'DD/MM/YYYY HH12:MI:SS AM') AS \"FECHA REGISTRO\",
                TO_CHAR(TO_DATE(DP.FECHA_REGISTRO,'DD/MM/YYYY HH12:MI:SS AM'),'HH12:MI:SS AM') AS \"HORA REGISTRO\",
                U.NOMBRE ||' '|| U.PRIMER_APELLIDO ||' '|| U.SEGUNDO_APELLIDO AS \"ASESOR\"

                FROM DETALLES_POA DP
                    JOIN PLAN_ANUAL PA
                    ON(DP.ID_PLAN=PA.ID_PLAN)
                    JOIN CENTRO C 
                    ON(C.CODIGO_CENTRO=PA.ID_CENTRO)
                    JOIN REGIONAL R 
                    ON(PA.ID_REGIONAL=R.CODIGO_REGIONAL)
                    LEFT JOIN EMPRESAS_SISTEMA ES
                    ON(DP.NIT_EMPRESA=ES.NIT_EMPRESA)
                    LEFT JOIN USUARIO U
                    ON(DP.ID_ASESOR=U.USUARIO_ID)
                WHERE EXTRACT(YEAR FROM TO_DATE(DP.FECHA_REGISTRO,'DD/MM/YYYY HH12:MI:SS AM')) = '2016'
                ";
            $statement2 = oci_parse($connection, $query2);
            oci_execute($statement2);

            
            while ($row2 = oci_fetch_array($statement2, OCI_BOTH)) {
                echo "<tr><td><font face=\"verdana\"><center>" .
                $row2["ID_DETALLES"] . "</center></font></td>";
                echo "<td><font face=\"verdana\"><center>" .
                $row2["EMPRESA"] . "</center></font></td>";
                echo "<td><font face=\"verdana\"><center>" .
                $row2["CODIGO_REGIONAL"] . "</center></font></td>";
                echo "<td><font face=\"verdana\"><center>" .
                $row2["NOMBRE_REGIONAL"] . "</center></font></td>";
                echo "<td><font face=\"verdana\"><center>" .
                utf8_encode($row2["CODIGO_CENTRO"] ). "</center></font></td>";
                echo "<td><font face=\"verdana\"><center>" .
                $row2["NOMBRE_CENTRO"] . "</center></font></td>";
                echo "<td><font face=\"verdana\"><center>" .
                $row2["VALIDADO ASESOR"] . "</center></font></td>";
                echo "<td><font face=\"verdana\"><center>" .
                $row2["OBSERVACION ASESOR"] . "</center></font></td>";
                echo "<td><font face=\"verdana\"><center>" .
                $row2["FECHA REGISTRO"] . "</center></font></td>";
                echo "<td><font face=\"verdana\"><center>" .
                $row2["HORA REGISTRO"] . "</center></font></td>";                
                echo "<td><font face=\"verdana\"><center>" .
                utf8_encode($row2["ASESOR"]) . "</center></font></td></tr>";                
            }
            oci_close($connection);
            ?>
        </table>
    </body>
</html>