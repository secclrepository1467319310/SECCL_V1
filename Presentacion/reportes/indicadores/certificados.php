<?php
$f = date('d/m/Y H:i');
$fe = date('d/m/Y');
$h = date('H');
$m = date('i');

header("Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment; filename=Reporte Certificados REG-CEN-MES-NOR (Corte $fe H$h M$m).xls");
header("Pragma: no-cache");
header("Expires: 0");

include("../../../Clase/conectar.php");
$connection = conectar($bd_host, $bd_usuario, $bd_pwd);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Reporte Certificados REG-CEN-MES-NOR - Corte <?php echo $f ?></title>
        <style type="text/css">
            body {
                font: 15px calibri; 
            }
            th {
                color: #FFFFFF;
                text-align: center;
                background-color: #5882FA;
                padding: 0px 10px;
            }
            .titulo {
                font-size: 24px; 
                font-style: bold; 
            }

            .trRegistros {
                background-color: #A9D0F5;
            }
        </style>
    </head>
    <body>
        <table id="tblTotal">
            <tr>
                <th colspan="14" class="titulo">
                    Reporte Certificados REG-CEN-MES-NOR - Corte <?php echo $f ?>
                </th>
            </tr>
            <tr>
                <th>
                    <strong>Código Regional</strong>
                </th>
                <th>
                    <strong>Nombre Regional</strong>
                </th>
                <th>
                    <strong>Código Centro</strong>
                </th>
                <th>
                    <strong>Nombre Centro</strong>
                </th>
                <th>
                    <strong>Código Mesa</strong>
                </th>
                <th>
                    <strong>Nombre Mesa</strong>
                </th>
                <th>
                    <strong>Código Norma</strong>
                </th>
                <th>
                    <strong>Versión Norma</strong>
                </th>
                <th>
                    <strong>Nombre Norma</strong>
                </th>
                <th>
                    <strong>Certificaciones Realizadas</strong>
                </th>
                <th>
                    <strong>Personas Certificadas</strong>
                </th>
            </tr>
            <?php
//            echo '<hr/> Regionales: <hr/>' .
            $sqlReg = 'SELECT '
                    . ' REG.CODIGO_REGIONAL, '
                    . ' INITCAP(REG.NOMBRE_REGIONAL) AS NOMBRE_REGIONAL '
                    . 'FROM REGIONAL REG '
                    . 'ORDER BY '
                    . ' REG.NOMBRE_REGIONAL ASC';
            $objReg = oci_parse($connection, $sqlReg);
            oci_execute($objReg);
//            echo '  // Numero Registros: ' .
            $numRowsReg = oci_fetch_all($objReg, $rowReg);

