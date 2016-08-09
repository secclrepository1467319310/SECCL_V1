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
$cen=$_POST['centro'];
$norma=$_POST['municipio'];
$finicial=$_POST['fi'];
$ffinal=$_POST['ff'];
$resp=$_POST['constructor'];
$nitems=$_POST['nitems'];
$obs=$_POST['obs'];

        
    $strSQL = "INSERT INTO CRONOGRAMA_ITEMS
        (
        ID_PROYECTO,
        ID_CENTRO,
        ID_NORMA,
        ID_CONSTRUCTOR,
        NUM_ITEMS,
        F_INICIAL,
        F_FINAL,
        OBS
        )
        VALUES (
        
        '$proyecto','$cen','$norma','$resp','$nitems','$finicial','$ffinal','$obs') ";
    
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
    window.location = "../Presentacion/cronogramai_proyecto_c.php?proyecto=<?php echo $proyecto?>";
</script>