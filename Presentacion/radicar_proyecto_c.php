<?php
include("../Clase/conectar.php");
$objConnect = conectar($bd_host, $bd_usuario, $bd_pwd);

$proyecto=$_GET['proyecto'];
$observaciones=$_POST["compromisos"];

ECHO $proyecto;
ECHO "--";
ECHO $observaciones;
//ultimo insert


    $strSQL3 = "UPDATE PROYECTO 
        SET 
        COMPROMISOS='$observaciones',
        ID_ESTADO_PROYECTO='3'
        WHERE ID_PROYECTO='$proyecto'";
    
   
$objParse3 = oci_parse($objConnect, $strSQL3);
$objExecute3=oci_execute($objParse3, OCI_DEFAULT);


if($objExecute3)
{
	oci_commit($objConnect); //*** Commit Transaction ***//
	
}
else
{
	oci_rollback($objConnect); //*** RollBack Transaction ***//
	$e = oci_error($objParse3); 
	
}


oci_close($objConnect);
?>
<script type="text/javascript">
    window.location = "../Presentacion/verproyectos_c.php";
</script>