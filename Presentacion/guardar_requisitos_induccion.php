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
$objConnect = conectar($bd_host, $bd_usuario, $bd_pwd);


$perinv = $_POST["idc"];
$proyecto = $_POST["proyecto"];
$total = count($perinv);

for ($i = 0; $i < $total; $i++) {
    
    $strSQL = "update induccion_candidato set estado=1,id_usu_registro=$id where id_induccion_candidato='$perinv[$i]'";
    
    
        
$objParse = oci_parse($objConnect, $strSQL);
$objExecute=oci_execute($objParse, OCI_DEFAULT);


if($objExecute)
{
	oci_commit($objConnect); //*** Commit Transaction ***//
	
}
else
{
	oci_rollback($objConnect); //*** RollBack Transaction ***//
	$e = oci_error($objParse); 
	
}
}

oci_close($objConnect);
?>
<script type="text/javascript">
    window.location = "../Presentacion/gen_induccion.php?proyecto=<?php echo $proyecto?>";
</script>