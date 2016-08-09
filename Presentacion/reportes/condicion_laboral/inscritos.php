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
        <title>Reporte Condición Laboral Inscritos - Corte <?php echo $f ?></title>
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
                    Reporte Condición Laboral Inscritos - Corte <?php echo $f ?>
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
                    <strong>Código Proyecto</strong>
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
                    <strong>Teléfono</strong>
                </th>
                <th>
                    <strong>Celular</strong>
                </th>
                <th>
                    <strong>Condición Laboral</strong>
                </th>
            </tr>
            <?php
//            echo '<hr/> Condicion Laboral: <hr/>' .
            $sqlCondLab = 'SELECT DISTINCT '
                            . 'REG.CODIGO_REGIONAL,'
                            . 'INITCAP(REG.NOMBRE_REGIONAL) AS NOMBRE_REGIONAL,'
                            . 'CEN.CODIGO_CENTRO,'
                            . 'INITCAP(CEN.NOMBRE_CENTRO) AS NOMBRE_CENTRO,'
                            . '"P" || PRO.ID_PROYECTO AS CODIGO_PROYECTO,'
                            . 'USU.DOCUMENTO,'
                            . 'INITCAP(USU.NOMBRE) AS NOMBRE,'
                            . 'INITCAP(USU.PRIMER_APELLIDO) AS PRIMER_APELLIDO,'
                            . 'INITCAP(USU.SEGUNDO_APELLIDO) AS SEGUNDO_APELLIDO,'
                            . 'INITCAP(USU.EMAIL) AS CORREO_ELECTRONICO,'
                            . 'USU.TELEFONO,'
                            . 'USU.CELULAR,'
                            . 'CLB.DESCRIPCION'
                        . 'FROM INSCRIPCION INS'
                        . 'INNER JOIN PROYECTO PRO'
                            . 'ON PRO.ID_PROYECTO = INS.ID_PROYECTO'
                        . 'INNER JOIN CENTRO CEN'
                            . 'ON CEN.CODIGO_CENTRO = PRO.ID_CENTRO'
                        . 'INNER JOIN REGIONAL REG'
                            . 'ON REG.CODIGO_REGIONAL = CEN.CODIGO_REGIONAL'
                        . 'INNER JOIN USUARIO USU'
                            . 'ON USU.USUARIO_ID = INS.ID_CANDIDATO'
                        . 'LEFT JOIN CONDICION_LABORAL CLB'
                            . 'ON CLB.ID_CONDICION_LABORAL = USU.CONDICION_LABORAL '
                        . 'WHERE INS.FECHA_REGISTRO >= "01/01/16"'
                        . 'ORDER BY '
                            . 'INITCAP(REG.NOMBRE_REGIONAL),'
                            . 'INITCAP(CEN.NOMBRE_CENTRO),'
                            . 'INITCAP(USU.NOMBRE),'
                            . 'INITCAP(USU.PRIMER_APELLIDO),'
                            . 'INITCAP(USU.SEGUNDO_APELLIDO),'
                            . 'INITCAP(USU.EMAIL),'
                            . 'USU.TELEFONO,'
                            . 'USU.CELULAR';

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
