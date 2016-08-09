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
$plan=$_GET['plan'];
$iddeta=$_GET['iddeta'];

$vali = $_POST["validado"];
$concepto = $_POST["concepto"];
$fecha=date("d/m/Y");

//Actualizar concepto en caliente


    $strSQL4 = "UPDATE DETALLES_POA 
        SET 
        VALIDACION='$vali',
        CONCEPTO_ASESOR='$concepto',
        FECHA_CONCEPTO='$fecha',
        ID_ASESOR='$id'
        WHERE ID_dETA='$iddeta'";
    
   
$objParse4 = oci_parse($objConnect, $strSQL4);
$objExecute4=oci_execute($objParse4, OCI_DEFAULT);


if($objExecute4)
{
	oci_commit($objConnect); //*** Commit Transaction ***//
	
}
else
{
	oci_rollback($objConnect); //*** RollBack Transaction ***//
	$e = oci_error($objParse4); 
	
}
//Guardar Trazabilidad
$strSQL5 = "INSERT INTO TRAZABILIDAD_CONCEPTO_ASESOR (ID_DETA,VALIDACION,CONCEPTO_ASESOR,ID_ASESOR) VALUES ('$iddeta','$vali','$concepto','$id')";
    
   
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




echo("<SCRIPT>window.alert(\"Concepto Actualizado\")</SCRIPT>");

oci_close($objConnect);
?>
<script type="text/javascript">
    window.location = "../Presentacion/verdetalles_poa_c.php?plan=<?php echo $plan ?>";
</script>
