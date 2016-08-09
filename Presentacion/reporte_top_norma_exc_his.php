<?php
//insertamos los headers que van a generar el archivo excel
header("Content-type: application/vnd.ms-excel");
//en filename vamos a colocar el nombre con el que el archivo xls sera generado
header("Content-Disposition: attachment; filename=Reportes Top Normas Mesa.xls");
header("Pragma: no-cache");
header("Expires: 0");

include("../Clase/conectar.php");
$connection = conectar($bd_host, $bd_usuario, $bd_pwd);
$f = date('d/m/Y');
$periodoActual = date('Y');
$mesa = $_POST['mesa'];
$periodo = $_POST['periodo'];
$top = $_POST['top'];
$tipo_reporte = $_POST['tipo_reporte'];
$query = "SELECT * FROM MESA WHERE CODIGO_MESA = $mesa";
$statement = oci_parse($connection, $query);
oci_execute($statement);
$numMesas = oci_fetch_all($statement, $mesas);
//realizamos la consulta
?>
<!DOCTYPE html PUBLIC “-//W3C//DTD XHTML 1.0 Transitional//EN” “http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd”>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Reporte Mesas</title>
    </head>

    <body>
        <br>
        <table>
            <tr>
                <th  colspan="11">
                    <!–Imprimimos un titulo –>
                    <div style="color:#003; text-align:center; text-shadow:#666; font-size: 20px">REPORTE TOP <?php echo $top ?>  NORMAS DE LA MESA <?php echo utf8_encode($mesas['NOMBRE_MESA'][0]) . "(" . $mesas['CODIGO_MESA'][0] ?>) - Desde <?php echo $periodo ?> Hasta <?php echo $periodoActual ?> <br> Corte <?php echo $f ?> <br /></div></th>
            </tr>
        </table>
        <br>
                <?php
                while ($periodo <= $periodoActual)
                {
                    ?>


                    <?php
//                    $queryHis = "SELECT  count(*) CERTIFICADOS,
//count(unique NRO_IDENT) NUMERO_PERSONAS,
//trim(FECHA_CERTIFICACION) AS FECHA_CERTIFICACION,
//trim(CODIGO_MESA) AS CODIGO_MESA,
//trim(NOMBRE_MESA) AS NOMBRE_MESA,
//trim(regexp_replace(UPPER(PROGRAMA),'NIVEL AVANZADO - |NIVEL INTERMEDIO - |NIVEL BASICO - ','')) AS NOMBRE_NORMA, 
//trim(CLCODIGO) AS CODIGO_NORMA
//FROM CE_ENERO  
//WHERE  TITULO_OBTENIDO = 'NC' AND FECHA_CERTIFICACION <> ' ' AND FECHA_CERTIFICACION = $periodo AND CODIGO_MESA = " . $mesas['CODIGO_MESA'][0] . "  
//GROUP BY trim(FECHA_CERTIFICACION),trim(CODIGO_MESA),trim(NOMBRE_MESA),trim(regexp_replace(UPPER(PROGRAMA),'NIVEL AVANZADO - |NIVEL INTERMEDIO - |NIVEL BASICO - ','')), 
//trim(CLCODIGO)
//ORDER BY CERTIFICADOS DESC";
                    
                    $queryHis = "SELECT to_char(fecha_registro,'yyyy') AS PERIODO, CENTRO_REGIONAL_ID_REGIONAL AS CODIGO_REGIONAL, NOMBREREGIONAL AS REGIONAL, CENTRO_ID_CENTRO AS CODIGO_CENTRO, NOMBRECENTRO AS CENTRO, CODIGOOCUPACION AS CODIGO_MESA, NOMBREOCUPACION AS NOMBRE_MESA, SALIDA_CODIGO AS CODIGO_NORMA, NOMBRESALIDA AS NOMBRE_NORMA, COUNT(*) AS CERTIFICACIONES, COUNT(DISTINCT NROIDENT) AS PERSONAS_CERTIFICADAS 
FROM T_HISTORICO
WHERE CODIGOOCUPACION = {$mesas['CODIGO_MESA'][0]} AND to_char(fecha_registro,'yyyy') = $periodo AND TIPO_CERTIFICADO = 'NC' AND TIPO_ESTADO = 'CERTIFICA'
GROUP BY to_char(fecha_registro,'yyyy'), CENTRO_REGIONAL_ID_REGIONAL, NOMBREREGIONAL, CENTRO_ID_CENTRO, NOMBRECENTRO, CODIGOOCUPACION, NOMBREOCUPACION, SALIDA_CODIGO, NOMBRESALIDA
ORDER BY CERTIFICACIONES DESC";
                    
                    $statementHis = oci_parse($connection, $queryHis);
                    oci_execute($statementHis);
                    $numHis = oci_fetch_all($statementHis, $rowHis);
                    if ($numHis > 0)
                    {
                        ?>
                        <table border="1">
                            <tr style="background-color:#006; text-align:center; color:#FFF">
                                <th colspan="7">TOP NORMAS AÑO <?php echo $periodo ?> MESA <?php echo utf8_encode($mesas['NOMBRE_MESA'][0]) . "(" . $mesas['CODIGO_MESA'][0] ?>)</th>
                            </tr>
                            <tr style="background-color:#006; text-align:center; color:#FFF">
                                <th><strong>Periodo</strong></th>
                                <th><strong>Codigo Mesa</strong></th>
                                <th><strong>Nombre Mesa</strong></th>
                                <th><strong>Codigo Norma</strong></th>
                                <th><strong>Nombre Norma</strong></th>
                                <th><strong>Cerificaciones</strong></th>
                                <th><strong>Personas Certificadas</strong></th>

                            </tr>

                            <?php
                            if ($numHis >= $top)
                            {
                                $numMax = $top;
                            }
                            else
                            {
                                $numMax = $numHis;
                            }
                            for ($i = 0; $i < $numMax; $i++)
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
                                    <td><?php echo $rowHis["PERIODO"][$i] ?></td>
                                    <td><?php echo $rowHis["CODIGO_MESA"][$i] ?></td>
                                    <td><?php echo utf8_encode($rowHis["NOMBRE_MESA"][$i]) ?></td>
                                    <td><?php echo $rowHis["CODIGO_NORMA"][$i] ?></td>
                                    <td><?php echo utf8_encode($rowHis["NOMBRE_NORMA"][$i]) ?></td>
                                    <td><?php echo $rowHis["CERTIFICACIONES"][$i] ?></td>
                                    <td><?php echo $rowHis["PERSONAS_CERTIFICADAS"][$i] ?></td>
                                </tr>

                                <?php
                            }
                            ?>
                        </table>
                    <?php } ?>
                    <br><br>
                            <?php
                            $periodo++;
                        }
                        oci_close($connection);
                        ?>
                        </body>
                        </html>
