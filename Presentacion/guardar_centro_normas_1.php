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

//Insert historico
$nNormas = count($codigo_norma);

for ($i = 0; $i < $nNormas; $i++) {
    $queryExiste = "SELECT COUNT(*) AS NUM FROM T_CENTRO_NORMAS "
            . "WHERE AREA_CENTRO='$id_area_centro' AND CODIGO_NORMA = $codigo_norma[$i]";
    $statementExiste = oci_parse($connection, $queryExiste);
    oci_execute($statementExiste);
    $existe = oci_fetch_array($statementExiste, OCI_BOTH);

    $condicion .= "CODIGO_NORMA != $codigo_norma[$i] AND ";
    
    if ($existe['NUM'] < 1) {
        $values = " INTO T_CENTRO_NORMAS (AREA_CENTRO,CODIGO_NORMA,USU_REGISTRO,PERIODO) VALUES ('$id_area_centro','$codigo_norma[$i]',$id,$periodo)";
        $valuesCentro = $valuesCentro . $values;
    }
}
$condicion = substr($condicion, 0, -5);

$queryDelete = "DELETE FROM T_CENTRO_NORMAS WHERE AREA_CENTRO=$id_area_centro AND PERIODO = $periodo AND ($condicion)";
$objParse = oci_parse($connection, $queryDelete);
$objExecute = oci_execute($objParse, OCI_DEFAULT);
if ($objExecute) {
    oci_commit($connection); //*** Commit Transaction ***//
} else {
    oci_rollback($connection); //*** RollBack Transaction ***//
    $e = oci_error($objParse);
}


if ($valuesCentro && $valuesCentro != "") {
    $queryCentro = 'INSERT ALL ' . $valuesCentro . ' SELECT * FROM DUAL';
    $objParse = oci_parse($connection, $queryCentro);
    $objExecute = oci_execute($objParse, OCI_DEFAULT);
    if ($objExecute) {
        oci_commit($connection); //*** Commit Transaction ***//
    } else {
        oci_rollback($connection); //*** RollBack Transaction ***//
        $e = oci_error($objParse);
    }
}
header("location:asociar_normas_centro_a.php?id_area_centro=$id_area_centro&mensaje=1");
oci_close($connection);


