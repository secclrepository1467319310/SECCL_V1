<?php
//header("Content-type: application/vnd.ms-excel");
//header("Content-Disposition: attachment; filename=Reporte_Historico_Certificaciones.xls");
//header("Pragma: no-cache");
//header("Expires: 0");

include("../../../Clase/conectar.php");
$connection = conectar($bd_host, $bd_usuario, $bd_pwd);
$f = date('d/m/Y');


extract($_POST);
//realizamos la consulta
?>
<!DOCTYPE html PUBLIC “-//W3C//DTD XHTML 1.0 Transitional//EN” “http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd”>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>
            Reporte Historico Certificaciones
        </title>
    </head>

    <body>
        <table width="641" border="1">
            <?php
            if (isset($chkPeriodo))
            {
                $banPeriodo = true;
                if (count($chkPeriodo) > 1)
                {
                    $conPeriodo = ' AND (';
                    for ($i = 0; $i < count($chkPeriodo); $i++)
                    {
                        $conPeriodo .= " TO_CHAR(FECHA_REGISTRO, 'YYYY') = '$chkPeriodo[$i]' OR";
                    }
                    $conPeriodo = substr($conPeriodo, 0, -2);
                    $conPeriodo .= ')';
                }
                else
                {
                    $conPeriodo = "  AND TO_CHAR(FECHA_REGISTRO, 'YYYY') = '$chkPeriodo[0]'";
                }
            }

            if (isset($ddlEmpresa) && $ddlEmpresa != '-1')
            {
                $banEmpresa = true;
                $gruCodEmpresa = ',EMPRESA_NROIDENT';
                $gruNomEmpresa = ',NOMBREEMPRESA';

                if ($ddlEmpresa == '1')
                {
                    $empresa = '  ,CASE'
                            . "     WHEN EMPRESA_NROIDENT IS NULL THEN 'NO REGISTRA'"
                            . '     ELSE EMPRESA_NROIDENT END AS NIT_EMPRESA'
                            . '  ,CASE'
                            . "     WHEN NOMBREEMPRESA IS NULL THEN 'NO REGISTRA'"
                            . '     ELSE NOMBREEMPRESA END AS NOMBRE_EMPRESA';
                    $conEmpresa = '  AND EMPRESA_NROIDENT IS NOT NULL';
                }
                else if ($ddlEmpresa == '2')
                {
                    $empresa = '  ,CASE'
                            . "     WHEN EMPRESA_NROIDENT IS NULL THEN 'SENA'"
                            . '     ELSE EMPRESA_NROIDENT END AS NIT_EMPRESA'
                            . '  ,CASE'
                            . "     WHEN NOMBREEMPRESA IS NULL THEN 'DEMANDA SOCIAL'"
                            . '     ELSE NOMBREEMPRESA END AS NOMBRE_EMPRESA';
                    $conEmpresa = '  AND EMPRESA_NROIDENT IS NULL';
                }
            }
            else
            {
                $empresa = '';
                $conEmpresa = '';
                $gruCodEmpresa = '';
                $gruNomEmpresa = '';
            }

            if (isset($chkRegional))
            {
                $banRegional = true;
                if (isset($codigoRegion))
                {
                    $regionalCodigo = ',CENTRO_REGIONAL_ID_REGIONAL AS CODIGO_REGIONAL';
                    $regionalNombre = ',NOMBREREGIONAL AS NOMBRE_REGIONAL';
                    $gruCodRegional = ',CENTRO_REGIONAL_ID_REGIONAL';
                    $gruNomRegional = ',NOMBREREGIONAL';

                    if (count($codigoRegion) > 1)
                    {
                        $conRegional = ' AND (';
                        for ($i = 0; $i < count($codigoRegion); $i++)
                        {
                            $conRegional .= " CENTRO_REGIONAL_ID_REGIONAL = $codigoRegion[$i] OR";
                        }
                        $conRegional = substr($conRegional, 0, -2);
                        $conRegional .= ' )';
                    }
                    else
                    {
                        $conRegional = " AND  CENTRO_REGIONAL_ID_REGIONAL = $codigoRegion[0] ";
                    }
                }
                else
                {
                    $regionalCodigo = '';
                    $regionalNombre = '';
                    $conRegional = '';
                    $gruCodRegional = '';
                    $gruNomRegional = '';
                }
            }
            else
            {
                $regionalCodigo = '';
                $regionalNombre = '';
                $conRegional = '';
                $gruCodRegional = '';
                $gruNomRegional = '';
            }

            if (isset($chkCentro))
            {
                $banCentro = true;
                if (isset($codigoCentro))
                {
                    $centroCodigo = ',SUBSTR(CENTRO_ID_CENTRO,0,4) AS CODIGO_CENTRO';
                    $centroNombre = ',NOMBRECENTRO AS NOMBRE_CENTRO';
                    $gruCodCentro = ',CENTRO_ID_CENTRO';
                    $gruNomCentro = ',NOMBRECENTRO';

                    if (count($codigoCentro) > 1)
                    {
                        $conCentro = ' AND (';
                        for ($i = 0; $i < count($codigoCentro); $i++)
                        {
                            $conCentro .= " SUBSTR(CENTRO_ID_CENTRO,0,4) = $codigoCentro[$i] OR";
                        }
                        $conCentro = substr($conCentro, 0, -2);
                        $conCentro .= ' )';
                    }
                    else
                    {
                        $conCentro = " AND SUBSTR(CENTRO_ID_CENTRO,0,4) = $codigoCentro[0] ";
                    }
                }
                else
                {
                    $centroCodigo = '';
                    $centroNombre = '';
                    $conCentro = '';
                    $gruCodCentro = '';
                    $gruNomCentro = '';
                }
            }
            else
            {
                $centroCodigo = '';
                $centroNombre = '';
                $conCentro = '';
                $gruCodCentro = '';
                $gruNomCentro = '';
            }

            if (isset($chkMesa))
            {
                $banMesa = true;
                if (isset($codigoMesa))
                {
                    $mesaCodigo = ',CODIGOOCUPACION AS CODIGO_MESA';
                    $mesaNombre = ',NOMBREOCUPACION AS NOMBRE_MESA';
                    $gruCodMesa = ',CODIGOOCUPACION';
                    $gruNomMesa = ',NOMBREOCUPACION';

                    if (count($codigoMesa) > 1)
                    {
                        $conMesa = ' AND (';
                        for ($i = 0; $i < count($codigoMesa); $i++)
                        {
                            $conMesa .= " CODIGOOCUPACION = $codigoMesa[$i] OR";
                        }
                        $conMesa = substr($conMesa, 0, -2);
                        $conMesa .= ' )';
                    }
                    else
                    {
                        $conMesa = " AND CODIGOOCUPACION = $codigoMesa[$i] ";
                    }
                }
                else
                {
                    $mesaCodigo = '';
                    $mesaNombre = '';
                    $conMesa = '';
                    $gruCodMesa = '';
                    $gruNomMesa = '';
                }
            }
            else
            {
                $mesaCodigo = '';
                $mesaNombre = '';
                $conMesa = '';
                $gruCodMesa = '';
                $gruNomMesa = '';
            }

            if (isset($chkNorma))
            {
                $banNorma = true;
                if (isset($codigoNorma))
                {
                    $normaCodigo = ',SALIDA_CODIGO AS CODIGO_NORMA';
                    $normaNombre = ',NOMBRESALIDA AS NOMBRE_NORMA';
                    $gruCodNorma = ',SALIDA_CODIGO';
                    $gruNomNorma = ',NOMBRESALIDA';

                    if (count($codigoNorma) > 1)
                    {
                        $conNorma = ' AND (';
                        for ($i = 0; $i < count($codigoNorma); $i++)
                        {
                            $conNorma .= " SALIDA_CODIGO = $codigoNorma[$i] OR";
                        }
                        $conNorma = substr($conNorma, 0, -2);
                        $conNorma .= ' )';
                    }
                    else
                    {
                        $conNorma = " AND SALIDA_CODIGO = $codigoNorma[0] ";
                    }
                }
                else
                {
                    $normaCodigo = '';
                    $normaNombre = '';
                    $conNorma = '';
                    $gruCodNorma = '';
                    $gruNomNorma = '';
                }
            }
            else
            {

                $normaCodigo = '';
                $normaNombre = '';
                $conNorma = '';
                $gruCodNorma = '';
                $gruNomNorma = '';
            }

            echo $consulta = 'SELECT'
                    . "  TO_CHAR(FECHA_REGISTRO, 'YYYY') AS PERIODO"
                    . $empresa
                    . $regionalCodigo
                    . $regionalNombre
                    . $centroCodigo
                    . $centroNombre
                    . $mesaCodigo
                    . $mesaNombre
                    . $normaCodigo
                    . $normaNombre
                    . '  ,COUNT(*) AS CERTIFICACIONES_EXPEDIDAS'
                    . '  ,COUNT(DISTINCT NROIDENT) AS PERSONAS_CERTIFICADAS '
                    . 'FROM T_HISTORICO '
                    . "WHERE TIPO_CERTIFICADO = 'NC'"
                    . "  AND TIPO_ESTADO = 'CERTIFICA'"
                    . $conPeriodo
                    . $conEmpresa
                    . $conRegional
                    . $conCentro
                    . $conMesa
                    . $conNorma
                    . "GROUP BY TO_CHAR(FECHA_REGISTRO, 'YYYY')"
                    . $gruCodEmpresa
                    . $gruNomEmpresa
                    . $gruCodRegional
                    . $gruNomRegional
                    . $gruCodCentro
                    . $gruNomCentro
                    . $gruCodMesa
                    . $gruNomMesa
                    . $gruCodNorma
                    . $gruNomNorma
                    . " ORDER BY TO_CHAR(FECHA_REGISTRO, 'YYYY') DESC";

            $objHistorico = oci_parse($connection, $consulta);
            oci_execute($objHistorico);
            $numRows = oci_fetch_all($objHistorico, $row);

            var_dump($row);
            var_dump($numRows);
            ?>
            <tr style=' background: gray; color: white;'>
                <th>Periodo</th>
                <?php if ($banEmpresa) : ?>
                    <th>Nit Empresa</th>
                    <th>Nombre Empresa</th>
                <?php endif; ?>
                <?php if ($banRegional) : ?>
                    <th>Codigo Regional</th>
                    <th>Nombre Regional</th>
                <?php endif; ?>
                <?php if ($banCentro) : ?>
                    <th>Codigo Centro</th>
                    <th>Nombre Centro</th>
                <?php endif; ?>
                <?php if ($banMesa) : ?>
                    <th>Codigo Mesa</th>
                    <th>Nombre Mesa</th>
                <?php endif; ?>
                <?php if ($banNorma) : ?>
                    <th>Codigo Norma</th>
                    <th>Nombre Norma</th>
                <?php endif; ?>
                <th>Certificaciones Expedidas</th>
                <th>Personas Certificadas</th>
            </tr>
            <?php
            for ($i = 0; $i < $numRows; $i++)
            {
                ?>
                <tr style = "background-color:<?php echo $fondo ?>;">
                    <td><?php echo $row['PERIODO'][$i]; ?></td>
                    <?php if ($banEmpresa) : ?>
                        <td><?php echo $row['NIT_EMPRESA'][$i]; ?></td>
                        <td><?php echo $row['NOMBRE_EMPRESA'][$i]; ?></td>
                    <?php endif; ?>
                    <?php if ($banRegional) : ?>
                        <td><?php echo $row['CODIGO_REGIONAL'][$i]; ?></td>
                        <td><?php echo $row['NOMBRE_REGIONAL'][$i]; ?></td>
                    <?php endif; ?>
                    <?php if ($banCentro) : ?>
                        <td><?php echo $row['CODIGO_CENTRO'][$i]; ?></td>
                        <td><?php echo $row['NOMBRE_CENTRO'][$i]; ?></td>
                    <?php endif; ?>
                    <?php if ($banMesa) : ?>
                        <td><?php echo $row['CODIGO_MESA'][$i]; ?></td>
                        <td><?php echo $row['NOMBRE_MESA'][$i]; ?></td>
                    <?php endif; ?>
                    <?php if ($banNorma) : ?>
                        <td><?php echo $row['CODIGO_NORMA'][$i]; ?></td>
                        <td><?php echo $row['NOMBRE_NORMA'][$i]; ?></td>
                    <?php endif; ?>
                    <td><?php echo $row['CERTIFICACIONES_EXPEDIDAS'][$i]; ?></td>
                    <td><?php echo $row['PERSONAS_CERTIFICADAS'][$i]; ?></td>
                </tr>
                <?php
            }
            ?>
        </table>
    </body>
</html>