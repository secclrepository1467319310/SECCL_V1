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

$idca = $_GET["idca"];
$norma = $_GET["norma"];
$grupo = $_GET["grupo"];
$proyecto = $_GET["proyecto"];
$check = $_POST["check_lider"];
$obs_lider = $_POST["obs_lider"];


//---
$strSQL1 = "select CHEK_LIDER from inscripcion where id_proyecto=$proyecto and id_norma=$norma and id_candidato=$idca and grupo=$grupo";
$statement1 = oci_parse($connection, $strSQL1);
$resp1 = oci_execute($statement1);
$totalc = oci_fetch_array($statement1, OCI_BOTH);

if ($check == NULL && $totalc['CHEK_LIDER'] == 0) {
    $check = 0;
} else if ($check == NULL && $totalc['CHEK_LIDER'] == 1) {
    $check = 1;
}



//Insert historico
$strSQL2 = "update inscripcion set chek_lider='$check'"
        . " where id_proyecto='$proyecto' and id_norma='$norma' and id_candidato='$idca' and grupo='$grupo'";

$objParse2 = oci_parse($connection, $strSQL2);
$objExecute2 = oci_execute($objParse2, OCI_DEFAULT);
if ($objExecute2) {
    oci_commit($connection); //*** Commit Transaction ***//
} else {
    oci_rollback($connection); //*** RollBack Transaction ***//
    $e = oci_error($objParse2);
    echo "Error Save [" . $e['message'] . "]";
}



$strSQL14 = "select count(obs_lider) from observaciones_inscripcion where id_proyecto=$proyecto and id_norma=$norma and id_candidato=$idca and grupo=$grupo";
$statement14 = oci_parse($connection, $strSQL14);
$resp14 = oci_execute($statement14);
$total = oci_fetch_array($statement14, OCI_BOTH);

if ($total[0] == 0) {
    //Insert historico
    $strSQL22 = "INSERT INTO OBSERVACIONES_INSCRIPCION"
            . " (ID_PROYECTO,ID_CANDIDATO,ID_NORMA,GRUPO,OBS_LIDER) "
            . "VALUES ('$proyecto','$idca','$norma','$grupo','$obs_lider')";

    $objParse22 = oci_parse($connection, $strSQL22);
    $objExecute22 = oci_execute($objParse22, OCI_DEFAULT);
    if ($objExecute22) {
        oci_commit($connection); //*** Commit Transaction ***//
    } else {
        oci_rollback($connection); //*** RollBack Transaction ***//
        $e = oci_error($objParse22);
        echo "Error Save [" . $e['message'] . "]";
    }
} else {
//Insert historico

    $strSQL23 = "UPDATE OBSERVACIONES_INSCRIPCION 
        SET 
        OBS_LIDER='$obs_lider'
        where id_proyecto='$proyecto' and id_norma='$norma' and id_candidato='$idca' and grupo='$grupo'";

    $objParse23 = oci_parse($connection, $strSQL23);
    $objExecute23 = oci_execute($objParse23, OCI_DEFAULT);
    if ($objExecute23) {
        oci_commit($connection); //*** Commit Transaction ***//
    } else {
        oci_rollback($connection); //*** RollBack Transaction ***//
        $e = oci_error($objParse23);
        echo "Error Save [" . $e['message'] . "]";
    }
}

oci_close($connection);
?>

<script type="text/javascript">
    window.location = "../Presentacion/verificar_inscripcion_l.php?proyecto=<?php echo $proyecto ?>&idca=<?php echo $idca ?>&norma=<?php echo $norma ?>&grupo=<?php echo $grupo ?>";
</script>
