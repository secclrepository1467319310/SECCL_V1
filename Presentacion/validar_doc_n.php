<?php
include("../Clase/conectar.php");
$connection = conectar($bd_host, $bd_usuario, $bd_pwd);


$documento = $_GET["doc"];
$proyecto=$_GET["proyecto"];

$query1 = ("SELECT USUARIO_ID FROM USUARIO WHERE DOCUMENTO='$documento'");
$statement1 = oci_parse($connection, $query1);
$resp1 = oci_execute($statement1);
$id = oci_fetch_array($statement1, OCI_BOTH);
$query3 = ("SELECT NOMBRE FROM USUARIO WHERE DOCUMENTO='$documento'");
$statement3 = oci_parse($connection, $query3);
$resp3 = oci_execute($statement3);
$nombre = oci_fetch_array($statement3, OCI_BOTH);
$query4 = ("SELECT PRIMER_APELLIDO FROM USUARIO WHERE DOCUMENTO='$documento'");
$statement4 = oci_parse($connection, $query4);
$resp4 = oci_execute($statement4);
$papellido = oci_fetch_array($statement4, OCI_BOTH);
$query7 = ("SELECT SEGUNDO_APELLIDO FROM USUARIO WHERE DOCUMENTO='$documento'");
$statement7 = oci_parse($connection, $query7);
$resp7 = oci_execute($statement7);
$sapellido = oci_fetch_array($statement7, OCI_BOTH);

echo $id;


?>
<script type="text/javascript">
    window.location="../Presentacion/candidatos_proyecto_n.php?proyecto=<?php echo $proyecto?>&id=<?php echo $id[0] ?>&documento=<?php echo $documento ?>&nombre=<?php echo $nombre[0] ?>&apellido=<?php echo $papellido[0] ?>&apellido2=<?php echo $sapellido[0] ?>";
</script>