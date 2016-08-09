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

for ($i = 0;$i < count($normasProNac);$i++){
    
    $insert = "INSERT INTO T_NOR_PRO_NAC_EST(
    ID_DETALLES_POA,
    ESTADO,
    ID_USU_REGISTRO
    ) VALUES(
    '$normasProNac[$i]',
    '1',
    '$_SESSION[USUARIO_ID]'
    )";

    $objParse = oci_parse($objConnect, $insert);
    $objExecute = oci_execute($objParse);
}

header('location: cons_normas_proyecto_c.php?proyecto=' . $proyecto . '&proNac=1');
