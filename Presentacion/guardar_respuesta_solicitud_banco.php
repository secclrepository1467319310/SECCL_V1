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

echo $query = "INSERT INTO T_ESTADO_SOLICITUD(
    ID_TIPO_ESTADO_SOLICITUD,
    DETALLE,
    USUARIO_ID,
    ID_SOLICITUD,
    CODIGO_INSTRUMENTO
    ) VALUES(
    '$ddlEstado',
    '$txtDetalles',
    '$_SESSION[USUARIO_ID]',
    '$hidIdSolicitud',
    '$codigo_instrumento'
    )";
$statement = oci_parse($objConnect, $query);
$resp = oci_execute($statement);

if ($resp) {
    oci_commit($objConnect); //*** Commit Transaction ***//
    header('Location: ver_solicitudes_banco.php');
} else {
    oci_rollback($objConnect); //*** RollBack Transaction ***//
    $e = oci_error($statement);
}




