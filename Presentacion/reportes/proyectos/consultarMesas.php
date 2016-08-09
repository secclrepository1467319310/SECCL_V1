<?php

include("../../../Clase/conectar.php");
//include ("conectar.php");
$connection = conectar($bd_host, $bd_usuario, $bd_pwd);

$sentencia = oci_parse($connection, 'SELECT CODIGO_MESA,NOMBRE_MESA FROM MESA ORDER BY NOMBRE_MESA');
$respuesta = oci_execute($sentencia);
$consulta = oci_fetch_all($sentencia, $argMesa);

$array[] = $argMesa['CODIGO_MESA'];
for ($i = 0; $i < count($argMesa['NOMBRE_MESA']); $i++)
{
     $utf8[$i] = utf8_encode($argMesa['NOMBRE_MESA'][$i]);
}
$array[1] = $utf8;
echo json_encode($array);