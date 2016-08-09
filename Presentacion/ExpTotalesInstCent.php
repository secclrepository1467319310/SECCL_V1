<?php
//insertamos los headers que van a generar el archivo excel
header("Content-type: application/vnd.ms-excel");
//en filename vamos a colocar el nombre con el que el archivo xls sera generado
header("Content-Disposition: attachment; filename=ReporteTotalInstCent.xls");
header("Pragma: no-cache");
header("Expires: 0");

include("../Clase/conectar.php");
$connection = conectar($bd_host, $bd_usuario, $bd_pwd);
$f = date('d/m/Y');
//realizamos la consulta
if($_GET[fechainicial]=="" ||$_GET[fechafinal]=="" ){
    $where="";
}else{
    $where="WHERE ob.fecha_solicitud BETWEEN '".$_GET[fechainicial]."' AND '".$_GET[fechafinal]."' ";
}
?>
<!DOCTYPE html PUBLIC “-//W3C//DTD XHTML 1.0 Transitional//EN” “http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd”>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Reporte General de Centro - Instrumentos - Totales</title>
    </head>

    <body><!–Vamos a crear una tabla que será impresa en el archivo excel –>
        <table width="600" border="0">
            <tr>
                <th width="600">
                    <!–Imprimimos un titulo –>
                    <div style="color:#003; text-align:center; text-shadow:#666;"><font size="+2">Reporte de Centro - Instrumentos - Totales Corte <?php echo $f ?>. Entre <?=$_GET[fechainicial]?>-<?=$_GET[fechafinal]?>  <br /></font></div></th>
            </tr>
        </table>
        <!–creamos la tabla de el reporte con border 1 y los títulos–>
        <table width="641" border="1">
            <tr>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>N°</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Código Regional</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Regional</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Código Centro</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Centro</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Código Mesa</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Mesa</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Código Norma</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Versión Norma</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Título Norma</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>Instrumento</strong></th>
                <th style="background-color:#006; text-align:center; color:#FFF"><strong>TOTAL</strong></th>
            </tr>
            <?php
// Un proceso repetitivo para imprimir cada uno de los registros.
            $query2 = "select 
p.id_regional CODIGO_REGIONAL,
r.nombre_regional NOMBRE_REGIONAL,
p.id_centro CODIGO_CENTRO,
ce.nombre_centro NOMBRE_CENTRO,
m.codigo_mesa CODIGO_MESA,
m.nombre_mesa NOMBRE_MESA,
n.codigo_norma CODIGO_NORMA,
n.version_norma VERSION_NORMA,
n.titulo_norma TITULO_NORMA,
ob.respuesta INSTRUMENTO,
COUNT (*) TOTAL
from obs_banco ob
inner join proyecto p
on p.id_proyecto=ob.id_proyecto
inner join regional r
on r.codigo_regional=p.id_regional
inner join centro ce
on ce.codigo_centro=p.id_centro
inner join norma n
on n.id_norma=ob.id_norma
inner join mesa m
on m.codigo_mesa=SUBSTR( n.codigo_norma, 2, 5 )
 $where 
group by 
p.id_regional,
r.nombre_regional ,
p.id_centro ,
ce.nombre_centro ,
m.codigo_mesa,
m.nombre_mesa,
n.codigo_norma,
n.version_norma,
n.titulo_norma,
ob.respuesta 
ORDER BY r.nombre_regional,ce.nombre_centro ASC";
            $statement2 = oci_parse($connection, $query2);
            oci_execute($statement2);

            $numero = 0;
            while ($row2 = oci_fetch_array($statement2, OCI_BOTH)) {
                
               
                $s=$numero+1;
                 
                echo "<tr><td><font face=\"verdana\"><center>" .
                $s . "</center></font></td>";
                echo "<td><font face=\"verdana\"><center>" .
                $row2["CODIGO_REGIONAL"] . "</center></font></td>";
                echo "<td><font face=\"verdana\"><center>" .
                utf8_encode($row2["NOMBRE_REGIONAL"]) . "</center></font></td>";
                echo "<td><font face=\"verdana\"><center>" .
                $row2["CODIGO_CENTRO"] . "</center></font></td>";
                echo "<td><font face=\"verdana\"><center>" .
                utf8_encode($row2["NOMBRE_CENTRO"]) . "</center></font></td>";
                echo "<td><font face=\"verdana\"><center>" .
                $row2["CODIGO_MESA"] . "</center></font></td>";
                echo "<td><font face=\"verdana\"><center>" .
                utf8_encode($row2["NOMBRE_MESA"]) . "</center></font></td>";
                echo "<td><font face=\"verdana\"><center>" .
                $row2["CODIGO_NORMA"] . "</center></font></td>";
                echo "<td><font face=\"verdana\"><center>" .
                $row2["VERSION_NORMA"] . "</center></font></td>";
                echo "<td><font face=\"verdana\"><center>" .
                utf8_encode($row2["TITULO_NORMA"]) . "</center></font></td>";
                echo "<td><font face=\"verdana\"><center>" .
                $row2["INSTRUMENTO"] . "</center></font></td>";
                echo "<td><font face=\"verdana\"><center>" .
                $row2["TOTAL"] . "</center></font></td></tr>";
                
                
                $numero++;
            }

            oci_close($connection);
            ?>
        </table>
    </body>
</html>