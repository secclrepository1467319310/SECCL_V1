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

$insertProyectoNacional = "UPDATE T_PROYECTOS_NACIONALES 
    SET
        DESCRIPCION = '$descripcion',
        NOMBRE_CONTACTO = '$nombre_contacto',
        TELEFONO_CONTACTO = '$telefono_contacto',
        CECULAR_CONTACTO = '$celular_contacto',
        EMAIL_CONTACTO = '$email_contacto',
        PRESUPUESTO_SENA = '$presupuesto_sena',
        PRESUPUESTO_ENTIDAD_EXTERNA = '$presupuesto_entidad',
        NUMERO_TOTAL_CANDIDATOS = '$numero_total_candidatos',
        DESC_PRO_REGIONAL = '$desc_pro_regional' 
        WHERE ID_PROYECTO_NACIONAL = '$proNac'"
        ;

$objParseProyectoNacional = oci_parse($objConnect, $insertProyectoNacional);
$objExecute = oci_execute($objParseProyectoNacional);

if ($objExecute) {
    oci_commit($objConnect);
} else {
    oci_rollback($objConnect);
    $e = oci_error($objParse);
}

oci_close($objConnect);
?>
<script type="text/javascript">
    window.location = "../Presentacion/ver_proyectos_nacionales.php";
</script>