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

$idarea = $_POST["idarea"];
$iddeta = $_POST["deta"];
$obs = $_POST["obs"];
$estado = $_POST["estado"];
$centro = $_GET['centro'];
$fecha = date('d/m/Y');

$strSQL = "UPDATE areas_claves_centro SET obs_asesor='$obs',aprobado_asesor='$estado' WHERE ID_AREAS_CENTRO='$iddeta'";

$objParse = oci_parse($connection, $strSQL);
$objExecute = oci_execute($objParse, OCI_DEFAULT);
if ($objExecute) {
    oci_commit($connection); //*** Commit Transaction ***//
} else {
    oci_rollback($connection); //*** RollBack Transaction ***//
    $e = oci_error($objParse);
    echo "Error Save [" . $e['message'] . "]";
}
ECHO $IDAREA[0];
//Insert historico
$strSQL2 = "INSERT INTO HISTORICO_AREAS_CLAVES (ID_AREA,ID_DETA,OBS_ASESOR,FECHA_OBS_ASESOR,APROBADO_ASESOR) VALUES ('$idarea','$iddeta','$obs','$fecha',$estado)";

$objParse2 = oci_parse($connection, $strSQL2);
$objExecute2 = oci_execute($objParse2, OCI_DEFAULT);
if ($objExecute2) {
    oci_commit($connection); //*** Commit Transaction ***//
    header("location:aprobar_area_a.php?id_area_centro=$iddeta&mensaje=1");
} else {
    oci_rollback($connection); //*** RollBack Transaction ***//
    $e = oci_error($objParse2);
    echo "Error Save [" . $e['message'] . "]";
}
oci_close($connection);


