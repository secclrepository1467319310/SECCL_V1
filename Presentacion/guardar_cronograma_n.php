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
$act=$_POST['actividad'];
$finicial=$_POST['fi'];
$ffinal=$_POST['ff'];
$resp=$_POST['responsable'];
$obs=$_POST['obs'];

        
    $strSQL = "INSERT INTO CRONOGRAMA_PROYECTO
        (
        ID_PROYECTO,
        ID_ACTIVIDAD,
        FECHA_INICIO,
        FECHA_FIN,
        RESPONSABLE,
        OBSERVACIONES
        )
        VALUES (
        
        '$proyecto','$act','$finicial','$ffinal','$resp','$obs') ";
    
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
    window.location = "../Presentacion/cronograma_proyecto_n.php?proyecto=<?php echo $proyecto?>";
</script>