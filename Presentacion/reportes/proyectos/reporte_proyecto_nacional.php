<?php
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Proyectos_nacionales.xls");
header("Pragma: no-cache");
header("Expires: 0");

include("../../../Clase/conectar.php");
$connection = conectar($bd_host, $bd_usuario, $bd_pwd);
$f = date('d/m/Y');
?>
<!DOCTYPE html PUBLIC â€œ-//W3C//DTD XHTML 1.0 Transitional//ENâ€� â€œhttp://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtdâ€�>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Reporte Proyectos Nacionales</title>
    </head>
    <body>
        <table>
            <tr>
                <th colspan="9">
                    <!â€“Imprimimos un titulo â€“>
                    <div style="color:#003; text-align:center; text-shadow:#666; font-size: 20px">Reporte Proyectos Nacionales - Corte <?php echo $f ?> <br /></div>
                </th>
            </tr>
        </table>
        <table border="1">
            <tr style="background-color:#006; text-align:center; color:#FFF">

                <th><strong>Código Proyecto Nacional</strong></th>
                <th><strong>Nit Empresa</strong></th>
                <th><strong>Empresa</strong></th>
                <th><strong>Código Regional</strong></th>
                <th><strong>Nombre Regional</strong></th>
                <th><strong>Código Centro</strong></th>
                <th><strong>Nombre Centro</strong></th>
                <th><strong>Código Proyecto</strong></th>
                <th><strong>Aspirantes Inscritos</strong></th>
                <th><strong>Total Candidatos Formalizados</strong></th>
                <th><strong>Candidatos Formalizados en Proceso</strong></th>
                <th><strong>Evaluaciones Realizadas</strong></th>
                <th><strong>Personas Evaluadas</strong></th>
                <th><strong>Certificados Expedidos</strong></th>
                <th><strong>Personas Certificadas</strong></th>
            </tr>
            <?php
            $sqlProNac = 'SELECT ' .
                    'TPN.ID_PROYECTO_NACIONAL ' .
                    'FROM T_PROYECTOS_NACIONALES TPN ' .
                    'ORDER BY ID_PROYECTO_NACIONAL ASC';
            $objProNac = oci_parse($connection, $sqlProNac);
            oci_execute($objProNac);
            $numRowsProNac = oci_fetch_all($objProNac, $rowProNac);

            for ($i = 0; $i < $numRowsProNac; $i++)
            {
//                echo '<hr/><hr/>' . $rowProNac['ID_PROYECTO_NACIONAL'][$i];
//                echo '<hr/>' . 
                $sqlProyectos1 = 'SELECT '
                        . 'PRO.ID_PROYECTO '
                        . 'FROM T_PROYECTOS_NACIONALES TPN '
                        . 'INNER JOIN T_PROY_NAC_PROYECTO PNP '
                        . '  ON PNP.ID_PROYECTO_NACIONAL = TPN.ID_PROYECTO_NACIONAL '
                        . 'INNER JOIN PROYECTO PRO '
                        . '  ON PRO.ID_PROYECTO = PNP.ID_PROYECTO '
                        . 'INNER JOIN CENTRO CEN '
                        . '  ON CEN.CODIGO_CENTRO = PRO.ID_CENTRO '
                        . 'WHERE CEN.CODIGO_CENTRO != 17076 '
                        . "  AND TPN.ID_PROYECTO_NACIONAL = {$rowProNac['ID_PROYECTO_NACIONAL'][$i]} "
                        . 'ORDER BY TPN.ID_PROYECTO_NACIONAL ASC';
                $objProyectos1 = oci_parse($connection, $sqlProyectos1);
                oci_execute($objProyectos1);
                $numRowsPro1 = oci_fetch_all($objProyectos1, $rowProyecto1);

//                echo '<br/><br/>' .
                $sqlProyectos2 = 'SELECT '
                        . 'PRO.ID_PROYECTO '
                        . 'FROM T_PROYECTOS_NACIONALES TPN '
                        . 'INNER JOIN T_PROY_NAC_PROY_REG PNR '
                        . '  ON PNR.ID_PROYECTO_NACIONAL = TPN.ID_PROYECTO_NACIONAL '
                        . 'INNER JOIN PROYECTO PRO '
                        . '  ON PRO.ID_PROYECTO = PNR.ID_PROYECTO '
                        . 'INNER JOIN CENTRO CEN '
                        . '  ON CEN.CODIGO_CENTRO = PRO.ID_CENTRO '
                        . 'WHERE CEN.CODIGO_CENTRO != 17076 '
                        . "  AND TPN.ID_PROYECTO_NACIONAL = {$rowProNac['ID_PROYECTO_NACIONAL'][$i]} "
                        . 'ORDER BY TPN.ID_PROYECTO_NACIONAL ASC';
                $objProyectos2 = oci_parse($connection, $sqlProyectos2);
                oci_execute($objProyectos2);
                $numRowsPro2 = oci_fetch_all($objProyectos2, $rowProyecto2);

                unset($rowProyectoTotal);
                $rowProyectoTotal = $rowProyecto1;

                for ($j = 0; $j < count($rowProyecto2['ID_PROYECTO']); $j++)
                {
                    array_push($rowProyectoTotal['ID_PROYECTO'], $rowProyecto2['ID_PROYECTO'][$j]);
                }
//                echo '<pre>';
//                var_dump($rowProyectoTotal);
//                echo '</pre>';

                $sqlEmp = 'SELECT '
                        . 'ES.NIT_EMPRESA,'
                        . 'ES.NOMBRE_EMPRESA '
                        . 'FROM PROYECTO PRO '
                        . 'INNER JOIN EMPRESAS_SISTEMA ES '
                        . ' ON PRO.NIT_EMPRESA = ES.NIT_EMPRESA '
                        . "WHERE PRO.ID_PROYECTO = {$rowProyectoTotal['ID_PROYECTO'][0]}";
                $objEmp = oci_parse($connection, $sqlEmp);
                oci_execute($objEmp);
                $numRowsEmp = oci_fetch_all($objEmp, $rowEmp);

//                echo '<hr/>' . $rowEmp['NIT_EMPRESA'][0] . ' - ' . $rowEmp['NOMBRE_EMPRESA'][0] . '<br/>';

                unset($totalAspirantes);
                unset($totalCandidatos);
                unset($totalEvaluacionesRealizadas);
                unset($totalPersonasEvaluadas);
                unset($totalCertificadosExpedidos);
                unset($totalPersonasCertificadas);

                for ($j = 0; $j < count($rowProyectoTotal['ID_PROYECTO']); $j++)
                {
//                    echo '<hr/><br/><br/>' .
                    $sqlAspirantes = 'SELECT COUNT(*) AS ASPIRANTES '
                            . 'FROM CANDIDATOS_PROYECTO CPR '
                            . 'INNER JOIN PROYECTO PRO '
                            . ' ON CPR.ID_PROYECTO = PRO.ID_PROYECTO '
                            . 'WHERE SUBSTR(PRO.FECHA_ELABORACION, 7, 4) = 2016 '
                            . " AND CPR.ID_PROYECTO = {$rowProyectoTotal['ID_PROYECTO'][$j]}";
                    $objAspiramtes = oci_parse($connection, $sqlAspirantes);
                    oci_execute($objAspiramtes);
                    $numRowsAspirantes = oci_fetch_all($objAspiramtes, $rowAspitantes);

//                    $totalAspirantes += $rowAspitantes ['ASPIRANTES'][0];
//                    echo '<br/><br/>' .
                    $sqlCandidatos = 'SELECT COUNT(*) AS CANDIDATOS '
                            . 'FROM INSCRIPCION INS '
                            . 'INNER JOIN PROYECTO PRO '
                            . ' ON INS.ID_PROYECTO = PRO.ID_PROYECTO '
                            . 'WHERE SUBSTR(PRO.FECHA_ELABORACION, 7, 4) = 2016 '
                            . 'AND INS.ESTADO = 1'
                            . " AND PRO.ID_PROYECTO = {$rowProyectoTotal['ID_PROYECTO'][$j]}";
                    $objCandidatos = oci_parse($connection, $sqlCandidatos);
                    oci_execute($objCandidatos);
                    $numRowsCandidatos = oci_fetch_all($objCandidatos, $rowCandidatos);

//                    $totalCandidatos += $rowCandidatos ['CANDIDATOS'][0];
//                    echo '<br/><br/>' .
                    $sqlEvaluaciones = 'SELECT COUNT(UNIQUE(EC.ID_CANDIDATO)) AS PERSONAS, COUNT(*) EVALUACIONES '
                            . 'FROM PROYECTO PRO '
                            . 'INNER JOIN PLAN_EVIDENCIAS PE '
                            . ' ON PE.ID_PROYECTO = PRO.ID_PROYECTO '
                            . 'INNER JOIN EVIDENCIAS_CANDIDATO EC '
                            . ' ON PE.ID_PLAN = EC.ID_PLAN '
                            . 'WHERE SUBSTR(PRO.FECHA_ELABORACION, 7, 4) = 2016'
                            . " AND PRO.ID_PROYECTO = {$rowProyectoTotal['ID_PROYECTO'][$j]}";

                    $objEvaluaciones = oci_parse($connection, $sqlEvaluaciones);
                    oci_execute($objEvaluaciones);
                    $numRowsEvaluaciones = oci_fetch_all($objEvaluaciones, $rowEvaluaciones);

//                    $totalEvaluacionesRealizadas += $rowEvaluaciones ['EVALUACIONES'][0];
//                    $totalPersonasEvaluadas += $rowEvaluaciones ['PERSONAS'][0];
//                    echo '<br/><br/>' .
                    $sqlCertificados = 'SELECT COUNT(*) AS CERTIFICADOS, COUNT(UNIQUE(ID_CANDIDATO)) AS PERSONAS '
                            . 'FROM CERTIFICACION CE '
                            . 'INNER JOIN PROYECTO PRO '
                            . ' ON CE.ID_PROYECTO = PRO.ID_PROYECTO '
                            . 'WHERE SUBSTR(PRO.FECHA_ELABORACION, 7, 4) = 2016 '
                            . " AND PRO.ID_PROYECTO = {$rowProyectoTotal['ID_PROYECTO'][$j]}";

                    $objCertificados = oci_parse($connection, $sqlCertificados);
                    oci_execute($objCertificados);
                    $numRowsCertificados = oci_fetch_all($objCertificados, $rowCertificados);

//                    $totalCertificadosExpedidos += $rowCertificados ['CERTIFICADOS'][0];
//                    $totalPersonasCertificadas += $rowCertificados ['PERSONAS'][0];

//                    echo '<br/><br/>' 
                    $sqlRegCen = 'SELECT REG.CODIGO_REGIONAL, REG.NOMBRE_REGIONAL, CEN.CODIGO_CENTRO, CEN.NOMBRE_CENTRO '
                            . 'FROM PROYECTO PRO '
                            . 'INNER JOIN CENTRO CEN '
                            . ' ON PRO.ID_CENTRO = CEN.CODIGO_CENTRO '
                            . 'INNER JOIN REGIONAL REG '
                            . ' ON PRO.ID_REGIONAL = REG.CODIGO_REGIONAL '
                            . 'WHERE SUBSTR(PRO.FECHA_ELABORACION, 7, 4) = 2016 '
                            . " AND PRO.ID_PROYECTO = {$rowProyectoTotal['ID_PROYECTO'][$j]}";

                    $objRegCen = oci_parse($connection, $sqlRegCen);
                    oci_execute($objRegCen);
                    $numRowsRegCen = oci_fetch_all($objRegCen, $rowRegCen);
                    
//                    echo '<hr/>';
//                    echo 'Código Centro = ' . $rowRegCen['CODIGO_REGIONAL'][0] . '<br/>';
//                    echo 'Nombre Centro = ' . $rowRegCen['NOMBRE_REGIONAL'][0] . '<br/>';
//                    echo 'Código Regional = ' . $rowRegCen['CODIGO_CENTRO'][0] . '<br/>';
//                    echo 'Nombre Regional = ' . $rowRegCen['NOMBRE_CENTRO'][0] . '<br/>';
//                    echo 'Código Proyecto = ' . $rowProyectoTotal['ID_PROYECTO'][$j] . '<br/>';
//                }
//                echo '<hr/>';
//                echo 'Aspirantes = ' . $totalAspirantes . '<br/>';
//                echo 'Candidatos = ' . $totalCandidatos . '<br/>';
//                echo 'Evaluaciones Realizadas = ' . $totalEvaluacionesRealizadas . '<br/>';
//                echo 'Personas Evaluadas = ' . $totalPersonasEvaluadas . '<br/>';
//                echo 'Certificados Expedidos = ' . $totalCertificadosExpedidos . '<br/>';
//                echo 'Personas Certificadas = ' . $totalPersonasCertificadas . '<br/>';
//                
                    if ($fondo == '#D9E1F2')
                    {
                        $fondo = '#B4C6E7';
                    }
                    else
                    {
                        $fondo = '#D9E1F2';
                    }
                    if ($rowEmp['NIT_EMPRESA'][0] == NULL)
                    {
                        $rowEmp['NIT_EMPRESA'][0] = 'DEMANDA SOCIAL';
                        $rowEmp['NOMBRE_EMPRESA'][0] = 'SENA';
                    }
                    ?>

                        <!--                <tr style="background-color:<?php //echo $fondo   ?>;">
                                <td><?php //echo $rowProNac['ID_PROYECTO_NACIONAL'][$i];   ?></td>
                                <td><?php //echo $rowEmp['NIT_EMPRESA'][0];    ?></td>
                                <td><?php //echo utf8_encode($rowEmp['NOMBRE_EMPRESA'][0]);    ?></td>
                                <td><?php //echo $totalAspirantes;    ?></td>
                                <td><?php //echo $totalCandidatos;    ?></td>
                                <td><?php //echo $totalEvaluacionesRealizadas;    ?></td>
                                <td><?php //echo $totalPersonasEvaluadas;    ?></td>
                                <td><?php //echo $totalCertificadosExpedidos;    ?></td>
                                <td><?php //echo $totalPersonasCertificadas;    ?></td>
                            </tr>-->

                    <tr style="background-color:<?php echo $fondo ?>;">
                        <td><?php echo $rowProNac['ID_PROYECTO_NACIONAL'][$i]; ?></td>
                        <td><?php echo $rowEmp['NIT_EMPRESA'][0]; ?></td>
                        <td><?php echo utf8_encode($rowEmp['NOMBRE_EMPRESA'][0]); ?></td>
                        <td><?php echo $rowRegCen['CODIGO_REGIONAL'][0]; ?></td>
                        <td><?php echo utf8_encode($rowRegCen['NOMBRE_REGIONAL'][0]); ?></td>
                        <td><?php echo $rowRegCen['CODIGO_CENTRO'][0]; ?></td>
                        <td><?php echo utf8_encode($rowRegCen['NOMBRE_CENTRO'][0]); ?></td>
                        <td><?php echo $rowProyectoTotal['ID_PROYECTO'][$j]; ?></td>
                        <td><?php echo $rowAspitantes ['ASPIRANTES'][0]; ?></td>
                        <td><?php echo $rowCandidatos ['CANDIDATOS'][0]; ?></td>
                        <td><?php echo $rowCandidatos ['CANDIDATOS'][0] - $rowEvaluaciones ['EVALUACIONES'][0]; ?></td>
                        <td><?php echo $rowEvaluaciones ['EVALUACIONES'][0]; ?></td>
                        <td><?php echo $rowEvaluaciones ['PERSONAS'][0]; ?></td>
                        <td><?php echo $rowCertificados ['CERTIFICADOS'][0]; ?></td>
                        <td><?php echo $rowCertificados ['PERSONAS'][0]; ?></td>
                    </tr>

                    <?php
                }
            }
            oci_close($connection);
            ?>
        </table>
    </body>
</html>