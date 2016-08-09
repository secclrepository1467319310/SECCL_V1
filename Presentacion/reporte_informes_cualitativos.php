<?php
//insertamos los headers que van a generar el archivo excel
header("Content-type: application/vnd.ms-excel");
//en filename vamos a colocar el nombre con el que el archivo xls sera generado
header("Content-Disposition: attachment; filename=Reportes Centros.xls");
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
        <title>Reporte Centros</title>
    </head>

    <body>
        <table>
            <tr>
                <th  colspan="14">
                    <!–Imprimimos un titulo –>
                    <div style="color:#003; text-align:center; text-shadow:#666; font-size: 20px">Informe Cualitativos - Proyectos <?php echo $f ?> <br /></div></th>
            </tr>
        </table>
        <br><br>
                <table border="1">
                    <tr style="background-color:#006; text-align:center; color:#FFF">

                        <th><strong>Codigo Regional</strong></th>
                        <th><strong>Regional</strong></th>
                        <th><strong>Codigo centro</strong></th>
                        <th><strong>Centro</strong></th>
                        <th><strong>Proyecto</strong></th>
                        <th><strong>Grupo</strong></th>
                        <th><strong>Nit Empresa</strong></th>
                        <th><strong>Nombre empresa</strong></th>
                        <th><strong>Codigo Mesa</strong></th>
                        <th><strong>Nombre mesa</strong></th>
                        <th><strong>Codigo Norma</strong></th>
                        <th><strong>Titulo Norma</strong></th>
                        <th><strong>Evaluador nombre</strong></th>
                        <th><strong>Evaluador primer apellido</strong></th>
                        <th><strong>Evaluador segundo apellido</strong></th>
                        <th><strong>Fortaleza Conocimiento</strong></th>
                        <th><strong>Fortaleza Desempeño</strong></th>
                        <th><strong>Fortaleza Producto</strong></th>
                        <th><strong>Debilidades Conocimiento</strong></th>
                        <th><strong>Debilidades Desempeño</strong></th>
                        <th><strong>Debilidades Producto</strong></th>
                    </tr>
                    <?php
                    $queryInforme = "SELECT REG.CODIGO_REGIONAL, REG.NOMBRE_REGIONAL, CE.CODIGO_CENTRO, CE.NOMBRE_CENTRO, 
                        PY.ID_PROYECTO, ES.NIT_EMPRESA, ES.NOMBRE_EMPRESA, NM.CODIGO_NORMA, NM.TITULO_NORMA, ME.CODIGO_MESA, ME.NOMBRE_MESA, USU.NOMBRE, 
                        USU.PRIMER_APELLIDO, USU.SEGUNDO_APELLIDO, IC.FORTALEZAS_CONOCIMIENTO, IC.FORTALEZAS_DESEMPENO, 
                        IC.FORTALEZAS_PRODUCTO, IC.DEBILIDADES_CONOCIMIENTO, IC.DEBILIDADES_DESEMPENO, IC.DEBILIDADES_PRODUCTO, PE.GRUPO FROM T_INFORME_CUALITATIVO_PROYECTO IC 
INNER JOIN PLAN_EVIDENCIAS PE ON IC.ID_PLAN_EVIDENCIAS = PE.ID_PLAN
INNER JOIN PROYECTO PY ON PE.ID_PROYECTO = PY.ID_PROYECTO
INNER JOIN NORMA NM ON NM.ID_NORMA = PE.ID_NORMA
INNER JOIN MESA ME ON NM.CODIGO_MESA = ME.CODIGO_MESA
INNER JOIN CENTRO CE ON PY.ID_CENTRO = CE.CODIGO_CENTRO
INNER JOIN REGIONAL REG ON CE.CODIGO_REGIONAL = REG.CODIGO_REGIONAL
INNER JOIN USUARIO USU ON IC.USUARIO_ID = USU.USUARIO_ID
LEFT JOIN EMPRESAS_SISTEMA ES ON PY.NIT_EMPRESA = ES.NIT_EMPRESA";
                    $statementInforme = oci_parse($connection, $queryInforme);
                    oci_execute($statementInforme);
                    $numInforme = oci_fetch_all($statementInforme, $informe);
                    for ($i = 0; $i < $numInforme; $i++)
                    {
                        if ($fondo == '#D9E1F2')
                        {
                            $fondo = '#B4C6E7';
                        }
                        else
                        {
                            $fondo = '#D9E1F2';
                        }
                        
                         if ($informe['NIT_EMPRESA'][$i] != NULL)
                        {
                            $nit_empresa = $informe['NIT_EMPRESA'][$i];
                            $nombre_empresa = $informe['NOMBRE_EMPRESA'][$i];
                        }
                        else
                        {
                            $nit_empresa = 'DEMANDA SOCIAL';
                            $nombre_empresa = 'DEMANDA SOCIAL';
                        }
                        ?>
                        <tr style="background-color:<?php echo $fondo ?>">
                            <td><?php echo $informe['CODIGO_REGIONAL'][$i] ?></td>
                            <td><?php echo utf8_encode($informe['NOMBRE_REGIONAL'][$i]) ?></td>
                            <td><?php echo $informe['CODIGO_CENTRO'][$i] ?></td>
                            <td><?php echo utf8_encode($informe['NOMBRE_CENTRO'][$i]) ?></td>
                            <td><?php echo $informe['ID_PROYECTO'][$i] ?></td>
                            <td><?php echo $informe['GRUPO'][$i] ?></td>
                            <td><?php echo $nit_empresa ?></td>
                            <td><?php echo utf8_encode($nombre_empresa) ?></td>
                            <td><?php echo $informe['CODIGO_MESA'][$i] ?></td>
                            <td><?php echo utf8_encode($informe['NOMBRE_MESA'][$i]) ?></td>
                            <td><?php echo $informe['CODIGO_NORMA'][$i] ?></td>
                            <td><?php echo utf8_encode($informe['TITULO_NORMA'][$i]) ?></td>
                            <td><?php echo $informe['NOMBRE'][$i] ?></td>
                            <td><?php echo $informe['PRIMER_APELLIDO'][$i] ?></td>
                            <td><?php echo $informe['SEGUNDO_APELLIDO'][$i] ?></td>
                            <td><?php echo $informe['FORTALEZAS_CONOCIMIENTO'][$i] ?></td>
                            <td><?php echo $informe['FORTALEZAS_DESEMPENO'][$i] ?></td>
                            <td><?php echo $informe['FORTALEZAS_PRODUCTO'][$i] ?></td>
                            <td><?php echo $informe['DEBILIDADES_CONOCIMIENTO'][$i] ?></td>
                            <td><?php echo $informe['DEBILIDADES_DESEMPENO'][$i] ?></td>
                            <td><?php echo $informe['DEBILIDADES_PRODUCTO'][$i] ?></td>
                        </tr>

                        <?php
                    }
                    oci_close($connection);
                    ?>
                </table>
                </body>
                </html>
