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

$documento = $_POST['txtDocumento'];
$nombres = $_POST["nombres"];
$ip = $_POST["ip"];
$celular = $_POST["celular"];
$email = $_POST["email"];
$email2 = $_POST["email2"];
$obs = $_POST["obs"];

$strSQL1 = "UPDATE EVALUADOR SET
        NOMBRE = '$nombres',
        IP = '$ip',
        CELULAR = '$celular',
        EMAIL = '$email',
        EMAIL2 = '$email2',
        OBS = '$obs',
        ESTADO_EVALUADOR = '3'
        WHERE DOCUMENTO = '$documento'";

$objParse1 = oci_parse($connection, $strSQL1);
$objExecute1 = oci_execute($objParse1, OCI_DEFAULT);
if ($objExecute1) {
    oci_commit($connection);
} else {
    oci_rollback($connection);
    $e = oci_error($objParse1);
    echo "Error Save [" . $e['message'] . "]";
}

oci_close($connection);

echo("<SCRIPT>window.alert(\"Registro Exitoso\")</SCRIPT>");
?>
<script type="text/javascript">
    window.location = "../Presentacion/evaluadores_c.php";
</script>