<?php
$f = date('Y-m-d');
//insertamos los headers que van a generar el archivo excel
header("Content-type: application/vnd.ms-excel");
//en filename vamos a colocar el nombre con el que el archivo xls sera generado
header("Content-Disposition: attachment; filename=Areas_Claves_Centros_$f.xls");
header("Pragma: no-cache");
header("Expires: 0");

include("../Clase/conectar.php");
$connection = conectar($bd_host, $bd_usuario, $bd_pwd);
?>
<!DOCTYPE html PUBLIC “-//W3C//DTD XHTML 1.0 Transitional//EN” “http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd”>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Reporte Areas Claves Por Centros Año 2016</title>
    </head>

    <body><!–Vamos a crear una tabla que será impresa en el archivo excel –>
        <table width="600" border="0">
            <tr>
                <th width="600" colspan="6" style="font-size: 20px">
                    <!–Imprimimos un titulo –>
                    <div style="color:#003; text-align:center; text-shadow:#666;">
                        Reporte Areas Claves Por Centros Año 2016 <br> Corte <?php echo $f ?> 
                    </div>
                </th>
            </tr>
        </table>
        <br/><br/>
        <table width="641" border="1">
            <tr style="background-color:#006; text-align:center; color:#FFF">
                <th><strong>Código Regional</strong></th>
                <th><strong>Nombre Regional</strong></th>
                <th><strong>Código Centro</strong></th>
                <th><strong>Nombre Centro</strong></th>
                <th><strong>Código Mesa</strong></th>
                <th><strong>Nombre Mesa</strong></th>
            </tr>
            <?php
            $query2 = "SELECT REG.CODIGO_REGIONAL, REG.NOMBRE_REGIONAL, CEN.CODIGO_CENTRO, CEN.NOMBRE_CENTRO, ME.CODIGO_MESA, ME.NOMBRE_MESA FROM AREAS_CLAVES_CENTRO ACC "
                    . "INNER JOIN AREAS_CLAVES AC ON ACC.ID_AREA_CLAVE = AC.ID_AREA_CLAVE "
                    . "INNER JOIN CENTRO CEN ON AC.CODIGO_CENTRO = CEN.CODIGO_CENTRO "
                    . "INNER JOIN REGIONAL REG ON CEN.CODIGO_REGIONAL=REG.CODIGO_REGIONAL "
                    . "INNER JOIN MESA ME ON ACC.ID_MESA=ME.CODIGO_MESA "
                    . "WHERE ACC.APROBADO_ASESOR = 1 AND ACC.PERIODO=2016 AND CEN.CODIGO_CENTRO != 17076"
                    . "ORDER BY REG.NOMBRE_REGIONAL ASC,  CEN.NOMBRE_CENTRO ASC";
            $statement2 = oci_parse($connection, $query2);
            oci_execute($statement2);
            $fondo = '#D9E1F2';
            while ($row2 = oci_fetch_array($statement2, OCI_BOTH))
            {
                if ($fondo == '#D9E1F2')
                {
                    $fondo = '#B4C6E7';
                }
                else
                {
                    $fondo = '#D9E1F2';
                }
                ?>
                <tr style="background-color:<?php echo $fondo ?>;">
                    <td>
                        <?php echo $row2['CODIGO_REGIONAL'] ?>
                    </td>
                    <td>
                        <?php echo utf8_encode($row2['NOMBRE_REGIONAL']) ?>
                    </td>
                    <td>
                        <?php echo $row2['CODIGO_CENTRO'] ?>
                    </td>
                    <td>
                        <?php echo utf8_encode($row2['NOMBRE_CENTRO']) ?>
                    </td>
                    <td>
                        <?php echo $row2['CODIGO_MESA'] ?>
                    </td>
                    <td>
                        <?php echo utf8_encode($row2['NOMBRE_MESA']) ?>
                    </td>
                </tr>
                <?php
            }

            oci_close($connection);
            ?>
        </table>
    </body>
</html>