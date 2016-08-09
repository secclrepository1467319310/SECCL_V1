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
        <title>Reporte Personas Certificadas Agencia Pubblica de Empleo- Corte <?php echo $f ?></title>
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
                    Reporte Personas Certificadas Agencia Pubblica de Empleo- Corte <?php echo $f ?>
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
                    <strong>Documento</strong>
                </th>
                <th>
                    <strong>Nombre</strong>
                </th>
                <th>
                    <strong>Primer Apellido</strong>
                </th>
                <th>
                    <strong>Segundo Apellido</strong>
                </th>
                <th>
                    <strong>Condición Laboral</strong>
                </th>
            </tr>
            <?php
//            echo '<hr/> Agencia Publica de Empleo: <hr/>' .
            $sqlEmpleo = 'SELECT DISTINCT '
                            . 'HIS.CENTRO_REGIONAL_ID_REGIONAL AS CODIGO_REGIONAL, '
                            . 'INITCAP(HIS.NOMBREREGIONAL) AS NOMBRE_REGIONAL, '
                            . 'SUBSTR(HIS.CENTRO_ID_CENTRO,0,4) AS CODIGO_CENTRO, '
                            . 'INITCAP(HIS.NOMBRECENTRO) AS NOMBRE_CENTRO, '
                            . 'USU.DOCUMENTO, '
                            . 'INITCAP(USU.NOMBRE) AS NOMBRE, '
                            . 'INITCAP(USU.PRIMER_APELLIDO) AS PRIMER_APELLIDO, '
                            . 'INITCAP(USU.SEGUNDO_APELLIDO) AS SEGUNDO_APELLIDO, '
                            . 'CLB.DESCRIPCION ' 
                        . 'FROM T_HISTORICO  HIS '
                        . 'INNER JOIN USUARIO USU '
                            . 'ON USU.DOCUMENTO = HIS.NROIDENT '
                        . 'LEFT JOIN CONDICION_LABORAL CLB '
                            . 'ON CLB.ID_CONDICION_LABORAL = USU.CONDICION_LABORAL '
                        . "WHERE HIS.TIPO_CERTIFICADO = 'NC' "
                            . "AND HIS.TIPO_ESTADO = 'CERTIFICA' "
                            . "AND HIS.fecha_registro >= '01/01/16' "
                        . 'ORDER BY '
                            . 'INITCAP(HIS.NOMBREREGIONAL) ASC,'
                            . 'INITCAP(SUBSTR(HIS.CENTRO_ID_CENTRO,0,4)) ASC,'
                            . 'INITCAP(USU.NOMBRE) ASC, '
                            . 'INITCAP(USU.PRIMER_APELLIDO) ASC, '
                            . 'INITCAP(USU.SEGUNDO_APELLIDO) ASC ';
//echo $sqlEmpleo;
            $objEmpleo = oci_parse($connection, $sqlEmpleo);
            oci_execute($objEmpleo);
//            echo '  // Numero Registros: ' .
            $numRowsEmpleo = oci_fetch_all($objEmpleo, $rowEmpleo);
            
//            echo '<pre>';
//            var_dump($rowEmpleo);
//            echo '</pre>';

            for ($Empleo = 0; $Empleo < $numRowsEmpleo; $Empleo++)
            {
                $classRegistros = ($registros % 2 == 0) ? 'class="trRegistros"' : '';
                $registros++;
                ?>
                <tr>
                    <td <?php echo $classRegistros; ?>>
                        <?php echo $rowEmpleo['CODIGO_REGIONAL'][$Empleo]; ?>
                    </td>
                    <td <?php echo $classRegistros; ?>>
                        <?php echo utf8_encode($rowEmpleo['NOMBRE_REGIONAL'][$Empleo]); ?>
                    </td>
                    <td <?php echo $classRegistros; ?>>
                        <?php echo $rowEmpleo['CODIGO_CENTRO'][$Empleo]; ?>
                    </td>
                    <td <?php echo $classRegistros; ?>>
                        <?php echo utf8_encode($rowEmpleo['NOMBRE_CENTRO'][$Empleo]); ?>
                    </td>
                    <td <?php echo $classRegistros; ?>>
                        <?php echo $rowEmpleo['DOCUMENTO'][$Empleo]; ?>
                    </td>
                    <td <?php echo $classRegistros; ?>>
                        <?php echo utf8_encode($rowEmpleo['NOMBRE'][$Empleo]); ?>
                    </td>
                    <td <?php echo $classRegistros; ?>>
                        <?php echo $rowEmpleo['PRIMER_APELLIDO'][$Empleo]; ?>
                    </td>
                    <td <?php echo $classRegistros; ?>>
                        <?php echo $rowEmpleo['SEGUNDO_APELLIDO'][$Empleo]; ?>
                    </td>
                    <td <?php echo $classRegistros; ?>>
                        <?php echo $rowEmpleo['DESCRIPCION'][$Empleo]; ?>
                    </td>
                </tr>
                <?php
            }
            ?>
        </table>
    </body>
</html>
