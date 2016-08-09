<?php

include("../Clase/conectar.php");
$connection = conectar($bd_host, $bd_usuario, $bd_pwd);
extract($_POST);
echo $strSQL = "INSERT INTO T_INSCRIPCION_OFERTA
        (
        ID_OFERTA,
        ID_OCUPACIONAL,
        NUMERO_DOCUMENTO,
        NOMBRES,
        PRIMER_APELLIDO,
        SEGUNDO_APELLIDO,
        CARGO,
        EMAIL,
        CELULAR,
        CENTRO
        )
        VALUES ('$id_oferta','$nivel_ocupacional','$nro_cedula','$nombre','$primer_apellido','$segundo_apellido','$cargo','$correo','$celular','$centros') ";

$objParse = oci_parse($connection, $strSQL);
$objExecute = oci_execute($objParse, OCI_DEFAULT);
if ($objExecute) {
    oci_commit($connection); //*** Commit Transaction ***//
    header('location: fin_oferta.php');
} else {
    oci_rollback($connection); //*** RollBack Transaction ***//
    $e = oci_error($objParse);
    echo "Error Save [" . $e['message'] . "]";
}
oci_close($connection);
?>
