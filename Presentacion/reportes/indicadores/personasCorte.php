<?php
$f = date('d/m/Y H:i');
$fe = date('d/m/Y');
$h = date('H');
$m = date('i');

extract($_POST);

header("Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment; filename=Consolidado INS-PEV-EVA-PCE-CER Personas REG-CEN (Del $fInicial Al $fFinal)(Generado $fe H$h M$m).xls");
header("Pragma: no-cache");
header("Expires: 0");

//echo '<pre>';
//var_dump($_POST);
//echo '</pre>';

include("../../../Clase/conectar.php");
$connection = conectar($bd_host, $bd_usuario, $bd_pwd);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Consolidado INS-PEV-EVA-PCE-CER Personas REG-CEN - Corte <?php echo $f ?></title>
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
                    Consolidado INS-PEV-EVA-PCE-CER Personas REG-CEN - Corte <?php echo $f ?>
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
//                    echo '<hr/> Candidatos Inscritos en el Centro ' . $rowCen['CODIGO_CENTRO'][$c] . ': <hr/>' .
					$sqlIns = 'SELECT '
							. ' COUNT(DISTINCT INS.ID_CANDIDATO) AS PERSONAS_INSCRITAS '
							. 'FROM INSCRIPCION INS '
							. 'INNER JOIN PROYECTO PRO '
							. ' ON PRO.ID_PROYECTO = INS.ID_PROYECTO '
							. "WHERE PRO.ID_CENTRO = {$rowCen['CODIGO_CENTRO'][$c]} "
							. ' AND INS.ESTADO = 1 '
							. " AND TO_CHAR(TO_DATE(SUBSTR(INS.FECHA_REGISTRO, 1,10),'DD/MM/YY'),'YYYY-MM-DD') >= '$fInicial' "
							. " AND TO_CHAR(TO_DATE(SUBSTR(INS.FECHA_REGISTRO, 1,10),'DD/MM/YY'),'YYYY-MM-DD') <= '$fFinal'";
					$objIns = oci_parse($connection, $sqlIns);
					oci_execute($objIns);
//                    echo '  // Numero Registros: ' .
					$numRowsIns = oci_fetch_all($objIns, $rowIns);

//                    echo '<pre>';
//                    var_dump($rowIns);
//                    echo '</pre>';
//                    echo '<hr/> Candidatos Evaluados en el Centro ' . $rowCen['CODIGO_CENTRO'][$c] . ': <hr/>' .
					$sqlEva = 'SELECT '
							. ' COUNT(DISTINCT EVA.ID_CANDIDATO) AS PERSONAS_EVALUADAS '
							. 'FROM PLAN_EVIDENCIAS PLE '
							. 'INNER JOIN EVIDENCIAS_CANDIDATO EVA '
							. ' ON  EVA.ID_PLAN  = PLE.ID_PLAN '
							. 'INNER JOIN PROYECTO PRO '
							. ' ON PRO.ID_PROYECTO = PLE.ID_PROYECTO '
							. 'WHERE EVA.ESTADO != 0 '
							. " AND SUBSTR(EVA.FECHA_EMISION, 7,2) = '16' "
							. " AND TO_CHAR(TO_DATE(SUBSTR(EVA.FECHA_EMISION, 1,10),'DD/MM/YY'),'YYYY-MM-DD') >= '$fInicial' "
							. " AND TO_CHAR(TO_DATE(SUBSTR(EVA.FECHA_EMISION, 1,10),'DD/MM/YY'),'YYYY-MM-DD') <= '$fFinal' "
							. " AND PRO.ID_CENTRO = {$rowCen['CODIGO_CENTRO'][$c]}";
					$objEva = oci_parse($connection, $sqlEva);
					oci_execute($objEva);
//                    echo '  // Numero Registros: ' .
					$numRowsEva = oci_fetch_all($objEva, $rowEva);

//                    echo '<pre>';
//                    var_dump($rowEva);
//                    echo '</pre>';
//                    echo '<hr/> Candidatos Certificados en el Centro ' . $rowCen['CODIGO_CENTRO'][$c] . ': <hr/>' .
					$sqlCer = 'SELECT '
							. '	COUNT(DISTINCT NROIDENT) AS PERSONAS_CERTIFICADAS '
							. 'FROM T_HISTORICO '
							. "WHERE TIPO_CERTIFICADO = 'NC' "
							. "	AND TIPO_ESTADO = 'CERTIFICA' "
							. "	AND SUBSTR(CENTRO_ID_CENTRO,0,4) = {$rowCen['CODIGO_CENTRO'][$c]}"
							. "	AND TO_CHAR(TO_DATE(FECHA_REGISTRO,'DD/MM/YY'),'YY-MM-DD') >= '" . substr($fInicial, 2, 10) . "' "
							. "	AND TO_CHAR(TO_DATE(FECHA_REGISTRO,'DD/MM/YY'),'YY-MM-DD') <= '" . substr($fFinal, 2, 10) . "'";
					$objCer = oci_parse($connection, $sqlCer);
					oci_execute($objCer);
