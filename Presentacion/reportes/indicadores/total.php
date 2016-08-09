<?php
$f = date('d/m/Y H:i');
$fe = date('d/m/Y');
$h = date('H');
$m = date('i');

header("Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment; filename=Consolidado INS-PEV-EVA-PCE-CER Total REG-CEN (Corte $fe H$h M$m).xls");
header("Pragma: no-cache");
header("Expires: 0");

include("../../../Clase/conectar.php");
$connection = conectar($bd_host, $bd_usuario, $bd_pwd);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Consolidado INS-PEV-EVA-PCE-CER Total REG-CEN - Corte <?php echo $f ?></title>
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
                    Consolidado INS-PEV-EVA-PCE-CER Total REG-CEN - Corte <?php echo $f ?>
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
                    <strong>Candidatos Inscritos</strong>
                </th>
                <th>
                    <strong>Candidatos En Proceso</strong>
                </th>
                <th>
                    <strong>Evaluaciones Realizadas</strong>
                </th>
                <th>
                    <strong>Evaluados Por Certificar</strong>
                </th>
                <th>
                    <strong>Certificaciones Expedidas</strong>
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
					$sqlIns = 'SELECT '
							. ' COUNT(INS.ID_CANDIDATO) AS CANDIDATOS_INSCRITOS '
							. 'FROM INSCRIPCION INS '
							. 'INNER JOIN PROYECTO PRO '
							. ' ON PRO.ID_PROYECTO = INS.ID_PROYECTO '
							. "WHERE PRO.ID_CENTRO = {$rowCen['CODIGO_CENTRO'][$c]} "
							. " AND SUBSTR(INS.FECHA_REGISTRO,7,2) = '16' "
							. ' AND INS.ESTADO = 1 ';
					$objIns = oci_parse($connection, $sqlIns);
					oci_execute($objIns);
//                            echo '  // Numero Registros: ' .
					$numRowsIns = oci_fetch_all($objIns, $rowIns);

//                            echo '<pre>';
//                            var_dump($rowIns);
//                            echo '</pre>';  
//                            echo '<hr/> Candidatos Inscritos a la norma ' . $rowNor['CODIGO_NORMA'][$n] . ': <hr/>' .
					$sqlEva = 'SELECT '
							. ' COUNT(EVA.ID_CANDIDATO) AS EVALUACIONES_REALIZADAS '
							. 'FROM PLAN_EVIDENCIAS PLE '
							. 'INNER JOIN EVIDENCIAS_CANDIDATO EVA '
							. ' ON  EVA.ID_PLAN  = PLE.ID_PLAN '
							. 'INNER JOIN PROYECTO PRO '
							. ' ON PRO.ID_PROYECTO = PLE.ID_PROYECTO '
							. 'WHERE EVA.ESTADO != 0 '
							. " AND SUBSTR(EVA.FECHA_REGISTRO, 7,2) = '16' "
							. " AND PRO.ID_CENTRO = {$rowCen['CODIGO_CENTRO'][$c]}";
					$objEva = oci_parse($connection, $sqlEva);
					oci_execute($objEva);
//                            echo '  // Numero Registros: ' .
					$numRowsEva = oci_fetch_all($objEva, $rowEva);

//                            echo '<pre>';
//                            var_dump($rowEva);
//                            echo '</pre>';
//                            echo '<hr/> Certificaciones en la norma ' . $rowNor['CODIGO_NORMA'][$n] . ': <hr/>' .
					$sqlCer = 'SELECT '
							. '	COUNT(NROIDENT) AS CERTIFICACIONES_EXPEDIDAS '
							. 'FROM T_HISTORICO '
							. "WHERE TIPO_CERTIFICADO = 'NC' "
							. "	AND TIPO_ESTADO = 'CERTIFICA' "
							. "	AND TO_CHAR(FECHA_REGISTRO, 'yyyy') = '2016' "
							. "	AND SUBSTR(CENTRO_ID_CENTRO,0,4) = {$rowCen['CODIGO_CENTRO'][$c]}";
					$objCer = oci_parse($connection, $sqlCer);
					oci_execute($objCer);
//                            echo '  // Numero Registros: ' .
					$numRowsCer = oci_fetch_all($objCer, $rowCer);

