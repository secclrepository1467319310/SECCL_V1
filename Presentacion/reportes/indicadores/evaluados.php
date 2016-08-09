<?php
$f = date('d/m/Y H:i');
$fe = date('d/m/Y');
$h = date('H');
$m = date('i');

header("Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment; filename=Reporte Evaluados REG-CEN-MES-NOR (Corte $fe H$h M$m).xls");
header("Pragma: no-cache");
header("Expires: 0");

include("../../../Clase/conectar.php");
$connection = conectar($bd_host, $bd_usuario, $bd_pwd);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Reporte Evaluados REG-CEN-MES-NOR - Corte <?php echo $f ?></title>
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
                    Reporte Evaluados REG-CEN-MES-NOR - Corte <?php echo $f ?>
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
                    <strong>Evaluaciones Realizadas</strong>
                </th>
                <th>
                    <strong>Personas Evaluadas</strong>
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
//                            echo '<hr/> Candidatos Inscritos a la norma ' . $rowNor['CODIGO_NORMA'][$n] . ': <hr/>' .
                    $sqlEva = 'SELECT '
                            . '	MES.CODIGO_MESA, '
                            . ' MES.NOMBRE_MESA, '
                            . '	NOR.CODIGO_NORMA, '
                            . ' NOR.VERSION_NORMA, '
                            . ' NOR.TITULO_NORMA, '
                            . ' COUNT(*) AS EVALUACIONES_REALIZADAS, '
                            . ' COUNT(DISTINCT EVA.ID_CANDIDATO) AS PERSONAS_EVALUADAS '
                            . 'FROM PLAN_EVIDENCIAS PLE '
                            . 'INNER JOIN EVIDENCIAS_CANDIDATO EVA '
                            . ' ON  EVA.ID_PLAN  = PLE.ID_PLAN '
                            . 'INNER JOIN PROYECTO PRO '
                            . ' ON PRO.ID_PROYECTO = PLE.ID_PROYECTO '
                            . 'INNER JOIN NORMA NOR '
                            . '	ON NOR.ID_NORMA = EVA.ID_NORMA '
                            . 'INNER JOIN MESA MES '
                            . ' ON MES.CODIGO_MESA = NOR.CODIGO_MESA '
                            . 'WHERE EVA.ESTADO != 0 '
                            . " AND SUBSTR(EVA.FECHA_REGISTRO, 7,2) = '16' "
                            . " AND PRO.ID_CENTRO = {$rowCen['CODIGO_CENTRO'][$c]}"
                            . 'GROUP BY '
                            . ' MES.CODIGO_MESA, '
                            . ' MES.NOMBRE_MESA, '
                            . ' NOR.CODIGO_NORMA, '
                            . ' NOR.VERSION_NORMA, '
                            . ' NOR.TITULO_NORMA';
                    $objEva = oci_parse($connection, $sqlEva);
                    oci_execute($objEva);
//                            echo '  // Numero Registros: ' .
                    $numRowsEva = oci_fetch_all($objEva, $rowEva);

//                            echo '<pre>';
//                            var_dump($rowEva);
//                            echo '</pre>';

                    for ($e = 0; $e < $numRowsEva; $e++)
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
                                <?php echo $rowEva['CODIGO_MESA'][$e]; ?>
                            </td>
                            <td <?php echo $classRegistros; ?>>
                                <?php echo utf8_encode($rowEva['NOMBRE_MESA'][$e]); ?>
                            </td>
                            <td <?php echo $classRegistros; ?>>
                                <?php echo $rowEva['CODIGO_NORMA'][$e]; ?>
                            </td>
                            <td <?php echo $classRegistros; ?>>
                                <?php echo $rowEva['VERSION_NORMA'][$e]; ?>
                            </td>
                            <td <?php echo $classRegistros; ?>>
                                <?php echo utf8_encode($rowEva['TITULO_NORMA'][$e]); ?>
                            </td>
                            <td <?php echo $classRegistros; ?>>
                                <?php echo $rowEva['EVALUACIONES_REALIZADAS'][$e]; ?>
                            </td>
                            <td <?php echo $classRegistros; ?>>
                                <?php echo $rowEva['PERSONAS_EVALUADAS'][$e]; ?>
                            </td>
                        </tr>
                        <?php
                        if ($rowCen['CODIGO_CENTRO'][$c] == 9540 && $e == $numRowsEva-1)
                        {
//							echo '<hr/> Inscripciones NCCER: <hr/>' .
                            $sqlNCCEREva = 'SELECT '
                                    . '	COUNT(DOCUMENTO) AS TOTAL_EVALUADOS, '
                                    . '	COUNT(DISTINCT DOCUMENTO) AS PERSONAS_EVALUADAS '
                                    . 'FROM T_NCCER '
                                    . "WHERE EVALUADO = 'SI' AND  EXTRACT (YEAR FROM FECHA_CORTE)='2016' ";
                            $objNCCEREva = oci_parse($connection, $sqlNCCEREva);
                            oci_execute($objNCCEREva);
//							echo '  // Numero Registros: ' .
                            $numRegistrosNCCEREva = oci_fetch_all($objNCCEREva, $datosNCCEREva);

//							echo '<pre>';
//							var_dump($datosNCCEREva);
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
                                    <?php echo $datosNCCEREva['TOTAL_EVALUADOS'][0]; ?>
                                </td>
                                <td <?php echo $classRegistros; ?>>
                                    <?php echo $datosNCCEREva['PERSONAS_EVALUADAS'][0]; ?>
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