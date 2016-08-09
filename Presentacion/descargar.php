<?php

include("../Clase/conectar.php");
$connection = conectar($bd_host, $bd_usuario, $bd_pwd);
$id = $_GET[id];
$query3 = ("SELECT HVIDA FROM EVALUADOR_PROYECTO WHERE ID_EVALUADOR='$id'");
$statement3 = oci_parse($connection, $query3);
$resp = oci_execute($statement3);
$r = oci_fetch_array($statement3, OCI_BOTH);
$ruta=$r[0];

// Permite la descarga de un archivo ocultando su ruta

$c = substr($ruta, 14, 1000);
$nombre = $c;
$filename = "hoja/$nombre";
$size = filesize($filename);
header("Content-Transfer-Encoding: binary");
header("Content-type: application/force-download");
header("Content-Disposition: attachment; filename=$nombre");
header("Content-Length: $size");
readfile("$filename");

?> 