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
$objConnect = conectar($bd_host, $bd_usuario, $bd_pwd);

extract($_POST);

if($historia_vida == '' || $historia_vida == ' ' || $historia_vida == null){
    $historia_vida = 'No Aplica';
}

$strSQL = "UPDATE T_INFORME_CUALITATIVO_PROYECTO SET FORTALEZAS_CONOCIMIENTO = '$fort_conocimiento',DEBILIDADES_CONOCIMIENTO = '$deb_conocimiento',FORTALEZAS_DESEMPENO = '$fort_desempeno',
    DEBILIDADES_DESEMPENO = '$deb_desempeno',FORTALEZAS_PRODUCTO = '$fort_producto',DEBILIDADES_PRODUCTO = '$deb_producto',OPORT_MEJORA_PRODUCTIVO = '$opor_mejor_produc',
    ASPECT_MEJORA_PROC = '$asp_resal_produc',HISTORIA_VIDA = '$historia_vida',HISTORIA = '$historia' WHERE ID_INFORME = $id_informe";

$objParse = oci_parse($objConnect, $strSQL);
$objExecute = oci_execute($objParse, OCI_DEFAULT);

if ($objExecute) {
    oci_commit($objConnect); //*** Commit Transaction ***//
    header('location: listar_emision_ev.php?idplan='.$plan);
} else {
    oci_rollback($objConnect); //*** RollBack Transaction ***//
    $e = oci_error($objParse);
    echo "Error Guardando los datos";
}
oci_close($objConnect);
?>
