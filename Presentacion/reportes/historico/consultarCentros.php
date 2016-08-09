<?php

include("../../../Clase/conectar.php");
//include ("conectar.php");
$connection = conectar($bd_host, $bd_usuario, $bd_pwd);
//$_POST['chkRegional']=TRUE;
//$_POST['codigoRegion']=array(
//    1,5
//);
if (isset($_POST['chkRegional']))
{
    $cont = 0;
    for ($i = 0; $i < count($_POST['codigoRegion']); $i++)
    {
        $sql = 'SELECT CODIGO_CENTRO,NOMBRE_CENTRO FROM CENTRO WHERE CODIGO_REGIONAL=' . $_POST['codigoRegion'][$i] . ' ORDER BY NOMBRE_CENTRO';
        $sentencia = oci_parse($connection, $sql);
        $respuesta = oci_execute($sentencia);
        $consulta = oci_fetch_all($sentencia, $argCentro);

        for ($j = 0; $j < count($argCentro['NOMBRE_CENTRO']); $j++)
        {
            $array[0][$cont] = $argCentro['CODIGO_CENTRO'][$j];
            $array[1][$cont] = utf8_encode($argCentro['NOMBRE_CENTRO'][$j]);
            $cont++;
        }
    }
}
else
{
    $sql = 'SELECT CODIGO_CENTRO,NOMBRE_CENTRO FROM CENTRO ORDER BY NOMBRE_CENTRO';
    $sentencia = oci_parse($connection, $sql);
    $respuesta = oci_execute($sentencia);
    $consulta = oci_fetch_all($sentencia, $argCentro);
    
    $array[0] = $argCentro['CODIGO_CENTRO'];
    for ($i = 0; $i < count($argCentro['NOMBRE_CENTRO']); $i++)
    {
        $utf8[$i] = utf8_encode($argCentro['NOMBRE_CENTRO'][$i]);
    }
    $array[1] = $utf8;
}


echo json_encode($array);

