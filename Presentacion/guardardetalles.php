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


//$provisional = $_GET["provisional"];
//$plan=$_GET["plan"];
$linea=$_GET["tp"];
$provi=$_GET["prov"];
//$nit_gremio=$_POST["nit_gremio"];
$deta=$_POST["deta"];
$norma=$_POST["norma"];
$idn=$_POST["idn"];
$requiere=$_POST["elab"];
$num_cert_alianza=$_POST["cert_alianza"];
//$total_per_alianza=$_POST["per_total_alianza"];
$certif_demsoc=$_POST["cert_demsoc"];
//$total_per_demsoc=$_POST["per_total_demsoc"];
$num_cert_func=$_POST["cert_func"];
//$total_pers_func=$_POST["per_total_func"];
$num_ev_req=$_POST["num_ev_req"];
$hor_totales_ev=$_POST["hor_ev_total"];
$pres_rec_hum=$_POST["pres_rec_hum"];
$pres_mat=$_POST["pres_mat"];
$viatic=$_POST["pres_viat"];
$observaciones=$_POST["obs"];
$det_pro_productivos=$_POST["det_pro_productivos"];

//ultimo insert

$total2 = count($idn);
for ($i = 0; $i < $total2; $i++) {
    $strSQL3 = "UPDATE DETALLES_POA 
        SET 
        ELAB_INST='$requiere[$i]',
        AL_NUM_CERTIF='$num_cert_alianza[$i]',
        DS_NUM_CERTIF='$certif_demsoc[$i]',
        FUN_NUM_CERTIF='$num_cert_func[$i]',
        EV_NUM_REQUERIDO='$num_ev_req[$i]',
        EV_HORAS_TOTALES='$hor_totales_ev[$i]',
        PRES_REC_HUMANOS='$pres_rec_hum[$i]',
        PRES_MATERIALES='$pres_mat[$i]',
        PRES_VIATICOS='$viatic[$i]',
        OBSERVACIONES='$observaciones[$i]',
        DET_PRO_PRODUCTIVO='$det_pro_productivos[$i]'
        WHERE ID_NORMA='$idn[$i]' AND ID_DETA='$deta[$i]' AND ID_PROVISIONAL='$provi'";
    
   
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

}
oci_close($objConnect);
?>
<script type="text/javascript">
    window.location = "../Presentacion/ver_poa.php";
</script>