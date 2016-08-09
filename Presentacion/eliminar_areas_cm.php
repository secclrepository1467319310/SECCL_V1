<?php
session_start();
if ($_SESSION['logged'] == 'yes') {
    $nom = $_SESSION["NOMBRE"];
    $ape = $_SESSION["PRIMER_APELLIDO"];
    $id = $_SESSION["USUARIO_ID"];
} else {
    echo '<script>window.location = "../index.php"</script>';
}

include("../Clase/conectar.php");
$connection = conectar($bd_host, $bd_usuario, $bd_pwd);

$idarea = $_GET["idarea"];
$iddeta = $_GET["iddeta"];
$centro = $_GET["centro"];

$strSQL = "delete from areas_claves_centro where id_areas_centro='$iddeta'";

$objParse = oci_parse($connection, $strSQL);
$objExecute = oci_execute($objParse, OCI_DEFAULT);
if ($objExecute) {
    oci_commit($connection); //*** Commit Transaction ***//
} else {
    oci_rollback($connection); //*** RollBack Transaction ***//
    $e = oci_error($objParse);
    echo "Error Save [" . $e['message'] . "]";
}

$deleteAreaActa = "DELETE FROM T_AREAS_CLAVES_ACTAS WHERE ID_ACTAS_CLAVES_ACTAS='$iddeta'";
$objParse = oci_parse($connection, $deleteAreaActa);
$objExecute = oci_execute($objParse, OCI_DEFAULT);
if ($objExecute) {
    oci_commit($connection); //*** Commit Transaction ***//
} else {
    oci_rollback($connection); //*** RollBack Transaction ***//
    $e = oci_error($objParse);
    echo "Error Save [" . $e['message'] . "]";
}

oci_close($connection);
?>

<script type="text/javascript">
    window.location = "../Presentacion/consultar_areas.php?centro=<?php echo $centro ?>&idarea=<?php echo $idarea ?>";
</script>
