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
$total = count($codigo);
$periodo = date('Y');
for ($i = 0; $i < $total; $i++) {
    $areaMesa = explode("-", $codigo[$i]);

    $query = "SELECT COUNT(*) FROM AREAS_CLAVES_CENTRO WHERE ID_AREA_CLAVE = $areaMesa[0] AND ID_MESA = $areaMesa[1] AND PERIODO = $periodo";
//    echo $query;
    $statement = oci_parse($objConnect, $query);
    oci_execute($statement);
    $numAreas = oci_fetch_array($statement, OCI_BOTH);
    if ($numAreas['COUNT(*)'] < 1) {
        $values = " INTO AREAS_CLAVES_CENTRO (ID_AREA_CLAVE,ID_MESA,OBS_MISIONAL,USU_REGISTRO,APROBADO_ASESOR,PERIODO) VALUES ($areaMesa[0],$areaMesa[1],'Sin Comentarios',$id,'3',$periodo)";
    }
    $valuesAreas = $valuesAreas . $values;
}
$insertArea = "INSERT ALL " . $valuesAreas . ' SELECT * FROM DUAL';
//echo $insertArea;
//die();
$objParse = oci_parse($objConnect, $insertArea);
$objExecute = oci_execute($objParse, OCI_DEFAULT);

if ($objExecute) {
    oci_commit($objConnect); //*** Commit Transaction ***//
} else {
    oci_rollback($objConnect); //*** RollBack Transaction ***//
    var_dump( oci_error($objConnect));
}

for ($i = 0; $i < $total; $i++) {
    $areaMesa = explode("-", $codigo[$i]);

    $query = "SELECT ID_AREAS_CENTRO FROM AREAS_CLAVES_CENTRO WHERE ID_AREA_CLAVE = '$areaMesa[0]' AND ID_MESA = '$areaMesa[1]' AND PERIODO = 2016";
//    echo $query."<hr/>";
    $statement = oci_parse($objConnect, $query);
    oci_execute($statement);
    $areasCentro = oci_fetch_array($statement, OCI_BOTH);
    $valueActaArea = " INTO T_AREAS_CLAVES_ACTAS (ID_ACTA,ID_AREA_CENTRO) VALUES ($numActa,$areasCentro[ID_AREAS_CENTRO])";
    $valuesActasAreas = $valuesActasAreas . $valueActaArea;
}
$insertArea = "INSERT ALL " . $valuesActasAreas . ' SELECT * FROM DUAL';
//ECHO $insertArea;
$objParse = oci_parse($objConnect, $insertArea);
$objExecute = oci_execute($objParse);
//DIE();
var_dump(oci_error($objConnect));
if ($objExecute) {
    oci_commit($objConnect); //*** Commit Transaction ***//
} else {
    oci_rollback($objConnect); //*** RollBack Transaction ***//
    var_dump(oci_error($objConnect));
}
oci_close($objConnect);
//DIE();
//die("");
header("location:../Presentacion/agregar_acta.php?id_acta=$numActa");
?>
