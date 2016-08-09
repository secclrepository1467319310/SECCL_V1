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

$strSQL = "INSERT INTO T_INFORME_CUALITATIVO_PROYECTO (FORTALEZAS_CONOCIMIENTO,DEBILIDADES_CONOCIMIENTO,FORTALEZAS_DESEMPENO,DEBILIDADES_DESEMPENO,FORTALEZAS_PRODUCTO,DEBILIDADES_PRODUCTO,OPORT_MEJORA_PRODUCTIVO,ASPECT_MEJORA_PROC,HISTORIA_VIDA,USUARIO_ID,ID_PLAN_EVIDENCIAS, HISTORIA)
        VALUES ('$fort_conocimiento','$deb_conocimiento','$fort_desempeno','$deb_desempeno','$fort_producto','$deb_producto','$opor_mejor_produc','$asp_resal_produc','$historia_vida',$id,$plan,$historia)";

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
