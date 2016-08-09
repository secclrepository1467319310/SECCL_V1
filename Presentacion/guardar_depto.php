<?php
include("../Clase/conectar.php");
$objConnect = conectar($bd_host, $bd_usuario, $bd_pwd);

$proyecto = $_GET["proyecto"];
$depto = $_POST['departamento'];
$municipio = $_POST['municipio'];
$candidato = $_POST['id'];

$strSQL3 = "UPDATE USUARIO 
        SET 
         DEPTO_RESIDENCIA='$depto',
        MUNICIPIO_RESIDENCIA='$municipio'
        WHERE USUARIO_ID='$candidato' ";
    
   
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
    window.location = "../Presentacion/candidatos_proyecto_n.php?proyecto=<?php echo $proyecto?>";
</script>