//                            echo '<pre>';
//                            var_dump($rowCer);
//                            echo '</pre>'; 

					if ($rowCen['CODIGO_CENTRO'][$c] == 9540)
					{
//                        echo '<hr/> Inscripciones NCCER: <hr/>' .	
						$sqlNCCERIns = " SELECT 
                                            COUNT(DOCUMENTO) AS TOTAL_INSCRITOS 
                                        FROM T_NCCER
                                        WHERE INSCRITO = 'SI' AND  EXTRACT (YEAR FROM FECHA_CORTE)='2016'";
						$objNCCERIns = oci_parse($connection, $sqlNCCERIns);
						oci_execute($objNCCERIns);
//                        echo '  // Numero Registros: ' .
						$numRegistrosNCCERIns = oci_fetch_all($objNCCERIns, $datosNCCERIns);

//                        echo '<pre>';
//                        var_dump($datosNCCERIns);
//                        echo '</pre>';
                        
//                        echo '<hr/> Evaluaciones NCCER: <hr/>' .	
						$sqlNCCEREva = " SELECT 
                                            COUNT(DOCUMENTO) AS TOTAL_EVALUADOS 
                                        FROM T_NCCER
                                        WHERE EVALUADO = 'SI' AND  EXTRACT (YEAR FROM FECHA_CORTE)='2016'";
						$objNCCEREva = oci_parse($connection, $sqlNCCEREva);
						oci_execute($objNCCEREva);
//                        echo '  // Numero Registros: ' .
						$numRegistrosNCCEREva = oci_fetch_all($objNCCEREva, $datosNCCEREva);

//                        echo '<pre>';
//                        var_dump($datosNCCEREva);
//                        echo '</pre>';
//                        echo '<hr/> Certificaciones NCCER: <hr/>' .
						$sqlNCCERCer = " SELECT 
                                            COUNT(DOCUMENTO) AS TOTAL_CERTIFICADOS 
                                        FROM T_NCCER
                                        WHERE CERTIFICADO = 'SI' AND  EXTRACT (YEAR FROM FECHA_CORTE)='2016'";
						$objNCCERCer = oci_parse($connection, $sqlNCCERCer);
						oci_execute($objNCCERCer);
//                        echo '  // Numero Registros: ' .
						$numRegistrosNCCERCer = oci_fetch_all($objNCCERCer, $datosNCCERCer);

//                        echo '<pre>';
//                        var_dump($datosNCCERCer);
//                        echo '</pre>';
					}
					else
					{
						$datosNCCERIns['TOTAL_INSCRITOS'][0] = 0;
						$datosNCCEREva['TOTAL_EVALUADOS'][0] = 0;
						$datosNCCERCer['TOTAL_CERTIFICADOS'][0] = 0;
					}

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
							<?php echo ($rowIns['CANDIDATOS_INSCRITOS'][0] + $datosNCCERIns['TOTAL_INSCRITOS'][0]); ?>
						</td>
						<td <?php echo $classRegistros; ?>>
							<?php echo ($rowIns['CANDIDATOS_INSCRITOS'][0] + $datosNCCERIns['TOTAL_INSCRITOS'][0]) - ($rowEva['EVALUACIONES_REALIZADAS'][0] + $datosNCCEREva['TOTAL_EVALUADOS'][0]); ?>
						</td>
						<td <?php echo $classRegistros; ?>>
							<?php echo ($rowEva['EVALUACIONES_REALIZADAS'][0] + $datosNCCEREva['TOTAL_EVALUADOS'][0]); ?>
						</td>
						<td <?php echo $classRegistros; ?>>
							<?php echo ($rowEva['EVALUACIONES_REALIZADAS'][0] + $datosNCCEREva['TOTAL_EVALUADOS'][0]) - ($rowCer['CERTIFICACIONES_EXPEDIDAS'][0] + $datosNCCERCer['TOTAL_CERTIFICADOS'][0]); ?>
						</td>
						<td <?php echo $classRegistros; ?>>
							<?php echo ($rowCer['CERTIFICACIONES_EXPEDIDAS'][0] + $datosNCCERCer['TOTAL_CERTIFICADOS'][0]); ?>
						</td>
					</tr>
							<?php
						}
					}
					?>
        </table>
    </body>
</html>