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


$eva = $_POST["ideva"];
$perinv = $_POST["codigo"];

$total = count($perinv);
for ($i = 0; $i < $total; $i++) {

    $strSQL = "INSERT INTO EVALUADOR_MESA (ID_EVALUADOR,ID_MESA,ID_USU_REGISTRO)
        VALUES ('$eva','$perinv[$i]','$id')";
    
    
        
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
    window.location = "../Presentacion/asociar_norma_evaluador.php?ideva=<?php echo $eva ?>";
</script>