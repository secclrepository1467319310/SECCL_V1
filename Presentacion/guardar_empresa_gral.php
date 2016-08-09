<?php
include("../Clase/conectar.php");
                
$connection = conectar($bd_host, $bd_usuario, $bd_pwd);
$nit = $_POST['nit'];
$nombre = strtoupper($_POST['nombre']);
$sigla = strtoupper($_POST['sigla']);

$query8 = ("SELECT count(*) from empresas_sistema where nit_empresa='$nit'");
$statement8 = oci_parse($connection, $query8);
$resp8 = oci_execute($statement8);
$t = oci_fetch_array($statement8, OCI_BOTH);

if ($t[0]>0) {
echo("<SCRIPT>window.alert(\"Empresa Ya Registrada\")</SCRIPT>");

?>
<script type="text/javascript">
        window.location = "../Presentacion/reg_empresa_gral.php?nit=<?php echo $nit?>";
</script>
<?php
}else 
{ 
    
    $strSQL = "INSERT INTO EMPRESAS_SISTEMA
        (
        NIT_EMPRESA,
        NOMBRE_EMPRESA,
        SIGLA_EMPRESA
        )
        VALUES (
        
        '$nit','$nombre','$sigla') ";
    
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
}
    ?>

<script type="text/javascript">
    window.location = "../index.php?empresa=<?php echo $nombre ?>&nit=<?php echo $nit ?>";
</script>