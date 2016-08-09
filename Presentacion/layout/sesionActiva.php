<?php
require_once('../Clase/conectar.php');
$conexion=conectar($bd_host,$bd_usuario,$bd_pwd);
$query = "SELECT USU.NOMBRE, USU.PRIMER_APELLIDO, USU.SEGUNDO_APELLIDO, RO.DESCRIPCION FROM USUARIO USU INNER JOIN ROL RO ON USU.ROL_ID_ROL = RO.ID_ROL WHERE USUARIO_ID = $id";
$result = ociparse($conexion, $query);
ociexecute($result);
$row = oci_fetch_array($result, OCI_BOTH);

echo $row['NOMBRE'] . " " . $row['PRIMER_APELLIDO'] . " " . $row['SEGUNDO_APELLIDO'] . " - " . utf8_encode($row['DESCRIPCION']);
?>
