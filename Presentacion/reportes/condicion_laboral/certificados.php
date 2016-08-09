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
        <title>Reporte Condici�n Laboral Certificados - Corte <?php echo $f ?></title>
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
                    Reporte Condici�n Laboral Certificados - Corte <?php echo $f ?>
                </th>
            </tr>
            <tr>
                <th>
                    <strong>C�digo Regional</strong>
                </th>
                <th>
                    <strong>Nombre Regional</strong>
                </th>
                <th>
                    <strong>C�digo Centro</strong>
                </th>
                <th>
                    <strong>Nombre Centro</strong>
                </th>
                <th>
                    <strong>C�digo Proyecto</strong>
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
                    <strong>Correo Electronico</strong>
                </th>
                <th>
                    <strong>Tel�fono</strong>
                </th>
                <th>
                    <strong>Celular</strong>
                </th>
                <th>
                    <strong>Condici�n Laboral</strong>
                </th>
            </tr>
            <?php
//            echo '<hr/> Condicion Laboral: <hr/>' .
            $sqlCondLab = 'SELECT DISTINCT '
                            . 'HIS.CENTRO_REGIONAL_ID_REGIONAL AS CODIGO_REGIONAL,'
                            . 'INITCAP(HIS.NOMBREREGIONAL) AS NOMBRE_REGIONAL,'
                            . 'SUBSTR(HIS.CENTRO_ID_CENTRO,0,4) AS CODIGO_CENTRO,'
                            . 'INITCAP(HIS.NOMBRECENTRO) AS NOMBRE_CENTRO,'
                            . 'HIS.PROYECTO_SECCL AS CODIGO_PROYECTO,'
                            . 'USU.DOCUMENTO,'
                            . 'INITCAP(USU.NOMBRE) AS NOMBRE,'
                            . 'INITCAP(USU.PRIMER_APELLIDO) AS PRIMER_APELLIDO,'
                            . 'INITCAP(USU.SEGUNDO_APELLIDO) AS SEGUNDO_APELLIDO,'
                            . 'INITCAP(USU.EMAIL) AS CORREO_ELECTRONICO,'
                            . 'USU.TELEFONO,'
                            . 'USU.CELULAR,'
                            . 'CLB.DESCRIPCION'
                        . 'FROM T_HISTORICO  HIS'
                        . 'INNER JOIN USUARIO USU'
                            . 'ON USU.DOCUMENTO = HIS.NROIDENT'
                        . 'LEFT JOIN CONDICION_LABORAL CLB'
                            . 'ON CLB.ID_CONDICION_LABORAL = USU.CONDICION_LABORAL '
                        . 'WHERE HIS.TIPO_CERTIFICADO = "NC"'
                            . 'AND HIS.TIPO_ESTADO = "CERTIFICA"'
                            . 'AND HIS.fecha_registro >= "01/01/16"'
                        . 'ORDER BY '
                            . 'INITCAP(HIS.NOMBREREGIONAL) ASC,'
                            . 'INITCAP(SUBSTR(HIS.CENTRO_ID_CENTRO,0,4)) ASC,'
                            . 'INITCAP(USU.NOMBRE) ASC,'
                            . 'INITCAP(USU.PRIMER_APELLIDO) ASC,'
                            . 'INITCAP(USU.SEGUNDO_APELLIDO) ASC,'
                            . 'INITCAP(USU.EMAIL) ASC,'
                            . 'USU.TELEFONO ASC,'
                            . 'USU.CELULAR ASC';

            $objCondLab = oci_parse($connection, $sqlCondLab);
            oci_execute($objCondLab);
//            echo '  // Numero Registros: ' .
            $numRowsCondLab = oci_fetch_all($objCondLab, $rowCondLab);

//            echo '<pre>';
//            var_dump($rowCondLab);
//            echo '</pre>';

            for ($CondLab = 0; $CondLab < $numRowsCondLab; $CondLab++)
            {
                $classRegistros = ($registros % 2 == 0) ? 'class="trRegistros"' : '';
                $registros++;
                ?>
                <tr>
                    <td <?php echo $classRegistros; ?>>
                        <?php echo $rowCondLab['CODIGO_REGIONAL'][$CondLab]; ?>
                    </td>
                    <td <?php echo $classRegistros; ?>>
                        <?php echo utf8_encode($rowCondLab['NOMBRE_REGIONAL'][$CondLab]); ?>
                    </td>
                    <td <?php echo $classRegistros; ?>>
                        <?php echo $rowCondLab['CODIGO_CENTRO'][$CondLab]; ?>
                    </td>
                    <td <?php echo $classRegistros; ?>>
                        <?php echo utf8_encode($rowCondLab['NOMBRE_CENTRO'][$CondLab]); ?>
                    </td>
                    <td <?php echo $classRegistros; ?>>
                        <?php echo $rowCondLabReg['CODIGO_PROYECTO'][$CondLabR]; ?>
                    </td>
                    <td <?php echo $classRegistros; ?>>
                        <?php echo $rowCondLab['DOCUMENTO'][$CondLab]; ?>
                    </td>
                    <td <?php echo $classRegistros; ?>>
                        <?php echo utf8_encode($rowCondLab['NOMBRE'][$CondLab]); ?>
                    </td>
                    <td <?php echo $classRegistros; ?>>
                        <?php echo $rowCondLab['PRIMER_APELLIDO'][$CondLab]; ?>
                    </td>
                    <td <?php echo $classRegistros; ?>>
                        <?php echo $rowCondLab['SEGUNDO_APELLIDO'][$CondLab]; ?>
                    </td>
                    <td <?php echo $classRegistros; ?>>
                        <?php echo $rowCondLab['CORREO_ELECTRONICO'][$CondLab]; ?>
                    </td>
                    <td <?php echo $classRegistros; ?>>
                        <?php echo $rowCondLab['TELEFONO'][$CondLab]; ?>
                    </td>
                    <td <?php echo $classRegistros; ?>>
                        <?php echo $rowCondLab['CELULAR'][$CondLab]; ?>
                    </td>
                    <td <?php echo $classRegistros; ?>>
                        <?php echo $rowCondLab['DESCRIPCION'][$CondLab]; ?>
                    </td>
                </tr>
                <?php
            }
            ?>
        </table>
    </body>
</html>
