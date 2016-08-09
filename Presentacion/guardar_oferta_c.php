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

$bimestre = $_POST["bimestre"];
$fi = $_POST["fi"];
$ff = $_POST["ff"];
$oferta = $_POST["toferta"];
$pub = $_POST["fpublicacion"];



$query5 = ("SELECT id_centro FROM centro_usuario where id_usuario =  '$id'");
            $statement5 = oci_parse($connection, $query5);
            $resp5 = oci_execute($statement5);
            $idc = oci_fetch_array($statement5, OCI_BOTH);
           
    $strSQL = "INSERT INTO OFERTA
        (
        ID_CENTRO,
        FECHA_INICIO,
        FECHA_FIN,
        ESTADO_OFERTA,
        BIMESTRE,
        TIPO_OFERTA,
        FECHA_PUBLICACION,
        USU_REGISTRO
        )
        VALUES (
        
        '$idc[0]','$fi','$ff','2','$bimestre','$oferta','$pub','$id') ";
    
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
    window.location = "../Presentacion/oferta_c.php";
</script>
