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

$tn=$_POST['tipo_novedad'];
$obs=$_POST['obs'];

    $strSQL = "INSERT INTO NOVEDAD
        (
        ID_T_NOVEDAD,
        DESCRIPCION,
        ID_USUARIO
        )
        VALUES (
        '$tn','$obs','$id') ";
    
$objParse = oci_parse($connection, $strSQL);
$objExecute = oci_execute($objParse, OCI_DEFAULT);
if($objExecute)
{
	oci_commit($connection); //*** Commit Transaction ***//
	
}
else
{
	oci_rollback($connection); //*** RollBack Transaction ***//
	$e = oci_error($objParse); 
	echo "Error Save [".$e['message']."]";
}

oci_close($connection);

    ?>

<script type="text/javascript">
    window.location = "../Presentacion/consultarnovedad_c.php";
</script>
