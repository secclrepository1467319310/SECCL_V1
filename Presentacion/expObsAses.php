<?php
//insertamos los headers que van a generar el archivo excel
header("Content-type: application/vnd.ms-excel");
//en filename vamos a colocar el nombre con el que el archivo xls sera generado
header("Content-Disposition: attachment; filename=ProyectosValidados.xls");
header("Pragma: no-cache");
header("Expires: 0");

include("../Clase/conectar.php");
$connection2 = conectar($bd_host, $bd_usuario, $bd_pwd);
$f = date('d/m/Y');
//realizamos la consulta
?>
<!DOCTYPE html PUBLIC “-//W3C//DTD XHTML 1.0 Transitional//EN” “http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd”>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Reporte de Proyectos Validados</title>
    </head>

    <body><!–Vamos a crear una tabla que será impresa en el archivo excel –>
        <table width="600" border="0">
            <tr>
                <th width="600">
                    <!–Imprimimos un titulo –>
                    <div style="color:#003; text-align:center; text-shadow:#666;"><font size="+2">Reporte de Proyectos Validados - Validada Corte <?php echo $f ?> <br /></font></div></th>
            </tr>
        </table>
        <!–creamos la tabla de el reporte con border 1 y los títulos–>
        <table width="641" border="1">


            <tr>
                <th style="background-color:#006; text-align:center; color:#FFF">CODIGO CENTRO</th>
                <th style="background-color:#006; text-align:center; color:#FFF">CENTRO</th>
                <th style="background-color:#006; text-align:center; color:#FFF">CODIGO REGIONAL</th>
                <th style="background-color:#006; text-align:center; color:#FFF">REGIONAL</th>
                <th style="background-color:#006; text-align:center; color:#FFF">ID PROYECTO</th>
                <th style="background-color:#006; text-align:center; color:#FFF">EMPRESA</th>
                <th style="background-color:#006; text-align:center; color:#FFF">DESCRIPCION</th>
                <th style="background-color:#006; text-align:center; color:#FFF">FECHA REGISTRO</th>
                <th style="background-color:#006; text-align:center; color:#FFF">ASESOR</th>
            </tr>

            <?php
            $query2 = "SELECT CE.CODIGO_CENTRO,CE.NOMBRE_CENTRO,REG.CODIGO_REGIONAL,REG.NOMBRE_REGIONAL,ES.NIT_EMPRESA, ES.NOMBRE_EMPRESA, OP.ID_PROYECTO, OP.DESCRIPCION, OP.FECHA_REGISTRO, USU.NOMBRE AS NOMBRE "
                    . "FROM T_OBSER_PROY_ASES OP INNER JOIN USUARIO USU "
                    . "ON OP.USU_REGISTRO = USU.USUARIO_ID "
                    . "INNER JOIN PROYECTO PY "
                    . "ON PY.ID_PROYECTO = OP.ID_PROYECTO "
                    . "INNER JOIN CENTRO CE "
                    . "ON PY.ID_CENTRO = CE.CODIGO_CENTRO "
                    . "INNER JOIN REGIONAL REG "
                    . "ON CE.CODIGO_REGIONAL = REG.CODIGO_REGIONAL "
                    . "LEFT JOIN EMPRESAS_SISTEMA ES "
                    . "ON ES.NIT_EMPRESA = PY.NIT_EMPRESA";
            $statement2 = oci_parse($connection2, $query2);
            oci_execute($statement2);
            $num = 0;
            while ($row2 = oci_fetch_array($statement2, OCI_BOTH)) {
                ?>
                <tr>
                    <td><?php echo $row2['CODIGO_CENTRO'] ?></td>
                    <td><?php echo utf8_encode($row2['NOMBRE_CENTRO']) ?></td>
                    <td><?php echo $row2['CODIGO_REGIONAL'] ?></td>
                    <td><?php echo utf8_encode($row2['NOMBRE_REGIONAL']) ?></td>
                    <td><?php echo $row2['ID_PROYECTO'] ?></td>
                    <td>
                        <?php
                        if ($row2['NIT_EMPRESA'] != NULL) {
                            echo utf8_encode($row2['NOMBRE_EMPRESA']);
                        } else {
                            echo 'Demanda Social';
                        }
                        ?>
                    </td>
                    <td><?php echo $row2['DESCRIPCION'] ?></td>
                    <td><?php echo $row2['FECHA_REGISTRO'] ?></td>
                    <td><?php echo $row2['NOMBRE'] ?></td>
                </tr>
                <?php
            }
            ?>
        </table>
        <?php
        oci_close($connection2);
        ?>
    </body>
</html>
