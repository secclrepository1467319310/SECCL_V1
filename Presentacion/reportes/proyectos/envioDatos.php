<?php
//header("Content-type: application/vnd.ms-excel");
//header("Content-Disposition: attachment; filename=Reporte.xls");
//header("Pragma: no-cache");
//header("Expires: 0");

include("../../../Clase/conectar.php");
$connection = conectar($bd_host, $bd_usuario, $bd_pwd);
$f = date('d/m/Y');
echo '<pre>';
var_dump($_POST);
echo '</pre>';
extract($_POST);
//realizamos la consulta
?>
<!DOCTYPE html PUBLIC “-//W3C//DTD XHTML 1.0 Transitional//EN” “http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd”>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>

        </title>
    </head>

    <body>
        <table width="641" border="1">
            <tr style=' background: gray; color: white;'>
                <th>Periodo</th>
                <th>Nit Empresa</th>
                <th>Nombre Empresa</th>
                <th>Codigo Regional</th>
                <th>Nombre Regional</th>
                <th>Codigo Centro</th>
                <th>Nombre Centro</th>
                <th>Codigo Mesa</th>
                <th>Nombre Mesa</th>
                <th>Codigo Norma</th>
                <th>Nombre Norma</th>
                <th>Certificaciones Expedidas</th>
                <th>Personas Certificadas</th>
            </tr>
            <?php
            if (isset($chkPeriodo))
            {
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
                $gruCodEmpresa = 'EMPRESA_NROIDENT,';
                $gruNomEmpresa = 'NOMBREEMPRESA,';

                if ($ddlEmpresa == '1')
                {
                    $empresa = '  CASE'
                            . "     WHEN EMPRESA_NROIDENT IS NULL THEN 'NO REGISTRA'"
                            . '     ELSE EMPRESA_NROIDENT END AS NIT_EMPRESA,'
                            . '  CASE'
                            . "     WHEN NOMBREEMPRESA IS NULL THEN 'NO REGISTRA'"
                            . '     ELSE NOMBREEMPRESA END AS NOMBRE_EMPRESA,';
                    $conEmpresa = '  AND EMPRESA_NROIDENT IS NOT NULL';
                }
                else if ($ddlEmpresa == '2')
                {
                    $empresa = '  CASE'
                            . "     WHEN EMPRESA_NROIDENT IS NULL THEN 'SENA'"
                            . '     ELSE EMPRESA_NROIDENT END AS NIT_EMPRESA,'
                            . '  CASE'
                            . "     WHEN NOMBREEMPRESA IS NULL THEN 'DEMANDA SOCIAL'"
                            . '     ELSE NOMBREEMPRESA END AS NOMBRE_EMPRESA,'
                            . '  CENTRO_REGIONAL_ID_REGIONAL AS CODIGO_REGIONAL,';
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
                if (isset($codigoRegion))
                {
                    $regionalCodigo = 'CENTRO_REGIONAL_ID_REGIONAL AS CODIGO_REGIONAL,';
                    $regionalNombre = 'NOMBREREGIONAL AS NOMBRE_REGIONAL,';
                    $gruCodRegional = 'CENTRO_REGIONAL_ID_REGIONAL,';
                    $gruNomRegional = 'NOMBREREGIONAL,';

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
                        $conRegional = " AND  CENTRO_REGIONAL_ID_REGIONAL = $codigoRegion[$i] ";
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
                if (isset($codigoCentro))
                {
                    $centroCodigo = 'SUBSTR(CENTRO_ID_CENTRO,0,4) AS CODIGO_CENTRO,';
                    $centroNombre = 'NOMBRECENTRO AS NOMBRE_CENTRO,';
                    $gruCodCentro = 'CENTRO_ID_CENTRO,';
                    $gruNomCentro = 'NOMBRECENTRO,';

                    if (count($codigoCentro) > 1)
                    {
                        $conCentro = ' AND (';
                        for ($i = 0; $i < count($codigoRegion); $i++)
                        {
                            $conCentro .= " CENTRO_ID_CENTRO = $codigoCentro[$i] OR";
                        }
                        $conCentro = substr($conCentro, 0, -2);
                        $conCentro .= ' )';
                    }
                    else
                    {
                        $conCentro = " AND CENTRO_ID_CENTRO = $codigoCentro[$i] ";
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
                if (isset($codigoMesa))
                {
                    $mesaCodigo = 'CODIGOOCUPACION AS CODIGO_MESA,';
                    $mesaNombre = 'NOMBREOCUPACION AS NOMBRE_MESA,';
                    $gruCodMesa = 'CODIGOOCUPACION,';
                    $gruNomMesa = 'NOMBREOCUPACION,';

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
                $mesaCodigo = '';
                $mesaNombre = '';
                $conMesa = '';
                $gruCodMesa = '';
                $gruNomMesa = '';
            }

            if (isset($chkNorma))
            {
                if (isset($codigoNorma))
                {
                    $normaCodigo = 'SALIDA_CODIGO AS CODIGO_NORMA,';
                    $normaNombre = 'NOMBRESALIDA AS NOMBRE_NORMA,';
                    $gruCodNorma = 'SALIDA_CODIGO,';
                    $gruNomNorma = '  NOMBRESALIDA';

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
                        $conNorma = " AND SALIDA_CODIGO = $codigoNorma[$i] ";
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
                $normaCodigo = '';
                $normaNombre = '';
                $conNorma = '';
                $gruCodNorma = '';
                $gruNomNorma = '';
            }

            echo $consulta = '<br>' . 'SELECT'
            . '<br>' . "  TO_CHAR(FECHA_REGISTRO, 'YYYY') AS PERIODO,"
            . '<br>' . $empresa
            . '<br>' . $regionalCodigo
            . '<br>' . $regionalNombre
            . '<br>' . $centroCodigo
            . '<br>' . $centroNombre
            . '<br>' . $mesaCodigo
            . '<br>' . $mesaNombre
            . '<br>' . $normaCodigo
            . '<br>' . $normaNombre
            . '<br>' . '  COUNT(*) AS CERTIFICACIONES_EXPEDIDAS,'
            . '<br>' . '  COUNT(DISTINCT NROIDENT) AS PERSONAS_CERTIFICADAS '
            . '<br>' . 'FROM T_HISTORICO '
            . '<br>' . "WHERE TIPO_CERTIFICADO = 'NC'"
            . '<br>' . "  AND TIPO_ESTADO = 'CERTIFICA'"
            . '<br>' . $conPeriodo
            . '<br>' . $conEmpresa
            . '<br>' . $conRegional
            . '<br>' . $conCentro
            . '<br>' . $conMesa
            . '<br>' . $conNorma
            . '<br>' . "GROUP BY TO_CHAR(FECHA_REGISTRO, 'YYYY'),"
            . '<br>' . $gruCodEmpresa
            . '<br>' . $gruNomEmpresa
            . '<br>' . $gruCodRegional
            . '<br>' . $gruNomRegional
            . '<br>' . $gruCodCentro
            . '<br>' . $gruNomCentro
            . '<br>' . $gruCodMesa
            . '<br>' . $gruNomMesa
            . '<br>' . $gruCodNorma
            . '<br>' . $gruNomNorma;
            ?>
        </table>
    </body>
</html>