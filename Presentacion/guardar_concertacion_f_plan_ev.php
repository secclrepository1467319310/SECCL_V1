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
$fp = $_POST["fp"];
$horap = $_POST["horap"];
$lugarp = $_POST["lugarp"];
$fc = $_POST["fc"];
$horac = $_POST["horac"];
$lugarc = $_POST["lugarc"];
$fo = $_POST["fo"];
$horao = $_POST["horao"];
$lugaro = $_POST["lugaro"];


    $strSQL = "INSERT INTO CONCERTACION_FECHAS_PLAN (ID_PLAN,P_FECHA,P_HORA,P_LUGAR,EC_FECHA,EC_HORA,EC_LUGAR,OP_FECHA,OP_HORA,OP_LUGAR,USU_REGISTRO)
        VALUES ('$plan','$fp','$horap','$lugarp','$fc','$horac','$lugarc','$fo','$horao','$lugaro','$id')";
    
    
        
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
    window.location = "../Presentacion/concertacion_f_plan_ev.php?idplan=<?php echo $plan ?>";
</script>