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

$proyecto=$_GET["proyecto"];
$req=$_POST['requerimiento'];
$sena=$_POST['sena_cantidad'];
$senaval=$_POST['sena_val_unit'];
$emp=$_POST['empresa_cantidad'];
$empval=$_POST['empresa_val_unit'];
$obs=$_POST['obs'];

    $strSQL = "INSERT INTO REQUERIMIENTOS_PROYECTO
        (
        ID_PROYECTO,
        ID_ACTIVIDAD,
        CANTIDAD_SENA,
        VAL_UNIT_SENA,
        CANTIDAD_EMPRESA,
        VAL_UNIT_EMPRESA,
        OBS
        )
        VALUES (
        
        '$proyecto','$req','$sena','$senaval','$emp','$empval','$obs') ";
    
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
    window.location = "../Presentacion/requerimientos_proyecto_n.php?proyecto=<?php echo $proyecto?>";
</script>
