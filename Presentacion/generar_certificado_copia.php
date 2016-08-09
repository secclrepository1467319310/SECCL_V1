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

$idca = $_POST['idca'];
$norma = $_POST['norma'];
$proyecto = $_POST['proyecto'];
$plan = $_POST['plan'];
$nivel = $_POST['nivel'];


$queryEvidencias = ("SELECT estado FROM evidencias_candidato WHERE id_plan='$plan' and id_norma='$norma' and id_candidato='$idca'");
$statementEvidencias = oci_parse($connection, $queryEvidencias);
$respEvidencias = oci_execute($statementEvidencias);
$estado = oci_fetch_array($statementEvidencias, OCI_BOTH);

//----

$queryCertificacion = ("SELECT count(*) FROM certificacion WHERE id_candidato='$idca' and id_norma='$norma'");
$statementCertificacion = oci_parse($connection, $queryCertificacion);
$respCertificado = oci_execute($statementCertificacion);
$certificado = oci_fetch_array($statementCertificacion, OCI_BOTH);

if (($estado['ESTADO']==1 || $estado['ESTADO']==3 || $estado['ESTADO']==4) && $certificado['COUNT(*)']==0) {
//actualizo el estado del instrumento
    $strSQL1 = "INSERT INTO CERTIFICACION
        (
        ID_CANDIDATO,
        ID_NORMA,
        ID_PROYECTO,
        NIVEL)
        VALUES 
        ('$idca','$norma','$proyecto','$nivel') ";


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


echo("<SCRIPT>window.alert(\"Certificado Generado\")</SCRIPT>");
?>
<script type="text/javascript">
    window.location = "../Presentacion/listar_certificacion.php?idplan=<?php echo $plan ?>";
</script>