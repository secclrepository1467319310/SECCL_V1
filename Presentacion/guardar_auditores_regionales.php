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

$regional = $_POST["regional"];
$centro = 0;
$tdoc = $_POST["tdoc"];
$documento = $_POST["documento"];
$nombres = $_POST["nombres"];
$ip = $_POST["ip"];
$celular = $_POST["celular"];
$email = $_POST["email"];
$email2 = $_POST["email2"];
$certiaudi = $_POST["certiaudi"];
$numcerti = $_POST["num_certi"];
$fechacert = $_POST["fecha_certificado_1"];
$activo = $_POST["activo"];
$iso = $_POST["iso"];
$fechacerti = $_POST["fecha_certificado"];
$entidad = $_POST["entidad"];
$audi = $_POST["auditoria_1"];
$audi2 = $_POST["auditoria_2"];
$obs = $_POST["observacion"];



$query8 = ("SELECT count(*) from auditor where documento='$documento' AND CODIGO_CENTRO = 0");
$statement8 = oci_parse($connection, $query8);
$resp8 = oci_execute($statement8);
$t = oci_fetch_array($statement8, OCI_BOTH);

if ($t[0] > 0) {
    echo("<SCRIPT>window.alert(\"Auditor Ya Registrado, Verifique Datos\")</SCRIPT>");
    ?>
    <script type="text/javascript">
        window.location = "../Presentacion/registrar_auditores_regionales.php";
    </script>
    <?php
} else {

//actualizo el estado del instrumento
    $strSQL1 = "INSERT INTO AUDITOR
        (CODIGO_REGIONAL,
        CODIGO_CENTRO,
        T_DOCUMENTO,
        DOCUMENTO,
        NOMBRE,
        IP,
        CELULAR,
        EMAIL,
        EMAIL2,
        AUDITOR_SENA,
        N_CERTI,
        FECHA_CERTIFICA,
        ACTIVO,
        CERT_ISO,
        FECHA_CERTIFICAC,
        ENTIDAD,
        AUDITORIA_1,
        AUDITORIA_2,
        OBS,
        USU_REGISTRO
        )
        VALUES 
        ('$regional','$centro','$tdoc','$documento','$nombres','$ip','$celular','$email','$email2','$certiaudi','$numcerti','$fechacert','$activo',"
    . "'$iso','$fechacerti','$entidad','$audi','$audi2','$obs','$id') ";


    $objParse1 = oci_parse($connection, $strSQL1);
    $objExecute1 = oci_execute($objParse1, OCI_DEFAULT);
    if ($objExecute1) {
        oci_commit($connection); //*** Commit Transaction ***//
    } else {
        oci_rollback($connection); //*** RollBack Transaction ***//
        $e = oci_error($objParse1);
        echo "Error Save [" . $e['message'] . "]";
    }
    oci_close($connection);
}

echo("<SCRIPT>window.alert(\"Registro Exitoso\")</SCRIPT>");
?>
<script type="text/javascript">
    window.location="../Presentacion/auditores_regionales.php";
</script>