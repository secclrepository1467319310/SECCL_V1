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

$aud = $_GET["ida"];
$es = $_GET["es"];
$f = date("d/m/Y");


$strSQL = "UPDATE APOYOS SET ESTADO='$es' WHERE DOCUMENTO=$aud";

$objParse = oci_parse($connection, $strSQL);
$objExecute = oci_execute($objParse, OCI_DEFAULT);


if ($objExecute) {
    oci_commit($connection); //*** Commit Transaction ***//
} else {
    oci_rollback($connection); //*** RollBack Transaction ***//
    $e = oci_error($objParse);
    echo "Error Save [" . $e['message'] . "]";
}

$insertEvaluadorRegistro = "INSERT INTO T_REGISTRO_ACTIVAR_ACTORES(
    DOCUMENTO,
    USU_REGISTRO,
    ESTADO,
    ID_ROL)
    VALUES(
    '$aud',
    '$_SESSION[USUARIO_ID]',
    '$es',
    '11')";

$objParseinsert = oci_parse($connection, $insertEvaluadorRegistro);
$objExecuteinsert = oci_execute($objParseinsert, OCI_DEFAULT);

if ($objExecuteinsert) {
    oci_commit($connection);
} else {
    oci_rollback($connection);
    $e = oci_error($objParse1);
    echo "Error Save [" . $e['message'] . "]";
}

oci_close($connection);
?>

<script type="text/javascript">
    //window.location = "../Presentacion/apoyos_regionales.php";
</script>