<?php
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Proyectos_nacionales.xls");
header("Pragma: no-cache");
header("Expires: 0");

include("../../../Clase/conectar.php");
$connection = conectar($bd_host, $bd_usuario, $bd_pwd);
$f = date('d/m/Y');
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Reporte Indicadores Globales - Corte <?php echo $f ?></title>
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
                <th colspan="17" class="titulo">
                    Reporte Proyectos Nacionales - Corte <?php echo $f ?>
                </th>
            </tr>
            <tr>
                <th>
                    <strong>Código Proyectos Nacionales</strong>
                </th>
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
                    <strong>Código Proyecto</strong>
                </th>
                <th>
                    <strong>Nit Empresa</strong>
                </th>
                <th>
                    <strong>Nombre Empresa</strong>
                </th>
                <th>
                    <strong>Personas Inscritas</strong>
                </th>
                <th>
                    <strong>Personas En Proceso</strong>
                </th>
                <th>
                    <strong>Personas Evaluadas</strong>
                </th>
                <th>
                    <strong>Personas Por Certificar</strong>
                </th>
                <th>
                    <strong>Personas Certificadas</strong>
                </th>
            </tr>
            <?php
//            echo '<hr/> Proyectos Nacionales: <hr/>' .
            $sqlProyNa = 'SELECT '
                    . ' ProyNa.ID_PROYECTO_NACIONAL '
                    . 'FROM T_PROYECTOS_NACIONALES ProyNa '
//                    . 'WHERE ProyNa.ID_PROYECTO_NACIONAL = 102'
                    . 'ORDER BY '
                    . ' ProyNa.ID_PROYECTO_NACIONAL ASC';
            $objProyNa = oci_parse($connection, $sqlProyNa);
            oci_execute($objProyNa);
//            echo '  // Numero Registros: ' .
            $numRowsProyNa = oci_fetch_all($objProyNa, $rowProyNa);

