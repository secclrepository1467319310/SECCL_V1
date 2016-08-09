<?php
include("../Clase/conectar.php");
$connection = conectar($bd_host, $bd_usuario, $bd_pwd);


$nit = $_GET["nit"];
$poa=$_GET["poa"];

$query6 = ("SELECT nombre_empresa FROM empresas_sistema WHERE nit_empresa='$nit'");
$statement6 = oci_parse($connection, $query6);
$resp6 = oci_execute($statement6);
$mesa = oci_fetch_array($statement6, OCI_BOTH);

$query7 = ("SELECT sigla_empresa FROM empresas_sistema WHERE nit_empresa='$nit'");
$statement7 = oci_parse($connection, $query7);
$resp7 = oci_execute($statement7);
$sigla = oci_fetch_array($statement7, OCI_BOTH);



if ($mesa[0] == null) {

    $nombre = 'Empresa no Registrada';
} else {

    $nombre = $mesa[0];
}

if ($sigla[0] == null) {

    $s = 'Sin sigla';
} else {

    $s = $sigla[0];
}

?>
<script type="text/javascript">
    window.location = "../Presentacion/proyecto_nacional.php?plan=<?php echo $poa?>&nit=<?php echo $nit ?>&empresa=<?php echo $nombre ?>&sigla=<?php echo $s ?>";
</script>