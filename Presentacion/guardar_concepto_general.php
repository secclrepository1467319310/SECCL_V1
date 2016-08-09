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


$num_certif_meta = $_POST["num_certif_meta"];
$num_personas_certificadas = $_POST["num_personas_certificadas"];
$pres_contratacion = $_POST["pres_contratacion"];
$pres_gastos = $_POST["pres_gastos"];
$pres_fal_contratacion = $_POST["pres_fal_contratacion"];
$pres_fal_gastos = $_POST["pres_fal_gastos"];
$concepto = $_POST["concepto"];
$fecha=date("d/m/Y");

//Actualizar contacto


    $strSQL4 = "UPDATE PLAN_ANUAL 
        SET 
        CONCEPTO_ASESOR='$concepto',
        FECHA_CONCEPTO='$fecha',
        ID_ASESOR='$id',
        NUM_CERTIF_META='$num_certif_meta',
        NUM_PERSONAS_CERTIFICADAS='$num_personas_certificadas',
        PRES_CONTRATACION='$pres_contratacion',
        PRES_GASTOS='$pres_gastos',
        PRES_FAL_CONTRATACION='$pres_fal_contratacion',
        PRES_FAL_GASTOS='$pres_fal_gastos'
        WHERE ID_PLAN='$plan'";
    
   
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


echo("<SCRIPT>window.alert(\"Concepto Actualizado\")</SCRIPT>");

oci_close($objConnect);
?>
<script type="text/javascript">
    window.location = "../Presentacion/verdetalles_poa_c.php?plan=<?php echo $plan ?>";
</script>
