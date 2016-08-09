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

$prov = $_GET["prov"];
//$compromisos = $_POST['compromisos'];
$tp = $_POST['al'];
$tp1 = $_POST['al1'];
$tp2 = $_POST['al2'];
$tp3 = $_POST['al3'];
$tp4 = $_POST['al4'];

$query = ("SELECT nit_empresa from detalles_poa where id_provisional =  '$prov'");
$statement = oci_parse($connection, $query);
$resp = oci_execute($statement);
$nit = oci_fetch_array($statement, OCI_BOTH);
$query2 = ("SELECT id_plan from detalles_poa where id_provisional =  '$prov'");
$statement2 = oci_parse($connection, $query2);
$resp2 = oci_execute($statement2);
$id_poa = oci_fetch_array($statement2, OCI_BOTH);
$query3 = ("SELECT id_regional from plan_anual where id_plan =  '$id_poa[0]'");
$statement3 = oci_parse($connection, $query3);
$resp3 = oci_execute($statement3);
$reg = oci_fetch_array($statement3, OCI_BOTH);
$query4 = ("SELECT id_centro from plan_anual where id_plan =  '$id_poa[0]'");
$statement4 = oci_parse($connection, $query4);
$resp4 = oci_execute($statement4);
$cen = oci_fetch_array($statement4, OCI_BOTH);

$estado='1';

$strSQL = "INSERT INTO PROYECTO
        (
        ID_REGIONAL,
        ID_CENTRO,
        ID_PLAN,
        TIPO_PROYECTO,
        NIT_EMPRESA,
        ID_ESTADO_PROYECTO,
        USU_REGISTRO,
        ID_PROVISIONAL,
        LINEA,
        TP1,
        TP2,
        TP3,
        TP4
        )
        VALUES (
        
        '$reg[0]','$cen[0]','$id_poa[0]','$tp','$nit[0]','$estado','$id','$prov','$tp','$tp1','$tp2','$tp3','$tp4') ";

$objParse = oci_parse($connection, $strSQL);
$objExecute = oci_execute($objParse, OCI_DEFAULT);
if ($objExecute) {
    oci_commit($connection); //*** Commit Transaction ***//
} else {
    oci_rollback($connection); //*** RollBack Transaction ***//
    $e = oci_error($objParse);
    echo "Error Save [" . $e['message'] . "]";
}


oci_close($connection);
?>

<script type="text/javascript">
    window.location = "../Presentacion/verproyectos_c.php";
</script>