//            echo '<pre>';
//            var_dump($rowReg);
//            echo '</pre>';

            $registros = 0;
            for ($r = 0; $r < $numRowsReg; $r++)
            {
//                echo '<hr/> Centros de la Regional ' . $rowReg['CODIGO_REGIONAL'][$r] . ': <hr/>' .
                $sqlCen = 'SELECT '
                        . ' CEN.CODIGO_CENTRO, '
                        . ' INITCAP(CEN.NOMBRE_CENTRO) AS NOMBRE_CENTRO '
                        . 'FROM CENTRO CEN '
                        . "WHERE CEN.CODIGO_REGIONAL = {$rowReg['CODIGO_REGIONAL'][$r]} "
                        . ' AND CEN.CODIGO_CENTRO != 17076 '
                        . 'ORDER BY '
                        . ' CEN.CODIGO_CENTRO ASC';
                $objCen = oci_parse($connection, $sqlCen);
                oci_execute($objCen);
//                echo '  // Numero Registros: ' .
                $numRowsCen = oci_fetch_all($objCen, $rowCen);

//                echo '<pre>';
//                var_dump($rowCen);
//                echo '</pre>';

                for ($c = 0; $c < $numRowsCen; $c++)
                {
//                            echo '<hr/> Certificaciones en la norma ' . $rowNor['CODIGO_NORMA'][$n] . ': <hr/>' .
                    $sqlCer = 'SELECT '
                            . '	CODIGOOCUPACION AS CODIGO_MESA, '
                            . '	NOMBREOCUPACION AS NOMBRE_MESA, '
                            . '	SALIDA_CODIGO AS CODIGO_NORMA, '
                            . '	SALIDA_VERSION AS VERSION_NORMA, '
                            . '	NOMBRESALIDA AS NOMBRE_NORMA, '
                            . '	COUNT(*) AS CERTIFICACIONES_EXPEDIDAS, '
                            . '	COUNT(DISTINCT NROIDENT) AS PERSONAS_CERTIFICADAS '
                            . 'FROM T_HISTORICO '
                            . "WHERE TIPO_CERTIFICADO = 'NC' "
                            . "	AND TIPO_ESTADO = 'CERTIFICA' "
                            . "	AND TO_CHAR(FECHA_REGISTRO, 'yyyy') = '2016' "
                            . "	AND SUBSTR(CENTRO_ID_CENTRO,0,4) = {$rowCen['CODIGO_CENTRO'][$c]} "
                            . 'GROUP BY '
                            . '	CODIGOOCUPACION, '
                            . '	NOMBREOCUPACION, '
                            . '	SALIDA_CODIGO, '
                            . '	SALIDA_VERSION, '
                            . '	NOMBRESALIDA';
                    $objCer = oci_parse($connection, $sqlCer);
                    oci_execute($objCer);
//                            echo '  // Numero Registros: ' .
                    $numRowsCer = oci_fetch_all($objCer, $rowCer);

//                            echo '<pre>';
//                            var_dump($rowCer);
//                            echo '</pre>'; 

                    for ($ce = 0; $ce < $numRowsCer; $ce++)
                    {
                        $classRegistros = ($registros % 2 == 0) ? 'class="trRegistros"' : '';
                        $registros++;
                        ?>
                        <tr>
                            <td <?php echo $classRegistros; ?>>
                                <?php echo $rowReg['CODIGO_REGIONAL'][$r]; ?>
                            </td>
                            <td <?php echo $classRegistros; ?>>
                                <?php echo utf8_encode($rowReg['NOMBRE_REGIONAL'][$r]); ?>
                            </td>
                            <td <?php echo $classRegistros; ?>>
                                <?php echo $rowCen['CODIGO_CENTRO'][$c]; ?>
                            </td>
                            <td <?php echo $classRegistros; ?>>
                                <?php echo utf8_encode($rowCen['NOMBRE_CENTRO'][$c]); ?>
                            </td>
                            <td <?php echo $classRegistros; ?>>
                                <?php echo $rowCer['CODIGO_MESA'][$ce]; ?>
                            </td>
                            <td <?php echo $classRegistros; ?>>
                                <?php echo utf8_encode($rowCer['NOMBRE_MESA'][$ce]); ?>
                            </td>
                            <td <?php echo $classRegistros; ?>>
                                <?php echo $rowCer['CODIGO_NORMA'][$ce]; ?>
                            </td>
                            <td <?php echo $classRegistros; ?>>
                                <?php echo $rowCer['VERSION_NORMA'][$ce]; ?>
                            </td>
                            <td <?php echo $classRegistros; ?>>
                                <?php echo utf8_encode($rowCer['NOMBRE_NORMA'][$ce]); ?>
                            </td>
                            <td <?php echo $classRegistros; ?>>
                                <?php echo $rowCer['CERTIFICACIONES_EXPEDIDAS'][$ce]; ?>
                            </td>
                            <td <?php echo $classRegistros; ?>>
                                <?php echo $rowCer['PERSONAS_CERTIFICADAS'][$ce]; ?>
                            </td>
                        </tr>
                        <?php
                        if ($rowCen['CODIGO_CENTRO'][$c] == 9540 && $ce == $numRowsCer-1)
                        {
//							echo '<hr/> Inscripciones NCCER: <hr/>' .
                            $sqlNCCERCer = 'SELECT '
                                    . '	COUNT(DOCUMENTO) AS TOTAL_CERTIFICADOS, '
                                    . '	COUNT(DISTINCT DOCUMENTO) AS PERSONAS_CERTIFICADAS '
                                    . 'FROM T_NCCER '
                                    . "WHERE CERTIFICADO = 'SI' AND  EXTRACT (YEAR FROM FECHA_CORTE)='2016' ";
                            $objNCCERCer = oci_parse($connection, $sqlNCCERCer);
                            oci_execute($objNCCERCer);
//							echo '  // Numero Registros: ' .
                            $numRegistrosNCCERCer = oci_fetch_all($objNCCERCer, $datosNCCERCer);

//							echo '<pre>';
//							var_dump($datosNCCERCer);
//							echo '</pre>';
                            ?>
                            <tr>
                                <td <?php echo $classRegistros; ?>>
                                    <?php echo $rowReg['CODIGO_REGIONAL'][$r]; ?>
                                </td>
                                <td <?php echo $classRegistros; ?>>
                                    <?php echo utf8_encode($rowReg['NOMBRE_REGIONAL'][$r]); ?>
                                </td>
                                <td <?php echo $classRegistros; ?>>
                                    <?php echo $rowCen['CODIGO_CENTRO'][$c]; ?>
                                </td>
                                <td <?php echo $classRegistros; ?>>
                                    <?php echo utf8_encode($rowCen['NOMBRE_CENTRO'][$c]); ?>
                                </td>
                                <td <?php echo $classRegistros; ?>>
                                    <?php echo utf8_encode('NCCER'); ?>
                                </td>
                                <td <?php echo $classRegistros; ?>>
                                    <?php echo utf8_encode('NCCER'); ?>
                                </td>
                                <td <?php echo $classRegistros; ?>>
                                    <?php echo utf8_encode('NCCER'); ?>
                                </td>
                                <td <?php echo $classRegistros; ?>>
                                    <?php echo utf8_encode('NCCER'); ?>
                                </td>
                                <td <?php echo $classRegistros; ?>>
                                    <?php echo utf8_encode('NCCER'); ?>
                                </td>
                                <td <?php echo $classRegistros; ?>>
                                    <?php echo $datosNCCERCer['TOTAL_CERTIFICADOS'][0]; ?>
                                </td>
                                <td <?php echo $classRegistros; ?>>
                                    <?php echo $datosNCCERCer['PERSONAS_CERTIFICADAS'][0]; ?>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                }
            }
            ?>
        </table>
    </body>
</html>