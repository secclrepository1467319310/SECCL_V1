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
$id_proyecto = $_POST['proyecto'];
$queryProyecto = ("SELECT ID_ESTADO_PROYECTO FROM PROYECTO WHERE ID_PROYECTO='$id_proyecto'");
$statementProyecto = oci_parse($connection, $queryProyecto);
oci_execute($statementProyecto);
$proyecto = oci_fetch_array($statementProyecto, OCI_BOTH);

if ($proyecto['ID_ESTADO_PROYECTO'] == 4) {
    $estado = 1;
} else if ($proyecto['ID_ESTADO_PROYECTO'] == 1) {
    $estado = 4;
}

$sqlProyecto = "UPDATE PROYECTO 
        SET ID_ESTADO_PROYECTO=$estado
         WHERE ID_PROYECTO=$id_proyecto";
$objParseProyecto = oci_parse($connection, $sqlProyecto);
$objExecuteProyecto = oci_execute($objParseProyecto, OCI_DEFAULT);

//echo $sqlProyecto;

if ($objExecuteProyecto) {
    oci_commit($connection); //*** Commit Transaction ***//
    header("location: consulta_proyecto_aprobacion.php?proyecto=$id_proyecto");
} else {
    oci_rollback($connection); //*** RollBack Transaction ***//
    $e = oci_error($objExecuteProyecto);
}
?>