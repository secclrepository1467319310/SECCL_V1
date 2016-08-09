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
$nit = $_POST['nit'];
$nombre = strtoupper($_POST['nombre']);
$sigla = strtoupper($_POST['sigla']);
$plan = $_GET["plan"];


$query8 = ("SELECT count(*) from empresas_sistema where nit_empresa='$nit'");
$statement8 = oci_parse($connection, $query8);
$resp8 = oci_execute($statement8);
$t = oci_fetch_array($statement8, OCI_BOTH);

if ($t[0]>0) {
echo("<SCRIPT>window.alert(\"Empresa Ya Registrada\")</SCRIPT>");

?>
<script type="text/javascript">
        window.location = "../Presentacion/asociar_ncl.php?plan=<?php echo $plan?>";
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
        window.location = "../Presentacion/asociar_ncl.php?plan=<?php echo $plan?>";
</script>
<!--<script type="text/javascript">
    window.location = "../Presentacion/correo_registro_empresa.php?sigla=<?php echo $sigla ?>&nombre=<?php echo $nombre ?>&nit=<?php echo $nit ?>&plan=<?php echo $plan?>";
</script>-->
