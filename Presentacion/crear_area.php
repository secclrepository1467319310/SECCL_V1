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

//obt datos
$centro=$_GET['centro'];


$strSQL5 = "INSERT INTO AREAS_CLAVES (CODIGO_CENTRO,ID_USUARIO_REGISTRO) VALUES ('$centro','$id')";
    
   
$objParse5 = oci_parse($objConnect, $strSQL5);
$objExecute5=oci_execute($objParse5, OCI_DEFAULT);


if($objExecute5)
{
	oci_commit($objConnect); //*** Commit Transaction ***//
	
}
else
{
	oci_rollback($objConnect); //*** RollBack Transaction ***//
	$e = oci_error($objParse5); 
	
}


oci_close($objConnect);
?>
<script type="text/javascript">
    window.location = "../Presentacion/asociar_areas_cm.php?centro=<?php echo $centro ?>";
</script>
