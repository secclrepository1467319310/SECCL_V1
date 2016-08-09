<?php
include("../Clase/conectar.php");

$connection = conectar($bd_host, $bd_usuario, $bd_pwd);

$nit = $_GET["nit"];

$query6 = ("SELECT nombre_empresa FROM empresas_sistema WHERE nit_empresa='$nit'");
$statement6 = oci_parse($connection, $query6);
$resp6 = oci_execute($statement6);
$mesa = oci_fetch_array($statement6, OCI_BOTH);

if ($mesa[0] == null) {

    $nombre = 'Empresa no Registrada';
} else {

    $nombre = $mesa[0];
}

?>
<script type="text/javascript">
    window.location = "../index.php?nit=<?php echo $nit ?>&empresa=<?php echo $nombre ?>";
</script>