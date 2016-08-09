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

$proyecto = $_POST['proyecto'];
$idnorma = $_GET["norma"];
$grupo = $_POST['grupo'];
$act = $_POST['actividad'];

$finicial = $_POST['fi'];
$finicial2 = str_replace('/','-',$finicial);
$finicial2 = strtotime($finicial2);

$ffinal = $_POST['fef'];
$ffinal2 = str_replace('/','-',$ffinal);
$ffinal2 = strtotime($ffinal2);

$resp = $_POST['responsable'];
$obs = $_POST['obs'];

$queryCroProy = ("select * from cronograma_proyecto where id_proyecto=  '$proyecto' AND id_actividad = 19");
$statementCroProy = oci_parse($connection, $queryCroProy);
oci_execute($statementCroProy);
$croProy = oci_fetch_array($statementCroProy, OCI_BOTH);

$fecha_inicio_proyecto = $croProy['FECHA_INICIO'];
$array_fecha_inicio = explode('/', $fecha_inicio_proyecto);
$fecha_inicio_proyecto = $array_fecha_inicio[0]."-".$array_fecha_inicio[1]."-20".$array_fecha_inicio[2];
$fecha_inicio_proyecto = strtotime($fecha_inicio_proyecto);

$fecha_fin_proyecto = $croProy['FECHA_FIN'];
$array_fecha_fin = explode('/', $fecha_fin_proyecto);
$fecha_fin_proyecto = $array_fecha_fin[0]."-".$array_fecha_fin[1]."-20".$array_fecha_fin[2];
$fecha_fin_proyecto = strtotime($fecha_fin_proyecto);

if ($finicial2 < $fecha_inicio_proyecto || $finicial2 > $fecha_fin_proyecto) {
    $mensaje = 1;
} elseif ($ffinal2 < $fecha_inicio_proyecto || $ffinal2 > $fecha_fin_proyecto) {
    $mensaje = 2;
} else {
    $mensaje = 3;
    $strSQL = "INSERT INTO CRONOGRAMA_GRUPO
        (
        ID_PROYECTO,
        ID_NORMA,
        N_GRUPO,
        ID_ACTIVIDAD,
        FECHA_INICIO,
        FECHA_FIN,
        RESPONSABLE,
        OBSERVACIONES,
        estado
        )
        VALUES (
        
        '$proyecto','$idnorma','$grupo','$act','$finicial','$ffinal','$resp','$obs','1') ";

    $objParse = oci_parse($connection, $strSQL);
    $objExecute = oci_execute($objParse, OCI_DEFAULT);
    if ($objExecute) {
        oci_commit($connection); //*** Commit Transaction ***//
    } else {
        oci_rollback($connection); //*** RollBack Transaction ***//
        $e = oci_error($objParse);
        echo "Error Save [" . $e['message'] . "]";
    }
}
oci_close($connection);
?>

<script type="text/javascript">
    window.location = "../Presentacion/cronograma_grupo.php?grupo=<?php echo $grupo ?>&norma=<?php echo $idnorma ?>&proyecto=<?php echo $proyecto ?>&mensaje=<?php echo $mensaje ?>";
</script>