//            echo '<pre>';
//            var_dump($rowProyNa);
//            echo '</pre>';

            $registros = 0;
            for ($ProyNa = 0; $ProyNa < $numRowsProyNa; $ProyNa++)
            {
//              echo '<hr/> Proyectos Nacionales Regulares: <hr/>' .
                $sqlProyNaReg = 'SELECT '
                        . ' PRO.ID_PROYECTO '
                        . 'FROM( '
                        . ' SELECT '
                        . '  ProyNaReg.ID_PROYECTO_NACIONAL, '
                        . '  ProyNaReg.ID_PROYECTO '
                        . ' FROM T_PROY_NAC_PROY_REG ProyNaReg '
                        . ' UNION '
                        . ' SELECT '
                        . '  ProyNaP.ID_PROYECTO_NACIONAL, '
                        . '  ProyNaP.ID_PROYECTO '
                        . ' FROM T_PROY_NAC_PROYECTO ProyNaP) PRO '
                        . "WHERE PRO.ID_PROYECTO_NACIONAL = {$rowProyNa['ID_PROYECTO_NACIONAL'][$ProyNa]} "
                        . 'ORDER BY '
                        . ' PRO.ID_PROYECTO ASC';
                $objProyNaReg = oci_parse($connection, $sqlProyNaReg);
                oci_execute($objProyNaReg);
//              echo '  // Numero Registros: ' .
                $numRowsProyNaReg = oci_fetch_all($objProyNaReg, $rowProyNaReg);

//              echo '<pre>';
//              var_dump($rowProyNaReg);
//              echo '</pre>';

                for ($ProyNaR = 0; $ProyNaR < $numRowsProyNaReg; $ProyNaR++)
                {
//                    echo '<hr/> Regionales: <hr/>' .
                    $sqlReg = 'SELECT '
                    . ' REG.CODIGO_REGIONAL AS CODIGO_REGIONAL, '
                    . ' INITCAP(REG.NOMBRE_REGIONAL) AS NOMBRE_REGIONAL, '
                    . ' CEN.CODIGO_CENTRO AS CODIGO_CENTRO, '
                    . ' INITCAP(CEN.NOMBRE_CENTRO) AS NOMBRE_CENTRO, '
                    . ' EMPS.NIT_EMPRESA AS NIT_EMPRESA, '
                    . ' INITCAP(EMPS.NOMBRE_EMPRESA) AS NOMBRE_EMPRESA '
                    . 'FROM PROYECTO  PRO '
                    . 'INNER JOIN CENTRO CEN  '
                    . ' ON PRO.ID_CENTRO = CEN.CODIGO_CENTRO '
                    . 'INNER JOIN REGIONAL REG '
                    . ' ON CEN.CODIGO_REGIONAL = REG.CODIGO_REGIONAL '
                    . 'LEFT JOIN EMPRESAS_SISTEMA EMPS '
                    . ' ON EMPS.NIT_EMPRESA = PRO.NIT_EMPRESA '
                    . "WHERE PRO.ID_PROYECTO = {$rowProyNaReg['ID_PROYECTO'][$ProyNaR]} "
                    . 'ORDER BY '
                    . ' INITCAP(REG.NOMBRE_REGIONAL) ASC, '
                    . ' CEN.CODIGO_CENTRO ASC, '
                    . ' INITCAP(EMPS.NOMBRE_EMPRESA) ASC ';
                    $objReg = oci_parse($connection, $sqlReg);
                    oci_execute($objReg);
//                    echo '  // Numero Registros: ' .
                    $numRowsReg = oci_fetch_all($objReg, $rowReg);

//                    echo '<pre>';
//                    var_dump($rowReg);
//                    echo '</pre>';

                    $Reg = 0;
                    do
                    {
//                          echo '<hr/> Candidatos Inscritos: <hr/>' .
                        $sqlIns = 'SELECT '
                                . ' COUNT(DISTINCT INS.ID_CANDIDATO) AS PERSONAS_INSCRITAS '
                                . 'FROM INSCRIPCION INS '
                                . "WHERE INS.ID_PROYECTO = {$rowProyNaReg['ID_PROYECTO'][$ProyNaR]}"
                                . ' AND INS.ESTADO = 1'
                                . 'ORDER BY '
                                . ' INS.ID_CANDIDATO ASC';
                        $objIns = oci_parse($connection, $sqlIns);
                        oci_execute($objIns);
//                          echo '  // Numero Registros: ' .
                        $numRowsIns = oci_fetch_all($objIns, $rowIns);

//                          echo '<pre>';
//                          var_dump($rowIns);
//                          echo '</pre>';
                              
//                        echo '<hr/> Evaluaciones Realizadas: <hr/>' .
                        $sqlEva = 'SELECT '
                                . ' COUNT(DISTINCT(EVA.ID_CANDIDATO)) AS PERSONAS_EVALUADAS '
                                . 'FROM PLAN_EVIDENCIAS PLE '
                                . 'INNER JOIN EVIDENCIAS_CANDIDATO EVA '
                                . ' ON  EVA.ID_PLAN  = PLE.ID_PLAN '
                                . 'WHERE EVA.ESTADO != 0 '
                                . ' AND SUBSTR(EVA.FECHA_REGISTRO, 7,2) = 15 '
                                . ' AND PLE.ID_PROYECTO = ' . $rowProyNaReg['ID_PROYECTO'][$ProyNaR];
                        $objEva = oci_parse($connection, $sqlEva);
                        oci_execute($objEva);
//                              echo '  // Numero Registros: ' .
                        $numRowsEva = oci_fetch_all($objEva, $rowEva);

//                              echo '<pre>';
//                              var_dump($rowEva);
//                              echo '</pre>';
                                  
//                        echo '<hr/> Personas Certificadas: <hr/>' .
                        $sqlCert = 'SELECT '
                                . ' COUNT(DISTINCT CERT.ID_CANDIDATO) AS PERSONAS_CERTIFICADAS '
                                . 'FROM CERTIFICACION CERT '
                                . "WHERE CERT.ID_PROYECTO = {$rowProyNaReg['ID_PROYECTO'][$ProyNaR]}"
                                . 'ORDER BY '
                                . ' CERT.ID_CANDIDATO ASC';
                        $objCert = oci_parse($connection, $sqlCert);
                        oci_execute($objCert);
//                                  echo '  // Numero Registros: ' .
                        $numRowsCert = oci_fetch_all($objCert, $rowCert);

//                                  echo '<pre>';
//                                  var_dump($rowCert);
//                                  echo '</pre>';

                        $classRegistros = ($registros % 2 == 0) ? 'class="trRegistros"' : '';
                        $registros++;
                        ?>
                        <tr>
                            <td <?php echo $classRegistros; ?>>
                                <?php echo $rowProyNa['ID_PROYECTO_NACIONAL'][$ProyNa]; ?>
                            </td>
                            <td <?php echo $classRegistros; ?>>
                                <?php echo $rowReg['CODIGO_REGIONAL'][$Reg]; ?>
                            </td>
                            <td <?php echo $classRegistros; ?>>
                                <?php echo utf8_encode($rowReg['NOMBRE_REGIONAL'][$Reg]); ?>
                            </td>
                            <td <?php echo $classRegistros; ?>>
                                <?php echo $rowReg['CODIGO_CENTRO'][$Reg]; ?>
                            </td>
                            <td <?php echo $classRegistros; ?>>
                                <?php echo utf8_encode($rowReg['NOMBRE_CENTRO'][$Reg]); ?>
                            </td>
                            <td <?php echo $classRegistros; ?>>
                                <?php echo $rowProyNaReg['ID_PROYECTO'][$ProyNaR]; ?>
                            </td>
                            <td <?php echo $classRegistros; ?>>
                                <?php echo $rowReg['NIT_EMPRESA'][$Reg]; ?>
                            </td>
                            <td <?php echo $classRegistros; ?>>
                                <?php echo utf8_encode($rowReg['NOMBRE_EMPRESA'][$Reg]); ?>
                            </td>
                            <td <?php echo $classRegistros; ?>>
                                <?php echo $rowIns['PERSONAS_INSCRITAS'][$Reg]; ?>
                            </td>
                            <td <?php echo $classRegistros; ?>>
                                <?php echo $rowIns['PERSONAS_INSCRITAS'][$Reg] - $rowEva['PERSONAS_EVALUADAS'][$Reg]; ?>
                            </td>
                            <td <?php echo $classRegistros; ?>>
                                <?php echo $rowEva['PERSONAS_EVALUADAS'][$Reg]; ?>
                            </td>
                            <td <?php echo $classRegistros; ?>>
                                <?php echo $rowEva['PERSONAS_EVALUADAS'][$Reg]-$rowCert['PERSONAS_CERTIFICADAS'][$Reg]; ?>
                            </td>
                            <td <?php echo $classRegistros; ?>>
                                <?php echo $rowCert['PERSONAS_CERTIFICADAS'][$Reg]; ?>
                            </td>
                        </tr>
                        <?php
                        $Reg++;
                    }
                    while ($Reg < $numRowsReg);
                }
            }
            ?>
        </table>
    </body>
</html>
