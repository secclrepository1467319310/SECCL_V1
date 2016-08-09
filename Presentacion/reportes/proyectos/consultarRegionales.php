<?php

include("../../../Clase/conectar.php");
//include ("conectar.php");
$connection = conectar($bd_host, $bd_usuario, $bd_pwd);

$sentencia = oci_parse($connection, 'SELECT CODIGO_REGIONAL,NOMBRE_REGIONAL FROM REGIONAL ORDER BY NOMBRE_REGIONAL');
$respuesta = oci_execute($sentencia);
$consulta = oci_fetch_all($sentencia, $argRegional);

$array[] = $argRegional['CODIGO_REGIONAL'];
for ($i = 0; $i < count($argRegional['NOMBRE_REGIONAL']); $i++)
{
     $utf8[$i] = utf8_encode($argRegional['NOMBRE_REGIONAL'][$i]);
}
$array[1] = $utf8;
echo json_encode($array);



