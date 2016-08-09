<?php

include("../Clase/conectar.php");
$connection = conectar($bd_host, $bd_usuario, $bd_pwd);
$id = $_GET[id];
$query3 = ("SELECT SOPORTE FROM RESPUESTA_AREAS_CLAVES WHERE ID_RESPUESTA='$id'");
$statement3 = oci_parse($connection, $query3);
$resp = oci_execute($statement3);
$r = oci_fetch_array($statement3, OCI_BOTH);
$ruta=$r[0];

// Permite la descarga de un archivo ocultando su ruta

$c = substr($ruta, 7, 1000);
$nombre = $c;
$filename = "onbase/$nombre";
$size = filesize($filename);
header("Content-Transfer-Encoding: binary");
header("Content-type: application/force-download");
header("Content-Disposition: attachment; filename=$nombre");
header("Content-Length: $size");
readfile("$filename");

?> 