//                    echo '  // Numero Registros: ' .
					$numRowsCer = oci_fetch_all($objCer, $rowCer);

//                    echo '<pre>';
//                    var_dump($rowCer);
//                    echo '</pre>';

					if ($rowCen['CODIGO_CENTRO'][$c] == 9540)
					{
//                        echo '<hr/> Inscripciones NCCER: <hr/>' .
						$sqlNCCERIns = 'SELECT '
								. '	COUNT(DISTINCT DOCUMENTO) AS PERSONAS_INSCRITAS '
								. 'FROM T_NCCER '
								. "WHERE INSCRITO = 'SI' "
								. "	AND TO_CHAR(TO_DATE(FECHA_CORTE,'DD/MM/YY'),'YY-MM-DD') >= '" . substr($fInicial, 2, 10) . "' "
								. "	AND TO_CHAR(TO_DATE(FECHA_CORTE,'DD/MM/YY'),'YY-MM-DD') <= '" . substr($fFinal, 2, 10) . "'";
						$objNCCERIns = oci_parse($connection, $sqlNCCERIns);
						oci_execute($objNCCERIns);
//                        echo '  // Numero Registros: ' .
						$numRegistrosNCCERIns = oci_fetch_all($objNCCERIns, $datosNCCERIns);

//                        echo '<pre>';
//                        var_dump($datosNCCERIns);
//                        echo '</pre>';
//                        echo '<hr/> Evaluaciones NCCER: <hr/>' .
						$sqlNCCEREva = 'SELECT '
								. '	COUNT(DISTINCT DOCUMENTO) AS PERSONAS_EVALUADAS '
								. 'FROM T_NCCER '
								. "WHERE EVALUADO = 'SI' "
								. "	AND TO_CHAR(TO_DATE(FECHA_CORTE,'DD/MM/YY'),'YY-MM-DD') >= '" . substr($fInicial, 2, 10) . "' "
								. "	AND TO_CHAR(TO_DATE(FECHA_CORTE,'DD/MM/YY'),'YY-MM-DD') <= '" . substr($fFinal, 2, 10) . "'";
						$objNCCEREva = oci_parse($connection, $sqlNCCEREva);
						oci_execute($objNCCEREva);
//                        echo '  // Numero Registros: ' .
						$numRegistrosNCCEREva = oci_fetch_all($objNCCEREva, $datosNCCEREva);

//                        echo '<pre>';
//                        var_dump($datosNCCEREva);
//                        echo '</pre>';
//                        echo '<hr/> Certificaciones NCCER: <hr/>' .
						$sqlNCCERCer = 'SELECT '
								. '	COUNT(DISTINCT DOCUMENTO) AS PERSONAS_CERTIFICADAS '
								. 'FROM T_NCCER '
								. "WHERE CERTIFICADO = 'SI' "
								. "	AND TO_CHAR(TO_DATE(FECHA_CORTE,'DD/MM/YY'),'YY-MM-DD') >= '" . substr($fInicial, 2, 10) . "' "
								. "	AND TO_CHAR(TO_DATE(FECHA_CORTE,'DD/MM/YY'),'YY-MM-DD') <= '" . substr($fFinal, 2, 10) . "'";
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
						$datosNCCERIns['PERSONAS_INSCRITAS'][0] = 0;
						$datosNCCEREva['PERSONAS_EVALUADAS'][0] = 0;
						$datosNCCERCer['PERSONAS_CERTIFICADAS'][0] = 0;
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
							<?php echo ($rowIns['PERSONAS_INSCRITAS'][0] + $datosNCCERIns['PERSONAS_INSCRITAS'][0]); ?>
						</td>
						<td <?php echo $classRegistros; ?>>
							<?php echo ($rowIns['PERSONAS_INSCRITAS'][0] + $datosNCCERIns['PERSONAS_INSCRITAS'][0]) - ($rowEva['PERSONAS_EVALUADAS'][0] + $datosNCCERIns['PERSONAS_EVALUADAS'][0]); ?>
						</td>
						<td <?php echo $classRegistros; ?>>
							<?php echo ($rowEva['PERSONAS_EVALUADAS'][0] + $datosNCCEREva['PERSONAS_EVALUADAS'][0]); ?>
						</td>
						<td <?php echo $classRegistros; ?>>
							<?php echo ($rowEva['PERSONAS_EVALUADAS'][0] + $datosNCCEREva['PERSONAS_EVALUADAS'][0]) - ($rowCer['PERSONAS_CERTIFICADAS'][0] + $datosNCCEREva['PERSONAS_CERTIFICADAS'][0]); ?>
						</td>
						<td <?php echo $classRegistros; ?>>
							<?php echo ($rowCer['PERSONAS_CERTIFICADAS'][0] + $datosNCCERCer['PERSONAS_CERTIFICADAS'][0]); ?>
						</td>
					</tr>
					<?php
				}
			}
			?>
        </table>
    </body>
</html>