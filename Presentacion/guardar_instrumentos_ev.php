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


$plan = $_GET['plan'];
$instrumentos = $_POST["instrumentos"];
$novedad = $_POST["novedad"];
$fnovedad = $_POST["fi"];


    $strSQL = "INSERT INTO PLAN_INSTRUMENTOS (ID_PLAN,INSTRUMENTOS,FECHA_NOVEDAD,NOVEDAD,USU_REGISTRO)
        VALUES ('$plan','$instrumentos','$fnovedad','$novedad','$id')";
    
    
        
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

oci_close($objConnect);
?>
<script type="text/javascript">
    window.location = "../Presentacion/consultar_plan_ev.php?idplan=<?php echo $plan ?>";
</script>