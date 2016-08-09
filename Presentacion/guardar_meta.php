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

$query = ("SELECT COUNT(*) FROM T_METAS_CENTROS WHERE CODIGO_CENTRO = $centro");
$statement = oci_parse($objConnect, $query);
$resp = oci_execute($statement);
$metaRow = oci_fetch_array($statement, OCI_BOTH);
$periodo = 2016;

if($metaRow['COUNT(*)'] < 1){
    $queryMeta = "INSERT INTO T_METAS_CENTROS(CODIGO_CENTRO,META,USU_REGISTRO,PERIODO)VALUES($centro, $meta, $id, '$periodo')";
}else{
    $queryMeta = "UPDATE T_METAS_CENTROS SET META = $meta WHERE CODIGO_CENTRO = $centro";
}

//echo $queryMeta;
    $objParse = oci_parse($objConnect, $queryMeta);
    $objExecute = oci_execute($objParse, OCI_DEFAULT);

    if ($objExecute) {
        oci_commit($objConnect); //*** Commit Transaction ***//
        header("location:../Presentacion/meta_centro.php");
    } else {
        oci_rollback($objConnect); //*** RollBack Transaction ***//
        $e = oci_error($objParse);
    }
    oci_close($objConnect);


    