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
$norma=$_GET["norma"];
$grupo=$_GET["grupo"];
$idr=$_GET["id"];

        $strSQL = "update cronograma_grupo set estado='0' where id_cronograma_grupo='$idr'";
    //$strSQL = "delete from cronograma_grupo where id_cronograma_grupo='$idr'";
    
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
    window.location = "../Presentacion/cronograma_grupo.php?grupo=<?php echo $grupo ?>&norma=<?php echo $norma ?>&proyecto=<?php echo $proyecto?>";
</script>
