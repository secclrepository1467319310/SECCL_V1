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

$al_num_certif = $_POST['al_num_certif'];
//$al_num_personas = $_POST['al_num_personas'];
$ds_num_certif = $_POST['ds_num_certif'];
//$ds_num_personas = $_POST['ds_num_personas'];
$fun_num_certif = $_POST['fun_num_certif'];
//$fun_num_personas = $_POST['fun_num_personas'];
$ev_req = $_POST['ev_num_requerido'];
$horas = $_POST['ev_horas_totales'];
$prec = $_POST['pres_rec_humanos'];
$pmat = $_POST['pres_materiales'];
$pviat = $_POST['pres_viaticos'];
$obs = $_POST['obs'];

$plan = $_GET["plan"];
$iddeta = $_GET["iddeta"];
$det_pro_productivos=$_POST["det_pro_productivos"];


$strSQL = "UPDATE DETALLES_POA SET AL_NUM_CERTIF='$al_num_certif',"
        . /*"AL_NUM_PERSONAS='$al_num_personas',"
        .*/ "DS_NUM_CERTIF='$ds_num_certif',"
        . /*"DS_NUM_PERSONAS='$ds_num_personas',"
        .*/ "FUN_NUM_CERTIF='$fun_num_certif',"
        . /*"FUN_NUM_PERSONAS='$fun_num_personas',"
        .*/ "EV_NUM_REQUERIDO='$ev_req',EV_HORAS_TOTALES='$horas',PRES_REC_HUMANOS='$prec',"
        . "PRES_MATERIALES='$pmat',PRES_VIATICOS='$pviat',OBSERVACIONES='$obs',DET_PRO_PRODUCTIVO='$det_pro_productivos' WHERE ID_DETA='$iddeta'";
    
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

?>

<script type="text/javascript">
    window.location = "../Presentacion/verdetalles_poa.php?plan=<?php echo $plan ?>";
</script>
