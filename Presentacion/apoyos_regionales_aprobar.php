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

extract($_POST);

for ($i = 0; $i < count($chkAprobado); $i++) {

    $strSQL1 = "INSERT INTO T_MISIONAL_APOYO_APROB
        (DOCUMENTO_APOYO,
        USU_REGISTRO)
        VALUES 
        ('$chkAprobado[$i]','$id') ";

    $objParse1 = oci_parse($connection, $strSQL1);
    $objExecute1 = oci_execute($objParse1, OCI_DEFAULT);
    if ($objExecute1) {
        oci_commit($connection); //*** Commit Transaction ***//
    } else {
        oci_rollback($connection); //*** RollBack Transaction ***//
        $e = oci_error($objParse1);
        echo "Error Save [" . $e['message'] . "]";
    }
}

oci_close($connection);


echo("<SCRIPT>window.alert(\"Registro Exitoso\")</SCRIPT>");
?>
<script type="text/javascript">
    //window.location = "../Presentacion/apoyos_regionales.php";
</script>