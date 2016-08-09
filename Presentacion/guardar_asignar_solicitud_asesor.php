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
var_dump($_POST);

extract($_POST);
$txt="";
$solicitudes = substr($solicitudes, 0, -1);

$solicitudes = explode(",", $solicitudes);



foreach ($solicitudes as $valor) {
    
    $queryUpdate = "UPDATE T_SOLICITUDES_ASIGNADAS SET ESTADO = '0'
        WHERE ID_SOLICITUD = $valor";
    
    $statementUpdate = oci_parse($objConnect, $queryUpdate);
    $objExecuteUpdate = oci_execute($statementUpdate);
    if ($objExecuteUpdate) {
        oci_commit($objConnect); //*** Commit Transaction ***//
    } else {
        oci_rollback($objConnect); //*** RollBack Transaction ***//
        $e = oci_error($statementUpdate);
    }
    
    $query = "INSERT INTO T_SOLICITUDES_ASIGNADAS(
    ID_SOLICITUD,
    USUARIO_ASIGNADO,
    ID_USUARIO_REGISTRO,
    OBSERVACION,
    ESTADO
    ) VALUES(
    '$valor',
    '$radEncargado',
    '$_SESSION[USUARIO_ID]',
    '$txt',
    '1'
    )";
    $statement = oci_parse($objConnect, $query);
    $objExecute = oci_execute($statement);
    if ($objExecute) {
        oci_commit($objConnect); //*** Commit Transaction ***//
    } else {
        oci_rollback($objConnect); //*** RollBack Transaction ***//
        $e = oci_error($statement);
    }
}


header('Location: solicitudes_b.php');


