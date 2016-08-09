<?php

include("../../../Clase/conectar.php");
//include ("conectar.php");
$connection = conectar($bd_host, $bd_usuario, $bd_pwd);
//$_POST['chkRegional']=TRUE;
//$_POST['codigoRegion']=array(
//    1,5
//);
if (isset($_POST['chkMesa']))
{
    $cont = 0;
    for ($i = 0; $i < count($_POST['codigoMesa']); $i++)
    {
        $sql = 'SELECT CODIGO_NORMA,VERSION_NORMA,TITULO_NORMA FROM NORMA WHERE ACTIVA=1 AND CODIGO_MESA=' . $_POST['codigoMesa'][$i] . ' ORDER BY CODIGO_NORMA';
        $sentencia = oci_parse($connection, $sql);
        $respuesta = oci_execute($sentencia);
        $consulta = oci_fetch_all($sentencia, $argNorma);

        for ($j = 0; $j < count($argNorma['TITULO_NORMA']); $j++)
        {
            $array[0][$cont] = $argNorma['CODIGO_NORMA'][$j];
            $array[1][$cont] = $argNorma['VERSION_NORMA'][$j];
            $array[2][$cont] = utf8_encode($argNorma['TITULO_NORMA'][$j]);
            $cont++;
        }
    }
}
else
{
    $sql = 'SELECT CODIGO_NORMA,VERSION_NORMA,TITULO_NORMA FROM NORMA ORDER BY CODIGO_NORMA';
    $sentencia = oci_parse($connection, $sql);
    $respuesta = oci_execute($sentencia);
    $consulta = oci_fetch_all($sentencia, $argNorma);

    $array[0] = $argNorma['CODIGO_NORMA'];
    $array[1] = $argNorma['VERSION_NORMA'];
    for ($i = 0; $i < count($argNorma['TITULO_NORMA']); $i++)
    {
        $utf8[$i] = utf8_encode($argNorma['TITULO_NORMA'][$i]);
    }
    $array[2] = $utf8;
}


echo json_encode($array);