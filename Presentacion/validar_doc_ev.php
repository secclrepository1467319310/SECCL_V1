<?php
include("../Clase/conectar.php");
$connection = conectar($bd_host, $bd_usuario, $bd_pwd);


$documento = $_GET["doc"];
$proyecto=$_GET["proyecto"];

$query1 = ("SELECT ID_EVALUADOR FROM EVALUADOR WHERE DOCUMENTO='$documento'  ");
$statement1 = oci_parse($connection, $query1);
$resp1 = oci_execute($statement1);
$id = oci_fetch_array($statement1, OCI_BOTH);
$query2 = ("SELECT EMAIL FROM EVALUADOR WHERE DOCUMENTO='$documento'  ");
$statement2 = oci_parse($connection, $query2);
$resp2 = oci_execute($statement2);
$email = oci_fetch_array($statement2, OCI_BOTH);
$query3 = ("SELECT NOMBRE FROM EVALUADOR WHERE DOCUMENTO='$documento' ");
$statement3 = oci_parse($connection, $query3);
$resp3 = oci_execute($statement3);
$nombre = oci_fetch_array($statement3, OCI_BOTH);
//$query4 = ("SELECT NOMBRE FROM EVALUADOR WHERE DOCUMENTO='$documento'  ");
//$statement4 = oci_parse($connection, $query4);
//$resp4 = oci_execute($statement4);
//$papellido = oci_fetch_array($statement4, OCI_BOTH);
$query5 = ("SELECT ESTADO_EVALUADOR FROM EVALUADOR WHERE DOCUMENTO='$documento'  ");
$statement5 = oci_parse($connection, $query5);
$resp5 = oci_execute($statement5);
$estado = oci_fetch_array($statement5, OCI_BOTH);
//$query7 = ("SELECT NOMBRE FROM EVALUADOR WHERE DOCUMENTO='$documento' ");
//$statement7 = oci_parse($connection, $query7);
//$resp7 = oci_execute($statement7);
//$sapellido = oci_fetch_array($statement7, OCI_BOTH);




?>
<script type="text/javascript">
    window.location="../Presentacion/evaluadores_proyecto_c.php?proyecto=<?php echo $proyecto?>&estado=<?php echo $estado[0] ?>&email=<?php echo $email[0] ?>&id=<?php echo $id[0] ?>&documento=<?php echo $documento ?>&nombre=<?php echo $nombre[0] ?>";
</script>