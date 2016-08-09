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
$conexion = conectar($bd_host, $bd_usuario, $bd_pwd);

extract($_POST);

$sqlInscripcion = "SELECT * FROM T_INSCRIPCION_OFERTA IO "
        . "INNER JOIN T_NORMAS_OFERTADAS NOF "
        . "ON IO.ID_OFERTA = NOF.ID_OFERTA "
        . "WHERE IO.NUMERO_DOCUMENTO = $nro_cedula AND NOF.CODIGO_OFERTA = $oferta";
$parseInscripcion = oci_parse($conexion, $sqlInscripcion);
oci_execute($parseInscripcion);
$numRowsInscripcion = oci_fetch_all($parseInscripcion, $rowsInscripcion);

if ($numRowsInscripcion >= 1) {
    header("location:validar_inscripcion.php?mensaje=1&id_oferta=$id_oferta");
} else {
    header("location:inscribirse_oferta.php?documento=$nro_cedula&id_oferta=$id_oferta");
}

