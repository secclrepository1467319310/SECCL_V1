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

//obt datos
$centro = $_POST['centro'];
$numActa = $_POST['numActa'];
$nCentro = count($centro);

for ($i = 0; $i < $nCentro; $i++) {
    $queryArea = ("SELECT COUNT(*) FROM AREAS_CLAVES WHERE CODIGO_CENTRO='$centro[$i]'");
    $statementArea = oci_parse($objConnect, $queryArea);
    $respArea = oci_execute($statementArea);
    $numArea = oci_fetch_array($statementArea, OCI_BOTH);
    if ($numArea['COUNT(*)'] < 1) {
        $values = " INTO AREAS_CLAVES (CODIGO_CENTRO,ID_USUARIO_REGISTRO) VALUES ('$centro[$i]','$id')";
    }
    $valuesAreas = $valuesAreas . $values;
    $centros = $centros . $centro[$i] . ',';
}

$centros = substr($centros, 0, -1);
if ($valuesAreas != " ") {
    $strSQL5 = "INSERT ALL " . $valuesAreas . ' SELECT * FROM DUAL';
    $objParse5 = oci_parse($objConnect, $strSQL5);
    $objExecute5 = oci_execute($objParse5, OCI_DEFAULT);


    if ($objExecute5) {
        oci_commit($objConnect); //*** Commit Transaction ***//
    } else {
        oci_rollback($objConnect); //*** RollBack Transaction ***//
        $e = oci_error($objParse5);
    }
}


oci_close($objConnect);
header("location:../Presentacion/acta_asociar_areas_cm.php?numActa=$numActa&centro=$centros");
?>
