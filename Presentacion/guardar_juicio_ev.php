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
$connection = conectar($bd_host, $bd_usuario, $bd_pwd);


$plan = $_GET['idplan'];
$idca = $_GET['idca'];
$norma = $_GET['norma'];
$accion = $_GET['accion'];
$vic = $_POST["vic"];
$opc = $_POST["opc"];
$vid = $_POST["vid"];
$opd = $_POST["opd"];
$vip = $_POST["vip"];
$opp = $_POST["opp"];



if ($opc == NULL || $opc == "" || $vic < 60) {
    $opc = 0;
}
if ($opd == NULL || $opd == "" || $vid < 60) {
    $opd = 0;
}
if ($opp == NULL || $opp == "" || $vip < 60) {
    $opp = 0;
}

$totalEvidenciaConocimiento = $vic + $opc;
$totalEvidenciaDesempeno = $vid + $opd;
$totalEvidenciaProducto = $vip + $opp;

//----------ec
$query23 = ("select ec from evidencias_candidato where id_plan='$plan' and id_norma='$norma' and id_candidato='$idca'");
$statement23 = oci_parse($connection, $query23);
$resp23 = oci_execute($statement23);
$ec = oci_fetch_array($statement23, OCI_BOTH);
//----------ed
$query24 = ("select ed from evidencias_candidato where id_plan='$plan' and id_norma='$norma' and id_candidato='$idca'");
$statement24 = oci_parse($connection, $query24);
$resp24 = oci_execute($statement24);
$ed = oci_fetch_array($statement24, OCI_BOTH);
//----------ep
$query25 = ("select ep from evidencias_candidato where id_plan='$plan' and id_norma='$norma' and id_candidato='$idca'");
$statement25 = oci_parse($connection, $query25);
$resp25 = oci_execute($statement25);
$ep = oci_fetch_array($statement25, OCI_BOTH);
//---------
$query281 = ("select opec from evidencias_candidato where id_plan='$plan' and id_norma='$norma' and id_candidato='$idca'");
$statement281 = oci_parse($connection, $query281);
$resp281 = oci_execute($statement281);
$opec = oci_fetch_array($statement281, OCI_BOTH);
//--
$query302 = ("select oped from evidencias_candidato where id_plan='$plan' and id_norma='$norma' and id_candidato='$idca'");
$statement302 = oci_parse($connection, $query302);
$resp302 = oci_execute($statement302);
$oped = oci_fetch_array($statement302, OCI_BOTH);
//-
$query323 = ("select opep from evidencias_candidato where id_plan='$plan' and id_norma='$norma' and id_candidato='$idca'");
$statement323 = oci_parse($connection, $query323);
$resp323 = oci_execute($statement323);
$opep = oci_fetch_array($statement323, OCI_BOTH);
//---
$query3233 = ("select estado from evidencias_candidato where id_plan='$plan' and id_norma='$norma' and id_candidato='$idca'");
$statement3233 = oci_parse($connection, $query3233);
$resp3233 = oci_execute($statement3233);
$estado = oci_fetch_array($statement3233, OCI_BOTH);
//----

$queryExiste = ("select * from evidencias_candidato where id_plan='$plan' and id_norma='$norma' and id_candidato='$idca'");
$statementExiste = oci_parse($connection, $queryExiste);
$respEstado = oci_execute($statementExiste);
$numEstado = oci_fetch_all($statementExiste, $rowEstado);

$totalec = $ec[0] + $opec[0];
$totaled = $ed[0] + $oped[0];
$totalep = $ep[0] + $opep[0];

/* * *************************************************************************** */

/*
 * Comprobamos si existe evidencias de ese candidato, si no existe, creamos el registro.
 */
if ($numEstado < 1) {
    $strSQL1 = "INSERT INTO EVIDENCIAS_CANDIDATO (ID_PLAN,ID_NORMA,ID_CANDIDATO,ESTADO,USU_REGISTRO)
 VALUES ('$plan','$norma','$idca','0','$id')";

    $objParse1 = oci_parse($objConnect, $strSQL1);
    $objExecute1 = oci_execute($objParse1, OCI_DEFAULT);


    if ($objExecute1) {
        oci_commit($objConnect); //*** Commit Transaction ***//
    } else {
        oci_rollback($objConnect); //*** RollBack Transaction ***//
        $e = oci_error($objParse1);
    }
}

/*
 * Deacuerdo a la acción enviada desde el formulario manipulamos la actualización.
 */

switch ($accion) {
    case 1:
        $fieldsUpdate = "EC='$vic', OPEC='$opc'";
        break;
    case 2:
        $fieldsUpdate = "ED='$vid', OPED='$opd'";
        break;
    case 3:
        $fieldsUpdate = "EP='$vip', OPEP='$opp'";
        break;
    case 4:
        $gransuma = $totalec + $totaled + $totalep;
        
        if(($totaled == 100 && $totalep == 100) && ($totalec >=0 && $totalec <= 59)){
            $fieldsUpdate = "ESTADO=4";
        } else if(($totaled == 100 && $totalep == 100) && ($totalec >=60 && $totalec <= 99)){
            $fieldsUpdate = "ESTADO=3";
        } else if(($totaled == 100 && $totalep == 100) && ($totalec ==100)){
            $fieldsUpdate = "ESTADO=1";
        }else{
            $fieldsUpdate = "ESTADO=2";
        }
        
        
//        if ($gransuma >= 300 && $estado[0] <> 1) {
//            $fieldsUpdate = "ESTADO=1";
//        } else {
//            
//        }
        $mensaje = 1;
        break;
}

$totalEvidenciaConocimiento = $vic + $opc;
$totalEvidenciaDesempeno = $vid + $opd;
$totalEvidenciaProducto = $vip + $opp;

if($totalEvidenciaConocimiento > 100 || $totalEvidenciaDesempeno > 100 || $totalEvidenciaProducto > 100) {
    $mensaje = 3;
}else{

    $strSQL2 = "UPDATE EVIDENCIAS_CANDIDATO SET " . $fieldsUpdate . " WHERE ID_PLAN='$plan' AND ID_NORMA='$norma' AND ID_CANDIDATO='$idca'";
    $objParse2 = oci_parse($objConnect, $strSQL2);
    $objExecute2 = oci_execute($objParse2, OCI_DEFAULT);

    if ($objExecute2) {
        oci_commit($objConnect); //*** Commit Transaction ***//
    } else {
        $mensaje = 2;
        oci_rollback($objConnect); //*** RollBack Transaction ***//
        $e = oci_error($objParse2);
    }
    oci_close($objConnect);
}
    ?>
<script type="text/javascript">
    window.location = "../Presentacion/emitir_juicio_ev.php?norma=<?php echo $norma ?>&idca=<?php echo $idca ?>&idplan=<?php echo $plan ?>&mensaje=<?php echo $mensaje ?>#generalidades";
</script>